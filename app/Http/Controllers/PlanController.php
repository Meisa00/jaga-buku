<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\PlanAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function index(Request $request, PlanAccess $plans): View
    {
        $user = $request->user();

        return view('plans.index', [
            'packages' => config('plans.packages'),
            'featureLabels' => config('plans.feature_labels'),
            'currentPlan' => $user ? $plans->currentPlan($user) : null,
            'activeSubscription' => $user ? $plans->activeSubscription($user) : null,
            'pendingSubscription' => $user?->subscriptions()->where('status', 'pending')->latest('id')->first(),
        ]);
    }

    public function subscribe(Request $request, PlanAccess $plans): RedirectResponse
    {
        $validated = Validator::make($request->all(), [
            'plan' => ['required', 'string', 'in:'.implode(',', array_keys(config('plans.packages')))],
        ])->validate();

        $user = $request->user();
        $plan = $validated['plan'];
        $user->subscriptions()->where('status', 'pending')->update(['status' => 'cancelled']);

        if ($plan === 'free') {
            Subscription::create([
                'user_id' => $user->id,
                'plan' => 'free',
                'status' => 'pending',
            ]);
            $plans->activate($user, 'free');

            return redirect()->route('subscriptions.show')->with('status', 'Paket Free sudah aktif.');
        }

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'status' => 'pending',
            'payment_status' => 'created',
        ]);

        return redirect()->route('subscriptions.checkout', $subscription);
    }

    public function checkout(Request $request, Subscription $subscription): View|RedirectResponse
    {
        abort_unless($subscription->user_id === $request->user()->id, 404);

        if ($subscription->status === 'active') {
            return redirect()->route('subscriptions.show')->with('status', 'Paket ini sudah aktif.');
        }

        if ($subscription->status !== 'pending' || $subscription->plan === 'free') {
            return redirect()->route('subscriptions.show')->with('status', 'Transaksi ini tidak lagi menunggu pembayaran.');
        }

        $serverKey = config('services.midtrans.server_key');
        $clientKey = config('services.midtrans.client_key');

        if (! $serverKey || ! $clientKey) {
            return view('plans.checkout', [
                'subscription' => $subscription,
                'package' => config("plans.packages.{$subscription->plan}"),
                'clientKey' => null,
                'snapUrl' => null,
                'setupMissing' => true,
            ]);
        }

        if (! $subscription->snap_token) {
            $package = config("plans.packages.{$subscription->plan}");
            $orderId = 'JB-'.Str::upper(Str::random(20));
            $isProduction = (bool) config('services.midtrans.is_production');
            $apiUrl = $isProduction
                ? 'https://app.midtrans.com/snap/v1/transactions'
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

            try {
                $response = Http::acceptJson()
                    ->asJson()
                    ->withBasicAuth($serverKey, '')
                    ->timeout(20)
                    ->post($apiUrl, [
                        'transaction_details' => [
                            'order_id' => $orderId,
                            'gross_amount' => (int) $package['price'],
                        ],
                        'item_details' => [[
                            'id' => $subscription->plan,
                            'price' => (int) $package['price'],
                            'quantity' => 1,
                            'name' => 'Langganan Jaga Buku '.$package['name'].' (30 hari)',
                        ]],
                        'customer_details' => [
                            'first_name' => $request->user()->name,
                            'email' => $request->user()->email,
                        ],
                    ]);
            } catch (\Throwable $exception) {
                report($exception);

                return redirect()->route('subscriptions.show')->with('status', 'Midtrans belum dapat dihubungi. Silakan coba lagi beberapa saat.');
            }

            if (! $response->successful() || ! $response->json('token')) {
                report(new \RuntimeException('Midtrans Snap token creation failed: HTTP '.$response->status()));

                return redirect()->route('subscriptions.show')->with('status', 'Checkout Midtrans belum berhasil dibuat. Periksa konfigurasi akun Midtrans lalu coba lagi.');
            }

            $subscription->update([
                'order_id' => $orderId,
                'snap_token' => $response->json('token'),
                'payment_url' => $response->json('redirect_url'),
                'payment_status' => 'created',
            ]);
        }

        $isProduction = (bool) config('services.midtrans.is_production');

        return view('plans.checkout', [
            'subscription' => $subscription->fresh(),
            'package' => config("plans.packages.{$subscription->plan}"),
            'clientKey' => $clientKey,
            'snapUrl' => $isProduction
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js',
            'setupMissing' => false,
        ]);
    }

    public function notification(Request $request): \Illuminate\Http\Response
    {
        $payload = $request->all();
        $serverKey = config('services.midtrans.server_key');

        if (! $serverKey) {
            return response('Midtrans is not configured.', 503);
        }

        $expectedSignature = hash('sha512',
            ($payload['order_id'] ?? '').
            ($payload['status_code'] ?? '').
            ($payload['gross_amount'] ?? '').
            $serverKey
        );

        if (! isset($payload['signature_key']) || ! hash_equals($expectedSignature, $payload['signature_key'])) {
            return response('Invalid signature.', 403);
        }

        $subscription = Subscription::query()->where('order_id', $payload['order_id'] ?? '')->first();

        if (! $subscription) {
            return response('Order not found.', 404);
        }

        $package = config("plans.packages.{$subscription->plan}");
        $expectedAmount = number_format((int) ($package['price'] ?? 0), 2, '.', '');

        if (($payload['gross_amount'] ?? null) !== $expectedAmount) {
            return response('Amount mismatch.', 422);
        }

        DB::transaction(function () use ($payload, $subscription) {
            $subscription = Subscription::query()->lockForUpdate()->findOrFail($subscription->id);
            $transactionStatus = $payload['transaction_status'] ?? 'unknown';
            $fraudStatus = $payload['fraud_status'] ?? null;

            $subscription->update([
                'payment_status' => $transactionStatus,
            ]);

            $isPaid = $transactionStatus === 'settlement'
                || ($transactionStatus === 'capture' && $fraudStatus === 'accept');

            if ($isPaid && $subscription->status === 'pending') {
                Subscription::query()
                    ->where('user_id', $subscription->user_id)
                    ->where('status', 'active')
                    ->update(['status' => 'expired']);

                $subscription->update([
                    'status' => 'active',
                    'starts_at' => now(),
                    'ends_at' => now()->addDays(30),
                    'paid_at' => now(),
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'], true) && $subscription->status === 'pending') {
                $subscription->update(['status' => 'cancelled']);
            }
        });

        return response('OK', 200);
    }

    public function show(Request $request, PlanAccess $plans): View
    {
        return view('plans.subscription', [
            'packages' => config('plans.packages'),
            'currentPlan' => $plans->currentPlan($request->user()),
            'activeSubscription' => $plans->activeSubscription($request->user()),
            'pendingSubscription' => $request->user()->subscriptions()->where('status', 'pending')->latest('id')->first(),
        ]);
    }

    public function cancel(Request $request): RedirectResponse
    {
        $request->user()->subscriptions()
            ->where('status', 'pending')
            ->whereNull('order_id')
            ->update(['status' => 'cancelled']);

        return redirect()->route('subscriptions.show')->with('status', 'Permintaan langganan yang menunggu sudah dibatalkan.');
    }
}

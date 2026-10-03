<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\PlanAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function create(Request $request, PlanAccess $plans): View
    {
        $type = $request->query('type') === 'expense' ? 'expense' : 'income';

        $builtInCategories = $this->builtInCategories();
        $customCategories = $request->user()->categories()->get()->groupBy('type');
        $incomeCategories = collect($builtInCategories['income'])->concat($customCategories->get('income', collect())->pluck('name'))->all();
        $expenseCategories = collect($builtInCategories['expense'])->concat($customCategories->get('expense', collect())->pluck('name'))->all();

        return view('transactions.create', [
            'type' => $type,
            'incomeCategories' => $incomeCategories,
            'expenseCategories' => $expenseCategories,
            'editingTransaction' => null,
            'planLabel' => $this->planLabel($plans->currentPlan($request->user())),
        ]);
    }

    public function history(Request $request, PlanAccess $plans): View
    {
        $user = $request->user();
        $transactions = $user->transactions()->latest('transaction_date')->latest('id');
        $hasUnlimitedHistory = $plans->allows($user, 'unlimited_history');

        if (! $hasUnlimitedHistory) {
            $transactions->whereDate('transaction_date', '>=', now()->subDays(29)->toDateString());
        }

        return view('transactions.history', [
            'transactions' => $transactions->paginate(15),
            'hasUnlimitedHistory' => $hasUnlimitedHistory,
        ]);
    }

    public function edit(Request $request, Transaction $transaction, PlanAccess $plans): View
    {
        $this->ensureEditable($request, $transaction);
        $type = $transaction->type;

        return view('transactions.create', [
            'type' => $type,
            'incomeCategories' => $this->categoriesFor($request, 'income'),
            'expenseCategories' => $this->categoriesFor($request, 'expense'),
            'editingTransaction' => $transaction,
            'planLabel' => $this->planLabel($plans->currentPlan($request->user())),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateTransaction($request);

        $request->user()->transactions()->create($validated);

        return redirect()->route('transactions.create')->with('success', 'Transaksi berhasil disimpan.');
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->ensureEditable($request, $transaction);
        $transaction->update($this->validateTransaction($request));

        return redirect()->route('transactions.history')->with('success', 'Perubahan transaksi berhasil disimpan.');
    }

    public function destroy(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->ensureEditable($request, $transaction);
        $transaction->delete();

        return redirect()->route('transactions.history')->with('success', 'Transaksi berhasil dihapus.');
    }

    private function validateTransaction(Request $request): array
    {
        $selectedType = $request->input('type');
        $allowedCategories = $this->categoriesFor($request, $selectedType);

        return $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'integer', 'min:1', 'max:999999999999'],
            'category' => ['required', 'string', 'max:100', Rule::in($allowedCategories)],
            'note' => ['nullable', 'string', 'max:500'],
            'transaction_date' => ['required', 'date', 'before_or_equal:today'],
        ]);
    }

    private function categoriesFor(Request $request, ?string $type): array
    {
        if (! in_array($type, ['income', 'expense'], true)) {
            return [];
        }

        $customCategories = $request->user()->categories()->where('type', $type)->pluck('name')->all();

        return [...$this->builtInCategories()[$type], ...$customCategories];
    }

    private function ensureEditable(Request $request, Transaction $transaction): void
    {
        abort_unless($transaction->user_id === $request->user()->id, 404);

        if (! app(PlanAccess::class)->allows($request->user(), 'unlimited_history')) {
            abort_if($transaction->transaction_date->lt(now()->subDays(29)->startOfDay()), 404);
        }
    }

    private function planLabel(string $plan): string
    {
        return $plan === 'pro_plus' ? 'Pro Plus' : ucfirst($plan);
    }

    private function builtInCategories(): array
    {
        return [
            'income' => [
                'Penjualan produk', 'Penjualan tunai', 'Penjualan online', 'Penjualan grosir',
                'Penjualan eceran', 'Pendapatan marketplace', 'Jasa', 'Modal usaha', 'Pemasukan lain',
            ],
            'expense' => [
                'Pembelian stok barang', 'Bahan baku', 'Biaya kemasan', 'Biaya marketplace',
                'Promosi dan iklan', 'Sewa tempat', 'Listrik dan air', 'Ongkos kirim', 'Operasional',
                'Gaji', 'Transportasi', 'Pajak dan retribusi', 'Pengeluaran lain',
            ],
        ];
    }
}

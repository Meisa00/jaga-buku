<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Carbon;

class PlanAccess
{
    public function activeSubscription(User $user): ?Subscription
    {
        return $user->subscriptions()
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
            })
            ->latest('starts_at')
            ->latest('id')
            ->first();
    }

    public function currentPlan(User $user): string
    {
        return $this->activeSubscription($user)?->plan ?? 'free';
    }

    public function allows(User $user, string $feature): bool
    {
        $plan = $this->currentPlan($user);

        return (bool) config("plans.packages.{$plan}.features.{$feature}", false);
    }

    public function activate(User $user, string $plan, ?int $days = null): Subscription
    {
        $subscription = Subscription::query()
            ->where('user_id', $user->id)
            ->where('plan', $plan)
            ->where('status', 'pending')
            ->latest('id')
            ->firstOrFail();

        $user->subscriptions()->where('status', 'active')->update(['status' => 'expired']);

        $subscription->update([
            'status' => 'active',
            'starts_at' => now(),
            'ends_at' => $plan === 'free' ? null : now()->addDays($days ?? 30),
        ]);

        return $subscription;
    }
}

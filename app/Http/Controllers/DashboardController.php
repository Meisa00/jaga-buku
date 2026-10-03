<?php

namespace App\Http\Controllers;

use App\Services\PlanAccess;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, PlanAccess $plans): View
    {
        $user = $request->user();
        $income = (int) $user->transactions()->where('type', 'income')->sum('amount');
        $expense = (int) $user->transactions()->where('type', 'expense')->sum('amount');
        $monthStart = now()->startOfMonth()->toDateString();
        $monthEnd = now()->endOfMonth()->toDateString();
        $monthlyIncome = (int) $user->transactions()->where('type', 'income')
            ->whereBetween('transaction_date', [$monthStart, $monthEnd])->sum('amount');
        $monthlyExpense = (int) $user->transactions()->where('type', 'expense')
            ->whereBetween('transaction_date', [$monthStart, $monthEnd])->sum('amount');
        $history = $user->transactions();

        if (! $plans->allows($user, 'unlimited_history')) {
            $history->whereDate('transaction_date', '>=', now()->subDays(29)->toDateString());
        }

        return view('welcome', [
            'incomeTotal' => $monthlyIncome,
            'expenseTotal' => $monthlyExpense,
            'balance' => $income - $expense,
            'transactionCount' => (clone $history)->count(),
            'recentTransactions' => $history
                ->latest('transaction_date')
                ->latest('id')
                ->limit(6)
                ->get(),
            'currentPlan' => $plans->currentPlan($user),
            'userName' => $user->name,
        ]);
    }
}

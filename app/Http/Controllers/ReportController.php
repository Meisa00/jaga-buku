<?php

namespace App\Http\Controllers;

use App\Services\PlanAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __invoke(Request $request, PlanAccess $plans): View
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m', 'before_or_equal:'.now()->format('Y-m')],
        ]);
        $user = $request->user();
        $canMonthlyReports = $plans->allows($user, 'monthly_reports');
        $month = $canMonthlyReports ? ($validated['month'] ?? now()->format('Y-m')) : now()->format('Y-m');
        $monthStart = Carbon::createFromFormat('!Y-m', $month)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();
        $periodStart = $canMonthlyReports ? $monthStart : now()->subDays(29)->startOfDay();
        $periodEnd = $canMonthlyReports ? $monthEnd : now()->endOfDay();
        $transactions = $user->transactions()
            ->whereBetween('transaction_date', [$periodStart->toDateString(), $periodEnd->toDateString()])
            ->orderBy('transaction_date')
            ->get();

        $daily = $transactions->groupBy(fn ($transaction) => $transaction->transaction_date->format('Y-m-d'));
        $daysInRange = $periodStart->copy()->startOfDay()->diffInDays($periodEnd->copy()->startOfDay());
        $days = collect(range(0, $daysInRange))->map(function ($offset) use ($periodStart, $daily) {
            $date = $periodStart->copy()->startOfDay()->addDays($offset);
            $dayTransactions = $daily->get($date->toDateString(), collect());
            $income = (int) $dayTransactions->where('type', 'income')->sum('amount');
            $expense = (int) $dayTransactions->where('type', 'expense')->sum('amount');

            return [
                'day' => $date->day,
                'label' => $date->format('d/m'),
                'date' => $date->format('d/m/Y'),
                'income' => $income,
                'expense' => $expense,
                'profit' => $income - $expense,
            ];
        });
        $incomeTotal = (int) $transactions->where('type', 'income')->sum('amount');
        $expenseTotal = (int) $transactions->where('type', 'expense')->sum('amount');

        return view('reports.index', [
            'month' => $month,
            'monthName' => $canMonthlyReports ? Carbon::createFromFormat('!Y-m', $month)->locale('id')->translatedFormat('F Y') : null,
            'periodLabel' => $canMonthlyReports ? Carbon::createFromFormat('!Y-m', $month)->locale('id')->translatedFormat('F Y') : '30 hari terakhir',
            'days' => $days,
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'netProfit' => $incomeTotal - $expenseTotal,
            'transactions' => $transactions->sortByDesc('transaction_date')->take(8),
            'canMonthlyReports' => $canMonthlyReports,
            'canCharts' => $plans->allows($user, 'charts'),
            'canPdf' => $plans->allows($user, 'pdf_export'),
            'canExcel' => $plans->allows($user, 'excel_export'),
        ]);
    }
}

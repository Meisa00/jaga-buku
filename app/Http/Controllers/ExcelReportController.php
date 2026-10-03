<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExcelReportController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $validated = $request->validate([
            'month' => ['nullable', 'date_format:Y-m', 'before_or_equal:'.now()->format('Y-m')],
        ]);
        $month = $validated['month'] ?? now()->format('Y-m');
        $start = Carbon::createFromFormat('!Y-m', $month)->startOfMonth();
        $end = $start->copy()->endOfMonth();
        $transactions = $request->user()->transactions()
            ->whereBetween('transaction_date', [$start->toDateString(), $end->toDateString()])
            ->orderBy('transaction_date')
            ->get();

        return response()->streamDownload(function () use ($transactions) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Tanggal', 'Jenis', 'Kategori', 'Catatan', 'Nominal (IDR)'], ';');

            foreach ($transactions as $transaction) {
                fputcsv($output, [
                    $transaction->transaction_date->format('d/m/Y'),
                    $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $transaction->category,
                    $transaction->note,
                    $transaction->amount,
                ], ';');
            }

            fclose($output);
        }, 'laporan-jaga-buku-'.$month.'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

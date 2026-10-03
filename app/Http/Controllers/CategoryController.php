<?php

namespace App\Http\Controllers;

use App\Services\PlanAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __invoke(Request $request, PlanAccess $plans): View
    {
        $defaults = [
            'income' => [
                'Penjualan produk' => 'Penjualan produk',
                'Penjualan tunai' => 'Penjualan tunai',
                'Penjualan online' => 'Penjualan online',
                'Penjualan grosir' => 'Penjualan grosir',
                'Penjualan eceran' => 'Penjualan eceran',
                'Pendapatan marketplace' => 'Penjualan marketplace',
                'Jasa' => 'Pendapatan jasa',
                'Modal usaha' => 'Modal usaha',
                'Pemasukan lain' => 'Pemasukan lainnya',
            ],
            'expense' => [
                'Pembelian stok barang' => 'Pembelian stok barang',
                'Bahan baku' => 'Biaya bahan baku',
                'Biaya kemasan' => 'Biaya kemasan dan label',
                'Biaya marketplace' => 'Biaya marketplace',
                'Promosi dan iklan' => 'Promosi dan iklan',
                'Sewa tempat' => 'Sewa tempat',
                'Listrik dan air' => 'Listrik dan air',
                'Ongkos kirim' => 'Ongkos kirim',
                'Operasional' => 'Biaya operasional',
                'Gaji' => 'Gaji dan upah',
                'Transportasi' => 'Transportasi',
                'Pajak dan retribusi' => 'Pajak dan retribusi',
                'Pengeluaran lain' => 'Pengeluaran lainnya',
            ],
        ];

        $user = $request->user();
        $aggregates = $user->transactions()
            ->selectRaw('type, category, COUNT(*) as transaction_count, SUM(amount) as total_amount')
            ->groupBy('type', 'category')
            ->get()
            ->keyBy(fn ($row) => $row->type.'|'.$row->category);

        $customCategories = $user->categories()->get()->groupBy('type');
        $categories = collect($defaults)->map(function (array $items, string $type) use ($aggregates, $customCategories) {
            $list = collect($items)->map(function (string $name, string $category) use ($aggregates, $type) {
                $aggregate = $aggregates->get($type.'|'.$category);

                return [
                    'category' => $category,
                    'name' => $name,
                    'count' => (int) ($aggregate->transaction_count ?? 0),
                    'amount' => (int) ($aggregate->total_amount ?? 0),
                ];
            });

            $known = $list->pluck('category')->all();
            $customNames = $customCategories->get($type, collect())->pluck('name');
            $custom = $customNames
                ->map(function (string $name) use ($aggregates, $type) {
                    $aggregate = $aggregates->get($type.'|'.$name);

                    return [
                        'category' => $name,
                        'name' => $name,
                        'count' => (int) ($aggregate->transaction_count ?? 0),
                        'amount' => (int) ($aggregate->total_amount ?? 0),
                    ];
                })
                ->concat($aggregates
                    ->filter(fn ($row) => $row->type === $type && ! in_array($row->category, [...$known, ...$customNames->all()], true))
                    ->map(fn ($row) => [
                        'category' => $row->category,
                        'name' => $row->category,
                        'count' => (int) $row->transaction_count,
                        'amount' => (int) $row->total_amount,
                    ]));

            return $list->concat($custom)->values();
        });

        return view('categories.index', [
            'incomeCategories' => $categories->get('income', new Collection()),
            'expenseCategories' => $categories->get('expense', new Collection()),
            'categoryCount' => $aggregates->count(),
            'transactionCount' => (int) $user->transactions()->count(),
            'customCategories' => $customCategories,
            'canAddCustomCategories' => $plans->allows($user, 'unlimited_categories'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('categories', 'name')
                ->where(fn ($query) => $query->where('user_id', $request->user()->id)
                    ->where('type', $request->input('type')))],
            'type' => ['required', 'in:income,expense'],
        ]);

        $request->user()->categories()->create($validated);

        return redirect()->route('categories.index')->with('status', 'Kategori baru berhasil ditambahkan.');
    }
}

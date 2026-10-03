<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#f4f7f5">
    <title>Laporan Keuangan · Jaga Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;background:#f4f7f5;color:#17251f;font:14px 'DM Sans',sans-serif}a{color:inherit;text-decoration:none}.shell{max-width:1100px;margin:auto;padding:31px 23px}.top{display:flex;align-items:center;justify-content:space-between;margin-bottom:25px}.brand{font-size:20px;font-weight:800;color:#087b59}.nav{display:flex;gap:6px}.nav a{padding:9px 10px;border-radius:9px;color:#66766d;font-size:12px;font-weight:600}.nav a.active,.nav a:hover{background:#e5f4ec;color:#087b59}.intro{margin-bottom:17px}.eyebrow{font-size:11px;color:#078a63;font-weight:800;letter-spacing:1px}.intro h1{font-size:27px;letter-spacing:-.8px;margin:6px 0}.muted{color:#849188}.subtitle{font-size:12px}.toolbar{display:flex;align-items:center;gap:9px;flex-wrap:wrap}.toolbar input,.button{border:1px solid #dfe8e2;border-radius:10px;background:#fff;padding:10px 12px;font:600 11px 'DM Sans',sans-serif;color:#43574b}.button{cursor:pointer}.button.primary{background:#087b59;color:white;border-color:#087b59}.filter{margin:15px 0}.filter label{font-size:11px;margin-right:5px}.cards{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.card,.panel{background:#fff;border:1px solid #e4ebe6;border-radius:14px;padding:17px}.card span{font-size:11px;color:#79877f;font-weight:600}.card strong{display:block;font-size:22px;margin-top:10px}.card.income strong{color:#078a63}.card.expense strong{color:#d65d4c}.card.profit{background:#14271f;color:white;border-color:#14271f}.card.profit span{color:#b4c9bc}.panel{margin-top:14px}.panel-head{display:flex;justify-content:space-between;gap:12px;align-items:center}.panel h2{font-size:15px;margin:0}.period{font-size:11px;color:#87948c;margin-top:5px}.legend{display:flex;gap:12px;color:#75837b;font-size:10px}.dot{display:inline-block;width:8px;height:8px;border-radius:50%;background:#15a174;margin-right:5px}.dot.negative{background:#e77664}.chart-scroll{overflow-x:auto;margin-top:16px}.chart{min-width:680px;display:grid;grid-template-columns:repeat({{ $days->count() }},minmax(12px,1fr));gap:5px;height:180px;align-items:end;border-bottom:1px solid #e6ece8;padding:0 3px}.chart-day{height:100%;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;gap:6px}.bar-area{height:145px;width:100%;display:flex;align-items:flex-end;justify-content:center}.bar{width:min(18px,75%);min-height:3px;border-radius:5px 5px 2px 2px;background:#16a474}.bar.negative{background:#e77664}.day-label{font-size:8px;color:#98a49d;height:13px}.pl{display:grid;grid-template-columns:1fr auto;gap:10px;padding:10px 0;border-bottom:1px solid #edf1ee;font-size:12px}.pl:last-child{border:0}.pl.total{font-weight:800;color:#087b59;font-size:15px}.rows{margin-top:7px}.row{display:grid;grid-template-columns:1.1fr 1fr auto;gap:12px;padding:11px 0;border-top:1px solid #edf1ee;font-size:11px}.row strong{font-size:11px}.amount-in{color:#078a63;font-weight:700}.amount-out{color:#d65d4c;font-weight:700}.empty{text-align:center;color:#87958d;padding:23px;font-size:12px}.upgrade{margin-top:14px;padding:13px 15px;border-radius:11px;background:#edf7f0;color:#557364;font-size:11px;line-height:1.6}.upgrade a{color:#087b59;font-weight:800;text-decoration:underline}.toolbar.actions{justify-content:flex-end;margin-top:14px}@media(max-width:650px){.shell{padding:18px 13px 30px}.top{align-items:flex-start;flex-direction:column;gap:9px}.nav{width:100%;overflow:auto}.nav a{white-space:nowrap;padding-inline:8px}.intro h1{font-size:24px}.cards{grid-template-columns:1fr}.card{padding:14px}.card strong{font-size:20px}.row{grid-template-columns:1fr auto}.row .date{display:none}}@media print{body{background:#fff}.shell{max-width:none;padding:0}.nav,.toolbar,.filter,.upgrade{display:none!important}.panel,.card{break-inside:avoid;box-shadow:none}.chart{min-width:0;gap:2px}.chart-scroll{overflow:visible}.day-label{font-size:7px}}
    </style>
</head>
<body>
@php
    $money = fn ($value) => 'Rp '.number_format((int) $value, 0, ',', '.');
    $maxProfit = max(1, (int) $days->max(fn ($item) => abs($item['profit'])));
    $shareText = "Laporan keuangan Jaga Buku — {$periodLabel}\nPendapatan: ".$money($incomeTotal)."\nBeban: ".$money($expenseTotal)."\nLaba bersih: ".$money($netProfit);
@endphp
<main class="shell">
    <header class="top"><a class="brand" href="{{ route('dashboard') }}">◈ Jaga Buku</a><nav class="nav" aria-label="Navigasi"><a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('categories.index') }}">Kategori</a><a href="{{ route('transactions.create') }}">Transaksi</a><a class="active" href="{{ route('reports.index') }}">Laporan</a><a href="{{ route('users.profile') }}">Pengguna</a><a href="{{ route('plans.index') }}">Paket</a><a href="{{ route('consultation.index') }}">Konsultasi</a></nav></header>
    <div class="intro"><div class="eyebrow">PEMBUKUAN USAHA · JAGA BUKU</div><h1>Laporan keuangan</h1><div class="subtitle muted">Ringkasan pendapatan, beban, dan laba bersih · {{ $periodLabel }}</div></div>
    @if($canMonthlyReports)<form class="toolbar filter" method="GET" action="{{ route('reports.index') }}"><label class="muted" for="month">Pilih bulan</label><input id="month" name="month" type="month" value="{{ $month }}" max="{{ now()->format('Y-m') }}"><button class="button" type="submit">Tampilkan</button></form>@endif
    <section class="cards" aria-label="Ringkasan laporan"><article class="card income"><span>Total pendapatan</span><strong>{{ $money($incomeTotal) }}</strong></article><article class="card expense"><span>Total beban</span><strong>{{ $money($expenseTotal) }}</strong></article><article class="card profit"><span>Laba bersih</span><strong>{{ $money($netProfit) }}</strong></article></section>
    @if($canCharts)
        <section class="panel"><div class="panel-head"><div><h2>Tren laba harian</h2><div class="period">Pemasukan dikurangi pengeluaran · {{ $periodLabel }}</div></div><div class="legend"><span><i class="dot"></i>Laba</span><span><i class="dot negative"></i>Rugi</span></div></div>
            <div class="chart-scroll"><div class="chart" role="img" aria-label="Grafik laba bersih harian {{ $periodLabel }}">
                @foreach($days as $item)
                    @php($height = $item['profit'] === 0 ? 2 : max(5, (int) (abs($item['profit']) / $maxProfit * 100)))
                    <div class="chart-day" title="{{ $item['date'] }}: {{ $money($item['profit']) }}"><div class="bar-area"><span class="bar {{ $item['profit'] < 0 ? 'negative' : '' }}" style="height:{{ $height }}%"></span></div><span class="day-label">{{ $item['label'] }}</span></div>
                @endforeach
            </div></div>
        </section>
    @else
        <div class="upgrade">Grafik dan laporan bulanan tersedia di paket Pro. <a href="{{ route('plans.index') }}">Lihat paket Pro</a></div>
    @endif
    <section class="panel"><div class="panel-head"><div><h2>Ringkasan laba rugi</h2><div class="period">{{ $periodLabel }}</div></div></div><div class="pl"><span>Pendapatan</span><strong>{{ $money($incomeTotal) }}</strong></div><div class="pl"><span>Beban</span><strong>− {{ $money($expenseTotal) }}</strong></div><div class="pl total"><span>Laba bersih</span><strong>{{ $money($netProfit) }}</strong></div></section>
    <section class="panel"><div class="panel-head"><div><h2>Rincian transaksi</h2><div class="period">Maksimal 8 transaksi terbaru pada periode ini</div></div></div><div class="rows">
        @forelse($transactions as $transaction)<div class="row"><span><strong>{{ $transaction->category }}</strong><br><span class="muted">{{ $transaction->note ?: '—' }}</span></span><span class="date muted">{{ $transaction->transaction_date->format('d/m/Y') }}</span><span class="{{ $transaction->type === 'income' ? 'amount-in' : 'amount-out' }}">{{ $transaction->type === 'income' ? '+' : '−' }}{{ $money($transaction->amount) }}</span></div>@empty<div class="empty">Belum ada transaksi pada periode ini.</div>@endforelse
    </div></section>
    <div class="toolbar actions">
        @if($canPdf)<button class="button primary" onclick="window.print()" type="button">Unduh Laporan PDF</button>@else<a class="button" href="{{ route('plans.index') }}">PDF · Upgrade ke Pro</a>@endif
        @if($canExcel)<a class="button" href="{{ route('reports.excel', ['month' => $month]) }}">Unduh Excel</a>@else<a class="button" href="{{ route('plans.index') }}">Excel · Upgrade ke Pro</a>@endif
        <a class="button" href="https://wa.me/6285787250157?text={{ rawurlencode($shareText) }}" target="_blank" rel="noopener noreferrer">Kirim ringkasan via WhatsApp</a>
    </div>
</main>
</body>
</html>

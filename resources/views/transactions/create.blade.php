<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f6f8fb">
    <title>{{ $editingTransaction ? 'Ubah Transaksi' : 'Catat Transaksi' }} · Jaga Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{font-family:'DM Sans',Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:#111a30;background:#f6f8fb;font-synthesis:none;text-rendering:optimizeLegibility;--green:#009c70;--muted:#7183a1;--line:#e1e8f0;--ink:#10182e}*{box-sizing:border-box}body{margin:0;min-width:320px}a{color:inherit;text-decoration:none}button,input,select,textarea{font:inherit}.sidebar{width:270px;position:fixed;inset:0 auto 0 0;overflow-y:auto;overscroll-behavior:contain;background:#fff;border-right:1px solid #e5ebf2;padding:32px 25px 22px;display:flex;flex-direction:column;z-index:5}.brand{display:flex;align-items:center;gap:12px;margin-bottom:30px;flex:0 0 auto}.brand-mark{width:50px;height:50px;border-radius:15px;background:var(--green);color:white;display:grid;place-items:center;box-shadow:0 5px 12px #009c7024}.brand-mark svg{width:27px;height:27px}.brand-name{font-size:20px;font-weight:800;letter-spacing:-.6px}.brand-tag{font-size:12px;font-weight:700;letter-spacing:2px;color:var(--green);margin-top:2px}.nav{display:grid;gap:6px;flex:1 1 auto;min-height:0;overflow-y:auto;overscroll-behavior:contain;padding-right:4px}.nav-link{display:flex;align-items:center;gap:12px;min-height:48px;padding:0 15px;border-radius:12px;color:#5c7191;font-size:14px;transition:background .2s,color .2s}.nav-link:hover,.nav-link.active{background:#e9faf3;color:#008c65}.nav-link.active{outline:4px solid #d1fae8;outline-offset:0}.nav-link svg{width:22px;height:22px;stroke-width:1.9}.pro-card{margin-top:auto;background:var(--ink);color:#fff;border-radius:16px;padding:13px;margin:18px 0 14px;flex:0 0 auto}.pro-title{color:#4ce2b4;font-weight:800;display:flex;align-items:center;gap:7px;font-size:12px}.pro-title svg{width:18px}.pro-card p{font-size:11px;line-height:1.5;color:#a9bad5;margin:7px 0 10px}.pro-button{display:block;text-align:center;padding:9px;background:#273146;border-radius:10px;font-size:12px}.profile{padding-top:16px;border-top:1px solid #edf0f5;display:flex;align-items:center;gap:10px;flex:0 0 auto}.avatar{width:42px;height:42px;flex:0 0 42px;border-radius:50%;background:#fff2c7;color:#a84a00;display:grid;place-items:center;font-weight:800}.profile-copy{min-width:0}.profile-name{font-weight:800;font-size:13px}.profile-shop{font-size:11px;color:var(--muted);margin-top:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.settings{margin-left:auto;color:#8293ae;padding:6px}.settings svg{width:20px}.main{margin-left:270px;max-width:1760px;padding:36px 40px 56px}.topbar{display:flex;align-items:center;justify-content:space-between;margin-bottom:34px}.eyebrow{color:#008d69;font-weight:600;font-size:13px;margin-bottom:7px}.page-title{font-size:30px;letter-spacing:-1.3px;line-height:1.18;margin:0;font-weight:800}.top-actions{display:flex;align-items:center;gap:10px}.account-chip{display:flex;align-items:center;gap:9px;min-width:0}.account-meta{display:grid;gap:3px;max-width:150px}.account-meta strong{font-size:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.account-meta small{font-size:10px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}.history-button{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 14px;border:1px solid var(--line);border-radius:13px;background:#fff;color:#087b59;font-size:13px;font-weight:700;white-space:nowrap}.search-toggle{width:56px;height:56px;border-radius:16px;background:#fff;border:1px solid var(--line);color:#425673;display:grid;place-items:center}.search-toggle svg{width:23px}.content-grid{display:grid;grid-template-columns:minmax(0,1fr) 400px;gap:30px;align-items:start}.form-card{background:#fff;border:1px solid #dfe7ef;box-shadow:0 2px 4px #13294b13;border-radius:18px;padding:28px}.type-tabs{display:grid;grid-template-columns:1fr 1fr;padding:5px;background:#f0f4f8;border-radius:14px;margin-bottom:30px;gap:4px}.type-tab{height:54px;border:0;border-radius:12px;background:transparent;color:#647995;font-size:16px;display:flex;align-items:center;justify-content:center;gap:12px;transition:background .18s,color .18s,box-shadow .18s}.type-tab svg{width:19px;height:19px}.type-tab.active{background:#fff;color:#008d69;box-shadow:0 2px 5px #10243b1b}.type-tab.active.expense-tab{color:#ef2353}.field{margin-bottom:27px}.field label{display:block;font-weight:700;font-size:14px;margin-bottom:11px}.field label span{font-weight:400;color:#8b9bb4}.control{width:100%;height:60px;border:1px solid #d9e3ef;border-radius:13px;background:#fff;color:#283c5b;padding:0 17px;font-size:16px;outline:none;transition:border .15s,box-shadow .15s}.control:focus,.note-control:focus{border-color:#00a979;box-shadow:0 0 0 4px #00a9791a}.amount-wrap{position:relative}.amount-prefix{position:absolute;left:21px;top:50%;transform:translateY(-50%);font-size:19px;font-weight:700;color:#91a1b9;pointer-events:none}.amount-control{padding-left:64px;font-weight:600}.amount-control::placeholder,.note-control::placeholder{color:#bbc9da;font-weight:400}.select-wrap{position:relative}.select-wrap:after{content:"";position:absolute;right:22px;top:27px;width:9px;height:9px;border-right:2px solid #8ca1be;border-bottom:2px solid #8ca1be;transform:rotate(45deg);pointer-events:none}.select-control{appearance:none;padding-right:50px;cursor:pointer}.note-control{width:100%;height:112px;resize:vertical;min-height:90px;border:1px solid #d9e3ef;border-radius:13px;background:#fff;color:#283c5b;padding:16px 17px;font-size:15px;outline:none;transition:border .15s,box-shadow .15s}.date-control{font-size:16px}.save-button{width:100%;height:60px;border:0;border-radius:13px;background:#009c70;color:#fff;font-size:16px;font-weight:600;display:flex;align-items:center;justify-content:center;gap:12px;box-shadow:0 10px 18px #009c7025;transition:background .18s,transform .18s;margin-top:15px}.save-button:hover{background:#008762;transform:translateY(-1px)}.save-button svg{width:20px}.tips-card{background:#002f25;color:white;border-radius:21px;padding:30px;min-height:347px}.tips-icon{width:56px;height:56px;border-radius:15px;background:#004638;color:#4ce2b4;display:grid;place-items:center;margin-bottom:27px}.tips-icon svg{width:26px;height:26px}.tips-title{font-size:20px;font-weight:800;margin:0 0 14px}.tips-copy{font-size:15px;line-height:1.7;color:#75d9bd;margin:0}.tips-rule{height:1px;background:#ffffff1c;margin:24px 0}.tips-foot{color:#4ce2b4;font-size:14px;font-weight:700}.alert{border-radius:12px;padding:14px 16px;margin-bottom:20px;font-size:14px}.alert-success{background:#e9faf3;color:#007a59}.alert-error{background:#fff0f2;color:#c31c43}.alert ul{margin:7px 0 0;padding-left:20px}.mobile-nav{display:none}
        @media(max-width:1280px){.sidebar{width:250px;padding-inline:20px}.main{margin-left:250px;padding-inline:30px}.content-grid{grid-template-columns:minmax(0,1fr) 300px;gap:20px}.form-card{padding:26px}.tips-card{padding:24px}.control{height:58px}.select-wrap:after{top:22px}}
        @media(max-width:900px){.content-grid{grid-template-columns:1fr}.tips-card{min-height:0}.tips-icon{margin-bottom:17px}.tips-copy{max-width:650px}.tips-rule{margin:18px 0}}
        @media(max-width:800px){.sidebar{display:none}.main{margin:0;padding:24px 20px 100px}.topbar{margin-bottom:25px}.page-title{font-size:28px}.top-avatar{width:48px;height:48px}.search-toggle{width:48px;height:48px}.mobile-nav{display:flex;position:fixed;z-index:6;inset:auto 0 0;background:#fff;border-top:1px solid var(--line);padding:9px max(10px,env(safe-area-inset-left)) calc(9px + env(safe-area-inset-bottom));justify-content:flex-start;gap:2px;overflow-x:auto}.mobile-nav .nav-link{height:auto;min-width:65px;flex:0 0 auto;display:flex;flex-direction:column;gap:4px;padding:7px 10px;font-size:11px}.mobile-nav .nav-link svg{width:21px;height:21px}.form-card{padding:24px}.type-tabs{margin-bottom:29px}.type-tab{height:54px;font-size:17px}.tips-card{padding:23px}}
        @media(max-width:480px){.main{padding-inline:15px}.page-title{font-size:25px}.eyebrow{font-size:13px}.top-actions{gap:8px}.account-meta{max-width:90px}.account-meta small{display:none}.history-button{min-height:40px;padding-inline:10px;font-size:11px}.form-card{padding:18px}.type-tab{font-size:15px;gap:7px}.control{height:58px;font-size:17px;padding-inline:15px}.amount-control{padding-left:57px}.amount-prefix{left:17px;font-size:17px}.field{margin-bottom:22px}.note-control{font-size:16px}.save-button{height:62px;font-size:17px}.tips-title{font-size:20px}.tips-copy{font-size:16px}}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition:none!important}}
    </style>
</head>
<body>
@php
    $icon = fn ($name) => match ($name) {
        'book' => '<path d="M12 7v14m0-14C10.5 5.7 8.5 5 5 5H3v14h3c3 0 4.5.7 6 2m0-14c1.5-1.3 3.5-2 7-2h2v14h-3c-3 0-4.5.7-6 2"/>',
        'home' => '<path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1z"/>',
        'tag' => '<path d="M20.6 13.4 11 3H4v7l10.6 10.6a2 2 0 0 0 2.8 0l3.2-3.2a2 2 0 0 0 0-2.8Z"/><circle cx="7.5" cy="7.5" r=".8"/>',
        'receipt' => '<path d="M5 3h14v18l-2.5-1.5L14 21l-2-1.5L9.5 21 7 19.5 5 21zM8 8h8M8 12h8M8 16h5"/>',
        'chart' => '<path d="M4 19V5m0 14h17M8 16v-5m5 5V7m5 9V3"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm10 10v-2a4 4 0 0 0-3-3.9m-1-11.9a4 4 0 0 1 0 7.8"/>',
        'wallet' => '<rect x="3" y="5" width="18" height="15" rx="2"/><path d="M3 9h18m-5 5h2"/>',
        'headphones' => '<path d="M3 13v-2a9 9 0 0 1 18 0v2m-18 0v5a2 2 0 0 0 2 2h2v-8H5a2 2 0 0 0-2 1zm18 0v5a2 2 0 0 1-2 2h-2v-8h2a2 2 0 0 1 2 1z"/>',
        'spark' => '<path d="m12 3 1.7 5.3L19 10l-5.3 1.7L12 17l-1.7-5.3L5 10l5.3-1.7L12 3zm7 12 .8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8L19 15z"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.7a8 8 0 0 1-1.5.9l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.5-.9l-1.7.7-1.4-2.4 1.4-1.1a7 7 0 0 1 0-1.8l-1.4-1.1 1.4-2.4 1.7.7a8 8 0 0 1 1.5-.9l.3-1.8h2.8l.3 1.8a8 8 0 0 1 1.5.9l1.7-.7 1.4 2.4-1.4 1.1a7 7 0 0 1-.1 1.7z"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m20 20-4-4"/>',
        'arrow-in' => '<path d="M20 12H4m0 0 7-7m-7 7 7 7" transform="rotate(135 12 12)"/>',
        'arrow-out' => '<path d="M20 12H4m0 0 7-7m-7 7 7 7" transform="rotate(-45 12 12)"/>',
        'plus' => '<path d="M12 5v14m-7-7h14"/>',
        'edit' => '<path d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>',
        default => '',
    };
    $svg = fn ($name, $class = '') => '<svg class="'.$class.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'.$icon($name).'</svg>';
    $navItems = [['home','Dashboard',route('dashboard')],['tag','Kategori',route('categories.index')],['receipt','Transaksi',route('transactions.create')],['chart','Laporan',route('reports.index')],['users','Pengguna',route('users.profile')],['wallet','Paket',route('plans.index')],['headphones','Konsultasi',route('consultation.index')]];
@endphp
<aside class="sidebar" aria-label="Navigasi utama">
    <a class="brand" href="/"><span class="brand-mark">{!! $svg('book') !!}</span><span><span class="brand-name">Jaga Buku</span><span class="brand-tag" style="display:block">BISNIS LEBIH RAPI</span></span></a>
    <nav class="nav">@foreach($navItems as [$iconName, $label, $href])<a class="nav-link {{ $label === 'Transaksi' ? 'active' : '' }}" href="{{ $href }}">{!! $svg($iconName) !!}<span>{{ $label }}</span></a>@endforeach</nav>
    <section class="pro-card" id="konsultasi"><div class="pro-title">{!! $svg('spark') !!} Jaga Buku Pro</div><p>Butuh fitur laporan dan pencatatan yang lebih lengkap?</p><a class="pro-button" href="{{ route('plans.index') }}">Lihat paket</a></section>
    <div class="profile"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div class="profile-copy"><div class="profile-name">{{ auth()->user()->name }}</div><div class="profile-shop">{{ auth()->user()->email }}</div></div><a class="settings" href="{{ route('users.profile') }}" aria-label="Buka profil akun">{!! $svg('settings') !!}</a></div>
</aside>

<main class="main">
    <header class="topbar"><div><div class="eyebrow">Pembukuan harian</div><h1 class="page-title">{{ $editingTransaction ? 'Ubah transaksi' : 'Catat transaksi' }}</h1></div><div class="top-actions"><a class="history-button" href="{{ route('transactions.history') }}">Riwayat transaksi</a><button class="search-toggle" type="button" aria-label="Fokus ke nominal" onclick="document.querySelector('[name=amount]').focus()">{!! $svg('search') !!}</button><a class="account-chip" href="{{ route('users.profile') }}"><span class="avatar top-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span class="account-meta"><strong>{{ auth()->user()->name }}</strong><small>Pemilik UMKM · {{ $planLabel }}</small></span></a></div></header>
    <div class="content-grid">
        <section class="form-card" aria-label="Formulir transaksi">
            @if(session('success'))<div class="alert alert-success" role="status">{{ session('success') }}</div>@endif
            @if($errors->any())<div class="alert alert-error" role="alert">Periksa kembali data transaksi.<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            <form method="POST" action="{{ $editingTransaction ? route('transactions.update', $editingTransaction) : route('transactions.store') }}" id="transaction-form">
                @csrf
                @if($editingTransaction) @method('PUT') @endif
                <input type="hidden" name="type" id="transaction-type" value="{{ old('type', $type) }}">
                <div class="type-tabs" role="group" aria-label="Jenis transaksi">
                    <button class="type-tab {{ old('type', $type) === 'income' ? 'active' : '' }}" type="button" data-type="income">{!! $svg('arrow-in') !!} Pemasukan</button>
                    <button class="type-tab {{ old('type', $type) === 'expense' ? 'active expense-tab' : '' }}" type="button" data-type="expense">{!! $svg('arrow-out') !!} Pengeluaran</button>
                </div>
                <div class="field"><label for="amount">Nominal transaksi</label><div class="amount-wrap"><span class="amount-prefix">Rp</span><input class="control amount-control" id="amount" name="amount" type="text" inputmode="numeric" autocomplete="off" placeholder="0" value="{{ old('amount', $editingTransaction?->amount) ? number_format((int) old('amount', $editingTransaction?->amount), 0, ',', '.') : '' }}" required></div></div>
                <div class="field"><label for="category">Kategori</label><div class="select-wrap"><select class="control select-control" id="category" name="category" required>
                    <optgroup label="Pemasukan" data-options="income">@foreach($incomeCategories as $category)<option value="{{ $category }}" @selected(old('category', $editingTransaction?->category ?? 'Penjualan produk') === $category)>{{ $category }}</option>@endforeach</optgroup>
                    <optgroup label="Pengeluaran" data-options="expense" hidden>@foreach($expenseCategories as $category)<option value="{{ $category }}" @selected(old('category', $editingTransaction?->category) === $category)>{{ $category }}</option>@endforeach</optgroup>
                </select></div></div>
                <div class="field"><label for="note">Catatan <span>(opsional)</span></label><textarea class="note-control" id="note" name="note" maxlength="500" placeholder="Contoh: Penjualan dari toko online">{{ old('note', $editingTransaction?->note) }}</textarea></div>
                <div class="field"><label for="transaction-date">Tanggal transaksi</label><input class="control date-control" id="transaction-date" name="transaction_date" type="date" max="{{ now()->toDateString() }}" value="{{ old('transaction_date', $editingTransaction?->transaction_date?->toDateString() ?? now()->toDateString()) }}" required></div>
                <button class="save-button" type="submit">{!! $editingTransaction ? $svg('edit') : $svg('plus') !!}<span>{{ $editingTransaction ? 'Simpan perubahan' : 'Simpan transaksi' }}</span></button>
                @if($editingTransaction)<a class="history-button" style="width:100%;margin-top:10px" href="{{ route('transactions.history') }}">Batal mengubah transaksi</a>@endif
            </form>
        </section>
        <aside class="tips-card"><div class="tips-icon">{!! $svg('spark') !!}</div><h2 class="tips-title">Tips Jaga Buku</h2><p class="tips-copy">Catat transaksi setiap hari agar laporan keuangan usahamu selalu akurat dan siap digunakan.</p><div class="tips-rule"></div><div class="tips-foot">Konsisten hari ini, bisnis sehat nanti.</div></aside>
    </div>
</main>
<nav class="mobile-nav" aria-label="Navigasi mobile">@foreach($navItems as [$iconName, $label, $href])<a class="nav-link {{ $label === 'Transaksi' ? 'active' : '' }}" href="{{ $href }}">{!! $svg($iconName) !!}<span>{{ $label }}</span></a>@endforeach</nav>
<script>
    const categories = document.querySelectorAll('[data-options]');
    const typeInput = document.getElementById('transaction-type');
    const categorySelect = document.getElementById('category');
    function setType(type) {
        typeInput.value = type;
        document.querySelectorAll('.type-tab').forEach(tab => {
            const active = tab.dataset.type === type;
            tab.classList.toggle('active', active);
            tab.classList.toggle('expense-tab', active && type === 'expense');
        });
        categories.forEach(group => { group.hidden = group.dataset.options !== type; });
        const choices = categorySelect.querySelector(`[data-options="${type}"]`).querySelectorAll('option');
        if (![...choices].some(option => option.value === categorySelect.value)) categorySelect.value = choices[0].value;
    }
    document.querySelectorAll('.type-tab').forEach(tab => tab.addEventListener('click', () => setType(tab.dataset.type)));
    setType(typeInput.value);
    document.getElementById('amount').addEventListener('input', event => {
        const digits = event.target.value.replace(/\D/g, '');
        event.target.value = digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
    });
    document.getElementById('transaction-form').addEventListener('submit', event => {
        const amount = document.getElementById('amount');
        amount.value = amount.value.replace(/\D/g, '');
        if (!amount.value || Number(amount.value) < 1) {
            event.preventDefault();
            amount.setCustomValidity('Masukkan nominal transaksi yang lebih dari nol.');
            amount.reportValidity();
        } else amount.setCustomValidity('');
    });
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f7f4">
    <title>Pembayaran {{ $package['name'] }} · Jaga Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:20px;background:#f3f7f4;color:#17251f;font:14px 'DM Sans',sans-serif}.card{width:min(510px,100%);background:#fff;border:1px solid #e2ebe4;border-radius:21px;padding:28px;box-shadow:0 18px 50px #163d2910}.brand{font-size:18px;font-weight:800;color:#087b59;text-decoration:none}.eyebrow{margin-top:27px;color:#078a63;font-size:10px;font-weight:800;letter-spacing:1.3px}.card h1{margin:7px 0 5px;font-size:27px;letter-spacing:-.8px}.muted{color:#7e8d83;font-size:12px;line-height:1.65}.summary{display:flex;justify-content:space-between;gap:12px;align-items:center;margin:21px 0;padding:16px;background:#f5f9f6;border:1px solid #e6eee8;border-radius:13px}.summary strong{font-size:14px}.amount{color:#087b59;font-size:18px;font-weight:800;white-space:nowrap}.button{display:flex;width:100%;justify-content:center;align-items:center;border:0;border-radius:11px;padding:13px 16px;background:#087b59;color:#fff;text-decoration:none;font:700 12px 'DM Sans',sans-serif;cursor:pointer}.button:hover{background:#066e50}.button.secondary{margin-top:9px;background:#edf4ef;color:#4f6959}.alert{margin:15px 0;padding:12px;border-radius:10px;background:#fff4df;color:#815300;font-size:11px;line-height:1.65}.secure{text-align:center;margin-top:16px;font-size:10px;color:#8a978f}.error{color:#ad3328;font-size:11px;margin:10px 0}
    .main-nav{display:flex;gap:4px;overflow-x:auto;margin:13px -7px 0;padding:0 1px 5px;scrollbar-width:thin}.main-nav a{flex:0 0 auto;white-space:nowrap;padding:7px 8px;border-radius:8px;color:#66766d;font-size:10px;font-weight:700;text-decoration:none}.main-nav a:hover,.main-nav a.active{background:#e5f4ec;color:#087b59}</style>
</head>
<body>
<main class="card">
    <a class="brand" href="{{ route('dashboard') }}">◈ Jaga Buku</a><nav class="main-nav"><a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('categories.index') }}">Kategori</a><a href="{{ route('transactions.create') }}">Transaksi</a><a href="{{ route('reports.index') }}">Laporan</a><a href="{{ route('users.profile') }}">Pengguna</a><a class="active" href="{{ route('plans.index') }}">Paket</a><a href="{{ route('consultation.index') }}">Konsultasi</a></nav><div class="eyebrow">CHECKOUT AMAN · MIDTRANS</div>
    <h1>Bayar paket {{ $package['name'] }}</h1>
    <p class="muted">Pilih metode pembayaran yang tersedia di halaman Midtrans. Paket aktif setelah pembayaran berhasil dikonfirmasi.</p>

    @if(session('status'))<div class="alert">{{ session('status') }}</div>@endif

    <section class="summary">
        <div><strong>{{ $package['name'] }}</strong><div class="muted">Akses selama 30 hari</div></div>
        <div class="amount">Rp{{ number_format($package['price'], 0, ',', '.') }}</div>
    </section>

    @if($setupMissing)
        <div class="alert">Checkout belum dikonfigurasi. Tambahkan <strong>MIDTRANS_SERVER_KEY</strong> dan <strong>MIDTRANS_CLIENT_KEY</strong> dari dashboard Midtrans ke file <code>.env</code>, lalu muat ulang halaman ini. Untuk uji coba gunakan kredensial Sandbox dan <code>MIDTRANS_IS_PRODUCTION=false</code>.</div>
    @elseif($subscription->snap_token)
        <button class="button" id="pay-button" type="button">Pilih Metode Pembayaran</button>
        <a class="button secondary" href="{{ $subscription->payment_url }}" target="_blank" rel="noopener noreferrer">Buka halaman pembayaran Midtrans</a>
        <div id="payment-error" class="error" role="alert"></div>
        <p class="secure">Pembayaran diproses oleh Midtrans. Jangan tutup halaman sampai instruksi pembayaran tampil.</p>
        <script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
        <script>
            const payButton = document.getElementById('pay-button');
            const paymentError = document.getElementById('payment-error');
            const showPayment = () => {
                if (!window.snap) {
                    paymentError.textContent = 'Jendela pembayaran tidak dapat dibuka. Gunakan tombol halaman pembayaran Midtrans.';
                    return;
                }
                window.snap.pay(@js($subscription->snap_token), {
                    onSuccess: () => window.location.assign(@js(route('subscriptions.show'))),
                    onPending: () => window.location.assign(@js(route('subscriptions.show'))),
                    onError: () => { paymentError.textContent = 'Pembayaran belum berhasil. Silakan coba kembali.'; },
                    onClose: () => { paymentError.textContent = 'Pembayaran belum diselesaikan. Anda bisa melanjutkannya kembali dari halaman ini.'; }
                });
            };
            payButton.addEventListener('click', showPayment);
            window.addEventListener('load', () => window.setTimeout(showPayment, 350));
        </script>
    @endif

    <a class="button secondary" href="{{ route('subscriptions.show') }}">Lihat status langganan</a>
    <p class="secure">Order: {{ $subscription->order_id ?? 'menyiapkan checkout' }}</p>
</main>
</body>
</html>

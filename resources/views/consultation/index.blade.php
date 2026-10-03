<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f4f7f5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jaga Buku CS Bot</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{font-family:'DM Sans',Inter,ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;color:#17251f;background:#f2f6f3;font-synthesis:none;text-rendering:optimizeLegibility;--green:#087b59;--muted:#84928a;--line:#e5ece7;--ink:#14251d}*{box-sizing:border-box}body{margin:0;min-width:320px;min-height:100vh}a{color:inherit;text-decoration:none}button,input{font:inherit}.page{max-width:1180px;min-height:100vh;margin:auto;padding:0 28px;display:flex;flex-direction:column}.topbar{height:78px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e4ebe6}.brand{display:flex;align-items:center;gap:11px;font-weight:800;font-size:19px;letter-spacing:-.5px}.brand-icon{width:39px;height:39px;display:grid;place-items:center;background:#078a63;color:white;border-radius:13px;box-shadow:0 6px 14px #087b5926}.brand-icon svg{width:22px;height:22px}.nav{display:flex;align-items:center;gap:5px;max-width:100%;min-width:0;overflow-x:auto}.nav a{white-space:nowrap}.topbar{flex-wrap:wrap;gap:8px}.nav a{padding:9px 11px;border-radius:9px;color:#68776f;font-size:12px;font-weight:600}.nav a:hover,.nav a.active{background:#e6f4eb;color:var(--green)}.main{flex:1;display:grid;place-items:center;padding:28px 0 30px}.chat-shell{width:min(920px,100%);height:min(760px,calc(100vh - 136px));min-height:550px;display:grid;grid-template-columns:270px minmax(0,1fr);background:#fff;border:1px solid #e2eae4;border-radius:22px;overflow:hidden;box-shadow:0 18px 55px #183c2910}.chat-aside{background:#f8fbf9;border-right:1px solid var(--line);padding:24px 17px;display:flex;flex-direction:column}.aside-kicker{font-size:10px;letter-spacing:1.4px;text-transform:uppercase;color:#98a69d;font-weight:800;margin:5px 7px 10px}.chat-aside h2{font-size:16px;letter-spacing:-.3px;margin:0 7px}.aside-copy{font-size:11px;line-height:1.6;color:#89968f;margin:7px 7px 19px}.quick-list{display:grid;gap:8px}.quick-question{background:#fff;border:1px solid #e5ece7;border-radius:11px;padding:10px 11px;text-align:left;color:#475a4e;font-size:11px;line-height:1.45;font-weight:600;cursor:pointer;transition:border-color .15s,background .15s}.quick-question:hover{background:#eef8f2;border-color:#9ed1b3;color:var(--green)}.aside-help{margin-top:auto;padding:13px;border:1px solid #deebe2;background:#eff7f1;border-radius:12px}.aside-help strong{font-size:11px}.aside-help p{font-size:10px;color:#7a8a80;line-height:1.5;margin:5px 0 9px}.aside-help a{color:var(--green);font-size:10px;font-weight:800}.chat{min-width:0;display:flex;flex-direction:column}.chat-header{height:76px;flex:0 0 76px;padding:0 21px;border-bottom:1px solid #edf1ee;display:flex;align-items:center;gap:11px}.bot-avatar{width:41px;height:41px;flex:0 0 41px;border-radius:14px;background:#e6f5eb;color:var(--green);display:grid;place-items:center;font-size:13px;font-weight:800}.bot-avatar svg{width:21px}.bot-name{font-size:13px;font-weight:800}.bot-subtitle{font-size:10px;color:#96a29b;margin-top:4px}.online{margin-left:auto;display:flex;align-items:center;gap:6px;color:#138a62;font-size:10px;font-weight:700}.online-dot{width:7px;height:7px;border-radius:50%;background:#21b478;box-shadow:0 0 0 3px #e0f4e9}.messages{flex:1;min-height:0;overflow-y:auto;padding:22px 20px;display:flex;flex-direction:column;gap:13px;scroll-behavior:smooth}.day-label{align-self:center;color:#a0aaa4;font-size:9px;background:#f6f8f6;padding:5px 9px;border-radius:20px;margin-bottom:2px}.message{display:flex;align-items:flex-end;gap:7px;max-width:88%}.message.user{align-self:flex-end;flex-direction:row-reverse}.mini-avatar{width:25px;height:25px;flex:0 0 25px;display:grid;place-items:center;border-radius:9px;background:#e8f4ec;color:#16825f;font-size:9px;font-weight:800}.message.user .mini-avatar{background:#edf0f5;color:#526278}.bubble{padding:11px 13px;border-radius:14px;background:#f1f6f2;color:#33463a;font-size:12px;line-height:1.6;white-space:pre-wrap;overflow-wrap:anywhere;border-bottom-left-radius:4px}.message.user .bubble{background:#087b59;color:#fff;border-bottom-left-radius:14px;border-bottom-right-radius:4px}.message-time{display:block;font-size:9px;opacity:.62;margin-top:5px}.chat-form-wrap{padding:13px 17px 15px;border-top:1px solid #edf1ee;background:#fff}.chat-form{display:flex;align-items:center;gap:9px;padding:5px 5px 5px 14px;border:1px solid #dfe8e2;border-radius:14px;background:#fff;transition:border-color .15s,box-shadow .15s}.chat-form:focus-within{border-color:#78bd96;box-shadow:0 0 0 3px #087b5912}.chat-input{min-width:0;flex:1;border:0;outline:0;background:transparent;padding:9px 0;color:#26392e;font-size:12px}.chat-input::placeholder{color:#a3aea7}.send{height:37px;display:flex;align-items:center;gap:7px;padding:0 13px;border:0;border-radius:10px;background:var(--green);color:#fff;font-size:11px;font-weight:700;cursor:pointer;transition:background .15s}.send:hover{background:#056849}.send:disabled{opacity:.6;cursor:wait}.send svg{width:15px;height:15px}.privacy-note{text-align:center;font-size:9px;color:#a0aaa4;margin:8px 0 0}.footer{padding:0 0 16px;text-align:center;color:#a0aaa4;font-size:10px}
        @media(max-width:760px){.page{padding:0 13px}.topbar{height:65px}.brand{font-size:17px}.brand-icon{width:35px;height:35px}.nav{gap:0;max-width:65%;overflow-x:auto;white-space:nowrap}.nav a{font-size:10px;padding:8px 7px}.chat-shell{height:calc(100dvh - 99px);min-height:520px;grid-template-columns:minmax(0,1fr);grid-template-rows:auto minmax(0,1fr);border-radius:17px}.chat-aside{padding:12px 13px;border:0;border-bottom:1px solid var(--line);display:block}.aside-kicker{display:none}.chat-aside h2{font-size:13px;margin:0}.aside-copy{display:none}.quick-list{display:flex;overflow-x:auto;gap:7px;margin-top:9px;padding-bottom:2px}.quick-question{flex:0 0 auto;max-width:210px;padding:8px 10px;font-size:10px}.aside-help{display:none}.chat-header{height:65px;flex-basis:65px;padding:0 14px}.messages{padding:17px 12px}.message{max-width:94%}.bubble{font-size:11px}.bubble.error{background:#fff0ed;color:#9e4337}.chat-form-wrap{padding:10px 11px calc(10px + env(safe-area-inset-bottom))}.footer{display:none}}
        @media(max-width:390px){.page{padding:0 8px}.topbar{height:59px}.brand{gap:7px;font-size:15px}.brand-icon{width:31px;height:31px;border-radius:10px}.nav{max-width:61%}.nav a{font-size:9px;padding-inline:5px}.chat-shell{height:calc(100dvh - 78px);min-height:470px}.chat-aside{padding:10px}.chat-header{height:58px;flex-basis:58px}.messages{padding:13px 9px}.chat-input{font-size:11px}.send{padding-inline:10px}}
        @media(prefers-reduced-motion:reduce){*,*::before,*::after{scroll-behavior:auto!important;transition:none!important}}
    </style>
</head>
<body>
<div class="page">
    <header class="topbar">
        <a class="brand" href="{{ route('dashboard') }}"><span class="brand-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 7v14m0-14C10.5 5.7 8.5 5 5 5H3v14h3c3 0 4.5.7 6 2m0-14c1.5-1.3 3.5-2 7-2h2v14h-3c-3 0-4.5.7-6 2"/></svg></span><span>Jaga Buku</span></a>
        <nav class="nav" aria-label="Navigasi utama"><a href="{{ route('dashboard') }}">Dashboard</a><a href="{{ route('categories.index') }}">Kategori</a><a href="{{ route('transactions.create') }}">Transaksi</a><a href="{{ route('reports.index') }}">Laporan</a><a href="{{ route('users.profile') }}">Pengguna</a><a href="{{ route('plans.index') }}">Paket</a><a class="active" href="{{ route('consultation.index') }}">Konsultasi</a></nav>
    </header>
    <main class="main">
        <section class="chat-shell" aria-label="Percakapan dengan CS Bot Jaga Buku">
            <aside class="chat-aside">
                <div class="aside-kicker">Pusat bantuan</div>
                <h2>Pertanyaan cepat</h2>
                <p class="aside-copy">Pilih pertanyaan untuk mendapatkan jawaban langsung dari panduan Jaga Buku.</p>
                <div class="quick-list">
                    <button class="quick-question" type="button">Bagaimana cara mencatat transaksi?</button>
                    <button class="quick-question" type="button">Bagaimana cara melihat laporan keuangan?</button>
                    <button class="quick-question" type="button">Bagaimana cara mengubah kategori transaksi?</button>
                    <button class="quick-question" type="button">Bagaimana cara berlangganan Jaga Buku Pro?</button>
                    <button class="quick-question" type="button">Bagaimana cara menghubungi CS?</button>
                </div>
                <div class="aside-help"><strong>Perlu bantuan langsung?</strong><p>Hubungi CS manusia untuk pertanyaan khusus tentang akun atau layanan.</p><a href="https://wa.me/6285787250157?text={{ rawurlencode('Halo CS Jaga Buku, saya membutuhkan bantuan.') }}" target="_blank" rel="noopener noreferrer">Hubungi CS via WhatsApp →</a></div>
            </aside>
            <section class="chat" aria-label="Chat CS Bot">
                <header class="chat-header"><span class="bot-avatar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="3"/><path d="M12 3v4m-5 6h.01M17 13h.01M8 17h8"/></svg></span><span><span class="bot-name" style="display:block">Jaga Buku CS Bot</span><span class="bot-subtitle" style="display:block">Asisten informasi Jaga Buku</span></span><span class="online"><i class="online-dot"></i>Online</span></header>
                <div class="messages" id="chat-log" role="log" aria-live="polite" aria-relevant="additions text"><div class="day-label">Percakapan baru</div><div class="message bot"><span class="mini-avatar">JB</span><div class="bubble">Halo! Saya CS Bot Jaga Buku. Saya dapat membantu menjawab pertanyaan tentang penggunaan website, pencatatan transaksi, laporan, dan layanan Jaga Buku.<span class="message-time">Sekarang</span></div></div></div>
                <div class="chat-form-wrap"><form class="chat-form" id="chat-form" data-endpoint="{{ route('consultation.chat') }}"><input class="chat-input" id="chat-input" name="message" type="text" maxlength="500" placeholder="Tulis pertanyaan Anda..." autocomplete="off" required><button class="send" id="chat-send" type="submit"><span>Kirim</span><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m22 2-7 20-4-9-9-4 20-7ZM22 2 11 13"/></svg></button></form><p class="privacy-note">CS Bot menggunakan panduan FAQ Jaga Buku. Percakapan ini tidak disimpan.</p></div>
            </section>
        </section>
    </main>
    <footer class="footer">Jaga Buku · Membantu pencatatan keuangan usaha Anda</footer>
</div>
<script>
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatLog = document.getElementById('chat-log');
    const chatSend = document.getElementById('chat-send');

    function addMessage(text, author, error = false) {
        const row = document.createElement('div');
        row.className = `message ${author}`;
        const avatar = document.createElement('span');
        avatar.className = 'mini-avatar';
        avatar.textContent = author === 'user' ? 'Anda' : 'JB';
        const bubble = document.createElement('div');
        bubble.className = `bubble${error ? ' error' : ''}`;
        bubble.textContent = text;
        const time = document.createElement('span');
        time.className = 'message-time';
        time.textContent = new Intl.DateTimeFormat('id-ID', { hour: '2-digit', minute: '2-digit' }).format(new Date());
        bubble.appendChild(time);
        row.append(avatar, bubble);
        chatLog.appendChild(row);
        chatLog.scrollTop = chatLog.scrollHeight;
    }

    async function sendMessage(text) {
        const message = text.trim();
        if (!message || chatSend.disabled) return;

        addMessage(message, 'user');
        chatInput.value = '';
        chatInput.disabled = true;
        chatSend.disabled = true;

        try {
            const response = await fetch(chatForm.dataset.endpoint, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ message }),
            });
            const data = await response.json();
            if (!response.ok) throw new Error(data.message || 'Pesan belum dapat diproses. Silakan coba lagi.');
            addMessage(data.reply, 'bot');
        } catch (error) {
            addMessage(error.message || 'Koneksi bermasalah. Silakan coba lagi atau hubungi CS Jaga Buku.', 'bot', true);
        } finally {
            chatInput.disabled = false;
            chatSend.disabled = false;
            chatInput.focus();
        }
    }

    chatForm.addEventListener('submit', event => {
        event.preventDefault();
        sendMessage(chatInput.value);
    });

    document.querySelectorAll('.quick-question').forEach(button => button.addEventListener('click', () => {
        chatInput.value = button.textContent.trim();
        sendMessage(chatInput.value);
    }));
</script>
</body>
</html>

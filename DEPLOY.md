# Deploy Jaga Buku ke Render

Konfigurasi ini menyiapkan aplikasi Laravel dengan Docker dan PostgreSQL. Blueprint membuat web service paket Starter dan PostgreSQL paket 0.1 CPU / 256 MB. Blueprint baru akan meminta konfirmasi saat diterapkan di akun Render; meninjau file ini di repository tidak membuat layanan atau biaya.

## Sebelum deploy

1. Pastikan perubahan project sudah ada di repository Git yang dapat dihubungkan ke Render.
2. Di Render, buat Blueprint baru dari repository tersebut dan tinjau layanan serta biaya yang akan dibuat sebelum menekan tombol penerapan.
3. Render menyediakan URL `onrender.com`. Blueprint ini mengasumsikan slug `jaga-buku`; jika Render memilih URL berbeda, sesuaikan `APP_URL` pada Environment service sebelum menerima trafik.
4. Setelah service dan database tersedia, masukkan `MIDTRANS_SERVER_KEY` dan `MIDTRANS_CLIENT_KEY` produksi pada Environment service. Jangan simpan key di Git atau kirim lewat chat.
5. Perbarui URL notifikasi pembayaran di dashboard Midtrans menjadi `https://<alamat-render>/midtrans/notifikasi`.
6. Buat akun pengguna melalui halaman registrasi setelah situs aktif.

Database PostgreSQL akan dibuat kosong dan migrasi Laravel dijalankan sebelum rilis. Database SQLite lokal tidak disalin oleh konfigurasi ini.

## Catatan operasional

- File `.env` lokal dikecualikan dari Docker build. `APP_KEY` dibuat oleh Render dan harus dijaga tetap sama setelah deploy pertama.
- TLS untuk domain `onrender.com` ditangani Render. Domain sendiri dapat ditambahkan kemudian.
- Unggahan berkas lokal di container tidak persisten. Jika fitur unggah bukti/dokumen ditambahkan, gunakan object storage atau persistent storage sebelum mengandalkannya untuk data pelanggan.

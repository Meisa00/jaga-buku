<?php

namespace App\Services;

use Illuminate\Support\Str;

class JagaBukuChatbot
{
    public function reply(string $message): string
    {
        $message = Str::lower(Str::ascii(trim($message)));
        $message = preg_replace('/[^a-z0-9\s]/', ' ', $message) ?? '';
        $message = preg_replace('/\s+/', ' ', $message) ?? '';

        if ($this->hasAny($message, ['halo', 'hai', 'hello', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam'])) {
            return 'Halo! Saya CS Bot Jaga Buku. Saya dapat membantu tentang penggunaan website, transaksi, kategori, laporan, dan layanan Jaga Buku. Apa yang ingin Anda tanyakan?';
        }

        if ($this->hasAny($message, ['bagaimana cara menghubungi cs', 'cara menghubungi cs', 'hubungi cs', 'kontak cs', 'customer service', 'hubungi tim'])) {
            return 'Tekan tombol “Hubungi CS via WhatsApp” di halaman Konsultasi. WhatsApp akan membuka percakapan langsung dengan tim CS Jaga Buku.';
        }

        if ($this->hasAny($message, ['login', 'masuk akun', 'lupa password', 'lupa kata sandi', 'kata sandi', 'password', 'daftar akun'])) {
            return 'Masuk melalui menu Login menggunakan email dan kata sandi akun. Jika belum punya akun, pilih Daftar; kata sandi harus minimal 8 karakter. Fitur reset kata sandi otomatis belum tersedia, jadi untuk kendala akses silakan hubungi CS melalui WhatsApp.';
        }

        if ($this->hasAny($message, ['ubah kategori', 'mengubah kategori', 'ganti kategori', 'edit kategori', 'tambah kategori', 'kategori transaksi', 'kategori apa', 'jenis pemasukan', 'jenis pengeluaran', 'kategori'])) {
            return 'Pilih kategori saat mencatat transaksi pada menu Transaksi. Jaga Buku menyediakan kategori dagang seperti penjualan tunai, online, grosir, eceran, dan marketplace. Pengeluaran mencakup pembelian stok, bahan baku, kemasan, biaya marketplace, promosi, sewa, listrik dan air, ongkos kirim, gaji, transportasi, serta pajak. Paket Pro dan Pro Plus dapat menambahkan kategori khusus dari halaman Kategori.';
        }

        if ($this->hasAny($message, ['berlangganan', 'langganan', 'jaga buku pro', 'paket pro', 'pro plus', 'paket', 'berapa biaya', 'berapa harga', 'harga layanan', 'tarif layanan'])) {
            return 'Paket Free Rp0 aktif setelah mendaftar. Paket Pro Rp29.000/bulan mencakup kategori dan riwayat tanpa batas, laporan lengkap, grafik, ekspor, backup, multi-user, dan pengingat. Paket Pro Plus Rp59.000/bulan mencakup fitur Pro serta bantuan pencatatan dan konsultasi. Pilih paket di menu Paket, lalu selesaikan pembayaran melalui Midtrans. Paket aktif otomatis setelah pembayaran dikonfirmasi.';
        }

        if ($this->hasAny($message, ['pembayaran', 'metode pembayaran', 'bayar', 'transfer', 'invoice'])) {
            return 'Pilih Pro atau Pro Plus dari menu Paket. Anda akan diarahkan ke checkout Midtrans untuk memilih metode pembayaran yang tersedia. Status paket diperbarui otomatis setelah Midtrans mengirim konfirmasi pembayaran.';
        }

        if ($this->hasAny($message, ['laporan', 'laba rugi', 'laba bersih', 'grafik', 'unduh pdf', 'ekspor', 'lihat laporan'])) {
            return 'Buka menu Laporan, lalu pilih bulan yang ingin dilihat. Halaman ini menampilkan pendapatan, beban, laba bersih, grafik laba harian, dan rincian transaksi. Untuk menyimpan PDF, tekan “Unduh Laporan PDF” lalu pilih “Save as PDF” pada dialog cetak.';
        }

        if ($this->hasAny($message, ['saldo', 'uang kas', 'kas usaha'])) {
            return 'Saldo di Dashboard dihitung dari seluruh pemasukan dikurangi seluruh pengeluaran yang tercatat. Kartu pemasukan dan pengeluaran menampilkan jumlah untuk bulan berjalan.';
        }

        if ($this->hasAny($message, ['catat pemasukan', 'transaksi pemasukan', 'uang masuk', 'pemasukan'])) {
            return 'Untuk mencatat pemasukan, buka menu Transaksi dan pilih tab Pemasukan. Masukkan nominal, pilih kategori pemasukan, tambahkan catatan bila perlu, tentukan tanggal transaksi, lalu tekan “Simpan transaksi”.';
        }

        if ($this->hasAny($message, ['catat pengeluaran', 'transaksi pengeluaran', 'uang keluar', 'pengeluaran', 'biaya usaha'])) {
            return 'Untuk mencatat pengeluaran, buka menu Transaksi dan pilih tab Pengeluaran. Masukkan nominal, pilih kategori pengeluaran seperti bahan baku atau sewa tempat, tambahkan catatan bila perlu, tentukan tanggal, lalu tekan “Simpan transaksi”.';
        }

        if ($this->hasAny($message, ['edit transaksi', 'ubah transaksi', 'hapus transaksi', 'salah input', 'mengubah transaksi', 'menghapus transaksi'])) {
            return 'Buka menu Transaksi, lalu pilih “Riwayat transaksi”. Pada catatan yang ingin diperbaiki, tekan Edit untuk mengubahnya atau Hapus untuk menghapusnya. Paket Free dapat mengelola transaksi dalam 30 hari terakhir.';
        }

        if ($this->hasAny($message, ['cara menggunakan', 'menggunakan jaga buku', 'cara pakai', 'gunakan website', 'penggunaan website', 'transaksi'])) {
            return 'Mulai dari Dashboard untuk melihat ringkasan usaha. Gunakan menu Transaksi untuk mencatat pemasukan atau pengeluaran, Kategori untuk melihat kelompok pencatatan, dan Laporan untuk meninjau hasil per bulan.';
        }

        return 'Maaf, pertanyaan tersebut belum dikenali di panduan CS Bot Jaga Buku. Agar Anda mendapat jawaban yang tepat, silakan hubungi CS manusia melalui tombol “Hubungi CS via WhatsApp” di halaman ini.';
    }

    /** @param list<string> $phrases */
    private function hasAny(string $message, array $phrases): bool
    {
        foreach ($phrases as $phrase) {
            if (str_contains(' '.$message.' ', ' '.$phrase.' ')) {
                return true;
            }
        }

        return false;
    }
}

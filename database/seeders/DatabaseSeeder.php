<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Evaluasi;
use App\Models\Kriteria;
use App\Models\Lowongan;
use App\Models\Pelamar;
use App\Models\Penilaian;
use App\Models\Tes;
use App\Models\User;
use App\Models\Wawancara;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Evaluasi::query()->delete();
        Penilaian::query()->delete();
        Wawancara::query()->delete();
        Tes::query()->delete();
        Pelamar::query()->delete();
        Kriteria::query()->delete();
        Lowongan::query()->delete();
        User::query()->delete();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make("admin"),
        ]);

        Lowongan::insert([
            [
                'judul' => 'Staff IT',
                'url_gambar' => 'https://www.techdonut.co.uk/sites/default/files/styles/landing_pages_lists/public/youritpolicies_143568193_0.jpg?itok=8ojzbsqo',
                'deskripsi' => "
- Lulusan Ilmu Komputer
- Memiliki pengalaman min. 1 tahun di bidang IT Software atau Fresh Graduate diperilahkan
- Bertanggungjawab untuk mengaplikasikan sistem komputer pada perusahaan
- Tanggap, teliti dan siap bekerja di bawah tekanan
- Berorientasi pada hasil
- Dapat secara tim maupun mandiri
- Dapat segera bergabung
- Penempatan di Semarang"
            ],
            [
                "judul" => "Admin",
                'url_gambar' => 'https://dibimbing-cdn.sgp1.cdn.digitaloceanspaces.com/1716979186003-surat-lamaran-kerja-staff-admin.webp',
                'deskripsi' => 'engolahan Pesanan
Menerima dan memproses pesanan dari pelanggan, baik melalui telepon, email, maupun sistem penjualan.
Memastikan bahwa semua pesanan terinput dengan benar dalam sistem.
Mengelola proses pengiriman barang dan memastikan pesanan dikirim tepat waktu.

Koordinasi dengan Tim Penjualan dan Departemen Lain
Berkomunikasi dengan tim penjualan untuk memastikan kelancaran proses penjualan dan pengiriman produk.
Bekerja sama dengan bagian gudang dan logistik untuk memastikan stok barang dan pengiriman tepat waktu.

Administrasi Data Penjualan
Memastikan bahwa data penjualan dicatat dan dikelola dengan baik.
Mengelola dokumen terkait transaksi penjualan seperti faktur, surat jalan, dan lainnya.

Penanganan Klaim dan Pengembalian Barang
Menangani keluhan dan klaim pelanggan terkait produk atau pengiriman.
Memproses pengembalian barang dan memastikan prosedur dilakukan sesuai kebijakan perusahaan.

Pemantauan Pembayaran
Memantau status pembayaran dari pelanggan dan berkoordinasi dengan bagian keuangan terkait tagihan yang belum dibayar.
Mengirimkan reminder atau notifikasi kepada pelanggan terkait pembayaran yang terlambat.
Penyusunan Laporan

Menyusun laporan penjualan dan aktivitas administrasi secara rutin untuk diserahkan kepada manajer penjualan.
Membantu dalam analisis penjualan untuk memantau pencapaian target dan mencari peluang peningkatan.

Pengelolaan Dokumen dan Arsip
Menyimpan dan mengelola arsip penjualan secara rapi dan terstruktur.
Memastikan dokumen terkait transaksi penjualan tersimpan dengan aman dan mudah diakses.

Pelayanan Pelanggan
Memberikan layanan pelanggan yang baik dengan memberikan informasi terkait produk, status pesanan, dan membantu menjawab pertanyaan pelanggan dengan cepat dan akurat.'
            ],
            [
                'judul' => 'Kasir',
                'url_gambar' => 'https://lh6.googleusercontent.com/Wl-SMc3OgoQHnL_-7UfAManPGwSF8a5gKOyqtqaqRCr46_Szwj1khSQdcMvDXwOkc9gI6KBJteonyFhePqLHzKToDCuVb_8G093-JCb8JERsBQzlrcEjYiF7uqows7D4xISDCYEyhWcr',
                'deskripsi' => '1. Transaksi Penjualan: Melayani pembayaran pelanggan dengan cepat dan akurat (cash, kartu, e-wallet).
2. Pencatatan Keuangan: Membuat laporan harian pendapatan dan menyetorkan uang hasil penjualan sesuai prosedur.
3. Pelayanan Pelanggan: Menyambut pelanggan dengan ramah dan memberikan informasi promo/restoran jika diperlukan.
4. Pengelolaan Kas: Memastikan saldo kas sesuai dan bertanggung jawab atas keuangan selama shift.
5. Sistem POS: Mengoperasikan sistem kasir dan memastikan tidak ada kesalahan input data.
6.Kebersihan Area Kasir: Menjaga kebersihan dan kerapihan meja kasir.
7.Kerjasama Tim: Berkoordinasi dengan tim lain untuk memastikan operasional restoran berjalan lancar.'
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@margasari.id')->first();
        
        if (!$admin) {
            $this->command->warn('Admin user tidak ditemukan. Jalankan DatabaseSeeder terlebih dahulu.');
            return;
        }

        $posts = [
            [
                'title' => 'Selamat Datang di Website Kelurahan Marga Sari',
                'slug' => 'selamat-datang-di-website-kelurahan-marga-sari',
                'excerpt' => 'Website resmi Kelurahan Marga Sari telah resmi diluncurkan untuk memberikan pelayanan informasi yang lebih baik kepada masyarakat.',
                'content' => '<p>Dengan bangga kami mengumumkan bahwa website resmi Kelurahan Marga Sari telah resmi diluncurkan. Website ini hadir sebagai wujud komitmen kami dalam memberikan pelayanan informasi yang transparan dan mudah diakses oleh seluruh masyarakat.</p>

<p>Melalui website ini, masyarakat dapat:</p>
<ul>
<li>Mengakses informasi terbaru tentang kegiatan kelurahan</li>
<li>Mendapatkan pengumuman penting</li>
<li>Melihat agenda kegiatan yang akan datang</li>
<li>Mengetahui layanan-layanan yang tersedia</li>
<li>Menghubungi aparatur kelurahan</li>
</ul>

<p>Kami berharap website ini dapat menjadi jembatan komunikasi yang efektif antara pemerintah kelurahan dengan masyarakat. Mari bersama-sama membangun Kelurahan Marga Sari yang lebih maju dan sejahtera.</p>',
                'type' => 'berita',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 156,
                'user_id' => $admin->id
            ],
            [
                'title' => 'Pengumuman Jadwal Pelayanan Administrasi Bulan Oktober 2025',
                'slug' => 'pengumuman-jadwal-pelayanan-administrasi-oktober-2025',
                'excerpt' => 'Informasi jadwal pelayanan administrasi kependudukan di Kelurahan Marga Sari untuk bulan Oktober 2025.',
                'content' => '<p>Kepada seluruh warga Kelurahan Marga Sari, dengan ini kami sampaikan jadwal pelayanan administrasi kependudukan untuk bulan Oktober 2025:</p>

<h3>Jadwal Pelayanan Regular</h3>
<ul>
<li><strong>Senin - Kamis:</strong> 08.00 - 15.00 WIB</li>
<li><strong>Jumat:</strong> 08.00 - 11.00 WIB</li>
<li><strong>Sabtu - Minggu:</strong> Libur</li>
</ul>

<h3>Layanan Yang Tersedia</h3>
<ul>
<li>Kartu Keluarga (KK)</li>
<li>Kartu Tanda Penduduk (KTP)</li>
<li>Akta Kelahiran</li>
<li>Surat Keterangan Domisili</li>
<li>Surat Keterangan Usaha</li>
<li>Surat Pengantar berbagai keperluan</li>
</ul>

<h3>Persyaratan Umum</h3>
<p>Pastikan membawa dokumen asli dan fotocopy yang diperlukan. Untuk informasi lebih detail, hubungi petugas pelayanan atau datang langsung ke kantor kelurahan.</p>

<p><em>Catatan: Pada tanggal 17 Oktober 2025 (libur nasional), kantor kelurahan tutup.</em></p>',
                'type' => 'pengumuman',
                'status' => 'published',
                'published_at' => now()->subHours(6),
                'views' => 89,
                'user_id' => $admin->id
            ],
            [
                'title' => 'Gotong Royong Bersih Lingkungan Serentak Se-Kelurahan',
                'slug' => 'gotong-royong-bersih-lingkungan-serentak',
                'excerpt' => 'Kegiatan gotong royong bersih lingkungan akan dilaksanakan pada hari Minggu, 29 Oktober 2025 pukul 07.00 WIB.',
                'content' => '<p>Dalam rangka menjaga kebersihan dan kesehatan lingkungan, Kelurahan Marga Sari mengajak seluruh warga untuk berpartisipasi dalam kegiatan Gotong Royong Bersih Lingkungan Serentak.</p>

<h3>Detail Kegiatan</h3>
<ul>
<li><strong>Hari/Tanggal:</strong> Minggu, 29 Oktober 2025</li>
<li><strong>Waktu:</strong> 07.00 - 10.00 WIB</li>
<li><strong>Tempat:</strong> Seluruh wilayah RT/RW di Kelurahan Marga Sari</li>
</ul>

<h3>Kegiatan Yang Akan Dilakukan</h3>
<ul>
<li>Pembersihan saluran air dan selokan</li>
<li>Pengangkutan sampah di area umum</li>
<li>Pembersihan taman dan fasilitas umum</li>
<li>Pemotongan rumput liar</li>
<li>Pengecatan fasilitas umum yang perlu diperbaiki</li>
</ul>

<h3>Peralatan Yang Perlu Dibawa</h3>
<ul>
<li>Sapu dan cangkul</li>
<li>Karung atau kantong sampah</li>
<li>Sarung tangan</li>
<li>Pakaian kerja</li>
</ul>

<p>Mari kita wujudkan lingkungan yang bersih, sehat, dan nyaman untuk kita semua. Partisipasi aktif dari seluruh warga sangat diharapkan.</p>

<p>Untuk koordinasi lebih lanjut, hubungi Ketua RT masing-masing atau langsung ke kantor kelurahan.</p>',
                'type' => 'agenda',
                'status' => 'published',
                'published_at' => now()->subHours(2),
                'views' => 234,
                'user_id' => $admin->id
            ],
            [
                'title' => 'Sosialisasi Program Bantuan Sosial Pemerintah Tahun 2025',
                'slug' => 'sosialisasi-program-bantuan-sosial-2025',
                'excerpt' => 'Kelurahan Marga Sari akan mengadakan sosialisasi program bantuan sosial pemerintah untuk tahun 2025.',
                'content' => '<p>Kelurahan Marga Sari akan mengadakan sosialisasi mengenai berbagai program bantuan sosial pemerintah yang dapat diakses oleh masyarakat pada tahun 2025.</p>

<h3>Waktu dan Tempat</h3>
<ul>
<li><strong>Hari/Tanggal:</strong> Rabu, 25 Oktober 2025</li>
<li><strong>Waktu:</strong> 14.00 - 16.00 WIB</li>
<li><strong>Tempat:</strong> Balai Kelurahan Marga Sari</li>
</ul>

<h3>Program Yang Akan Disosialisasikan</h3>
<ul>
<li>Program Keluarga Harapan (PKH)</li>
<li>Bantuan Langsung Tunai (BLT)</li>
<li>Kartu Indonesia Pintar (KIP)</li>
<li>Kartu Indonesia Sehat (KIS)</li>
<li>Program Sembako</li>
<li>Bantuan Usaha Mikro Kecil (BUMK)</li>
</ul>

<p>Sosialisasi ini akan disampaikan langsung oleh tim dari Dinas Sosial Kabupaten dan petugas dari berbagai instansi terkait.</p>

<p><strong>Peserta yang diharapkan hadir:</strong></p>
<ul>
<li>Ketua RT/RW se-kelurahan</li>
<li>Perwakilan keluarga kurang mampu</li>
<li>Pelaku usaha mikro dan kecil</li>
<li>Masyarakat umum yang membutuhkan informasi</li>
</ul>

<p>Acara ini gratis dan terbuka untuk umum. Diharapkan partisipasi aktif dari seluruh warga untuk mendapatkan informasi terbaru mengenai program-program bantuan sosial.</p>',
                'type' => 'agenda',
                'status' => 'draft',
                'published_at' => null,
                'views' => 0,
                'user_id' => $admin->id
            ]
        ];

        foreach ($posts as $postData) {
            Post::create($postData);
        }

        $this->command->info('Sample posts berhasil dibuat!');
    }
}

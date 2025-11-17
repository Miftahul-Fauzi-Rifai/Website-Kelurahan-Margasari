-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 05:36 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kelmarga`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_setting_kelurahan_name', 's:20:\"KELURAHAN MARGA SARI\";', 1763263122),
('laravel_cache_setting_lurah_name', 's:25:\"HENDRA JAYA PRAWIRA, S.ST\";', 1763263122);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelapor` varchar(255) NOT NULL,
  `email_pelapor` varchar(255) DEFAULT NULL,
  `telepon_pelapor` varchar(255) NOT NULL,
  `alamat_pelapor` varchar(255) NOT NULL,
  `judul_pengaduan` varchar(255) NOT NULL,
  `deskripsi_pengaduan` text NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `prioritas` enum('rendah','sedang','tinggi') NOT NULL DEFAULT 'sedang',
  `foto_pendukung` varchar(255) DEFAULT NULL,
  `status` enum('baru','sedang_diproses','selesai','ditolak') NOT NULL DEFAULT 'baru',
  `tanggapan_admin` text DEFAULT NULL,
  `tanggal_tanggapan` timestamp NULL DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `nama_pelapor`, `email_pelapor`, `telepon_pelapor`, `alamat_pelapor`, `judul_pengaduan`, `deskripsi_pengaduan`, `kategori`, `prioritas`, `foto_pendukung`, `status`, `tanggapan_admin`, `tanggal_tanggapan`, `admin_id`, `created_at`, `updated_at`) VALUES
(1, 'awda', 'alif@gmail.com', '081350141971721', 'wadaw', 'awd', 'wadawd', 'kebersihan', 'sedang', 'complaints/1762569655_Screenshot 2025-09-07 214216.png', 'sedang_diproses', NULL, '2025-11-13 20:22:18', 1, '2025-11-07 18:40:55', '2025-11-13 20:22:18'),
(2, 'asda', '1231@gmail.com', '1231', '3131', '1231', '123', 'ekonomi', 'sedang', 'complaints/1762571784_Screenshot 2025-09-27 123313.png', 'selesai', NULL, '2025-11-13 19:55:27', 1, '2025-11-07 19:16:24', '2025-11-13 19:55:27');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_19_205500_create_roles_table', 1),
(5, '2025_09_19_205506_create_posts_table', 1),
(6, '2025_09_19_205510_create_services_table', 1),
(7, '2025_09_19_205518_add_role_id_to_users_table', 1),
(8, '2025_09_19_211324_create_rts_table', 1),
(9, '2025_09_26_235608_create_complaints_table', 1),
(10, '2025_10_17_182919_remove_agenda_from_posts_type_enum', 1),
(11, '2025_10_18_055320_create_reports_table', 1),
(12, '2025_11_02_050537_add_detailed_data_to_rts_table', 1),
(13, '2025_11_02_052740_add_photo_to_rts_table', 1),
(14, '2025_11_02_054855_add_address_to_rts_table', 1),
(15, '2025_11_03_100921_create_tentang_table', 1),
(16, '2025_11_03_132330_create_sosial_media_table', 1),
(17, '2025_11_03_140046_update_tentang_add_logo_column', 1),
(18, '2025_11_03_141858_create_struktur_organisasi_table', 1),
(19, '2025_11_04_023353_create_settings_table', 1),
(20, '2025_11_07_000001_update_rt_code_to_two_digits', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `type` enum('berita','pengumuman') NOT NULL DEFAULT 'berita',
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `type`, `status`, `published_at`, `user_id`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Selamat Datang di Website Kelurahan Marga Sari', 'selamat-datang-di-website-kelurahan-marga-sari', 'Website resmi Kelurahan Marga Sari telah resmi diluncurkan untuk memberikan pelayanan informasi yang lebih baik kepada masyarakat.', '<p>Dengan bangga kami mengumumkan bahwa website resmi Kelurahan Marga Sari telah resmi diluncurkan. Website ini hadir sebagai wujud komitmen kami dalam memberikan pelayanan informasi yang transparan dan mudah diakses oleh seluruh masyarakat.</p>\r\n\r\n<p>Melalui website ini, masyarakat dapat:</p>\r\n<ul>\r\n<li>Mengakses informasi terbaru tentang kegiatan kelurahan</li>\r\n<li>Mendapatkan pengumuman penting</li>\r\n<li>Melihat agenda kegiatan yang akan datang</li>\r\n<li>Mengetahui layanan-layanan yang tersedia</li>\r\n<li>Menghubungi aparatur kelurahan</li>\r\n</ul>\r\n\r\n<p>Kami berharap website ini dapat menjadi jembatan komunikasi yang efektif antara pemerintah kelurahan dengan masyarakat. Mari bersama-sama membangun Kelurahan Marga Sari yang lebih maju dan sejahtera.</p>', NULL, 'berita', 'published', '2025-11-05 05:05:52', 1, 156, '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(2, 'Pengumuman Jadwal Pelayanan Administrasi Bulan Oktober 2025', 'pengumuman-jadwal-pelayanan-administrasi-oktober-2025', 'Informasi jadwal pelayanan administrasi kependudukan di Kelurahan Marga Sari untuk bulan Oktober 2025.', '<p>Kepada seluruh warga Kelurahan Marga Sari, dengan ini kami sampaikan jadwal pelayanan administrasi kependudukan untuk bulan Oktober 2025:</p>\r\n\r\n<h3>Jadwal Pelayanan Regular</h3>\r\n<ul>\r\n<li><strong>Senin - Kamis:</strong> 08.00 - 15.00 WIB</li>\r\n<li><strong>Jumat:</strong> 08.00 - 11.00 WIB</li>\r\n<li><strong>Sabtu - Minggu:</strong> Libur</li>\r\n</ul>\r\n\r\n<h3>Layanan Yang Tersedia</h3>\r\n<ul>\r\n<li>Kartu Keluarga (KK)</li>\r\n<li>Kartu Tanda Penduduk (KTP)</li>\r\n<li>Akta Kelahiran</li>\r\n<li>Surat Keterangan Domisili</li>\r\n<li>Surat Keterangan Usaha</li>\r\n<li>Surat Pengantar berbagai keperluan</li>\r\n</ul>\r\n\r\n<h3>Persyaratan Umum</h3>\r\n<p>Pastikan membawa dokumen asli dan fotocopy yang diperlukan. Untuk informasi lebih detail, hubungi petugas pelayanan atau datang langsung ke kantor kelurahan.</p>\r\n\r\n<p><em>Catatan: Pada tanggal 17 Oktober 2025 (libur nasional), kantor kelurahan tutup.</em></p>', NULL, 'pengumuman', 'published', '2025-11-06 23:05:52', 1, 89, '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(3, 'Gotong Royong Bersih Lingkungan Serentak Se-Kelurahan', 'gotong-royong-bersih-lingkungan-serentak', 'Kegiatan gotong royong bersih lingkungan akan dilaksanakan pada hari Minggu, 29 Oktober 2025 pukul 07.00 WIB.', '<p>Dalam rangka menjaga kebersihan dan kesehatan lingkungan, Kelurahan Marga Sari mengajak seluruh warga untuk berpartisipasi dalam kegiatan Gotong Royong Bersih Lingkungan Serentak.</p>\r\n\r\n<h3>Detail Kegiatan</h3>\r\n<ul>\r\n<li><strong>Hari/Tanggal:</strong> Minggu, 29 Oktober 2025</li>\r\n<li><strong>Waktu:</strong> 07.00 - 10.00 WIB</li>\r\n<li><strong>Tempat:</strong> Seluruh wilayah RT/RW di Kelurahan Marga Sari</li>\r\n</ul>\r\n\r\n<h3>Kegiatan Yang Akan Dilakukan</h3>\r\n<ul>\r\n<li>Pembersihan saluran air dan selokan</li>\r\n<li>Pengangkutan sampah di area umum</li>\r\n<li>Pembersihan taman dan fasilitas umum</li>\r\n<li>Pemotongan rumput liar</li>\r\n<li>Pengecatan fasilitas umum yang perlu diperbaiki</li>\r\n</ul>\r\n\r\n<h3>Peralatan Yang Perlu Dibawa</h3>\r\n<ul>\r\n<li>Sapu dan cangkul</li>\r\n<li>Karung atau kantong sampah</li>\r\n<li>Sarung tangan</li>\r\n<li>Pakaian kerja</li>\r\n</ul>\r\n\r\n<p>Mari kita wujudkan lingkungan yang bersih, sehat, dan nyaman untuk kita semua. Partisipasi aktif dari seluruh warga sangat diharapkan.</p>\r\n\r\n<p>Untuk koordinasi lebih lanjut, hubungi Ketua RT masing-masing atau langsung ke kantor kelurahan.</p>', NULL, 'berita', 'published', '2025-11-07 03:05:52', 1, 234, '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(4, 'Sosialisasi Program Bantuan Sosial Pemerintah Tahun 2025', 'sosialisasi-program-bantuan-sosial-2025', 'Kelurahan Marga Sari akan mengadakan sosialisasi program bantuan sosial pemerintah untuk tahun 2025.', '<p>Kelurahan Marga Sari akan mengadakan sosialisasi mengenai berbagai program bantuan sosial pemerintah yang dapat diakses oleh masyarakat pada tahun 2025.</p>\r\n\r\n<h3>Waktu dan Tempat</h3>\r\n<ul>\r\n<li><strong>Hari/Tanggal:</strong> Rabu, 25 Oktober 2025</li>\r\n<li><strong>Waktu:</strong> 14.00 - 16.00 WIB</li>\r\n<li><strong>Tempat:</strong> Balai Kelurahan Marga Sari</li>\r\n</ul>\r\n\r\n<h3>Program Yang Akan Disosialisasikan</h3>\r\n<ul>\r\n<li>Program Keluarga Harapan (PKH)</li>\r\n<li>Bantuan Langsung Tunai (BLT)</li>\r\n<li>Kartu Indonesia Pintar (KIP)</li>\r\n<li>Kartu Indonesia Sehat (KIS)</li>\r\n<li>Program Sembako</li>\r\n<li>Bantuan Usaha Mikro Kecil (BUMK)</li>\r\n</ul>\r\n\r\n<p>Sosialisasi ini akan disampaikan langsung oleh tim dari Dinas Sosial Kabupaten dan petugas dari berbagai instansi terkait.</p>\r\n\r\n<p><strong>Peserta yang diharapkan hadir:</strong></p>\r\n<ul>\r\n<li>Ketua RT/RW se-kelurahan</li>\r\n<li>Perwakilan keluarga kurang mampu</li>\r\n<li>Pelaku usaha mikro dan kecil</li>\r\n<li>Masyarakat umum yang membutuhkan informasi</li>\r\n</ul>\r\n\r\n<p>Acara ini gratis dan terbuka untuk umum. Diharapkan partisipasi aktif dari seluruh warga untuk mendapatkan informasi terbaru mengenai program-program bantuan sosial.</p>', NULL, 'berita', 'draft', NULL, 1, 0, '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(5, 'asda', 'asda', 'asda', 'dsasd', 'posts/1762520825_Screenshot 2025-09-07 214310.png', 'berita', 'published', '2025-11-07 05:07:05', 1, 0, '2025-11-07 05:07:05', '2025-11-07 05:07:05'),
(6, 'sdasd', 'sdasd', 'adsad', 'asasd', 'posts/1762539763_Screenshot 2025-09-07 214216.png', 'pengumuman', 'published', '2025-11-07 10:22:43', 1, 0, '2025-11-07 10:22:43', '2025-11-07 10:22:43'),
(7, 'adsad', 'adsad', 'asdas', 'dasd', 'posts/1762539783_Screenshot 2025-09-07 214228.png', 'pengumuman', 'published', '2025-11-07 10:23:03', 1, 6, '2025-11-07 10:23:03', '2025-11-13 19:34:21'),
(8, 'sads', 'sads', 'a', 'asd', 'posts/1762569864_Screenshot 2025-09-07 214216.png', 'berita', 'published', '2025-11-07 18:44:24', 1, 0, '2025-11-07 18:44:24', '2025-11-07 18:44:24'),
(9, 'asdsa', 'asdsa', 'dsad', '<p>a</p>', 'posts/1762569937_Screenshot 2025-09-07 214251.png', 'berita', 'published', '2025-11-07 18:45:00', 1, 0, '2025-11-07 18:45:37', '2025-11-07 19:17:16'),
(10, 'asd', 'asd', 'asd', '<p>asda</p>', 'posts/1762571863_Screenshot 2025-09-22 150932.png', 'berita', 'published', '2025-11-07 19:17:52', 1, 2, '2025-11-07 19:17:43', '2025-11-13 19:34:25');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rt_code` varchar(255) NOT NULL,
  `month` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `activities` text DEFAULT NULL,
  `total_residents` int(11) DEFAULT NULL,
  `total_households` int(11) DEFAULT NULL,
  `issues` text DEFAULT NULL,
  `suggestions` text DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `status` enum('draft','submitted','reviewed','approved','rejected') NOT NULL DEFAULT 'draft',
  `admin_notes` text DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `rt_code`, `month`, `title`, `description`, `activities`, `total_residents`, `total_households`, `issues`, `suggestions`, `attachment`, `status`, `admin_notes`, `submitted_at`, `reviewed_at`, `created_at`, `updated_at`) VALUES
(1, 2, '01', '2025-11', 'sadasd', 'asd', '[{\"date\":\"2025-11-13\",\"task\":\"asda\",\"note\":\"asdasd\",\"photo\":\"reports\\/activities\\/AqM6twGQH7O9sQbZBftd9vVdSngdNTxswjk75xR6.png\"}]', NULL, NULL, 'asd', 'asdad', NULL, 'approved', 'asdad', '2025-11-13 03:47:10', '2025-11-13 03:48:00', '2025-11-13 03:47:02', '2025-11-13 03:48:00'),
(2, 3, '02', '2025-11', 'sadasda', '-', '[{\"date\":\"2025-11-16\",\"task\":\"sd\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"sdas\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asda\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-12-06\",\"task\":\"sdad\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asda\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asd\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"dasd\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asdas\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asd\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"sad\",\"note\":\"\",\"photo\":\"\"},{\"date\":\"2025-11-16\",\"task\":\"asd\",\"note\":\"\",\"photo\":\"\"}]', NULL, NULL, 'sada', 'sdasd', NULL, 'draft', NULL, NULL, NULL, '2025-11-16 02:18:36', '2025-11-16 02:18:36');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'masyarakat', 'Masyarakat', 'Warga masyarakat biasa', '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(2, 'ketua_rt', 'Ketua RT', 'Ketua Rukun Tetangga', '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(3, 'admin', 'Admin Kelurahan', 'Administrator kelurahan', '2025-11-07 05:05:52', '2025-11-07 05:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `rts`
--

CREATE TABLE `rts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rt_code` varchar(2) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `ketua_rt_name` varchar(255) DEFAULT NULL,
  `ketua_rt_phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `ketua_rt_photo` varchar(255) DEFAULT NULL,
  `ketua_rt_age` int(11) DEFAULT NULL,
  `ketua_rt_profession` varchar(255) DEFAULT NULL,
  `ketua_rt_tenure_years` int(11) DEFAULT NULL COMMENT 'Masa jabatan dalam tahun',
  `num_households` int(11) NOT NULL DEFAULT 0,
  `num_population` int(11) NOT NULL DEFAULT 0,
  `num_male` int(11) NOT NULL DEFAULT 0,
  `num_female` int(11) NOT NULL DEFAULT 0,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `boundaries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`boundaries`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mata_pencaharian` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Pedagang, Karyawan, Buruh, Lainnya dalam %' CHECK (json_valid(`mata_pencaharian`)),
  `bantuan_sosial` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'PKH, BLT, Lainnya dalam jumlah KK' CHECK (json_valid(`bantuan_sosial`)),
  `kegiatan_rutin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Pengajian, Posyandu, Kerja Bakti per bulan' CHECK (json_valid(`kegiatan_rutin`)),
  `fasilitas_umum` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Masjid, Musholla, Posyandu, Bank Sampah, Pos Ronda' CHECK (json_valid(`fasilitas_umum`)),
  `kondisi_infrastruktur` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Jalan, Saluran air, Penerangan' CHECK (json_valid(`kondisi_infrastruktur`)),
  `masalah_lingkungan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Banjir, Sampah, dll' CHECK (json_valid(`masalah_lingkungan`)),
  `tingkat_pendidikan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'SD, SMP, SMA, Kuliah dalam %' CHECK (json_valid(`tingkat_pendidikan`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rts`
--

INSERT INTO `rts` (`id`, `rt_code`, `name`, `ketua_rt_name`, `ketua_rt_phone`, `address`, `ketua_rt_photo`, `ketua_rt_age`, `ketua_rt_profession`, `ketua_rt_tenure_years`, `num_households`, `num_population`, `num_male`, `num_female`, `latitude`, `longitude`, `boundaries`, `created_at`, `updated_at`, `mata_pencaharian`, `bantuan_sosial`, `kegiatan_rutin`, `fasilitas_umum`, `kondisi_infrastruktur`, `masalah_lingkungan`, `tingkat_pendidikan`) VALUES
(1, '01', 'RT 01', 'H. Ahmad Suryadi', '0812-6676-8524', NULL, 'ketua_rt/01_1762521013.jpg', NULL, NULL, NULL, 41, 300, 80, 84, -1.2371590, 116.8260070, NULL, '2025-11-07 05:05:52', '2025-11-13 20:23:52', '{\"pedagang\":\"0.2\",\"karyawan\":\"0.1\",\"buruh\":\"0.1\",\"lainnya\":\"0.1\"}', '{\"pkh\":\"1\",\"blt\":\"1\",\"lainnya\":\"1\"}', '{\"pengajian\":\"kurang_dari_3\",\"posyandu\":\"kurang_dari_3\",\"kerja_bakti\":\"lebih_dari_3\",\"lainnya\":\"kurang_dari_3\"}', '{\"masjid\":\"1\",\"musholla\":\"1\",\"posyandu\":\"2\",\"bank_sampah\":\"1\",\"pos_ronda\":\"2\",\"lainnya\":null}', '{\"jalan\":\"baik\",\"saluran_air\":\"baik\",\"penerangan\":\"baik\"}', '{\"banjir\":true,\"sampah\":true}', '{\"sd\":\"0.1\",\"smp\":\"0.1\",\"sma\":\"0.1\",\"kuliah\":\"0.1\"}'),
(2, '02', 'RT 02', 'Budi Santoso', '0812-5066-2472', 'jl ptarafsad', NULL, NULL, NULL, NULL, 74, 370, 192, 178, -1.2395010, 116.8266470, NULL, '2025-11-07 05:05:52', '2025-11-16 02:16:46', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, '03', 'RT 03', 'Siti Nurhaliza', '0812-8255-4239', NULL, NULL, NULL, NULL, NULL, 71, 284, 148, 136, -1.2355950, 116.8185150, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, '04', 'RT 04', 'Eko Prasetyo', '0812-9375-5612', NULL, NULL, NULL, NULL, NULL, 41, 205, 100, 105, -1.2401640, 116.8233700, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, '05', 'RT 05', 'Dewi Sartika', '0812-1568-6098', NULL, NULL, NULL, NULL, NULL, 81, 405, 207, 198, -1.2346980, 116.8226720, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, '06', 'RT 06', 'Rudi Hartono', '0812-5298-3496', NULL, NULL, NULL, NULL, NULL, 62, 310, 149, 161, -1.2374870, 116.8260890, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, '07', 'RT 07', 'Sri Wahyuni', '0812-1621-4696', NULL, NULL, NULL, NULL, NULL, 41, 123, 62, 61, -1.2373130, 116.8261490, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, '08', 'RT 08', 'Agus Salim', '0812-2730-9189', NULL, NULL, NULL, NULL, NULL, 79, 237, 116, 121, -1.2372920, 116.8239110, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, '09', 'RT 09', 'Rina Marlina', '0812-3365-4511', NULL, NULL, NULL, NULL, NULL, 35, 175, 89, 86, -1.2370870, 116.8225440, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, '10', 'RT 10', 'Hendi Kusuma', '0812-5849-9199', NULL, NULL, NULL, NULL, NULL, 76, 380, 190, 190, -1.2382140, 116.8205220, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, '11', 'RT 11', 'Lisa Permata', '0812-8265-1680', NULL, NULL, NULL, NULL, NULL, 78, 390, 195, 195, -1.2403450, 116.8244890, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, '12', 'RT 12', 'Joko Widodo', '0812-8921-6192', NULL, NULL, NULL, NULL, NULL, 70, 280, 134, 146, -1.2369510, 116.8201340, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, '13', 'RT 13', 'Indah Sari', '0812-4482-9827', NULL, NULL, NULL, NULL, NULL, 51, 153, 78, 75, -1.2354090, 116.8225800, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '14', 'RT 14', 'Bambang Surya', '0812-2114-3543', NULL, NULL, NULL, NULL, NULL, 53, 159, 78, 81, -1.2354780, 116.8189220, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, '15', 'RT 15', 'Ratna Dewi', '0812-1306-7207', NULL, NULL, NULL, NULL, NULL, 60, 180, 88, 92, -1.2399870, 116.8229600, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '16', 'RT 16', 'Faisal Rahman', '0812-3078-8377', NULL, NULL, NULL, NULL, NULL, 43, 172, 86, 86, -1.2379720, 116.8175440, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '17', 'RT 17', 'Sari Melati', '0812-7287-5719', NULL, NULL, NULL, NULL, NULL, 68, 340, 170, 170, -1.2365100, 116.8216600, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, '18', 'RT 18', 'Wawan Setiawan', '0812-4950-5958', NULL, NULL, NULL, NULL, NULL, 71, 284, 148, 136, -1.2377100, 116.8245790, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '19', 'RT 19', 'Maya Indira', '0812-5620-1065', NULL, NULL, NULL, NULL, NULL, 54, 270, 130, 140, -1.2363330, 116.8262480, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, '20', 'RT 20', 'Doni Irawan', '0812-1336-6736', NULL, NULL, NULL, NULL, NULL, 55, 165, 84, 81, -1.2384820, 116.8190720, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, '21', 'RT 21', 'Nurul Fadilah', '0812-9559-4894', NULL, NULL, NULL, NULL, NULL, 76, 380, 194, 186, -1.2381560, 116.8228710, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, '22', 'RT 22', 'Tono Supriatna', '0812-7407-6735', NULL, NULL, NULL, NULL, NULL, 40, 160, 78, 82, -1.2399010, 116.8264510, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, '23', 'RT 23', 'Rini Astuti', '0812-1729-7722', NULL, NULL, NULL, NULL, NULL, 38, 114, 56, 58, -1.2355040, 116.8236550, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '24', 'RT 24', 'Adi Nugroho', '0812-3924-1806', NULL, NULL, NULL, NULL, NULL, 70, 350, 179, 171, -1.2395750, 116.8267640, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '25', 'RT 25', 'Lina Marlina', '0812-5839-6438', NULL, NULL, NULL, NULL, NULL, 70, 350, 172, 178, -1.2371510, 116.8181200, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '26', 'RT 26', 'Yudi Pranata', '0812-8701-2089', NULL, NULL, NULL, NULL, NULL, 76, 228, 119, 109, -1.2389410, 116.8247120, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '27', 'RT 27', 'Diah Permatasari', '0812-4048-9351', NULL, NULL, NULL, NULL, NULL, 53, 159, 76, 83, -1.2384230, 116.8211410, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '28', 'RT 28', 'Rizki Pratama', '0812-2166-9049', NULL, NULL, NULL, NULL, NULL, 39, 195, 101, 94, -1.2396270, 116.8242470, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '29', 'RT 29', 'Sinta Dewi', '0812-3011-6723', NULL, NULL, NULL, NULL, NULL, 63, 252, 123, 129, -1.2402690, 116.8233440, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '30', 'RT 30', 'Benny Kurniawan', '0812-4368-4644', NULL, NULL, NULL, NULL, NULL, 45, 135, 65, 70, -1.2388870, 116.8256960, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '31', 'RT 31', 'Fitri Handayani', '0812-4641-5579', NULL, NULL, NULL, NULL, NULL, 61, 244, 122, 122, -1.2397210, 116.8225390, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '32', 'RT 32', 'M. Ridwan', '0812-3511-5136', NULL, NULL, NULL, NULL, NULL, 49, 196, 100, 96, -1.2393850, 116.8238130, NULL, '2025-11-07 05:05:52', '2025-11-13 19:04:39', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `process` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `processing_days` int(11) DEFAULT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dyRTFcbTFs3Eksd801Du41WBd7pCC3jQk7JzVlqG', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTFaN3lQRFQ1NnFrT1NrWFZLdkk1UjVQT3R6QVQwZmRSaHRqVkgyZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763256951),
('nWDN05fxqFRHXVOduSO2cwYSphr6a2IL3Mki6pB5', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ3JWY2x5MERyVjNEUG43c2FRbUdncUFOeXpXbktXNHRCUlQ1WXJMWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1763258946),
('UQq5fEcPjVR4rIgnqowZGmZQfCdADU0SII3bOQZc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRjdoTjZ5d2ZyVXFIOHNXbmF1bjIxa1pQNzRjS1dKSWkwTnI3bW5JQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9maWxlIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1763259850);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `label` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `created_at`, `updated_at`) VALUES
(1, 'lurah_name', 'HENDRA JAYA PRAWIRA, S.ST', 'text', 'document', 'Nama Lurah', 'Nama Lurah Kelurahan Marga Sari yang akan muncul di dokumen/laporan', '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(2, 'kelurahan_name', 'KELURAHAN MARGA SARI', 'text', 'general', 'Nama Kelurahan', 'Nama lengkap kelurahan', '2025-11-07 05:05:52', '2025-11-07 05:05:52'),
(3, 'kelurahan_address', 'Balikpapan', 'textarea', 'general', 'Alamat Kelurahan', 'Alamat lengkap kelurahan', '2025-11-07 05:05:52', '2025-11-07 05:05:52');

-- --------------------------------------------------------

--
-- Table structure for table `sosial_media`
--

CREATE TABLE `sosial_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `struktur_organisasi`
--

CREATE TABLE `struktur_organisasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jabatan` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tentang`
--

CREATE TABLE `tentang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_kantor` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tentang`
--

INSERT INTO `tentang` (`id`, `judul`, `deskripsi`, `gambar_kantor`, `logo`, `created_at`, `updated_at`) VALUES
(1, NULL, 'asdas', NULL, NULL, '2025-11-13 19:56:13', '2025-11-13 19:56:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 1,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `rt` varchar(255) DEFAULT NULL,
  `rw` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`, `phone`, `address`, `rt`, `rw`, `is_active`) VALUES
(1, 'Admin Kelurahan', 'admin@margasari.id', '2025-11-07 05:05:52', '$2y$12$Iva6EdUEMheth08earohhOcJ987HCZod9RcOMNB0u.GqaITWaXCqO', 'UzOeIVkXf9zVtgp5yQo8m4X9hi26Tu2W691CZBFnQrhlFop1qPEQ4wweA28q', '2025-11-07 05:05:52', '2025-11-07 05:05:52', 3, NULL, NULL, NULL, NULL, 1),
(2, 'Ketua RT 01', 'ketuart01@margasari.id', '2025-11-07 05:05:52', '$2y$12$Iva6EdUEMheth08earohhOcJ987HCZod9RcOMNB0u.GqaITWaXCqO', 'YKaHa7KQOxSu9Y7oB8nDIgLoUrUG1LDSQb5BOtYjoEj1js04MAzMyBer494W', '2025-11-07 05:05:52', '2025-11-07 05:05:52', 2, NULL, NULL, '01', NULL, 1),
(3, 'Budi Santoso', 'alif1@gmail.com', NULL, '$2y$12$VHR7oheuimHHMbiVSsWBF.YpZ.kKXgLOCpM9ePg0nRmiM0bMMWbta', NULL, '2025-11-16 02:17:00', '2025-11-16 02:17:00', 2, '0812-5066-2472', 'jl ptarafsad', '02', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`),
  ADD KEY `posts_status_published_at_index` (`status`,`published_at`),
  ADD KEY `posts_type_status_index` (`type`,`status`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_user_id_foreign` (`user_id`),
  ADD KEY `reports_rt_code_month_index` (`rt_code`,`month`),
  ADD KEY `reports_status_index` (`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `rts`
--
ALTER TABLE `rts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rts_rt_code_unique` (`rt_code`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sosial_media`
--
ALTER TABLE `sosial_media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tentang`
--
ALTER TABLE `tentang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rts`
--
ALTER TABLE `rts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sosial_media`
--
ALTER TABLE `sosial_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `struktur_organisasi`
--
ALTER TABLE `struktur_organisasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tentang`
--
ALTER TABLE `tentang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

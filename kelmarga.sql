-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2025 at 05:28 PM
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
(9, '2025_09_26_235608_create_complaints_table', 1);

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
  `type` enum('berita','pengumuman','agenda') NOT NULL DEFAULT 'berita',
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
(1, 'aaaa', 'aaaa', 'aaaa', 'aaaaaaaaaaaaaaaaaaaaa', 'posts/1758948784_Screenshot 2025-09-07 214228.png', 'berita', 'published', '2025-09-26 20:53:04', 1, 1, '2025-09-26 20:53:04', '2025-09-27 20:01:12');

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
(1, 'admin', 'Admin Kelurahan', 'Administrator kelurahan', '2025-09-26 20:52:03', '2025-09-26 20:52:03');

-- --------------------------------------------------------

--
-- Table structure for table `rts`
--

CREATE TABLE `rts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rt_code` varchar(3) NOT NULL,
  `rw_code` varchar(3) NOT NULL DEFAULT '001',
  `name` varchar(255) DEFAULT NULL,
  `ketua_rt_name` varchar(255) DEFAULT NULL,
  `ketua_rt_phone` varchar(255) DEFAULT NULL,
  `num_households` int(11) NOT NULL DEFAULT 0,
  `num_population` int(11) NOT NULL DEFAULT 0,
  `num_male` int(11) NOT NULL DEFAULT 0,
  `num_female` int(11) NOT NULL DEFAULT 0,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `boundaries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`boundaries`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rts`
--

INSERT INTO `rts` (`id`, `rt_code`, `rw_code`, `name`, `ketua_rt_name`, `ketua_rt_phone`, `num_households`, `num_population`, `num_male`, `num_female`, `latitude`, `longitude`, `boundaries`, `created_at`, `updated_at`) VALUES
(1, '001', '001', 'RT 001 / RW 001', 'H. Ahmad Suryadi', '0812-3098-4779', 44, 220, 110, 110, -1.2347558, 116.8200807, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(2, '002', '001', 'RT 002 / RW 001', 'Budi Santoso', '0812-5850-6790', 76, 228, 119, 109, -1.2368000, 116.8341000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(3, '003', '001', 'RT 003 / RW 001', 'Siti Nurhaliza', '0812-6744-9685', 45, 225, 115, 110, -1.2334000, 116.8283000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(4, '004', '001', 'RT 004 / RW 001', 'Eko Prasetyo', '0812-7513-5552', 67, 201, 105, 96, -1.2331000, 116.8331000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(5, '005', '002', 'RT 005 / RW 002', 'Dewi Sartika', '0812-5823-5678', 54, 270, 135, 135, -1.2366000, 116.8392000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(6, '006', '002', 'RT 006 / RW 002', 'Rudi Hartono', '0812-3320-2596', 40, 120, 61, 59, -1.2362000, 116.8484000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(7, '007', '002', 'RT 007 / RW 002', 'Sri Wahyuni', '0812-7831-6066', 43, 129, 62, 67, -1.2335000, 116.8415000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(8, '008', '002', 'RT 008 / RW 002', 'Agus Salim', '0812-2985-9952', 71, 355, 170, 185, -1.2340000, 116.8471000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(9, '009', '003', 'RT 009 / RW 003', 'Rina Marlina', '0812-8416-8294', 80, 240, 125, 115, -1.2395000, 116.8546000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(10, '010', '003', 'RT 010 / RW 003', 'Hendi Kusuma', '0812-1994-6059', 72, 288, 144, 144, -1.2387000, 116.8604000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(11, '011', '003', 'RT 011 / RW 003', 'Lisa Permata', '0812-1050-2970', 71, 284, 142, 142, -1.2337000, 116.8522000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(12, '012', '003', 'RT 012 / RW 003', 'Joko Widodo', '0812-8530-6960', 74, 370, 178, 192, -1.2325000, 116.8604000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(13, '013', '004', 'RT 013 / RW 004', 'Indah Sari', '0812-5091-1220', 75, 300, 147, 153, -1.2393000, 116.8669000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(14, '014', '004', 'RT 014 / RW 004', 'Bambang Surya', '0812-9559-6380', 65, 260, 125, 135, -1.2393000, 116.8716000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(15, '015', '004', 'RT 015 / RW 004', 'Ratna Dewi', '0812-8121-2725', 62, 186, 89, 97, -1.2352000, 116.8663000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(16, '016', '004', 'RT 016 / RW 004', 'Faisal Rahman', '0812-3475-1005', 41, 205, 105, 100, -1.2359000, 116.8706000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(17, '017', '005', 'RT 017 / RW 005', 'Sari Melati', '0812-9884-5506', 53, 212, 108, 104, -1.2294000, 116.8303000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(18, '018', '005', 'RT 018 / RW 005', 'Wawan Setiawan', '0812-1352-5909', 83, 332, 159, 173, -1.2280000, 116.8336000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(19, '019', '005', 'RT 019 / RW 005', 'Maya Indira', '0812-1504-9295', 64, 320, 157, 163, -1.2248000, 116.8280000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(20, '020', '005', 'RT 020 / RW 005', 'Doni Irawan', '0812-9975-3050', 39, 117, 61, 56, -1.2250000, 116.8355000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(21, '021', '006', 'RT 021 / RW 006', 'Nurul Fadilah', '0812-1296-3547', 55, 220, 112, 108, -1.2301000, 116.8397000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(22, '022', '006', 'RT 022 / RW 006', 'Tono Supriatna', '0812-3936-2222', 75, 375, 195, 180, -1.2283000, 116.8478000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(23, '023', '006', 'RT 023 / RW 006', 'Rini Astuti', '0812-7357-6481', 53, 159, 83, 76, -1.2264000, 116.8404000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(24, '024', '006', 'RT 024 / RW 006', 'Adi Nugroho', '0812-3322-4274', 61, 305, 156, 149, -1.2243000, 116.8488000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(25, '025', '007', 'RT 025 / RW 007', 'Lina Marlina', '0812-5349-3063', 58, 232, 116, 116, -1.2308000, 116.8523000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(26, '026', '007', 'RT 026 / RW 007', 'Yudi Pranata', '0812-1551-1491', 82, 246, 123, 123, -1.2319000, 116.8604000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(27, '027', '007', 'RT 027 / RW 007', 'Diah Permatasari', '0812-3412-7211', 45, 135, 68, 67, -1.2271000, 116.8538000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(28, '028', '007', 'RT 028 / RW 007', 'Rizki Pratama', '0812-8428-5791', 78, 390, 187, 203, -1.2256000, 116.8582000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(29, '029', '008', 'RT 029 / RW 008', 'Sinta Dewi', '0812-8586-6088', 40, 200, 100, 100, -1.2305000, 116.8661000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(30, '030', '008', 'RT 030 / RW 008', 'Benny Kurniawan', '0812-4651-6754', 53, 212, 110, 102, -1.2291000, 116.8727000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(31, '031', '008', 'RT 031 / RW 008', 'Fitri Handayani', '0812-2280-5659', 73, 365, 175, 190, -1.2275000, 116.8644000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35'),
(32, '032', '008', 'RT 032 / RW 008', 'M. Ridwan', '0812-3632-4405', 79, 395, 190, 205, -1.2246000, 116.8709000, NULL, '2025-09-26 20:04:03', '2025-09-26 20:04:35');

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
('jnjcUVkZ0QxI7sXX9vUJNQpkNctICN88iJYwivIz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWUxXWXlRWEYxY25tbnBhOTdHa3ltYzl1UmNMellEa0NybFlhNURBTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5nYWR1YW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1759505268);

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
(1, 'Admin Kelurahan Margasari', 'admin@kelurahan.id', NULL, '$2y$12$7N8PePV.iQRfYm.MoGqQ8.oDYAajGxLYJALGlbx.Z4wSQtXZjEA4m', NULL, '2025-09-26 20:52:03', '2025-09-26 20:52:03', 1, NULL, NULL, NULL, NULL, 1);

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
  ADD UNIQUE KEY `rts_rt_code_unique` (`rt_code`),
  ADD KEY `rts_rw_code_index` (`rw_code`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

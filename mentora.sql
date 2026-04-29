-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 04:09 AM
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
-- Database: `mentora`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-kevintanwiputra@gmail.com|10.68.107.58', 'i:2;', 1777014925),
('laravel-cache-kevintanwiputra@gmail.com|10.68.107.58:timer', 'i:1777014925;', 1777014925),
('laravel-cache-kevinx.tanx@gmail.com|10.68.105.254', 'i:1;', 1777005133),
('laravel-cache-kevinx.tanx@gmail.com|10.68.105.254:timer', 'i:1777005133;', 1777005133),
('laravel-cache-kimmyyonata24@gmail.com|10.68.109.8', 'i:1;', 1777015057),
('laravel-cache-kimmyyonata24@gmail.com|10.68.109.8:timer', 'i:1777015057;', 1777015057);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
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
(4, '2026_04_08_092118_create_study_sessions_table', 2),
(5, '2026_04_10_065600_create_study_sessions_table', 3),
(6, '2026_04_24_035137_add_google_id_to_users_table', 4),
(7, '2026_04_24_061923_add_role_to_users_table', 5),
(8, '2026_04_24_061924_create_study_groups_table', 5);

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
('UzA8h8jZLF1OabMPTyIaDnZRmRe1Q852RsTQL0NE', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJFT0pYS054bWpXcXZ1aDdYUXlPNmlsSlMwbzJWaXZQeUFlOXUyS2kzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9zdHVkeS1yb29tIiwicm91dGUiOiJzdHVkeS1yb29tIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1777428335);

-- --------------------------------------------------------

--
-- Table structure for table `study_groups`
--

CREATE TABLE `study_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_groups`
--

INSERT INTO `study_groups` (`id`, `name`, `subject`, `slug`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 'SNBT Gacor', 'Literasi', 'snbt-gacor-XI6mt', 1, '2026-04-24 00:11:59', '2026-04-24 00:11:59'),
(7, 'SNBT Turu', 'Literasi', 'snbt-turu-7Sika', 1, '2026-04-27 01:32:44', '2026-04-27 01:32:44'),
(8, 'Belajar', 'Literasi', 'belajar-wYSvg', 1, '2026-04-27 01:36:26', '2026-04-27 01:36:26'),
(13, 'Belajar dari malam sampai pagi ketemu pagi lagi', 'Semua', 'belajar-dari-malam-sampai-pagi-ketemu-pagi-lagi-0IZpY', 1, '2026-04-28 18:29:12', '2026-04-28 18:29:12');

-- --------------------------------------------------------

--
-- Table structure for table `study_sessions`
--

CREATE TABLE `study_sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_sessions`
--

INSERT INTO `study_sessions` (`id`, `user_id`, `category`, `duration`, `created_at`, `updated_at`) VALUES
(1, 1, 'focus', 25, '2026-04-12 19:38:05', '2026-04-12 19:38:05'),
(2, 1, 'focus', 25, '2026-04-12 19:39:30', '2026-04-12 19:39:30'),
(3, 1, 'focus', 25, '2026-04-12 20:08:23', '2026-04-12 20:08:23'),
(4, 1, 'focus', 25, '2026-04-12 20:12:10', '2026-04-12 20:12:10'),
(5, 1, 'focus', 25, '2026-04-12 20:16:48', '2026-04-12 20:16:48'),
(6, 1, 'focus', 25, '2026-04-12 20:20:26', '2026-04-12 20:20:26'),
(7, 1, 'focus', 25, '2026-04-12 20:25:30', '2026-04-12 20:25:30'),
(8, 1, 'focus', 25, '2026-04-12 20:27:51', '2026-04-12 20:27:51'),
(9, 1, 'focus', 25, '2026-04-12 20:28:49', '2026-04-12 20:28:49'),
(10, 1, 'focus', 25, '2026-04-12 20:30:18', '2026-04-12 20:30:18'),
(11, 1, 'focus', 25, '2026-04-12 20:32:54', '2026-04-12 20:32:54'),
(12, 1, 'focus', 25, '2026-04-12 20:34:27', '2026-04-12 20:34:27'),
(13, 1, 'focus', 25, '2026-04-12 20:37:03', '2026-04-12 20:37:03'),
(14, 1, 'focus', 25, '2026-04-12 20:37:13', '2026-04-12 20:37:13'),
(15, 1, 'focus', 25, '2026-04-12 20:39:37', '2026-04-12 20:39:37'),
(16, 1, 'focus', 25, '2026-04-27 02:23:51', '2026-04-27 02:23:51'),
(17, 1, 'focus', 25, '2026-04-28 00:11:21', '2026-04-28 00:11:21'),
(18, 1, 'focus', 25, '2026-04-28 01:04:31', '2026-04-28 01:04:31'),
(19, 1, 'focus', 25, '2026-04-28 01:04:47', '2026-04-28 01:04:47'),
(20, 1, 'focus', 25, '2026-04-28 18:34:51', '2026-04-28 18:34:51'),
(21, 1, 'focus', 25, '2026-04-28 18:35:31', '2026-04-28 18:35:31'),
(22, 1, 'focus', 25, '2026-04-28 18:35:37', '2026-04-28 18:35:37'),
(23, 1, 'focus', 25, '2026-04-28 18:35:42', '2026-04-28 18:35:42'),
(24, 1, 'focus', 25, '2026-04-28 18:37:01', '2026-04-28 18:37:01'),
(25, 1, 'focus', 25, '2026-04-28 18:37:44', '2026-04-28 18:37:44'),
(26, 1, 'focus', 25, '2026-04-28 18:38:01', '2026-04-28 18:38:01'),
(27, 1, 'focus', 25, '2026-04-28 18:38:33', '2026-04-28 18:38:33'),
(28, 1, 'focus', 25, '2026-04-28 18:38:52', '2026-04-28 18:38:52'),
(29, 1, 'focus', 25, '2026-04-28 18:39:22', '2026-04-28 18:39:22'),
(30, 1, 'focus', 25, '2026-04-28 18:39:47', '2026-04-28 18:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','tutor','user') NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '116522587757057005169', 'Kei', 'kevin.tanwiputra@gmail.com', 'user', NULL, '$2y$12$0orCB4dOMu/TvxYXhnPXhOV2/Bgyzzip1oP38DYLXKxsMzPTS3oRu', NULL, '2026-04-09 23:49:38', '2026-04-28 00:04:40'),
(2, NULL, 'Kevin Tanwiputra', 'kevinx.tanx@gmail.com', 'user', NULL, '$2y$12$heLpJFODI8VxAdgctSENCeGTnXQBGC7SQ4Dzs8XuYQHbwLhyMpXdm', NULL, '2026-04-23 21:17:06', '2026-04-23 21:17:06'),
(3, NULL, 'Kei', 'takeivina@gmail.com', 'user', NULL, '$2y$12$I6OwIXd2/TDKzAPDtlLt3uerCBx/hpZGn2yUbRmArf.jPIzHUi2GG', NULL, '2026-04-23 21:31:34', '2026-04-23 21:31:34'),
(4, NULL, 'Gabriel Martin Prasona', 'gabmar1505@gmail.com', 'user', NULL, '$2y$12$rl4p1iop7TQ.SXcPdB4n.uEOR.NB/3AMQh/P8iZo1DeQsOsWQjDcC', NULL, '2026-04-24 00:16:49', '2026-04-24 00:16:49'),
(5, NULL, 'Donat Kentang Bubuk Full Cream', 'kim@gmail.com', 'user', NULL, '$2y$12$.kvet1UT5h2qFMLtHVPchOdjWs91ZkL2wmnlUSj.GSZrwzAF0Tjm6', NULL, '2026-04-24 00:16:59', '2026-04-24 00:16:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

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
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `study_groups`
--
ALTER TABLE `study_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `study_groups_slug_unique` (`slug`),
  ADD KEY `study_groups_created_by_foreign` (`created_by`);

--
-- Indexes for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_sessions_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `study_groups`
--
ALTER TABLE `study_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `study_sessions`
--
ALTER TABLE `study_sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `study_groups`
--
ALTER TABLE `study_groups`
  ADD CONSTRAINT `study_groups_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `study_sessions`
--
ALTER TABLE `study_sessions`
  ADD CONSTRAINT `study_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

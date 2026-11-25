-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 06:56 AM
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
-- Database: `findit_db`
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
-- Table structure for table `claim_requests`
--

CREATE TABLE `claim_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `match_id` bigint(20) UNSIGNED NOT NULL,
  `proof_description` text NOT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `admin_remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `claim_requests`
--

INSERT INTO `claim_requests` (`id`, `user_id`, `item_id`, `match_id`, `proof_description`, `proof_image`, `status`, `admin_remarks`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 8, 'phone with black case', NULL, 'approved', NULL, '2026-05-17 05:14:00', '2026-05-17 05:14:20'),
(2, 1, 7, 14, 'ID name: ANDRIAN C. ALANA', NULL, 'approved', NULL, '2026-05-19 08:20:17', '2026-05-19 08:21:17');

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
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('lost','found') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date_reported` date NOT NULL,
  `time_reported` time NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','claimed','resolved') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `type`, `title`, `description`, `category`, `location`, `date_reported`, `time_reported`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 'found', 'Iphone 13 pro max', 'asdsadad', 'Electronics', 'Parking Area', '2026-05-17', '10:00:00', 'items/N6QibcTwCACYhrq8OnfeRjdb1vApLsEupsrNNe1S.png', 'active', '2026-05-17 00:20:15', '2026-05-17 00:20:15'),
(3, 2, 'found', 'Iphone 13 pro max', 'asdsadad', 'Electronics', 'Parking Area', '2026-05-18', '00:00:00', 'items/D531WykDdzMqvcoqM14x2Ypcek9EQv8FoegXsAmh.png', 'active', '2026-05-17 00:21:57', '2026-05-17 00:21:57'),
(4, 3, 'found', 'Iphone 13 pro max', NULL, 'Electronics', 'Parking Area', '2026-05-18', '00:01:00', NULL, 'active', '2026-05-17 04:38:35', '2026-05-17 04:38:35'),
(5, 1, 'lost', 'phone', NULL, 'Electronics', 'College of Technology', '2026-05-10', '12:00:00', NULL, 'claimed', '2026-05-17 05:11:59', '2026-05-17 05:14:20'),
(6, 3, 'found', 'phone', NULL, 'Electronics', 'College of Technology', '2026-05-10', '13:00:00', NULL, 'active', '2026-05-17 05:12:49', '2026-05-17 05:12:49'),
(7, 1, 'lost', 'CTU ID School ID', 'Andrian C. Alana\r\n5231484 ID number', 'ID/Cards', 'Library', '2026-05-01', '14:00:00', NULL, 'claimed', '2026-05-19 08:16:42', '2026-05-19 08:21:17'),
(8, 3, 'found', 'CTU ID School ID', NULL, 'ID/Cards', 'Cafeteria', '2026-05-01', '15:17:00', NULL, 'active', '2026-05-19 08:18:06', '2026-05-19 08:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `item_matches`
--

CREATE TABLE `item_matches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lost_item_id` bigint(20) UNSIGNED NOT NULL,
  `found_item_id` bigint(20) UNSIGNED NOT NULL,
  `location_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `date_time_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `category_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `total_score` decimal(5,2) NOT NULL DEFAULT 0.00,
  `match_level` enum('high','possible','low') NOT NULL,
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_matches`
--

INSERT INTO `item_matches` (`id`, `lost_item_id`, `found_item_id`, `location_score`, `date_time_score`, `category_score`, `total_score`, `match_level`, `status`, `created_at`, `updated_at`) VALUES
(4, 5, 2, 0.00, 40.00, 100.00, 42.00, 'possible', 'pending', '2026-05-17 05:11:59', '2026-05-17 05:11:59'),
(5, 5, 3, 0.00, 20.00, 100.00, 36.00, 'low', 'pending', '2026-05-17 05:11:59', '2026-05-17 05:11:59'),
(6, 5, 4, 0.00, 20.00, 100.00, 36.00, 'low', 'pending', '2026-05-17 05:11:59', '2026-05-17 05:11:59'),
(8, 5, 6, 100.00, 100.00, 100.00, 100.00, 'high', 'pending', '2026-05-17 05:12:49', '2026-05-17 05:12:49'),
(9, 7, 2, 0.00, 0.00, 0.00, 0.00, 'low', 'pending', '2026-05-19 08:16:43', '2026-05-19 08:16:43'),
(10, 7, 3, 0.00, 0.00, 0.00, 0.00, 'low', 'pending', '2026-05-19 08:16:43', '2026-05-19 08:16:43'),
(11, 7, 4, 0.00, 0.00, 0.00, 0.00, 'low', 'pending', '2026-05-19 08:16:43', '2026-05-19 08:16:43'),
(12, 7, 6, 0.00, 20.00, 0.00, 6.00, 'low', 'pending', '2026-05-19 08:16:43', '2026-05-19 08:16:43'),
(14, 7, 8, 0.00, 100.00, 100.00, 60.00, 'possible', 'pending', '2026-05-19 08:18:06', '2026-05-19 08:18:06');

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
(4, '2026_05_17_073510_add_role_to_users_table', 1),
(5, '2026_05_17_073523_create_items_table', 1),
(6, '2026_05_17_073535_create_item_matches_table', 1),
(7, '2026_05_17_073553_create_claim_requests_table', 1),
(8, '2026_05_17_073604_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `reference_id`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'Claim Submitted', 'Your claim request has been submitted and is pending review.', 'claim', 8, 1, '2026-05-17 05:14:00', '2026-06-02 07:47:13'),
(2, 1, 'Claim Approved!', 'Your claim for \"phone\" has been approved!', 'claim_approved', 1, 0, '2026-05-17 05:14:20', '2026-05-17 05:14:20'),
(3, 1, 'Claim Submitted', 'Your claim request has been submitted and is pending review.', 'claim', 14, 0, '2026-05-19 08:20:17', '2026-05-19 08:20:17'),
(4, 1, 'Claim Approved!', 'Your claim for \"CTU ID School ID\" has been approved!', 'claim_approved', 2, 0, '2026-05-19 08:21:17', '2026-05-19 08:21:17');

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
('fglXeyp2E6hV8lrpjyi21lNa2NBgYOnY5r5ndOpf', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1gzNmZuR3Jtd1pCR002NVdNajhKczNYUTlmUXFUWmZ2TVphUWJoRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783962543),
('lr8Aa8DZpxJPYH5c0x3oC2fFW9i95cXIxK5I3yQo', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoieEpGdndpY3Vjajk3VzFYUFNPR2k0RjdFRlFNOG4zT0hiZmxzbGNYVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1783962168),
('qXSLCPrcV5dzCoN6GH7HAWasLpv9eQcSuaFlHENS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSVZrREhUeTNwOHJGVFRQRXI1djJ2d3lkUVNVUHpINnZ2MXdXVldwMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1783962918),
('uRx8awlk81ETTvzNiDn4nMJCW9b4bfzLpCprvhrq', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzdFNGJoZFdGZnEzVTBJbk9RQnk4eFFDRXB5UjZiT1dVN1VtYWpMdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1783355146),
('YLAhjEovzjslVFtJvQhIF4Po6d5cScTXDeGM8OCP', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidG44UVlSMkFiWUJuZHA3RVBGR0NVelpwelJ4czlNdmM0N2EzNVZHcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1783962127);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `id_number`, `contact_number`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Andrian Alaña', '5231484', '09661806898', 'caparida.ryan12@gmail.com', 'user', NULL, '$2y$12$vsDNF1.BS/2RHM7u.KrvLOcTezjSz512PBPZZIgGijM3mThTMh1/K', NULL, '2026-05-17 00:00:04', '2026-05-17 00:00:04'),
(2, 'Admin', 'ADMIN-001', '09000000000', 'admin@findit.com', 'admin', NULL, '$2y$12$pD2woLs01r70C4xm/mU6k.DvUeDACnwWdr5khH3ggElB.WmIvlYdG', 'dgeLjRb713hj4D0APi5WvlM8cdWlQ84TXwXrBoNRUTYqPncQ5jsZabb75GTH', '2026-05-17 00:01:04', '2026-05-17 00:01:04'),
(3, 'testFindit', '1234567', '12345678901', 'testfindit@hit.com', 'user', NULL, '$2y$12$VwXq77wFLierlYM9i8mzWOgTbYvvFWSWKYU9jJtBAD5zQ5PqtYHce', NULL, '2026-05-17 04:33:04', '2026-05-17 04:33:04'),
(4, 'Test User', '2024-001', '09111111111', 'test@findit.com', 'user', NULL, '$2y$12$oEfJpP/SkxhWgX6yJSM2XOW.ua2t40L.IRqW/2Fklg.6eBguEZM2K', NULL, '2026-05-17 04:35:14', '2026-05-17 04:35:14');

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
-- Indexes for table `claim_requests`
--
ALTER TABLE `claim_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `claim_requests_user_id_foreign` (`user_id`),
  ADD KEY `claim_requests_item_id_foreign` (`item_id`),
  ADD KEY `claim_requests_match_id_foreign` (`match_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_user_id_foreign` (`user_id`);

--
-- Indexes for table `item_matches`
--
ALTER TABLE `item_matches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_matches_lost_item_id_foreign` (`lost_item_id`),
  ADD KEY `item_matches_found_item_id_foreign` (`found_item_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `claim_requests`
--
ALTER TABLE `claim_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `item_matches`
--
ALTER TABLE `item_matches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `claim_requests`
--
ALTER TABLE `claim_requests`
  ADD CONSTRAINT `claim_requests_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claim_requests_match_id_foreign` FOREIGN KEY (`match_id`) REFERENCES `item_matches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `claim_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `item_matches`
--
ALTER TABLE `item_matches`
  ADD CONSTRAINT `item_matches_found_item_id_foreign` FOREIGN KEY (`found_item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `item_matches_lost_item_id_foreign` FOREIGN KEY (`lost_item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

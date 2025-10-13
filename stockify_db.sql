-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Okt 2025 pada 14.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stockify_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Pakaian', NULL, '2025-09-22 11:04:53', '2025-09-22 11:04:53'),
(2, 'Elektronik', NULL, '2025-09-22 11:05:02', '2025-09-22 11:05:02'),
(3, 'Makanan', NULL, '2025-09-24 06:24:32', '2025-09-24 06:24:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(23, '2014_10_12_000000_create_users_table', 1),
(24, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(25, '2019_08_19_000000_create_failed_jobs_table', 1),
(26, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(27, '2025_09_17_000100_add_role_to_users_table', 1),
(28, '2025_09_17_010000_create_categories_table', 1),
(29, '2025_09_17_010100_create_suppliers_table', 1),
(30, '2025_09_17_010200_create_products_table', 1),
(31, '2025_09_17_010300_create_product_attributes_table', 1),
(32, '2025_09_17_020000_create_stock_transactions_table', 1),
(33, '2025_09_18_000200_add_last_login_at_to_users_table', 1),
(34, '2025_10_04_090014_create_settings_table', 2),
(35, '2025_10_08_090808_add_lock_fields_to_products_table', 3),
(36, '2025_10_09_134230_add_avatar_to_users_table', 3),
(37, '2025_10_09_143201_add_hidden_fields_to_products_table', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `purchase_price` decimal(15,2) NOT NULL,
  `selling_price` decimal(15,2) NOT NULL,
  `is_fixed` tinyint(1) NOT NULL DEFAULT 0,
  `locked_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`locked_fields`)),
  `locked_for` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`locked_for`)),
  `hidden_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hidden_fields`)),
  `hidden_for` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`hidden_for`)),
  `image` varchar(255) DEFAULT NULL,
  `minimum_stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `name`, `sku`, `description`, `stock`, `purchase_price`, `selling_price`, `is_fixed`, `locked_fields`, `locked_for`, `hidden_fields`, `hidden_for`, `image`, `minimum_stock`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Kaos Polos', 'KPS001', 'Kaos katun berkualitas tinggi', 95, 50000.00, 75000.00, 1, '[]', '[]', NULL, NULL, 'product_images/Gr3HoQlrbyFZd6Uhd7Hjvu84AA4obKdGNmG6YagH.webp', 10, '2025-09-22 11:08:12', '2025-10-10 10:03:16'),
(2, 2, 3, 'HP ROG', 'KPS002', 'Dambaan para gamers', 50, 10000000.00, 12000000.00, 1, '[]', '[]', NULL, NULL, 'product_images/lfYKKaFPiO2pDyijVwuftFwhQxiYFH3dnuuR7ZC2.webp', 5, '2025-09-22 11:12:11', '2025-10-10 06:42:33'),
(3, 3, 2, 'Nasi Goreng Spesial', 'MKN001', 'Nasi goreng dengan ayam dan sayuran segar', 50, 20000.00, 30000.00, 1, '[]', '[]', '[]', '[]', 'product_images/7XeHvpk4z5YdYqPYX8vGkYZaGdcEzGQBKHQ3tjsQ.jpg', 5, '2025-09-24 06:28:33', '2025-10-10 10:27:57'),
(9, 1, 2, 'Kaos Polos', 'OnqdkR', 'dawd', 2, 12.00, 13.00, 0, '[]', '[]', '[\"supplier_id\",\"purchase_price\",\"attributes\"]', '[\"staff\"]', NULL, 3, '2025-09-26 19:40:59', '2025-10-10 06:43:35'),
(13, 1, 3, 'Test01', 'zJO4m0', 'aiueo', 50, 20000.00, 25000.00, 0, '[]', '[]', '[\"supplier_id\",\"attributes\"]', '[\"manager\",\"staff\"]', NULL, 15, '2025-09-28 20:34:17', '2025-10-10 08:01:19'),
(15, 2, 2, 'Test02', 'TST002', 'aiueo', 10, 2000.00, 5000.00, 0, '[]', '[]', '[\"purchase_price\",\"attributes\"]', '[\"manager\",\"staff\"]', NULL, 5, '2025-10-10 09:18:42', '2025-10-10 09:18:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(36, 2, 'Ukuran', '6 inci', '2025-09-28 22:03:56', '2025-09-28 22:03:56'),
(37, 2, 'Warna', 'Hitam Putih', '2025-09-28 22:03:56', '2025-09-28 22:03:56'),
(38, 1, 'Ukuran', 'M', '2025-09-28 22:14:07', '2025-09-28 22:14:07'),
(39, 1, 'Warna', 'Biru', '2025-09-28 22:14:07', '2025-09-28 22:14:07'),
(43, 9, 'Berat', '500gr', '2025-10-10 06:43:35', '2025-10-10 06:43:35'),
(47, 15, 'Bentuk', 'Bulat', '2025-10-10 09:18:42', '2025-10-10 09:18:42'),
(48, 13, 'Ukuran', 'XL', '2025-10-10 10:04:10', '2025-10-10 10:04:10'),
(51, 3, 'Berat', '500gr', '2025-10-10 10:27:57', '2025-10-10 10:27:57'),
(52, 3, 'Rasa', 'Pedas', '2025-10-10 10:27:57', '2025-10-10 10:27:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', '\"Stockify\"', '2025-10-04 02:08:32', '2025-10-10 12:08:11'),
(2, 'default_email', 'admin@stockify.com', '2025-10-04 02:08:33', '2025-10-04 02:08:33'),
(3, 'theme_mode', 'dark', '2025-10-04 02:08:33', '2025-10-04 02:08:33'),
(4, 'default_hidden_fields', '[\"sku\",\"minimum_stock\",\"purchase_price\",\"attributes\"]', '2025-10-10 09:50:46', '2025-10-10 12:07:38'),
(5, 'default_hidden_for', '[\"manager\",\"staff\"]', '2025-10-10 09:50:46', '2025-10-10 12:07:38'),
(6, 'admin_email', '\"admin@stockify.com\"', '2025-10-10 12:08:11', '2025-10-10 12:08:11'),
(7, 'logo_url', NULL, '2025-10-10 12:08:11', '2025-10-10 12:08:11'),
(8, 'dark_mode_default', 'false', '2025-10-10 12:08:11', '2025-10-10 12:08:11'),
(9, 'show_logo_sidebar', 'true', '2025-10-10 12:08:11', '2025-10-10 12:08:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('in','out') NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL,
  `status` enum('pending','completed','canceled') NOT NULL DEFAULT 'completed',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product_id`, `user_id`, `type`, `quantity`, `date`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'in', 10, '2025-09-29', 'completed', NULL, '2025-09-28 18:34:23', '2025-09-28 18:34:23'),
(2, 1, 2, 'out', 5, '2025-09-29', 'completed', NULL, '2025-09-28 18:34:45', '2025-09-28 18:34:45'),
(3, 2, 2, 'in', 5, '2025-09-29', 'completed', NULL, '2025-09-28 18:35:00', '2025-09-28 18:35:00'),
(4, 1, 2, 'out', 5, '2025-09-29', 'completed', NULL, '2025-09-28 18:35:30', '2025-09-28 18:35:30'),
(5, 2, 2, 'out', 5, '2025-09-29', 'completed', NULL, '2025-09-28 18:35:37', '2025-09-28 18:35:37'),
(6, 9, 2, 'out', 3, '2025-09-29', 'completed', NULL, '2025-09-28 18:58:17', '2025-09-28 18:58:17'),
(8, 1, 3, 'out', 5, '2025-10-02', 'pending', 'pengiriman', '2025-10-02 01:16:31', '2025-10-02 01:16:31'),
(9, 13, 3, 'in', 12, '2025-10-02', 'pending', 'pengiriman', '2025-10-02 01:17:12', '2025-10-02 01:17:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `address`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Supplier Pakaian A', NULL, NULL, NULL, '2025-09-22 11:06:27', '2025-09-24 06:25:24'),
(2, 'Supplier Makanan A', NULL, NULL, NULL, '2025-09-24 06:25:06', '2025-09-24 06:25:06'),
(3, 'Supplier Elektronik A', NULL, NULL, NULL, '2025-09-24 06:25:44', '2025-09-24 06:25:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','manager','staff') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `last_login_at`, `created_at`, `updated_at`, `role`) VALUES
(1, 'YS', 'admin@stockify.com', NULL, NULL, '$2y$12$fypkV1wk9b2.ykMQGvNZa.lE12E8rVO9NgNY9/2jM8SJImCgZG8Va', NULL, NULL, '2025-09-22 10:59:18', '2025-09-22 10:59:54', 'admin'),
(2, 'Alfian', 'manager@stockify.com', NULL, NULL, '$2y$12$eFRh4EpNf4GarIoA11BxG.RiRQy3ydMlQT9hf23b.wElYMifz.kOa', NULL, NULL, '2025-09-22 11:13:01', '2025-09-22 11:14:21', 'manager'),
(3, 'Fadrian', 'staff@stockify.com', NULL, NULL, '$2y$12$91kbhZgWZyfQki9o6Z1wke122yC5qG/PwK90Z75LO2jN/J/NzYsNC', NULL, NULL, '2025-09-22 11:15:23', '2025-10-10 10:07:24', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`);

--
-- Indeks untuk tabel `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_attributes_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_transactions_product_id_foreign` (`product_id`),
  ADD KEY `stock_transactions_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD CONSTRAINT `stock_transactions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

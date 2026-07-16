-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2026 at 08:29 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_arc_ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `title`, `image`, `link`, `is_active`, `sort_order`) VALUES
(1, 'Promo Spesial Pastry Homemade', 'banner_1.png', NULL, 1, 1),
(2, 'Nasi Box Favorit, Cocok untuk Acara', 'banner_2.png', NULL, 1, 2),
(3, 'Kelezatan Tradisional Minangkabau', 'banner_3.png', NULL, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`) VALUES
(1, 2, '2026-07-15 15:31:48'),
(2, 3, '2026-07-16 06:05:44');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`) VALUES
(2, 1, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(120) COLLATE utf8mb4_general_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `created_at`) VALUES
(1, 'Pastry', 'pastry', 'cake-candles', '2026-07-16 06:18:49'),
(2, 'Nasi Box', 'nasi-box', 'utensils', '2026-07-16 06:18:49'),
(3, 'Snack Box', 'snack-box', 'cookie', '2026-07-16 06:18:49'),
(4, 'Makanan Berat', 'makanan-berat', 'bowl-food', '2026-07-16 06:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `order_code` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  `shipping_method_id` int NOT NULL,
  `shipping_address` text COLLATE utf8mb4_general_ci,
  `subtotal` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `status` enum('pending','diproses','dikirim','selesai','dibatalkan') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_code`, `user_id`, `shipping_method_id`, `shipping_address`, `subtotal`, `shipping_cost`, `total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'ORD-20260715-4C29B0', 2, 1, 'Jl. Test No. 123, Padang', 50000.00, 0.00, 50000.00, 'diproses', 'Tolong dikirim sore', '2026-07-15 15:32:04', '2026-07-15 15:33:47'),
(2, 'ORD-20260716-3DAD7A', 3, 2, 'Jln. Siti Manggopoh', 46000.00, 15000.00, 61000.00, 'selesai', 'Bungkus ya', '2026-07-16 06:06:56', '2026-07-16 06:14:03'),
(3, 'ORD-20260716-ABCAF2', 3, 2, 'Lubuk begalung', 105000.00, 15000.00, 120000.00, 'selesai', 'ABC', '2026-07-16 07:01:01', '2026-07-16 07:02:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`) VALUES
(1, 1, 4, 'Nasi Box Ayam Bakar', 25000.00, 2, 50000.00),
(2, 2, 1, 'Croissant Butter', 15000.00, 2, 30000.00),
(3, 2, 3, 'Donat Kentang', 8000.00, 2, 16000.00),
(4, 3, 2, 'Pizza Kecil', 15000.00, 1, 15000.00),
(5, 3, 1, 'Brownies Panggang Premium', 45000.00, 2, 90000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `bank_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `account_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` enum('pending','verified','rejected') COLLATE utf8mb4_general_ci DEFAULT 'pending',
  `verified_by` int DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_proof`, `bank_name`, `account_name`, `amount`, `status`, `verified_by`, `verified_at`, `created_at`) VALUES
(1, 1, 'f_6a57a81da72910.64108070.png', NULL, NULL, 50000.00, 'verified', 1, '2026-07-15 15:33:47', '2026-07-15 15:32:45'),
(2, 2, 'f_6a587510135731.34497110.jpeg', NULL, NULL, 61000.00, 'verified', 1, '2026-07-16 06:10:48', '2026-07-16 06:07:12'),
(3, 3, 'f_6a5881ba04f7f4.92450354.jpeg', NULL, NULL, 120000.00, 'verified', 1, '2026-07-16 07:02:42', '2026-07-16 07:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(180) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `price` decimal(12,2) NOT NULL,
  `stock` int DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT '0',
  `status` enum('active','inactive') COLLATE utf8mb4_general_ci DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `is_featured`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Brownies Panggang Premium', 'brownies-panggang-premium', 'Brownies panggang cokelat premium dengan tekstur fudgy dan toppings melimpah.', 45000.00, 23, 'brownies.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 07:01:01'),
(2, 1, 'Pizza Kecil', 'pizza-kecil', 'Pizza ukuran mini dengan topping sosis, keju mozarella, dan saus bolognese gurih.', 15000.00, 29, 'pizza_kecil.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 07:01:01'),
(3, 1, 'Kue Sus Buah', 'kue-sus-buah', 'Kue sus dengan vla lembut manis dan hiasan buah segar di atasnya.', 5000.00, 40, 'kue_sus_buah.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(4, 2, 'Nasi Ayam Bakar', 'nasi-ayam-bakar', 'Nasi lengkap dengan ayam bakar bumbu khas Padang, lalapan segar, dan sambal cabai.', 30000.00, 40, 'nasi_ayam_bakar.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(5, 2, 'Nasi Box Catering Premium', 'nasi-box-catering-premium', 'Paket nasi box catering lengkap untuk berbagai acara formal dan informal.', 35000.00, 50, 'catering.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(6, 3, 'Klepon', 'klepon', 'Kue tradisional klepon dengan isian gula merah cair dan taburan kelapa parut gurih.', 2000.00, 60, 'klepon.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(7, 3, 'Risol', 'risol', 'Risol renyah dengan isian sayur gurih dan telur, digoreng keemasan.', 3000.00, 50, 'risol.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(8, 3, 'Snack Box Jajanan Pasar', 'snack-box-jajanan-pasar', 'Paket snack box lengkap berisi aneka kue tradisional (klepon, risol, sus) untuk rapat/acara.', 20000.00, 30, 'snackbox.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(9, 3, 'Jajanan Pasar Campur', 'jajanan-pasar-campur', 'Piring saji berisi aneka jajanan pasar tradisional khas Ranah Minang yang legit.', 15000.00, 35, 'jajanan_pasar.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(10, 4, 'Rendang Daging Sapi', 'rendang-daging-sapi', 'Rendang daging sapi asli Minang, dimasak perlahan hingga bumbu meresap sempurna.', 55000.00, 20, 'rendang.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(11, 4, 'Ayam Geprek Sambal Korek', 'ayam-geprek-sambal-korek', 'Ayam goreng tepung renyah dengan ulekan cabai rawit pedas mantap.', 25000.00, 35, 'ayam_geprek.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(12, 4, 'Ikan Cabe Ijo Pete', 'ikan-cabe-ijo-pete', 'Ikan goreng siram sambal cabai hijau gurih ditambah dengan pete segar.', 25000.00, 15, 'ikan_cabe_ijo_pete.png', 1, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49'),
(13, 4, 'Tumis Kangkung', 'tumis-kangkung', 'Tumis kangkung segar dengan irisan bawang dan cabai rawit pedas gurih.', 10000.00, 30, 'kangkung.png', 0, 'active', '2026-07-16 06:18:49', '2026-07-16 06:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `site_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `whatsapp` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about_text` text COLLATE utf8mb4_general_ci,
  `bank_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_account_number` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bank_account_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_name`, `logo`, `address`, `phone`, `email`, `whatsapp`, `about_text`, `bank_name`, `bank_account_number`, `bank_account_name`) VALUES
(1, 'UKM ARC', NULL, 'Jl. Kuliner Raya No. 10, Padang, Sumatera Barat', '0751-1234567', 'info@ukmarc.test', '081234500000', 'UKM ARC adalah usaha kuliner rumahan di Padang yang memproduksi pastry, kue, dan makanan siap saji dengan bahan berkualitas, higienis, dan tanpa pengawet.', 'Bank BRI', '1234-5678-9012', 'UKM ARC');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cost` decimal(12,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_methods`
--

INSERT INTO `shipping_methods` (`id`, `name`, `description`, `cost`, `is_active`) VALUES
(1, 'Ambil di Tempat', 'Pelanggan mengambil pesanan langsung di lokasi UKM ARC', 0.00, 1),
(2, 'Antar Dalam Kota Padang', 'Diantar oleh pihak UKM ARC, biaya tetap', 15000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int NOT NULL,
  `customer_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `rating` tinyint DEFAULT '5',
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_shown` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `customer_name`, `message`, `rating`, `photo`, `is_shown`, `created_at`) VALUES
(1, 'Siti Rahma', 'Kuenya enak banget dan selalu fresh! Langganan tiap minggu.', 5, NULL, 1, '2026-07-16 06:18:49'),
(2, 'Andi Wijaya', 'Nasi box-nya porsinya pas dan rasanya autentik Padang banget.', 5, NULL, 1, '2026-07-16 06:18:49'),
(3, 'Dewi Lestari', 'Pelayanan ramah, pesan online jadi lebih gampang sekarang.', 4, NULL, 1, '2026-07-16 06:18:49'),
(4, 'Rian Pratama', 'Rendang kemasannya cocok buat oleh-oleh keluar kota.', 5, NULL, 1, '2026-07-16 06:18:49'),
(5, 'Khairul Huda', 'Pelayanan Mantap', 5, NULL, 1, '2026-07-16 07:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `role` enum('admin','customer') COLLATE utf8mb4_general_ci DEFAULT 'customer',
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `address`, `role`, `photo`, `created_at`, `updated_at`) VALUES
(1, 'Admin ARC', 'admin@gmail.com', '$2y$10$gEy133kAkPDIkqS3QqMwierUWuvCcoKNkUhfSgUoVwEm6dTP9bIU.', NULL, NULL, 'admin', NULL, '2026-07-15 15:16:50', '2026-07-16 06:57:22'),
(2, 'Budi Santoso Updated', 'costumer@gmail.com', '$2y$10$nL/aPVKvLnngWVUiwA.Uq.yw9BkN612BfhRVWn4z0Y8Rx6OU1VBc.', '081200000000', 'Alamat baru, Padang', 'customer', NULL, '2026-07-15 15:16:50', '2026-07-16 06:57:32'),
(3, 'Khairul Huda', 'khairulhuda242@gmail.com', '$2y$10$0ghCqQvWSJ3Yaa9pe2xIiebcwLAe0j2ZRSlT7CNGgyyVE8TBgQ8bO', '082165443677', '', 'customer', NULL, '2026-07-16 06:04:10', '2026-07-16 06:04:10'),
(4, 'Ahmad Dahlan', 'ahmad@example.test', '$2y$10$7LkEeMlroa5lraqSeduGQukWzqsDwTK0JgEbPoFZkBSCkuyENSf32', '081234567891', 'Jl. Sudirman No. 12, Padang', 'customer', NULL, '2026-07-16 08:19:33', '2026-07-16 08:19:33'),
(5, 'Siti Aminah', 'siti@example.test', '$2y$10$pZg.LFVs7BylA2N7/AxNbuq4UVvrOKVyvZLXxybkkEpnRTU4w3sle', '081234567892', 'Jl. Khatib Sulaiman No. 45, Padang', 'customer', NULL, '2026-07-16 08:19:33', '2026-07-16 08:19:33'),
(6, 'Rudi Hermawan', 'rudi@example.test', '$2y$10$ZVfR94KgJuo/0hOdgvC8le6jFdA4ytWt10QNylecQ/CUIOFIeUOsq', '081234567893', 'Jl. H. Agus Salim No. 8, Padang', 'customer', NULL, '2026-07-16 08:19:33', '2026-07-16 08:19:33'),
(7, 'Indah Permata', 'indah@example.test', '$2y$10$Xpp4ID8ERyTYzgA7jfGwZ.pTc/SiThWqRZaoEXtFZXErQ33uC1tFy', '081234567894', 'Jl. Raden Saleh No. 20, Padang', 'customer', NULL, '2026-07-16 08:19:34', '2026-07-16 08:19:34'),
(8, 'Fajar Nugraha', 'fajar@example.test', '$2y$10$M9.GbIRA/L8NTy1J5C1gxO/5JY587VqdbSztxfLxs61qN8QHznFUK', '081234567895', 'Jl. Proklamasi No. 17, Padang', 'customer', NULL, '2026-07-16 08:19:34', '2026-07-16 08:19:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_method_id` (`shipping_method_id`),
  ADD KEY `idx_orders_status` (`status`),
  ADD KEY `idx_orders_created` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `verified_by` (`verified_by`),
  ADD KEY `idx_payments_status` (`status`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `idx_products_status` (`status`),
  ADD KEY `idx_products_category` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_methods` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

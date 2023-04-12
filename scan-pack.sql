-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 06, 2023 at 01:57 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scan-pack`
--

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int UNSIGNED NOT NULL,
  `nama_karyawan` varchar(255) NOT NULL,
  `usia` int NOT NULL,
  `status_vaksin_1` enum('sudah','belum') NOT NULL DEFAULT 'belum',
  `status_vaksin_2` enum('sudah','belum') NOT NULL DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-04-03-014027', 'App\\Database\\Migrations\\Employees', 'default', 'App', 1680486099, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblbuyer`
--

CREATE TABLE `tblbuyer` (
  `buyer_id` int NOT NULL,
  `buyer_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `offadd` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipadd` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblbuyer`
--

INSERT INTO `tblbuyer` (`buyer_id`, `buyer_name`, `offadd`, `shipadd`, `country`, `code`, `created_at`, `updated_at`) VALUES
(1, 'AMAZON', 'NEW YORK', 'Warehouse East', 'Amerika Serikat', 'amazon', '2023-03-13 17:38:43', NULL),
(2, 'AEROPOSTALE', 'NEW YORK', 'Warehouse South', 'United States', 'aeropostale', '2023-03-13 17:39:05', NULL),
(3, 'GIII', 'NEW YORK city\r\n', 'Warehouse North', 'United States', 'giii', '2023-03-13 17:39:15', NULL),
(4, 'FOOT LOCKER', 'NEW YORK', 'Warehouse South\r\n', 'United States', 'foot-locker', '2023-03-13 17:39:23', NULL),
(5, 'CHICOS', 'San Franscisco', '', 'United States', 'chicos', '2023-03-13 17:39:30', NULL),
(6, 'KOHL\'s', 'California', 'New Warehouse', 'United States', 'kohls', '2023-03-13 17:39:38', NULL),
(7, 'WALMART', 'no idea', 'Old Warehouse South', 'United States', 'walmart', '2023-03-13 17:40:08', NULL),
(8, 'PVH Baru', 'new york ku', 'alamat baru', 'United States', 'pvh-baru', '2023-03-13 17:40:18', NULL),
(9, 'Ross Store', 'no ideaa', 'No Warehouse', 'United States', 'ros-store', '2023-03-13 17:40:35', NULL),
(23, 'Macy USA', 'Taiwan Tainan', 'Gudang Selatan', 'USA', 'macy-usa', '2023-03-28 03:45:05', '2023-03-28 03:45:05'),
(27, 'H&M', 'Jakarta', 'Sunter', 'Indonesia', 'hm', '2023-03-29 02:07:32', '2023-03-29 02:07:32');

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`category_id`, `category_name`) VALUES
(1, 'T-Shirt'),
(2, 'Polo Shirt'),
(3, 'Leggings'),
(4, 'Dress'),
(5, 'Jacket');

-- --------------------------------------------------------

--
-- Table structure for table `tblfactory`
--

CREATE TABLE `tblfactory` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `incharge` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblfactory`
--

INSERT INTO `tblfactory` (`id`, `name`, `incharge`, `remarks`) VALUES
(1, 'Ghim Li Indonesia', 'Joyce Teo', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblpo`
--

CREATE TABLE `tblpo` (
  `id` int NOT NULL,
  `PO_No` varchar(35) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PO_buyer_id` int NOT NULL,
  `PO_product_id` int NOT NULL,
  `shipdate` date NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `PO_qty` int NOT NULL,
  `PO_amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tblpo`
--

INSERT INTO `tblpo` (`id`, `PO_No`, `PO_buyer_id`, `PO_product_id`, `shipdate`, `unit_price`, `PO_qty`, `PO_amount`, `created_at`, `updated_at`) VALUES
(1, '8X8WFHBM', 1, 8, '2022-11-03', 10.80, 10, 108, '2023-04-03 03:01:31', NULL),
(2, '8X8WFHBM', 3, 9, '2022-10-18', 10.80, 116, 1253, '2023-04-03 03:01:42', NULL),
(3, '8X8WFHBM', 5, 10, '2022-10-29', 10.80, 269, 2905, '2023-04-03 03:01:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpo_detail`
--

CREATE TABLE `tblpo_detail` (
  `id` int NOT NULL,
  `order_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `price` int DEFAULT NULL,
  `qty` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblproduct`
--

CREATE TABLE `tblproduct` (
  `product_id` int NOT NULL,
  `product_code` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `product_asin_id` varchar(35) COLLATE utf8mb4_general_ci NOT NULL,
  `style` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `product_name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_category_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblproduct`
--

INSERT INTO `tblproduct` (`product_id`, `product_code`, `product_asin_id`, `style`, `product_name`, `product_price`, `product_category_id`, `created_at`, `updated_at`) VALUES
(8, '195111263922', 'B08J66XGYV', 'AE-M-FW20-SHR-1270-Micon-X-Small', 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man', 10.80, 1, '2023-04-29 10:46:01', NULL),
(9, '195111263939', 'B08J5GGYGK', 'AE-M-FW20-SHR-1270-Micon-Small', 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man', 10.80, 1, '2023-04-29 10:49:05', NULL),
(10, '195111263946', 'B08J6C297M', 'AE-M-FW20-SHR-1270-Micon-Medium', 'Amazon Essential Disney Star Wars Men\'s Fleece Pullover Hoodie Sweatshirts, Marvel Spider-Man', 10.80, 4, '2023-04-29 10:51:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL COMMENT 'Primary Key',
  `name` varchar(100) NOT NULL COMMENT 'Name',
  `email` varchar(255) NOT NULL COMMENT 'Email Address'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='datatable demo table';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(1, 'Paul Bettany', 'paul@gmail.com'),
(2, 'Vanya', 'vanya@gmail.com'),
(3, 'Luther', 'luther@gmail.com'),
(4, 'John Doe', 'john@gmail.com'),
(5, 'Paul Bettany', 'paul@gmail.com'),
(6, 'Vanya', 'vanya@gmail.com'),
(7, 'Luther', 'luther@gmail.com'),
(8, 'Wayne Barrett', 'wayne@gmail.com'),
(9, 'Vincent Ramos', 'ramos@gmail.com'),
(10, 'Susan Warren', 'sussan@gmail.com'),
(11, 'Jason Evans', 'jason@gmail.com'),
(12, 'Madison Simpson', 'madison@gmail.com'),
(13, 'Marvin Ortiz', 'paul@gmail.com'),
(14, 'Felecia Phillips', 'felecia@gmail.com'),
(15, 'Tommy Hernandez', 'hernandez@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbuyer`
--
ALTER TABLE `tblbuyer`
  ADD PRIMARY KEY (`buyer_id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tblfactory`
--
ALTER TABLE `tblfactory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpo`
--
ALTER TABLE `tblpo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpo_detail`
--
ALTER TABLE `tblpo_detail`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `fk_transaksi_has_product_product1_idx` (`product_id`) USING BTREE,
  ADD KEY `fk_transaksi_has_product_order1_idx` (`id`) USING BTREE;

--
-- Indexes for table `tblproduct`
--
ALTER TABLE `tblproduct`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblbuyer`
--
ALTER TABLE `tblbuyer`
  MODIFY `buyer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblfactory`
--
ALTER TABLE `tblfactory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblpo`
--
ALTER TABLE `tblpo`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblpo_detail`
--
ALTER TABLE `tblpo_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblproduct`
--
ALTER TABLE `tblproduct`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key', AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

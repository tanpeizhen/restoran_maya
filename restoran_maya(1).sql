-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-08-14 04:42:19
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `restoran_maya`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(17, 'admin', '$2y$10$kRtS7ARNAA2y00Gqw2P3HeG4xG/cmqbJidBgUxldtZt/JCdgzai4S');

-- --------------------------------------------------------

--
-- 表的结构 `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `imej` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `menu`
--

INSERT INTO `menu` (`id`, `nama`, `kategori`, `keterangan`, `harga`, `imej`) VALUES
(1, 'Nasi Lemak', 'Makanan', NULL, 5.00, '屏幕截图 2025-08-08 041509.jpg'),
(2, 'Mee Goreng', 'Makanan', NULL, 6.50, '屏幕截图 2025-08-07 194701.jpg'),
(3, 'Teh Tarik', 'Minuman', NULL, 2.00, '屏幕截图 2025-08-07 200104.jpg'),
(5, 'Laksa', 'Makanan', NULL, 8.00, '屏幕截图 2025-08-08 051128.jpg'),
(6, 'Seri muka', 'pencuci mulut', NULL, 2.00, '屏幕截图 2025-08-08 055012.jpg'),
(7, 'Milo panas', 'Minuman', NULL, 3.00, '屏幕截图 2025-08-08 094626.jpg'),
(8, 'Kari ayam', 'Makanan Kari', NULL, 10.00, '屏幕截图 2025-08-09 165045.jpg'),
(9, 'Kari daging', 'Makanan Kari', NULL, 15.00, '屏幕截图 2025-08-09 165537.jpg'),
(10, 'Puding', 'pencuci mulut', NULL, 3.00, '屏幕截图 2025-08-09 165828.png'),
(11, 'Char Kuey Teow', 'Makanan', NULL, 5.00, '屏幕截图 2025-08-11 185115.jpg'),
(12, 'RotiCanai', 'Makanan', NULL, 3.20, '屏幕截图 2025-08-11 184341.jpg'),
(13, 'Air sirap', 'Minuman', NULL, 2.50, '屏幕截图 2025-08-11 185540.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `nama_pelanggan`, `telefon`, `phone`, `payment_method`, `total_amount`) VALUES
(1, '2025-08-07 21:25:33', NULL, NULL, NULL, NULL, NULL),
(2, '2025-08-07 21:30:53', NULL, NULL, NULL, NULL, NULL),
(3, '2025-08-07 21:32:00', NULL, NULL, NULL, NULL, NULL),
(4, '2025-08-07 21:33:39', NULL, NULL, NULL, NULL, NULL),
(5, '2025-08-07 21:38:13', 'sd', NULL, 'dqwfwdfwdw', 'Tunai', 41.50),
(6, '2025-08-07 21:44:54', '首发式', NULL, 'gegg', 'Tunai', 24.00),
(7, '2025-08-07 21:47:53', '首发式', NULL, 'gegg', 'Tunai', 24.00),
(8, '2025-08-07 21:48:04', '等', NULL, '17783700867', 'Tunai', 26.00),
(9, '2025-08-07 22:07:52', '才', NULL, 'scsc', 'Kad Kredit', 24.00),
(10, '2025-08-08 00:26:27', '非法', NULL, '三个', 'Tunai', 4.00),
(11, '2025-08-08 00:27:49', '非法', NULL, '三个', 'Tunai', 4.00),
(12, '2025-08-08 00:28:07', 'Mee Goreng', NULL, 'dqwfwdfwdw', 'Kad Kredit/Debit', 8.00),
(13, '2025-08-08 00:46:22', 'xxx', NULL, '0123456', 'Tunai', 13.00),
(14, '2025-08-08 01:22:51', 'dee', NULL, '17783700867', 'Kad Kredit/Debit', 18.50),
(15, '2025-08-08 01:32:41', 'Teh Tarik', NULL, NULL, NULL, 24.00),
(16, '2025-08-08 01:32:56', '二分', NULL, NULL, NULL, 8.00),
(17, '2025-08-08 01:34:24', '发布公告', NULL, NULL, NULL, 16.00),
(18, '2025-08-08 01:38:06', 'Mee Goreng', NULL, NULL, NULL, 24.00),
(19, '2025-08-08 01:40:42', 'Nasi Lemak', NULL, NULL, NULL, 16.00),
(20, '2025-08-08 01:44:02', 'fe', NULL, 'affef', 'Tunai', 16.00),
(21, '2025-08-08 01:48:30', 'Teh Tarik', NULL, 'dqwfwdfwdw', 'Online Banking', 5.00),
(22, '2025-08-08 04:30:19', 'gwf', NULL, '放f', 'Tunai', 10.00),
(23, '2025-08-08 13:10:24', '一股guig', NULL, '54343564454564364', 'E-wallet', 4.00),
(24, '2025-08-09 08:49:02', 'Teh tarik', NULL, '17783700867', 'Tunai', 4.00),
(25, '2025-08-09 09:52:16', '看你了、', NULL, 'dqwfwdfwdw', 'Kad Kredit/Debit', NULL),
(26, '2025-08-09 09:58:29', '看你了、', NULL, '17783700867', 'Tunai', NULL),
(27, '2025-08-09 10:02:06', '看你了、', NULL, '17783700867', 'Kad Kredit/Debit', NULL),
(28, '2025-08-09 10:07:41', '爱你', NULL, 'dqwfwdfwdw', 'Kad Kredit/Debit', NULL),
(29, '2025-08-09 10:24:47', '坦佩珍、', NULL, '17783700867', 'Kad Kredit/Debit', NULL),
(30, '2025-08-11 10:57:47', '坦佩珍、', NULL, '17783700867', 'Kad Kredit/Debit', NULL),
(31, '2025-08-13 06:44:47', 'egfef', NULL, '123465667', 'Kad Kredit/Debit', NULL),
(32, '2025-08-14 01:23:38', '坦佩珍、', NULL, '17783700867', 'Kad Kredit/Debit', NULL),
(33, '2025-08-14 01:25:52', '爱你', NULL, 'dqwfwdfwdw', 'E-Wallet', NULL),
(34, '2025-08-14 01:38:15', '坦佩珍、', NULL, '17783700867', 'Tunai', NULL),
(35, '2025-08-14 02:00:04', '坦佩珍、', NULL, '', '', NULL),
(36, '2025-08-14 02:06:23', '', '01111031014', NULL, '', 0.00),
(37, '2025-08-14 02:12:56', 'Teh Tarik', '01111031014', NULL, 'Kad Kredit', 24.00),
(38, '2025-08-14 02:13:29', 'Teh Tarik', '01111031014', NULL, 'Kad Kredit', 8.00),
(39, '2025-08-14 02:22:54', 'ong', '01111031014', NULL, 'Kad Kredit', 17.00),
(40, '2025-08-14 02:31:03', 'Teh tarik', '01111031014', NULL, 'Online Banking', 3.20);

-- --------------------------------------------------------

--
-- 表的结构 `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `kuantiti` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_id`, `quantity`, `remark`, `price`, `kuantiti`) VALUES
(1, 11, 3, 2, NULL, 2.00, 1),
(2, 12, 5, 1, NULL, 8.00, 1),
(3, 13, 5, 1, NULL, 8.00, 1),
(4, 13, 1, 1, NULL, 5.00, 1),
(5, 14, 5, 1, NULL, 8.00, 1),
(6, 14, 2, 1, NULL, 6.50, 1),
(7, 14, 3, 1, NULL, 2.00, 1),
(8, 14, 6, 1, NULL, 2.00, 1),
(9, 15, 5, NULL, NULL, NULL, 3),
(10, 16, 5, NULL, NULL, NULL, 1),
(11, 17, 5, NULL, NULL, NULL, 2),
(12, 18, 5, NULL, NULL, NULL, 3),
(13, 19, 5, NULL, NULL, NULL, 2),
(14, 20, 5, NULL, NULL, NULL, 2),
(15, 21, 7, NULL, NULL, NULL, 1),
(16, 21, 3, NULL, NULL, NULL, 1),
(17, 22, 7, NULL, NULL, NULL, 2),
(18, 22, 3, NULL, NULL, NULL, 2),
(19, 23, 6, NULL, NULL, NULL, 2),
(20, 24, 3, NULL, NULL, NULL, 2),
(21, 25, NULL, NULL, NULL, NULL, 3),
(22, 26, NULL, NULL, NULL, NULL, 3),
(23, 27, 2, NULL, NULL, NULL, 7),
(24, 28, 2, NULL, NULL, NULL, 1),
(25, 29, 3, NULL, NULL, NULL, 3),
(26, 30, 5, NULL, NULL, NULL, 2),
(27, 30, 2, NULL, NULL, NULL, 2),
(28, 31, 5, NULL, NULL, NULL, 1),
(29, 31, 12, NULL, NULL, NULL, 1),
(30, 31, 7, NULL, NULL, NULL, 1),
(31, 31, 6, NULL, NULL, NULL, 1),
(32, 32, 5, NULL, NULL, NULL, 1),
(33, 32, 12, NULL, NULL, NULL, 1),
(34, 32, 13, NULL, NULL, NULL, 1),
(35, 33, 12, NULL, NULL, NULL, 1),
(36, 33, 7, NULL, NULL, NULL, 1),
(37, 34, 9, NULL, '', NULL, 1),
(38, 35, NULL, NULL, '民间', NULL, 1),
(39, 37, 5, NULL, '顶顶顶', NULL, 3),
(40, 38, 5, NULL, '顶顶顶', NULL, 1),
(41, 39, 11, NULL, '说的是我可没', NULL, 3),
(42, 39, 6, NULL, '少冰', NULL, 1),
(43, 40, 12, NULL, 'saya nak telur', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `created_at`) VALUES
(1, 'user1', 'Ali', '2025-08-07 20:06:17'),
(2, 'user2', 'Fatimah', '2025-08-07 20:06:17'),
(3, 'user3', 'Ahmad', '2025-08-07 20:06:17');

--
-- 转储表的索引
--

--
-- 表的索引 `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 使用表AUTO_INCREMENT `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 使用表AUTO_INCREMENT `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 限制导出的表
--

--
-- 限制表 `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

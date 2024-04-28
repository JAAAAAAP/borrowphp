-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 11:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `borrowphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bin`
--

CREATE TABLE `bin` (
  `b_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `img` text NOT NULL,
  `upload_time` datetime NOT NULL,
  `delete_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bin`
--

INSERT INTO `bin` (`b_id`, `p_id`, `name`, `amount`, `img`, `upload_time`, `delete_time`) VALUES
(42, 107, 'asd', 24, '1713522960_สกรีนช็อต 2024-03-13 200625.png', '2024-04-19 17:36:00', '2024-04-22 21:48:26'),
(43, 108, 'wwwwwww', 0, '1713522986_Capture001.png', '2024-04-19 17:36:26', '2024-04-22 21:48:29'),
(44, 109, 'assa', 0, '1713797379_1712027187580.jpg', '2024-04-22 21:49:39', '2024-04-23 02:07:09'),
(45, 110, 'assa', 1, '1713797391_5ba43a1940491c1b.png', '2024-04-22 21:49:51', '2024-04-23 02:07:12'),
(46, 123, 'assa', 2, '1713822483_ซื้อโปรเจคเตอร์-2.jpg', '2024-04-23 04:48:03', '2024-04-23 04:48:10');

-- --------------------------------------------------------

--
-- Table structure for table `oder_product`
--

CREATE TABLE `oder_product` (
  `o_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `tel` int(11) NOT NULL,
  `address` text NOT NULL,
  `teacher` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `group_id` int(11) NOT NULL,
  `status` enum('รออนุมัติ','อนุมัติแล้ว','ไม่อนุมัติ','กำลังยืม','เลยกำหนด','รอดำเนินการ','คืนแล้ว') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oder_product`
--

INSERT INTO `oder_product` (`o_id`, `p_id`, `user_id`, `amount`, `tel`, `address`, `teacher`, `department`, `date_start`, `date_end`, `group_id`, `status`) VALUES
(139, 111, 1, 1, 863112408, 'aaaa', 'จาเอ', 'ทดสอบ 1', '2024-04-23', '2024-04-25', 804, 'คืนแล้ว'),
(141, 111, 1, 1, 1233, 'dsaas', 'aweawd', 'ทดสอบ 1', '2024-04-23', '2024-04-25', 213, 'คืนแล้ว'),
(142, 112, 1, 3, 1233, 'dsaasd', 'aweawd', 'ทดสอบ 1', '2024-04-23', '2024-04-25', 213, 'กำลังยืม'),
(143, 113, 1, 1, 1233, 'dsaas', 'aweawd', 'ทดสอบ 1', '2024-04-23', '2024-04-25', 213, 'กำลังยืม');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `p_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `img` varchar(255) NOT NULL,
  `sn_products` text NOT NULL,
  `upload_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`p_id`, `name`, `amount`, `img`, `sn_products`, `upload_time`, `update_time`) VALUES
(111, 'โปรเจคเตอร์', 10, '1713813842_ซื้อโปรเจคเตอร์-2.jpg', '479001600', '2024-04-23 02:14:17', '2024-04-23 02:53:09'),
(112, 'Notebook ACER ๑(สำหรับยืมสอน)', 1, '1713813965_ดาวน์โหลด.jpg', '1307674368000', '2024-04-23 02:26:05', '0000-00-00 00:00:00'),
(113, 'Notebook ACER ๒(สำหรับประชุม)', 0, '1713814004_ดาวน์โหลด.jpg', '87178291200', '2024-04-23 02:26:44', '0000-00-00 00:00:00'),
(114, 'MacBook Air(สำหรับประชุม) ', 2, '1713814037_202401172220941037.jpg', '362880', '2024-04-23 02:27:17', '0000-00-00 00:00:00'),
(115, 'HDMI to VGA ', 7, '1713814130_ดาวน์โหลด (2).jpg', '5040', '2024-04-23 02:27:52', '2024-04-23 02:28:50'),
(116, 'สาย VGA ', 4, '1713814145_ดาวน์โหลด (1).jpg', '3628800', '2024-04-23 02:28:26', '2024-04-23 02:29:05'),
(117, 'เครื่องฉายแผ่นทึบ ', 3, '1713814172_ดาวน์โหลด (3).jpg', '3628800', '2024-04-23 02:29:32', '0000-00-00 00:00:00'),
(118, 'ลำโพง/เครื่่องเสียง ', 2, '1713814197_ดาวน์โหลด (4).jpg', '1307674368000', '2024-04-23 02:29:57', '0000-00-00 00:00:00'),
(119, 'ไมค์ลอย ', 10, '1713814224_ดาวน์โหลด (5).jpg', '40320', '2024-04-23 02:30:24', '0000-00-00 00:00:00'),
(120, 'ไมล์สาย ', 5, '1713814252_ดาวน์โหลด (6).jpg', '6227020800', '2024-04-23 02:30:52', '0000-00-00 00:00:00'),
(121, 'สายเสียง ', 5, '1713814280_ดาวน์โหลด (7).jpg', '39916800', '2024-04-23 02:31:20', '0000-00-00 00:00:00'),
(122, 'ปลั๊กพ่วง ', 2, '1713814307_ดาวน์โหลด (8).jpg', '20922789888000', '2024-04-23 02:31:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user`, `password`, `role`) VALUES
(1, 'admin', 'admin', 1),
(2, 'user', 'user', 0),
(4, 'shell', 'shell', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bin`
--
ALTER TABLE `bin`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `oder_product`
--
ALTER TABLE `oder_product`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bin`
--
ALTER TABLE `bin`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `oder_product`
--
ALTER TABLE `oder_product`
  MODIFY `o_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

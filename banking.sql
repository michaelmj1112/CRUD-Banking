-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 08:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banking`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `SSN` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `TEL` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `balance` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_number`, `SSN`, `firstname`, `lastname`, `address`, `city`, `country`, `TEL`, `email`, `password`, `balance`, `date_created`, `date_updated`) VALUES
(3, '4322555947', '754812394712304', 'Michael', 'Jordan', 'Wuquan Rd.', 'Hualien', 'Taiwan', '5481-578-458', 'michael@sample.com', 'Qld4QWM5WjFKU20rMXNKcFNTWlBLZz09OjrveR+yLHVQVR2+DmUVzpYh', 35000, '2023-01-10 01:51:54', '2023-01-12 12:54:10'),
(7, '6592621874', '2352356425234523', 'Katharina', 'Posasih', 'Zhixue Rd.', 'Hualien', 'Taiwan', '0946-481-344', 'kat@sample.com', 'M0FFTU5yVDd2SjRraE5uTzh2a0RaZz09Ojog0hlm27waHWj9ZcU733fs', 86500, '2023-01-10 22:12:42', '2023-01-11 20:15:23'),
(16, '6370479331', '4234231423423423', 'Kyree', 'Martin', 'Shouxue Rd.', 'Tainan', 'Taiwan', '0493-481-382', 'kyree123@sample.com', 'ZUh3Y0RobkdxZWEzYTY0QzhlKzNhdz09OjqmuuAwnu+ILvTY8m2+DDA0', 92000, '2023-01-11 19:58:34', '2023-01-12 15:31:20'),
(18, '5627881669', '478239472314890312', 'Marcel', 'Johan', 'Daxue Rd.', 'Hualien', 'Taiwan', '0398-483-481', 'marcel@sample.com', 'cjZtdFF6OXdHYW5YT0FIbjF0RVV0Zz09OjpMT8ajdYBgvEZ7snecNJHA', 87000, '2023-01-11 23:17:56', '2023-01-12 01:48:47'),
(21, '6081522849', '7483290174382091', 'John', 'Doe', 'Zhixue Rd.', 'Hualien', 'Taiwan', '0934-381-182', 'john@sample.com', 'YlRmQWdubmRmYTBKODFubjFhQW5TZz09OjolGPHZ7V4lpXxSmX3sTFsH', 0, '2023-01-12 15:25:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `firstname`, `lastname`, `username`, `password`, `last_login`, `date_added`, `date_updated`) VALUES
(1, 'Administrator', 'Admin', 'admin', 'c2xYdzIwUG8zTWZZZGpMclRBRjlGdz09OjolFuMp/lfTKUuQIrVleNoK', '2023-01-12 15:33:31', '2022-12-29 21:38:21', '2023-01-12 04:21:45');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL COMMENT '1 = Cash in\r\n2 = Withdraw\r\n3 = Transfer',
  `amount` float NOT NULL,
  `remarks` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `account_id`, `type`, `amount`, `remarks`, `date_created`) VALUES
(1, 1, 3, 500, 'Transfered to 2', '2022-12-22 17:39:25'),
(2, 1, 3, 500, 'Transfered to 2', '2022-12-22 17:39:42'),
(3, 1, 3, 500, 'Transfered to 2', '2022-12-22 17:48:16'),
(4, 1, 3, 500, 'Transferred to 2', '2022-12-22 18:41:31'),
(5, 1, 3, 500, 'Transferred to 2', '2022-12-22 18:41:57'),
(6, 1, 3, 500, 'Transferred to 3', '2022-12-22 18:43:22'),
(7, 1, 3, 500, 'Transferred to 2', '2022-12-22 18:43:38'),
(8, 1, 3, 500, 'Transferred to 1', '2022-12-23 14:13:33'),
(9, 2, 3, 500, 'Transferred to 1', '2022-12-27 00:12:51'),
(10, 1, 3, 500, 'Transferred to 2', '2022-12-27 00:13:16'),
(11, 2, 3, 500, 'Transferred to 1', '2022-12-27 00:55:56'),
(13, 1, 2, 500, 'Withdraw', '2022-12-27 23:20:18'),
(14, 1, 2, 500, 'Withdraw', '2022-12-27 23:29:01'),
(15, 1, 2, 500, 'Withdraw', '2022-12-27 23:29:18'),
(16, 1, 2, 500, 'Withdraw', '2022-12-27 23:29:48'),
(17, 1, 1, 500, 'Deposit', '2022-12-27 23:30:09'),
(18, 1, 3, 500, 'Transferred to 2', '2022-12-27 23:33:23'),
(19, 2, 3, 500, 'Transferred from 1', '2022-12-27 23:33:23'),
(20, 1, 3, 500, 'Transferred to 2', '2022-12-28 00:51:35'),
(21, 2, 3, 500, 'Transferred from 1', '2022-12-28 00:51:35'),
(22, 1, 1, 1000, 'Deposit', '2022-12-29 16:18:43'),
(23, 1, 2, 500, 'Withdraw', '2022-12-29 23:20:10'),
(24, 1, 2, 500, 'Withdraw', '2022-12-29 23:20:53'),
(25, 1, 2, 500, 'Withdraw', '2022-12-29 23:21:03'),
(26, 1, 1, 500, 'Deposit', '2022-12-29 23:22:19'),
(27, 1, 3, 1000, 'Transferred to 2', '2022-12-29 23:22:36'),
(28, 2, 3, 1000, 'Transferred from 1', '2022-12-29 23:22:36'),
(29, 1, 1, 1000, 'Deposit', '2022-12-30 21:42:50'),
(30, 3, 1, 1000, 'Deposit', '2022-12-30 22:16:08'),
(31, 3, 1, 500, 'Deposit', '2022-12-30 22:16:32'),
(32, 1, 1, 500, 'Deposit', '2022-12-30 22:25:30'),
(33, 3, 1, 500, 'Deposit', '2022-12-30 22:25:56'),
(34, 3, 1, 500, 'Deposit', '2022-12-30 22:26:12'),
(35, 3, 1, 500, 'Deposit', '2022-12-30 22:26:34'),
(36, 1, 1, 500, 'Deposit', '2022-12-30 22:26:51'),
(37, 3, 1, 500, 'Deposit', '2022-12-30 22:35:18'),
(38, 3, 1, 500, 'Deposit', '2022-12-30 22:42:18'),
(39, 3, 2, 500, 'Withdraw', '2022-12-30 22:42:30'),
(40, 3, 2, 500, 'Withdraw', '2022-12-30 22:45:31'),
(41, 3, 2, 500, 'Withdraw', '2022-12-30 22:45:34'),
(42, 1, 1, 500, 'Deposit', '2022-12-30 22:54:58'),
(43, 3, 3, 500, 'Transferred to 2', '2022-12-30 23:01:30'),
(44, 2, 3, 500, 'Transferred from 3', '2022-12-30 23:01:30'),
(45, 3, 3, 500, 'Transferred to 2', '2022-12-30 23:01:37'),
(46, 2, 3, 500, 'Transferred from 3', '2022-12-30 23:01:37'),
(47, 7, 1, 10000, 'Deposit', '2023-01-02 23:33:01'),
(48, 7, 1, 5000, 'Deposit', '2023-01-02 23:33:22'),
(49, 7, 2, 2000, 'Withdraw', '2023-01-02 23:33:38'),
(50, 7, 1, 5000, 'Deposit', '2023-01-02 23:34:13'),
(51, 7, 1, 3000, 'Deposit', '2023-01-02 23:34:31'),
(52, 7, 3, 1500, 'Transferred to 3', '2023-01-02 23:35:22'),
(53, 3, 3, 1500, 'Transferred from 7', '2023-01-02 23:35:22'),
(54, 1, 1, 1000, 'Deposit', '2023-01-08 17:28:14'),
(55, 1, 2, 500, 'Withdraw', '2023-01-08 17:28:22'),
(56, 1, 3, 1000, 'Transferred to 3', '2023-01-08 17:28:28'),
(57, 3, 3, 1000, 'Transferred from 1', '2023-01-08 17:28:28'),
(58, 1, 1, 500, 'Deposit', '2023-01-08 17:30:02'),
(59, 1, 1, 500, 'Deposit', '2023-01-08 18:25:40'),
(60, 1, 1, 1000, 'Deposit', '2023-01-08 22:24:45'),
(61, 3, 3, 2000, 'Transferred to 1', '2023-01-08 23:21:10'),
(62, 1, 3, 2000, 'Transferred from 3', '2023-01-08 23:21:10'),
(63, 1, 1, 1000, 'Deposit', '2023-01-08 23:24:01'),
(64, 3, 1, 50000, 'Deposit', '2023-01-11 01:38:52'),
(65, 3, 3, 30000, 'Transferred to 7', '2023-01-11 02:08:53'),
(66, 7, 3, 30000, 'Transferred from 3', '2023-01-11 02:08:53'),
(67, 3, 3, 10000, 'Transferred to 7', '2023-01-11 02:11:20'),
(68, 7, 3, 10000, 'Transferred from 3', '2023-01-11 02:11:20'),
(69, 3, 3, 5000, 'Transferred to 4322555947 - Michael Jordan', '2023-01-11 02:17:58'),
(70, 7, 3, 5000, 'Transferred from 6592621874 - Katharina Posasih', '2023-01-11 02:17:58'),
(71, 3, 1, 90000, '4322555947 - Michael Jordan [Deposit]', '2023-01-11 02:23:29'),
(72, 3, 1, 50000, '4322555947 - Michael Jordan [Deposit]', '2023-01-11 02:23:36'),
(73, 3, 2, 23000, '4322555947 - Michael Jordan [Withdraw]', '2023-01-11 02:23:43'),
(74, 7, 3, 3000, 'Transferred to 6592621874 - Katharina Posasih', '2023-01-12 00:03:39'),
(75, 3, 3, 3000, 'Transferred from 4322555947 - Michael Jordan', '2023-01-12 00:03:39'),
(76, 3, 3, 7000, 'Transferred from 4322555947 - Michael Jordan', '2023-01-12 00:04:45'),
(77, 7, 3, 7000, 'Transferred to 6592621874 - Katharina Posasih', '2023-01-12 00:04:45'),
(78, 3, 3, 3000, 'Transferred from 4322555947 - Michael Jordan', '2023-01-12 00:05:10'),
(79, 7, 3, 3000, 'Transferred to 6592621874 - Katharina Posasih', '2023-01-12 00:05:10'),
(80, 3, 3, 2000, 'Transferred to 4322555947 - Michael Jordan', '2023-01-12 00:05:31'),
(81, 7, 3, 2000, 'Transferred from 6592621874 - Katharina Posasih', '2023-01-12 00:05:31'),
(82, 3, 3, 2000, 'Transferred from 4322555947 - 3', '2023-01-12 00:06:25'),
(83, 7, 3, 2000, 'Transferred to 6592621874 - Katharina Posasih', '2023-01-12 00:06:25'),
(84, 3, 3, 6000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 00:07:16'),
(85, 7, 3, 6000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 00:07:16'),
(86, 3, 2, 35000, '4322555947 - Michael Jordan [Withdraw]', '2023-01-12 00:27:12'),
(87, 3, 3, 5000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 01:37:08'),
(88, 7, 3, 5000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 01:37:08'),
(89, 18, 1, 87000, '5627881669 - Marcel Johan [Deposit]', '2023-01-12 01:38:20'),
(90, 3, 1, 5000, '4322555947 - Michael Jordan [Deposit]', '2023-01-12 01:47:18'),
(91, 3, 2, 5000, '4322555947 - Michael Jordan [Withdraw]', '2023-01-12 01:47:22'),
(92, 3, 3, 5000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 01:47:27'),
(93, 7, 3, 5000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 01:47:27'),
(94, 3, 1, 5000, '4322555947 - Michael Jordan [Deposit]', '2023-01-12 04:09:20'),
(95, 3, 2, 12000, '4322555947 - Michael Jordan [Withdraw]', '2023-01-12 04:09:26'),
(96, 3, 3, 9000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 04:09:36'),
(97, 7, 3, 9000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 04:09:36'),
(98, 3, 3, 3000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 04:13:15'),
(99, 7, 3, 3000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 04:13:15'),
(100, 3, 3, 500, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 12:43:26'),
(101, 7, 3, 500, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 12:43:26'),
(102, 3, 3, 5000, 'Transferred to 4322555947 - Michael Jordan', '2023-01-12 12:48:42'),
(103, 3, 3, 5000, 'Transferred from 4322555947 - Michael Jordan', '2023-01-12 12:48:42'),
(104, 3, 3, 2000, 'Transferred to 4322555947 - Katharina Posasih', '2023-01-12 12:49:01'),
(105, 7, 3, 2000, 'Transferred from 6592621874 - Michael Jordan', '2023-01-12 12:49:01'),
(106, 3, 1, 5000, '4322555947 - Michael Jordan [Deposit]', '2023-01-12 15:26:46'),
(107, 3, 2, 3500, '4322555947 - Michael Jordan [Withdraw]', '2023-01-12 15:27:16'),
(108, 3, 3, 5000, 'Transferred to 4322555947 - Kyree Martin', '2023-01-12 15:28:05'),
(109, 16, 3, 5000, 'Transferred from 6370479331 - Michael Jordan', '2023-01-12 15:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `transfer_list`
--

CREATE TABLE `transfer_list` (
  `from_acc` varchar(50) NOT NULL,
  `to_acc` varchar(50) NOT NULL,
  `to_name` varchar(100) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transfer_list`
--

INSERT INTO `transfer_list` (`from_acc`, `to_acc`, `to_name`, `id`) VALUES
('4322555947', '6592621874', 'Kat', 2),
('6592621874', '4322555947', 'mikel', 4),
('4322555947', '6370479331', 'Kyree', 5),
('5627881669', '4322555947', 'Mike', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer_list`
--
ALTER TABLE `transfer_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_4` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_3` (`id`),
  ADD KEY `id_5` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `transfer_list`
--
ALTER TABLE `transfer_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

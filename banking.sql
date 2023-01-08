-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2023 at 08:34 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

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
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `balance` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_number`, `firstname`, `lastname`, `email`, `password`, `balance`, `date_created`, `date_updated`) VALUES
(1, '0884716827', 'Michael', 'Jordan', 'michael@sample.com', '1234', 95500, '2022-12-22 10:14:02', '2023-01-01 13:37:25'),
(2, '7583753910', 'Akeem', 'Peters', 'akeem@sample.com', '1234', 28000, '2022-12-22 10:30:22', NULL),
(3, '088', 'mekel', 'jorden', 'mekel@sample.com', '1234', 53000, '2022-12-29 23:40:17', '2022-12-30 00:51:08'),
(7, '8301504594', 'mikel', 'jordan', 'mikel@sample.com', '1234', 19500, '2023-01-02 23:28:56', NULL);

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
(1, 'Administrator', 'Admin', 'admin', 'admin', '2023-01-03 00:48:05', '2022-12-29 21:38:21', '2023-01-01 15:10:11');

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
(53, 3, 3, 1500, 'Transferred from 7', '2023-01-02 23:35:22');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

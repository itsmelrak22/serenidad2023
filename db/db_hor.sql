-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 29, 2023 at 12:35 PM
-- Server version: 8.0.28
-- PHP Version: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `username` varchar(24) NOT NULL,
  `password` varchar(191) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `restriction` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `restriction`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'Admin', 'admin', 'admin', NULL, '2022-12-01 10:16:37'),
(6, 'Admin 2', 'Admin2', 'admin2', 'admin', '2022-12-01 10:01:49', '2022-12-01 10:16:28'),
(9, 'test', 'test', 'test', 'user', '2022-12-02 14:39:34', '2022-12-02 14:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int NOT NULL,
  `messages` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `response` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `messages`, `response`) VALUES
(2, 'Hello', 'Hey There, How can I help you?'),
(3, 'Hi/Hello/Hy/Hey There', 'Good Day how can we help you?'),
(5, 'location / where is your location / where is the location / where / location? / where is your location? / where is the location? / where?', 'We are located @ Lian, Batangas, Calabarzon, Philippines'),
(6, 'cancel / cancel reservation / reservation cancel / how to cancel reservation', 'Cancellation: 3-4 days before check in'),
(7, 'How much? / How Much/ how much? / rate / rates / rate? / rates / amount / amount? / estimate / estimates? / estimates / estimate ? / How much is the rate / how much is the rate? /how much rate / how much rate? ', 'Serenidad Suites @Matabungkay Beach, Aquino suite. 2500/day (22 hours of stay)\n\n_____________________\n\nSerenidad Suites @Matabungkay Beach, Enrique Kubo 2000/day (22 hours of stay)'),
(8, 'help / Help! / HELP / Help', 'you can chat this basic commands, \n\nHello, Hi, Hey There, Location, rate, how much?');

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `id` int NOT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `firstname` varchar(50) NOT NULL,
  `username` varchar(191) DEFAULT NULL,
  `password` varchar(191) DEFAULT NULL,
  `middlename` varchar(30) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `address` varchar(191) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `contactno` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`id`, `uuid`, `firstname`, `username`, `password`, `middlename`, `lastname`, `address`, `contactno`, `created_at`, `updated_at`) VALUES
(1, '3f944dd6-8416-4bf9-91ad-58b329e14abc', 'client', 'client', 'client', 'client', 'client', NULL, '2312321312', '2023-01-28 22:50:44', '2023-01-28 22:50:44'),
(2, 'dc4f6a5c-8d3e-472d-9a9b-626efba99123', 'client2', 'client2', 'client2', 'client2', 'client2', NULL, '2312321312', '2023-01-28 22:59:42', '2023-01-28 22:59:42');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `id` int NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `price` varchar(11) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `room_type`, `price`, `photo`, `description`, `created_at`, `updated_at`) VALUES
(9, 'Corazon Aquino Suite', '2500', 'img/rooms/mmmmmm.jpg', 'Has 2 beds and 2 extra sofa beds good for a maximum of 6 pax Additional P350/exceeding pax', '2023-01-28 21:49:55', '2023-01-28 21:49:55'),
(10, 'Enrique kubo Suite', '2000', 'img/rooms/11.jpg', 'Has 1 double deck bed (upper Single, lower Double) good for a maximum of 4 pax Additional P350/exceeding pax', '2023-01-28 21:50:35', '2023-01-28 21:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `room_other_images`
--

CREATE TABLE `room_other_images` (
  `id` int NOT NULL,
  `room_id` int NOT NULL,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_other_images`
--

INSERT INTO `room_other_images` (`id`, `room_id`, `path`) VALUES
(25, 9, 'img/rooms/cas1.jpg'),
(26, 10, 'img/rooms/kubo2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `guest_id` int NOT NULL,
  `room_id` int NOT NULL,
  `room_no` int DEFAULT NULL,
  `extra_bed` tinyint NOT NULL DEFAULT '0',
  `extra_pax` int DEFAULT NULL,
  `status` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `days` int DEFAULT NULL,
  `checkin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_time` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` int NOT NULL DEFAULT '0',
  `payment` int NOT NULL DEFAULT '0',
  `is_payment_full` tinyint NOT NULL DEFAULT '0',
  `payment_at` datetime DEFAULT NULL,
  `valid_until` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_unread` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `remarks` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `guest_id`, `room_id`, `room_no`, `extra_bed`, `extra_pax`, `status`, `days`, `checkin`, `checkin_time`, `checkout`, `checkout_time`, `bill`, `balance`, `payment`, `is_payment_full`, `payment_at`, `valid_until`, `is_unread`, `created_at`, `updated_at`, `remarks`) VALUES
(12, 1, 9, NULL, 2, 2, 'Expired', 2, '01/30/2023', NULL, '02/01/2023', NULL, '6700', 0, 0, 0, NULL, '2023-01-29 12:54:31', 0, '2023-01-29 11:54:31', '2023-01-29 11:54:31', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_other_images`
--
ALTER TABLE `room_other_images`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `room_other_images`
--
ALTER TABLE `room_other_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

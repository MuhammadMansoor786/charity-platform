-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 25, 2026 at 10:21 PM
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
-- Database: `charity_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

CREATE TABLE `campaigns` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `goal_amount` decimal(10,2) NOT NULL,
  `raised_amount` decimal(10,2) DEFAULT 0.00,
  `status` enum('active','completed') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `title`, `description`, `goal_amount`, `raised_amount`, `status`, `created_at`) VALUES
(1, 'Education for Orphans', 'Har bachay ko taleem dene ke liye is campaign ka hissa banein.', 50000.00, 197105.00, 'active', '2026-09-22 19:05:49'),
(2, 'Clean Water Project', 'Gharib ilaqon mein saaf pani ke tube-well lagane ki muhim.', 100000.00, 38163282.00, 'active', '2026-09-22 19:05:49'),
(3, 'Be Saharo Ka Sahara ', 'is compaign mai hum road ke consruction, nimaz janza kai doran jo traffic hota wo controle karengai, our ghareeb logo ke madad karengay, wagera wagera. ', 100000.00, 10000.00, 'active', '2026-09-23 07:18:57'),
(4, 'Da Haya Sadar', 'Pa De Group Ke Ba Tool Da Dawood Shah Fan Ye. ', 50000.00, 50000.00, 'active', '2026-09-23 07:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `campaign_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `campaign_id`, `amount`, `donation_date`) VALUES
(1, 8, 1, 6.00, '2026-09-22 19:07:22'),
(2, 8, 2, 12.00, '2026-09-22 19:07:28'),
(3, 8, 1, 20000.00, '2026-09-22 19:08:14'),
(4, 8, 2, 20000.00, '2026-09-22 19:08:19'),
(5, 8, 1, 12000.00, '2026-09-22 19:19:09'),
(6, 8, 2, 19999.00, '2026-09-22 19:19:13'),
(7, 8, 2, 12200.00, '2026-09-22 19:34:44'),
(8, 8, 1, 50000.00, '2026-09-22 19:35:18'),
(9, 12, 1, 12999.00, '2026-09-22 19:37:25'),
(10, 12, 2, 37865873.00, '2026-09-22 19:37:29'),
(11, 1, 1, 90000.00, '2026-09-22 19:42:02'),
(12, 1, 2, 99999.00, '2026-09-22 19:42:06'),
(13, 1, 2, 99999.00, '2026-09-22 19:50:58'),
(14, 17, 1, 100.00, '2026-09-23 07:12:06'),
(15, 17, 2, 200.00, '2026-09-23 07:12:13'),
(16, 1, 3, 10000.00, '2026-09-23 07:19:10'),
(17, 1, 4, 50000.00, '2026-09-23 07:31:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','donor') DEFAULT 'donor',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Muhammad Mansoor', 'pro924432@gmail.com', '$2y$10$5zfs6sujsk5thodibkO5LeFS94URu5zTVKrURh.XbjjsSdNGfpPvy', 'admin', '2026-09-22 18:42:09'),
(3, 'nasir', 'adminn@digitalshop.com', '$2y$10$Bv8WeGYA2hhvtZ.P/GbofeTuAsfilEBbQ72NmHsAiJzK.EFMHX4Ne', 'donor', '2026-09-22 18:42:51'),
(8, 'mansoor ', 'mansoor11@gmail.com', '$2y$10$O/j/S1dh4d5PuF5tvToa1uMwbY3Qo1eWqY/ec7cBVfgNx2sAuXJ5a', 'donor', '2026-09-22 18:55:17'),
(9, 'izaz ', 'izaz123@gmai.com', '$2y$10$/ditR50FksYCiJvLZmy5NuDtSLEUfoRxBSBwFzd7er941AF.rEQVK', 'donor', '2026-09-22 19:03:25'),
(12, 'sayyed', 'sayedeed12@gmail.com', '$2y$10$8ERqvfvRfdpvKs4aGTJYVuxsGlA2CNpGz.8z3j/MCxmlRrw1Q/3Ym', 'donor', '2026-09-22 19:36:59'),
(13, 'saeed', 'saeeed@gmail.com', '$2y$10$qCw/rasK9zNChYg79Du4g.iuRHqfI7Hq1yYEQbJK4Kw7p2pHDOtxO', 'donor', '2026-09-22 19:42:27'),
(14, 'khan', 'khan1122@gmail.com', '$2y$10$ZvQvS9PHqxwvQcGS6j8evO9fzQrZpNahdAGSVxrD.LjpA/XgRVR/u', 'donor', '2026-09-22 19:42:57'),
(15, 'adnan', 'adnan22@gmail.com', '$2y$10$DYZQB.sFSIakJ1Xsq1t/jeDW8nN9Hh0avrMLH.IWd1kRqqHEIqdDK', 'donor', '2026-09-23 05:39:35'),
(16, 'adnan', 'adnan11@gmail.com', '$2y$10$om68N..WinMPmpJ/PpmxleuVk5QhXuBCIl4EwFGGdS.4/DStWy3vG', 'donor', '2026-09-23 05:40:59'),
(17, 'shahbeer ', 'shahbeer123@gmail.com', '$2y$10$uQnOMmSguqvjJHttI4mpT.X29./q0yYxH6TAz/XIIwVCKATuEgHVm', 'donor', '2026-09-23 07:01:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `campaign_id` (`campaign_id`);

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
-- AUTO_INCREMENT for table `campaigns`
--
ALTER TABLE `campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `campaigns` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2024 at 08:24 PM
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
-- Database: `presentation_invite_creator`
--

-- --------------------------------------------------------

--
-- Table structure for table `invite_log`
--

CREATE TABLE `invite_log` (
  `id` int(11) NOT NULL,
  `faculty_number` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invite_log`
--

INSERT INTO `invite_log` (`id`, `faculty_number`, `email`, `status`) VALUES
(1, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'not sent'),
(2, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(3, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(4, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'not sent'),
(5, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(6, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(7, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(8, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(9, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(10, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(11, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(12, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(13, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(14, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(15, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(16, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(17, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(18, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(19, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(20, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(21, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(22, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(23, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(24, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(25, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent'),
(26, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'failed'),
(27, 'd', 'aleksandar.sv.kiryakov@gmail.com', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `memes`
--

CREATE TABLE `memes` (
  `id` int(11) NOT NULL,
  `meme_image` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'a', 'sashko159@abv.bg', '$2y$10$hwbZSZuY/nKwhMW9GuLsleekZB/ofaiJs7qfV0JilNQLNMifpnXvO', '2024-06-13 00:27:24'),
(2, 'v', 'v@abv.bg', '$2y$10$/pGSix/kHX/ldJv.wonYOuKHwLItaYvhHxI6XL2W5SJs7sDd0QCM.', '2024-06-13 00:34:05'),
(9, 'vdas', 'vca@abv.bg', '$2y$10$Hbvt30E19Iuwk0W8S2mzRecprUSiUXTkxBBDxoDyvdJM78u3hAkeu', '2024-06-13 00:36:42'),
(17, 'ads', 'arrs@abv.bg', '$2y$10$2w.sIY2jKgrihB5KB8Xhh.135AeadhOdLEiRb4dWg2cp7hzQUarVu', '2024-06-13 00:43:37'),
(18, 'r', 'aca@abv.bg', '$2y$10$1c6tcC/fPfxG6DoWeXsoLeVn19rRgWVpZnq8catvqxnCCPdQB42ta', '2024-06-13 00:44:04'),
(19, 'dd', 'ddd@abv.bg', '$2y$10$GfqL8NuuE4nV/o3a0w9mceHc4amTsLwM8/cS8NrFLNbAuOYk/VMvq', '2024-06-13 00:45:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invite_log`
--
ALTER TABLE `invite_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invite_log`
--
ALTER TABLE `invite_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `memes`
--
ALTER TABLE `memes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

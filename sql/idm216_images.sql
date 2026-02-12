-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 09, 2026 at 11:45 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idm216`
--

-- --------------------------------------------------------

--
-- Table structure for table `idm216_images`
--

CREATE TABLE `idm216_images` (
  `id` int(10) NOT NULL,
  `image` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_images`
--

INSERT INTO `idm216_images` (`id`, `image`) VALUES
(1, 'media/custom_smoothie.png'),
(2, 'media/fruit_salad.png'),
(3, 'media/pb_banana.png'),
(4, 'media/taro.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm216_images`
--
ALTER TABLE `idm216_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm216_images`
--
ALTER TABLE `idm216_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

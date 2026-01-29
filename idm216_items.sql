-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 29, 2026 at 09:40 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `an943_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `idm216_items`
--

CREATE TABLE `idm216_items` (
  `id` int(1) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `s_price` float(2,2) DEFAULT NULL,
  `m_price` float(2,2) DEFAULT NULL,
  `l_price` float(2,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `idm216_items`
--

INSERT INTO `idm216_items` (`id`, `name`, `s_price`, `m_price`, `l_price`) VALUES
(1, 'Custom Smoothie', 4.00, 5.00, 6.00),
(2, 'Custom Fruit Salad', 4.00, 0.00, 5.00),
(3, 'P.B. Banana Smoothie', 4.00, 5.00, 6.00),
(4, 'Taro Smoothie', 4.50, 5.50, 6.50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm216_items`
--
ALTER TABLE `idm216_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm216_items`
--
ALTER TABLE `idm216_items`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

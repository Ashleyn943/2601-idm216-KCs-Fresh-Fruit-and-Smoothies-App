-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2026 at 11:53 PM
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
-- Table structure for table `idm216_ingredients`
--

CREATE TABLE `idm216_ingredients` (
  `id` int(1) NOT NULL,
  `ingredients` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_ingredients`
--

INSERT INTO `idm216_ingredients` (`id`, `ingredients`) VALUES
(1, 'Strawberry'),
(2, 'Pineapple '),
(3, 'Mixed Berry'),
(4, 'Mango'),
(5, 'Banana'),
(6, 'Kale'),
(7, 'Spinich');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm216_ingredients`
--
ALTER TABLE `idm216_ingredients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm216_ingredients`
--
ALTER TABLE `idm216_ingredients`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

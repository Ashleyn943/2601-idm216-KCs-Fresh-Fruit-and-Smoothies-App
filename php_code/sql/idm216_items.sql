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
-- Table structure for table `idm216_items`
--

CREATE TABLE `idm216_items` (
  `id` int(1) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `description` text,
  `s_price` float(2,2) DEFAULT NULL,
  `m_price` float(2,2) DEFAULT NULL,
  `l_price` float(2,2) DEFAULT NULL,
  `fruit_options` text,
  `add_ons` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_items`
--

INSERT INTO `idm216_items` (`id`, `name`, `description`, `s_price`, `m_price`, `l_price`, `fruit_options`, `add_ons`) VALUES
(1, 'Custom Smoothie', 'A custom blend of your choice of three different ingredients', 4.00, 5.00, 6.00, 'banana, mango, mixed berry, pineapple, strawberry, kale, spinich', 'yogurt, whey protein'),
(2, 'Fruit Salad', 'A mix of fruits in a cup', 4.00, 0.00, 5.00, NULL, NULL),
(3, 'P.B. Banana Smoothie', 'A campus favorite made up of the wonderful combination of banana and peanut butter', 4.00, 5.00, 6.00, NULL, NULL),
(4, 'Taro Smoothie', 'An exclusive smoothie made of the popular tuber: taro!', 4.50, 5.50, 6.50, NULL, NULL);

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

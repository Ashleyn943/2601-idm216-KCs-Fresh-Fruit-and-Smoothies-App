-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2026 at 09:31 PM
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
-- Table structure for table `idm216_addons`
--

CREATE TABLE `idm216_addons` (
  `id` int(1) NOT NULL,
  `add_ons` varchar(12) DEFAULT NULL,
  `price_change` decimal(2,1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_addons`
--

INSERT INTO `idm216_addons` (`id`, `add_ons`, `price_change`) VALUES
(1, 'Yogurt', '0.5'),
(2, 'Whey Protein', '0.5');

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

-- --------------------------------------------------------

--
-- Table structure for table `idm216_items`
--

CREATE TABLE `idm216_items` (
  `id` int(1) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `description` text,
  `fruit_options` text,
  `add_ons` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_items`
--

INSERT INTO `idm216_items` (`id`, `name`, `description`, `fruit_options`, `add_ons`) VALUES
(1, 'Custom Smoothie', 'A custom blend of your choice of three different ingredients', 'banana, mango, mixed berry, pineapple, strawberry, kale, spinich', 'yogurt, whey protein'),
(2, 'Fruit Salad', 'A mix of fruits in a cup', NULL, NULL),
(3, 'P.B. Banana Smoothie', 'A campus favorite made up of the wonderful combination of banana and peanut butter', NULL, NULL),
(4, 'Taro Smoothie', 'An exclusive smoothie made of the popular tuber: taro!', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `idm216_orders`
--

CREATE TABLE `idm216_orders` (
  `id` int(11) NOT NULL,
  `item_id` int(10) DEFAULT NULL,
  `size` varchar(10) DEFAULT NULL,
  `item_price` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `idm216_prices`
--

CREATE TABLE `idm216_prices` (
  `id` int(100) NOT NULL,
  `item_id` int(100) DEFAULT NULL,
  `s_price` float(10,2) DEFAULT NULL,
  `m_price` float(10,2) DEFAULT NULL,
  `l_price` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `idm216_prices`
--

INSERT INTO `idm216_prices` (`id`, `item_id`, `s_price`, `m_price`, `l_price`) VALUES
(1, 1, 4.00, 5.00, 6.00),
(2, 2, 4.00, NULL, 5.00),
(3, 3, 4.00, 5.00, 6.00),
(4, 4, 4.50, 5.50, 6.50);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm216_addons`
--
ALTER TABLE `idm216_addons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idm216_images`
--
ALTER TABLE `idm216_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idm216_ingredients`
--
ALTER TABLE `idm216_ingredients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idm216_items`
--
ALTER TABLE `idm216_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idm216_orders`
--
ALTER TABLE `idm216_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `idm216_prices`
--
ALTER TABLE `idm216_prices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm216_addons`
--
ALTER TABLE `idm216_addons`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `idm216_images`
--
ALTER TABLE `idm216_images`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `idm216_ingredients`
--
ALTER TABLE `idm216_ingredients`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `idm216_items`
--
ALTER TABLE `idm216_items`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `idm216_orders`
--
ALTER TABLE `idm216_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `idm216_prices`
--
ALTER TABLE `idm216_prices`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

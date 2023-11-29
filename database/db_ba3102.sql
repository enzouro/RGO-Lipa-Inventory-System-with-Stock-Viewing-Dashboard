-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 04:52 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ba3102`
--

-- --------------------------------------------------------

--
-- Table structure for table `instocks_details`
--

CREATE TABLE `instocks_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `added_qnt` int(11) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `empid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instocks_details`
--

INSERT INTO `instocks_details` (`id`, `product_id`, `added_qnt`, `received_date`, `empid`) VALUES
(1, 3, 2, '2023-11-28', 0),
(2, 4, 5, '2023-11-28', 0),
(3, 5, 10, '2023-11-28', 0),
(20, 3, 5, '2023-11-29', 0),
(21, 3, 5, '2023-11-29', 0),
(22, 3, 4, '2023-11-29', 2),
(23, 3, 4, '2023-11-29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `in_stocks`
--

CREATE TABLE `in_stocks` (
  `product_id` int(11) NOT NULL,
  `stocks_qnt` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `in_stocks`
--

INSERT INTO `in_stocks` (`product_id`, `stocks_qnt`) VALUES
(3, 449),
(4, 172),
(5, 21),
(6, 20),
(7, 93),
(8, 106),
(9, 40),
(10, 55),
(11, 75),
(12, 75),
(13, 60),
(14, 85),
(15, 95),
(16, 105),
(17, 45),
(18, 60),
(19, 0),
(20, 0),
(21, 0);

-- --------------------------------------------------------

--
-- Table structure for table `outstocks_details`
--

CREATE TABLE `outstocks_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `out_qnt` int(11) DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `empid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outstocks_details`
--

INSERT INTO `outstocks_details` (`id`, `product_id`, `out_qnt`, `received_date`, `empid`) VALUES
(1, 6, 5, '2023-11-28', 0),
(2, 8, 10, '2023-11-28', 0),
(3, 13, 5, '2023-11-28', 0),
(4, 4, 1, '2023-11-28', 0),
(7, 3, 18, '2023-11-28', 0),
(9, 5, 4, '2023-11-28', 0),
(15, 3, 6, '2023-11-29', 0),
(16, 3, 100, '2023-11-29', 0),
(17, 4, 5, '2023-11-29', 2),
(18, 3, 17, '2023-11-29', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `image`) VALUES
(3, 'Product C', 'Description for Product C', 30.00, NULL),
(4, 'Product D', 'Description for Product D', 35.00, NULL),
(5, 'Product E', 'Description for Product E', 40.00, NULL),
(6, 'Product F', 'Description for Product F', 45.00, NULL),
(7, 'Product G', 'Description for Product G', 50.00, NULL),
(8, 'Product H', 'Description for Product H', 55.00, NULL),
(9, 'Product I', 'Description for Product I', 60.00, NULL),
(10, 'Product J', 'Description for Product J', 65.00, NULL),
(11, 'Product K', 'Description for Product K', 70.00, NULL),
(12, 'Product L', 'Description for Product L', 75.00, NULL),
(13, 'Product M', 'Description for Product M', 80.00, NULL),
(14, 'Product N', 'Description for Product N', 85.00, NULL),
(15, 'Product O', 'Description for Product O', 90.00, NULL),
(16, 'Product P', 'Description for Product P', 95.00, NULL),
(17, 'Product Q', 'Description for Product Q', 100.00, NULL),
(18, 'Product R', 'Description for Product R', 105.00, NULL),
(19, 'GGs', 'GGs', 123.00, NULL),
(20, 'GGG', 'GGG', 123.00, NULL),
(21, 'GGG', 'GG', 3.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rgouser`
--

CREATE TABLE `rgouser` (
  `id` int(11) NOT NULL,
  `empid` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) DEFAULT NULL,
  `role` enum('admin','employee','client','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rgouser`
--

INSERT INTO `rgouser` (`id`, `empid`, `username`, `password`, `role`) VALUES
(1, 1, 'admin', 'admRGO', 'admin'),
(2, 2, 'employee', 'empRGO', 'employee'),
(3, 0, 'client', 'RGO', 'client');

-- --------------------------------------------------------

--
-- Table structure for table `tbempinfo`
--

CREATE TABLE `tbempinfo` (
  `empid` int(11) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `department` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbempinfo`
--

INSERT INTO `tbempinfo` (`empid`, `lastname`, `firstname`, `department`) VALUES
(1, 'aguila', 'nina', 'cics'),
(2, 'mayo', 'john', 'cics');

-- --------------------------------------------------------

--
-- Table structure for table `tb_studinfo`
--

CREATE TABLE `tb_studinfo` (
  `studid` int(11) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `course` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_studinfo`
--

INSERT INTO `tb_studinfo` (`studid`, `lastname`, `firstname`, `course`) VALUES
(1, 'parker', 'peter', 'bsit'),
(2, 'kent', 'clark', 'bscs');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instocks_details`
--
ALTER TABLE `instocks_details`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `in_stocks`
--
ALTER TABLE `in_stocks`
  ADD KEY `FK_Products_Stocks` (`product_id`);

--
-- Indexes for table `outstocks_details`
--
ALTER TABLE `outstocks_details`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD KEY `idx_product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instocks_details`
--
ALTER TABLE `instocks_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `outstocks_details`
--
ALTER TABLE `outstocks_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `in_stocks`
--
ALTER TABLE `in_stocks`
  ADD CONSTRAINT `in_stocks_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

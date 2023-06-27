-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2022 at 08:23 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `after_sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `buys`
--

CREATE TABLE `buys` (
  `invoiceNo` int(11) NOT NULL,
  `aadhar` bigint(12) NOT NULL,
  `dateOfPurchase` date NOT NULL,
  `productId` int(11) NOT NULL,
  `sellerId` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `buys`
--

INSERT INTO `buys` (`invoiceNo`, `aadhar`, `dateOfPurchase`, `productId`, `sellerId`, `price`) VALUES
(1, 9850339380, '2022-10-20', 8, 5, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customerId` int(11) NOT NULL,
  `customerName` varchar(128) NOT NULL,
  `customerAddress` varchar(256) NOT NULL,
  `customerPincode` int(6) NOT NULL,
  `customerMobile` bigint(10) NOT NULL,
  `customerEmail` varchar(128) NOT NULL,
  `customerAadhar` bigint(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customerId`, `customerName`, `customerAddress`, `customerPincode`, `customerMobile`, `customerEmail`, `customerAadhar`) VALUES
(1, 'Rudra Chopde', 'A-303, Sun Universe, Nahre, Pune', 411041, 9850339380, 'rudrachopde@gmail.com', 852174963251),
(5, 'Gautam Deshpande', 'DP Road, Kothrud Pune', 411038, 7588115115, 'gdeshpande14@gmail.com', 741285693320),
(9, 'Tanmay Devare', 'DP Road, Kothrud Pune', 411038, 9588115115, 'tanmayd52002@gmail.com', 941285693320),
(11, 'Vaibhav Gurap', 'G-603, Padmavati Hills, Bavdhan Budruk,Pune', 411021, 7588115116, 'gurapvaibhav@gmail.com', 711223459631);

-- --------------------------------------------------------

--
-- Table structure for table `dealerserves`
--

CREATE TABLE `dealerserves` (
  `dealerId` int(11) NOT NULL,
  `pincode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dealerserves`
--

INSERT INTO `dealerserves` (`dealerId`, `pincode`) VALUES
(2, 0),
(3, 0),
(3, 0),
(3, 0),
(4, 411021),
(4, 411038),
(4, 411041);

-- --------------------------------------------------------

--
-- Table structure for table `policies`
--

CREATE TABLE `policies` (
  `policyId` int(11) NOT NULL,
  `replacableMonths` int(11) NOT NULL COMMENT 'in months',
  `freeRepairMonths` int(11) NOT NULL COMMENT 'in months',
  `warrantyPeriod` int(11) NOT NULL COMMENT 'in months'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `policies`
--

INSERT INTO `policies` (`policyId`, `replacableMonths`, `freeRepairMonths`, `warrantyPeriod`) VALUES
(2, 6, 24, 24),
(3, 12, 24, 24);

-- --------------------------------------------------------

--
-- Table structure for table `problemhas`
--

CREATE TABLE `problemhas` (
  `productId` int(11) NOT NULL,
  `problemId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problemhas`
--

INSERT INTO `problemhas` (`productId`, `problemId`) VALUES
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `problemId` int(11) NOT NULL,
  `problem` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`problemId`, `problem`) VALUES
(1, 'Tub Not Spinning'),
(2, 'Display Not Working');

-- --------------------------------------------------------

--
-- Table structure for table `producthas`
--

CREATE TABLE `producthas` (
  `productId` int(11) NOT NULL,
  `policyId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `producthas`
--

INSERT INTO `producthas` (`productId`, `policyId`) VALUES
(8, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL,
  `productName` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productId`, `productName`) VALUES
(4, 'LG Washing Machine 18L'),
(5, 'LG TV 42 inch'),
(6, 'LG TV 32 inch'),
(8, 'LG TV 21 inch');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `sellerId` int(11) NOT NULL,
  `sellerName` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`sellerId`, `sellerName`, `city`, `mobile`, `uid`) VALUES
(1, 'Vijay Sales', 'Pune', 0, 0),
(2, 'Croma', 'Pune', 0, 0),
(5, 'Croma', 'Mumbai', 8520741963, 7);

-- --------------------------------------------------------

--
-- Table structure for table `serveby`
--

CREATE TABLE `serveby` (
  `requestId` int(11) NOT NULL,
  `dealerId` int(11) NOT NULL,
  `technicianId` int(11) NOT NULL,
  `serviceDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `servicedealer`
--

CREATE TABLE `servicedealer` (
  `dealerId` int(11) NOT NULL,
  `dealerName` varchar(128) NOT NULL,
  `dealerMobile` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `servicedealer`
--

INSERT INTO `servicedealer` (`dealerId`, `dealerName`, `dealerMobile`, `uid`) VALUES
(4, 'ABC Enterprises', 7410852963, 11);

-- --------------------------------------------------------

--
-- Table structure for table `servicerequest`
--

CREATE TABLE `servicerequest` (
  `requestId` int(11) NOT NULL,
  `customerId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `invoiceNo` int(11) NOT NULL,
  `problemId` int(11) NOT NULL,
  `problemDescription` varchar(256) NOT NULL,
  `requestDate` date NOT NULL,
  `status` enum('request received','pending','completed','cancelled') NOT NULL,
  `cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE `technicians` (
  `technicianId` int(11) NOT NULL,
  `technicianName` varchar(128) NOT NULL,
  `technicianMobile` bigint(20) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`technicianId`, `technicianName`, `technicianMobile`, `uid`) VALUES
(2, 'Ramesh Yadav', 9635287410, 13);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `type` enum('customer','admin','seller','service_dealer','technician') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `email`, `password`, `type`) VALUES
(1, 'rudrachopde@gmail.com', 'rudrachopde@123', 'customer'),
(2, 'gdeshpande14@gmail.com', 'gdeshpande14', 'customer'),
(3, 'tanmayd52002@gmail.com', 'tanmayd52002', 'customer'),
(4, 'gurapvaibhav@gmail.com', 'kngurap2002', 'admin'),
(7, 'cromamumbai@demo.com', 'croma123', 'seller'),
(11, 'abc@demo.com', 'abc123', 'service_dealer'),
(13, 'ramesh@demo.com', 'ramesh123', 'technician');

-- --------------------------------------------------------

--
-- Table structure for table `worksfor`
--

CREATE TABLE `worksfor` (
  `technicianId` int(11) NOT NULL,
  `dealerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `worksfor`
--

INSERT INTO `worksfor` (`technicianId`, `dealerId`) VALUES
(2, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buys`
--
ALTER TABLE `buys`
  ADD PRIMARY KEY (`invoiceNo`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerId`),
  ADD UNIQUE KEY `customerEmail` (`customerEmail`);

--
-- Indexes for table `policies`
--
ALTER TABLE `policies`
  ADD PRIMARY KEY (`policyId`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`problemId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`sellerId`);

--
-- Indexes for table `servicedealer`
--
ALTER TABLE `servicedealer`
  ADD PRIMARY KEY (`dealerId`);

--
-- Indexes for table `servicerequest`
--
ALTER TABLE `servicerequest`
  ADD PRIMARY KEY (`requestId`);

--
-- Indexes for table `technicians`
--
ALTER TABLE `technicians`
  ADD PRIMARY KEY (`technicianId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `worksfor`
--
ALTER TABLE `worksfor`
  ADD UNIQUE KEY `unique` (`technicianId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buys`
--
ALTER TABLE `buys`
  MODIFY `invoiceNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `policies`
--
ALTER TABLE `policies`
  MODIFY `policyId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `problemId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `sellerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `servicedealer`
--
ALTER TABLE `servicedealer`
  MODIFY `dealerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `servicerequest`
--
ALTER TABLE `servicerequest`
  MODIFY `requestId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technicians`
--
ALTER TABLE `technicians`
  MODIFY `technicianId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

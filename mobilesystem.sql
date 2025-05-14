-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2025 at 05:52 PM
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
-- Database: `mobilesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accid` int(11) NOT NULL,
  `accnumber` varchar(255) NOT NULL,
  `cid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `linked` enum('yes','no') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accid`, `accnumber`, `cid`, `sid`, `linked`) VALUES
(1, 'ACC0001', 1, 1, 'yes'),
(2, 'ACC002', 2, 2, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `aid` int(11) NOT NULL,
  `aname` varchar(50) NOT NULL,
  `acode` varchar(50) NOT NULL,
  `balance` decimal(9,2) DEFAULT 5000.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`aid`, `aname`, `acode`, `balance`) VALUES
(1, 'gervais', 'AGT001', 18000.00),
(2, 'gervais', 'AGT002', 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `approvals`
--

CREATE TABLE `approvals` (
  `apid` int(11) NOT NULL,
  `accid` int(11) NOT NULL,
  `sid` int(11) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approvals`
--

INSERT INTO `approvals` (`apid`, `accid`, `sid`, `descriptions`, `created_at`) VALUES
(1, 1, 1, 'Deposit', '2025-05-14 06:46:24'),
(2, 1, 2, 'withdraw', '2025-05-14 06:49:30'),
(3, 1, 2, 'deposit', '2025-05-14 07:01:40'),
(13, 1, 1, 'wgkfjmhsgrzxcjvkjb', '2025-05-14 11:33:10'),
(16, 2, 2, 'kfjddjjdsdy', '2025-05-14 11:39:27'),
(18, 2, 2, 'hello again', '2025-05-14 12:55:20'),
(22, 2, 2, 'hello again', '2025-05-14 13:07:43'),
(24, 2, 2, 'hello again', '2025-05-14 13:24:39'),
(25, 2, 2, 'hello again', '2025-05-14 13:25:32'),
(26, 2, 2, 'hello what', '2025-05-14 13:26:23'),
(27, 2, 2, 'hello what', '2025-05-14 13:38:53'),
(28, 2, 2, 'hello then', '2025-05-14 13:39:38'),
(29, 2, 2, 'hello then', '2025-05-14 14:57:27'),
(30, 2, 2, 'hello then', '2025-05-14 15:17:04'),
(31, 2, 2, 'hello then', '2025-05-14 15:17:18'),
(32, 2, 2, 'hello then', '2025-05-14 15:17:55'),
(33, 2, 2, 'hello then', '2025-05-14 15:28:03'),
(34, 2, 2, 'hello then', '2025-05-14 15:29:15'),
(35, 2, 2, 'hello then', '2025-05-14 15:32:57'),
(36, 2, 2, 'hello then', '2025-05-14 15:33:12'),
(37, 2, 2, 'hello then', '2025-05-14 15:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bid` int(11) NOT NULL,
  `bname` varchar(50) NOT NULL,
  `blocation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bid`, `bname`, `blocation`) VALUES
(1, 'BK', 'Kigali'),
(2, 'GT Bank', 'Kigali'),
(3, 'BRD', 'Kigali');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `cid` int(11) NOT NULL,
  `cfname` varchar(50) NOT NULL,
  `clname` varchar(50) NOT NULL,
  `pin` int(11) NOT NULL,
  `bid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`cid`, `cfname`, `clname`, `pin`, `bid`) VALUES
(1, 'Nizeyimana', 'Gervais', 1111, 1),
(2, 'Gaelle', 'Ishimwe', 1111, 3);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `sid` int(11) NOT NULL,
  `sfname` varchar(50) NOT NULL,
  `slname` varchar(50) NOT NULL,
  `phoneNumber` varchar(50) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `balance` decimal(9,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`sid`, `sfname`, `slname`, `phoneNumber`, `pin`, `balance`) VALUES
(1, 'Nizeyimana ', 'Gervais', '+250786139330', '1111', 0.00),
(2, 'gahire', 'Muhire', '+250782246180', '1111', 5000.00),
(3, 'Nizeyimana ', 'Gervais', '+250785342178', '1111', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `tid` int(11) NOT NULL,
  `type` enum('send money to bank','get money from bank','link account','send money','withdraw money') NOT NULL,
  `status` enum('success','fail','pending') NOT NULL,
  `description` text DEFAULT NULL,
  `sid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`tid`, `type`, `status`, `description`, `sid`) VALUES
(1, 'send money to bank', 'success', 'khgfdsazxfghj', 1),
(2, 'send money to bank', 'success', 'jhgfdsxfghj', 1),
(3, 'send money to bank', 'success', 'jghdsgfdgfhjgkh', 2),
(4, 'send money to bank', 'success', 'uyydxcjvkbi', 2),
(5, 'send money to bank', 'success', 'END You\'ve sent 2000 to ACC0001\n', 2),
(6, 'send money to bank', 'success', 'END You\'ve sent 2000 to ACC0001\n', 2),
(7, 'get money from bank', 'success', 'You\'ve sent 200 to your mobile account from ACC0001 bank Account\n', 2),
(8, 'send money to bank', 'success', 'END You\'ve sent 2000 to ACC0001\n', 2),
(9, 'get money from bank', 'success', 'You\'ve sent 2000 to your mobile account from ACC0001 bank Account\n', 2),
(10, 'send money to bank', 'success', 'END You\'ve sent 200 to ACC0001\n', 2),
(11, 'send money to bank', 'success', 'END You\'ve sent 200 to ACC0001\n', 2),
(12, 'send money to bank', 'success', 'END You\'ve sent 100 to acc0001\n', 2),
(13, 'send money to bank', 'success', 'END You\'ve sent 100 to ACC0001\n', 2),
(14, 'send money to bank', 'success', 'END You\'ve sent 1000 to ACC0001\n', 2),
(15, 'send money to bank', 'success', 'END You\'ve sent 1000 to ACC0001\n', 2),
(16, 'send money to bank', 'success', 'END You\'ve sent 1000 to ACC0001\n', 2),
(17, 'send money to bank', 'success', 'END You\'ve sent 111 to ACC0001\n', 2),
(18, 'send money to bank', 'success', 'END You\'ve sent 1000 to acc0001\n', 2),
(19, 'send money to bank', 'success', 'END You\'ve sent 1000 to acc0001\n', 2),
(20, 'send money to bank', 'success', 'END You\'ve sent 1000 to acc0001\n', 2),
(21, 'send money to bank', 'success', 'END You\'ve sent 111 to acc0001\n', 2),
(22, 'send money to bank', 'success', 'END You\'ve sent 1000 to acc0001\n', 2),
(23, 'send money to bank', 'success', NULL, 2),
(24, 'send money to bank', 'success', NULL, 2),
(25, 'send money to bank', 'success', NULL, 2),
(26, 'send money to bank', 'success', NULL, 2),
(27, 'send money to bank', 'success', NULL, 2),
(28, 'send money to bank', 'success', NULL, 2),
(29, 'send money to bank', 'success', NULL, 2),
(30, 'send money to bank', 'success', NULL, 2),
(31, 'send money to bank', 'success', NULL, 2),
(32, 'send money to bank', 'success', NULL, 2),
(33, 'withdraw money', 'success', ' You\'ve withdrawn 2000 from your Mobile account', 1),
(34, 'withdraw money', 'success', ' You\'ve withdrawn 2000 from your Mobile account', 1),
(35, 'withdraw money', 'success', ' You\'ve withdrawn 2000 from your Mobile account', 1),
(36, 'withdraw money', 'success', ' You\'ve withdrawn 1000 from your Mobile account', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accid`),
  ADD UNIQUE KEY `accnumber` (`accnumber`),
  ADD UNIQUE KEY `cid` (`cid`),
  ADD UNIQUE KEY `sid` (`sid`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`aid`),
  ADD UNIQUE KEY `acode` (`acode`);

--
-- Indexes for table `approvals`
--
ALTER TABLE `approvals`
  ADD PRIMARY KEY (`apid`),
  ADD KEY `aid` (`accid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bid`),
  ADD UNIQUE KEY `bname` (`bname`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`cid`),
  ADD KEY `bid` (`bid`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `sid` (`sid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `approvals`
--
ALTER TABLE `approvals`
  MODIFY `apid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `clients` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_constraint_sid` FOREIGN KEY (`sid`) REFERENCES `subscribers` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `approvals`
--
ALTER TABLE `approvals`
  ADD CONSTRAINT `approvals_ibfk_1` FOREIGN KEY (`accid`) REFERENCES `agents` (`aid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `approvals_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `subscribers` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_ibfk_1` FOREIGN KEY (`bid`) REFERENCES `banks` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `subscribers` (`sid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

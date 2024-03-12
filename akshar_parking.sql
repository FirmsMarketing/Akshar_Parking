-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2024 at 09:45 AM
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
-- Database: `akshar_parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `addtruckdetails`
--

CREATE TABLE `addtruckdetails` (
  `id` int(11) NOT NULL,
  `TruckNumber` varchar(10) NOT NULL,
  `DriverName` varchar(20) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `EntryDateTime` datetime NOT NULL,
  `Flag` int(11) DEFAULT 0,
  `ExitDateTime` datetime DEFAULT NULL,
  `Payments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addtruckdetails`
--

INSERT INTO `addtruckdetails` (`id`, `TruckNumber`, `DriverName`, `PhoneNumber`, `EntryDateTime`, `Flag`, `ExitDateTime`, `Payments`) VALUES
(38, 'GJ16CB3188', 'BHAVIK', '8866682459', '2024-03-12 14:07:00', 0, NULL, NULL),
(39, 'GJ16CB0012', 'BHAVIK', '7202088666', '2024-03-12 14:07:00', 0, NULL, NULL),
(40, 'GJ16CB0012', 'PREET', '7777777778', '2024-03-12 14:13:00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'Ajaysinh', 'Ajaysinh0011@', 1),
(2, 'Parking', 'Parking123@', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addtruckdetails`
--
ALTER TABLE `addtruckdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addtruckdetails`
--
ALTER TABLE `addtruckdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

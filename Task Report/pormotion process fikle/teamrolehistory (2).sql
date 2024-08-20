-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2024 at 02:57 PM
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
-- Database: `vsalive2`
--

-- --------------------------------------------------------

--
-- Table structure for table `teamrolehistory`
--

CREATE TABLE `teamrolehistory` (
  `id` int(11) NOT NULL,
  `teammember_id` int(10) NOT NULL,
  `roleid_old` int(11) DEFAULT NULL,
  `roleid_new` int(11) DEFAULT NULL,
  `oldstaff_code` varchar(200) DEFAULT NULL,
  `newstaff_code` varchar(200) DEFAULT NULL,
  `old_staffcodenumber` varchar(200) DEFAULT NULL,
  `new_staffcodenumber` varchar(200) DEFAULT NULL,
  `rejoiningdate` date DEFAULT NULL,
  `rejointimesheetstatus` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teamrolehistory`
--

INSERT INTO `teamrolehistory` (`id`, `teammember_id`, `roleid_old`, `roleid_new`, `oldstaff_code`, `newstaff_code`, `old_staffcodenumber`, `new_staffcodenumber`, `rejoiningdate`, `rejointimesheetstatus`, `created_at`, `updated_at`) VALUES
(11, 868, 14, 13, 'M1048', 'P1011', '1048', '1011', NULL, 0, '2024-07-17 07:27:19', '2024-07-20 07:27:19'),
(12, 902, 15, 13, 'S1059', 'P1012', '1059', '1012', NULL, 0, '2024-07-22 11:40:53', '2024-07-22 11:40:53'),
(14, 847, 14, 13, 'M1027', 'P1013', '1027', '1013', '2024-07-21', 1, '2024-07-24 09:03:14', '2024-07-24 09:03:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teamrolehistory`
--
ALTER TABLE `teamrolehistory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teamrolehistory`
--
ALTER TABLE `teamrolehistory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

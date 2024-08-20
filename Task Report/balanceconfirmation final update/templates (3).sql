-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 11:39 AM
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
-- Database: `vsademo`
--

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `assignmentgenerate_id` varchar(200) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `createdby` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `draftstatus` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `client_id`, `assignmentgenerate_id`, `title`, `type`, `createdby`, `description`, `draftstatus`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'Debtor', 1, NULL, '<p><strong>[name]</strong></p><p><br><strong>Reg .&nbsp; Confirmation of Balance as on [date]&nbsp;</strong></p><p>test<br>Dear Sir,&nbsp;<br>We <strong>M/s K.G.Somani &amp; Co. Chartered accountants</strong> are the statutory Auditors of M/s (the Company) for the Financial Year [year]. For the Audit purpose, we require the confirmation of the outstanding balance of the company in your books of account as on [date].&nbsp;<br><br>We request you to confirm the balance at the place provided below and send the duly signed copy of the same to our address given below. Also share the balance confirmation copy through mail on our mail id <a href=\"mailto:office@kgsomani.com\">test@kgsomani.com</a>&nbsp;<br><br>M/s K G Somani &amp; Co. (Chartered Accountants)<br>3rd Floor, Gate no.2, Delite Cinema Building, Asaf Ali Road,<br>New Delhi – 110002<br><br>An early action would be appreciated&nbsp;<br>&nbsp; &nbsp; &nbsp;<br>Thanking You,&nbsp;<br><br><strong>Yours Faithfully</strong>&nbsp;<br><br><strong>FOR K.G Somani &amp; Co.</strong>&nbsp;<br><strong>Chartered Accountants</strong>&nbsp;<br><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br><br><strong>(Authorised Signatory)</strong></p><p>&nbsp;</p>', 1, '2024-03-30 17:09:29', '2024-03-30 17:09:29'),
(2, NULL, NULL, 'Creditor', 2, NULL, '<p>To &nbsp;[name]</p><p>Dear Sir/Ma’am,</p><p>&nbsp;</p><p>We, VSA , have been authorized video letter dated [date] by M/s ABC Pvt Ltd (hereinafter referred to as “TEV”) to obtain Statement of Accounts / Balance Confirmation from its customers/vendors.</p><p>Your outstanding balance in the books of TEV is Rs. [amount]. We request you to confirm the said balance as on [date] and in case of any mismatch, please indicate the balance in your books giving details of the difference amount or the invoices outstanding.</p><p>In case no reply is received within the below mentioned date, it will deem to be considered that the balance in the books of TEV is correct.</p><p>We would appreciate your prompt response or your reply before [date] and thank you in advance for your kind co-operation.</p><p>&nbsp;</p>', 1, '2024-03-30 17:10:22', '2024-06-07 06:56:25'),
(3, NULL, NULL, 'Bank Confirmation', 3, NULL, '<p><br>To &nbsp;[name]</p><p>Dear Sir/Ma’am,</p><p>&nbsp;</p><p>We, VSA, have been authorized video letter dated [date] by M/s ABC &nbsp;Pvt Ltd (hereinafter referred to as “TEV”) to obtain Statement of Accounts / Balance Confirmation from its customers/vendors.</p><p>Your outstanding balance in the books of TEV is Rs. [amount]. We request you to confirm the said balance as on [date] and in case of any mismatch, please indicate the balance in your books giving details of the difference amount or the invoices outstanding.</p><p>In case no reply is received within the below mentioned date, it will deem to be considered that the balance in the books of TEV is correct.</p><p>We would appreciate your prompt response or your reply before [date] and thank you in advance for your kind co-operation.<br>&nbsp;</p>', 1, '2024-03-30 17:11:08', '2024-06-07 06:56:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

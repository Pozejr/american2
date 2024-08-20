-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2024 at 03:40 PM
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
-- Database: `client_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `check_ins`
--

CREATE TABLE `check_ins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `check_in_time` datetime DEFAULT NULL,
  `check_out_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `check_ins`
--

INSERT INTO `check_ins` (`id`, `name`, `check_in_time`, `check_out_time`) VALUES
(1, 'sammue', '2024-08-20 09:17:03', '2024-08-20 09:34:53'),
(2, 'JOSEPH OMOKE', '2024-08-20 09:21:31', '2024-08-20 09:21:34'),
(3, 'sammue', '2024-08-20 09:34:47', '2024-08-20 09:34:53');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone_no` varchar(20) DEFAULT NULL,
  `id_no` varchar(50) DEFAULT NULL,
  `date_stamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `address` text DEFAULT NULL,
  `check_in` timestamp NULL DEFAULT NULL,
  `check_out` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone_no`, `id_no`, `date_stamp`, `address`, `check_in`, `check_out`) VALUES
(9, 'sammue', NULL, '0794234567', '34353535', '2024-08-14 10:07:48', NULL, '2024-08-17 11:16:35', '2024-08-17 11:21:07'),
(10, 'JOSEPH OMOKE', NULL, '0710153792', 'N/A', '2024-08-15 06:45:28', NULL, '2024-08-17 10:34:22', '2024-08-17 10:43:04'),
(11, 'SAMUEL KUNG\'U', NULL, '0112624259', 'N/A', '2024-08-15 06:47:13', NULL, NULL, NULL),
(12, 'PETER LOTER', NULL, 'N/A', 'N/A', '2024-08-15 06:55:44', NULL, NULL, NULL),
(13, 'ALVIN KAMAU', NULL, '0790965311', 'N/A', '2024-08-15 06:56:36', NULL, NULL, NULL),
(14, 'LOISE WANGECI', NULL, 'N/A', 'N/A', '2024-08-15 06:57:18', NULL, NULL, NULL),
(15, 'DORYN ACHIENG', NULL, 'N/A', 'N/A', '2024-08-15 06:57:46', NULL, NULL, NULL),
(16, 'ERIC MOKUA', NULL, '0771783139', 'N/A', '2024-08-15 07:02:56', NULL, NULL, NULL),
(17, 'DAVID MAINA', NULL, '0720662289', 'N/A', '2024-08-15 07:03:34', NULL, NULL, NULL),
(18, 'FRANCIS NGUGI', NULL, 'N/A', 'N/A', '2024-08-15 07:07:26', NULL, NULL, NULL),
(19, 'KEVIN OGINGA', NULL, '0791891825', '31867585', '2024-08-15 07:10:14', NULL, NULL, NULL),
(20, 'DERRICK MWANGI', NULL, '0745256303', 'N/A', '2024-08-15 07:13:54', NULL, NULL, NULL),
(21, 'VIVIAN', NULL, '0721334283', 'N/A', '2024-08-15 07:15:37', NULL, NULL, NULL),
(22, 'LIAM', NULL, '0714125596', 'N/A', '2024-08-15 07:16:23', NULL, NULL, NULL),
(23, 'CATHERINE', NULL, '0710421032', '40325125', '2024-08-15 07:18:15', NULL, NULL, NULL),
(24, 'JOSHUA', NULL, '0715938026', 'N/A', '2024-08-15 07:19:15', NULL, NULL, NULL),
(25, 'DAVID', NULL, '0717103116', 'N/A', '2024-08-15 07:20:59', NULL, NULL, NULL),
(26, 'FELIX AMATA', NULL, '0719396550', 'N/A', '2024-08-15 07:22:00', NULL, NULL, NULL),
(27, 'JAMES ONYANGO', NULL, 'N/A', 'N/A', '2024-08-15 07:26:55', NULL, NULL, NULL),
(28, 'DESMOND OCHIENG', NULL, 'N/A', 'N/A', '2024-08-15 07:27:27', NULL, NULL, NULL),
(29, 'MARION NALIAKA', NULL, 'N/A', 'N/A', '2024-08-15 07:27:53', NULL, NULL, NULL),
(30, 'DAVID ONYANGO', NULL, 'N/A', 'N/A', '2024-08-15 07:28:23', NULL, NULL, NULL),
(31, 'HENRY KAMUNJERU', NULL, '0745811793', 'N/A', '2024-08-15 07:31:02', NULL, NULL, NULL),
(32, 'DAVID KARIUKI', NULL, '0725227487', 'N/A', '2024-08-15 07:31:40', NULL, NULL, NULL),
(33, 'EPHRAIM JAKES', NULL, '0793715518', 'N/A', '2024-08-15 07:33:03', NULL, NULL, NULL),
(34, 'LEENA ASAD', NULL, '0722436148', 'N/A', '2024-08-15 07:33:41', NULL, NULL, NULL),
(35, 'IVY AUMA', NULL, '071235645', 'N/A', '2024-08-15 07:35:52', NULL, NULL, NULL),
(36, 'AGNES MUTAI', NULL, '0721202120', 'N/A', '2024-08-15 07:36:31', NULL, NULL, NULL),
(37, 'KALEB KOCHEY', NULL, '0724565896', 'N/A', '2024-08-15 07:37:09', NULL, NULL, NULL),
(38, 'REBECCA  AYOM', NULL, '0798494623', 'N/A', '2024-08-15 07:38:28', NULL, NULL, NULL),
(39, 'EMMANUEL MUNENE', NULL, 'N/A', 'N/A', '2024-08-15 07:44:29', NULL, NULL, NULL),
(41, 'SHARON KIBET', NULL, '0758441608', 'N/A', '2024-08-15 07:46:07', NULL, NULL, NULL),
(42, 'JUNE KIBET', NULL, '0758441608', 'N/A', '2024-08-15 07:47:15', NULL, NULL, NULL),
(43, 'JACQUELINE WANAINA', NULL, '0791713978', 'N/A', '2024-08-15 07:51:13', NULL, NULL, NULL),
(44, 'PRIMROSE AKELLO', NULL, '0781681368', '471451655', '2024-08-15 07:52:23', NULL, NULL, NULL),
(45, 'BRANDON OTIENO', NULL, '07Z', '414', '2024-08-15 08:24:47', NULL, NULL, NULL),
(46, 'SAMUEL WAWERU', NULL, '0112029302', 'N/A', '2024-08-15 09:49:34', NULL, NULL, NULL),
(47, 'IAN MUTURI', NULL, '0741942448', 'N/A', '2024-08-15 09:50:13', NULL, NULL, NULL),
(48, 'CYNTHIA AKINYI', NULL, '0781681368', 'N/A', '2024-08-15 09:50:58', NULL, NULL, NULL),
(49, 'NICOLE RAPHAELA', NULL, '0716498827', 'N/A', '2024-08-15 09:52:21', NULL, NULL, NULL),
(50, 'PLISTER AWUOR', NULL, '0714284554', 'N/A', '2024-08-15 09:53:29', NULL, NULL, NULL),
(51, 'VIOLA', NULL, 'N/A', 'N/A', '2024-08-15 09:54:17', NULL, NULL, NULL),
(52, 'JANET WANJA', NULL, '0797562565', 'N/A', '2024-08-15 09:57:52', NULL, NULL, NULL),
(53, 'VIOLA NYABOKE', NULL, '0712505650', 'N/A', '2024-08-15 10:04:51', NULL, NULL, NULL),
(54, 'VICTA ADHIAMBO', NULL, 'N/A', 'N/A', '2024-08-15 10:06:32', NULL, NULL, NULL),
(55, 'NYAKUNDI XAVIERS', NULL, '89030647', 'N/A', '2024-08-15 10:07:38', NULL, NULL, NULL),
(56, 'KIMANI JACKSON', NULL, '0708302164', '40427370', '2024-08-15 10:09:20', NULL, NULL, NULL),
(57, 'FORTUNE MWANGI', NULL, '0703500876', 'N/A', '2024-08-15 10:09:54', NULL, NULL, NULL),
(58, 'SAMANTHA NOEL', NULL, '0727498058', 'N/A', '2024-08-15 10:10:39', NULL, NULL, NULL),
(59, 'EVANS CHEGE', NULL, '0738419238', 'N/A', '2024-08-16 05:10:52', NULL, NULL, NULL),
(60, 'FABREGAS OKELLO', NULL, '0714799991', 'N/A', '2024-08-16 05:11:30', NULL, NULL, NULL),
(61, 'CRILL REAGAN ', NULL, 'N/A', 'N/A', '2024-08-16 05:11:58', NULL, NULL, NULL),
(62, 'GODFREY THUO', NULL, 'N/A', 'N/A', '2024-08-16 05:12:20', NULL, NULL, NULL),
(63, 'TIBERIUS OPAELI', NULL, 'N/A', 'N/A', '2024-08-16 05:13:02', NULL, NULL, NULL),
(64, 'ELI DENGE', NULL, 'N/A', 'N/A', '2024-08-16 05:13:34', NULL, NULL, NULL),
(65, 'JANICE NYARINDA', NULL, 'N/A', 'N/A', '2024-08-16 05:14:07', NULL, NULL, NULL),
(66, 'KENNEDY KESSLER', NULL, '0735711004', 'N/A', '2024-08-16 05:34:29', NULL, NULL, NULL),
(67, 'FRANCIS MWANGI', NULL, 'N/A', 'N/A', '2024-08-16 05:35:19', NULL, NULL, NULL),
(68, 'VICTOR NOBANE', NULL, '0798393627', 'N/A', '2024-08-16 05:36:38', NULL, NULL, NULL),
(69, 'ANN JERONO', NULL, '0796339661', '39188228', '2024-08-16 05:37:31', NULL, NULL, NULL),
(70, 'EMANUEL MWANGI', NULL, '0111208558', 'N', '2024-08-16 10:58:02', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `computer`
--

CREATE TABLE `computer` (
  `id` int(11) NOT NULL,
  `comp_name` varchar(100) NOT NULL,
  `serial_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `computer`
--

INSERT INTO `computer` (`id`, `comp_name`, `serial_no`) VALUES
(1, 'A10', 'E-RESOURCE'),
(2, 'A8', 'E-RESOURCE'),
(3, 'A6', 'E-RESOURCE'),
(4, 'A1', 'E-RESOURCE'),
(5, 'A2', 'E-RESOURCE'),
(6, 'A3', 'E-RESOURCE'),
(7, 'A4', 'E-RESOURCE'),
(8, 'A5', 'E-RESOURCE'),
(9, 'A7', 'E-RESOURCE'),
(10, 'A9', 'E-RESOURCE'),
(11, 'LAPTOP KNLS/NKU(AC)/04/23981', '5CD337F36W'),
(12, 'LAPTOP KNLS/NKU(AC)/04/23980', '5CD337JS4R'),
(13, 'LAPTOP KNLS/NKU(AC)/04/23974', '5CD337JRP5'),
(14, 'LAPTOP KNLS/NKU(AC)/04/23978', '5CD337JTFQ'),
(15, 'LAPTOP KNLS/NKU(AC)/04/23977', '5CD337JRMW'),
(16, 'LAPTOP KNLS/NKU(AC)/04/23982', '5CD337JSSL'),
(17, 'LAPTOP KNLS/NKU(AC)/04/23975', '5CD31088VQ'),
(18, 'LAPTOP KNLS/NKU(AC)/04/23976', '5CD3105ZYN'),
(19, 'LAPTOP KNLS/NKU(AC)/04/23983', '5CD337F36L'),
(20, 'LAPTOP KNLS/NKU(AC)/0423978', '5CD337JSMG');

-- --------------------------------------------------------

--
-- Table structure for table `computer_check_in`
--

CREATE TABLE `computer_check_in` (
  `id` int(11) NOT NULL,
  `comp_name` varchar(100) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `check_in_time` datetime NOT NULL,
  `check_out_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `computer_check_in`
--

INSERT INTO `computer_check_in` (`id`, `comp_name`, `client_name`, `check_in_time`, `check_out_time`) VALUES
(1, 'ERE13', 'kip', '2024-06-22 09:15:57', '2024-06-22 09:33:16'),
(3, '', 'fff', '2024-06-22 10:57:24', NULL),
(6, '222222', 'kip', '2024-06-22 10:27:44', '2024-06-22 10:46:20'),
(7, 'ERE13', 'fff', '2024-06-22 10:34:07', '2024-06-22 10:46:25'),
(8, '222222', 'winner', '2024-06-22 10:34:48', '2024-06-22 10:46:28'),
(11, 'ERE14', 'kip', '2024-06-22 11:11:00', '2024-06-22 11:11:18'),
(12, '222222', 'pov', '2024-06-22 11:11:40', '2024-06-22 11:12:44'),
(13, 'ERE13', 'winner', '2024-06-22 11:11:46', '2024-06-22 11:23:10'),
(15, 'ERE13', 'pov', '2024-06-22 11:23:22', '2024-06-22 11:23:40'),
(16, 'ere34', 'kip', '2024-06-22 12:12:47', '2024-06-22 12:13:12'),
(25, '222222', 'kip', '2024-06-24 16:12:10', '2024-06-24 16:12:51'),
(26, 'ERE14', 'kip', '2024-06-24 16:12:19', '2024-06-24 16:14:52'),
(27, 'ere34', 'kip', '2024-06-24 16:12:27', '2024-06-24 17:16:09'),
(28, 'ERE13', 'fff', '2024-06-24 16:12:34', '2024-06-24 16:13:10'),
(29, '222222', 'kip', '2024-06-24 16:13:02', '2024-06-24 17:16:24'),
(30, 'ERE13', 'winner', '2024-06-24 16:13:19', '2024-06-24 16:13:28'),
(31, 'ERE13', 'winner', '2024-06-24 16:14:03', '2024-06-24 16:14:10'),
(32, 'ERE13', 'pov', '2024-06-24 16:14:44', '2024-06-24 17:16:17'),
(33, '56', 'sammue', '2024-08-14 13:07:52', '2024-08-14 13:07:59'),
(34, 'A3', 'JOSEPH OMOKE', '2024-08-15 09:46:13', '2024-08-15 13:03:42'),
(35, 'A2', 'SAMUEL KUNG', '2024-08-15 09:47:51', '2024-08-16 08:07:13'),
(36, 'A4', 'PETER LOTER', '2024-08-15 09:55:57', '2024-08-16 08:07:18'),
(37, 'A5', 'ALVIN KAMAU', '2024-08-15 09:56:44', '2024-08-15 09:59:29'),
(38, 'A10', 'DORYN ACHIENG', '2024-08-15 09:58:11', '2024-08-15 09:58:30'),
(39, 'A10', 'LOISE WANGECI', '2024-08-15 09:58:37', '2024-08-16 08:07:24'),
(40, 'A9', 'DORYN ACHIENG', '2024-08-15 09:58:46', '2024-08-15 10:06:21'),
(41, 'A7', 'ALVIN KAMAU', '2024-08-15 09:59:37', '2024-08-15 11:01:13'),
(42, 'A5', 'ERIC MOKUA', '2024-08-15 10:03:07', '2024-08-15 11:59:08'),
(43, 'A6', 'ALVIN KAMAU', '2024-08-15 10:03:39', '2024-08-16 08:07:30'),
(44, 'A8', 'FRANCIS NGUGI', '2024-08-15 10:08:34', '2024-08-16 08:07:45'),
(45, 'A1', 'KEVIN OGINGA', '2024-08-15 10:10:29', '2024-08-15 11:55:05'),
(46, 'A9', 'DERRICK MWANGI', '2024-08-15 10:14:02', '2024-08-16 08:07:40'),
(47, '', 'AGNES MUTAI', '2024-08-15 13:16:36', NULL),
(48, '', 'AGNES MUTAI', '2024-08-15 13:19:05', NULL),
(49, 'A1', 'KEVIN OGINGA', '2024-08-16 08:07:07', '2024-08-16 13:51:12'),
(50, 'A5', 'ERIC MOKUA', '2024-08-16 08:09:24', '2024-08-16 08:42:02'),
(51, '', 'AGNES MUTAI', '2024-08-16 08:28:42', NULL),
(52, 'A3', 'ELI DENGE', '2024-08-16 08:31:15', '2024-08-16 15:15:11'),
(53, 'A9', 'FRANCIS NGUGI', '2024-08-16 08:38:10', '2024-08-16 16:01:21'),
(54, 'A4', 'FRANCIS MWANGI', '2024-08-16 08:42:16', '2024-08-16 18:08:58'),
(55, 'A2', 'VICTOR NOBANE', '2024-08-16 08:42:37', '2024-08-16 18:09:43'),
(56, 'A5', 'KENNEDY KESSLER', '2024-08-16 08:43:50', '2024-08-16 18:09:33'),
(57, 'A6', 'PLISTER AWUOR', '2024-08-16 08:45:10', '2024-08-16 18:09:12'),
(58, 'A7', 'DAVID MAINA', '2024-08-16 08:49:12', '2024-08-16 09:26:31'),
(59, 'A8', 'ERIC MOKUA', '2024-08-16 08:49:47', '2024-08-16 13:46:50'),
(60, 'A10', 'TIBERIUS OPAELI', '2024-08-16 08:50:03', '2024-08-16 13:48:44'),
(61, '', 'REBECCA  AYOM', '2024-08-16 08:50:14', NULL),
(62, '', 'PETER LOTER', '2024-08-16 08:50:42', NULL),
(63, '', 'ANN JERONO', '2024-08-16 08:51:07', NULL),
(64, '', 'DERRICK MWANGI', '2024-08-16 08:51:26', NULL),
(65, '', 'CYNTHIA AKINYI', '2024-08-16 08:55:09', NULL),
(66, '', 'AGNES MUTAI', '2024-08-16 13:52:15', NULL),
(67, 'A8', 'EMANUEL MWANGI', '2024-08-16 14:00:42', '2024-08-16 18:09:23'),
(68, 'A7', 'JUNE KIBET', '2024-08-16 14:00:57', '2024-08-16 18:07:04'),
(69, 'A1', 'SHARON KIBET', '2024-08-16 14:01:40', '2024-08-16 18:06:38'),
(70, 'A10', 'PLISTER AWUOR', '2024-08-16 14:02:29', '2024-08-16 18:10:14'),
(71, 'A3', 'AGNES MUTAI', '2024-08-16 16:02:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `type` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `status` enum('available','checked-out','checked-in') DEFAULT 'available',
  `date_registered` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`id`, `client_id`, `type`, `serial_number`, `model`, `status`, `date_registered`) VALUES
(19, '30401678', 'laptop', '45555645675', 'hp', 'checked-in', '2024-08-14 10:18:41'),
(20, '30401678', 'mouse', '4566555', 'hp', 'checked-out', '2024-08-14 10:18:41'),
(21, '30401678', 'laptop', '45555645675', 'hp', 'checked-out', '2024-08-14 14:05:31');

-- --------------------------------------------------------

--
-- Table structure for table `equipment_log`
--

CREATE TABLE `equipment_log` (
  `id` int(11) NOT NULL,
  `equipment_id` int(11) DEFAULT NULL,
  `action` enum('check-in','check-out') NOT NULL,
  `action_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `allocated_day` date DEFAULT NULL,
  `trainer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `name`, `description`, `created_at`, `allocated_day`, `trainer_id`) VALUES
(1, '3D PRINTING', '', '2024-08-14 11:05:10', NULL, NULL),
(2, 'pwd storrytelling', '', '2024-08-14 12:09:46', '2024-08-15', 1),
(4, 'FILMING', '', '2024-08-16 05:17:03', '2024-08-16', 1),
(5, 'FILMING', '', '2024-08-16 06:11:38', '2024-08-16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `program_attendance`
--

CREATE TABLE `program_attendance` (
  `id` int(11) NOT NULL,
  `program_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `attended_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `trainer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_attendance`
--

INSERT INTO `program_attendance` (`id`, `program_id`, `client_id`, `attended_at`, `trainer_id`) VALUES
(13, 1, 44, '2024-08-15 09:07:45', NULL),
(14, 1, 38, '2024-08-15 09:08:03', NULL),
(15, 1, 24, '2024-08-15 09:09:09', NULL),
(16, 1, 25, '2024-08-15 09:10:02', NULL),
(17, 1, 41, '2024-08-15 09:10:19', NULL),
(18, 1, 21, '2024-08-15 09:10:54', NULL),
(19, 1, 42, '2024-08-15 09:11:13', NULL),
(20, 1, 15, '2024-08-15 09:12:12', NULL),
(21, 1, 39, '2024-08-15 09:12:49', NULL),
(22, 1, 51, '2024-08-15 09:54:40', NULL),
(23, 1, 50, '2024-08-15 09:54:57', NULL),
(24, 1, 49, '2024-08-15 09:55:12', NULL),
(25, 1, 48, '2024-08-15 09:55:39', NULL),
(26, 1, 47, '2024-08-15 09:55:52', NULL),
(27, 1, 46, '2024-08-15 09:56:11', NULL),
(28, 1, 47, '2024-08-15 09:56:59', NULL),
(29, 1, 52, '2024-08-15 09:58:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trainers`
--

CREATE TABLE `trainers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers`
--

INSERT INTO `trainers` (`id`, `name`) VALUES
(1, 'CELE');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `profile_pic` varchar(255) DEFAULT 'C:/xampp/htdocs/KNLS/KNLS/images/users'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `profile_pic`) VALUES
(4, 'poze', '', '$2y$10$JOp4kFTbVqnGjhQsYEK./eBpWHa3gCN7cryFQQiGuGUJD.hxgEKCu', 'admin', 'default_profile_pic_url'),
(8, 'william', 'pogba1762@gmail.com', '$2y$10$HX1B5YmnAFgF61P1Z37DSOak8VpzfZthp7Q9DqleknL5Xh5tFIvVe', 'user', 'default_profile_pic_url'),
(9, 'cele', 'pogba1762@gmail.com', '$2y$10$KUJGhlE0CesyzmL.SLkuruWjJd6DZgMZYsO9Nb2YS7bW2Vyiwv.FW', 'user', 'download.jfif'),
(11, 'sammy', 'njorogestanley186@gmail.com', '$2y$10$z9YdzKa2h2oR/Hsts5oe9O.ZaPABl8epiqG.nLBUJl9zJuJ1dcov2', 'user', 'Untitled.jpg'),
(12, 'poppixie', 'poppixieempire@gmail.com', '$2y$10$YJnvrGLOBaXATa8X6ZabHe5AOANDwHBxxlhfey5DFBF71wcvBnrFq', 'user', 'Untitled.jpg'),
(13, 'winner', '7416.2020@students.ku.ac.ke', '$2y$10$SYJxoftYjHn5kvj2EvPC.uiM9Kj1ik.IpaKVJ95c5u9KaHrlVaw0K', 'user', 'download.jfif');

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `login_time` datetime DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `username`, `session_id`, `last_activity`, `login_time`, `logout_time`) VALUES
(1, 'cele', '', '2024-08-20 06:57:40', '2024-08-20 13:01:23', NULL),
(2, 'cele', '', '2024-08-20 10:04:52', '2024-08-20 13:04:52', NULL),
(3, 'cele', '', '2024-08-20 10:05:23', '2024-08-20 13:05:23', NULL),
(4, 'poze', '', '2024-08-20 11:11:36', '2024-08-20 14:11:36', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `computer`
--
ALTER TABLE `computer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `computer_check_in`
--
ALTER TABLE `computer_check_in`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_client_id` (`client_id`);

--
-- Indexes for table `equipment_log`
--
ALTER TABLE `equipment_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_log_ibfk_1` (`equipment_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- Indexes for table `program_attendance`
--
ALTER TABLE `program_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `program_id` (`program_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `trainers`
--
ALTER TABLE `trainers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `computer`
--
ALTER TABLE `computer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `computer_check_in`
--
ALTER TABLE `computer_check_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `equipment_log`
--
ALTER TABLE `equipment_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `program_attendance`
--
ALTER TABLE `program_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `trainers`
--
ALTER TABLE `trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `check_ins_ibfk_1` FOREIGN KEY (`name`) REFERENCES `clients` (`name`);

--
-- Constraints for table `equipment_log`
--
ALTER TABLE `equipment_log`
  ADD CONSTRAINT `equipment_log_ibfk_1` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`);

--
-- Constraints for table `programs`
--
ALTER TABLE `programs`
  ADD CONSTRAINT `programs_ibfk_1` FOREIGN KEY (`trainer_id`) REFERENCES `trainers` (`id`);

--
-- Constraints for table `program_attendance`
--
ALTER TABLE `program_attendance`
  ADD CONSTRAINT `program_attendance_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `program_attendance_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

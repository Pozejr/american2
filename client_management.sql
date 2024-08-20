-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 07:27 AM
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
  `client_name` varchar(255) DEFAULT NULL,
  `check_in_time` datetime DEFAULT current_timestamp(),
  `check_out_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 'sammue', NULL, '0794234567', '34353535', '2024-08-14 10:07:48', NULL, NULL, NULL);

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
(1, 'ERE 13', ''),
(2, 'ERE 14', ''),
(5, 'ERE 15', ''),
(6, 'ERE 11', ''),
(7, 'ERE 17', ''),
(8, 'ERE 12', ''),
(9, 'ERE 16', ''),
(11, '56', '');

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
(33, '56', 'sammue', '2024-08-14 13:07:52', '2024-08-14 13:07:59');

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
(2, 'pwd storrytelling', '', '2024-08-14 12:09:46', '2024-08-15', 1);

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
(1, 1, 9, '2024-08-14 11:05:44', NULL),
(2, 2, 9, '2024-08-14 12:11:11', NULL),
(3, 1, NULL, '2024-08-14 12:20:56', 1),
(4, 1, 9, '2024-08-14 12:21:07', NULL),
(5, 1, 9, '2024-08-14 12:25:46', NULL);

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_name` (`client_name`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `comp_name` (`comp_name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `check_ins`
--
ALTER TABLE `check_ins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `computer`
--
ALTER TABLE `computer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `computer_check_in`
--
ALTER TABLE `computer_check_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `program_attendance`
--
ALTER TABLE `program_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for dumped tables
--

--
-- Constraints for table `check_ins`
--
ALTER TABLE `check_ins`
  ADD CONSTRAINT `check_ins_ibfk_1` FOREIGN KEY (`client_name`) REFERENCES `clients` (`name`);

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

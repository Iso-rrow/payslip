-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2025 at 02:56 PM
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
-- Database: `h_r`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `sent_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `email`, `sent_at`) VALUES
(3, 'intel050305@gmail.com', '2025-06-14 21:23:21'),
(4, 'jon@gmail.com', '2025-06-19 01:42:46'),
(5, 'jima33599@gmail.com', '2025-06-25 12:35:47'),
(6, 'jima33599@gmail.com', '2025-06-26 07:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `auto_employee_id` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `contact_number` varchar(30) NOT NULL,
  `department` varchar(50) NOT NULL,
  `position` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `sss_number` varchar(30) NOT NULL,
  `philhealth_number` varchar(30) NOT NULL,
  `pagibig_number` varchar(30) NOT NULL,
  `tin_number` varchar(30) NOT NULL,
  `salary_rate` decimal(12,2) NOT NULL,
  `payment_method` varchar(30) NOT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `emergency_name` varchar(100) DEFAULT NULL,
  `emergency_phone` varchar(30) DEFAULT NULL,
  `civil_status` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `citizenship` varchar(50) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `documents` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `auto_employee_id`, `first_name`, `last_name`, `email`, `contact_number`, `department`, `position`, `hire_date`, `sss_number`, `philhealth_number`, `pagibig_number`, `tin_number`, `salary_rate`, `payment_method`, `bank_name`, `bank_account`, `address`, `emergency_name`, `emergency_phone`, `civil_status`, `sex`, `citizenship`, `height`, `weight`, `religion`, `documents`, `created_at`) VALUES
(16, NULL, 'Jefffrey', 'Mercado', 'cablestraight@gmail.com', '09983099328', 'IT', 'Hiring Manager', '2025-06-14', '01-234567-89', '1234-5678-91011', '1234-5678-9012', '123-456-789-000', 25555.00, 'Cash', '', '', 'Bel-Air', 'Josephine Mercado', '09491962755', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-14 09:19:49'),
(19, NULL, 'Jefffrey', 'Mercado', 'intel050305@gmail.com', '09983099328', 'IT', 'Hiring Manager', '2025-06-14', '01-234567-89', '1234-5678-91011', '1234-5678-9012', '123-456-789-000', 25555.00, 'Cash', '', '', 'Bel-Air', 'Josephine Mercado', '09491962755', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-14 13:23:18'),
(20, 'EMP-2025 - 5849', 'Jim', 'Mercado', 'jon@gmail.com', '09983099322', 'IT', 'Hiring Manager', '2025-06-19', '01-234567-89', '1234-5678-91011', '1234-5678-9012', '123-456-789-000', 25555.00, 'Cash', '', '', 'Bel-Air', 'Josephine Mercado', '09491962755', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-06-18 17:42:43'),
(22, 'EMP-2025 - 7419', 'Jim', 'Aquino', 'jima33599@gmail.com', '09063957870', 'IT', 'CEO', '2025-06-26', '1233312312', '12412312', '12312312', '123123432354353', 120000000.00, 'Cash', '', '', 'test', 'testtest', '21313123345', 'Married', 'Male', 'Filipino', 190.00, 65.00, 'test', '/h_r_3/uploads/documents/1750893051_AQUINO_RESUME.pdf', '2025-06-25 23:10:51');

-- --------------------------------------------------------

--
-- Table structure for table `time_logs`
--

CREATE TABLE `time_logs` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `time_logs`
--

INSERT INTO `time_logs` (`id`, `employee_id`, `time_in`, `latitude`, `longitude`, `date`, `time_out`) VALUES
(1, '22', '2025-07-02 18:18:11', 14.23000000, 121.05000000, '2025-07-02', '2025-07-02 18:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(201) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `must_change_password` tinyint(1) NOT NULL DEFAULT 1,
  `role` enum('admin','hr','employee','pending') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `password`, `must_change_password`, `role`, `created_at`) VALUES
(15, 16, NULL, 'cablestraight@gmail.com', '$2y$10$WmGnxIhDK1wll7G8WPrA1.ciER82L/D6PtQ.cE0tiyovzRYCZInye', 1, 'employee', '2025-06-14 09:19:49'),
(19, 19, 'Jefffrey Mercado', 'intel050305@gmail.com', '$2y$10$..rddwMHbDaDDyIFg9YbhePoLX.HO3u4AvMadjjCqyBc2Su4D.BpG', 1, 'admin', '2025-06-14 13:23:18'),
(20, 20, 'Jim Mercadosss', 'jon@gmail.com', '$2y$10$wggSW7BMgMQEH1XTkh/6o.GbqcjrqzdxqvrJuZ54pNgrzZSeY85Ui', 1, 'admin', '2025-06-18 17:42:43'),
(22, 22, 'Jim Aquino', 'jima33599@gmail.com', '$2y$10$Shny5c9S8ev4ZgGK27O0Xe7OlzWWPv.JZ565INFbW33aXcHl8HSES', 1, 'employee', '2025-06-25 23:10:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `auto_employee_id` (`auto_employee_id`);

--
-- Indexes for table `time_logs`
--
ALTER TABLE `time_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `time_logs`
--
ALTER TABLE `time_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

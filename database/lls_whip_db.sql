-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 09:24 AM
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
-- Database: `lls_whip_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contractors`
--

CREATE TABLE `contractors` (
  `contractor_id` int(11) NOT NULL,
  `contractor_name` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `province_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `city_code` varchar(255) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `barangay_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `phone_number` varchar(30) DEFAULT NULL,
  `phone_number_owner` varchar(30) DEFAULT NULL,
  `telephone_number` varchar(30) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `proprietor` varchar(255) DEFAULT NULL,
  `status` set('active','inactive') NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contractors`
--

INSERT INTO `contractors` (`contractor_id`, `contractor_name`, `province`, `province_code`, `city`, `city_code`, `barangay`, `barangay_code`, `street`, `phone_number`, `phone_number_owner`, `telephone_number`, `email_address`, `proprietor`, `status`, `added_by`, `created_on`) VALUES
(2, 'DDS Builders', 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Villaflor', '1004209048', NULL, '09399168447', 'Engr. Robert Lamparas', NULL, 'robertlamparas@yahoo.com', 'Denny S. Sasil', 'active', 8, '2024-08-07 03:44:02'),
(3, 'SBU Builders & General Merchandise', 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Poblacion II', '1004209031', NULL, NULL, NULL, '531-1187', 'sbu.construction.supplies@gmail.com', 'William L. Siao', 'active', 8, '2024-08-07 03:46:01'),
(4, 'Lexand Construction & Development', 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, '09073574277', NULL, NULL, 'lim.alexander.1@gmail.com', 'Alexander L. Lim', 'active', 8, '2024-08-07 03:47:59'),
(5, 'Alfahad Builders & Enterprises', 'Lanao del Sur', '1903600000', 'Balindong', '1903603000', NULL, NULL, NULL, '09568804475', NULL, NULL, NULL, 'Abdul Samad P. Amod', 'active', 8, '2024-08-07 03:49:07'),
(6, 'Grace Construction Corporation', 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, 'Grace Compound, Bernad Subdivision', '09100000268', 'Bebot Boligor', '521-1540', 'graceconst@yahoo.com', 'Delwin Vince Y. Chiong', 'active', 9, '2024-08-07 03:51:24');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(150) NOT NULL,
  `middle_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `extension` varchar(150) DEFAULT NULL,
  `province` varchar(255) NOT NULL,
  `province_code` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `city_code` varchar(255) NOT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `barangay_code` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `gender` set('male','female') NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `first_name`, `middle_name`, `last_name`, `extension`, `province`, `province_code`, `city`, `city_code`, `barangay`, `barangay_code`, `street`, `gender`, `contact_number`, `birthdate`, `created_on`) VALUES
(5, 'Robert', NULL, 'Mante', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:50:24'),
(6, 'Jimboy', NULL, 'Beltran', NULL, 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:51:34'),
(7, 'Felix', NULL, 'Handumon', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:52:03'),
(8, 'Harold', NULL, 'Revelo', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-02', '2024-08-08 04:52:33'),
(9, 'Joel', NULL, 'Simbajon', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:53:19'),
(10, 'Julindo', NULL, 'Paculba', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:53:46'),
(11, 'Homar', NULL, 'Yagao', NULL, 'Misamis Occidental', '1004200000', 'City of Ozamiz', '1004210000', NULL, NULL, NULL, 'male', NULL, '2024-08-03', '2024-08-08 04:54:13'),
(12, 'Jed', NULL, 'Adaza', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Langcangan Lower', '1004209017', NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:55:02'),
(13, 'Jennifer', NULL, 'Adaza', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Langcangan Lower', '1004209017', NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:55:30'),
(14, 'Dante', NULL, 'Bitache', NULL, 'Misamis Occidental', '1004200000', 'City of Tangub', '1004215000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:55:59'),
(15, 'Kenneth', NULL, 'Revelo', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:56:31'),
(16, 'Geoffrey', NULL, 'Cabo', NULL, 'Lanao del Norte', '1003500000', 'Linamon', '1003510000', 'Poblacion', '1003510005', NULL, 'male', NULL, '2024-08-05', '2024-08-08 04:57:17'),
(17, 'Johnny', NULL, 'Luste', NULL, 'Misamis Occidental', '1004200000', 'City of Tangub', '1004215000', NULL, NULL, NULL, 'male', NULL, '2024-08-02', '2024-08-08 04:57:40'),
(18, 'Noel', NULL, 'Maturan', NULL, 'Misamis Occidental', '1004200000', 'Tudela', '1004216000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 04:58:14'),
(19, 'Nemecio', NULL, 'Mintang', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-08', '2024-08-08 04:59:09'),
(20, 'Roy', NULL, 'Paculba', NULL, 'Misamis Occidental', '1004200000', 'Clarin', '1004205000', NULL, NULL, NULL, 'male', NULL, '2024-08-01', '2024-08-08 05:00:07'),
(21, 'sample', NULL, 'dasdsad', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Lamac Lower', '1004209015', NULL, 'male', NULL, '2024-08-08', '2024-08-09 10:39:58'),
(22, 'Greg', NULL, 'Rodinas', NULL, 'Misamis Occidental', '1004200000', 'Sinacaban', '1004214000', NULL, NULL, NULL, 'male', NULL, '2024-08-05', '2024-08-11 04:56:27'),
(23, 'Basil John', NULL, 'Manabo', NULL, 'Misamis Occidental', '1004200000', 'City of Oroquieta', '1004209000', 'Langcangan Lower', '1004209017', NULL, 'male', NULL, '2024-08-12', '2024-08-19 14:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `employment_status`
--

CREATE TABLE `employment_status` (
  `employment_status_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employment_status`
--

INSERT INTO `employment_status` (`employment_status_id`, `status`, `created_on`) VALUES
(4, 'Resigned', '2024-08-09 04:31:06'),
(5, 'Terminated', '2024-08-09 04:31:18'),
(6, 'Active', '2024-08-09 04:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `establishments`
--

CREATE TABLE `establishments` (
  `establishment_id` int(11) NOT NULL,
  `establishment_code` varchar(150) NOT NULL,
  `establishment_name` varchar(255) NOT NULL,
  `contact_number` varchar(30) DEFAULT NULL,
  `telephone_number` varchar(30) DEFAULT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `authorized_personnel` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `status` set('active','inactive') NOT NULL,
  `added_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `establishments`
--

INSERT INTO `establishments` (`establishment_id`, `establishment_code`, `establishment_name`, `contact_number`, `telephone_number`, `barangay`, `street`, `email_address`, `authorized_personnel`, `position`, `status`, `added_by`, `created_on`) VALUES
(3, 'ES-001', '1st Valley Bank Inc.', '09178498326', '531 8326', 'Poblacion 1', 'Enanoria Bldg.,Sen. Jose  Oz. St.', 'oroquieta@1stvalleybank.com', 'Ray C. Adala', 'Branch Manager', 'active', 9, '2024-08-12 14:10:54');

-- --------------------------------------------------------

--
-- Table structure for table `establishment_employee`
--

CREATE TABLE `establishment_employee` (
  `establishment_employee_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `nature_of_employment` varchar(255) NOT NULL,
  `status_of_employment_id` int(11) NOT NULL,
  `level_of_employment` set('rank_and_file','managerial','proprietor') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishment_monitoring`
--

CREATE TABLE `establishment_monitoring` (
  `establishment_monitoring_id` int(11) NOT NULL,
  `establishment_id` int(11) NOT NULL,
  `date_of_monitoring` datetime NOT NULL,
  `specific_activity` text NOT NULL,
  `annotations` text NOT NULL,
  `remarks` text DEFAULT NULL,
  `monitoring_status` set('pending','approved') DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `establishment_monitoring_employee`
--

CREATE TABLE `establishment_monitoring_employee` (
  `estab_mon_emp_id` int(11) NOT NULL,
  `establishment_monitoring_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `position_id` int(11) NOT NULL,
  `position` varchar(255) NOT NULL,
  `type` set('lls','whip') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`position_id`, `position`, `type`, `created_on`) VALUES
(4, 'Laborer', 'whip', '2024-08-07 06:01:25'),
(5, 'Foreman', 'whip', '2024-08-07 06:01:28'),
(6, 'Watchman', 'whip', '2024-08-07 06:02:03'),
(7, 'Timekeeper', 'whip', '2024-08-07 06:02:07'),
(8, 'Mason', 'whip', '2024-08-07 06:02:13'),
(11, 'Saleslady', 'lls', '2024-08-12 12:25:46'),
(12, 'Sales Clerk', 'lls', '2024-08-12 12:26:06'),
(13, 'Cashier', 'lls', '2024-08-12 12:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  `project_title` varchar(255) NOT NULL,
  `project_nature_id` int(11) NOT NULL,
  `project_cost` bigint(20) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) DEFAULT NULL,
  `date_started` date NOT NULL,
  `date_completed` date DEFAULT NULL,
  `project_status` set('ongoing','completed') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `contractor_id`, `project_title`, `project_nature_id`, `project_cost`, `barangay`, `street`, `date_started`, `date_completed`, `project_status`, `created_on`) VALUES
(14, 2, 'MULTI PURPOSE BUILDING MOPH OLD', 1, 100000000, 'Langcangan Lower', NULL, '2024-08-19', NULL, 'ongoing', '2024-08-19 14:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `project_employee`
--

CREATE TABLE `project_employee` (
  `project_employee_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `nature_of_employment` varchar(255) NOT NULL,
  `status_of_employment_id` int(11) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `level_of_employment` set('rank_and_file','managerial','proprietor') NOT NULL,
  `project_monitoring_id` int(11) NOT NULL,
  `location_status` set('near','far','within') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_employee`
--

INSERT INTO `project_employee` (`project_employee_id`, `project_id`, `employee_id`, `position_id`, `nature_of_employment`, `status_of_employment_id`, `start_date`, `end_date`, `level_of_employment`, `project_monitoring_id`, `location_status`, `created_on`) VALUES
(61, 13, 14, 5, 'skilled', 6, NULL, NULL, 'rank_and_file', 17, 'far', '2024-08-19 10:49:28'),
(67, 14, 5, 5, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:18:38'),
(68, 14, 6, 7, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:18:55'),
(69, 14, 7, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:19:11'),
(70, 14, 8, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:37:09'),
(71, 14, 9, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:37:28'),
(72, 14, 10, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:37:44'),
(73, 14, 11, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:38:01'),
(74, 14, 14, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:41:20'),
(75, 14, 13, 8, 'skilled', 6, NULL, NULL, 'rank_and_file', 19, 'within', '2024-08-19 14:43:46'),
(76, 14, 22, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:44:56'),
(77, 14, 23, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'within', '2024-08-19 14:49:17'),
(78, 14, 20, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:49:33'),
(79, 14, 19, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:50:12'),
(80, 14, 18, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:51:19'),
(81, 14, 16, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:52:09'),
(82, 14, 15, 4, 'unskilled', 6, NULL, NULL, 'rank_and_file', 19, 'far', '2024-08-19 14:52:26');

-- --------------------------------------------------------

--
-- Table structure for table `project_monitoring`
--

CREATE TABLE `project_monitoring` (
  `project_monitoring_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `whip_code` varchar(255) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date_of_monitoring` date NOT NULL,
  `specific_activity` text NOT NULL,
  `annotations` text DEFAULT NULL,
  `monitoring_status` set('pending','approved') NOT NULL,
  `approved_date` datetime DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_monitoring`
--

INSERT INTO `project_monitoring` (`project_monitoring_id`, `project_id`, `whip_code`, `added_by`, `date_of_monitoring`, `specific_activity`, `annotations`, `monitoring_status`, `approved_date`, `remarks`, `created_on`) VALUES
(16, 12, '', 9, '2024-08-18', 'asdsadasdsadasdsadasdsa', 'asdasdasdasd', 'approved', '2024-08-18 08:31:29', NULL, '2024-08-18 08:30:32'),
(17, 13, '', 9, '2024-08-19', 'sadsad asdsa', 'dsadsadsa', 'pending', NULL, NULL, '2024-08-18 16:07:42'),
(18, 13, '', 9, '2024-08-20', 'asdasd', 'sadsada', 'pending', NULL, NULL, '2024-08-19 14:00:58'),
(19, 14, '', 9, '2024-08-20', 'Excavation/Column Installation', NULL, 'pending', NULL, NULL, '2024-08-19 14:18:03');

-- --------------------------------------------------------

--
-- Table structure for table `project_monitoring_employee`
--

CREATE TABLE `project_monitoring_employee` (
  `proj_mon_emp_id` int(11) NOT NULL,
  `project_monitoring_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_nature`
--

CREATE TABLE `project_nature` (
  `project_nature_id` int(11) NOT NULL,
  `project_nature` varchar(255) NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_nature`
--

INSERT INTO `project_nature` (`project_nature_id`, `project_nature`, `created_on`) VALUES
(1, 'sample', '2024-08-08 06:04:42'),
(2, 'sample 2', '2024-08-08 06:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `remarks_id` int(11) NOT NULL,
  `project_monitoring_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `seen_status` set('unseen','seen') NOT NULL,
  `created_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`remarks_id`, `project_monitoring_id`, `user_id`, `remarks`, `seen_status`, `created_on`) VALUES
(26, 17, 9, 'sadsad', 'seen', '2024-08-19 13:48:38'),
(27, 17, 9, 'asdasdasdsad', 'seen', '2024-08-19 13:48:46'),
(28, 17, 9, 'asdsadssd asdasd', 'seen', '2024-08-19 13:49:36'),
(29, 18, 9, 'asdasdasd', 'seen', '2024-08-19 14:01:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contractors`
--
ALTER TABLE `contractors`
  ADD PRIMARY KEY (`contractor_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `employment_status`
--
ALTER TABLE `employment_status`
  ADD PRIMARY KEY (`employment_status_id`);

--
-- Indexes for table `establishments`
--
ALTER TABLE `establishments`
  ADD PRIMARY KEY (`establishment_id`);

--
-- Indexes for table `establishment_employee`
--
ALTER TABLE `establishment_employee`
  ADD PRIMARY KEY (`establishment_employee_id`);

--
-- Indexes for table `establishment_monitoring`
--
ALTER TABLE `establishment_monitoring`
  ADD PRIMARY KEY (`establishment_monitoring_id`);

--
-- Indexes for table `establishment_monitoring_employee`
--
ALTER TABLE `establishment_monitoring_employee`
  ADD PRIMARY KEY (`estab_mon_emp_id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `project_employee`
--
ALTER TABLE `project_employee`
  ADD PRIMARY KEY (`project_employee_id`);

--
-- Indexes for table `project_monitoring`
--
ALTER TABLE `project_monitoring`
  ADD PRIMARY KEY (`project_monitoring_id`);

--
-- Indexes for table `project_monitoring_employee`
--
ALTER TABLE `project_monitoring_employee`
  ADD PRIMARY KEY (`proj_mon_emp_id`);

--
-- Indexes for table `project_nature`
--
ALTER TABLE `project_nature`
  ADD PRIMARY KEY (`project_nature_id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`remarks_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contractors`
--
ALTER TABLE `contractors`
  MODIFY `contractor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `employment_status`
--
ALTER TABLE `employment_status`
  MODIFY `employment_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `establishments`
--
ALTER TABLE `establishments`
  MODIFY `establishment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `establishment_employee`
--
ALTER TABLE `establishment_employee`
  MODIFY `establishment_employee_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishment_monitoring`
--
ALTER TABLE `establishment_monitoring`
  MODIFY `establishment_monitoring_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `establishment_monitoring_employee`
--
ALTER TABLE `establishment_monitoring_employee`
  MODIFY `estab_mon_emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `project_employee`
--
ALTER TABLE `project_employee`
  MODIFY `project_employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `project_monitoring`
--
ALTER TABLE `project_monitoring`
  MODIFY `project_monitoring_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `project_monitoring_employee`
--
ALTER TABLE `project_monitoring_employee`
  MODIFY `proj_mon_emp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_nature`
--
ALTER TABLE `project_nature`
  MODIFY `project_nature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `remarks_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

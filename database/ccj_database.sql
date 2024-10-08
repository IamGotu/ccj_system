-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2024 at 12:48 PM
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
-- Database: `ccj_database`
--
CREATE DATABASE IF NOT EXISTS `ccj_database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ccj_database`;

-- --------------------------------------------------------

--
-- Table structure for table `derogatory_records`
--

CREATE TABLE `derogatory_records` (
  `id` int(11) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `violation` text NOT NULL,
  `action_status` enum('Settled','Sanction') NOT NULL,
  `sanction_type` enum('Suspension','Expulsion','Verbal Warning','Written Warning','Others') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_number` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `suffix` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `guardian_name` varchar(100) DEFAULT NULL,
  `guardian_occupation` varchar(100) DEFAULT NULL,
  `is_graduated` tinyint(1) DEFAULT 0,
  `year_graduated` year(4) DEFAULT NULL,
  `graduation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_number`, `last_name`, `first_name`, `middle_name`, `suffix`, `birthdate`, `address`, `guardian_name`, `guardian_occupation`, `is_graduated`, `year_graduated`, `graduation_date`) VALUES
('20231001', 'Doe', 'John', '', 'II', '2002-05-10', '123 Elm St', 'Jane Doe', 'Engineer', 1, '2024', '2024-06-15'),
('20231002', 'Smith', 'Alice', 'Bilogo', '', '2001-09-20', '456 Oak Ave', 'Robert Smith', 'Teacher', 1, '2023', '2023-06-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `derogatory_records`
--
ALTER TABLE `derogatory_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_number` (`student_number`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_number`,`first_name`,`middle_name`,`last_name`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `derogatory_records`
--
ALTER TABLE `derogatory_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `derogatory_records`
--
ALTER TABLE `derogatory_records`
  ADD CONSTRAINT `derogatory_records_ibfk_1` FOREIGN KEY (`student_number`) REFERENCES `students` (`student_number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

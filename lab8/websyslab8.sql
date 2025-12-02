-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 28, 2025 at 09:00 PM
-- Server version: 8.0.44-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websyslab8`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `crn` int NOT NULL,
  `prefix` varchar(4) COLLATE utf8mb3_unicode_ci NOT NULL,
  `number` smallint NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `section` varchar(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `year` smallint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`crn`, `prefix`, `number`, `title`, `section`, `year`) VALUES
(1001, 'CSCI', 101, 'Intro to CS', 'A', 2025),
(1002, 'CSCI', 102, 'Data Structures', 'B', 2025),
(1003, 'MATH', 201, 'Calculus I', 'A', 2025),
(1004, 'PHYS', 101, 'Physics I', 'C', 2025);

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id` int NOT NULL,
  `crn` int DEFAULT NULL,
  `rin` int DEFAULT NULL,
  `grade` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `crn`, `rin`, `grade`) VALUES
(1, 1001, 100000001, 95),
(2, 1001, 100000002, 88),
(3, 1001, 100000003, 92),
(4, 1002, 100000001, 85),
(5, 1002, 100000004, 90),
(6, 1003, 100000002, 91),
(7, 1003, 100000003, 87),
(8, 1003, 100000004, 94),
(9, 1004, 100000001, 78),
(10, 1004, 100000004, 99);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `rin` int NOT NULL,
  `rcsID` char(7) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `firstname` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `lastname` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `alias` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `state` char(2) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `zip` char(10) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`rin`, `rcsID`, `firstname`, `lastname`, `alias`, `phone`, `street`, `city`, `state`, `zip`) VALUES
(100000001, 'r123456', 'Alice', 'Smith', 'Ally', '5551234567', '123 Maple St', 'Troy', 'NY', '12180'),
(100000002, 'r234567', 'Bob', 'Jones', 'Bobby', '5552345678', '456 Oak St', 'Troy', 'NY', '12180'),
(100000003, 'r345678', 'Carol', 'Taylor', 'Caz', '5553456789', '789 Pine St', 'Troy', 'NY', '12180'),
(100000004, 'r456789', 'David', 'Lee', 'Dave', '5554567890', '321 Birch St', 'Troy', 'NY', '12180');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`crn`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `crn` (`crn`),
  ADD KEY `rin` (`rin`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`rin`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`crn`) REFERENCES `courses` (`crn`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`rin`) REFERENCES `students` (`rin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

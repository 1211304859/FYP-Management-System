-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2025 at 12:40 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminid` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_login` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminid`, `firstName`, `lastName`, `email`, `password`, `last_login`) VALUES
(1, 'Mubarak', 'Ahmed', 'admin@example.com', '$2y$10$F9bdjvqn2Jz9klMp6jRSOuT7GTSYqP0E4vdS4BJxMejpE9mhR2r3W', '2025-02-05 11:38:11'),
(5, 'Ahmed', 'Lufti', 'lufti123@gmail.com', '$2y$10$zcO1ng.uP..cVLPAUdDvqelrpaYdlOrL9OHcxSAgF554XoBQ3G6gm', '2025-02-05 11:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(10) NOT NULL,
  `studentid` int(10) NOT NULL,
  `lecturerid` int(10) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `studentid`, `lecturerid`, `appointment_date`, `status`) VALUES
(1, 3, 4, '2025-02-17 09:07:00', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_fyp`
--

CREATE TABLE `assigned_fyp` (
  `assignmentid` int(10) NOT NULL,
  `studentid` int(10) NOT NULL,
  `lecturerid` int(10) NOT NULL,
  `proposalid` int(10) NOT NULL,
  `progress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_fyp`
--

INSERT INTO `assigned_fyp` (`assignmentid`, `studentid`, `lecturerid`, `proposalid`, `progress`) VALUES
(3, 3, 5, 6, 'Not Started'),
(4, 5, 4, 8, 'Not Started');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `lecturerid` int(10) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`lecturerid`, `firstName`, `lastName`, `email`, `password`) VALUES
(4, 'Abdulrahman', 'Saif', 's123@gmail.com', '$2y$10$Lol4K4D5ml/RSuzZh3hYo.8vzr/IrxjOP87CrAGy/xsIKVoroNBl6'),
(5, 'Rayyan', 'Mohamed', 'r123@gmail.com', '$2y$10$.zLBioSR.m.KAAflCI3cj.iE4HYf0DYHfJrv1xhIh8kjzo3QiSb9S'),
(6, 'Rashid', 'Jalal', 'j123@gmail.com', '$2y$10$qg75jdhoHEvy1fN/gUAe1uyyDBiBJLX2BQ39MDipTRVLb2wMQfDTu');

-- --------------------------------------------------------

--
-- Table structure for table `meetings`
--

CREATE TABLE `meetings` (
  `meetingid` int(10) NOT NULL,
  `studentid` int(10) NOT NULL,
  `lecturerid` int(10) NOT NULL,
  `meeting_date` date NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress`
--

CREATE TABLE `progress` (
  `progressid` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `milestone` varchar(200) NOT NULL,
  `status` enum('not started','in progress','completed') DEFAULT 'not started',
  `due_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

CREATE TABLE `proposals` (
  `proposalid` int(10) NOT NULL,
  `lecturerid` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proposals`
--

INSERT INTO `proposals` (`proposalid`, `lecturerid`, `title`, `description`, `status`) VALUES
(5, 4, 'User Interface Trends', 'The study and research of trends in the designs of user interfaces.', 'approved'),
(6, 5, 'Trends in Short Length Media', 'A research into the trend of media being made into short form content for consumption, and it\'s affect on the market.', 'approved'),
(7, 5, 'Machine Learning in Healthcare', 'A research into how the healthcare community is able to use machine learning.', 'pending'),
(8, 4, 'Trends in the Computer Science Field', 'A research into the current trends in the CompSci field, and how the market for it is affected.', 'approved'),
(9, 6, 'AI Use in Buisness Analytics', 'Researching how AI can be used in the anaylzing of data trends in the buisness field.', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentid` int(10) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentid`, `firstName`, `lastName`, `email`, `password`) VALUES
(3, 'Farhan', 'Mohamed', 'f123@gmail.com', '$2y$10$5/u64ZZhBJRRktYIx8KEVeZ/CbUGd0BcUNAEinwoNZt9EwC/wL4mG'),
(5, 'Saif', 'Ahmed', 'a123@gmail.com', '$2y$10$8skEA2F04Gxq5gc1w3UOyuzO377NX1qSTBLOPY2Fi1x8E.r0ud1iC'),
(8, 'Ibrahim', 'Bin Masdi', 'b123@gmail.com', '$2y$10$7AkscZEHw2/lRwdJpXDKaexaz7pCDBRrSvcTquRBYQl.UKHKOdn.y'),
(9, 'Abdullah', 'Thani', 't123@gmail.com', '$2y$10$k4AYCokAdUZ0Ed2eU7Ii4eXPN3shgQfXe2iYL2qJi2XDJRkYmBLle');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `studentid` (`studentid`),
  ADD KEY `lecturerid` (`lecturerid`);

--
-- Indexes for table `assigned_fyp`
--
ALTER TABLE `assigned_fyp`
  ADD PRIMARY KEY (`assignmentid`),
  ADD KEY `lecturerid` (`lecturerid`),
  ADD KEY `studentid` (`studentid`),
  ADD KEY `proposalid` (`proposalid`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`lecturerid`);

--
-- Indexes for table `meetings`
--
ALTER TABLE `meetings`
  ADD PRIMARY KEY (`meetingid`),
  ADD KEY `lecturerid` (`lecturerid`),
  ADD KEY `studentid` (`studentid`);

--
-- Indexes for table `progress`
--
ALTER TABLE `progress`
  ADD PRIMARY KEY (`progressid`),
  ADD KEY `project_id` (`project_id`);

--
-- Indexes for table `proposals`
--
ALTER TABLE `proposals`
  ADD PRIMARY KEY (`proposalid`),
  ADD KEY `lecturerid` (`lecturerid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assigned_fyp`
--
ALTER TABLE `assigned_fyp`
  MODIFY `assignmentid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `lecturerid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `progress`
--
ALTER TABLE `progress`
  MODIFY `progressid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `proposals`
--
ALTER TABLE `proposals`
  MODIFY `proposalid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `studentid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`lecturerid`) REFERENCES `lecturer` (`lecturerid`) ON DELETE CASCADE;

--
-- Constraints for table `assigned_fyp`
--
ALTER TABLE `assigned_fyp`
  ADD CONSTRAINT `assigned_fyp_ibfk_1` FOREIGN KEY (`lecturerid`) REFERENCES `lecturer` (`lecturerid`),
  ADD CONSTRAINT `assigned_fyp_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`),
  ADD CONSTRAINT `assigned_fyp_ibfk_3` FOREIGN KEY (`proposalid`) REFERENCES `proposals` (`proposalid`);

--
-- Constraints for table `meetings`
--
ALTER TABLE `meetings`
  ADD CONSTRAINT `meetings_ibfk_1` FOREIGN KEY (`lecturerid`) REFERENCES `lecturer` (`lecturerid`),
  ADD CONSTRAINT `meetings_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentid`);

--
-- Constraints for table `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `assigned_fyp` (`assignmentid`) ON DELETE CASCADE;

--
-- Constraints for table `proposals`
--
ALTER TABLE `proposals`
  ADD CONSTRAINT `proposals_ibfk_1` FOREIGN KEY (`lecturerid`) REFERENCES `lecturer` (`lecturerid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

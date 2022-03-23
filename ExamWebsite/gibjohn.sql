-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2022 at 03:39 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gibjohn`
--

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `StudentScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settasks`
--

CREATE TABLE `settasks` (
  `ID` int(11) NOT NULL,
  `TaskID` int(11) NOT NULL,
  `TeachingGroupID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `DueDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settasks`
--

INSERT INTO `settasks` (`ID`, `TaskID`, `TeachingGroupID`, `TeacherID`, `DueDate`) VALUES
(1, 1, 1, 5, '2022-04-01'),
(2, 5, 2, 6, '2022-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `ID` int(11) NOT NULL,
  `StudentName` varchar(64) DEFAULT NULL,
  `StudentDateOfBirth` date NOT NULL,
  `StudentEmail` varchar(255) DEFAULT NULL,
  `StudentPasswordHash` varchar(255) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ID`, `StudentName`, `StudentDateOfBirth`, `StudentEmail`, `StudentPasswordHash`, `DateCreated`) VALUES
(9, 'Lucas Parnell', '2004-04-17', 'lucas.parnell@gmail.com', '$2y$10$H/c0e0Po1U6X87RCsMWJ/OxcFoWdURWo.INs.o1KzCUVFFu4jTzVi', '2022-03-15'),
(10, 'Phil House', '2002-04-12', 'philb@email.com', '$2y$10$FOVmvfDTKRMHstiqdPIobeqVDjBuRskk2LWSqC2mRk1s73GhQGkQG', '2022-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `taskfeedback`
--

CREATE TABLE `taskfeedback` (
  `ID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL,
  `SetTaskID` int(11) NOT NULL,
  `TeacherID` int(11) NOT NULL,
  `FeedbackMessage` varchar(255) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `ID` int(11) NOT NULL,
  `TaskSubject` varchar(32) NOT NULL,
  `TaskDescription` varchar(255) NOT NULL,
  `TaskPoints` int(11) NOT NULL,
  `TaskFileIdentifier` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`ID`, `TaskSubject`, `TaskDescription`, `TaskPoints`, `TaskFileIdentifier`) VALUES
(1, 'Maths', 'Add two numbers', 4, 'maths0001'),
(2, 'Geography', 'Map reading', 12, 'geography0001'),
(3, 'Geography', 'Long Shore Drift', 12, 'geography0002'),
(4, 'English', 'Common pieces of literature', 24, 'english0001'),
(5, 'Computing', 'Hello world!', 15, 'computing0001'),
(6, 'Maths', 'Trigonometry Revision', 26, 'maths0002'),
(7, 'French', 'Basic words', 10, 'french0001');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `ID` int(11) NOT NULL,
  `TeacherName` varchar(64) DEFAULT NULL,
  `TeacherDateOfBirth` date NOT NULL,
  `TeacherEmail` varchar(255) DEFAULT NULL,
  `TeacherPasswordHash` varchar(255) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`ID`, `TeacherName`, `TeacherDateOfBirth`, `TeacherEmail`, `TeacherPasswordHash`, `DateCreated`) VALUES
(5, 'Bob Jones', '1995-05-11', 'bobj@email.com', '$2y$10$1SES09gWYzfTWA1z03QiMuBxiIDwQSy9qrA.BfX1IEq3VO8csjB0i', '2022-02-21'),
(6, 'Bill Grant', '0000-00-00', 'bg32@email.com', '$2y$10$1G8LUkqEaImoxtvfba7LNOzcDV2rOBxYENmcwPQNCfi5h9OIqaRzy', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `teachersteachinggroups`
--

CREATE TABLE `teachersteachinggroups` (
  `TeacherID` int(11) NOT NULL,
  `TeachingGroupID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachersteachinggroups`
--

INSERT INTO `teachersteachinggroups` (`TeacherID`, `TeachingGroupID`) VALUES
(5, 1),
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teachinggroups`
--

CREATE TABLE `teachinggroups` (
  `ID` int(11) NOT NULL,
  `GroupName` varchar(64) NOT NULL,
  `DateCreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachinggroups`
--

INSERT INTO `teachinggroups` (`ID`, `GroupName`, `DateCreated`) VALUES
(1, 'ASchoolG1', '2022-03-16'),
(2, 'ASchoolG2', '2022-03-16');

-- --------------------------------------------------------

--
-- Table structure for table `teachinggroupstudents`
--

CREATE TABLE `teachinggroupstudents` (
  `TeachingGroupID` int(11) NOT NULL,
  `StudentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachinggroupstudents`
--

INSERT INTO `teachinggroupstudents` (`TeachingGroupID`, `StudentID`) VALUES
(1, 9),
(2, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `settasks`
--
ALTER TABLE `settasks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TaskID` (`TaskID`,`TeachingGroupID`),
  ADD KEY `TeachingGroupID` (`TeachingGroupID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `StudentEmail` (`StudentEmail`);

--
-- Indexes for table `taskfeedback`
--
ALTER TABLE `taskfeedback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `StudentID` (`StudentID`,`SetTaskID`,`TeacherID`),
  ADD KEY `SetTaskID` (`SetTaskID`),
  ADD KEY `TeacherID` (`TeacherID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `TeacherEmail` (`TeacherEmail`);

--
-- Indexes for table `teachersteachinggroups`
--
ALTER TABLE `teachersteachinggroups`
  ADD KEY `TeacherID` (`TeacherID`,`TeachingGroupID`),
  ADD KEY `TeachingGroupID` (`TeachingGroupID`);

--
-- Indexes for table `teachinggroups`
--
ALTER TABLE `teachinggroups`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `teachinggroupstudents`
--
ALTER TABLE `teachinggroupstudents`
  ADD KEY `TeachingGroupID` (`TeachingGroupID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settasks`
--
ALTER TABLE `settasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `taskfeedback`
--
ALTER TABLE `taskfeedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teachinggroups`
--
ALTER TABLE `teachinggroups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD CONSTRAINT `leaderboard_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `students` (`ID`);

--
-- Constraints for table `settasks`
--
ALTER TABLE `settasks`
  ADD CONSTRAINT `settasks_ibfk_1` FOREIGN KEY (`TeachingGroupID`) REFERENCES `teachinggroups` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `settasks_ibfk_2` FOREIGN KEY (`TaskID`) REFERENCES `tasks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `settasks_ibfk_3` FOREIGN KEY (`TeacherID`) REFERENCES `teachers` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `taskfeedback`
--
ALTER TABLE `taskfeedback`
  ADD CONSTRAINT `taskfeedback_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `students` (`ID`),
  ADD CONSTRAINT `taskfeedback_ibfk_2` FOREIGN KEY (`SetTaskID`) REFERENCES `settasks` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `taskfeedback_ibfk_3` FOREIGN KEY (`TeacherID`) REFERENCES `teachers` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachersteachinggroups`
--
ALTER TABLE `teachersteachinggroups`
  ADD CONSTRAINT `teachersteachinggroups_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `teachers` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachersteachinggroups_ibfk_2` FOREIGN KEY (`TeachingGroupID`) REFERENCES `teachinggroups` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachinggroupstudents`
--
ALTER TABLE `teachinggroupstudents`
  ADD CONSTRAINT `teachinggroupstudents_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `students` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teachinggroupstudents_ibfk_2` FOREIGN KEY (`TeachingGroupID`) REFERENCES `teachinggroups` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

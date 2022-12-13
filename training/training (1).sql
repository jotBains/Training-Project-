-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2022 at 01:15 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `training`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_training`
--

DROP TABLE IF EXISTS `assigned_training`;
CREATE TABLE IF NOT EXISTS `assigned_training` (
  `trainingCode` smallint(6) DEFAULT NULL,
  `studentID` smallint(6) DEFAULT NULL,
  `date_selected` date DEFAULT NULL,
  `date_approved` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assigned_training`
--

INSERT INTO `assigned_training` (`trainingCode`, `studentID`, `date_selected`, `date_approved`) VALUES
(7, 1, '2022-05-12', NULL),
(6, 2, '2022-05-13', NULL),
(6, 1, '2022-05-13', NULL),
(22, 2, '2022-05-13', NULL),
(211, 2, '2022-05-13', NULL),
(112, 2, '2022-05-13', NULL),
(112, 1, '2022-05-12', NULL),
(211, 1, '2022-05-12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `studentID` smallint(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(40) DEFAULT NULL,
  `password_md5` varchar(32) DEFAULT NULL,
  `first` varchar(40) DEFAULT NULL,
  `last` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `email`, `password_md5`, `first`, `last`) VALUES
(1, 'charnjot2000@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'charnjot', 'singh'),
(2, 'charnjot200@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'milkjeet', 'singh');

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

DROP TABLE IF EXISTS `trainings`;
CREATE TABLE IF NOT EXISTS `trainings` (
  `trainingCode` smallint(6) NOT NULL AUTO_INCREMENT,
  `trainingName` varchar(40) DEFAULT NULL,
  `facility` varchar(25) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `trainer` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`trainingCode`)
) ENGINE=MyISAM AUTO_INCREMENT=222 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trainings`
--

INSERT INTO `trainings` (`trainingCode`, `trainingName`, `facility`, `start_date`, `end_date`, `trainer`) VALUES
(6, 'paint', 'art', '2022-05-01', '2022-05-03', 'me'),
(112, 'web developer', 'IT', '2022-05-01', '2022-05-03', 'jot'),
(22, 'x', 'IT', '2022-05-01', '2022-05-03', 'jot'),
(211, 'dance ', 'entertainment', '2021-05-31', '2022-05-03', 'bains'),
(7, 'music', 'art', '2022-05-01', '2022-05-03', 'bains');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

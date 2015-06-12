-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2015 at 04:40 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gafrat`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
`admin_id` int(11) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_name` varchar(45) NOT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `admin_password` varchar(63) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_name`, `create_date`, `admin_password`) VALUES
(2, 'admin@gmail.com', 'admin', '2015-06-12 18:39:41', '$2y$10$3547bwZjOb67fApHSh35Me5fyoAarb2HGPzsk7FtWTfQ8uqBpm3HC');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
`log_id` int(11) NOT NULL,
  `log_creator_admin` int(11) NOT NULL,
  `log_type` int(11) NOT NULL,
  `log_title` varchar(200) DEFAULT NULL,
  `description` longtext NOT NULL,
  `log_create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `log_creator_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_screenshot`
--

CREATE TABLE IF NOT EXISTS `log_screenshot` (
`log_screenshot_id` int(11) NOT NULL,
  `log_screenshot_path` mediumtext NOT NULL,
  `log_screenshot_name` mediumtext NOT NULL,
  `log_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_type`
--

CREATE TABLE IF NOT EXISTS `log_type` (
`log_type_id` int(11) NOT NULL,
  `log_type_title` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `log_type`
--

INSERT INTO `log_type` (`log_type_id`, `log_type_title`) VALUES
(4, 'Cabels'),
(3, 'Electricity'),
(5, 'Heat');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`admin_id`), ADD UNIQUE KEY `admin_email_UNIQUE` (`admin_email`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`log_id`,`log_creator_admin`,`log_type`), ADD KEY `log_admin_creator_id_idx` (`log_creator_admin`), ADD KEY `log_type_key_idx` (`log_type`);

--
-- Indexes for table `log_screenshot`
--
ALTER TABLE `log_screenshot`
 ADD PRIMARY KEY (`log_screenshot_id`,`log_id`), ADD KEY `log_id_key_idx` (`log_id`);

--
-- Indexes for table `log_type`
--
ALTER TABLE `log_type`
 ADD PRIMARY KEY (`log_type_id`), ADD UNIQUE KEY `log_title_UNIQUE` (`log_type_title`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `log_screenshot`
--
ALTER TABLE `log_screenshot`
MODIFY `log_screenshot_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `log_type`
--
ALTER TABLE `log_type`
MODIFY `log_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `log`
--
ALTER TABLE `log`
ADD CONSTRAINT `log_admin_creator_id_key` FOREIGN KEY (`log_creator_admin`) REFERENCES `admin` (`admin_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `log_type_key` FOREIGN KEY (`log_type`) REFERENCES `log_type` (`log_type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `log_screenshot`
--
ALTER TABLE `log_screenshot`
ADD CONSTRAINT `log_id_key` FOREIGN KEY (`log_id`) REFERENCES `log` (`log_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

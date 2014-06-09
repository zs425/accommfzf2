-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2013 at 07:02 PM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `accomm_newcms`
--
CREATE DATABASE IF NOT EXISTS `accomm_newcms` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `accomm_newcms`;

-- --------------------------------------------------------

--
-- Table structure for table `product_changes`
--

CREATE TABLE IF NOT EXISTS `product_changes` (
  `change_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `admin_id` int(10) NOT NULL,
  `change_date` int(10) NOT NULL,
  `change_back` int(11) DEFAULT NULL,
  PRIMARY KEY (`change_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `product_changesdetail`
--

CREATE TABLE IF NOT EXISTS `product_changesdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `change_id` int(11) NOT NULL,
  `change_field` varchar(200) NOT NULL,
  `old_value` varchar(400) DEFAULT NULL,
  `new_value` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

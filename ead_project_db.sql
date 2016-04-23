-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2016 at 05:57 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ead_project`
--
CREATE DATABASE IF NOT EXISTS `ead_project` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `ead_project`;

-- --------------------------------------------------------

--
-- Table structure for table `moves`
--

CREATE TABLE IF NOT EXISTS `moves` (
  `move_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `move_name` varchar(30) NOT NULL,
  `accuracy` int(11) NOT NULL,
  `pp` int(11) NOT NULL,
  `power` int(11) NOT NULL,
  PRIMARY KEY (`move_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `moves`
--

TRUNCATE TABLE `moves`;
-- --------------------------------------------------------

--
-- Table structure for table `pokemon`
--

CREATE TABLE IF NOT EXISTS `pokemon` (
  `id` int(10) unsigned NOT NULL COMMENT 'Usual Pokemon ID. 1: Bulbasaur etc',
  `name` varchar(30) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `hp` int(11) NOT NULL,
  `move1_id` int(11) NOT NULL,
  `move2_id` int(11) DEFAULT NULL,
  `move3_id` int(11) DEFAULT NULL,
  `move4_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `pokemon`
--

TRUNCATE TABLE `pokemon`;
-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Truncate table before insert `users`
--

TRUNCATE TABLE `users`;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

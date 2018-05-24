-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2018 at 01:20 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trackingportaldb27`
--

-- --------------------------------------------------------

--
-- Table structure for table `consumer_family_details`
--

CREATE TABLE IF NOT EXISTS `consumer_family_details` (
  `relation_id` int(11) NOT NULL AUTO_INCREMENT,
  `consumer_id` int(11) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `relation` varchar(100) NOT NULL,
  `phone_number` varchar(14) NOT NULL,
  `howzzt_member` varchar(5) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `modified_at` varchar(100) NOT NULL,
  PRIMARY KEY (`relation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `consumer_family_details`
--

INSERT INTO `consumer_family_details` (`relation_id`, `consumer_id`, `member_name`, `relation`, `phone_number`, `howzzt_member`, `ip`, `status`, `modified_at`) VALUES
(1, 14, 'Situ ...', 'Brother..', '7678665537', 'yes', '103.201.141.106', 1, '2018-05-24 15:46:26'),
(2, 14, 'Bablu', 'Cusion..', '7678665538', 'no', '103.201.141.106', 1, '2018-05-24 15:47:51'),
(3, 14, 'MM', 'Cusion..', '7678665538', 'no', '103.201.141.106', 1, '2018-05-24 16:28:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

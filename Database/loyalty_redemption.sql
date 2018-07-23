-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2018 at 10:17 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trackingportaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_redemption`
--

CREATE TABLE IF NOT EXISTS `loyalty_redemption` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `redemption_id` varchar(20) NOT NULL,
  `points_redeemed` int(10) NOT NULL,
  `mobile_no` bigint(14) NOT NULL,
  `alt_mobile_no` int(14) NOT NULL,
  `street_address` varchar(256) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `pin_code` int(8) NOT NULL,
  `coupon_number` varchar(20) NOT NULL,
  `coupon_type` varchar(50) NOT NULL,
  `coupon_vendor` varchar(100) NOT NULL,
  `request_date` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `status_change_date` datetime NOT NULL,
  `courier_details` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

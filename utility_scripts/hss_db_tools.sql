-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2010 at 05:04 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hss_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tools`
--

CREATE TABLE IF NOT EXISTS `tools` (
  `tool_id` int(11) NOT NULL AUTO_INCREMENT,
  `tool_category_id` int(11) NOT NULL,
  `tool_type_id` int(11) NOT NULL,
  `tool_description` varchar(255) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `date_of_purchase` varchar(10) NOT NULL,
  `voltage` varchar(10) DEFAULT NULL,
  `s_n` varchar(20) DEFAULT NULL,
  `quantity` int(11) DEFAULT '1',
  `location` varchar(10) DEFAULT NULL,
  `last_calibration_date` varchar(10) DEFAULT NULL,
  `next_calibration_date` varchar(10) DEFAULT NULL,
  `price` float NOT NULL,
  `regular_user_id` int(11) NOT NULL DEFAULT '13',
  `last_user_id` int(11) NOT NULL DEFAULT '13',
  `current_user_id` int(11) NOT NULL DEFAULT '13',
  `tool_status_id` int(11) NOT NULL DEFAULT '1',
  `message_id` int(11) DEFAULT '0',
  PRIMARY KEY (`tool_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `tools`
--

INSERT INTO `tools` (`tool_id`, `tool_category_id`, `tool_type_id`, `tool_description`, `manufacturer_id`, `supplier_id`, `date_of_purchase`, `voltage`, `s_n`, `quantity`, `location`, `last_calibration_date`, `next_calibration_date`, `price`, `regular_user_id`, `last_user_id`, `current_user_id`, `tool_status_id`, `message_id`) VALUES
(1, 1, 1, 'Cable USB 2.0 a IDE/SATA 2.5" y 3.5"', 1, 1, '24/05/2010', '120V', NULL, 1, 'warehouse', NULL, NULL, 25.4, 13, 14, 13, 1, 0),
(2, 2, 2, 'drilling machine', 2, 2, '19', '220V', '1234567890', 1, 'warehouse2', NULL, NULL, 300, 13, 13, 13, 1, 0),
(3, 1, 1, 'VGA to USB Frame Grabber', 3, 3, '25', NULL, '7654321', 2, 'warehouse3', NULL, NULL, 300, 13, 5, 13, 1, 0),
(4, 1, 1, 'DB9 serial cable', 4, 1, '01', NULL, NULL, 1, 'workshop', NULL, NULL, 10, 13, 0, 13, 1, 0),
(25, 3, 3, 'phillips no. 5', 4, 2, '01', NULL, NULL, NULL, NULL, NULL, NULL, 5, 13, 2, 13, 1, 0),
(6, 3, 3, 'flat screwdriver no. 2', 4, 2, '26/05/2010', NULL, NULL, NULL, NULL, NULL, NULL, 4, 13, 0, 13, 1, 0),
(7, 4, 4, '8 Mpxls sony camera', 4, 1, '01', NULL, NULL, 1, NULL, NULL, NULL, 200, 13, 0, 13, 1, 0),
(8, 4, 5, '4GB usb memory', 3, 1, '01', NULL, NULL, NULL, NULL, NULL, NULL, 30, 13, 0, 13, 1, 0),
(9, 2, 2, 'Makita drilling machine 450W', 2, 2, '01', '220', '98765', NULL, NULL, NULL, NULL, 350, 13, 0, 13, 1, 0),
(10, 1, 1, 'usb printer cable', 4, 1, '01', NULL, NULL, NULL, NULL, NULL, NULL, 10, 13, 6, 13, 1, 0),
(26, 1, 6, '2510P', 5, 3, '12/05/2010', NULL, '1234567890', 1, NULL, '5/11/2010', NULL, 500, 13, 0, 13, 1, 0),
(27, 4, 4, 'panasonic lumix 6Mpxl', 4, 3, '01', '5/4/2010', NULL, NULL, NULL, NULL, NULL, 200, 13, 0, 13, 1, 0),
(28, 2, 2, '400W wired drilling machine', 7, 2, '19/05/2010', '110', '123654', 1, NULL, NULL, NULL, 50, 13, 13, 13, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tools_accessories`
--

CREATE TABLE IF NOT EXISTS `tools_accessories` (
  `accessory_id` int(11) NOT NULL AUTO_INCREMENT,
  `tool_id` int(11) NOT NULL,
  `accessory_description` varchar(255) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `part_number` varchar(30) DEFAULT NULL,
  `s_n` varchar(20) DEFAULT NULL,
  `location` varchar(10) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`accessory_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tools_accessories`
--

INSERT INTO `tools_accessories` (`accessory_id`, `tool_id`, `accessory_description`, `manufacturer_id`, `supplier_id`, `part_number`, `s_n`, `location`, `price`, `quantity`) VALUES
(1, 26, 'Docking Staion', 5, 3, NULL, NULL, 'workshop', 1, 1),
(2, 26, 'Battery', 5, 3, '54321', '12345', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tools_app_current_state`
--

CREATE TABLE IF NOT EXISTS `tools_app_current_state` (
  `tools_app_state_id` int(11) NOT NULL,
  PRIMARY KEY (`tools_app_state_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tools_app_current_state`
--

INSERT INTO `tools_app_current_state` (`tools_app_state_id`) VALUES
(1);

-- --------------------------------------------------------

--
-- Table structure for table `tools_app_messages`
--

CREATE TABLE IF NOT EXISTS `tools_app_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tools_app_messages`
--

INSERT INTO `tools_app_messages` (`message_id`, `message`) VALUES
(1, 'Batteries need to be recharged.'),
(2, 'This tool needs maintenance'),
(3, 'This tool is not good<br>and has to be replaced'),
(4, 'Talk to the previous user<br> about this tool');

-- --------------------------------------------------------

--
-- Table structure for table `tools_app_states`
--

CREATE TABLE IF NOT EXISTS `tools_app_states` (
  `tools_app_state_id` int(11) NOT NULL AUTO_INCREMENT,
  `tools_app_state` varchar(50) NOT NULL,
  PRIMARY KEY (`tools_app_state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tools_app_states`
--

INSERT INTO `tools_app_states` (`tools_app_state_id`, `tools_app_state`) VALUES
(1, 'home'),
(2, 'home_w_msg'),
(3, 'process');

-- --------------------------------------------------------

--
-- Table structure for table `tools_categories`
--

CREATE TABLE IF NOT EXISTS `tools_categories` (
  `tool_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `tool_category` varchar(50) NOT NULL,
  PRIMARY KEY (`tool_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tools_categories`
--

INSERT INTO `tools_categories` (`tool_category_id`, `tool_category`) VALUES
(1, 'computers'),
(2, 'electrical and power machines'),
(3, 'hand tools'),
(4, 'electronics');

-- --------------------------------------------------------

--
-- Table structure for table `tools_manufacturers`
--

CREATE TABLE IF NOT EXISTS `tools_manufacturers` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_name` varchar(50) NOT NULL,
  `manufacturer_address` varchar(255) DEFAULT NULL,
  `manufacturer_website` varchar(50) DEFAULT NULL,
  `manufacturer_email` varchar(50) DEFAULT NULL,
  `manufacturer_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tools_manufacturers`
--

INSERT INTO `tools_manufacturers` (`manufacturer_id`, `manufacturer_name`, `manufacturer_address`, `manufacturer_website`, `manufacturer_email`, `manufacturer_phone`) VALUES
(1, 'Vantec', NULL, 'http://www.vantecusa.com/', NULL, NULL),
(2, 'Makita', NULL, NULL, NULL, NULL),
(3, 'Epiphan', NULL, NULL, NULL, NULL),
(4, 'no name', NULL, NULL, NULL, NULL),
(5, 'Dell', NULL, NULL, NULL, NULL),
(6, 'Hewllet-Packard', NULL, 'www.hp.com', NULL, NULL),
(7, 'Black and Decker', NULL, NULL, NULL, NULL),
(8, 'mitsubishi', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tools_status`
--

CREATE TABLE IF NOT EXISTS `tools_status` (
  `tool_status_id` int(11) NOT NULL,
  `tool_status` varchar(50) NOT NULL,
  PRIMARY KEY (`tool_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tools_status`
--

INSERT INTO `tools_status` (`tool_status_id`, `tool_status`) VALUES
(1, 'available'),
(2, 'in use'),
(3, 'damaged'),
(4, 'under repairment');

-- --------------------------------------------------------

--
-- Table structure for table `tools_suppliers`
--

CREATE TABLE IF NOT EXISTS `tools_suppliers` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_source` varchar(10) NOT NULL,
  `supplier_name` varchar(50) NOT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `supplier_website` varchar(50) DEFAULT NULL,
  `supplier_email` varchar(50) DEFAULT NULL,
  `supplier_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tools_suppliers`
--

INSERT INTO `tools_suppliers` (`supplier_id`, `supplier_source`, `supplier_name`, `supplier_address`, `supplier_website`, `supplier_email`, `supplier_phone`) VALUES
(1, 'local', 'Yoytec Computer', 'Via Ricardo J. Alfaro (Tumba Muerto), Edificio Green Hills Local 3 y 4 (Planta Baja) El Dorado, Panamá', 'www.yoytec.com', 'ventas3@yoytec.com', '+507 260 7959'),
(2, 'local', 'MAYHER', NULL, NULL, NULL, NULL),
(3, 'local', 'Computer Store', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tools_types`
--

CREATE TABLE IF NOT EXISTS `tools_types` (
  `tool_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `tool_category_id` int(11) NOT NULL,
  `tool_type` varchar(50) NOT NULL,
  PRIMARY KEY (`tool_type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tools_types`
--

INSERT INTO `tools_types` (`tool_type_id`, `tool_category_id`, `tool_type`) VALUES
(1, 1, 'cables and adaptors'),
(2, 2, 'drilling machine'),
(3, 3, 'screwdriver'),
(4, 4, 'cameras'),
(5, 4, 'usb devices'),
(6, 1, 'Laptop');

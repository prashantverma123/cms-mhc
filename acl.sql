-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2016 at 01:52 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sample_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `acl`
--

CREATE TABLE `acl` (
  `id` int(11) NOT NULL,
  `role` varchar(45) NOT NULL,
  `module` varchar(45) NOT NULL,
  `action` varchar(144) NOT NULL,
  `insert_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acl`
--

INSERT INTO `acl` (`id`, `role`, `module`, `action`, `insert_date`) VALUES
(1, 'admin', 'city', 'add,edit,delete', '2016-06-01 18:30:00'),
(2, 'admin', 'employee', 'add,edit,delete', '2016-06-01 18:30:00'),
(3, 'admin', 'category', 'add,edit,delete', '2016-06-01 18:30:00'),
(4, 'admin', 'leadmanager', 'add,edit,delete', '2016-06-01 18:30:00'),
(5, 'admin', 'dashboard', '', '2016-06-01 18:30:00'),
(6, 'admin', 'cmsuser', 'add,edit,delete', '2016-06-01 18:30:00'),
(7, 'admin', 'leadsource', 'add,edit,delete', '2016-06-01 18:30:00'),
(8, 'admin', 'leadstage', 'add,edit,delete', '2016-06-01 18:30:00'),
(9, 'admin', 'order', 'add,edit,delete', '2016-06-01 18:30:00'),
(10, 'admin', 'pricelist', 'add,edit,delete', '2016-06-01 18:30:00'),
(11, 'customer_care', 'leadmanager', 'add,edit,delete', '2016-06-01 18:30:00'),
(12, 'customer_care', 'leadsource', 'add,edit,delete', '2016-06-01 18:30:00'),
(13, 'customer_care', 'order', 'add,edit,delete', '2016-06-01 18:30:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acl`
--
ALTER TABLE `acl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role`),
  ADD KEY `module` (`module`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acl`
--
ALTER TABLE `acl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `acl`
--
ALTER TABLE `acl`
  ADD CONSTRAINT `fk_acl_module` FOREIGN KEY (`module`) REFERENCES `modules` (`name`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_acl_role` FOREIGN KEY (`role`) REFERENCES `role` (`role`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

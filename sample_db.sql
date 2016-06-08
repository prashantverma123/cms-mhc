-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2016 at 08:14 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sample`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `parent_id` int(10) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `priority` int(5) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_alt` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL,
  `meta_description` varchar(500) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`, `summary`, `priority`, `image`, `image_alt`, `meta_title`, `meta_keyword`, `meta_description`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 'Test', 0, 'sdsdd', 1, '1459693273_unnamed800x262.jpg', '', 'dsdad', 'lkhq', 'dsadas', 3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 'Sample', 1, 'siumary', 2, '', '', 'meta titlrq', 'meta keywords', 'meta desc', 3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 'sample2', 2, 'dsummary slkjad', 3, 'category/1459702182_ayubs_main-image.jpg', '', 'metitle', 'keyword', 'desc', 3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_users`
--

CREATE TABLE IF NOT EXISTS `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `password` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `role` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
    `org_name` varchar(200) DEFAULT NULL,
  `org_twitter` varchar(200) DEFAULT NULL,
  `org_url` varchar(200) DEFAULT NULL,
  `org_email` varchar(200) DEFAULT NULL,
  `org_phone` varchar(200) DEFAULT NULL,
  `org_logo` varchar(200) DEFAULT NULL,
  `org_description` text,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `cms_users`
--

INSERT INTO `cms_users` (`id`, `username`, `password`, `name`, `email`, `role`, `status`, `org_name`, `org_twitter`, `org_url`, `org_email`, `org_phone`, `org_logo`, `org_description`, `update_date`) VALUES
(1, 'sample', '123456', 'Sample', 'sample@gmail.com', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
CREATE TABLE IF NOT EXISTS `city` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `city_tier` int(10) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


INSERT INTO `city` (`id`, `name`, `city_tier`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 'Mumbai', 1,3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 'Pune', 2, 3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 'Banglore', 3, 3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);


CREATE TABLE IF NOT EXISTS `leadsource` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `source_url` varchar(255) NOT NULL,
  `source_phone` varchar(255) NOT NULL,
  `source_address` varchar(255) NOT NULL,
  `commission_type` varchar(255) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `leadsource` (`id`, `name`, `source_url`, `source_phone`, `source_address`, `commission_type`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 'HouseJoy','http://www.housejoy.in/', '7738038119', 'dsdad', 'lkhq',3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 'Zimber','http://zimmber.com/', '7738038119', 'meta titlrq', 'meta keywords',3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 'Facebook', 'https://www.facebook.com/', '7738038119','metitle', 'desc', 3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);


CREATE TABLE IF NOT EXISTS `leadstage` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `lead_order` int(50) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `leadstage` (`id`, `name`, `lead_order`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 'HouseJoy',1,3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 'Zimber',2,3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 'Facebook', 3, 3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);


CREATE TABLE IF NOT EXISTS `product` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `category_id` int(50) NOT NULL,
  `validity` varchar(255) NOT NULL,
  `cost` int(50) NOT NULL,
  `city_id` int(50) NOT NULL,
  `lead_source_id` int(50) NOT NULL,
  `comission` varchar(255) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `product` (`id`, `category_id`, `validity`, `cost`, `city_id`, `lead_source_id`, `comission`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 1,'long', 343, 1, 2,'asdfghj',3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 2,'short', 121, 2, 2,'qwerty',3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 1, 'long', 434,2, 3, 'asdfghjkwerty',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);





CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `lead_source` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `alternate_no` varchar(255) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `service` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `commission` int(100) NOT NULL,
  `taxed_cost` int(100) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `orders` (`id`, `name`, `lead_source`, `mobile_no`, `alternate_no`, `email_id`, `address`,`landmark`,`location`,`city`,`state`,`pincode`,`service`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1, 'Prashant','housejoy', '7738038119', '', '','fdsf','qwew','long','erewrewr','Mumbai','Maharashtra','Ac Servicing',3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2, 'Sahil','zimmber', 'long', '9426838119', '','','lonerwg','dsadasd','dfsdfsdf','Delhi','Delhi','Deep Cleaning',3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3, 'Shreyans','oyo rooms', 'long', '9414141999', '','','lorewrerng','lovcvcvvcng','Banglore','Karnataka','long','Painting',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);



CREATE TABLE IF NOT EXISTS `pricelist` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `category_type` varchar(255) NOT NULL,
  `lead_source` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `commission` int(100) NOT NULL,
  `taxed_cost` int(100) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `pricelist` (`id`, `name`, `category_type`, `lead_source`, `city`, `price`,`commission`, `taxed_cost`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1,'AC Servicing','AC Maintaining' ,'HouseJoy','Mumbai',500,10,575,3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2,'AC Servicing','AC Maintaining' ,'Zimber','Mumbai',700,8,775,3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3,'AC Servicing','AC Maintaining' ,'Haptik','Mumbai',600,2,690,3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `mobile_no` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `experties` varchar(255) NOT NULL,
  `attendence` tinyint(1) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `employee` (`id`, `name`, `email`, `designation`, `city`, `mobile_no`,`gender`,`experties`,`attendence`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1,'Amit Desai','amitdesai@mrhomecare.in' ,'Janitor','Mumbai','1234567890','M','dajksdjkadkas',1,3, '', '0000-00-00 00:00:00', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2,'Bhawana Raj','bhawanaraj@mrhomecare.in' ,'Supervisor','Mumbai','1234567890','F','dejndnejkdew',0,3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3,'Kaushik Sharma','kaushiksharma@mrhomecare.in' ,'Team Leader','Delhi','1234567890','M','wedbewkjdewd',1,3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);

CREATE TABLE IF NOT EXISTS `variantMaster` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `varianttype` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `variantMaster` (`id`, `varianttype`, `city`, `category`,`author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1,'1BHK','Mumbai' ,'AC Servicing',3, '', '2016-04-03 12:30:35', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2,'2BHK','Mumbai' ,'Office Cleaning',3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3,'1RK','Mumbai' ,'Pest Control',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);


CREATE TABLE IF NOT EXISTS `designationMaster` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

INSERT INTO `designationMaster` (`id`, `designation`, `author_id`, `author_name`, `insert_date`, `update_date`, `ip`, `status`) VALUES
(1,'Ass. Operation Controller',3, '', '2016-04-03 12:30:35', '2016-04-03 12:24:06', '127.0.0.1', 0),
(2,'Asst. Manager',3, '', '2016-04-03 12:30:35', '2016-04-03 12:30:35', '127.0.0.1', 0),
(3,'Car Care',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(4,'Carpenter',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(5,'Chambermaid',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(6,'Driver',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(7,'Electrician',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(8,'H/k boy',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(9,'HK Boy',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(10,'MST',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(11,'Office Boy',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(12,'Plumber',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(13,'Store keeper',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(14,'Supervisor',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(15,'Team Leader',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(16,'Trainer',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(17,'Training Supervisor',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(18,'Supervisor',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(19,'Supervisor',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0),
(20,'Van Driver',3, '', '2016-04-03 17:53:52', '2016-04-03 17:53:52', '127.0.0.1', 0);

CREATE TABLE IF NOT EXISTS `leadManager` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `lead_source` varchar(255) NOT NULL,
  `lead_owner` varchar(255) NOT NULL,
  `job_status` varchar(255) NOT NULL,
  `lead_stage` varchar(255) NOT NULL,
  `service_date` datetime NOT NULL,
  `service_time` datetime NOT NULL,
  `manpower_deployment` varchar(255) NOT NULL,
  'client_salutation' varchar(255) NOT NULL,
  `client_firstname` varchar(255) NOT NULL,
  `client_lasttname` varchar(255) NOT NULL,
  `client_mobile_no` varchar(255) NOT NULL,
  `alternate_no` varchar(255) NOT NULL,
  `client_email_id` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  'additional_note' varchar(255) NOT NULL,
  `service_inquiry1` varchar(255) NOT NULL,
  `service_inquiry1_booked` varchar(255) NOT NULL,
  `service_inquiry2` varchar(255) NOT NULL,
  `service_inquiry2_booked` varchar(255) NOT NULL,
  `service_inquiry3` varchar(255) NOT NULL,
  `service_inquiry3_booked` varchar(255) NOT NULL,
  `promo_code` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `commission` int(100) NOT NULL,
  `taxed_cost` int(100) NOT NULL,
  `author_id` int(50) NOT NULL,
  `author_name` varchar(255) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


ALTER TABLE `leadmanager` ADD INDEX(`lead_source`);

ALTER TABLE `leadmanager` CHANGE `lead_stage` `lead_stage` INT NOT NULL;

ALTER TABLE `leadmanager` ADD INDEX(`lead_stage`);

ALTER TABLE `leadmanager` ADD INDEX(`varianttype`);

ALTER TABLE `leadmanager` ADD CONSTRAINT `fk_leadsource_leadmanager` FOREIGN KEY (`lead_source`) REFERENCES `sample_db`.`leadsource`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `leadmanager` ADD CONSTRAINT `fk_leadstage_leadmanager` FOREIGN KEY (`lead_stage`) REFERENCES `sample_db`.`leadstage`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `leadmanager` ADD CONSTRAINT `fk_varianttype_leadmanager` FOREIGN KEY (`varianttype`) REFERENCES `sample_db`.`variantmaster`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `orders` CHANGE `lead_source` `lead_source` INT NOT NULL;

ALTER TABLE `orders` ADD INDEX(`lead_source`);

ALTER TABLE `orders` CHANGE `pincode` `pincode` VARCHAR(45) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `orders` ADD CONSTRAINT `fk_leadsource_orders` FOREIGN KEY (`lead_source`) REFERENCES `sample_db`.`leadsource`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `pricelist` ADD INDEX(`category_type`);

ALTER TABLE `pricelist` ADD INDEX(`lead_source`);

ALTER TABLE `pricelist` ADD INDEX(`city`);

ALTER TABLE `pricelist` CHANGE `category_type` `category_type` INT NOT NULL;
ALTER TABLE `pricelist` CHANGE `lead_source` `lead_source` INT NOT NULL;
ALTER TABLE `pricelist` CHANGE `city` `city` INT NOT NULL;

ALTER TABLE `pricelist` CHANGE `varianttype` `varianttype` INT NULL DEFAULT NULL;

ALTER TABLE `pricelist` ADD INDEX(`varianttype`);


ALTER TABLE `pricelist` ADD CONSTRAINT `fk_leadsource_pricelist` FOREIGN KEY (`lead_source`) REFERENCES `sample_db`.`leadsource`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `pricelist` ADD CONSTRAINT `fk_category_pricelist` FOREIGN KEY (`category_type`) REFERENCES `sample_db`.`category`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `pricelist` ADD CONSTRAINT `fk_city_pricelist` FOREIGN KEY (`city`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `pricelist` ADD CONSTRAINT `fk_varianttype_pricelist` FOREIGN KEY (`varianttype`) REFERENCES `sample_db`.`variantmaster`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `product` ADD INDEX(`category_id`);

ALTER TABLE `product` ADD INDEX(`city_id`);

ALTER TABLE `product` ADD INDEX(`lead_source_id`);

ALTER TABLE `product` ADD  CONSTRAINT `fk_leadsourceid_product` FOREIGN KEY (`lead_source_id`) REFERENCES `sample_db`.`leadsource`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `product` ADD CONSTRAINT `fk_categoryid_product` FOREIGN KEY (`category_id`) REFERENCES `sample_db`.`category`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION; ALTER TABLE `product` ADD CONSTRAINT `fk_city_product` FOREIGN KEY (`city_id`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `employee` CHANGE `city` `city` INT NOT NULL;

ALTER TABLE `employee` ADD INDEX(`city`);

ALTER TABLE `employee` ADD CONSTRAINT `fk_city_employee` FOREIGN KEY (`city`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `category` ADD INDEX(`author_id`);
ALTER TABLE `category` ADD  CONSTRAINT `fk_cmsuserid_category` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `city` ADD INDEX(`author_id`);
ALTER TABLE `city` ADD CONSTRAINT `fk_cmsuserid_city` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `employee` ADD INDEX(`author_id`);
ALTER TABLE `employee` ADD CONSTRAINT `fk_cmsuserid_employee` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `leadmanager` ADD INDEX(`author_id`);
ALTER TABLE `leadmanager` ADD CONSTRAINT `fk_cmsuserid_leadmanager` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `leadsource` ADD INDEX(`author_id`);
ALTER TABLE `leadsource` ADD CONSTRAINT `fk_cmsuserid_leadsource` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `leadstage` ADD INDEX(`author_id`);
ALTER TABLE `leadstage` ADD CONSTRAINT `fk_cmsuserid_leadstage` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`leadstage`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `pricelist` ADD INDEX(`author_id`);
ALTER TABLE `pricelist` ADD CONSTRAINT `fk_cmsuserid_pricelist` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`pricelist`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `orders` ADD INDEX(`author_id`);
ALTER TABLE `orders` ADD CONSTRAINT `fk_cmsuserid_orders` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `variantmaster` ADD INDEX(`author_id`);
ALTER TABLE `variantmaster` ADD CONSTRAINT `fk_cmsuserid` FOREIGN KEY (`author_id`) REFERENCES `sample_db`.`cms_users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;


ALTER TABLE `cms_users` CHANGE `org_email` `ip` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `cms_users` CHANGE `org_phone` `insert_date` DATETIME NULL DEFAULT NULL;

ALTER TABLE `cms_users` DROP `org_name`;
ALTER TABLE `cms_users` DROP `org_twitter`;
ALTER TABLE `cms_users` DROP `org_url`;
ALTER TABLE `cms_users` DROP `org_logo`;
ALTER TABLE `cms_users` DROP `org_description`;

ALTER TABLE `leadmanager` CHANGE `manpower_deployment` `teamLeader_deployment`INT NOT NULL;

ALTER TABLE `leadmanager` ADD `supervisor_deployment` INT NOT NULL AFTER`teamLeader_deployment`, ADD `janitor_deployment` INT NOT NULL AFTER`supervisor_deployment`;
ALTER TABLE `order` CHANGE `city` `city` INT NOT NULL;
ALTER TABLE `order` ADD INDEX(`city`);
ALTER TABLE `order` ADD  CONSTRAINT `fk_order_city` FOREIGN KEY (`city`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `cmsuser` CHANGE `city` `city` INT(11) NOT NULL;
ALTER TABLE `cmsuser` ADD INDEX(`city`); 
ALTER TABLE `cmsuser` ADD CONSTRAINT `fk_cmsuser_city` FOREIGN KEY (`city`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `employee` CHANGE `designation` `designation` INT NOT NULL;
ALTER TABLE `employee` ADD INDEX(`designation`);
ALTER TABLE `employee` ADD CONSTRAINT `fk_designation_employee` FOREIGN KEY (`designation`) REFERENCES `sample_db`.`designation`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `cmsuser` CHANGE `password` `password` TEXT CHARACTER SET latin1 COLLATE latin1_general_ci NULL DEFAULT NULL;

ALTER TABLE `leadmanager` CHANGE `city` `city` INT NOT NULL;
ALTER TABLE `leadmanager` ADD INDEX(`city`); 
ALTER TABLE `leadmanager` ADD  CONSTRAINT `fk_city_leadmanager` FOREIGN KEY (`city`) REFERENCES `sample_db`.`city`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
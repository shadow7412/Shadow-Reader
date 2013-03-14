-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 14, 2013 at 04:31 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `shadowreader`
--

-- --------------------------------------------------------

--
-- Table structure for table `rssfeeds`
--

DROP TABLE IF EXISTS `rssfeeds`;
CREATE TABLE IF NOT EXISTS `rssfeeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(50) NOT NULL,
  `iconurl` varchar(50) NOT NULL,
  `lastchecked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastupdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rssfeeds`
--

INSERT INTO `rssfeeds` (`id`, `url`, `iconurl`, `lastchecked`, `lastupdated`) VALUES
(1, 'http://www.questionablecontent.net/QCRSS.xml', '', '2013-03-14 05:30:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `rssitems`
--

DROP TABLE IF EXISTS `rssitems`;
CREATE TABLE IF NOT EXISTS `rssitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed` int(11) NOT NULL,
  `link` varchar(150) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feed` (`feed`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rssitems`
--
ALTER TABLE `rssitems`
  ADD CONSTRAINT `rssitems_ibfk_1` FOREIGN KEY (`feed`) REFERENCES `rssfeeds` (`id`);

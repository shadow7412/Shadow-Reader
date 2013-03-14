-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2013 at 10:09 AM
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

CREATE TABLE IF NOT EXISTS `rssfeeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `url` varchar(50) NOT NULL,
  `iconurl` varchar(50) NOT NULL,
  `lastchecked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastupdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `rssitems`
--

CREATE TABLE IF NOT EXISTS `rssitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `feed` int(11) NOT NULL,
  `link` text NOT NULL,
  `subject` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `feed` (`feed`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=279 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rssitems`
--
ALTER TABLE `rssitems`
  ADD CONSTRAINT `rssitems_ibfk_1` FOREIGN KEY (`feed`) REFERENCES `rssfeeds` (`id`);

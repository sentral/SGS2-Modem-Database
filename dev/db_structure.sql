-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: wp208.webpack.hosteurope.de
-- Erstellungszeit: 10. Juni 2012 um 14:23
-- Server Version: 5.5.22
-- PHP-Version: 5.3.3-7+squeeze8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `db1181624-testarea`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_data`
--

CREATE TABLE IF NOT EXISTS `android_data` (
  `data_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider` tinyint(2) unsigned NOT NULL,
  `modem` tinyint(2) unsigned NOT NULL,
  `firmware` tinyint(2) unsigned NOT NULL,
  `kernel` tinyint(2) unsigned NOT NULL,
  `region` int(10) unsigned NOT NULL,
  `phone_quality` tinyint(2) unsigned NOT NULL DEFAULT '3',
  `internet_quality` tinyint(2) unsigned NOT NULL DEFAULT '3',
  `avg_dBm` varchar(4) COLLATE latin1_german2_ci NOT NULL,
  `avg_dBm_wifi` varchar(4) COLLATE latin1_german2_ci NOT NULL,
  `timetested` tinyint(3) unsigned NOT NULL,
  `approved` char(1) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_firmware`
--

CREATE TABLE IF NOT EXISTS `android_firmware` (
  `fw_id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `firmware` varchar(128) COLLATE latin1_german2_ci NOT NULL,
  `approved` char(1) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`fw_id`),
  UNIQUE KEY `firmware` (`firmware`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_kernel`
--

CREATE TABLE IF NOT EXISTS `android_kernel` (
  `krnl_id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `kernel` varchar(128) COLLATE latin1_german2_ci NOT NULL,
  `approved` char(1) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`krnl_id`),
  UNIQUE KEY `kernel` (`kernel`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_modem`
--

CREATE TABLE IF NOT EXISTS `android_modem` (
  `modem_id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `modem` varchar(64) COLLATE latin1_german2_ci NOT NULL,
  `ics_only` char(1) COLLATE latin1_german2_ci NOT NULL,
  `approved` char(1) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`modem_id`),
  UNIQUE KEY `modem` (`modem`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=42 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_provider`
--

CREATE TABLE IF NOT EXISTS `android_provider` (
  `provid` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(128) COLLATE latin1_german2_ci NOT NULL,
  `approved` char(1) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`provid`),
  UNIQUE KEY `provider` (`provider`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_rating`
--

CREATE TABLE IF NOT EXISTS `android_rating` (
  `rating_id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `rating` char(2) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`rating_id`),
  UNIQUE KEY `rating` (`rating`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_region`
--

CREATE TABLE IF NOT EXISTS `android_region` (
  `region_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(128) COLLATE latin1_german2_ci NOT NULL,
  `postalcode` varchar(32) COLLATE latin1_german2_ci NOT NULL,
  `area` varchar(64) COLLATE latin1_german2_ci NOT NULL,
  `country` varchar(64) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`region_id`),
  UNIQUE KEY `city` (`city`,`postalcode`,`area`,`country`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `android_verify`
--

CREATE TABLE IF NOT EXISTS `android_verify` (
  `vkey` varchar(128) COLLATE latin1_german2_ci NOT NULL,
  `data_entry` int(10) unsigned NOT NULL,
  KEY `vkey` (`vkey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci;

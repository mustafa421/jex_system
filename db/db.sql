-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 18, 2018 at 10:15 PM
-- Server version: 5.1.73
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS whstoredb;

use whstoredb;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `whstoredb`
--

-- --------------------------------------------------------

--
-- Table structure for table `jestore_articles`
--

CREATE TABLE IF NOT EXISTS `jestore_articles` (
  `article` varchar(30) NOT NULL DEFAULT '',
  `activate_article` varchar(1) NOT NULL DEFAULT 'Y',
  `category_id` int(8) NOT NULL DEFAULT '0',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Contains articles that are displayed on sale agreement' AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_articletypes`
--

CREATE TABLE IF NOT EXISTS `jestore_articletypes` (
  `articletype` varchar(30) NOT NULL DEFAULT '',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Contains article types' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_brands`
--

CREATE TABLE IF NOT EXISTS `jestore_brands` (
  `brand` varchar(30) NOT NULL DEFAULT '',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Contains brands that items use to be more descriptive' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_categories`
--

CREATE TABLE IF NOT EXISTS `jestore_categories` (
  `category` varchar(30) NOT NULL DEFAULT '',
  `activate_category` varchar(1) NOT NULL DEFAULT 'Y',
  `report_transaction` varchar(1) NOT NULL DEFAULT 'N',
  `showon_itempanel` varchar(1) NOT NULL DEFAULT 'N',
  `showon_moviespanel` varchar(1) NOT NULL DEFAULT 'N',
  `showon_gamespanel` varchar(1) NOT NULL DEFAULT 'N',
  `showon_jewelrypanel` varchar(1) NOT NULL DEFAULT 'N',
  `showon_saleservicepanel` varchar(1) NOT NULL DEFAULT 'N',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Contains categories that items use to be more descriptive' AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_checknumber`
--

CREATE TABLE IF NOT EXISTS `jestore_checknumber` (
  `start_check_number` int(8) NOT NULL,
  `next_check_number` int(8) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_checkprinting_coordinates`
--

CREATE TABLE IF NOT EXISTS `jestore_checkprinting_coordinates` (
  `date_xpos` smallint(2) NOT NULL,
  `date_ypos` smallint(2) NOT NULL,
  `name_xpos` smallint(2) NOT NULL,
  `name_ypos` smallint(2) NOT NULL,
  `amount_inwords_xpos` smallint(2) NOT NULL,
  `amount_inwords_ypos` smallint(2) NOT NULL,
  `amount_xpos` smallint(2) NOT NULL,
  `amount_ypos` smallint(2) NOT NULL,
  `note_xpos` smallint(2) NOT NULL,
  `note_ypos` smallint(2) NOT NULL,
  `id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_customers`
--

CREATE TABLE IF NOT EXISTS `jestore_customers` (
  `first_name` varchar(25) NOT NULL DEFAULT '',
  `last_name` varchar(25) NOT NULL DEFAULT '',
  `account_number` varchar(10) NOT NULL DEFAULT '',
  `phone_number` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(40) NOT NULL DEFAULT '',
  `street_address` blob NOT NULL,
  `comments` blob NOT NULL,
  `date` date NOT NULL,
  `bancustomer` varchar(1) NOT NULL DEFAULT 'N',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Customer Info.' AUTO_INCREMENT=3224 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_discounts`
--

CREATE TABLE IF NOT EXISTS `jestore_discounts` (
  `item_id` int(8) NOT NULL DEFAULT '0',
  `percent_off` varchar(60) NOT NULL DEFAULT '',
  `comment` blob NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='This table keeps track of item discounts' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_items`
--

CREATE TABLE IF NOT EXISTS `jestore_items` (
  `item_number` varchar(15) NOT NULL DEFAULT '',
  `category_id` int(8) NOT NULL DEFAULT '0',
  `supplier_id` int(8) NOT NULL DEFAULT '0',
  `article_id` int(8) NOT NULL DEFAULT '0',
  `share_inventorytbl_rowid` int(8) NOT NULL DEFAULT '0',
  `itemtranstbl_rowid` int(8) NOT NULL DEFAULT '0',
  `item_name` varchar(30) NOT NULL,
  `kindsize` varchar(30) NOT NULL,
  `numstone` int(8) NOT NULL DEFAULT '0',
  `serialnumber` varchar(35) NOT NULL DEFAULT '',
  `imei1` varchar(20) NOT NULL DEFAULT '',
  `imei2` varchar(20) NOT NULL DEFAULT '',
  `brandname` varchar(35) NOT NULL DEFAULT '',
  `itemsize` varchar(35) NOT NULL DEFAULT '',
  `itemcolor` varchar(35) NOT NULL DEFAULT '',
  `itemmodel` varchar(35) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL,
  `buy_price` varchar(10) NOT NULL,
  `unit_price` varchar(10) NOT NULL,
  `supplier_catalogue_number` varchar(60) NOT NULL DEFAULT '',
  `tax_percent` varchar(5) NOT NULL DEFAULT '',
  `total_cost` varchar(40) NOT NULL DEFAULT '',
  `quantity` int(8) NOT NULL DEFAULT '0',
  `reorder_level` int(8) NOT NULL DEFAULT '0',
  `item_image` varchar(25) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  `removedbypd` varchar(5) NOT NULL,
  `qtyremovedpd` int(8) NOT NULL DEFAULT '0',
  `removecommentpd` varchar(150) NOT NULL,
  `removedatepd` date NOT NULL,
  `removedbyjex` varchar(5) NOT NULL,
  `qtyremovedjex` int(8) NOT NULL DEFAULT '0',
  `removecommentjex` varchar(150) NOT NULL,
  `removedatejex` date NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Item Info.' AUTO_INCREMENT=9545 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_item_transactions`
--

CREATE TABLE IF NOT EXISTS `jestore_item_transactions` (
  `itemrow_id` int(8) NOT NULL DEFAULT '0',
  `share_inventorytbl_rowid` int(8) NOT NULL DEFAULT '0',
  `category_id` int(8) NOT NULL DEFAULT '0',
  `article_id` int(8) NOT NULL DEFAULT '0',
  `transaction_id` bigint(20) NOT NULL DEFAULT '0',
  `supplier_id` int(8) NOT NULL DEFAULT '0',
  `supplier_phone` varchar(15) NOT NULL,
  `upc` varchar(15) NOT NULL,
  `buy_price` varchar(10) NOT NULL,
  `unit_price` varchar(10) NOT NULL,
  `item_gender` char(8) NOT NULL,
  `material_type` char(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `kindsize` varchar(35) NOT NULL,
  `numstone` int(8) NOT NULL DEFAULT '0',
  `brandname` varchar(35) NOT NULL,
  `serialnumber` varchar(35) NOT NULL,
  `imei1` varchar(20) NOT NULL DEFAULT '',
  `imei2` varchar(20) NOT NULL DEFAULT '',
  `itemmodel` varchar(35) NOT NULL,
  `totalowner` varchar(1) NOT NULL DEFAULT 'N',
  `itemfound` varchar(1) NOT NULL DEFAULT 'N',
  `founddesc` varchar(250) NOT NULL,
  `transaction_from_panel` varchar(10) NOT NULL,
  `addtoinventory_scrapgold` varchar(1) NOT NULL DEFAULT 'N',
  `report_item` varchar(1) NOT NULL DEFAULT 'Y',
  `scrap_or_resale` varchar(15) NOT NULL DEFAULT '',
  `item_image` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10802 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_printed_checks`
--

CREATE TABLE IF NOT EXISTS `jestore_printed_checks` (
  `checknumber` int(8) NOT NULL DEFAULT '0',
  `supplierid` int(8) NOT NULL DEFAULT '0',
  `transactionid` int(8) NOT NULL DEFAULT '0',
  `checkamount` varchar(10) NOT NULL,
  `bankname` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_sales`
--

CREATE TABLE IF NOT EXISTS `jestore_sales` (
  `date` date NOT NULL DEFAULT '0000-00-00',
  `customer_id` int(8) NOT NULL DEFAULT '0',
  `sale_sub_total` varchar(12) NOT NULL DEFAULT '',
  `sale_total_cost` varchar(30) NOT NULL DEFAULT '',
  `paid_with` varchar(25) NOT NULL DEFAULT '',
  `items_purchased` int(8) NOT NULL DEFAULT '0',
  `sold_by` int(8) NOT NULL DEFAULT '0',
  `comment` varchar(100) NOT NULL DEFAULT '',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Contains overall sale details' AUTO_INCREMENT=6048 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_sales_items`
--

CREATE TABLE IF NOT EXISTS `jestore_sales_items` (
  `sale_id` int(8) NOT NULL DEFAULT '0',
  `item_id` int(8) NOT NULL DEFAULT '0',
  `upc` varchar(15) NOT NULL,
  `saletype` varchar(25) NOT NULL,
  `srvname` varchar(30) NOT NULL,
  `srvcost` varchar(10) NOT NULL,
  `quantity_purchased` int(8) NOT NULL DEFAULT '0',
  `item_unit_price` varchar(15) NOT NULL DEFAULT '',
  `item_buy_price` varchar(30) NOT NULL DEFAULT '',
  `item_tax_percent` varchar(10) NOT NULL DEFAULT '',
  `item_total_tax` varchar(12) NOT NULL DEFAULT '',
  `item_total_cost` varchar(12) NOT NULL DEFAULT '',
  `refundtype` varchar(1) NOT NULL,
  `refundunitprice` varchar(15) NOT NULL,
  `refundtax` varchar(15) NOT NULL,
  `refundtotal` varchar(15) NOT NULL,
  `refundcomment` varchar(100) NOT NULL,
  `refunddate` date NOT NULL,
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Table that holds item information for sales' AUTO_INCREMENT=8034 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_suppliers`
--

CREATE TABLE IF NOT EXISTS `jestore_suppliers` (
  `supplier` varchar(50) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `middlename` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `gender` blob NOT NULL,
  `race` blob NOT NULL,
  `dob` blob NOT NULL,
  `height` blob NOT NULL,
  `weight` blob NOT NULL,
  `hair_color` blob NOT NULL,
  `eyes_color` blob NOT NULL,
  `address` blob NOT NULL,
  `apartment` blob NOT NULL,
  `city` blob NOT NULL,
  `state` blob NOT NULL,
  `zip` blob NOT NULL,
  `driver_lic_num` blob NOT NULL,
  `licstate` blob NOT NULL,
  `itisid` varchar(1) NOT NULL DEFAULT 'N',
  `idnumber` blob NOT NULL,
  `idstate` blob NOT NULL,
  `idtype` blob NOT NULL,
  `phone_number` varchar(14) NOT NULL,
  `contact` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `other` varchar(100) NOT NULL,
  `imagelic` varchar(25) NOT NULL,
  `imagecust` varchar(25) NOT NULL,
  `imagethumb` varchar(25) NOT NULL,
  `licexpdate` blob NOT NULL,
  `date` date NOT NULL,
  `bansupplier` varchar(1) NOT NULL DEFAULT 'N',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Hold information about suppliers' AUTO_INCREMENT=3211 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_transaction_numbers`
--

CREATE TABLE IF NOT EXISTS `jestore_transaction_numbers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `transaction_number` bigint(20) NOT NULL,
  `processing` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=225 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_upc_numbers`
--

CREATE TABLE IF NOT EXISTS `jestore_upc_numbers` (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `itemupc` varchar(15) NOT NULL,
  `processing` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=239 ;

-- --------------------------------------------------------

--
-- Table structure for table `jestore_users`
--

CREATE TABLE IF NOT EXISTS `jestore_users` (
  `first_name` varchar(50) NOT NULL DEFAULT '',
  `last_name` varchar(50) NOT NULL DEFAULT '',
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '',
  `id` int(8) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='User info. that the program needs' AUTO_INCREMENT=11 ;

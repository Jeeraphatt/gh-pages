-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 24, 2013 at 01:37 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `myshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE IF NOT EXISTS `tbl_cart` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `ct_session_id` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ct_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ct_id`),
  KEY `pd_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=121 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cat_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cat_description` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cat_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`),
  KEY `cat_parent_id` (`cat_parent_id`),
  KEY `cat_name` (`cat_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`cat_id`, `cat_parent_id`, `cat_name`, `cat_description`, `cat_image`) VALUES
(1, 0, 'เสื้อผ้า', 'เสื้อ กางเกง หมวก กระโปรง และอื่นๆ', 'ae871984ef85195b522f74e0951f5371.jpg'),
(2, 0, 'กระเป๋า', 'กระเป๋าเป้ กระเป๋าถือ กระเป๋าสะพาย', '6f318ccc16c5507519765f72fddfc5d1.jpg'),
(3, 2, 'กระเป๋าเป้', 'เป้สวย ตัดเย็บเนียบ คุณภาพดี', '5f96d4a0b539dc1aacc3818ebe902de4.jpg'),
(4, 0, 'นาฬิกา', 'นาฬิกาแฟชั่น นาฬิกาข้อมูลสวยๆ', '892fbd37e8b209af9fb973b1dcdff9c9.jpg'),
(5, 4, 'Triwa', 'นาฬิกาข้อมูลสำหรับบุรุษ และสตรี ยี่ห้อ Triwa', '8d24c9ed69afba90ed6b26035432d956.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `cy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cy_code` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `cy_symbol` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`cy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`cy_id`, `cy_code`, `cy_symbol`) VALUES
(1, 'EUR', '&#8364;'),
(2, 'GBP', '&pound;'),
(4, 'USD', '$'),
(5, 'THB', '฿');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE IF NOT EXISTS `tbl_order` (
  `od_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `od_date` datetime DEFAULT NULL,
  `od_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `od_status` enum('New','Paid','Shipped','Completed','Cancelled') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'New',
  `od_memo` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_state` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_postal_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_shipping_cost` decimal(5,2) DEFAULT '0.00',
  `od_payment_first_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_last_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_address1` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_address2` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_city` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_state` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `od_payment_postal_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`od_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_item`
--

CREATE TABLE IF NOT EXISTS `tbl_order_item` (
  `od_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pd_id` int(10) unsigned NOT NULL DEFAULT '0',
  `od_qty` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`od_id`,`pd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pd_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pd_description` text COLLATE utf8_unicode_ci NOT NULL,
  `pd_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `pd_qty` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pd_image` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pd_thumbnail` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pd_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pd_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pd_id`),
  KEY `cat_id` (`cat_id`),
  KEY `pd_name` (`pd_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`pd_id`, `cat_id`, `pd_name`, `pd_description`, `pd_price`, `pd_qty`, `pd_image`, `pd_thumbnail`, `pd_date`, `pd_last_update`) VALUES
(1, 3, 'เป้ลายทหาร', 'มีช่องเก็บหลากหลาย ', 1200.00, 1, 'c00a8e35a291b3320e5122581f697772.jpg', 'c1047877b2b453b675b1ae09246d63a1.jpg', '2013-02-24 04:17:29', '0000-00-00 00:00:00'),
(2, 3, 'เป้ลายทันสมัย', 'เนื้อผ้าร่ม กันน้ำ สีไม่ซีดไม่จาง ช่องใส่แยกซ้ายขวา', 1450.00, 5, '75fc8d8ef5b210ae30db6806415b4da5.jpg', '71abbc3a42da9ee70af825620a348f58.jpg', '2013-02-24 04:18:46', '0000-00-00 00:00:00'),
(3, 5, 'Triwa Brasco', 'นาฬิการะบบ Quatz ผลิตจากสแตนเลสอย่างดี หน้าปัด Saphine กันรอยขีดข่วน กันน้ำลึก 100 เมตร สามารถจับเวลาด้วย Chonometer เรืองแสงในที่มืด ', 45000.00, 5, '1297e47140b3b320372f8cd5323d0778.jpg', '5188fc24204ce00d6c1908a436c669de.jpg', '2013-02-24 04:35:46', '0000-00-00 00:00:00'),
(4, 3, 'เป้ลายดอกตัด', 'เป้ลายคอนโซเมท', 4250.00, 3, '4adfbc5eb9ede90766ec99b2a90809f7.jpg', '2194b274268bbb0bd9fcd3d41948fdef.jpg', '2013-02-24 04:51:14', '0000-00-00 00:00:00'),
(5, 3, 'เป้ลายน้ำเงิน', 'เป้ลายฟ้าตัดน้ำเงินอ่อน', 2340.00, 0, '5e9a2dab468efc51e439bacbc27579d3.jpg', 'd1574c7a5027c238c6dab277a9090ee4.jpg', '2013-02-24 04:52:36', '0000-00-00 00:00:00'),
(6, 3, 'เป้ลายน้ำตาลอ่อน', 'เป้สีอ่อนแต่เนื้อผ้าดีเยี่ยม', 2300.00, 5, 'acffe86b1444a3e423a22a7b04ae500a.jpg', '4e215986d1f4f2e8ff629444e0931c9d.jpg', '2013-02-24 04:54:06', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shop_config`
--

CREATE TABLE IF NOT EXISTS `tbl_shop_config` (
  `sc_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sc_address` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sc_phone` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sc_email` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `sc_shipping_cost` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sc_currency` int(10) unsigned NOT NULL DEFAULT '1',
  `sc_order_email` enum('y','n') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_shop_config`
--

INSERT INTO `tbl_shop_config` (`sc_name`, `sc_address`, `sc_phone`, `sc_email`, `sc_shipping_cost`, `sc_currency`, `sc_order_email`) VALUES
('jeerawuth shop', '99/623 หมู่ 4 ต. กระแชง อ. &', '080-0000000', 'jeerawuth@me.com', 200.00, 5, 'y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `user_name`, `user_password`, `user_regdate`, `user_last_login`) VALUES
(1, 'admin', 'admin', '2005-02-20 17:35:44', '2013-02-24 04:22:40'),
(2, 'webmaster', 'password', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

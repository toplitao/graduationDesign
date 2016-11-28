-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-11-27 11:42:39
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `repaircenter`
--

-- --------------------------------------------------------

--
-- 表的结构 `applyrepair`
--

CREATE TABLE IF NOT EXISTS `applyrepair` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goodsType` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '型号',
  `buyTime` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '购买时间',
  `problem` text CHARACTER SET utf8 COMMENT '具体问题',
  `customerName` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '姓名',
  `telNumber` varchar(20) CHARACTER SET utf8 DEFAULT NULL COMMENT '电话',
  `address` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '地址',
  `picture` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片地址',
  `status` int(10) DEFAULT NULL COMMENT '状态',
  `orderNumber` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '运单号',
  `backNumber` varchar(30) DEFAULT NULL COMMENT '返单号',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `fittings`
--

CREATE TABLE IF NOT EXISTS `fittings` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fittingsName` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '配件名',
  `number` int(10) DEFAULT NULL COMMENT '库存',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `goods`
--

CREATE TABLE IF NOT EXISTS `goods` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `goodsName` varchar(50) CHARACTER SET utf8 DEFAULT NULL COMMENT '商品名',
  `goodsPicture` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '图片地址',
  `goodsMessage` text CHARACTER SET utf8 COMMENT '商品信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `repairperson`
--

CREATE TABLE IF NOT EXISTS `repairperson` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `repairName` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '姓名',
  `repairAddress` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '驻点',
  `status` int(10) DEFAULT NULL COMMENT '状态',
  `aid` int(10) DEFAULT NULL COMMENT '表applyRepair的id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `int` int(10) NOT NULL AUTO_INCREMENT,
  `customerName` varchar(30) CHARACTER SET utf8 DEFAULT NULL COMMENT '客户名',
  `uid` int(10) DEFAULT NULL COMMENT '客户id',
  `video` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '视频地址',
  PRIMARY KEY (`int`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

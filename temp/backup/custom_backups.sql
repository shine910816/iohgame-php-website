/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : 127.0.0.1:3306
Source Database       : wod

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2018-12-01 00:00:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for c_coupon
-- ----------------------------
DROP TABLE IF EXISTS `c_coupon`;
CREATE TABLE `c_coupon` (
  `coupon_id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_number` varchar(20) DEFAULT NULL,
  `coupon_name` varchar(50) DEFAULT NULL,
  `coupon_descript` text,
  `coupon_favour_type` tinyint(4) NOT NULL,
  `coupon_favour_value` int(5) NOT NULL,
  `coupon_favour_value_2` int(5) NOT NULL,
  `coupon_publish_date` datetime NOT NULL,
  `coupon_vaildity_start` datetime NOT NULL,
  `coupon_vaildity_expiry` datetime NOT NULL,
  `coupon_apply_range` tinyint(4) NOT NULL,
  `coupon_apply_flg` tinyint(4) NOT NULL,
  `coupon_apply_date` datetime DEFAULT NULL,
  `custom_id` int(11) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`coupon_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_coupon
-- ----------------------------
INSERT INTO `c_coupon` VALUES ('1', '20181211C0000001', '昵称修改抵价券', '注册即日起7日内有效，只能用于修改昵称，抵价300积分。', '0', '300', '0', '2018-12-11 20:00:08', '2018-12-11 00:00:00', '2018-12-17 23:59:59', '1', '0', '0000-00-00 00:00:00', '1001', '2018-12-11 20:00:08', '2018-12-11 20:00:08', '0');
INSERT INTO `c_coupon` VALUES ('2', '20181211C0000002', '全平台3折优惠券', '全平台可享受3折优惠。', '1', '70', '0', '2018-12-11 22:00:00', '2018-01-01 00:00:00', '2019-12-31 23:59:59', '0', '0', '0000-00-00 00:00:00', '1001', '2018-12-11 20:00:08', '2018-12-11 20:00:08', '0');
INSERT INTO `c_coupon` VALUES ('3', '20181211C0000003', '全平台7折优惠券', '全平台可享受7折优惠。', '1', '30', '0', '2018-12-11 22:00:00', '2018-01-01 00:00:00', '2019-12-31 23:59:59', '0', '0', '0000-00-00 00:00:00', '1001', '2018-12-11 20:00:08', '2018-12-11 20:00:08', '0');

-- ----------------------------
-- Table structure for c_coupon_history
-- ----------------------------
DROP TABLE IF EXISTS `c_coupon_history`;
CREATE TABLE `c_coupon_history` (
  `coupon_number` varchar(20) NOT NULL,
  `custom_id` int(11) NOT NULL,
  `coupon_apply_range` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`coupon_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_coupon_history
-- ----------------------------
INSERT INTO `c_coupon_history` VALUES ('20181211C0000001', '1001', '1', '2018-12-11 16:42:06', '2018-12-11 16:42:06', '0');
INSERT INTO `c_coupon_history` VALUES ('20181211C0000002', '1001', '0', '2018-12-11 16:44:29', '2018-12-11 16:44:29', '0');
INSERT INTO `c_coupon_history` VALUES ('20181211C0000003', '1001', '0', '2018-12-11 16:44:29', '2018-12-11 16:44:29', '0');

-- ----------------------------
-- Table structure for c_event
-- ----------------------------
DROP TABLE IF EXISTS `c_event`;
CREATE TABLE `c_event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_number` varchar(36) NOT NULL,
  `event_name` varchar(50) DEFAULT NULL,
  `event_descript` text,
  `event_start_date` datetime NOT NULL,
  `event_expiry_date` datetime NOT NULL,
  `event_open_flg` tinyint(4) NOT NULL,
  `event_active_flg` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_event
-- ----------------------------
INSERT INTO `c_event` VALUES ('1', '2AC08D0A-9154-0D21-BA12-299FA6E7A78A', '注册奖励', '即日起，新注册用户可获得100积分与面值300积分的昵称修改抵价券一张。感谢您对本网站的支持。', '2015-01-01 00:00:00', '9999-12-31 23:59:59', '1', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');

-- ----------------------------
-- Table structure for c_point
-- ----------------------------
DROP TABLE IF EXISTS `c_point`;
CREATE TABLE `c_point` (
  `custom_id` int(11) NOT NULL,
  `custom_point` int(11) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_point
-- ----------------------------
INSERT INTO `c_point` VALUES ('100', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('101', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('102', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('103', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('104', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('105', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('106', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('107', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('108', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('109', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('110', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('111', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('112', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('113', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('114', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `c_point` VALUES ('1001', '100', '2018-12-11 16:44:28', '2018-12-11 16:44:29', '0');

-- ----------------------------
-- Table structure for c_point_history
-- ----------------------------
DROP TABLE IF EXISTS `c_point_history`;
CREATE TABLE `c_point_history` (
  `point_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_id` int(11) NOT NULL,
  `point_value` int(11) NOT NULL,
  `point_type` tinyint(4) NOT NULL,
  `point_note` text,
  `point_before` int(11) NOT NULL,
  `point_after` int(11) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`point_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2  DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of c_point_history
-- ----------------------------
INSERT INTO `c_point_history` VALUES ('1', '1001', '100', '0', '', '0', '100', '2018-12-11 16:44:29', '2018-12-11 16:44:29', '0');

-- ----------------------------
-- Table structure for custom_admin
-- ----------------------------
DROP TABLE IF EXISTS `custom_admin`;
CREATE TABLE `custom_admin` (
  `custom_id` int(11) NOT NULL,
  `admin_lvl` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_admin
-- ----------------------------
INSERT INTO `custom_admin` VALUES ('100', '2', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_admin` VALUES ('101', '1', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_admin` VALUES ('102', '1', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_admin` VALUES ('103', '1', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_admin` VALUES ('104', '1', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');

-- ----------------------------
-- Table structure for custom_info
-- ----------------------------
DROP TABLE IF EXISTS `custom_info`;
CREATE TABLE `custom_info` (
  `custom_id` int(11) NOT NULL,
  `custom_nick` varchar(20) DEFAULT NULL,
  `custom_gender` tinyint(4) NOT NULL,
  `custom_birth` date NOT NULL,
  `confirm_flg` tinyint(4) NOT NULL,
  `open_level` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_info
-- ----------------------------
INSERT INTO `custom_info` VALUES ('100', '超级管理员', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('101', '管理员青龙', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('102', '管理员朱雀', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('103', '管理员白虎', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('104', '管理员玄武', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('105', '测试员甲', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('106', '测试员乙', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('107', '测试员丙', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('108', '测试员丁', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('109', '测试员戊', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('110', '测试员己', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('111', '测试员庚', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('112', '测试员辛', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('113', '测试员壬', '1', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('114', '测试员癸', '0', '1990-01-01', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_info` VALUES ('1001', 'shine910816', '0', '1990-01-01', '0', '2', '2018-12-11 16:44:28', '2018-12-11 16:44:28', '0');

-- ----------------------------
-- Table structure for custom_login
-- ----------------------------
DROP TABLE IF EXISTS `custom_login`;
CREATE TABLE `custom_login` (
  `custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_login_name` varchar(100) DEFAULT NULL,
  `custom_tele_number` varchar(20) DEFAULT NULL,
  `custom_mail_address` varchar(200) DEFAULT NULL,
  `custom_salt` varchar(10) DEFAULT NULL,
  `custom_tele_flg` tinyint(4) NOT NULL,
  `custom_mail_flg` tinyint(4) NOT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_login
-- ----------------------------
INSERT INTO `custom_login` VALUES ('100', 'administrator', '', '', 'u84v8s', '1', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('101', 'admin01', '', '', 'pdzl7r', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('102', 'admin02', '', '', '09acuv', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('103', 'admin03', '', '', '8zf0o1', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('104', 'admin04', '', '', '7rxb6r', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('105', 'tester01', '', '', 'm5t21g', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('106', 'tester02', '', '', '2bvifj', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('107', 'tester03', '', '', 'c6td6t', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('108', 'tester04', '', '', 'rwl97p', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('109', 'tester05', '', '', 'aulwif', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('110', 'tester06', '', '', 'x2yboa', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('111', 'tester07', '', '', 'ves6x0', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('112', 'tester08', '', '', 'queziu', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('113', 'tester09', '', '', 'yojauw', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('114', 'tester10', '', '', 'urs1ue', '0', '0', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_login` VALUES ('1001', 'shine910816', '', '', 'rzkdsx', '0', '0', '2018-12-11 16:44:28', '2018-12-11 16:44:28', '0');

-- ----------------------------
-- Table structure for custom_password
-- ----------------------------
DROP TABLE IF EXISTS `custom_password`;
CREATE TABLE `custom_password` (
  `custom_id` int(11) NOT NULL,
  `custom_password` varchar(32) DEFAULT NULL,
  `insert_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `del_flg` tinyint(4) NOT NULL,
  PRIMARY KEY (`custom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of custom_password
-- ----------------------------
INSERT INTO `custom_password` VALUES ('100', '9f274a232f22425ba7a4eec92147e53e', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('101', '2bd7c755b0f38e791f0b4fcf0f9d3768', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('102', 'f5c1a15a3d9d80d2dea9ac493182a441', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('103', '29350b89478c8728888be5f88f9f251a', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('104', 'eb29ded5da7674393422f5fd9bd5b1cf', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('105', 'ee746436c1b433e13282c712f6218cc8', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('106', 'b1651c3ec99d24b9c7a8e9ae5448181b', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('107', 'c374af4df44398eaaff95e0c72fd2d13', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('108', 'cfae2e8e941bbb5c29a5a57e0a62a764', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('109', '18ddf504d991d42ba179a265ed489a7a', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('110', '8be837cfd3ed4d48812e01312f6d6fb5', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('111', '18511021f3129d316aa99e1d6a186662', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('112', '8ad97c70e701726865580dae6f67aa49', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('113', 'e5b191b4218d5bed53cddbca7b372055', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('114', 'e8aaf5607bd6ac60210c4ccd7b1de9a8', '2018-01-01 00:00:00', '2018-01-01 00:00:00', '0');
INSERT INTO `custom_password` VALUES ('1001', '0d344ded82be68596e78617ac2ed17dc', '2018-12-11 16:44:28', '2018-12-11 16:44:28', '0');

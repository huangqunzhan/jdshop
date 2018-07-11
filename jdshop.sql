/*
Navicat MySQL Data Transfer

Source Server         : Database
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : jdshop

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2018-07-11 22:36:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `jdshop_admin`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_admin`;
CREATE TABLE `jdshop_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(32) NOT NULL,
  `admin_password` varchar(32) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin` (`admin_name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_admin
-- ----------------------------
INSERT INTO `jdshop_admin` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112');
INSERT INTO `jdshop_admin` VALUES ('3', 'admina', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `jdshop_admin` VALUES ('4', '123456', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `jdshop_admin` VALUES ('5', 'admin123', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `jdshop_admin` VALUES ('6', '111111', '25d55ad283aa400af464c76d713c07ad');
INSERT INTO `jdshop_admin` VALUES ('7', 'aaaa', 'e10adc3949ba59abbe56e057f20f883e');
INSERT INTO `jdshop_admin` VALUES ('8', 'aaaaa', '25d55ad283aa400af464c76d713c07ad');

-- ----------------------------
-- Table structure for `jdshop_cate`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_cate`;
CREATE TABLE `jdshop_cate` (
  `cate_id` int(10) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL,
  `cate_pid` int(11) NOT NULL,
  `cate_level` int(11) NOT NULL,
  `cate_sort` int(10) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_cate
-- ----------------------------
INSERT INTO `jdshop_cate` VALUES ('1', '家用电器', '0', '1', '4');
INSERT INTO `jdshop_cate` VALUES ('2', '电视', '1', '2', '5');
INSERT INTO `jdshop_cate` VALUES ('3', '冰箱', '1', '2', '0');
INSERT INTO `jdshop_cate` VALUES ('5', '手机', '0', '1', '5');
INSERT INTO `jdshop_cate` VALUES ('6', '电脑', '0', '1', '1');
INSERT INTO `jdshop_cate` VALUES ('7', '手机通信', '5', '2', '0');
INSERT INTO `jdshop_cate` VALUES ('8', '空调', '1', '2', '4');
INSERT INTO `jdshop_cate` VALUES ('18', '互联网品牌', '2', '3', '2');
INSERT INTO `jdshop_cate` VALUES ('10', '老人机', '7', '3', '3');
INSERT INTO `jdshop_cate` VALUES ('13', '华为手机', '7', '3', '1');
INSERT INTO `jdshop_cate` VALUES ('36', '苹果手机', '7', '3', '2');
INSERT INTO `jdshop_cate` VALUES ('14', '合资品牌', '2', '3', '3');
INSERT INTO `jdshop_cate` VALUES ('16', '食品', '0', '1', '2');
INSERT INTO `jdshop_cate` VALUES ('19', '休闲食品', '16', '2', '1');
INSERT INTO `jdshop_cate` VALUES ('20', '坚果炒货', '19', '3', '1');
INSERT INTO `jdshop_cate` VALUES ('21', '电脑整机', '6', '2', '1');
INSERT INTO `jdshop_cate` VALUES ('22', '笔记本', '21', '3', '2');
INSERT INTO `jdshop_cate` VALUES ('24', '壁挂式空调', '8', '3', '1');
INSERT INTO `jdshop_cate` VALUES ('25', '两门', '3', '3', '1');
INSERT INTO `jdshop_cate` VALUES ('26', '三门', '3', '3', '2');
INSERT INTO `jdshop_cate` VALUES ('27', '多门', '3', '3', '3');
INSERT INTO `jdshop_cate` VALUES ('28', '家居', '0', '0', '3');
INSERT INTO `jdshop_cate` VALUES ('29', '厨具', '28', '0', '1');
INSERT INTO `jdshop_cate` VALUES ('30', '餐具', '29', '0', '1');
INSERT INTO `jdshop_cate` VALUES ('37', '休闲零食', '19', '3', '0');
INSERT INTO `jdshop_cate` VALUES ('31', '生活日用', '28', '0', '0');
INSERT INTO `jdshop_cate` VALUES ('32', '清洁工具', '31', '0', '0');

-- ----------------------------
-- Table structure for `jdshop_goods`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_goods`;
CREATE TABLE `jdshop_goods` (
  `goods_id` int(11) NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(200) NOT NULL,
  `goods_thumb` varchar(200) NOT NULL,
  `goods_price` decimal(10,2) NOT NULL,
  `goods_after_price` decimal(10,2) NOT NULL,
  `goods_status` tinyint(2) NOT NULL DEFAULT '1',
  `goods_sales` int(10) NOT NULL DEFAULT '0',
  `goods_inventory` int(10) NOT NULL DEFAULT '0',
  `goods_pid` int(10) NOT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_goods
-- ----------------------------
INSERT INTO `jdshop_goods` VALUES ('19', 'Apple 苹果 iPhone 6s Plus', '\\jdshop\\public\\uploads\\20180616\\3fe93937f567762ba4c68dc365331d8a.JPG', '2838.00', '0.00', '1', '10000', '150000', '36');
INSERT INTO `jdshop_goods` VALUES ('2', 'Apple 苹果 iPhone X (A1865)', '\\jdshop\\public\\uploads\\20180603\\899fdd1050b578f5bf231d21eb74c6d9.jpg', '7599.00', '0.00', '1', '5000', '80000', '36');
INSERT INTO `jdshop_goods` VALUES ('3', '华为（HUAWEI） 荣耀8青春版 手机', '\\jdshop\\public\\uploads\\20180603\\ac1eb167f0a6be261a699d078591e8e8.jpg', '1199.00', '0.00', '1', '6000', '70000', '13');
INSERT INTO `jdshop_goods` VALUES ('4', '荣耀10', '\\jdshop\\public\\uploads\\20180603\\34ab9ff42c3a102021ff9cd7e04a8cc2.jpg', '2599.00', '2500.00', '1', '4000', '68000', '13');
INSERT INTO `jdshop_goods` VALUES ('5', '手剥松子', '\\jdshop\\public\\uploads\\20180603\\f1a0df355a3cae9ec10650bf24161c61.jpg', '46.90', '45.00', '1', '8000', '90000', '20');
INSERT INTO `jdshop_goods` VALUES ('6', '甘栗仁', '\\jdshop\\public\\uploads\\20180603\\f5894fd3f12345310c1822adf578c611.jpg', '12.90', '12.00', '1', '7000', '80000', '20');
INSERT INTO `jdshop_goods` VALUES ('20', '雀巢（Nestle）脆脆鲨 ', '\\jdshop\\public\\uploads\\20180617\\000e4ec83d1e64a6caa888a3a5f8ddab.jpg', '27.80', '0.00', '1', '14000', '500000', '37');

-- ----------------------------
-- Table structure for `jdshop_goodsproperty`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_goodsproperty`;
CREATE TABLE `jdshop_goodsproperty` (
  `goodsproperty_id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `goodsproperty_content` varchar(100) NOT NULL,
  `goods_id` int(11) NOT NULL,
  PRIMARY KEY (`goodsproperty_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_goodsproperty
-- ----------------------------
INSERT INTO `jdshop_goodsproperty` VALUES ('17', '19', '0.6kg', '19');
INSERT INTO `jdshop_goodsproperty` VALUES ('8', '15', '安卓 (Android)', '3');
INSERT INTO `jdshop_goodsproperty` VALUES ('7', '16', '4G', '3');
INSERT INTO `jdshop_goodsproperty` VALUES ('10', '13', '华为（HUAWEI） 荣耀8青春版', '3');
INSERT INTO `jdshop_goodsproperty` VALUES ('16', '18', 'Apple 苹果 iPhone 6s Plus', '19');
INSERT INTO `jdshop_goodsproperty` VALUES ('18', '20', '8G', '19');
INSERT INTO `jdshop_goodsproperty` VALUES ('19', '16', '8G', '4');
INSERT INTO `jdshop_goodsproperty` VALUES ('20', '15', '安卓（Android）', '4');
INSERT INTO `jdshop_goodsproperty` VALUES ('21', '13', '华为荣耀10', '4');
INSERT INTO `jdshop_goodsproperty` VALUES ('22', '18', 'Apple 苹果 iPhone X (A1865) ', '2');
INSERT INTO `jdshop_goodsproperty` VALUES ('23', '19', '0.6kg', '2');
INSERT INTO `jdshop_goodsproperty` VALUES ('24', '20', '8G', '2');

-- ----------------------------
-- Table structure for `jdshop_goods_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_goods_keywords`;
CREATE TABLE `jdshop_goods_keywords` (
  `goods_id` int(11) NOT NULL,
  `keywords_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_goods_keywords
-- ----------------------------
INSERT INTO `jdshop_goods_keywords` VALUES ('20', '37');
INSERT INTO `jdshop_goods_keywords` VALUES ('3', '20');
INSERT INTO `jdshop_goods_keywords` VALUES ('5', '24');
INSERT INTO `jdshop_goods_keywords` VALUES ('3', '19');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '28');
INSERT INTO `jdshop_goods_keywords` VALUES ('5', '18');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '22');
INSERT INTO `jdshop_goods_keywords` VALUES ('20', '36');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '27');
INSERT INTO `jdshop_goods_keywords` VALUES ('3', '22');
INSERT INTO `jdshop_goods_keywords` VALUES ('3', '21');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '19');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '30');
INSERT INTO `jdshop_goods_keywords` VALUES ('5', '26');
INSERT INTO `jdshop_goods_keywords` VALUES ('4', '29');
INSERT INTO `jdshop_goods_keywords` VALUES ('5', '25');
INSERT INTO `jdshop_goods_keywords` VALUES ('6', '32');
INSERT INTO `jdshop_goods_keywords` VALUES ('6', '25');
INSERT INTO `jdshop_goods_keywords` VALUES ('6', '24');
INSERT INTO `jdshop_goods_keywords` VALUES ('2', '7');
INSERT INTO `jdshop_goods_keywords` VALUES ('19', '2');
INSERT INTO `jdshop_goods_keywords` VALUES ('19', '10');
INSERT INTO `jdshop_goods_keywords` VALUES ('19', '19');
INSERT INTO `jdshop_goods_keywords` VALUES ('2', '17');
INSERT INTO `jdshop_goods_keywords` VALUES ('2', '16');

-- ----------------------------
-- Table structure for `jdshop_img`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_img`;
CREATE TABLE `jdshop_img` (
  `img_id` int(10) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `goods_id` int(10) NOT NULL,
  PRIMARY KEY (`img_id`)
) ENGINE=MyISAM AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_img
-- ----------------------------
INSERT INTO `jdshop_img` VALUES ('102', '\\jdshop\\public\\uploads\\img\\20180616\\5df195bb2e21abb9f0ff4fdc0020dc9e.jpg', '3');
INSERT INTO `jdshop_img` VALUES ('95', '\\jdshop\\public\\uploads\\img\\20180616\\dac5aeda68c46ce728f57c10ce0e569e.jpg', '4');
INSERT INTO `jdshop_img` VALUES ('96', '\\jdshop\\public\\uploads\\img\\20180616\\eb70fb3530683bd266d27d7cd1979517.jpg', '4');
INSERT INTO `jdshop_img` VALUES ('97', '\\jdshop\\public\\uploads\\img\\20180616\\59f638d10a1235a6491791965157170a.jpg', '5');
INSERT INTO `jdshop_img` VALUES ('98', '\\jdshop\\public\\uploads\\img\\20180616\\1d342087a237454912a80fb4464ed93d.jpg', '5');
INSERT INTO `jdshop_img` VALUES ('99', '\\jdshop\\public\\uploads\\img\\20180616\\60523144b678de7a91eca814930a8bbf.jpg', '6');
INSERT INTO `jdshop_img` VALUES ('100', '\\jdshop\\public\\uploads\\img\\20180616\\63f035824947c28342bcc94ddd150a45.jpg', '6');
INSERT INTO `jdshop_img` VALUES ('101', '\\jdshop\\public\\uploads\\img\\20180616\\5dafbad3ca0a9c853059165367a2c816.jpg', '3');
INSERT INTO `jdshop_img` VALUES ('103', '\\jdshop\\public\\uploads\\img\\20180616\\0e4c86bc78a3021ce2e5661d82e3c851.jpg', '2');
INSERT INTO `jdshop_img` VALUES ('93', '\\jdshop\\public\\uploads\\img\\20180616\\75750bf8bb61a626e27224feab5cb36e.jpg', '3');
INSERT INTO `jdshop_img` VALUES ('92', '\\jdshop\\public\\uploads\\img\\20180616\\49a3260048c85ebc01c8edb790126d3d.jpg', '2');
INSERT INTO `jdshop_img` VALUES ('91', '\\jdshop\\public\\uploads\\img\\20180616\\585edb1f5915766ffe06919cbe80a17d.jpg', '2');
INSERT INTO `jdshop_img` VALUES ('106', '\\jdshop\\public\\uploads\\img\\20180617\\256ba5d7e789b02cf65f3ec432af4943.jpg', '20');
INSERT INTO `jdshop_img` VALUES ('107', '\\jdshop\\public\\uploads\\img\\20180617\\7901fbd91b581b19896b6fb96f0786bd.jpg', '20');

-- ----------------------------
-- Table structure for `jdshop_keywords`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_keywords`;
CREATE TABLE `jdshop_keywords` (
  `keywords_id` int(11) NOT NULL AUTO_INCREMENT,
  `keywords_name` varchar(100) NOT NULL,
  PRIMARY KEY (`keywords_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_keywords
-- ----------------------------
INSERT INTO `jdshop_keywords` VALUES ('1', '16g');
INSERT INTO `jdshop_keywords` VALUES ('2', '32g');
INSERT INTO `jdshop_keywords` VALUES ('5', '手机');
INSERT INTO `jdshop_keywords` VALUES ('6', '华为');
INSERT INTO `jdshop_keywords` VALUES ('7', '64g');
INSERT INTO `jdshop_keywords` VALUES ('8', '128g');
INSERT INTO `jdshop_keywords` VALUES ('9', '干果');
INSERT INTO `jdshop_keywords` VALUES ('10', '玫瑰金');
INSERT INTO `jdshop_keywords` VALUES ('16', '深空灰色');
INSERT INTO `jdshop_keywords` VALUES ('17', '移动联通电信4G手机');
INSERT INTO `jdshop_keywords` VALUES ('18', '良品铺子');
INSERT INTO `jdshop_keywords` VALUES ('19', '全网通4G');
INSERT INTO `jdshop_keywords` VALUES ('20', '幻海蓝');
INSERT INTO `jdshop_keywords` VALUES ('21', '4G+64G');
INSERT INTO `jdshop_keywords` VALUES ('22', '移动定制版');
INSERT INTO `jdshop_keywords` VALUES ('23', '手剥松子');
INSERT INTO `jdshop_keywords` VALUES ('24', '干果坚果');
INSERT INTO `jdshop_keywords` VALUES ('25', '零食特产');
INSERT INTO `jdshop_keywords` VALUES ('26', '袋装小吃120g');
INSERT INTO `jdshop_keywords` VALUES ('27', '全面屏AI摄影手机');
INSERT INTO `jdshop_keywords` VALUES ('28', '6GB+64GB');
INSERT INTO `jdshop_keywords` VALUES ('29', '游戏手机');
INSERT INTO `jdshop_keywords` VALUES ('30', '幻夜黑');
INSERT INTO `jdshop_keywords` VALUES ('31', '双卡双待');
INSERT INTO `jdshop_keywords` VALUES ('32', '休闲板栗80g');
INSERT INTO `jdshop_keywords` VALUES ('33', '自然片');
INSERT INTO `jdshop_keywords` VALUES ('34', '肉脯肉干');
INSERT INTO `jdshop_keywords` VALUES ('35', '休闲零食100g');
INSERT INTO `jdshop_keywords` VALUES ('36', '休闲零食');
INSERT INTO `jdshop_keywords` VALUES ('37', '威化饼干巧克力味24*20g+8*20g');

-- ----------------------------
-- Table structure for `jdshop_property`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_property`;
CREATE TABLE `jdshop_property` (
  `property_id` int(10) NOT NULL AUTO_INCREMENT,
  `property_name` varchar(30) NOT NULL,
  `property_pid` int(10) NOT NULL COMMENT '属性所属的分类',
  PRIMARY KEY (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_property
-- ----------------------------
INSERT INTO `jdshop_property` VALUES ('16', '运行内存', '13');
INSERT INTO `jdshop_property` VALUES ('15', '手机系统', '13');
INSERT INTO `jdshop_property` VALUES ('22', '净重', '37');
INSERT INTO `jdshop_property` VALUES ('13', '手机名称', '13');
INSERT INTO `jdshop_property` VALUES ('18', '商品名称', '36');
INSERT INTO `jdshop_property` VALUES ('19', '手机毛重', '36');
INSERT INTO `jdshop_property` VALUES ('20', '内存ROM', '36');

-- ----------------------------
-- Table structure for `jdshop_user`
-- ----------------------------
DROP TABLE IF EXISTS `jdshop_user`;
CREATE TABLE `jdshop_user` (
  `user_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) DEFAULT NULL,
  `user_password` varchar(100) DEFAULT NULL,
  `user_email_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '用户邮箱是否激活，0未激活，1激活',
  `user_phone` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jdshop_user
-- ----------------------------
INSERT INTO `jdshop_user` VALUES ('1', '123456@qq.com', '96e79218965eb72c92a549dd5a330112', '0', '');
INSERT INTO `jdshop_user` VALUES ('2', '1041684959@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '0', '');
INSERT INTO `jdshop_user` VALUES ('3', '577842700@qq.com', 'e10adc3949ba59abbe56e057f20f883e', '0', null);
INSERT INTO `jdshop_user` VALUES ('4', null, null, '0', '11111111111');

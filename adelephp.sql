/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 60011
Source Host           : localhost:3306
Source Database       : adelephp

Target Server Type    : MYSQL
Target Server Version : 60011
File Encoding         : 65001

Date: 2017-09-24 17:19:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `adelephp_book`
-- ----------------------------
DROP TABLE IF EXISTS `adelephp_book`;
CREATE TABLE `adelephp_book` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '小说名',
  `gid` int(10) unsigned NOT NULL COMMENT '采集id',
  `author` varchar(255) NOT NULL COMMENT '作者',
  `type` char(10) NOT NULL COMMENT '类型',
  `last_create_time` varchar(255) NOT NULL COMMENT '最新更新时间',
  `count` int(10) unsigned NOT NULL COMMENT '最大章节',
  `img` varchar(255) NOT NULL COMMENT '图片',
  `desc` varchar(255) NOT NULL COMMENT '描述',
  `last_create_section` varchar(255) NOT NULL COMMENT '最新更新章节名',
  `hot` decimal(5,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '是否热门',
  `classical` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '是否经典',
  `banner` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否上banner',
  `banner_img` varchar(255) NOT NULL COMMENT 'banner图片',
  `is_update` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '是否更新',
  `last_novel_id` int(10) unsigned NOT NULL COMMENT '最新章节id',
  `last_section` varchar(255) NOT NULL COMMENT '最新章节',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=307 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of adelephp_book
-- ----------------------------

-- ----------------------------
-- Table structure for `adelephp_gather`
-- ----------------------------
DROP TABLE IF EXISTS `adelephp_gather`;
CREATE TABLE `adelephp_gather` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `detail_url` varchar(255) DEFAULT NULL,
  `detail_start` text,
  `detail_end` text,
  `detail_pattern` text,
  `section_url` varchar(255) DEFAULT NULL,
  `section_start` varchar(255) DEFAULT NULL,
  `section_end` varchar(255) DEFAULT NULL,
  `section_pattern` varchar(255) DEFAULT NULL,
  `section_page` int(2) NOT NULL DEFAULT '0',
  `section_page_start` varchar(255) DEFAULT NULL,
  `section_page_end` varchar(255) DEFAULT NULL,
  `section_page_pattern` varchar(255) DEFAULT NULL,
  `content_start` varchar(255) DEFAULT NULL,
  `content_end` varchar(255) DEFAULT NULL,
  `content_pattern` varchar(255) DEFAULT NULL,
  `iconv` varchar(255) NOT NULL DEFAULT 'utf-8',
  `templet` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adelephp_gather
-- ----------------------------
INSERT INTO `adelephp_gather` VALUES ('2', 'http://www.iadele.cn/home/html/1_1_0.html', '<div class=\"detail\">;\r\nname:<h1>;\r\nauthor:<h1>;\r\nimg:<div class=\"book-img\">;\r\ndesc:<p class=\"intro\">;', '<div class=\"book-comment\">;\r\nname:</h1>;\r\nauthor:</h1>;\r\nimg:</div>;\r\ndesc:</p>;', 'name:/<em>(.*)</em>/U;\r\nauthor:/<span><a href=.*>(.*)</a>/U;\r\nimg:/<img src=\"(.*)\">/U;\r\ndesc:/<p class=\"intro\">(.*)/;', '', '<ul class=\"cl\">', '</ul>', '/<a href=\"(.*)\" .*>(.*)</a>/U', '0', null, null, null, '<div class=\"content\">', '</div>', '/(.*)/s', 'utf-8', '0');
INSERT INTO `adelephp_gather` VALUES ('3', 'http://www.iadele.cn/home/html/1_1_0.html', '<div class=\"detail\">;\r\nname:<h1>;\r\nauthor:<h1>;\r\nimg:<div class=\"book-img\">;\r\ndesc:<p class=\"intro\">;', '<div class=\"book-comment\">;\r\nname:</h1>;\r\nauthor:</h1>;\r\nimg:</div>;\r\ndesc:</p>;', 'name:/<em>(.*)<\\/em>/U;\r\nauthor:/<span><a href=.*>(.*)<\\/a>/U;\r\nimg:/<img src=\"(.*)\">/U;\r\ndesc:/<p class=\"intro\">(.*)/;', 'http://www.iadele.cn/home/html/1_1_0.html', '<ul class=\"cl\">', '</ul>', '/<a href=\"(.*)\" .*>(.*)<\\/a>/U', '0', null, null, null, '<div class=\"content\">', '</div>', '/<div class=\"content\">(.*)/s', 'utf-8', '0');
INSERT INTO `adelephp_gather` VALUES ('4', 'http://www.iadele.cn/home/html/1_1_0.html', '<div class=\"detail\">;\r\nname:<h1>;\r\nauthor:<h1>;\r\nimg:<div class=\"book-img\">;\r\ndesc:<p class=\"intro\">;', '<div class=\"book-comment\">;\r\nname:</h1>;\r\nauthor:</h1>;\r\nimg:</div>;\r\ndesc:</p>;', 'name:/<em>(.*)<\\/em>/U;\r\nauthor:/<span><a href=.*>(.*)<\\/a>/U;\r\nimg:/<img src=\"(.*)\">/U;\r\ndesc:/<p class=\"intro\">(.*)/;', 'http://www.iadele.cn/home/html/1_1_0.html', '<ul class=\"cl\">', '</ul>', '/<a href=\"(.*)\" .*>(.*)<\\/a>/U', '1', '<div class=\"catalog\">', '</h3>', '/<a href=\"(.*)\">.*<\\/a>/U', '<div class=\"content\">', '</div>', '/<div class=\"content\">(.*)/s', 'utf-8', '1');

-- ----------------------------
-- Table structure for `adelephp_nav`
-- ----------------------------
DROP TABLE IF EXISTS `adelephp_nav`;
CREATE TABLE `adelephp_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `url` varchar(255) NOT NULL DEFAULT '',
  `order` int(5) NOT NULL DEFAULT '0',
  `pid` int(5) NOT NULL DEFAULT '0',
  `group` varchar(255) NOT NULL DEFAULT '默认分组',
  `is_hide` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adelephp_nav
-- ----------------------------
INSERT INTO `adelephp_nav` VALUES ('1', '首页', 'admin/admin/index', '0', '0', '', '0');
INSERT INTO `adelephp_nav` VALUES ('2', '系统', 'admin/admin/system', '1', '0', '', '0');
INSERT INTO `adelephp_nav` VALUES ('3', '网站设置', 'admin/config/base', '0', '2', '默认分组', '0');
INSERT INTO `adelephp_nav` VALUES ('4', '菜单管理', 'admin/menu/index', '0', '2', '默认分组', '0');
INSERT INTO `adelephp_nav` VALUES ('5', '采集', 'admin/gather/index', '0', '0', '', '0');
INSERT INTO `adelephp_nav` VALUES ('9', '采集规则', 'admin/gather/index', '1', '5', '默认分组', '0');
INSERT INTO `adelephp_nav` VALUES ('11', '测试', '', '0', '0', '默认分组', '0');
INSERT INTO `adelephp_nav` VALUES ('13', '采集配置', 'admin/gather/config', '1', '5', '默认分组', '0');

-- ----------------------------
-- Table structure for `adelephp_novel`
-- ----------------------------
DROP TABLE IF EXISTS `adelephp_novel`;
CREATE TABLE `adelephp_novel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `section` decimal(8,3) NOT NULL DEFAULT '0.000',
  `content` text,
  `subsection` int(5) NOT NULL DEFAULT '0',
  `bid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of adelephp_novel
-- ----------------------------

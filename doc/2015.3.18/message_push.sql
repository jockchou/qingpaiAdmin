/*
Navicat MySQL Data Transfer

Source Server         : zxy
Source Server Version : 50537
Source Host           : 121.201.7.119:3306
Source Database       : pingo

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2015-03-18 13:55:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `message_push`
-- ----------------------------
DROP TABLE IF EXISTS `message_push`;
CREATE TABLE `message_push` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL DEFAULT '0' COMMENT '帖子类型，0: 纯文本，1: 图文，2: 音频，3: 视频',
  `title` varchar(120) NOT NULL,
  `content` varchar(255) NOT NULL,
  `os` varchar(30) NOT NULL COMMENT 'all、ios、android',
  `pushTime` datetime DEFAULT NULL,
  `addTime` datetime DEFAULT NULL,
  `isSend` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0:未发，1：发送中 2：已发送',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of message_push
-- ----------------------------
INSERT INTO `message_push` VALUES ('127', '0', 'title', 'contents', 'all', '2015-03-18 13:51:18', '2015-03-18 13:51:06', '0');

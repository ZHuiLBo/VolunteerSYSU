/*
Navicat MySQL Data Transfer

Source Server         : Volunteer
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : volunteer

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2017-10-15 13:21:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `activity`
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '活动id',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `recruitment_count` int(11) NOT NULL COMMENT '招募人数',
  `number_of_applicants` int(11) NOT NULL DEFAULT '0' COMMENT '已报名人数',
  `activity_date` date NOT NULL COMMENT '活动日期',
  `deadline` date NOT NULL COMMENT '截至日期',
  `face_to` enum('2','1','0') NOT NULL COMMENT '面向人群,0-东校，1-南校，2-全校',
  `sponsor` varchar(255) NOT NULL,
  `activity_location` varchar(255) NOT NULL COMMENT '活动地点',
  `hours_a_day` tinyint(4) NOT NULL COMMENT '公益时（/天）',
  `detail` longtext NOT NULL COMMENT '具体描述',
  `qq_number` varchar(255) NOT NULL COMMENT 'qq群号',
  `publish_time` datetime NOT NULL COMMENT '发布时间，先表示活动创建时间，审核后表示通过后的时间',
  `audit_result` enum('2','1','0') NOT NULL DEFAULT '0' COMMENT '管理员审核情况，0-待审核，1-审核通过，2-审核不通过',
  `audit_opinion` varchar(255) DEFAULT NULL COMMENT '审核意见',
  `publisher` int(11) NOT NULL,
  PRIMARY KEY (`activity_id`),
  KEY `发布人外键` (`publisher`),
  CONSTRAINT `发布人外键` FOREIGN KEY (`publisher`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity
-- ----------------------------
INSERT INTO `activity` VALUES ('4', 'z', '2', '0', '2017-12-22', '2017-11-23', '0', 'z', 'z', '2', 'z', 'z', '2017-10-15 13:19:59', '0', null, '1');

-- ----------------------------
-- Table structure for `application`
-- ----------------------------
DROP TABLE IF EXISTS `application`;
CREATE TABLE `application` (
  `application_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '报名id',
  `user_id` int(11) NOT NULL COMMENT '用户id，外键',
  `activity_id` int(11) NOT NULL COMMENT '活动id，外键',
  `apply_time` datetime NOT NULL COMMENT '报名时间',
  `application_state` enum('2','1','0') NOT NULL DEFAULT '0' COMMENT '报名状态，0-待审核，1-已录用，2-报名失败',
  `performance` enum('2','1','0') NOT NULL DEFAULT '0' COMMENT '活动完成情况，0-正在进行，1-已完成，2-未完成',
  PRIMARY KEY (`application_id`),
  KEY `用户` (`user_id`),
  KEY `活动` (`activity_id`),
  CONSTRAINT `用户` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `活动` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of application
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(8) NOT NULL COMMENT '用户名',
  `password` varchar(50) NOT NULL DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '密码',
  `campus` enum('1','0') NOT NULL COMMENT '校区，0:东校，1：南校',
  `year` year(4) NOT NULL COMMENT '入学年份',
  `phone_number` char(11) NOT NULL COMMENT '11位手机号',
  `academy` varchar(100) NOT NULL COMMENT '学院名称',
  `name` varchar(50) NOT NULL COMMENT '学生姓名',
  `role` enum('1','0') NOT NULL DEFAULT '0' COMMENT '用户类别，0:普通用户，1：管理员',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '17214719', 'e10adc3949ba59abbe56e057f20f883e', '0', '2017', '18038096606', '数据科学与计算机学院', '赵惠', '0');
INSERT INTO `user` VALUES ('2', '17214720', 'e10adc3949ba59abbe56e057f20f883e', '0', '2017', '18138096606', '马克思主义学院', '哈哈', '0');
INSERT INTO `user` VALUES ('3', '17214721', 'e10adc3949ba59abbe56e057f20f883e', '0', '2017', '12345678900', '文学院', '啦啦', '0');
INSERT INTO `user` VALUES ('4', '12345678', 'e10adc3949ba59abbe56e057f20f883e', '0', '2017', '12345678900', '数据科学与计算机学院', '管理员', '1');

/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : artifact

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-08-09 00:35:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chats
-- ----------------------------
DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `chat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `chat_user_id` int(11) DEFAULT '0' COMMENT '接收用户',
  `chat_text` text COMMENT '聊天信息',
  `chat_is_read` tinyint(4) DEFAULT '0',
  `chat_created` int(11) DEFAULT '0',
  `chat_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`chat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of chats
-- ----------------------------
INSERT INTO `chats` VALUES ('1', '3', '2', '3=>2', '0', '1444131552', '0');
INSERT INTO `chats` VALUES ('2', '2', '3', '2=>3', '0', '1444131552', '0');
INSERT INTO `chats` VALUES ('3', '3', '2', '33=>22', '0', '1444131552', '0');
INSERT INTO `chats` VALUES ('4', '2', '3', '22=>33', '0', '1444131552', '0');
INSERT INTO `chats` VALUES ('5', '4', '2', '4=>2', '0', '1444131552', '0');

-- ----------------------------
-- Table structure for logs
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT '0',
  `log_type_id` int(11) DEFAULT '0',
  `log_text` text,
  `log_created` int(11) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of logs
-- ----------------------------
INSERT INTO `logs` VALUES ('1', '1', '1', '{\"user_id\":\"1\",\"role_id\":1,\"user_parent_id\":\"0\",\"user_code\":\"admin\",\"user_password\":\"123123\",\"user_name\":\"\\u7ba1\\u7406\\u5458\",\"user_mobile\":\"\",\"user_email\":\"\",\"user_reg_time\":\"0\",\"user_reg_ip\":null,\"user_expire\":1443074439,\"user_last_time\":\"1442210808\",\"user_last_ip\":\"127.0.0.1\",\"user_login_num\":\"124\",\"user_is_delete\":\"0\",\"user_is_exp\":\"0\",\"user_remark\":\"\",\"user_created\":\"1442118040\",\"user_updated\":1442210818}', '1442210818');
INSERT INTO `logs` VALUES ('2', '1', '4', '{\"message_id\":\"11\",\"user_id\":\"0\",\"message_text\":\"f\",\"message_time\":\"1442118040\",\"message_is_exp\":\"0\",\"message_created\":\"1442123979\",\"message_updated\":\"0\"}', '1442210837');
INSERT INTO `logs` VALUES ('3', '1', '4', '{\"message_id\":\"4\",\"user_id\":\"0\",\"message_text\":\"df\",\"message_time\":\"1442118040\",\"message_is_exp\":\"0\",\"message_created\":\"1442123979\",\"message_updated\":\"0\"}', '1442210855');

-- ----------------------------
-- Table structure for logtypes
-- ----------------------------
DROP TABLE IF EXISTS `logtypes`;
CREATE TABLE `logtypes` (
  `log_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_type_name` varchar(30) DEFAULT NULL,
  `log_type_created` int(11) DEFAULT '0',
  `log_type_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`log_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of logtypes
-- ----------------------------
INSERT INTO `logtypes` VALUES ('1', '修改用户', '0', '0');
INSERT INTO `logtypes` VALUES ('2', '修改密码', '0', '0');
INSERT INTO `logtypes` VALUES ('3', '删除用户', '0', '0');
INSERT INTO `logtypes` VALUES ('4', '删除信息', '0', '0');

-- ----------------------------
-- Table structure for messages
-- ----------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_text` text,
  `message_time` int(11) DEFAULT '0',
  `message_is_exp` tinyint(4) DEFAULT '0' COMMENT '1体验，0会员',
  `message_created` int(11) DEFAULT '0',
  `message_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of messages
-- ----------------------------
INSERT INTO `messages` VALUES ('1', '0', 'www.51aspx.com/CodeList', '1442118040', '0', '1442123979', '0');
INSERT INTO `messages` VALUES ('2', '0', 'awef顶替李斐莉雪顶替', '1442118040', '0', '1442123979', '0');
INSERT INTO `messages` VALUES ('3', '0', 'as伊东遥模压 \r\nasdf asdf as   模压 顶替顶替模压 枯\r\n傅顶替\r\n\r\n模压 末梦工厂顶替顶替\r\n使用者顶替模压 \r\n顶替模压 李斐莉雪顶替', '1442118040', '0', '1442123979', '0');
INSERT INTO `messages` VALUES ('34', '1', ' ', '1442456159', '0', '1442456159', '1442456159');
INSERT INTO `messages` VALUES ('43', '1', 'sdfasdfasfd\n\n[IMG]http://api.zhongyi8888.com/upload/snap/20150917/121604453_9505.jpg[/IMG]sdfasdfasdf\n\n\nsdfsadf', '1442463365', '0', '1442463365', '1442463365');
INSERT INTO `messages` VALUES ('35', '1', 'saf \n\nfdgsdf\na ', '1442456344', '0', '1442456344', '1442456344');
INSERT INTO `messages` VALUES ('44', '1', 'afsdfasdf\nasdf\nasdf\n<img src=\'http://api.zhongyi8888.com/upload/snap/20150917/190248953_1908.jpg\' />\nfasdfasdf\nasdf\nasd\n<img src=\'http://api.zhongyi8888.com/upload/snap/20150917/190249953_6562.jpg\' />asdf\nasdf\nfasdfasdfasdf\nas\n<img src=\'http://api.zhongyi8888.com/upload/snap/20150917/190250968_6015.jpg\' />f\nasdf', '1442487771', '0', '1442487771', '1442487771');
INSERT INTO `messages` VALUES ('36', '1', ' ', '1442456405', '0', '1442456405', '1442456405');
INSERT INTO `messages` VALUES ('37', '1', ' ', '1442456878', '0', '1442456878', '1442456878');
INSERT INTO `messages` VALUES ('33', '1', 'fasdfsdfasdfasdfasdfsfd', '1442285705', '0', '1442285705', '1442285705');
INSERT INTO `messages` VALUES ('42', '1', 'sadfasdf\nasdf\nasdfsdfasdfasdf', '1442463267', '0', '1442463267', '1442463267');
INSERT INTO `messages` VALUES ('38', '1', 'asdfadf ', '1442458846', '0', '1442458846', '1442458846');
INSERT INTO `messages` VALUES ('39', '1', ' ', '1442459993', '0', '1442459993', '1442459993');
INSERT INTO `messages` VALUES ('40', '1', ' ', '1442460380', '0', '1442460380', '1442460380');
INSERT INTO `messages` VALUES ('41', '1', ' ', '1442460625', '0', '1442460625', '1442460625');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(30) DEFAULT NULL,
  `role_created` int(11) DEFAULT '0',
  `role_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '管理员', '0', '0');
INSERT INTO `roles` VALUES ('2', '信息管理员', '0', '0');
INSERT INTO `roles` VALUES ('3', '会员管理员', '0', '0');
INSERT INTO `roles` VALUES ('4', '会员', '0', '0');
INSERT INTO `roles` VALUES ('5', '体验会员', '0', '0');

-- ----------------------------
-- Table structure for sessions
-- ----------------------------
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT '0',
  `session_expire` int(11) DEFAULT '0',
  `session_token` varchar(50) DEFAULT NULL,
  `session_ip` varchar(30) DEFAULT NULL,
  `session_area` varchar(255) DEFAULT NULL,
  `session_visit_time` int(11) DEFAULT '0',
  `session_last_time` int(11) DEFAULT '0',
  `session_created` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `session_token` (`session_token`),
  KEY `session_expire` (`session_expire`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of sessions
-- ----------------------------
INSERT INTO `sessions` VALUES ('1', '1453274439', 'nogosf80rdor2a5qqobs8vj803', '127.0.0.1', 'IANA保留地址用于本地回送', '1444705483', '1444705339', '1442064439');
INSERT INTO `sessions` VALUES ('10', '1442137955', '48c90fs5pjn0e2cd0a4b9ba2e1', '127.0.0.1', 'IANA保留地址用于本地回送', '1442138553', '1442138531', '1442138011');
INSERT INTO `sessions` VALUES ('2', '1452496959', 'rhfrmsjsj28nft2ejrcu8cqu30', '127.0.0.1', 'IANA保留地址用于本地回送', '1445087354', '1444705643', '1442202541');

-- ----------------------------
-- Table structure for status
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status_code` varchar(50) DEFAULT NULL,
  `status_name` varchar(255) DEFAULT NULL,
  `status_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', '0', '操作成功', null);
INSERT INTO `status` VALUES ('2', '1000', '权限不足', null);
INSERT INTO `status` VALUES ('3', '1001', '操作失败', null);
INSERT INTO `status` VALUES ('4', '1002', '用户账号已存在', null);
INSERT INTO `status` VALUES ('5', '1003', '创建用户失败', null);
INSERT INTO `status` VALUES ('6', '1004', '登录过期', null);
INSERT INTO `status` VALUES ('7', '1005', '账号已过期', null);
INSERT INTO `status` VALUES ('8', '1006', '请填写完整资料', null);
INSERT INTO `status` VALUES ('9', '1007', '用户不存在', null);
INSERT INTO `status` VALUES ('10', '1008', '旧密码错误', null);
INSERT INTO `status` VALUES ('11', '1009', '账号或密码不正确', null);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT '0',
  `user_parent_id` int(11) DEFAULT '0',
  `user_code` varchar(20) DEFAULT NULL,
  `user_password` varchar(40) DEFAULT NULL,
  `user_name` varchar(30) DEFAULT NULL,
  `user_mobile` varchar(11) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_reg_time` int(11) DEFAULT '0',
  `user_reg_ip` varchar(30) DEFAULT NULL,
  `user_expire` int(11) DEFAULT '0' COMMENT '过期时间',
  `user_last_time` int(11) DEFAULT '0',
  `user_last_ip` varchar(30) DEFAULT NULL,
  `user_login_num` int(11) DEFAULT '0',
  `user_is_delete` tinyint(4) DEFAULT '0' COMMENT '1删除用户',
  `user_is_exp` tinyint(4) DEFAULT '0' COMMENT '1体验用户',
  `user_is_service` tinyint(4) DEFAULT '0' COMMENT '是否客服',
  `user_remark` varchar(255) DEFAULT NULL,
  `user_created` int(11) DEFAULT '0',
  `user_updated` int(11) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_code` (`user_code`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '1', '0', 'admin', '123123', '管理员', '', '', '0', null, '1453274439', '1444705483', '127.0.0.1', '162', '0', '0', '0', '', '1442118040', '1444705483');
INSERT INTO `users` VALUES ('2', '3', '0', 'fasdf', '123123', 'erhse', '', '', '1442064959', '127.0.0.1', '1453274439', '1445087353', '127.0.0.1', '12', '0', '0', '1', '', '1442064959', '1445087353');
INSERT INTO `users` VALUES ('3', '4', '0', 'adminrthdrth', '123123', 'serg', null, '', '1442068556', '127.0.0.1', '1453274439', '0', null, '0', '0', '0', '0', '', '1442068556', '1442068556');
INSERT INTO `users` VALUES ('5', '5', '0', 'sdfgsdf', '123123', 'sdfasdf', null, '', '1442131506', '127.0.0.1', '1453274439', '0', null, '0', '0', '1', '0', 'asdfsadf', '1442131506', '1442131506');
INSERT INTO `users` VALUES ('11', '5', '0', 'wfeasdf', '123123', 'sdfasdf', null, '', '1442138685', '127.0.0.1', '1453274439', '0', null, '0', '0', '1', '0', 'sadfasdf', '1442138685', '1442138685');
INSERT INTO `users` VALUES ('8', '3', '0', 'fffffffff', '123123', '水电费水电费', '', '', '1442135890', '127.0.0.1', '1453274439', '0', null, '0', '0', '1', '0', '', '1442135890', '1442148029');
INSERT INTO `users` VALUES ('9', '2', '0', 'egsfgsd', '123123', 'sdfasdf', null, '', '1442136107', '127.0.0.1', '1453274439', '0', null, '0', '0', '1', '0', 'awefsadfsdf', '1442136107', '1442136107');
INSERT INTO `users` VALUES ('10', '3', '0', 'sfgsdfasdf', '123123', '123123esrg', null, '', '1442137955', '127.0.0.1', '1453274439', '1442138553', '127.0.0.1', '3', '0', '0', '0', 'sdafasdfasdf', '1442137955', '1442138553');
INSERT INTO `users` VALUES ('12', '3', '0', 'fsdfsdf', 'asdf', 'serg', null, '', '1442196794', '127.0.0.1', '1453274439', '0', null, '0', '0', '0', '0', '', '1442196794', '1442196794');

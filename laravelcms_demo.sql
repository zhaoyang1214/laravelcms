/*
Navicat MySQL Data Transfer

Source Server         : develop
Source Server Version : 50723
Source Host           : 192.168.159.128:3306
Source Database       : laravelcms

Target Server Type    : MYSQL
Target Server Version : 50723
File Encoding         : 65001

Date: 2019-10-27 21:24:03
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lv_admin
-- ----------------------------
DROP TABLE IF EXISTS `lv_admin`;
CREATE TABLE `lv_admin` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '密码',
  `nickname` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `regtime` datetime NOT NULL COMMENT '注册时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1：正常，0：禁用',
  `admin_group_id` smallint(5) unsigned NOT NULL COMMENT 'admin_group表 id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `admin_group_id` (`admin_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_admin
-- ----------------------------
INSERT INTO `lv_admin` VALUES ('1', 'admin', 'd16837c9c0a9349fa54b87b80f001c0a', '超级管理员', '2019-03-10 22:20:48', '1', '1', '2019-03-10 22:20:48', null);
INSERT INTO `lv_admin` VALUES ('2', 'laravel', 'd16837c9c0a9349fa54b87b80f001c0a', '管理员', '2019-03-10 22:20:48', '1', '2', '2019-03-10 22:20:48', null);

-- ----------------------------
-- Table structure for lv_admin_auth
-- ----------------------------
DROP TABLE IF EXISTS `lv_admin_auth`;
CREATE TABLE `lv_admin_auth` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '权限名称',
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '父id',
  `controller` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '控制器',
  `action` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作方法',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，越小越排在前面',
  `note` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：0：隐藏，1：显示',
  PRIMARY KEY (`id`),
  KEY `pid_status` (`pid`,`status`),
  KEY `controller_action_status` (`controller`,`action`,`status`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=10008 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_admin_auth
-- ----------------------------
INSERT INTO `lv_admin_auth` VALUES ('1', '首页管理', '0', '', '', '5', '首页管理', 'layui-icon-home', '1');
INSERT INTO `lv_admin_auth` VALUES ('2', '栏目管理', '0', 'category', 'index', '10', '栏目管理', 'layui-icon-component', '1');
INSERT INTO `lv_admin_auth` VALUES ('3', '内容管理', '0', 'content', 'manage', '15', '内容管理', 'layui-icon-read', '1');
INSERT INTO `lv_admin_auth` VALUES ('4', '扩展管理', '0', '', '', '20', '扩展管理', 'layui-icon-senior', '1');
INSERT INTO `lv_admin_auth` VALUES ('5', '表单管理', '0', 'form', 'index', '25', '表单管理', 'layui-icon-form', '1');
INSERT INTO `lv_admin_auth` VALUES ('6', '安全管理', '0', '', '', '30', '安全管理', 'layui-icon-auz', '1');
INSERT INTO `lv_admin_auth` VALUES ('100', '系统设置', '1', 'systemset', 'index', '100', '系统设置', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('101', '栏目模型', '1', 'categorymodel', 'index', '105', '栏目模型管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('102', '扩展模型', '4', 'expand', 'index', '110', '扩展模型管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('103', '自定义变量', '4', 'fragment', 'index', '115', '自定义变量管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('104', '内容替换', '4', 'replace', 'index', '120', '内容替换', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('105', 'TAG管理', '4', 'tags', 'index', '125', 'TAG管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('106', '推荐位管理', '4', 'position', 'index', '130', '推荐位管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('107', '附件管理', '4', 'upload', 'index', '135', '附件管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('108', '管理组管理', '6', 'admingroup', 'index', '140', '管理组管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('109', '管理员管理', '6', 'admin', 'index', '145', '管理员管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('110', '后台登录记录', '6', 'adminlog', 'index', '150', '后台登录记录', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('111', '添加表单', '5', 'form', 'add', '155', '表单添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('112', '查看', '5', 'form', 'info', '160', '查看表单', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('113', '修改', '5', 'form', 'edit', '165', '修改表单', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('114', '删除', '5', 'form', 'delete', '170', '删除表单', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('115', '字段管理', '5', 'formfield', 'index', '175', '表单字段管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('116', '数据管理', '5', 'formdata', 'index', '180', '表单数据管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('117', '栏目排序', '2', 'category', 'sequence', '185', '栏目排序', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('118', '添加新闻栏目', '2', 'categorynews', 'add', '190', '新闻栏目添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('119', '查看', '2', 'categorynews', 'info', '195', '查看新闻栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('120', '修改', '2', 'categorynews', 'edit', '200', '修改新闻栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('121', '删除', '2', 'categorynews', 'delete', '205', '删除新闻栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('122', '添加页面栏目', '2', 'categorypage', 'add', '210', '页面栏目添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('123', '查看', '2', 'categorypage', 'info', '215', '查看页面栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('124', '修改', '2', 'categorypage', 'edit', '220', '修改页面栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('125', '删除', '2', 'categorypage', 'delete', '225', '删除页面栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('126', '添加跳转栏目', '2', 'categoryjump', 'add', '230', '跳转栏目添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('127', '查看', '2', 'categoryjump', 'info', '235', '查看跳转栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('128', '修改', '2', 'categoryjump', 'edit', '240', '修改跳转栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('129', '删除', '2', 'categoryjump', 'delete', '245', '删除跳转栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('130', '内容首页', '3', 'content', 'list', '250', '快速审核', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1000', '保存', '100', 'systemset', 'save', '1000', '系统设置保存', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1001', '查看', '101', 'categorymodel', 'info', '1005', '查看栏目模型详情', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1002', '修改', '101', 'categorymodel', 'edit', '1010', '栏目模型修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1003', '添加管理组', '108', 'admingroup', 'add', '1015', '管理组添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1004', '查看', '108', 'admingroup', 'info', '1020', '管理组查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1005', '修改', '108', 'admingroup', 'edit', '1025', '管理组修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1006', '删除', '108', 'admingroup', 'delete', '1030', '管理组删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1007', '添加管理员', '109', 'admin', 'add', '1035', '管理员添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1008', '查看', '109', 'admin', 'info', '1040', '管理员查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1009', '修改', '109', 'admin', 'edit', '1045', '管理员修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1010', '删除', '109', 'admin', 'delete', '1050', '管理员删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1011', '修改资料', '109', 'admin', 'editInfo', '1055', '管理员修改资料', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1012', '添加字段', '115', 'formfield', 'add', '1060', '表单字段添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1013', '查看', '115', 'formfield', 'info', '1065', '表单字段查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1014', '修改', '115', 'formfield', 'edit', '1070', '表单字段修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1015', '删除', '115', 'formfield', 'delete', '1075', '表单字段删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1016', '添加数据', '116', 'formdata', 'add', '1080', '表单数据添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1017', '查看', '116', 'formdata', 'info', '1085', '表单数据查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1018', '修改', '116', 'formdata', 'edit', '1090', '表单数据修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1019', '删除', '116', 'formdata', 'delete', '1095', '表单数据删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1020', '添加扩展模型', '102', 'expand', 'add', '1100', '扩展模型添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1021', '查看', '102', 'expand', 'info', '1105', '扩展模型查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1022', '修改', '102', 'expand', 'edit', '1110', '扩展模型修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1023', '删除', '102', 'expand', 'delete', '1115', '扩展模型删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1024', '字段管理', '102', 'expandfield', 'index', '1120', '扩展模型字段管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1025', '添加自定义变量', '103', 'fragment', 'add', '1125', '自定义变量添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1026', '查看', '103', 'fragment', 'info', '1130', '自定义变量查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1027', '修改', '103', 'fragment', 'edit', '1135', '自定义变量修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1028', '删除', '103', 'fragment', 'delete', '1140', '自定义变量删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1029', '添加内容替换', '104', 'replace', 'add', '1145', '内容替换添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1030', '查看', '104', 'replace', 'info', '1150', '内容替换查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1031', '修改', '104', 'replace', 'edit', '1155', '内容替换修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1032', '删除', '104', 'replace', 'delete', '1160', '内容替换删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1033', '添加tag标签', '105', 'tags', 'add', '1165', 'tag标签添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1034', '分组', '105', 'tags', 'grouping', '1170', 'tag标签分组', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1035', '删除', '105', 'tags', 'delete', '1175', 'tag标签删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1036', 'TAG分组管理', '105', 'tagsgroup', 'index', '1180', 'tag标签分组管理', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1037', '添加推荐位', '106', 'position', 'add', '1185', '推荐位添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1038', '查看', '106', 'position', 'info', '1190', '推荐位查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1039', '修改', '106', 'position', 'edit', '1195', '推荐位修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1040', '删除', '106', 'position', 'delete', '1200', '推荐位删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1041', '删除', '107', 'upload', 'delete', '1205', '附件删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1042', '内容管理', '130', 'content', 'index', '1210', '浏览某个栏目的内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1043', '审核', '130', 'content', 'audit', '1215', '审核内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1044', '添加内容', '130', 'content', 'add', '1220', '添加内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1045', '查看内容', '130', 'content', 'info', '1225', '查看内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1046', '修改内容', '130', 'content', 'edit', '1530', '修改内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1047', '删除内容', '130', 'content', 'delete', '1235', '删除内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1048', '快速编辑', '130', 'content', 'quickEdit', '1240', '快速编辑内容', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('1049', '移动', '130', 'content', 'move', '1245', '移动内容到某栏目', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10000', '添加字段', '1024', 'expandfield', 'add', '10000', '扩展模型字段添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10001', '查看', '1024', 'expandfield', 'info', '10005', '扩展模型字段查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10002', '修改', '1024', 'expandfield', 'edit', '10010', '扩展模型字段修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10003', '删除', '1024', 'expandfield', 'delete', '10015', '扩展模型字段删除', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10004', '添加TAG分组', '1036', 'tagsgroup', 'add', '10020', 'TAG分组添加', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10005', '查看', '1036', 'tagsgroup', 'info', '10025', 'TAG分组查看', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10006', '修改', '1036', 'tagsgroup', 'edit', '10030', 'TAG分组修改', '', '1');
INSERT INTO `lv_admin_auth` VALUES ('10007', '删除', '1036', 'tagsgroup', 'delete', '10035', 'TAG分组删除', '', '1');

-- ----------------------------
-- Table structure for lv_admin_group
-- ----------------------------
DROP TABLE IF EXISTS `lv_admin_group`;
CREATE TABLE `lv_admin_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级 id',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '角色名称',
  `admin_auth_ids` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '操作权限ids,1,2,5',
  `category_ids` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目权限',
  `form_ids` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '表单权限',
  `grade` tinyint(4) NOT NULL DEFAULT '99' COMMENT '等级，数字越小等级越高',
  `keep` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否校验权限（允许组合），0：全部校验，1：不校验表单权限，2：不校验栏目权限，4：不校验功能权限，7：全部不校验',
  `admin_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'admin表 id，创建者id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_admin_group
-- ----------------------------
INSERT INTO `lv_admin_group` VALUES ('1', '0', '超级管理组', '', '', '', '1', '7', '0', '2019-03-10 22:20:48', null);
INSERT INTO `lv_admin_group` VALUES ('2', '1', '管理员组', '1,100,1000,101,1001,1002,2,3,4,102,1020,1021,1022,1023,1024,10000,10001,10002,10003,103,1025,1026,1027,1028,104,1029,1030,1031,1032,105,1033,1034,1035,1036,10004,10005,10006,10007,106,107,5,111,112,113,114,115,1012,1013,1014,1015,116,1016,1017,1018,1019,6,108,1003,1004,1005,1006,109,1007,1008,1009,1010,1011,110', '', '', '10', '3', '0', '2019-03-10 22:20:48', '2019-03-31 00:37:57');

-- ----------------------------
-- Table structure for lv_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `lv_admin_log`;
CREATE TABLE `lv_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` mediumint(8) unsigned NOT NULL COMMENT '表admin id',
  `logintime` datetime NOT NULL COMMENT '登录时间',
  `ip` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_admin_log
-- ----------------------------
INSERT INTO `lv_admin_log` VALUES ('1', '1', '2019-03-10 22:23:32', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('2', '1', '2019-03-11 21:14:45', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('3', '1', '2019-03-14 17:42:36', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('4', '1', '2019-03-14 23:21:50', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('5', '1', '2019-03-16 18:35:32', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('6', '1', '2019-03-16 22:37:55', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('7', '1', '2019-03-17 14:51:28', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('8', '1', '2019-03-18 22:34:52', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('9', '1', '2019-03-19 22:00:34', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('10', '1', '2019-03-22 21:47:26', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('11', '1', '2019-03-23 21:55:28', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('12', '1', '2019-03-24 22:34:20', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('13', '1', '2019-03-25 22:20:16', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('14', '1', '2019-03-26 23:26:01', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('15', '1', '2019-03-29 22:25:22', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('16', '1', '2019-03-31 00:19:31', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('17', '2', '2019-03-31 00:38:12', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('18', '1', '2019-03-31 00:39:01', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('19', '1', '2019-04-04 21:05:01', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('20', '1', '2019-04-05 17:38:58', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('21', '1', '2019-04-05 20:47:33', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('22', '1', '2019-04-06 19:48:19', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('23', '1', '2019-04-06 23:15:30', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('24', '1', '2019-04-07 14:54:54', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('25', '1', '2019-04-07 18:42:33', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('26', '1', '2019-04-22 21:19:16', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('27', '1', '2019-04-23 20:53:22', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('28', '1', '2019-04-25 20:55:03', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('29', '1', '2019-04-27 15:11:01', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('30', '1', '2019-04-27 20:31:22', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('31', '1', '2019-04-28 21:39:13', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('32', '1', '2019-05-05 21:19:18', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('33', '1', '2019-05-11 15:18:39', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('34', '1', '2019-05-12 13:34:22', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('35', '1', '2019-05-12 15:13:34', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('36', '1', '2019-05-15 20:52:57', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('37', '1', '2019-05-18 18:07:24', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('38', '1', '2019-05-18 22:22:23', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('39', '1', '2019-05-19 17:57:08', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('40', '1', '2019-05-19 21:00:49', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('41', '1', '2019-05-21 20:15:14', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('42', '1', '2019-05-25 16:36:37', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('43', '1', '2019-05-25 20:31:05', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('44', '1', '2019-05-26 14:10:18', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('45', '1', '2019-05-29 21:21:36', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('46', '1', '2019-06-05 17:01:57', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('47', '1', '2019-06-07 16:03:25', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('48', '1', '2019-06-14 21:14:29', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('49', '1', '2019-06-15 21:54:10', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('50', '1', '2019-06-16 16:14:07', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('51', '1', '2019-06-16 19:11:37', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('52', '1', '2019-06-17 21:39:30', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('53', '1', '2019-06-19 20:36:48', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('54', '1', '2019-06-23 19:41:39', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('55', '1', '2019-06-29 13:34:00', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('56', '1', '2019-07-12 21:42:56', '127.0.0.1');
INSERT INTO `lv_admin_log` VALUES ('57', '1', '2019-07-21 17:25:55', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('58', '1', '2019-07-24 21:34:29', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('59', '1', '2019-07-24 22:30:08', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('60', '1', '2019-07-25 21:53:24', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('61', '1', '2019-07-26 21:59:57', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('62', '1', '2019-07-27 15:00:41', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('63', '1', '2019-07-28 13:37:12', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('64', '1', '2019-07-28 17:16:23', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('65', '1', '2019-07-29 21:44:17', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('66', '1', '2019-07-30 21:08:53', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('67', '1', '2019-07-31 21:10:57', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('68', '1', '2019-08-01 21:40:44', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('69', '1', '2019-08-03 15:21:37', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('70', '1', '2019-08-03 15:21:39', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('71', '1', '2019-08-04 15:27:55', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('72', '1', '2019-08-04 21:45:14', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('73', '1', '2019-08-05 21:17:40', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('74', '1', '2019-08-06 22:15:20', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('75', '1', '2019-08-07 22:16:37', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('76', '1', '2019-08-07 22:25:29', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('77', '1', '2019-08-08 21:50:19', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('78', '1', '2019-08-14 21:50:10', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('79', '1', '2019-08-18 16:46:30', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('80', '1', '2019-08-19 21:08:56', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('81', '1', '2019-08-20 22:52:02', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('82', '1', '2019-08-21 22:48:11', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('83', '1', '2019-08-22 21:38:09', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('84', '1', '2019-09-08 21:39:59', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('85', '1', '2019-09-14 14:26:49', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('86', '1', '2019-09-14 17:22:04', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('87', '1', '2019-09-15 17:40:20', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('88', '1', '2019-09-19 22:04:31', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('89', '1', '2019-09-22 15:17:49', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('90', '1', '2019-09-22 21:15:57', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('91', '1', '2019-09-23 20:47:14', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('92', '1', '2019-09-24 20:10:46', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('93', '1', '2019-09-25 20:16:29', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('94', '1', '2019-09-28 13:04:09', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('95', '1', '2019-09-28 19:59:39', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('96', '1', '2019-09-29 20:51:18', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('97', '1', '2019-10-01 17:58:50', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('98', '1', '2019-10-02 20:07:09', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('99', '1', '2019-10-04 19:13:55', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('100', '1', '2019-10-04 22:51:12', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('101', '1', '2019-10-05 14:16:15', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('102', '1', '2019-10-05 20:04:37', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('103', '1', '2019-10-05 22:13:26', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('104', '1', '2019-10-06 21:16:02', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('105', '1', '2019-10-07 20:27:49', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('106', '1', '2019-10-09 22:44:51', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('107', '1', '2019-10-10 20:15:24', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('108', '1', '2019-10-11 21:44:50', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('109', '1', '2019-10-16 21:46:27', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('110', '1', '2019-10-17 19:39:29', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('111', '1', '2019-10-18 21:45:02', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('112', '1', '2019-10-19 21:09:01', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('113', '1', '2019-10-20 12:34:21', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('114', '1', '2019-10-20 20:59:12', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('115', '1', '2019-10-21 22:17:48', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('116', '1', '2019-10-22 22:07:48', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('117', '1', '2019-10-23 21:59:45', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('118', '1', '2019-10-24 20:42:15', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('119', '1', '2019-10-26 13:54:23', '192.168.159.1');
INSERT INTO `lv_admin_log` VALUES ('120', '1', '2019-10-27 13:49:27', '192.168.159.1');

-- ----------------------------
-- Table structure for lv_category
-- ----------------------------
DROP TABLE IF EXISTS `lv_category`;
CREATE TABLE `lv_category` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pid` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '上级栏目id',
  `category_model_id` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'category_model表id',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，升序',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否显示，1：显示，0：隐藏',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '栏目类型，1：频道页，2：列表页',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '栏目名称',
  `urlname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '栏目url优化',
  `subname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '副栏目名称',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目形象图',
  `category_tpl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目模板',
  `content_tpl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '内容模板',
  `page` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '内容分页数',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词，","分割',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `seo_content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SEO内容',
  `content_order` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '内容排序，1:更新时间 新旧("updatetime DESC")；2:更新时间 旧新("updatetime ASC")；3：发布时间 新旧("inputtime DESC")；4:发布时间 旧新("inputtime ASC")；5：自定义顺序 大小("sequence DESC")；6：自定义顺序 小大("sequence ASC")',
  `expand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '扩展表id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `urlname` (`urlname`),
  KEY `pid` (`pid`),
  KEY `category_model_id` (`category_model_id`),
  KEY `name` (`name`),
  KEY `sequence` (`sequence`),
  KEY `expand_id` (`expand_id`),
  KEY `urlname_is_show` (`urlname`,`is_show`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_category
-- ----------------------------
INSERT INTO `lv_category` VALUES ('1', '0', '3', '1', '1', '1', '关于我们', 'guanyuwomen', 'CONTACT US', '', '', '', '10', '', '', '', '1', '0', '2019-10-17 20:53:26', '2019-10-17 20:53:26');
INSERT INTO `lv_category` VALUES ('2', '0', '3', '2', '1', '1', '剧院动态', 'juyuandongtai', 'THEATRE NEWS', '', '', '', '10', '', '', '', '1', '0', '2019-10-17 20:54:26', '2019-10-17 20:54:26');
INSERT INTO `lv_category` VALUES ('3', '0', '3', '3', '1', '1', '网上购票', 'wangshanggoupiao', 'TICKETS', '', '', '', '10', '', '', '', '1', '0', '2019-10-17 20:55:06', '2019-10-17 20:55:06');
INSERT INTO `lv_category` VALUES ('5', '0', '3', '5', '1', '1', '商务合作', 'shangwuhezuo', 'COOPERATION', '', '', '', '10', '', '', '', '1', '0', '2019-10-17 20:56:31', '2019-10-17 20:56:31');
INSERT INTO `lv_category` VALUES ('6', '0', '3', '6', '1', '1', '招聘信息', 'zhaopinxinxi', 'RECRUITMENT', '', '', '', '10', '', '', '', '1', '0', '2019-10-17 20:57:07', '2019-10-17 20:57:07');
INSERT INTO `lv_category` VALUES ('7', '1', '1', '0', '1', '2', '剧院概况', 'juyuangaikuang', '', '', 'category.jygk', '', '10', '', '', '', '4', '0', '2019-10-17 20:58:00', '2019-10-17 21:27:50');
INSERT INTO `lv_category` VALUES ('8', '1', '1', '0', '1', '2', '配套设施', 'peitaosheshi', '', '', 'category.ptss', 'content.ptss', '8', '', '', '', '1', '0', '2019-10-20 12:58:35', '2019-10-20 16:50:16');
INSERT INTO `lv_category` VALUES ('9', '1', '2', '0', '1', '1', '管理机构', 'guanlijigou', '', '', 'category.gljg', '', '10', '', '', '', '1', '0', '2019-10-20 17:00:13', '2019-10-20 17:02:44');
INSERT INTO `lv_category` VALUES ('10', '2', '1', '0', '1', '2', '媒体报道', 'meitibaodao', '', '', 'category.news', 'content.news', '10', '', '', '', '1', '0', '2019-10-20 20:59:59', '2019-10-27 16:19:55');
INSERT INTO `lv_category` VALUES ('11', '2', '1', '0', '1', '2', '剧院新闻', 'juyuanxinwen', '', '', 'category.news', 'content.news', '10', '', '', '', '1', '0', '2019-10-20 21:01:20', '2019-10-20 21:01:20');
INSERT INTO `lv_category` VALUES ('12', '3', '1', '0', '1', '2', '网上购票', 'wsgp', '', '', 'category.wsgp', 'content.jmxq', '9', '', '', '', '1', '2', '2019-10-26 14:07:38', '2019-10-26 17:59:28');
INSERT INTO `lv_category` VALUES ('13', '0', '3', '4', '1', '1', '演出信息', 'ycxx', 'PERFORMANCE', '', '', '', '10', '', '', '', '1', '0', '2019-10-26 22:12:12', '2019-10-27 15:50:41');
INSERT INTO `lv_category` VALUES ('14', '13', '1', '1', '1', '2', '合肥剧院', 'hefeijuyuan', '', '', 'category.ycxx', 'content.jmxq', '9', '', '', '', '1', '2', '2019-10-26 22:15:06', '2019-10-26 23:13:38');
INSERT INTO `lv_category` VALUES ('15', '13', '1', '2', '1', '2', '淮南剧院', 'huainanjuyuan', '', '', 'category.ycxx', 'content.jmxq', '9', '', '', '', '1', '2', '2019-10-26 22:16:07', '2019-10-26 23:11:09');
INSERT INTO `lv_category` VALUES ('16', '13', '1', '3', '1', '2', '蚌埠剧院', 'bengbujuyuan', '', '', 'category.ycxx', 'content.jmxq', '9', '', '', '', '1', '2', '2019-10-26 22:16:45', '2019-10-26 23:11:17');
INSERT INTO `lv_category` VALUES ('17', '5', '1', '0', '1', '2', '商务合作', 'swhz', '', '', 'category.swhz', '', '3', '', '', '', '4', '3', '2019-10-27 16:55:28', '2019-10-27 17:57:22');
INSERT INTO `lv_category` VALUES ('18', '6', '1', '0', '1', '2', '招聘信息', 'zpxx', '', '', 'category.zpxx', '', '100', '', '', '', '3', '4', '2019-10-27 20:19:13', '2019-10-27 20:21:06');

-- ----------------------------
-- Table structure for lv_category_jump
-- ----------------------------
DROP TABLE IF EXISTS `lv_category_jump`;
CREATE TABLE `lv_category_jump` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(5) unsigned NOT NULL COMMENT 'category表id',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_category_jump
-- ----------------------------
INSERT INTO `lv_category_jump` VALUES ('1', '1', '/category/juyuangaikuang');
INSERT INTO `lv_category_jump` VALUES ('2', '2', '/category/meitibaodao');
INSERT INTO `lv_category_jump` VALUES ('3', '3', '/category/wsgp');
INSERT INTO `lv_category_jump` VALUES ('5', '5', '/category/swhz');
INSERT INTO `lv_category_jump` VALUES ('6', '6', '/category/zpxx');
INSERT INTO `lv_category_jump` VALUES ('7', '13', '/category/hefeijuyuan');

-- ----------------------------
-- Table structure for lv_category_model
-- ----------------------------
DROP TABLE IF EXISTS `lv_category_model`;
CREATE TABLE `lv_category_model` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型名称',
  `category` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '栏目控制器名',
  `content` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '栏目控制器名',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0：禁用，1：开启',
  `befrom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_category_model
-- ----------------------------
INSERT INTO `lv_category_model` VALUES ('1', '新闻', 'categorynews', 'content', '1', 'laravel', '2019-03-10 22:20:48', '2019-06-17 22:32:35');
INSERT INTO `lv_category_model` VALUES ('2', '页面', 'categorypage', '', '1', '', '2019-03-10 22:20:48', null);
INSERT INTO `lv_category_model` VALUES ('3', '跳转', 'categoryjump', '', '1', '', '2019-03-10 22:20:48', null);

-- ----------------------------
-- Table structure for lv_category_page
-- ----------------------------
DROP TABLE IF EXISTS `lv_category_page`;
CREATE TABLE `lv_category_page` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(5) unsigned NOT NULL COMMENT 'category表id',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_category_page
-- ----------------------------
INSERT INTO `lv_category_page` VALUES ('1', '9', '&lt;ul class=&quot; list-paddingleft-2&quot; style=&quot;list-style-type: disc;&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;a href=&quot;http://www.SuperSlide2.com&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;/uploads/images/2019-10/20/5075786933493698263a6657d032781e.jpg&quot; title=&quot;5075786933493698263a6657d032781e&quot; alt=&quot;i1.jpg&quot;/&gt;&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a href=&quot;http://www.SuperSlide2.com&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;/uploads/images/2019-10/20/30d3de1270ed1ee416f3c287de55ae0c.jpg&quot; title=&quot;30d3de1270ed1ee416f3c287de55ae0c&quot; alt=&quot;i2.jpg&quot;/&gt;&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;a href=&quot;http://www.SuperSlide2.com&quot; target=&quot;_blank&quot;&gt;&lt;img src=&quot;/uploads/images/2019-10/20/225c068b2c0478c3e4ce78caa4e62c90.jpg&quot; title=&quot;225c068b2c0478c3e4ce78caa4e62c90&quot; alt=&quot;i3.jpg&quot;/&gt;&lt;/a&gt;&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;');

-- ----------------------------
-- Table structure for lv_content
-- ----------------------------
DROP TABLE IF EXISTS `lv_content`;
CREATE TABLE `lv_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` smallint(5) unsigned NOT NULL COMMENT 'category表id',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `urltitle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'URL路径',
  `subtitle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '短标题',
  `font_color` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '颜色(16进制RGB值)',
  `font_bold` tinyint(4) NOT NULL DEFAULT '0' COMMENT '加粗，0：不加粗，1：加粗',
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '关键词',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '描述',
  `update_time` datetime NOT NULL COMMENT '更新时间',
  `input_time` datetime NOT NULL COMMENT '发布时间',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '封面图',
  `jump_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '跳转',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `tpl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '模板',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0：草稿，1：发布',
  `copyfrom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '来源',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览数',
  `position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0' COMMENT '推荐ids',
  `taglink` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否内容自动TAG',
  PRIMARY KEY (`id`),
  UNIQUE KEY `urltitle` (`urltitle`),
  KEY `category_id_status` (`category_id`,`status`),
  KEY `title` (`title`),
  KEY `urltitle_status` (`urltitle`,`status`),
  KEY `update_time` (`update_time`),
  KEY `input_time` (`input_time`),
  KEY `views` (`views`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_content
-- ----------------------------
INSERT INTO `lv_content` VALUES ('1', '7', '合肥剧院', 'hefeijuyuan', '', '', '0', '', '', '2019-10-17 22:04:01', '2019-10-17 21:34:08', '/uploads/scrawls/2019-10/17/5898c4cb271083dc64f43316cda0eebc.png', '', '0', '', '1', '', '0', '', '0');
INSERT INTO `lv_content` VALUES ('2', '7', '淮南大剧院', 'huainandajuyuan', '', '', '0', '', '', '2019-10-17 22:04:24', '2019-10-17 21:35:24', '/uploads/scrawls/2019-10/17/a6384f57266c19a402fee011c3d5f81f.png', '', '0', '', '1', '', '0', '', '0');
INSERT INTO `lv_content` VALUES ('3', '7', '蚌埠剧院', 'bengbujuyuan', '', '', '0', '', '', '2019-10-17 22:04:39', '2019-10-17 21:36:39', '/uploads/scrawls/2019-10/17/e6f175774b59ce2f6be441eb10f3e05d.png', '', '0', '', '1', '', '0', '', '0');
INSERT INTO `lv_content` VALUES ('4', '8', '1', '1', '', '', '0', '', '', '2019-10-20 13:12:06', '2019-10-20 13:12:06', '/uploads/scrawls/2019-10/20/cd70e41803e72c256abe951feae43b8d.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('5', '8', '2', '2', '', '', '0', '', '', '2019-10-20 13:12:59', '2019-10-20 13:12:59', '/uploads/scrawls/2019-10/20/56480a617a4ad5c4a6d60aa0a0d41ee4.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('6', '8', '3', '3', '', '', '0', '', '', '2019-10-20 13:14:55', '2019-10-20 13:14:55', '/uploads/scrawls/2019-10/20/d1f31f24e5a8fbcff0e54b5fd321b052.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('7', '8', '4', '4', '', '', '0', '', '', '2019-10-20 13:15:15', '2019-10-20 13:15:15', '/uploads/scrawls/2019-10/20/1cc51d71d2e7727e8f6d2eeaebe785b0.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('8', '8', '5', '5', '', '', '0', '', '', '2019-10-20 15:33:14', '2019-10-20 15:33:14', '/uploads/scrawls/2019-10/20/ba7d6740e4dc37faa789a85c47c6fcf5.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('9', '8', '6', '6', '', '', '0', '', '', '2019-10-20 15:33:28', '2019-10-20 15:33:28', '/uploads/scrawls/2019-10/20/8d6ec9e79b8197eb8a89de29e57caaf0.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('10', '8', '7', '7', '', '', '0', '', '', '2019-10-20 15:33:41', '2019-10-20 15:33:41', '/uploads/scrawls/2019-10/20/a907786e4dd85ab016dd4f1573cf513b.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('11', '8', '8', '8', '', '', '0', '', '', '2019-10-20 15:33:56', '2019-10-20 15:33:56', '/uploads/scrawls/2019-10/20/e8022533c6f160be544afcc6632c5f43.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('12', '8', '9', '9', '', '', '0', '', '', '2019-10-20 15:34:35', '2019-10-20 15:34:35', '/uploads/scrawls/2019-10/20/390a5a43d548383295f84bd99fba624e.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('13', '8', '10', '10', '', '', '0', '', '', '2019-10-20 15:34:52', '2019-10-20 15:34:52', '/uploads/scrawls/2019-10/20/11d0618f92eb0ca63c7d2067d47b27ca.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('14', '8', '11', '11', '', '', '0', '', '', '2019-10-20 15:36:45', '2019-10-20 15:36:45', '/uploads/scrawls/2019-10/20/4578f41ddee2d51fc8b1df78593f909e.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('15', '8', '12', '12', '', '', '0', '', '', '2019-10-20 16:36:30', '2019-10-20 16:36:30', '/uploads/scrawls/2019-10/20/09d2336d5bf74eb8f8f90414d514da65.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('16', '10', '郑佩佩：每个人都在为自己的希望而活', 'zhengpeipeimeigerendouzaiweizijidexiwangerhuo', '', '', '0', '', '不管是在舞台上还是休息室，郑佩佩都不能让人把她跟70岁画等号。话剧舞台上，她是《在那遥远的星球，一粒沙》的女主角，顶一头时髦的红发，对着天文望远镜遥望星空；舞台下，人称“佩佩姐”的她穿着印有大花朵的棉布裙子，和蔼地笑着看你，像一朵美丽的花。上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。上周末（', '2019-10-20 21:18:35', '2019-10-20 21:17:53', '/uploads/scrawls/2019-10/20/87b5d6c434270468628113ede86df63c.png', '', '0', '', '1', '新华日报', '3', '', '0');
INSERT INTO `lv_content` VALUES ('17', '10', '每个人都在为自己的希望而活', 'meigerendouzaiweizijidexiwangerhuo', '', '', '0', '', '上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所', '2019-10-20 23:00:27', '2019-10-20 21:20:07', '/uploads/scrawls/2019-10/20/c0af49cec7fbf493589f813a105a76e1.png', '', '0', '', '1', '新华日报', '9', '', '0');
INSERT INTO `lv_content` VALUES ('18', '10', '为自己的希望而活', 'weizijidexiwangerhuo', '', '', '0', '', '不管是在舞台上还是休息室，郑佩佩都不能让人把她跟70岁画等号。话剧舞台上，她是《在那遥远的星球，一粒沙》的女主角，顶一头时髦的红发，对着天文望远镜遥望星空；舞台下，人称“佩佩姐”的她穿着印有大花朵的棉布裙子，和蔼地笑着看你，像一朵美丽的花。上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。不管是在', '2019-10-20 22:15:23', '2019-10-20 21:21:02', '/uploads/scrawls/2019-10/20/bfa64b1f909354adba99000da100df90.png', '', '0', '', '1', '人民日报', '48', '', '0');
INSERT INTO `lv_content` VALUES ('19', '11', '福布斯中国发布跨国经营商业领袖榜单 马化腾在列', 'fubusizhongguofabukuaguojingyingshangyelingxiubangdanmahuatengzailie', '', '', '0', '', '新京报记者现场了解到，榜单中包括马化腾、马云、丁磊、任正非、柳传志、梁建章、郭广昌、王传福、张近东、张瑞敏共计十位商业知名人士。而范鲁贤也逐一对每位入选者做出相应的入选解读。 记者了解到，2009年福布斯中国首次推出“年度商业人物”，任正非、柳传志等中国企业家当选，此后的2010年，腾讯创始人马化腾、阿里巴巴创始人马云和百度创始人李彦宏同时上榜。<p style=\"margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adju', '2019-10-20 22:56:11', '2019-10-20 21:32:09', '/uploads/scrawls/2019-10/20/f748ec11b15a4e8c7dd84727971a6a7d.png', '', '0', '', '1', '新京报', '5', '', '0');
INSERT INTO `lv_content` VALUES ('21', '12', '荒诞喜剧《劫出人生》', 'huangdanxijujiechurensheng', '', '', '0', '', '', '2019-10-26 17:01:02', '2019-10-26 17:01:02', '/uploads/scrawls/2019-10/26/af6f89afe94815d36dd2cb65b76dcfb5.png', '', '0', '', '1', '', '1', '1', '0');
INSERT INTO `lv_content` VALUES ('22', '12', '封神传奇 (2016)', 'fengshenchuanqi2016', '', '', '0', '', '', '2019-10-26 17:10:38', '2019-10-26 17:10:38', '/uploads/scrawls/2019-10/26/439590ee34c511a3e8694dea3ad1c1ef.png', '', '0', '', '1', '', '1', '0', '0');
INSERT INTO `lv_content` VALUES ('23', '12', '台湾果陀剧场话剧《五斗米靠腰》', 'taiwanguotuojuchanghuajuwudoumikaoyao', '', '', '0', '', '', '2019-10-26 17:13:30', '2019-10-26 17:13:30', '/uploads/scrawls/2019-10/26/b3c4d1dcb4d54ec597a063ce70975eeb.png', '', '0', '', '1', '', '8', '1', '0');
INSERT INTO `lv_content` VALUES ('24', '14', '盗墓笔记  (2016)', 'daomubiji2016', '', '', '0', '', '', '2019-10-26 22:46:40', '2019-10-26 22:46:40', '/uploads/scrawls/2019-10/26/816403d305278647b77a8b753543db77.png', '', '0', '', '1', '', '2', '0', '0');
INSERT INTO `lv_content` VALUES ('25', '14', '哆啦A梦：新·大雄的日本诞生  (2016)', 'duolaAmengxindaxiongderibendansheng2016', '', '', '0', '', '', '2019-10-26 22:48:35', '2019-10-26 22:48:35', '/uploads/scrawls/2019-10/26/4481d0ddaba82a2d67644780603cb859.png', '', '0', '', '1', '', '0', '1', '0');
INSERT INTO `lv_content` VALUES ('26', '14', '绝地逃亡  (2016)', 'jueditaowang2016', '', '', '0', '', '', '2019-10-26 22:52:22', '2019-10-26 22:52:22', '/uploads/scrawls/2019-10/26/09007ad6d74cc0eccf7c035215250215.png', '', '0', '', '1', '', '2', '1', '0');
INSERT INTO `lv_content` VALUES ('27', '14', '龙拳小子  (2016)', 'longquanxiaozi2016', '', '', '0', '', '', '2019-10-26 23:13:12', '2019-10-26 23:13:12', '/uploads/scrawls/2019-10/26/a09dde64e92adbe05c7adc7f0f25c41f.png', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('28', '15', '泰山归来：险战丛林 (2016)', 'httpwwwbaiducom', '', '', '0', '', '', '2019-10-27 14:22:14', '2019-10-26 23:15:21', '/uploads/scrawls/2019-10/26/bf180a4a699be3ac5951f28fa1a09db2.png', '', '0', '', '1', '', '2', '1', '0');
INSERT INTO `lv_content` VALUES ('29', '16', '神秘世界历险记3  (2016)', 'shenmishijielixianji32016', '', '', '0', '', '', '2019-10-26 23:19:07', '2019-10-26 23:19:07', '/uploads/scrawls/2019-10/26/d2dfaab42445d385b76940bba9916a37.png', '', '0', '', '1', '', '2', '1', '0');
INSERT INTO `lv_content` VALUES ('30', '17', '合肥剧院', 'swhz-hefeijuyuan', '', '', '0', '', '', '2019-10-27 17:07:45', '2019-10-27 17:07:45', '', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('31', '17', '淮南剧院', 'swhz-huainanjuyuan', '', '', '0', '', '', '2019-10-27 17:09:40', '2019-10-27 17:09:40', '', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('32', '17', '蚌埠剧院', 'swhz-bengbujuyuan', '', '', '0', '', '', '2019-10-27 17:11:20', '2019-10-27 17:11:20', '', '', '0', '', '1', '', '0', '0', '0');
INSERT INTO `lv_content` VALUES ('33', '18', '话剧演员', 'huajuyanyuan', 'STRAIGHT ACTOR', '', '0', '', '', '2019-10-27 20:56:48', '2019-10-27 20:44:02', '', '', '0', '', '1', '', '0', '', '0');
INSERT INTO `lv_content` VALUES ('34', '18', '话剧演员2', 'huajuyanyuan2', 'STRAIGHT ACTOR', '', '0', '', '', '2019-10-27 20:56:33', '2019-10-27 20:46:25', '', '', '0', '', '1', '', '0', '', '0');

-- ----------------------------
-- Table structure for lv_content_data
-- ----------------------------
DROP TABLE IF EXISTS `lv_content_data`;
CREATE TABLE `lv_content_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL COMMENT 'content表id',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_content_data
-- ----------------------------
INSERT INTO `lv_content_data` VALUES ('1', '1', '&lt;p&gt;江淮大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众，坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。 江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场 经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众， 坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用，其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首 位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续 发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('2', '2', '&lt;p&gt;淮南大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众，坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。 江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场 经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众， 坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用，其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首 位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续 发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('3', '3', '&lt;p&gt;蚌埠剧院&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('4', '4', '');
INSERT INTO `lv_content_data` VALUES ('5', '5', '');
INSERT INTO `lv_content_data` VALUES ('6', '6', '');
INSERT INTO `lv_content_data` VALUES ('7', '7', '');
INSERT INTO `lv_content_data` VALUES ('8', '8', '');
INSERT INTO `lv_content_data` VALUES ('9', '9', '');
INSERT INTO `lv_content_data` VALUES ('10', '10', '');
INSERT INTO `lv_content_data` VALUES ('11', '11', '');
INSERT INTO `lv_content_data` VALUES ('12', '12', '');
INSERT INTO `lv_content_data` VALUES ('13', '13', '');
INSERT INTO `lv_content_data` VALUES ('14', '14', '');
INSERT INTO `lv_content_data` VALUES ('15', '15', '');
INSERT INTO `lv_content_data` VALUES ('16', '16', '&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;不管是在舞台上还是休息室，郑佩佩都不能让人把她跟70岁画等号。话剧舞台上，她是《在那遥远的星球，一粒沙》的女主角，顶一头时髦的红发，对着天文望远镜遥望星空；舞台下，人称“佩佩姐”的她穿着印有大花朵的棉布裙子，和蔼地笑着看你，像一朵美丽的花。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('17', '17', '&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('18', '18', '&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;1不管是在舞台上还是休息室，郑佩佩都不能让人把她跟70岁画等号。话剧舞台上，她是《在那遥远的星球，一粒沙》的女主角，顶一头时髦的红发，对着天文望远镜遥望星空；舞台下，人称“佩佩姐”的她穿着印有大花朵的棉布裙子，和蔼地笑着看你，像一朵美丽的花。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;[page]&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;2不管是在舞台上还是休息室，郑佩佩都不能让人把她跟70岁画等号。话剧舞台上，她是《在那遥远的星球，一粒沙》的女主角，顶一头时髦的红发，对着天文望远镜遥望星空；舞台下，人称“佩佩姐”的她穿着印有大花朵的棉布裙子，和蔼地笑着看你，像一朵美丽的花。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;&lt;span style=&quot;color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; text-align: justify; background-color: rgb(255, 255, 255);&quot;&gt;[page]&lt;/span&gt;&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 10px 0px; text-align: justify; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;3上周末（5月6日、7日）的成都，锦城艺术宫观众爆满，因为郑佩佩的表演，因为赖声川的作品，观看《在那遥远的星球，一粒沙》（以下简称《一粒沙》）成了雨天夜晚一件浪漫的事。两个半小时的演出，演员一气呵成，没有中场休息。观众送上掌声、笑声，在笑与泪中若有所思。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('19', '19', '&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;新京报记者现场了解到，榜单中包括马化腾、马云、丁磊、任正非、柳传志、梁建章、郭广昌、王传福、张近东、张瑞敏共计十位商业知名人士。而范鲁贤也逐一对每位入选者做出相应的入选解读。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;　　记者了解到，2009年福布斯中国首次推出“年度商业人物”，任正非、柳传志等中国企业家当选，此后的2010年，腾讯创始人马化腾、阿里巴巴创始人马云和百度创始人李彦宏同时上榜。&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;　　范鲁贤在会议现场介绍马云时说，“提到海外不得不提到阿里巴巴的马云，这个是当过我们福布斯的年度任务，是当过我们福布斯的封面人物好几次。”&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;　　而对于马化腾，范鲁贤则表示，“马化腾是国内业务为主，但是马化腾也是非常成功的投资海外的企业家，要谈到跨国成功的中国企业，是不可能不提，也不可能不肯定腾讯的经验。”&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;　　对于丁磊率领网易把海外收入从10亿人民币慢慢达到20亿方向的努力，以及网易如今布局东南亚、加拿大以及日本市场时，范鲁贤称“丁磊是非常有远见的，是非常值得学习的一个企业家。”&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 30px; padding: 0px; text-size-adjust: 100%; font-size: 18px; color: rgb(77, 79, 83); font-family: &amp;quot;Microsoft Yahei&amp;quot;, 微软雅黑, &amp;quot;STHeiti Light&amp;quot;, 华文细黑, SimSun, 宋体, Arial, sans-serif; letter-spacing: 1px; white-space: normal;&quot;&gt;　　福布斯工作人员告诉记者，“福布斯中国年度商业人物所选人物不仅具备当年的重要性、新闻性，而且所作所为还能在某一方面对中国商业生态的进化产生重大影响，或者对未来扮演风向标的角色。”&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('21', '21', '&lt;p&gt;荒诞喜剧《劫出人生》荒诞喜剧《劫出人生》荒诞喜剧《劫出人生》&lt;/p&gt;&lt;p&gt;&lt;img src=&quot;/uploads/images/2019-10/26/9187867e2a7319142b1d2ebf05e5ed46.jpg&quot; title=&quot;9187867e2a7319142b1d2ebf05e5ed46&quot; alt=&quot;pic5.jpg&quot;/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('22', '22', '&lt;p&gt;三千年前，商末，昏君纣王（梁家辉 饰）受妖妃妲己（范冰冰 饰）蛊惑，联手申公豹（古天乐 饰），试图召唤黑暗力量降生灭世黑龙，一时间妖孽横行，民不聊生……为阻止昏君灭世，姜子牙（李连杰 饰）命雷震子（向佐 饰）、哪吒（文章 饰）与杨戬（黄晓明 饰）联手寻找光明之剑斩妖除魔，并协助武王引领西岐大军攻打朝歌。不料妲己施法令姜子牙中了逆生咒，朝歌大战迫在眉睫，黑龙降世已成定局，天下再度陷入危 机……&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('23', '23', '&lt;p&gt;&lt;img src=&quot;/uploads/images/2019-10/26/fd1773ab8c6ae986be0921ee0eb5d8bb.jpg&quot; title=&quot;fd1773ab8c6ae986be0921ee0eb5d8bb&quot; alt=&quot;pic10.jpg&quot;/&gt;&lt;/p&gt;&lt;p&gt;1. 融合热门时事，加深观众参与感&lt;/p&gt;&lt;p&gt;全剧延伸部落客马克创作之讽刺幽默的作品风格，并于剧中融入大量时事元素，将其予以拆解重组，呈现台湾社会现况，激起民众更多参与感，将各种议题藉由半嘲讽的戏剧表达方式，唤起民众关注。&lt;/p&gt;&lt;p&gt;2. 穿插模仿、歌舞、电玩等元素，丰富舞台之呈现&lt;/p&gt;&lt;p&gt;除喜剧包袱的巧妙铺排外，亦加入热门人物模仿、印度宝莱坞式歌舞以及漫画电玩的特殊画面风格与配乐，活络观众观戏情绪并串起整齣戏的热闹气氛，为此剧更增添强烈的逗趣风格。&lt;/p&gt;&lt;p&gt;3. 戏中戏再现回忆过往&lt;/p&gt;&lt;p&gt;剧中各角色在回忆事件发生时各自的动作片段，将以戏中戏方式呈现，包括演员于舞台上的快速转换演出，以及与投影影片的互动，让「过去」与「现在」得以更流畅的连结，明确而完整的使观众理解各段落故事。&lt;/p&gt;&lt;p&gt;购票说明&lt;/p&gt;&lt;p&gt;1.请慎重选票，门票售出，恕不退换。请在指定购票渠道购票，否则出现不良后果如假票等，由购票者自行承担。 2.为避免快递配送不能及时送达，演出距开场时间少于3天时不提供【快递配送】服务，请您谅解！您可以选择官方淘宝在线支付，演出当天至杭州大剧院售票窗口自取纸质票（取票地址：杭州市江干区钱江新城新业路39号杭州大剧院南大厅售票窗口 ）。 3.凡演出票类商品，涉及未开票但成功完成在线预订者，正式开票后客服会第一时间电话联系您，请保持电话畅通。（如电话不通的预订者，需自行与我们联系。） 4.1.2m以下儿童谢绝入场（儿童专场及特殊场次除外），1.2m以上儿童请在家长的带领下凭票入场。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('24', '24', '&lt;p&gt;落魄作家为了写作素材， 寻访到了一个叫做吴邪的古董铺子老板，而吴邪正准备离开这个城市， 临走之前， 吴邪和他讲诉了关于自己奇怪的盗墓家族往事， 并说出了自己第一次随家族探险所经历的诡异事件：那一次他们的家族因为偶然获取了一件特殊的青铜器， 追根溯源，寻找到了被掩埋在中国西北盆地中的西王母古国， 他们招募了一批盗墓贼一同前往古城遗址探险， 进入了位于古城地下的西王母陵中， 发现了当年周穆王于西王母求长生不死之术的真相。 作家听完吴邪的故事， 却发现其中有很多疑点， 吴邪到底说的是自己的臆想， 还是真相更加可怕复杂， 因为吴邪的离开变成了永恒之谜。&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('25', '25', '&lt;p&gt;阳光明媚的日子里，大雄（大原惠美 配音）的心情却十分糟糕。无论是学校还是家中，老师、妈妈的严厉训斥已经让他不堪忍受。烦恼的大雄决定离家出走，借助哆啦A梦（水田山葵 配音）的道具，他在空地搭起了临时住所，无奈空地的主人决不允许他非法侵占土地。之后大雄在后山落脚，轰鸣的挖掘机又使他的出走计划受挫。好不容易在深山老林找到无人居住的旧房子，谁知却被附近水库的贮水所淹没。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;当 大雄灰头土脸回到家中的同时，似乎是受到了他的感染，胖虎（木村昴 配音）、小夫（关智一 配音）和静香（嘉数由美 配音）等好朋友也都动起了离家出走的 念头。只是放眼望去，不光是狭窄的日本，而今地球上每一寸土地都留下了人类的足迹，根本没有让他们自由玩耍的世外桃源。经过一番商讨，大家决定前往七万年 前的地球。心情激动的少年们乘坐时光机来到了遥远的过去，当时还处在冰河时代起始之初，脚下的日本土地蛮荒遍野，野兽横行。大家穿上可以调节温度的原始皮 装，拿起拥有电击功能的石器武器，俨然变成了彻头彻尾的原始人。借助未来道具的帮助，他们分工合作，建造房屋、种植作物、改造气候，大雄甚至还利用其他动 物的基因孵化出神话里的幻想动物古里菲因、飞龙以及飞马柏伽索斯。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;在此之后，小伙伴们每天利用放学后的时间回到七万年前，打造属于自己的梦 幻王国，偷偷享受着离家出走的乐趣。而就在此时，一个名叫古古鲁（白石凉子 配音）的神秘少年被时间乱流卷到了大雄他们的时代。从古古鲁的口中得知，少年 来自七万年前的中国古大陆。他所从属的光明一族爱好和平，相亲相爱，谁知穷凶极恶的黑暗族在神秘的精灵王巨尊比（大冢芳忠 配音）的率领下，对光明族展开 残酷的欺凌和屠戮。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;为了帮古古鲁回到族人的身边，并且解除光明一族的危机，小伙伴们不远万里从古老的日本向中国大陆出发。沿途上大雄他们经历了无数的艰难险阻，而巨尊比的可怕更是他们始料未及的。当然更出乎小伙伴们意料的是，他们这次离家出走的举动，无意间促成了日本的诞生……&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('26', '26', '&lt;p&gt;　影片讲述了香港探员班尼·布莱克（成龙饰）跟踪黑道老大维克多·王长达十数年， 为搜集他犯罪证据而被卷入一场“计中计”中，还将自己的侄女白舒（范冰冰饰）牵扯进来。在这场被中国特警、维克多·王、俄罗斯黑帮三面夹攻的“绝地逃亡” 中，班尼结识了共患难的最佳拍档康纳，一位正被维克多·王和俄国杀手追捕逃命的美国赌博高手，三人最终将怎样结束这场冒险变得扑朔迷离。&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('27', '27', '&lt;p&gt;电影讲述了从小在美国长大的林秋楠带着“超级英雄梦”回到中国，和舅舅袁来（刘芮 麟 饰）共同生活并一直相信自己可以照顾好“脆弱舅舅”。但他独特的思维方式和一身的功夫反而给自己的校园生活和舅舅的恋情添乱。他又在不知觉中卷入一桩国际 罪案，一场惊心动魄的对决难以避免……&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('28', '28', '&lt;p&gt;19世纪80年代，泰山（亚历山大·斯卡斯加德饰）已经离开了刚果丛林十年了，他 与心爱的简·波特（玛歌特·罗比饰）在维多利亚女王时代的英国伦敦生活。看似平静的城市生活对泰山来说并非真的自在，甚至感到窒息，身着考究的礼服，住在 豪宅里，却找不到家的感觉。一次，他以英国议会贸易大使的身份重新回到刚果，但这次派遣实际上是一次比利时人里昂·罗姆（克里斯托弗·瓦尔兹饰）的阴谋。 泰山、珍以及他的朋友们都陷入了危险，但丛林是泰山的天下，他开始重新飞檐走壁，拯救爱人和朋友。&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('29', '29', '&lt;p&gt;一只古老的面具打破了神秘世界族民们的平静的生活，一场不可避免的战争即将爆发！为阻止这场战争，新族长啦啦请人类世界的好友王雨果回来帮忙，淘气的雨果却将爸爸王大山带入了神秘世界。面对周遭突如其来的变化和对未知的恐惧，爱女心切的王大山惊慌失措，糗态百出……&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('30', '30', '&lt;p&gt;江淮大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众，坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。 江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场 经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众， 坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用，其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;江淮大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首 位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续 发展。 江淮大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('31', '31', '&lt;p&gt;淮南大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众，坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。 淮南大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场 经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续发展。 淮南大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;淮南大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众， 坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用，其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;淮南大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首 位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续 发展。 淮南大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('32', '32', '&lt;p&gt;蚌埠大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众，坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。 蚌埠大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场 经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续发展。 蚌埠大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;蚌埠大戏院万盛演艺广场发扬敢为人先的创新精神，坚持面向市场，面向广大观众， 坚持以人为本，贴近实际、贴近生活、贴近群众，发挥人民在文化建设中的主体作用，其健康向上、丰富多彩的文化演出风格深受广大群众的喜爱，影响不断扩大。 坚持继承和创新相统一，以优秀的作品鼓舞人，在全社会形成积极向上的精神追求和健康文明的生活方式。给安徽乃至全国观众带来了别具一格的文化盛宴。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;&lt;p&gt;蚌埠大戏院认真学习《国家十二五文化改革发展规划纲要》，坚持把社会效益放在首 位，坚持社会效益和经济效益有机统一，遵循文化发展规律，适应社会主义市场经济发展要求，一手抓繁荣、一手抓管理，推动文化事业和文化产业全面协调可持续 发展。 蚌埠大戏院万盛演艺广场发展文化产业的同时，一直以服务社会、回报社会为己任，积极利用自身宣传优势，弘扬爱心慈善精神，传播和谐理念，参与社会各类公益 事业，用实际行动回馈社会。&lt;/p&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('33', '33', '&lt;ul style=&quot;margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot; class=&quot; list-paddingleft-2&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;span style=&quot;font-size: 14px;&quot;&gt;&lt;strong&gt;岗位职责&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;&lt;ul style=&quot;margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot; class=&quot; list-paddingleft-2&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;span style=&quot;font-size: 14px;&quot;&gt;&lt;strong&gt;任职要求&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;');
INSERT INTO `lv_content_data` VALUES ('34', '34', '&lt;ul style=&quot;margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &amp;quot;microsoft yahei&amp;quot;; font-size: 12px; white-space: normal; background-color: rgb(255, 255, 255);&quot; class=&quot; list-paddingleft-2&quot;&gt;&lt;li&gt;&lt;p&gt;&lt;span style=&quot;font-size: 14px;&quot;&gt;&lt;strong&gt;岗位职责&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p&gt;&lt;span style=&quot;font-size: 14px;&quot;&gt;&lt;strong&gt;任职要求&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;&lt;/li&gt;&lt;li&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;1、负责剧场舞台的日常器械的管理、操作、维护，为参加演出的艺术团体提供相关技术支持；&lt;/p&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;2、爱岗敬业吃苦耐劳，有工作责任感、主动性和沟通协调能力，学习能力强；&lt;/p&gt;&lt;/li&gt;&lt;/ul&gt;&lt;p style=&quot;margin-top: 0px; margin-bottom: 0px; padding: 5px; color: rgb(102, 102, 102);&quot;&gt;&lt;br/&gt;&lt;/p&gt;');

-- ----------------------------
-- Table structure for lv_content_position
-- ----------------------------
DROP TABLE IF EXISTS `lv_content_position`;
CREATE TABLE `lv_content_position` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL COMMENT 'content表id',
  `position_id` smallint(5) unsigned NOT NULL COMMENT 'position表id',
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_content_position
-- ----------------------------
INSERT INTO `lv_content_position` VALUES ('1', '21', '1');
INSERT INTO `lv_content_position` VALUES ('2', '23', '1');
INSERT INTO `lv_content_position` VALUES ('3', '25', '1');
INSERT INTO `lv_content_position` VALUES ('4', '26', '1');
INSERT INTO `lv_content_position` VALUES ('5', '28', '1');
INSERT INTO `lv_content_position` VALUES ('6', '29', '1');

-- ----------------------------
-- Table structure for lv_content_tags
-- ----------------------------
DROP TABLE IF EXISTS `lv_content_tags`;
CREATE TABLE `lv_content_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL COMMENT 'content表id',
  `tags_id` int(10) unsigned NOT NULL COMMENT 'tags表id',
  PRIMARY KEY (`id`),
  KEY `content_id` (`content_id`),
  KEY `tags_id` (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_content_tags
-- ----------------------------

-- ----------------------------
-- Table structure for lv_expand
-- ----------------------------
DROP TABLE IF EXISTS `lv_expand`;
CREATE TABLE `lv_expand` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `table` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型表名称',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '模型名称',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '扩展模型排序，升序',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `table` (`table`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_expand
-- ----------------------------
INSERT INTO `lv_expand` VALUES ('2', 'program', '节目', '0', '2019-10-24 22:15:00', '2019-10-24 22:15:00');
INSERT INTO `lv_expand` VALUES ('3', 'cooperation', '商务合作', '2', '2019-10-27 16:49:02', '2019-10-27 16:49:02');
INSERT INTO `lv_expand` VALUES ('4', 'join_us', '招聘信息', '3', '2019-10-27 20:20:46', '2019-10-27 20:20:46');

-- ----------------------------
-- Table structure for lv_expand_data_cooperation
-- ----------------------------
DROP TABLE IF EXISTS `lv_expand_data_cooperation`;
CREATE TABLE `lv_expand_data_cooperation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL,
  `rolling_picture` varchar(2500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `leader` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_expand_data_cooperation
-- ----------------------------
INSERT INTO `lv_expand_data_cooperation` VALUES ('1', '30', '[{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/2f51f8eb6f14a84b56e51d6337538fbc.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/2f51f8eb6f14a84b56e51d6337538fbc.jpg\",\"title\":\"2f51f8eb6f14a84b56e51d6337538fbc\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/486a0916358e6b5c348eaefc58248e70.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/486a0916358e6b5c348eaefc58248e70.jpg\",\"title\":\"486a0916358e6b5c348eaefc58248e70\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/7714543f96dfea31adc488a9d451fc57.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/7714543f96dfea31adc488a9d451fc57.jpg\",\"title\":\"7714543f96dfea31adc488a9d451fc57\",\"order\":\"0\"}]', '合肥场地租赁', '望京', '15215569996');
INSERT INTO `lv_expand_data_cooperation` VALUES ('2', '31', '[{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/69c947ed45d24f30addbf755339a8016.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/69c947ed45d24f30addbf755339a8016.jpg\",\"title\":\"69c947ed45d24f30addbf755339a8016\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/81f938079af4b407f11733d9478f902a.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/81f938079af4b407f11733d9478f902a.jpg\",\"title\":\"81f938079af4b407f11733d9478f902a\",\"order\":\"0\"}]', '淮南场地租赁', '淮南', '15215569995');
INSERT INTO `lv_expand_data_cooperation` VALUES ('3', '32', '[{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/469cc53afb80b168630db9782515cb7d.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/469cc53afb80b168630db9782515cb7d.jpg\",\"title\":\"469cc53afb80b168630db9782515cb7d\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/56df921a5ab8497b29a9e7f4e22d6d8b.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/56df921a5ab8497b29a9e7f4e22d6d8b.jpg\",\"title\":\"56df921a5ab8497b29a9e7f4e22d6d8b\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/668e45138465f7046c14616c5b890688.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/668e45138465f7046c14616c5b890688.jpg\",\"title\":\"668e45138465f7046c14616c5b890688\",\"order\":\"0\"},{\"url\":\"\\/uploads\\/images\\/2019-10\\/27\\/a27e9f0172bc665c2ec93490ef40c582.jpg\",\"thumbnail_url\":\"\\/uploads\\/images\\/2019-10\\/27\\/a27e9f0172bc665c2ec93490ef40c582.jpg\",\"title\":\"a27e9f0172bc665c2ec93490ef40c582\",\"order\":\"0\"}]', '蚌埠场地租赁', '蚌埠', '15215569990');

-- ----------------------------
-- Table structure for lv_expand_data_join_us
-- ----------------------------
DROP TABLE IF EXISTS `lv_expand_data_join_us`;
CREATE TABLE `lv_expand_data_join_us` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL,
  `salary` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `experience` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profession` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_type` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_expand_data_join_us
-- ----------------------------
INSERT INTO `lv_expand_data_join_us` VALUES ('1', '33', '20-40K', '合肥', '3-5年', '舞蹈专业', '全职');
INSERT INTO `lv_expand_data_join_us` VALUES ('2', '34', '10-40K', '上海', '1-2年', '表演专业', '全职');

-- ----------------------------
-- Table structure for lv_expand_data_program
-- ----------------------------
DROP TABLE IF EXISTS `lv_expand_data_program`;
CREATE TABLE `lv_expand_data_program` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content_id` int(10) unsigned NOT NULL,
  `show_time` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fares` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `performance_groups` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `performance_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inportant` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booking` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `program_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `content_id` (`content_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_expand_data_program
-- ----------------------------
INSERT INTO `lv_expand_data_program` VALUES ('1', '21', '8月16日 10:30\n8月17日 16:30\n8月18日 16:30', '合肥江淮大剧院', '80\n90\n100', '合肥江淮大剧院', '商演', '不适宜12岁以下儿童观赏。', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('2', '22', '9月17日 19:00', '江淮大剧院', '90', '江淮大剧院', '商演', '18禁', '', '2');
INSERT INTO `lv_expand_data_program` VALUES ('3', '23', '8月15日 18:30\n8月16日 18:30\n8月17日 18:30\n8月18日 18:30', '合肥江淮大剧院', '60\n80\n100\n120', '合肥江淮大剧院', '商演', '不适宜12岁以下儿童观赏。', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('4', '24', '8月15日 18:30', '江淮大剧院', '80\n90', '江淮大剧院', '商演', '20禁', 'http://www.baidu.com', '2');
INSERT INTO `lv_expand_data_program` VALUES ('5', '25', '8月15日 18:30', '江淮大剧院', '90\n100\n110', '江淮大剧院', '商演', '18禁', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('6', '26', '8月15日 18:30\n8月19日 18:30', '江淮大剧院', '80\n90\n100', '江淮大剧院', '商演', '12禁', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('7', '27', '8月15日 18:30', '江淮大剧院', '80', '江淮大剧院', '商演', '19禁', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('8', '28', '8月11日 18:30', '淮南大剧院', '90', '淮南大剧院', '商演', '11禁', 'http://www.baidu.com', '1');
INSERT INTO `lv_expand_data_program` VALUES ('9', '29', '8月15日 19:30', '蚌埠大剧院', '30', '蚌埠大剧院', '商演', '18禁', 'http://www.baidu.com', '1');

-- ----------------------------
-- Table structure for lv_expand_field
-- ----------------------------
DROP TABLE IF EXISTS `lv_expand_field`;
CREATE TABLE `lv_expand_field` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `expand_id` smallint(5) unsigned NOT NULL COMMENT 'expand表id',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段描述',
  `field` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段名',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '字段类型，1：文本框；2：多行文本；3：编辑器，4：文件上传；5：单图片上传；6：组图上传；7：下拉菜单；8：单选；9：多选',
  `property` tinyint(4) NOT NULL DEFAULT '1' COMMENT '字段属性，1：varchar；2：int；3：text；4：datetime；5：decimal；',
  `len` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '长度',
  `decimal` tinyint(3) unsigned NOT NULL COMMENT '小数点位数',
  `default` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '默认值',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，越小越排在前面',
  `tip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段提示',
  `config` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '其他配置',
  `is_must` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否必填，0：否，1：是',
  `is_unique` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否唯一，0：否，1：是',
  `is_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否添加普通索引，0：否，1：是',
  `regex` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '正则表达式验证',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_expand_id` (`name`,`expand_id`),
  UNIQUE KEY `field_expand_id` (`field`,`expand_id`),
  KEY `expand_id` (`expand_id`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_expand_field
-- ----------------------------
INSERT INTO `lv_expand_field` VALUES ('2', '2', '展示时间', 'show_time', '2', '1', '250', '0', '', '1', '一行一个时间', '', '1', '0', '0', '/^\\d{1,2}月\\d{1,2}日 +\\d{1,2}:\\d{1,2}(\\n\\d{1,2}月\\d{1,2}日 +\\d{1,2}:\\d{1,2})*$/Us', '2019-10-24 23:53:47', '2019-10-24 23:53:47');
INSERT INTO `lv_expand_field` VALUES ('3', '2', '地点', 'address', '1', '1', '250', '0', '', '2', '', '', '1', '0', '0', '', '2019-10-26 14:25:35', '2019-10-26 14:25:35');
INSERT INTO `lv_expand_field` VALUES ('4', '2', '票价', 'fares', '2', '1', '250', '0', '', '3', '一行一个票价，不用带单位', '', '1', '0', '0', '/^\\d+(\\.\\d{1,2})?(\\n\\d+(\\.\\d{1,2})?)*$/', '2019-10-26 14:31:53', '2019-10-26 17:00:58');
INSERT INTO `lv_expand_field` VALUES ('5', '2', '演出团体', 'performance_groups', '1', '1', '50', '0', '', '4', '', '', '0', '0', '0', '', '2019-10-26 16:11:21', '2019-10-26 16:11:21');
INSERT INTO `lv_expand_field` VALUES ('6', '2', '演出类型', 'performance_type', '1', '1', '20', '0', '', '5', '', '', '1', '0', '0', '', '2019-10-26 16:14:06', '2019-10-26 16:15:58');
INSERT INTO `lv_expand_field` VALUES ('7', '2', '重要说明', 'inportant', '1', '1', '250', '0', '', '6', '', '', '0', '0', '0', '', '2019-10-26 16:15:44', '2019-10-26 16:16:03');
INSERT INTO `lv_expand_field` VALUES ('8', '2', '订票', 'booking', '1', '1', '250', '0', '', '7', '', '', '0', '0', '0', '', '2019-10-26 16:17:34', '2019-10-26 16:17:34');
INSERT INTO `lv_expand_field` VALUES ('9', '2', '节目类型', 'program_type', '8', '2', '11', '0', '1', '8', '', '{\"1\":\"正片\",\"2\":\"预告\"}', '1', '0', '0', '', '2019-10-26 16:31:12', '2019-10-26 16:31:12');
INSERT INTO `lv_expand_field` VALUES ('10', '3', '滚动图片', 'rolling_picture', '6', '1', '2500', '0', '', '1', '', '', '1', '0', '0', '', '2019-10-27 16:51:59', '2019-10-27 16:51:59');
INSERT INTO `lv_expand_field` VALUES ('11', '3', '场地名', 'site_name', '1', '1', '20', '0', '', '2', '', '', '1', '0', '0', '', '2019-10-27 16:52:54', '2019-10-27 16:53:01');
INSERT INTO `lv_expand_field` VALUES ('12', '3', '负责人', 'leader', '1', '1', '10', '0', '', '3', '', '', '1', '0', '0', '', '2019-10-27 16:53:41', '2019-10-27 16:53:41');
INSERT INTO `lv_expand_field` VALUES ('13', '3', '联系电话', 'tel', '1', '1', '50', '0', '', '4', '', '', '1', '0', '0', '', '2019-10-27 16:54:22', '2019-10-27 16:54:22');
INSERT INTO `lv_expand_field` VALUES ('14', '4', '薪资', 'salary', '1', '1', '20', '0', '', '1', '', '', '1', '0', '0', '', '2019-10-27 20:35:20', '2019-10-27 20:35:20');
INSERT INTO `lv_expand_field` VALUES ('15', '4', '工作地点', 'address', '1', '1', '20', '0', '', '2', '', '', '1', '0', '0', '', '2019-10-27 20:35:59', '2019-10-27 20:35:59');
INSERT INTO `lv_expand_field` VALUES ('16', '4', '经验', 'experience', '1', '1', '50', '0', '', '3', '', '', '1', '0', '0', '', '2019-10-27 20:36:44', '2019-10-27 20:36:51');
INSERT INTO `lv_expand_field` VALUES ('17', '4', '专业', 'profession', '1', '1', '20', '0', '', '4', '', '', '1', '0', '0', '', '2019-10-27 20:37:38', '2019-10-27 20:37:48');
INSERT INTO `lv_expand_field` VALUES ('18', '4', '职位类型', 'position_type', '1', '1', '10', '0', '全职', '5', '', '', '1', '0', '0', '', '2019-10-27 20:42:37', '2019-10-27 20:42:37');

-- ----------------------------
-- Table structure for lv_form
-- ----------------------------
DROP TABLE IF EXISTS `lv_form`;
CREATE TABLE `lv_form` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '表单名称',
  `no` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '表单编号',
  `table` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '表名',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '表单排序，升序',
  `sort` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'id DESC' COMMENT '内容排序',
  `display` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否在前台显示此表单的分页列表内容，0：否，1：是',
  `page` smallint(5) unsigned NOT NULL DEFAULT '10' COMMENT '前台分页数',
  `tpl` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前台模板，为空使用默认模板',
  `condition` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '前台分页条件',
  `return_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '提交表单返回类型，0：JS消息框，1：json',
  `return_msg` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '提交成功' COMMENT '提交成功后返回的提示信息',
  `return_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '提交成功后跳转的地址',
  `is_captcha` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用图片验证码，0：否，1：是',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `no` (`no`),
  UNIQUE KEY `table` (`table`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_form
-- ----------------------------
INSERT INTO `lv_form` VALUES ('1', '首页banner', '2bd219c11779604ad048341ec480692b', 'index_banner', '0', 'sort desc', '0', '10', '', '', '0', '提交成功', '', '1', '2019-10-11 22:56:52', '2019-10-11 22:56:52');
INSERT INTO `lv_form` VALUES ('2', '二维码', 'b08552cfe821c46078679221ffb9dbb0', 'qr_code', '0', 'id desc', '0', '10', '', '', '0', '提交成功', '', '1', '2019-10-20 12:43:04', '2019-10-20 12:43:04');

-- ----------------------------
-- Table structure for lv_form_data_index_banner
-- ----------------------------
DROP TABLE IF EXISTS `lv_form_data_index_banner`;
CREATE TABLE `lv_form_data_index_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_form_data_index_banner
-- ----------------------------
INSERT INTO `lv_form_data_index_banner` VALUES ('1', '', '/uploads/scrawls/2019-10/11/79c4d9d49deff2753c25620ecf549f3f.png', '0');
INSERT INTO `lv_form_data_index_banner` VALUES ('2', 'http://www.baidu.com', '/uploads/scrawls/2019-10/11/40fc9e8265556e425953d970fe22ee6e.png', '1');

-- ----------------------------
-- Table structure for lv_form_data_qr_code
-- ----------------------------
DROP TABLE IF EXISTS `lv_form_data_qr_code`;
CREATE TABLE `lv_form_data_qr_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_form_data_qr_code
-- ----------------------------
INSERT INTO `lv_form_data_qr_code` VALUES ('1', '/uploads/scrawls/2019-10/20/f1baca2aca63f6ffbe9329f903a16ffe.png');

-- ----------------------------
-- Table structure for lv_form_field
-- ----------------------------
DROP TABLE IF EXISTS `lv_form_field`;
CREATE TABLE `lv_form_field` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` tinyint(3) unsigned NOT NULL COMMENT 'form表id',
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段描述',
  `field` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '字段名',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '字段类型，1：文本框；2：多行文本；3：编辑器，4：文件上传；5：单图片上传；6：组图上传；7：下拉菜单；8：单选；9：多选',
  `property` tinyint(4) NOT NULL DEFAULT '1' COMMENT '字段属性，1：varchar；2：int；3：text；4：datetime；5：decimal；',
  `len` smallint(6) NOT NULL DEFAULT '0' COMMENT '字段长度',
  `decimal` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '小数点位数',
  `default` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '默认值',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，越小越排在前面',
  `tip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段提示',
  `config` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '字段配置',
  `is_must` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否必填，0：否，1：是',
  `is_unique` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否唯一，0：否，1：是',
  `is_index` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否添加普通索引，0：否，1：是',
  `regex` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '正则表达式验证',
  `admin_display` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否后台显示，0：否，1：是',
  `admin_display_len` smallint(6) NOT NULL DEFAULT '0' COMMENT '后台列表显示长度',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_form_id` (`name`,`form_id`),
  UNIQUE KEY `field_form_id` (`field`,`form_id`),
  KEY `form_id` (`form_id`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_form_field
-- ----------------------------
INSERT INTO `lv_form_field` VALUES ('1', '1', '链接', 'url', '1', '1', '250', '0', '', '0', '', '', '0', '0', '0', '', '1', '0', '2019-10-11 23:01:17', '2019-10-11 23:01:17');
INSERT INTO `lv_form_field` VALUES ('2', '1', '图片', 'pic', '5', '1', '250', '0', '', '0', '', '', '1', '0', '0', '', '1', '0', '2019-10-11 23:01:53', '2019-10-11 23:04:05');
INSERT INTO `lv_form_field` VALUES ('3', '1', '排序', 'sort', '1', '2', '11', '0', '0', '0', '降序', '', '0', '0', '0', '', '1', '0', '2019-10-11 23:02:55', '2019-10-11 23:02:55');
INSERT INTO `lv_form_field` VALUES ('5', '2', '二维码', 'url', '5', '1', '250', '0', '', '0', '', '', '1', '0', '0', '', '1', '0', '2019-10-20 12:44:59', '2019-10-20 12:44:59');

-- ----------------------------
-- Table structure for lv_fragment
-- ----------------------------
DROP TABLE IF EXISTS `lv_fragment`;
CREATE TABLE `lv_fragment` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sign` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标识',
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '描述',
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',
  `rm_html` tinyint(4) NOT NULL DEFAULT '0' COMMENT '去除html标签，0：否，1：去除最外层p标签；2:去除所有html标签',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sign` (`sign`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_fragment
-- ----------------------------

-- ----------------------------
-- Table structure for lv_migrations
-- ----------------------------
DROP TABLE IF EXISTS `lv_migrations`;
CREATE TABLE `lv_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_migrations
-- ----------------------------
INSERT INTO `lv_migrations` VALUES ('139', '2018_12_08_111345_create_admin_auth_table', '1');
INSERT INTO `lv_migrations` VALUES ('140', '2018_12_10_203111_create_admin_group_table', '1');
INSERT INTO `lv_migrations` VALUES ('141', '2018_12_11_191423_create_admin_table', '1');
INSERT INTO `lv_migrations` VALUES ('142', '2018_12_11_200445_create_admin_log_table', '1');
INSERT INTO `lv_migrations` VALUES ('143', '2018_12_11_203022_create_system_config_table', '1');
INSERT INTO `lv_migrations` VALUES ('144', '2018_12_11_211400_create_form_table', '1');
INSERT INTO `lv_migrations` VALUES ('145', '2018_12_12_193341_create_form_field_table', '1');
INSERT INTO `lv_migrations` VALUES ('146', '2018_12_12_200102_create_upload_table', '1');
INSERT INTO `lv_migrations` VALUES ('147', '2018_12_12_200708_create_expand_table', '1');
INSERT INTO `lv_migrations` VALUES ('148', '2018_12_12_203402_create_expand_field_table', '1');
INSERT INTO `lv_migrations` VALUES ('149', '2018_12_12_211201_create_fragment_table', '1');
INSERT INTO `lv_migrations` VALUES ('150', '2018_12_12_211937_create_replace_table', '1');
INSERT INTO `lv_migrations` VALUES ('151', '2018_12_13_200805_create_tags_group_table', '1');
INSERT INTO `lv_migrations` VALUES ('152', '2018_12_13_202347_create_tags_table', '1');
INSERT INTO `lv_migrations` VALUES ('153', '2018_12_13_203544_create_content_tags_table', '1');
INSERT INTO `lv_migrations` VALUES ('154', '2018_12_13_204418_create_position_table', '1');
INSERT INTO `lv_migrations` VALUES ('155', '2018_12_13_205312_create_content_position_table', '1');
INSERT INTO `lv_migrations` VALUES ('156', '2018_12_13_210209_create_category_model_table', '1');
INSERT INTO `lv_migrations` VALUES ('157', '2018_12_13_213413_create_category_table', '1');
INSERT INTO `lv_migrations` VALUES ('158', '2018_12_13_215144_create_content_table', '1');
INSERT INTO `lv_migrations` VALUES ('159', '2018_12_13_220644_create_content_data_table', '1');
INSERT INTO `lv_migrations` VALUES ('160', '2018_12_13_220948_create_category_jump_table', '1');
INSERT INTO `lv_migrations` VALUES ('161', '2018_12_13_221002_create_category_page_table', '1');

-- ----------------------------
-- Table structure for lv_position
-- ----------------------------
DROP TABLE IF EXISTS `lv_position`;
CREATE TABLE `lv_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '名称',
  `sequence` smallint(6) NOT NULL DEFAULT '0' COMMENT '排序，升序',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `sequence` (`sequence`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_position
-- ----------------------------
INSERT INTO `lv_position` VALUES ('1', '热门演出', '0');

-- ----------------------------
-- Table structure for lv_replace
-- ----------------------------
DROP TABLE IF EXISTS `lv_replace`;
CREATE TABLE `lv_replace` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '关键字',
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '要替换的内容',
  `num` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '替换次数，0：不限制',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态，0：禁用，1：启用',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_replace
-- ----------------------------

-- ----------------------------
-- Table structure for lv_system_config
-- ----------------------------
DROP TABLE IF EXISTS `lv_system_config`;
CREATE TABLE `lv_system_config` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置名称',
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '配置值',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_system_config
-- ----------------------------
INSERT INTO `lv_system_config` VALUES ('1', 'sitename', '万盛江淮大剧院', '2019-03-10 22:20:48', '2019-10-20 17:04:38');
INSERT INTO `lv_system_config` VALUES ('2', 'seoname', '江淮大剧院', '2019-03-10 22:20:48', '2019-10-20 17:04:43');
INSERT INTO `lv_system_config` VALUES ('3', 'siteurl', 'laravelcms.com', '2019-03-10 22:20:48', '2019-08-04 17:46:56');
INSERT INTO `lv_system_config` VALUES ('4', 'keywords', 'laravel', '2019-03-10 22:20:48', '2019-08-04 22:01:42');
INSERT INTO `lv_system_config` VALUES ('5', 'description', 'laravelcms test', '2019-03-10 22:20:48', '2019-08-04 22:02:46');
INSERT INTO `lv_system_config` VALUES ('6', 'masteremail', '1134856531@qq.com', '2019-03-10 22:20:48', '2019-10-17 23:04:37');
INSERT INTO `lv_system_config` VALUES ('7', 'copyright', '© 2016 万盛江淮大剧院版权所有', '2019-03-10 22:20:48', '2019-10-17 23:03:46');
INSERT INTO `lv_system_config` VALUES ('8', 'registered_no', '', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('9', 'telephone', '0551-5656-2121', '2019-03-10 22:20:48', '2019-10-17 23:03:10');
INSERT INTO `lv_system_config` VALUES ('10', 'linkman', '赵阳', '2019-03-10 22:20:48', '2019-10-17 23:04:33');
INSERT INTO `lv_system_config` VALUES ('11', 'fax', '021-5656-2323', '2019-03-10 22:20:48', '2019-10-17 23:03:21');
INSERT INTO `lv_system_config` VALUES ('12', 'qq', '', '2019-03-10 22:20:48', '2019-10-17 23:04:05');
INSERT INTO `lv_system_config` VALUES ('13', 'addr', '', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('14', 'db_cache', '1', '2019-03-10 22:20:48', '2019-10-20 16:50:03');
INSERT INTO `lv_system_config` VALUES ('15', 'db_cache_time', '5', '2019-03-10 22:20:48', '2019-08-18 19:38:28');
INSERT INTO `lv_system_config` VALUES ('16', 'view_cache', '1', '2019-03-10 22:20:48', '2019-10-20 16:50:02');
INSERT INTO `lv_system_config` VALUES ('17', 'html_index_cache_time', '10', '2019-03-10 22:20:48', '2019-08-04 22:26:29');
INSERT INTO `lv_system_config` VALUES ('18', 'html_other_cache_time', '10', '2019-03-10 22:20:48', '2019-08-18 22:39:14');
INSERT INTO `lv_system_config` VALUES ('19', 'html_search_cache_time', '10', '2019-03-10 22:20:48', '2019-08-18 22:39:16');
INSERT INTO `lv_system_config` VALUES ('20', 'theme', 'default', '2019-03-10 22:20:48', '2019-08-04 17:47:08');
INSERT INTO `lv_system_config` VALUES ('21', 'index_tpl', 'index.index', '2019-03-10 22:20:48', '2019-09-08 21:40:11');
INSERT INTO `lv_system_config` VALUES ('22', 'search_tpl', 'search.index', '2019-03-10 22:20:48', '2019-08-04 17:27:22');
INSERT INTO `lv_system_config` VALUES ('23', 'tags_index_tpl', 'tags.index', '2019-03-10 22:20:48', '2019-08-04 17:27:24');
INSERT INTO `lv_system_config` VALUES ('24', 'tags_info_tpl', 'tags.info', '2019-03-10 22:20:48', '2019-08-04 17:27:27');
INSERT INTO `lv_system_config` VALUES ('25', 'tpl_seach_page', '20', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('26', 'tpl_tags_index_page', '20', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('27', 'tpl_tags_page', '20', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('28', 'upload_switch', '0', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('29', 'file_size', '2', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('30', 'file_num', '10', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('31', 'image_type', 'png,jpg,jpeg,gif,bmp', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('32', 'video_type', 'flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('33', 'file_type', 'png,jpg,jpeg,gif,bmp,flv,swf,mkv,avi,rm,rmvb,mpeg,mpg,ogg,ogv,mov,wmv,mp4,webm,mp3,wav,mid,rar,zip,tar,gz,7z,bz2,cab,iso,doc,docx,xls,xlsx,ppt,pptx,pdf,txt,md,xml', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('34', 'thumbnail_switch', '0', '2019-03-10 22:20:48', '2019-08-03 18:36:29');
INSERT INTO `lv_system_config` VALUES ('35', 'thumbnail_cutout', '1', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('36', 'thumbnail_maxwidth', '210', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('37', 'thumbnail_maxheight', '110', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('38', 'watermark_switch', '0', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('39', 'watermark_place', '9', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('40', 'watermark_image', '', '2019-03-10 22:20:48', null);
INSERT INTO `lv_system_config` VALUES ('41', 'content_preview', '1', '2019-08-04 17:27:29', '2019-08-04 17:27:29');

-- ----------------------------
-- Table structure for lv_tags
-- ----------------------------
DROP TABLE IF EXISTS `lv_tags`;
CREATE TABLE `lv_tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tags_group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'tags_group表id',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '标签名',
  `click` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `tags_group_id` (`tags_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_tags
-- ----------------------------

-- ----------------------------
-- Table structure for lv_tags_group
-- ----------------------------
DROP TABLE IF EXISTS `lv_tags_group`;
CREATE TABLE `lv_tags_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标签组名',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_tags_group
-- ----------------------------
INSERT INTO `lv_tags_group` VALUES ('1', 'test', '2019-03-26 23:26:38', null);
INSERT INTO `lv_tags_group` VALUES ('2', 'test1', '2019-09-22 15:58:29', '2019-09-22 15:58:29');

-- ----------------------------
-- Table structure for lv_upload
-- ----------------------------
DROP TABLE IF EXISTS `lv_upload`;
CREATE TABLE `lv_upload` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件',
  `folder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件路径',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件名',
  `ext` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '文件扩展名',
  `size` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '文件类型',
  `time` datetime NOT NULL COMMENT '上传时间',
  `module` tinyint(4) NOT NULL DEFAULT '-1' COMMENT '所属模块，-1:未绑定模块；1：栏目模块，2：内容模块，3：扩展模块，4：表单模块',
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  KEY `ext` (`ext`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of lv_upload
-- ----------------------------
INSERT INTO `lv_upload` VALUES ('1', '/uploads/scrawls/2019-10/11/79c4d9d49deff2753c25620ecf549f3f.png', '/uploads/scrawls/2019-10/11/', '79c4d9d49deff2753c25620ecf549f3f', 'png', '393449', 'image/png', '2019-10-11 23:03:39', '4');
INSERT INTO `lv_upload` VALUES ('2', '/uploads/scrawls/2019-10/11/40fc9e8265556e425953d970fe22ee6e.png', '/uploads/scrawls/2019-10/11/', '40fc9e8265556e425953d970fe22ee6e', 'png', '337348', 'image/png', '2019-10-11 23:12:59', '4');
INSERT INTO `lv_upload` VALUES ('3', '/uploads/scrawls/2019-10/17/5898c4cb271083dc64f43316cda0eebc.png', '/uploads/scrawls/2019-10/17/', '5898c4cb271083dc64f43316cda0eebc', 'png', '649519', 'image/png', '2019-10-17 22:03:58', '2');
INSERT INTO `lv_upload` VALUES ('4', '/uploads/scrawls/2019-10/17/a6384f57266c19a402fee011c3d5f81f.png', '/uploads/scrawls/2019-10/17/', 'a6384f57266c19a402fee011c3d5f81f', 'png', '138322', 'image/png', '2019-10-17 22:04:21', '2');
INSERT INTO `lv_upload` VALUES ('5', '/uploads/scrawls/2019-10/17/e6f175774b59ce2f6be441eb10f3e05d.png', '/uploads/scrawls/2019-10/17/', 'e6f175774b59ce2f6be441eb10f3e05d', 'png', '117740', 'image/png', '2019-10-17 22:04:36', '2');
INSERT INTO `lv_upload` VALUES ('6', '/uploads/scrawls/2019-10/20/f1baca2aca63f6ffbe9329f903a16ffe.png', '/uploads/scrawls/2019-10/20/', 'f1baca2aca63f6ffbe9329f903a16ffe', 'png', '17617', 'image/png', '2019-10-20 12:45:23', '4');
INSERT INTO `lv_upload` VALUES ('7', '/uploads/scrawls/2019-10/20/cd70e41803e72c256abe951feae43b8d.png', '/uploads/scrawls/2019-10/20/', 'cd70e41803e72c256abe951feae43b8d', 'png', '138322', 'image/png', '2019-10-20 13:11:56', '2');
INSERT INTO `lv_upload` VALUES ('8', '/uploads/scrawls/2019-10/20/56480a617a4ad5c4a6d60aa0a0d41ee4.png', '/uploads/scrawls/2019-10/20/', '56480a617a4ad5c4a6d60aa0a0d41ee4', 'png', '106544', 'image/png', '2019-10-20 13:12:55', '2');
INSERT INTO `lv_upload` VALUES ('9', '/uploads/scrawls/2019-10/20/d1f31f24e5a8fbcff0e54b5fd321b052.png', '/uploads/scrawls/2019-10/20/', 'd1f31f24e5a8fbcff0e54b5fd321b052', 'png', '117740', 'image/png', '2019-10-20 13:14:52', '2');
INSERT INTO `lv_upload` VALUES ('10', '/uploads/scrawls/2019-10/20/1cc51d71d2e7727e8f6d2eeaebe785b0.png', '/uploads/scrawls/2019-10/20/', '1cc51d71d2e7727e8f6d2eeaebe785b0', 'png', '861459', 'image/png', '2019-10-20 13:15:11', '2');
INSERT INTO `lv_upload` VALUES ('11', '/uploads/scrawls/2019-10/20/ba7d6740e4dc37faa789a85c47c6fcf5.png', '/uploads/scrawls/2019-10/20/', 'ba7d6740e4dc37faa789a85c47c6fcf5', 'png', '138322', 'image/png', '2019-10-20 15:33:11', '2');
INSERT INTO `lv_upload` VALUES ('12', '/uploads/scrawls/2019-10/20/8d6ec9e79b8197eb8a89de29e57caaf0.png', '/uploads/scrawls/2019-10/20/', '8d6ec9e79b8197eb8a89de29e57caaf0', 'png', '106544', 'image/png', '2019-10-20 15:33:26', '2');
INSERT INTO `lv_upload` VALUES ('13', '/uploads/scrawls/2019-10/20/a907786e4dd85ab016dd4f1573cf513b.png', '/uploads/scrawls/2019-10/20/', 'a907786e4dd85ab016dd4f1573cf513b', 'png', '117740', 'image/png', '2019-10-20 15:33:39', '2');
INSERT INTO `lv_upload` VALUES ('14', '/uploads/scrawls/2019-10/20/e8022533c6f160be544afcc6632c5f43.png', '/uploads/scrawls/2019-10/20/', 'e8022533c6f160be544afcc6632c5f43', 'png', '861459', 'image/png', '2019-10-20 15:33:54', '2');
INSERT INTO `lv_upload` VALUES ('15', '/uploads/scrawls/2019-10/20/390a5a43d548383295f84bd99fba624e.png', '/uploads/scrawls/2019-10/20/', '390a5a43d548383295f84bd99fba624e', 'png', '138322', 'image/png', '2019-10-20 15:34:32', '2');
INSERT INTO `lv_upload` VALUES ('16', '/uploads/scrawls/2019-10/20/11d0618f92eb0ca63c7d2067d47b27ca.png', '/uploads/scrawls/2019-10/20/', '11d0618f92eb0ca63c7d2067d47b27ca', 'png', '106544', 'image/png', '2019-10-20 15:34:50', '2');
INSERT INTO `lv_upload` VALUES ('17', '/uploads/scrawls/2019-10/20/4578f41ddee2d51fc8b1df78593f909e.png', '/uploads/scrawls/2019-10/20/', '4578f41ddee2d51fc8b1df78593f909e', 'png', '117740', 'image/png', '2019-10-20 15:36:42', '2');
INSERT INTO `lv_upload` VALUES ('18', '/uploads/scrawls/2019-10/20/09d2336d5bf74eb8f8f90414d514da65.png', '/uploads/scrawls/2019-10/20/', '09d2336d5bf74eb8f8f90414d514da65', 'png', '861459', 'image/png', '2019-10-20 16:36:27', '2');
INSERT INTO `lv_upload` VALUES ('19', '/uploads/images/2019-10/20/e5d4c797fcdf7221aedf32f4015d8a34.jpg', '/uploads/images/2019-10/20/', 'e5d4c797fcdf7221aedf32f4015d8a34', 'jpg', '12407', 'image/jpeg', '2019-10-20 17:48:44', '1');
INSERT INTO `lv_upload` VALUES ('20', '/uploads/images/2019-10/20/5075786933493698263a6657d032781e.jpg', '/uploads/images/2019-10/20/', '5075786933493698263a6657d032781e', 'jpg', '33239', 'image/jpeg', '2019-10-20 17:51:24', '1');
INSERT INTO `lv_upload` VALUES ('21', '/uploads/images/2019-10/20/d63569b8ed049edee1df96641aac4bba.jpg', '/uploads/images/2019-10/20/', 'd63569b8ed049edee1df96641aac4bba', 'jpg', '33239', 'image/jpeg', '2019-10-20 17:51:35', '1');
INSERT INTO `lv_upload` VALUES ('22', '/uploads/images/2019-10/20/30d3de1270ed1ee416f3c287de55ae0c.jpg', '/uploads/images/2019-10/20/', '30d3de1270ed1ee416f3c287de55ae0c', 'jpg', '24310', 'image/jpeg', '2019-10-20 17:51:41', '1');
INSERT INTO `lv_upload` VALUES ('23', '/uploads/images/2019-10/20/225c068b2c0478c3e4ce78caa4e62c90.jpg', '/uploads/images/2019-10/20/', '225c068b2c0478c3e4ce78caa4e62c90', 'jpg', '29598', 'image/jpeg', '2019-10-20 17:51:48', '1');
INSERT INTO `lv_upload` VALUES ('24', '/uploads/scrawls/2019-10/20/87b5d6c434270468628113ede86df63c.png', '/uploads/scrawls/2019-10/20/', '87b5d6c434270468628113ede86df63c', 'png', '224180', 'image/png', '2019-10-20 21:18:33', '2');
INSERT INTO `lv_upload` VALUES ('25', '/uploads/scrawls/2019-10/20/c0af49cec7fbf493589f813a105a76e1.png', '/uploads/scrawls/2019-10/20/', 'c0af49cec7fbf493589f813a105a76e1', 'png', '117929', 'image/png', '2019-10-20 21:19:41', '2');
INSERT INTO `lv_upload` VALUES ('26', '/uploads/scrawls/2019-10/20/bfa64b1f909354adba99000da100df90.png', '/uploads/scrawls/2019-10/20/', 'bfa64b1f909354adba99000da100df90', 'png', '61536', 'image/png', '2019-10-20 21:21:15', '2');
INSERT INTO `lv_upload` VALUES ('27', '/uploads/scrawls/2019-10/20/f748ec11b15a4e8c7dd84727971a6a7d.png', '/uploads/scrawls/2019-10/20/', 'f748ec11b15a4e8c7dd84727971a6a7d', 'png', '609880', 'image/png', '2019-10-20 21:31:57', '2');
INSERT INTO `lv_upload` VALUES ('28', '/uploads/scrawls/2019-10/26/af6f89afe94815d36dd2cb65b76dcfb5.png', '/uploads/scrawls/2019-10/26/', 'af6f89afe94815d36dd2cb65b76dcfb5', 'png', '137386', 'image/png', '2019-10-26 16:57:23', '2');
INSERT INTO `lv_upload` VALUES ('29', '/uploads/images/2019-10/26/9187867e2a7319142b1d2ebf05e5ed46.jpg', '/uploads/images/2019-10/26/', '9187867e2a7319142b1d2ebf05e5ed46', 'jpg', '34244', 'image/jpeg', '2019-10-26 16:57:54', '2');
INSERT INTO `lv_upload` VALUES ('30', '/uploads/scrawls/2019-10/26/439590ee34c511a3e8694dea3ad1c1ef.png', '/uploads/scrawls/2019-10/26/', '439590ee34c511a3e8694dea3ad1c1ef', 'png', '270652', 'image/png', '2019-10-26 17:09:01', '2');
INSERT INTO `lv_upload` VALUES ('31', '/uploads/scrawls/2019-10/26/b3c4d1dcb4d54ec597a063ce70975eeb.png', '/uploads/scrawls/2019-10/26/', 'b3c4d1dcb4d54ec597a063ce70975eeb', 'png', '109657', 'image/png', '2019-10-26 17:11:45', '2');
INSERT INTO `lv_upload` VALUES ('32', '/uploads/images/2019-10/26/fd1773ab8c6ae986be0921ee0eb5d8bb.jpg', '/uploads/images/2019-10/26/', 'fd1773ab8c6ae986be0921ee0eb5d8bb', 'jpg', '67280', 'image/jpeg', '2019-10-26 17:12:07', '2');
INSERT INTO `lv_upload` VALUES ('33', '/uploads/scrawls/2019-10/26/816403d305278647b77a8b753543db77.png', '/uploads/scrawls/2019-10/26/', '816403d305278647b77a8b753543db77', 'png', '258394', 'image/png', '2019-10-26 22:45:29', '2');
INSERT INTO `lv_upload` VALUES ('34', '/uploads/scrawls/2019-10/26/4481d0ddaba82a2d67644780603cb859.png', '/uploads/scrawls/2019-10/26/', '4481d0ddaba82a2d67644780603cb859', 'png', '137908', 'image/png', '2019-10-26 22:47:36', '2');
INSERT INTO `lv_upload` VALUES ('35', '/uploads/scrawls/2019-10/26/09007ad6d74cc0eccf7c035215250215.png', '/uploads/scrawls/2019-10/26/', '09007ad6d74cc0eccf7c035215250215', 'png', '238633', 'image/png', '2019-10-26 22:51:24', '2');
INSERT INTO `lv_upload` VALUES ('36', '/uploads/scrawls/2019-10/26/bf7f00ea671e1979b298e7f5ea4428e1.png', '/uploads/scrawls/2019-10/26/', 'bf7f00ea671e1979b298e7f5ea4428e1', 'png', '206830', 'image/png', '2019-10-26 23:10:45', '2');
INSERT INTO `lv_upload` VALUES ('37', '/uploads/scrawls/2019-10/26/a09dde64e92adbe05c7adc7f0f25c41f.png', '/uploads/scrawls/2019-10/26/', 'a09dde64e92adbe05c7adc7f0f25c41f', 'png', '241944', 'image/png', '2019-10-26 23:12:21', '2');
INSERT INTO `lv_upload` VALUES ('38', '/uploads/scrawls/2019-10/26/bf180a4a699be3ac5951f28fa1a09db2.png', '/uploads/scrawls/2019-10/26/', 'bf180a4a699be3ac5951f28fa1a09db2', 'png', '206830', 'image/png', '2019-10-26 23:14:35', '2');
INSERT INTO `lv_upload` VALUES ('39', '/uploads/scrawls/2019-10/26/4c3442dc18018cca3651c741eefbdf33.png', '/uploads/scrawls/2019-10/26/', '4c3442dc18018cca3651c741eefbdf33', 'png', '270652', 'image/png', '2019-10-26 23:16:55', '2');
INSERT INTO `lv_upload` VALUES ('40', '/uploads/scrawls/2019-10/26/d2dfaab42445d385b76940bba9916a37.png', '/uploads/scrawls/2019-10/26/', 'd2dfaab42445d385b76940bba9916a37', 'png', '261335', 'image/png', '2019-10-26 23:18:13', '2');
INSERT INTO `lv_upload` VALUES ('41', '/uploads/images/2019-10/27/2f51f8eb6f14a84b56e51d6337538fbc.jpg', '/uploads/images/2019-10/27/', '2f51f8eb6f14a84b56e51d6337538fbc', 'jpg', '21616', 'image/jpeg', '2019-10-27 16:57:28', '4');
INSERT INTO `lv_upload` VALUES ('42', '/uploads/images/2019-10/27/486a0916358e6b5c348eaefc58248e70.jpg', '/uploads/images/2019-10/27/', '486a0916358e6b5c348eaefc58248e70', 'jpg', '17234', 'image/jpeg', '2019-10-27 16:57:28', '4');
INSERT INTO `lv_upload` VALUES ('43', '/uploads/images/2019-10/27/7714543f96dfea31adc488a9d451fc57.jpg', '/uploads/images/2019-10/27/', '7714543f96dfea31adc488a9d451fc57', 'jpg', '21597', 'image/jpeg', '2019-10-27 16:57:28', '4');
INSERT INTO `lv_upload` VALUES ('44', '/uploads/images/2019-10/27/69c947ed45d24f30addbf755339a8016.jpg', '/uploads/images/2019-10/27/', '69c947ed45d24f30addbf755339a8016', 'jpg', '135801', 'image/jpeg', '2019-10-27 17:09:17', '4');
INSERT INTO `lv_upload` VALUES ('45', '/uploads/images/2019-10/27/81f938079af4b407f11733d9478f902a.jpg', '/uploads/images/2019-10/27/', '81f938079af4b407f11733d9478f902a', 'jpg', '107710', 'image/jpeg', '2019-10-27 17:09:17', '4');
INSERT INTO `lv_upload` VALUES ('46', '/uploads/images/2019-10/27/a27e9f0172bc665c2ec93490ef40c582.jpg', '/uploads/images/2019-10/27/', 'a27e9f0172bc665c2ec93490ef40c582', 'jpg', '66229', 'image/jpeg', '2019-10-27 17:11:01', '4');
INSERT INTO `lv_upload` VALUES ('47', '/uploads/images/2019-10/27/668e45138465f7046c14616c5b890688.jpg', '/uploads/images/2019-10/27/', '668e45138465f7046c14616c5b890688', 'jpg', '20237', 'image/jpeg', '2019-10-27 17:11:01', '4');
INSERT INTO `lv_upload` VALUES ('48', '/uploads/images/2019-10/27/56df921a5ab8497b29a9e7f4e22d6d8b.jpg', '/uploads/images/2019-10/27/', '56df921a5ab8497b29a9e7f4e22d6d8b', 'jpg', '111875', 'image/jpeg', '2019-10-27 17:11:01', '4');
INSERT INTO `lv_upload` VALUES ('49', '/uploads/images/2019-10/27/469cc53afb80b168630db9782515cb7d.jpg', '/uploads/images/2019-10/27/', '469cc53afb80b168630db9782515cb7d', 'jpg', '11546', 'image/jpeg', '2019-10-27 17:11:02', '4');

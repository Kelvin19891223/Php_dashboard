/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100131
Source Host           : localhost:3306
Source Database       : simple_db

Target Server Type    : MYSQL
Target Server Version : 100131
File Encoding         : 65001

Date: 2018-09-10 17:04:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for assessment_form
-- ----------------------------
DROP TABLE IF EXISTS `assessment_form`;
CREATE TABLE `assessment_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) DEFAULT NULL,
  `pre_event_status` varchar(255) DEFAULT NULL,
  `post_event_status` varchar(255) DEFAULT NULL,
  `pre_reminder` text,
  `pre_reminder_day` int(11) DEFAULT '14',
  `post_reminder` text,
  `post_reminder_day` int(11) DEFAULT NULL COMMENT '14',
  `year` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `assessment_release_date` date DEFAULT NULL,
  `submission_due_date` date DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `course_description` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of assessment_form
-- ----------------------------
INSERT INTO `assessment_form` VALUES ('58', 'Taught', 'Reviewed_', 'Uploaded_', 'a', '21', 'b', '3', '2018', '1', '2018-09-13', '2018-09-19', '3', 'ASDAdasdadasdasdasd');
INSERT INTO `assessment_form` VALUES ('59', 'Taught', '', '', '', null, '', null, null, '1', '2018-09-05', '1900-12-06', '3', 'ASDAdasdadasdasdasd');
INSERT INTO `assessment_form` VALUES ('60', 'Taught', '', '', '', '14', '', '1', '2018', '1', '2018-09-29', '2018-09-26', '3', '');
INSERT INTO `assessment_form` VALUES ('61', 'Taught', '', '', '', '14', '', '1', '2018', '1', '2018-09-11', '2018-09-27', '3', '');

-- ----------------------------
-- Table structure for assign_role
-- ----------------------------
DROP TABLE IF EXISTS `assign_role`;
CREATE TABLE `assign_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) NOT NULL,
  `teacher_name` varchar(255) NOT NULL,
  `moderator_name` varchar(255) NOT NULL,
  `course_kind` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of assign_role
-- ----------------------------
INSERT INTO `assign_role` VALUES ('3', 'Taught', 'abbb', 'q', 'Taught');

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) DEFAULT NULL,
  `uploaded_on` date DEFAULT NULL,
  `status` enum('0','1','') DEFAULT NULL,
  `kind` varchar(255) DEFAULT NULL,
  `course_name` varchar(255) DEFAULT NULL,
  `origin_name` varchar(255) DEFAULT NULL,
  `form_id` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('74', 'uploads/58_Taught/5b9267f268236index.php', '2018-09-07', null, 'marking_criteria', 'Taught', 'index.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('75', 'uploads/58_Taught/5b9267f26920blist.php', '2018-09-07', null, 'exam_solution', 'Taught', 'list.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('76', 'uploads/58_Taught/5b9267f26a598list.php', '2018-09-07', null, 'pre_event_file', 'Taught', 'list.php', '58', null, '', 'abbb');
INSERT INTO `files` VALUES ('77', 'uploads/58_Taught/5b9267f26b538index.php', '2018-09-07', null, 'post_event_file', 'Taught', 'index.php', '58', null, '', 'abbb');
INSERT INTO `files` VALUES ('78', 'uploads/58_Taught/5b9267f26c4d6list.php', '2018-09-07', null, 'student_sample_low', 'Taught', 'list.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('79', 'uploads/58_Taught/5b9267f26d521index.php', '2018-09-07', null, 'student_sample_medium', 'Taught', 'index.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('80', 'uploads/58_Taught/5b9267f26e5b8list.php', '2018-09-07', null, 'student_sample_high', 'Taught', 'list.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('81', 'uploads/58_Taught/5b92684534f5dindex.php', '2018-09-07', null, 'assessment_description', 'Taught', 'index.php', '58', null, null, 'abbb');
INSERT INTO `files` VALUES ('82', 'uploads/59_Taught/5b939776aa02c1.JPG', '2018-09-08', null, 'assessment_description', 'Taught', '1.JPG', '59', null, null, 'abbb');
INSERT INTO `files` VALUES ('83', 'uploads/59_Taught/5b93981d8f97f3.png', '2018-09-08', null, 'marking_criteria', 'Taught', '3.png', '59', null, null, 'abbb');
INSERT INTO `files` VALUES ('84', 'uploads/59_Taught/5b93982480557photo.jpg', '2018-09-08', null, 'exam_solution', 'Taught', 'photo.jpg', '59', null, null, 'abbb');
INSERT INTO `files` VALUES ('85', 'uploads/59_Taught/5b93c5f2d55aaProject Requirementsv1.docx', '2018-09-08', null, 'assessment_description', 'Taught', 'Project Requirementsv1.docx', '59', null, null, 'abbb');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(64) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `user_level` int(10) NOT NULL DEFAULT '1' COMMENT '0:admin',
  `gender` enum('') DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `level` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('19', 'kelvin', 'schelor', 'admin@admin.com', '89177a6c3708ca433e918ce0043d6affb33db7f8', '0', '2018-09-04 18:53:07', '2018-09-10 16:59:36', 'abbb', '123', '1', null, '                                            ', '0000-00-00', 'admin');
INSERT INTO `users` VALUES ('33', 'Ahmed', 'Alghamdi', 'a.moca@gmail.com', '89177a6c3708ca433e918ce0043d6affb33db7f8', '1', '2018-09-07 15:23:46', null, 'ahmoca_23', '678789090', '1', null, '', '2018-09-14', null);
INSERT INTO `users` VALUES ('37', 'asd', 'asd', 'asd@asd.com', '89177a6c3708ca433e918ce0043d6affb33db7f8', '0', '2018-09-10 16:47:03', '2018-09-10 16:47:03', 'ahmoca_23', 'asdasd', '1', null, '', '0000-00-00', 'Taught');

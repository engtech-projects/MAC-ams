/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1_3306
 Source Server Type    : MySQL
 Source Server Version : 50733
 Source Host           : 127.0.0.1:3306
 Source Schema         : just_accounting_db

 Target Server Type    : MySQL
 Target Server Version : 50733
 File Encoding         : 65001

 Date: 17/05/2022 08:40:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_lists
-- ----------------------------
DROP TABLE IF EXISTS `access_lists`;
CREATE TABLE `access_lists`  (
  `al_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `module_name` varchar(86) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`al_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of access_lists
-- ----------------------------
INSERT INTO `access_lists` VALUES (1, 'Sales', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (2, 'Expenses', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (3, 'Employees', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (4, 'Reports', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (5, 'System Setup', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (6, 'Misc', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (7, 'Dashboard', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (8, 'Chart of Accounts', '2022-04-10 02:27:25', '2022-04-10 02:27:25');

-- ----------------------------
-- Table structure for accessibilities
-- ----------------------------
DROP TABLE IF EXISTS `accessibilities`;
CREATE TABLE `accessibilities`  (
  `access_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sml_id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `date_created` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`access_id`) USING BTREE,
  INDEX `sml_id`(`sml_id`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE,
  CONSTRAINT `accessibilities_ibfk_1` FOREIGN KEY (`sml_id`) REFERENCES `sub_module_lists` (`sml_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `accessibilities_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 155 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of accessibilities
-- ----------------------------
INSERT INTO `accessibilities` VALUES (25, 122, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (26, 123, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (27, 124, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (28, 125, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (29, 126, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (30, 127, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (31, 128, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (35, 132, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (37, 134, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (38, 135, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (39, 136, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (40, 137, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (41, 138, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (42, 139, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (43, 140, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (44, 141, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (45, 142, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (46, 143, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (47, 144, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (48, 145, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (49, 146, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (50, 147, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (51, 148, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (52, 149, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (53, 150, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (54, 151, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (55, 152, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (56, 153, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (57, 154, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (58, 155, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (59, 156, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (60, 157, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (61, 158, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (62, 159, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (63, 160, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (64, 161, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (65, 162, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (66, 163, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (67, 164, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (68, 165, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (69, 166, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (70, 167, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (71, 168, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (72, 169, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (73, 170, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (74, 171, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (75, 172, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (76, 174, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (80, 175, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (81, 178, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (82, 179, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (83, 180, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (85, 181, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (86, 187, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (87, 189, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (88, 191, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (90, 182, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (92, 193, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (101, 130, 1, '2022-05-05', '2022-05-05 04:42:04', '2022-05-05 04:42:04');
INSERT INTO `accessibilities` VALUES (105, 131, 1, '2022-05-05', '2022-05-05 04:42:15', '2022-05-05 04:42:15');
INSERT INTO `accessibilities` VALUES (106, 133, 1, '2022-05-05', '2022-05-05 04:42:16', '2022-05-05 04:42:16');
INSERT INTO `accessibilities` VALUES (107, 174, 2, '2022-05-05', '2022-05-05 04:43:06', '2022-05-05 04:43:06');
INSERT INTO `accessibilities` VALUES (108, 125, 2, '2022-05-05', '2022-05-05 04:43:30', '2022-05-05 04:43:30');
INSERT INTO `accessibilities` VALUES (109, 126, 2, '2022-05-05', '2022-05-05 04:43:31', '2022-05-05 04:43:31');
INSERT INTO `accessibilities` VALUES (110, 127, 2, '2022-05-05', '2022-05-05 04:43:32', '2022-05-05 04:43:32');
INSERT INTO `accessibilities` VALUES (111, 128, 2, '2022-05-05', '2022-05-05 04:43:34', '2022-05-05 04:43:34');
INSERT INTO `accessibilities` VALUES (113, 156, 2, '2022-05-05', '2022-05-05 05:05:48', '2022-05-05 05:05:48');
INSERT INTO `accessibilities` VALUES (115, 157, 2, '2022-05-05', '2022-05-05 05:05:51', '2022-05-05 05:05:51');
INSERT INTO `accessibilities` VALUES (116, 159, 2, '2022-05-05', '2022-05-05 05:05:53', '2022-05-05 05:05:53');
INSERT INTO `accessibilities` VALUES (117, 158, 2, '2022-05-05', '2022-05-05 05:05:53', '2022-05-05 05:05:53');
INSERT INTO `accessibilities` VALUES (118, 178, 2, '2022-05-05', '2022-05-05 05:05:55', '2022-05-05 05:05:55');
INSERT INTO `accessibilities` VALUES (119, 175, 2, '2022-05-05', '2022-05-05 05:05:56', '2022-05-05 05:05:56');
INSERT INTO `accessibilities` VALUES (122, 180, 2, '2022-05-05', '2022-05-05 05:06:02', '2022-05-05 05:06:02');
INSERT INTO `accessibilities` VALUES (123, 181, 2, '2022-05-05', '2022-05-05 05:06:03', '2022-05-05 05:06:03');
INSERT INTO `accessibilities` VALUES (127, 122, 2, '2022-05-05', '2022-05-05 05:06:18', '2022-05-05 05:06:18');
INSERT INTO `accessibilities` VALUES (128, 123, 2, '2022-05-05', '2022-05-05 05:06:18', '2022-05-05 05:06:18');
INSERT INTO `accessibilities` VALUES (129, 124, 2, '2022-05-05', '2022-05-05 05:06:19', '2022-05-05 05:06:19');
INSERT INTO `accessibilities` VALUES (130, 195, 1, '2022-05-05', '2022-05-05 05:22:51', '2022-05-05 05:22:51');
INSERT INTO `accessibilities` VALUES (132, 129, 1, '2022-05-06', '2022-05-06 01:44:25', '2022-05-06 01:44:25');
INSERT INTO `accessibilities` VALUES (133, 179, 2, '2022-05-06', '2022-05-06 05:58:55', '2022-05-06 05:58:55');
INSERT INTO `accessibilities` VALUES (134, 187, 2, '2022-05-06', '2022-05-06 05:58:57', '2022-05-06 05:58:57');
INSERT INTO `accessibilities` VALUES (135, 189, 2, '2022-05-06', '2022-05-06 05:59:00', '2022-05-06 05:59:00');
INSERT INTO `accessibilities` VALUES (136, 191, 2, '2022-05-06', '2022-05-06 05:59:01', '2022-05-06 05:59:01');
INSERT INTO `accessibilities` VALUES (137, 193, 2, '2022-05-06', '2022-05-06 05:59:01', '2022-05-06 05:59:01');
INSERT INTO `accessibilities` VALUES (138, 195, 2, '2022-05-06', '2022-05-06 05:59:02', '2022-05-06 05:59:02');
INSERT INTO `accessibilities` VALUES (144, 129, 2, '2022-05-13', '2022-05-13 01:50:39', '2022-05-13 01:50:39');
INSERT INTO `accessibilities` VALUES (145, 130, 2, '2022-05-13', '2022-05-13 01:50:41', '2022-05-13 01:50:41');
INSERT INTO `accessibilities` VALUES (146, 131, 2, '2022-05-13', '2022-05-13 01:50:41', '2022-05-13 01:50:41');
INSERT INTO `accessibilities` VALUES (147, 132, 2, '2022-05-13', '2022-05-13 01:50:42', '2022-05-13 01:50:42');
INSERT INTO `accessibilities` VALUES (148, 133, 2, '2022-05-13', '2022-05-13 01:50:43', '2022-05-13 01:50:43');
INSERT INTO `accessibilities` VALUES (149, 139, 2, '2022-05-13', '2022-05-13 01:50:53', '2022-05-13 01:50:53');
INSERT INTO `accessibilities` VALUES (150, 140, 2, '2022-05-13', '2022-05-13 01:50:54', '2022-05-13 01:50:54');
INSERT INTO `accessibilities` VALUES (151, 141, 2, '2022-05-13', '2022-05-13 01:50:55', '2022-05-13 01:50:55');
INSERT INTO `accessibilities` VALUES (152, 142, 2, '2022-05-13', '2022-05-13 01:50:56', '2022-05-13 01:50:56');
INSERT INTO `accessibilities` VALUES (153, 143, 2, '2022-05-13', '2022-05-13 01:51:02', '2022-05-13 01:51:02');
INSERT INTO `accessibilities` VALUES (154, 197, 1, '2022-05-17', '2022-05-17 00:39:34', '2022-05-17 00:39:34');

-- ----------------------------
-- Table structure for account_category
-- ----------------------------
DROP TABLE IF EXISTS `account_category`;
CREATE TABLE `account_category`  (
  `account_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of account_category
-- ----------------------------
INSERT INTO `account_category` VALUES (1, 'assets', '2021-09-13 10:33:14', '2021-09-13 10:33:14');
INSERT INTO `account_category` VALUES (2, 'liabilities', '2021-09-13 10:33:14', '2021-09-13 10:33:14');
INSERT INTO `account_category` VALUES (3, 'equity', '2021-09-13 10:33:14', '2021-09-13 10:33:14');
INSERT INTO `account_category` VALUES (4, 'income', '2021-09-13 10:33:14', '2021-09-13 10:33:14');
INSERT INTO `account_category` VALUES (5, 'expense', '2021-09-13 10:33:14', '2021-09-13 10:33:14');

-- ----------------------------
-- Table structure for account_type
-- ----------------------------
DROP TABLE IF EXISTS `account_type`;
CREATE TABLE `account_type`  (
  `account_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_opening_balance` tinyint(1) NULL DEFAULT NULL,
  `account_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_type_id`) USING BTREE,
  INDEX `idfk_account_category_id`(`account_category_id`) USING BTREE,
  CONSTRAINT `idfk_account_category_id` FOREIGN KEY (`account_category_id`) REFERENCES `account_category` (`account_category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of account_type
-- ----------------------------
INSERT INTO `account_type` VALUES (1, 'cash accounts', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (2, 'bank accounts', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (3, 'accounts receivable (A/R)', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (4, 'undeposited funds', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (5, 'accounts payable (A/P)', 1, 2, NULL, NULL);
INSERT INTO `account_type` VALUES (6, 'credit cards', 1, 2, NULL, NULL);
INSERT INTO `account_type` VALUES (7, 'current liabilities', 1, 2, NULL, NULL);
INSERT INTO `account_type` VALUES (8, 'non-current liabilities', 1, 2, NULL, NULL);
INSERT INTO `account_type` VALUES (9, 'current assets', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (10, 'fixed assets', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (11, 'non-current assets', 1, 1, NULL, NULL);
INSERT INTO `account_type` VALUES (12, 'owner\'s equity', 0, 3, NULL, NULL);
INSERT INTO `account_type` VALUES (13, 'income', 0, 4, NULL, NULL);
INSERT INTO `account_type` VALUES (14, 'other income', 0, 4, NULL, NULL);
INSERT INTO `account_type` VALUES (15, 'cost of sales', 0, 5, NULL, NULL);
INSERT INTO `account_type` VALUES (16, 'expenses', 0, 5, NULL, NULL);
INSERT INTO `account_type` VALUES (17, 'other expenses', 0, 5, NULL, NULL);

-- ----------------------------
-- Table structure for accounting
-- ----------------------------
DROP TABLE IF EXISTS `accounting`;
CREATE TABLE `accounting`  (
  `accounting_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `start_date` date NULL DEFAULT NULL,
  `end_date` date NULL DEFAULT NULL,
  `method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`accounting_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of accounting
-- ----------------------------
INSERT INTO `accounting` VALUES (1, '2022-05-10', '2022-06-30', 'cash', NULL, '2022-05-10 02:54:37', '2022-05-10 02:54:37');

-- ----------------------------
-- Table structure for bill
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill`  (
  `bill_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `bill_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `bill_date` date NULL DEFAULT NULL,
  `due_date` date NULL DEFAULT NULL,
  `payee_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payee` int(10) UNSIGNED NULL DEFAULT NULL,
  `total_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `term_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `account_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `to_increase` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`bill_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of bill
-- ----------------------------
INSERT INTO `bill` VALUES (2, 98, '1001', '2021-11-24', '2021-11-24', 'supplier', 2, '5000', 1, 3, 'credit');
INSERT INTO `bill` VALUES (3, 99, '1001', '2022-01-11', '2022-01-11', 'supplier', 2, '500', NULL, 3, 'credit');

-- ----------------------------
-- Table structure for chart_of_accounts
-- ----------------------------
DROP TABLE IF EXISTS `chart_of_accounts`;
CREATE TABLE `chart_of_accounts`  (
  `account_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `account_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_description` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `parent_account` int(10) UNSIGNED NULL DEFAULT NULL,
  `statement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `account_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_id`) USING BTREE,
  UNIQUE INDEX `account`(`account_number`, `account_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of chart_of_accounts
-- ----------------------------
INSERT INTO `chart_of_accounts` VALUES (1, NULL, 'Cash on hand', NULL, NULL, NULL, 'inactive', 1, '2021-09-14 04:20:51', '2022-04-25 08:40:28');
INSERT INTO `chart_of_accounts` VALUES (2, NULL, 'Accounts Receivable (A/R)', NULL, NULL, 'investing', 'active', 3, '2021-09-14 06:27:14', '2021-09-14 06:27:14');
INSERT INTO `chart_of_accounts` VALUES (3, NULL, 'Accounts Payable (A/P)', NULL, NULL, NULL, 'active', 5, '2021-09-15 05:23:57', '2021-09-15 05:23:57');
INSERT INTO `chart_of_accounts` VALUES (4, NULL, 'Prepaid expenses', 'This is a description', NULL, 'investing', 'active', 9, '2021-09-16 07:31:55', '2021-09-16 07:31:55');
INSERT INTO `chart_of_accounts` VALUES (5, NULL, 'Office expenses', NULL, NULL, NULL, 'active', 16, '2021-09-16 08:51:59', '2021-09-17 01:59:20');
INSERT INTO `chart_of_accounts` VALUES (6, NULL, 'Petty cash', NULL, 1, 'operating', 'active', 1, '2021-09-16 08:57:36', '2021-09-17 01:59:04');
INSERT INTO `chart_of_accounts` VALUES (7, NULL, 'Cost of sales', NULL, NULL, NULL, 'active', 15, '2021-09-16 13:04:56', '2021-09-16 13:04:56');
INSERT INTO `chart_of_accounts` VALUES (8, NULL, 'Sales', NULL, NULL, NULL, 'active', 13, '2021-10-06 04:54:15', '2021-10-06 04:54:15');
INSERT INTO `chart_of_accounts` VALUES (9, NULL, 'Retained Earnings', NULL, NULL, 'investing', 'active', 12, '2021-10-22 01:00:43', '2021-10-22 01:00:57');
INSERT INTO `chart_of_accounts` VALUES (10, 'sss', 'sss', 'ss', 2, NULL, 'active', 12, '2022-04-25 08:39:34', '2022-04-25 08:39:34');
INSERT INTO `chart_of_accounts` VALUES (11, '2000', 'Time Deposit', 'vnbvnbvn', NULL, NULL, 'active', 7, '2022-05-13 02:40:22', '2022-05-13 02:40:22');
INSERT INTO `chart_of_accounts` VALUES (12, '2015', 'Notarial Payable', 'Notarial', NULL, NULL, 'active', 7, '2022-05-13 02:49:33', '2022-05-13 02:49:33');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `company_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES (1, 'Engtech Global Solutions Inc.', '', 'pedales.rustom@gmail.com', '+639631433932', NULL, NULL, '2022-04-25 07:05:30');

-- ----------------------------
-- Table structure for company_address
-- ----------------------------
DROP TABLE IF EXISTS `company_address`;
CREATE TABLE `company_address`  (
  `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `zip_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`) USING BTREE,
  INDEX `company_address_company_id_foreign`(`company_id`) USING BTREE,
  CONSTRAINT `company_address_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `company` (`company_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of company_address
-- ----------------------------
INSERT INTO `company_address` VALUES (1, 'P5B Silad Mahogany\r\nHDS Building 999 JC Aquino St.', 'Butuan City', 'Butuan City', '8600', 'Philippines', 1, '2022-04-25 07:05:30', '2022-04-25 07:05:30');

-- ----------------------------
-- Table structure for currency
-- ----------------------------
DROP TABLE IF EXISTS `currency`;
CREATE TABLE `currency`  (
  `currency_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `abbreviation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`currency_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of currency
-- ----------------------------

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `customer_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `firstname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `middlename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lastname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `suffix` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `displayname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mobile_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tin_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, NULL, NULL, NULL, NULL, NULL, 'gian anduyan', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `customer` VALUES (2, NULL, NULL, NULL, NULL, NULL, 'rustom pedales', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for customer_address
-- ----------------------------
DROP TABLE IF EXISTS `customer_address`;
CREATE TABLE `customer_address`  (
  `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `address_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zip_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`) USING BTREE,
  INDEX `customer_address_customer_id_foreign`(`customer_id`) USING BTREE,
  CONSTRAINT `customer_address_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer_address
-- ----------------------------

-- ----------------------------
-- Table structure for employee_addresses
-- ----------------------------
DROP TABLE IF EXISTS `employee_addresses`;
CREATE TABLE `employee_addresses`  (
  `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `zip_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`) USING BTREE,
  INDEX `employee_addresses_employee_id_foreign`(`employee_id`) USING BTREE,
  CONSTRAINT `employee_addresses_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of employee_addresses
-- ----------------------------
INSERT INTO `employee_addresses` VALUES (1, 'street', 'city', 'province', '8600', NULL, NULL, 1, NULL, NULL);

-- ----------------------------
-- Table structure for employees
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees`  (
  `employee_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `employee_id_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `firstname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `middlename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lastname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `displayname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mobile_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `birth_date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`employee_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of employees
-- ----------------------------
INSERT INTO `employees` VALUES (1, '1', 'lenoardo', NULL, 'empuesto', NULL, 'leonardo', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for expense
-- ----------------------------
DROP TABLE IF EXISTS `expense`;
CREATE TABLE `expense`  (
  `expense_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `payment_method_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `payment_date` datetime NULL DEFAULT NULL,
  `reference_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payee` int(10) UNSIGNED NULL DEFAULT NULL,
  `payee_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'customer, employee, supplier',
  `total_amount` double(10, 2) NULL DEFAULT NULL,
  `account_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `to_increase` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`expense_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of expense
-- ----------------------------
INSERT INTO `expense` VALUES (2, 97, 1, '2021-11-21 00:00:00', '125003625', 3, 'supplier', 3000.00, 1, 'credit');
INSERT INTO `expense` VALUES (3, 100, 1, '2022-01-11 00:00:00', '1003', 2, 'supplier', 6000.00, 1, 'credit');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `invoice_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `invoice_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `invoice_date` date NULL DEFAULT NULL,
  `due_date` date NULL DEFAULT NULL,
  `term_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `total_amount` double(10, 2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`invoice_id`) USING BTREE,
  UNIQUE INDEX `invoice_invoice_no_unique`(`invoice_no`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of invoice
-- ----------------------------
INSERT INTO `invoice` VALUES (1, 101, '3423', '2022-01-11', '2022-01-11', 2, 2, 25000.00, '2022-01-11 03:24:35', '2022-01-11 03:24:35');
INSERT INTO `invoice` VALUES (2, 102, '2620', '2022-01-11', '2022-01-11', 2, 2, 50000.00, '2022-01-11 03:25:05', '2022-01-11 03:25:05');

-- ----------------------------
-- Table structure for item_details
-- ----------------------------
DROP TABLE IF EXISTS `item_details`;
CREATE TABLE `item_details`  (
  `item_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item_id` int(11) UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `rate` double(11, 2) NULL DEFAULT NULL,
  `amount` double(11, 2) NULL DEFAULT NULL,
  `transaction_id` int(11) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`item_details_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of item_details
-- ----------------------------
INSERT INTO `item_details` VALUES (16, 1, 'description 1', 3, 500.00, 1500.00, 90);
INSERT INTO `item_details` VALUES (17, 2, '', 1, 25000.00, 25000.00, 91);
INSERT INTO `item_details` VALUES (18, 2, 'desc 1', 1, 25000.00, 25000.00, 101);
INSERT INTO `item_details` VALUES (19, 2, '', 2, 25000.00, 50000.00, 102);

-- ----------------------------
-- Table structure for journal_book
-- ----------------------------
DROP TABLE IF EXISTS `journal_book`;
CREATE TABLE `journal_book`  (
  `book_id` int(11) NOT NULL AUTO_INCREMENT,
  `book_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_src` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_ref` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_head` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `book_flag` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`book_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of journal_book
-- ----------------------------

-- ----------------------------
-- Table structure for journal_entry
-- ----------------------------
DROP TABLE IF EXISTS `journal_entry`;
CREATE TABLE `journal_entry`  (
  `journal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `journal_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`journal_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of journal_entry
-- ----------------------------

-- ----------------------------
-- Table structure for journal_entry_details
-- ----------------------------
DROP TABLE IF EXISTS `journal_entry_details`;
CREATE TABLE `journal_entry_details`  (
  `journal_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `subsidiary_id` int(11) NULL DEFAULT NULL,
  `subsidiary_category_id` int(11) NULL DEFAULT NULL,
  `journal_book_id` int(11) NULL DEFAULT NULL,
  `journal_details_account_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_debit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_credit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_ref_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`journal_details_id`) USING BTREE,
  INDEX `journal_book_id`(`journal_book_id`) USING BTREE,
  INDEX `journal_subsidiary_id`(`subsidiary_id`) USING BTREE,
  INDEX `subsidiary_category_id`(`subsidiary_category_id`) USING BTREE,
  CONSTRAINT `journal_entry_details_ibfk_1` FOREIGN KEY (`journal_book_id`) REFERENCES `journal_book` (`book_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `journal_entry_details_ibfk_2` FOREIGN KEY (`subsidiary_id`) REFERENCES `subsidiary` (`sub_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `journal_entry_details_ibfk_3` FOREIGN KEY (`subsidiary_category_id`) REFERENCES `subsidiary_category` (`sub_cat_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of journal_entry_details
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 31 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (6, '2021_09_08_075402_create_account_category_table', 2);
INSERT INTO `migrations` VALUES (7, '2021_09_08_075951_create_account_type_table', 2);
INSERT INTO `migrations` VALUES (8, '2021_09_08_080235_create_chart_of_accounts_table', 3);
INSERT INTO `migrations` VALUES (10, '2021_09_14_022732_create_opening_balance_table', 4);
INSERT INTO `migrations` VALUES (11, '2021_09_14_214016_create_customers_table', 5);
INSERT INTO `migrations` VALUES (12, '2021_09_14_215318_create_customer_adresses_table', 5);
INSERT INTO `migrations` VALUES (13, '2021_09_14_222917_create_products_services_table', 5);
INSERT INTO `migrations` VALUES (14, '2021_09_15_022324_create_employees_table', 5);
INSERT INTO `migrations` VALUES (15, '2021_09_15_031236_create_employee_addresses_table', 5);
INSERT INTO `migrations` VALUES (16, '2021_09_24_052408_create_supplier_table', 5);
INSERT INTO `migrations` VALUES (17, '2021_09_24_052457_create_supplier_address_table', 5);
INSERT INTO `migrations` VALUES (20, '2021_10_08_023435_create_products_and_services_table', 6);
INSERT INTO `migrations` VALUES (21, '2021_10_12_031719_create_invoice_table', 7);
INSERT INTO `migrations` VALUES (22, '2021_10_01_033025_create_item_details_table', 8);
INSERT INTO `migrations` VALUES (25, '2021_10_22_070317_create_companies_table', 9);
INSERT INTO `migrations` VALUES (26, '2021_10_22_071645_create_company_addresses_table', 9);
INSERT INTO `migrations` VALUES (27, '2021_10_28_020722_create_accountings_table', 9);
INSERT INTO `migrations` VALUES (28, '2021_10_28_020929_create_currencies_table', 9);
INSERT INTO `migrations` VALUES (29, '2021_11_15_013953_create_products_services_categories_table', 10);
INSERT INTO `migrations` VALUES (30, '2022_01_04_022349_create_reports', 11);

-- ----------------------------
-- Table structure for opening_balance
-- ----------------------------
DROP TABLE IF EXISTS `opening_balance`;
CREATE TABLE `opening_balance`  (
  `opening_balance_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `opening_balance` double(11, 2) NOT NULL,
  `starting_date` datetime NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `accounting_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`opening_balance_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of opening_balance
-- ----------------------------

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  INDEX `password_resets_email_index`(`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `payment_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_method_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `payment_date` date NULL DEFAULT NULL,
  `reference_no` varbinary(191) NULL DEFAULT NULL,
  `amount` double(10, 2) NULL DEFAULT NULL,
  `transaction` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `reference_id` varbinary(191) NULL DEFAULT NULL,
  `transaction_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`payment_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment
-- ----------------------------
INSERT INTO `payment` VALUES (1, 1, '2022-01-11', NULL, 25000.00, 'invoice', 0x31, 103);

-- ----------------------------
-- Table structure for payment_method
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method`  (
  `payment_method_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES (1, 'cash');
INSERT INTO `payment_method` VALUES (2, 'check');

-- ----------------------------
-- Table structure for payment_terms
-- ----------------------------
DROP TABLE IF EXISTS `payment_terms`;
CREATE TABLE `payment_terms`  (
  `term_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `term` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `no_of_days` int(5) NULL DEFAULT NULL,
  PRIMARY KEY (`term_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of payment_terms
-- ----------------------------
INSERT INTO `payment_terms` VALUES (1, 'NET 15', 15);
INSERT INTO `payment_terms` VALUES (2, 'NET 30', 30);

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token`) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_info
-- ----------------------------
DROP TABLE IF EXISTS `personal_info`;
CREATE TABLE `personal_info`  (
  `personal_info_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `lname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `displayname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone_number` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`personal_info_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_info
-- ----------------------------
INSERT INTO `personal_info` VALUES (1, 'Rustom', 'ramos', 'pedales', 'male', 'tom', 'pedales.rustom@gmail.com', '+639631433932', '2022-04-24 13:51:31', '2022-05-06 05:48:15');
INSERT INTO `personal_info` VALUES (2, 'Zetro', 'Armado', 'Patenio', 'male', 'zet', 'zet@gmail.com', '193399221', '2022-04-24 13:51:31', '2022-05-13 01:50:03');
INSERT INTO `personal_info` VALUES (9, 'Rustom', 'sss', 'ss', 'male', 'tomss', 'pedales.rustom@gmail.com', '6544', '2022-05-06 05:15:40', '2022-05-06 07:14:42');

-- ----------------------------
-- Table structure for products_and_services
-- ----------------------------
DROP TABLE IF EXISTS `products_and_services`;
CREATE TABLE `products_and_services`  (
  `item_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `sku` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `qty_on_hand` int(11) NULL DEFAULT NULL,
  `reorder_point` int(11) NULL DEFAULT NULL,
  `rate` double(10, 2) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `image_path` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `income_account` int(10) UNSIGNED NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`) USING BTREE,
  UNIQUE INDEX `products_and_services_name_unique`(`name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products_and_services
-- ----------------------------
INSERT INTO `products_and_services` VALUES (1, 'tutorial', 'service', NULL, NULL, NULL, 500.00, NULL, NULL, 8, NULL, NULL);
INSERT INTO `products_and_services` VALUES (2, 'laptop', 'inventory', NULL, NULL, NULL, 25000.00, NULL, NULL, 8, NULL, NULL);

-- ----------------------------
-- Table structure for products_services_category
-- ----------------------------
DROP TABLE IF EXISTS `products_services_category`;
CREATE TABLE `products_services_category`  (
  `ps_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ps_category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products_services_category
-- ----------------------------

-- ----------------------------
-- Table structure for reports
-- ----------------------------
DROP TABLE IF EXISTS `reports`;
CREATE TABLE `reports`  (
  `report_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`report_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of reports
-- ----------------------------
INSERT INTO `reports` VALUES (1, 'standard', 'General Ledger', 'general_ledger', NULL, NULL);
INSERT INTO `reports` VALUES (2, 'standard', 'Balance Sheet', 'balance_sheet', NULL, NULL);
INSERT INTO `reports` VALUES (3, 'standard', 'Journal', 'journal', NULL, NULL);
INSERT INTO `reports` VALUES (4, 'standard', 'Profit and Loss', 'profit_and_loss', NULL, NULL);
INSERT INTO `reports` VALUES (5, 'standard', 'Trial Balance', 'trial_balance', NULL, NULL);

-- ----------------------------
-- Table structure for sub_module_lists
-- ----------------------------
DROP TABLE IF EXISTS `sub_module_lists`;
CREATE TABLE `sub_module_lists`  (
  `sml_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `al_id` int(10) UNSIGNED NOT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sml_id`) USING BTREE,
  INDEX `sub_module_lists_al_id_foreign`(`al_id`) USING BTREE,
  CONSTRAINT `sub_module_lists_ibfk_1` FOREIGN KEY (`al_id`) REFERENCES `access_lists` (`al_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 198 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of sub_module_lists
-- ----------------------------
INSERT INTO `sub_module_lists` VALUES (122, 6, 'login', 'System Login', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (123, 6, 'logout', 'System Logout', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (124, 6, 'authenticate', 'System Authentication', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (125, 8, 'accounts', 'Chart of Accounts Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (126, 8, 'accounts/create', 'Chart of Accounts (Create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (127, 8, 'accounts-datatable', 'Chart of Accounts (Datatable)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (128, 8, 'set-status', 'Chart of Accounts (Set Status)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (129, 1, 'sales/customers', 'Sales - Customer Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (130, 1, 'sales/customer/create', 'Sales - Customer (create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (131, 1, 'sales/customer/store', 'Sales - Customer (store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (132, 1, 'sales/customer/update', 'Sales - Customer (update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (133, 1, 'customer-datatable', 'Sales - Customer (datatable)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (134, 3, 'employees', 'employees Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (135, 3, 'employees-datatable', 'employees-datatable', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (136, 3, 'employee/create', 'employees (Datatable)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (137, 3, 'employee/store', 'employees (Store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (138, 3, 'employee/update', 'employees (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (139, 1, 'products_and_services', 'Products and Services ', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (140, 1, 'products_and_services/fetch', 'Products and Services  (fetch)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (141, 1, 'product/create', 'Products and Services (Create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (142, 1, 'product/store', 'Products and Services (Store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (143, 1, 'product/update', 'Products and Services (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (144, 1, 'product/category/create', 'Product Category (Create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (145, 1, 'product/categories/fetch', 'Product Category (fetch)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (146, 1, 'product/category/store', 'Product Category (store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (147, 1, 'product/category/delete', 'Product Category (delete)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (148, 1, 'product/category/update', 'Product Category (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (149, 1, 'service/update', 'Service (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (150, 1, 'service/create', 'Service (Create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (151, 1, 'service/store', 'Service (Store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (152, 2, 'expenses', 'Expenses Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (153, 2, 'expenses/store', 'Expense (Store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (154, 2, 'expenses/void', 'Expense (Void)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (155, 2, 'expense-datatable', 'Expense (DataTable)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (156, 5, 'systemSetup', 'System Setup', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (157, 5, 'systemSetup/general/company/update', 'Company Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (158, 5, 'systemSetup/general/accounting/update', 'Accounting Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (159, 5, 'systemSetup/general/currency/update', 'Currency Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (160, 1, 'supplier', 'Supplier Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (161, 1, 'supplier/create', 'Supplier (Create)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (162, 1, 'supplier-datatable', 'Supplier (Datatables)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (163, 1, 'sales', 'Sales Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (164, 1, 'sales/store', 'Sales (store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (165, 1, 'sales-datatable', 'Sales (Datatables)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (166, 1, 'getsales', 'Sales (Fetch)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (167, 1, 'sales/invoice', 'Sales (Invoice)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (168, 1, 'payment/store', 'Payment (Store)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (169, 1, 'journal', 'Journal Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (170, 1, 'user/profile', 'User Profile Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (171, 1, 'user/profile/username/update', 'Username (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (172, 1, 'user/profile/password/update', 'Password (Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (174, 7, 'dashboard', 'Dashboard Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (175, 5, 'companySettings', 'Company Settings (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (178, 5, 'JournalBook', 'JournalBook (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (179, 5, 'UserMasterFile', 'UserMasterFile (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (180, 5, 'accounting', 'accounting (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (181, 5, 'currency', 'currency (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (182, 1, 'sales/customer', 'Sales (customer)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (187, 5, 'systemSetup/general/userMasterFile/createOrUpdate', 'User Master FIle (Create or Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (189, 5, 'systemSetup/general/usermasterfile/searchAccount', 'User Master File (Search Account)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (191, 5, 'systemSetup/general/usermasterfile/fetchInfo', 'User Master File (Fetch Information)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (193, 5, 'systemSetup/general/usermasterfile/createOrUpdateAccessibility', 'User Master File ( Update Accessibility)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (195, 5, 'systemSetup/general/usermasterfile/createOrUpdate', 'User Master File ( Create User or Update User)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (197, 5, 'CategoryFile', 'Category File (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');

-- ----------------------------
-- Table structure for subsidiary
-- ----------------------------
DROP TABLE IF EXISTS `subsidiary`;
CREATE TABLE `subsidiary`  (
  `sub_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_id` int(11) NULL DEFAULT NULL,
  `sub_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_tel` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_acct_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_per_branch` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_date` date NULL DEFAULT NULL,
  `sub_amount` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_no_depre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_no_amort` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_salvage` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_date_post` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sub_id`) USING BTREE,
  INDEX `sub_cat_id`(`sub_cat_id`) USING BTREE,
  CONSTRAINT `subsidiary_ibfk_1` FOREIGN KEY (`sub_cat_id`) REFERENCES `subsidiary_category` (`sub_cat_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subsidiary
-- ----------------------------

-- ----------------------------
-- Table structure for subsidiary_category
-- ----------------------------
DROP TABLE IF EXISTS `subsidiary_category`;
CREATE TABLE `subsidiary_category`  (
  `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_cat_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `create_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sub_cat_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subsidiary_category
-- ----------------------------

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `supplier_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `firstname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `middlename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `lastname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `suffix` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `displayname` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `mobile_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `tin_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`supplier_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, NULL, 'rustom', NULL, 'pedales', NULL, 'rustom pedales', NULL, NULL, NULL, 'data trend', NULL, NULL, NULL);
INSERT INTO `supplier` VALUES (2, NULL, 'leonardo', NULL, 'empuesto', 'jr', 'lenardo empuesto', NULL, NULL, NULL, NULL, NULL, '2021-10-01 03:09:16', '2021-10-01 05:07:46');
INSERT INTO `supplier` VALUES (3, 'mr', 'nino', NULL, 'jabagat', NULL, 'nino jabagat', NULL, NULL, NULL, 'aclc', NULL, '2021-10-01 03:14:14', '2021-10-01 05:10:16');

-- ----------------------------
-- Table structure for supplier_address
-- ----------------------------
DROP TABLE IF EXISTS `supplier_address`;
CREATE TABLE `supplier_address`  (
  `address_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `province` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `zip_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`address_id`) USING BTREE,
  INDEX `supplier_address_supplier_id_foreign`(`supplier_id`) USING BTREE,
  CONSTRAINT `supplier_address_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of supplier_address
-- ----------------------------
INSERT INTO `supplier_address` VALUES (1, NULL, 'butuan', 'agusan del norte', '8600', 'philippines', 1, NULL, NULL);
INSERT INTO `supplier_address` VALUES (2, 'street', 'butuan', NULL, '8600', 'philippines', 2, '2021-10-01 12:17:13', '2021-10-01 05:07:46');
INSERT INTO `supplier_address` VALUES (3, NULL, 'butuan', NULL, NULL, NULL, 3, '2021-10-01 12:17:16', '2021-10-01 05:10:16');

-- ----------------------------
-- Table structure for transaction_category
-- ----------------------------
DROP TABLE IF EXISTS `transaction_category`;
CREATE TABLE `transaction_category`  (
  `transaction_category_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaction_category
-- ----------------------------
INSERT INTO `transaction_category` VALUES (1, 'sales');
INSERT INTO `transaction_category` VALUES (2, 'expenses');
INSERT INTO `transaction_category` VALUES (3, 'journal');

-- ----------------------------
-- Table structure for transaction_details
-- ----------------------------
DROP TABLE IF EXISTS `transaction_details`;
CREATE TABLE `transaction_details`  (
  `transaction_details_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `amount` double(10, 2) NULL DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `person` int(10) UNSIGNED NULL DEFAULT NULL,
  `person_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `to_increase` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_details_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 116 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaction_details
-- ----------------------------
INSERT INTO `transaction_details` VALUES (106, 5, 97, 3000.00, '', NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (107, 5, 98, 5000.00, '1212', NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (108, 5, 99, 500.00, 'qwdqw', NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (109, 7, 100, 6000.00, 'qwdq', NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (110, 2, 101, 25000.00, NULL, NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (111, 8, 101, 25000.00, NULL, NULL, NULL, 'credit');
INSERT INTO `transaction_details` VALUES (112, 2, 102, 50000.00, NULL, NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (113, 8, 102, 50000.00, NULL, NULL, NULL, 'credit');
INSERT INTO `transaction_details` VALUES (114, 1, 103, 25000.00, NULL, NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (115, 2, 103, 25000.00, NULL, NULL, NULL, 'credit');

-- ----------------------------
-- Table structure for transaction_status
-- ----------------------------
DROP TABLE IF EXISTS `transaction_status`;
CREATE TABLE `transaction_status`  (
  `transaction_status_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `default` bit(1) NULL DEFAULT NULL,
  `transaction_type_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_status_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaction_status
-- ----------------------------
INSERT INTO `transaction_status` VALUES (1, 'paid', b'1', 4);
INSERT INTO `transaction_status` VALUES (2, 'open', b'1', 3);
INSERT INTO `transaction_status` VALUES (3, 'overdue', NULL, 3);
INSERT INTO `transaction_status` VALUES (4, 'paid', NULL, 3);
INSERT INTO `transaction_status` VALUES (5, 'open', b'1', 1);
INSERT INTO `transaction_status` VALUES (6, 'overdue', NULL, 1);
INSERT INTO `transaction_status` VALUES (7, 'paid', NULL, 1);
INSERT INTO `transaction_status` VALUES (8, 'closed', b'1', 2);
INSERT INTO `transaction_status` VALUES (9, 'partial', NULL, 2);

-- ----------------------------
-- Table structure for transaction_type
-- ----------------------------
DROP TABLE IF EXISTS `transaction_type`;
CREATE TABLE `transaction_type`  (
  `transaction_type_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `transaction_category_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `visible` bit(1) NULL DEFAULT NULL,
  `account_id` int(10) UNSIGNED NULL DEFAULT NULL COMMENT 'default account for this transaction',
  `counter_account_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transaction_type
-- ----------------------------
INSERT INTO `transaction_type` VALUES (1, 'invoice', 1, b'1', 2, 8);
INSERT INTO `transaction_type` VALUES (2, 'payment', 1, b'1', 2, NULL);
INSERT INTO `transaction_type` VALUES (3, 'bill', 2, b'1', 3, NULL);
INSERT INTO `transaction_type` VALUES (4, 'expense', 2, b'1', NULL, NULL);
INSERT INTO `transaction_type` VALUES (5, 'bill (payment)', 2, b'0', 3, NULL);
INSERT INTO `transaction_type` VALUES (6, 'journal', 3, b'1', NULL, NULL);

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `transaction_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaction_type_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `attachments` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `transaction_date` date NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(10) UNSIGNED NULL DEFAULT NULL,
  `updated_by` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`transaction_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 104 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (97, 4, 'note', NULL, 'void', '2021-11-23', '2021-11-23 01:37:27', '2021-11-25 03:21:09', 1, NULL);
INSERT INTO `transactions` VALUES (98, 3, 'note 1001', NULL, 'open', '2021-11-24', '2021-11-24 06:15:33', '2021-11-24 06:15:33', 1, NULL);
INSERT INTO `transactions` VALUES (99, 3, NULL, NULL, 'open', '2022-01-11', '2022-01-11 03:21:36', '2022-01-11 03:21:36', 1, NULL);
INSERT INTO `transactions` VALUES (100, 4, NULL, NULL, 'paid', '2022-01-11', '2022-01-11 03:24:15', '2022-01-11 03:24:15', 1, NULL);
INSERT INTO `transactions` VALUES (101, 1, NULL, NULL, 'paid', '2022-01-11', '2022-01-11 03:24:35', '2022-01-11 03:25:11', 1, NULL);
INSERT INTO `transactions` VALUES (102, 1, NULL, NULL, 'open', '2022-01-11', '2022-01-11 03:25:05', '2022-01-11 03:25:05', 1, NULL);
INSERT INTO `transactions` VALUES (103, 2, NULL, NULL, 'closed', '2022-01-11', '2022-01-11 03:25:11', '2022-01-11 03:25:11', 1, NULL);

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of user_roles
-- ----------------------------
INSERT INTO `user_roles` VALUES (1, 'system administrator');
INSERT INTO `user_roles` VALUES (2, 'accountant');
INSERT INTO `user_roles` VALUES (3, 'accounting staff');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `personal_info_id` int(10) UNSIGNED NULL DEFAULT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `personal_info_id`(`personal_info_id`) USING BTREE,
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`personal_info_id`) REFERENCES `personal_info` (`personal_info_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 1, 'admin', '$2y$10$MCG/ne93UlRjG9omTjz6RO4/NhuWOGl57wPpWcp7nNMbBxKVzRHA6', 'NysqnywOrZ', 'active', 1, 'nfv4IkK4WzLorIorsfIoJjR4UrY00tWgesTHptUZjwLowzdEl4hjuyPWUCw7', '2021-09-01 11:34:14', '2022-05-06 05:48:15');
INSERT INTO `users` VALUES (2, 2, 'zetadmin', '$2y$10$tksrA1rX7fgWd5O5e88crO/QShQ2Li8HjdkCAg8DNb5v.K97aFfgG', 'NysqnywOrZ', 'active', 1, 'nfv4IkK4WzLorIorsfIoJjR4UrY00tWgesTHptUZjwLowzdEl4hjuyPWUCw7', '2021-09-01 11:34:14', '2022-05-13 01:50:03');
INSERT INTO `users` VALUES (4, 9, 'tomtomy', '$2y$10$eY9r75BVKUxzPQMI5Gs25OfV.VgsBZ6KK.wHvhzpsqZE27bRIdQPm', '$2y$10$sfgoyx/XXm2cEImPekU3KOS5Np8Bw01wJRHoG4i5pu68s.GLKFmkK', 'active', 1, NULL, '2022-05-06 05:15:40', '2022-05-06 07:14:42');

SET FOREIGN_KEY_CHECKS = 1;

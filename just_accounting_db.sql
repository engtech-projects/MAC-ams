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

 Date: 15/08/2022 11:38:26
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
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = COMPACT;

-- ----------------------------
-- Records of access_lists
-- ----------------------------
INSERT INTO `access_lists` VALUES (3, 'Employees', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (4, 'Reports', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (5, 'System Setup', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (6, 'Misc', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (7, 'Dashboard', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (8, 'Chart of Accounts', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (9, 'Journal', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (10, 'sales', '2022-04-10 02:27:25', '2022-04-10 02:27:25');
INSERT INTO `access_lists` VALUES (11, 'Expenses', '2022-04-10 02:27:25', '2022-04-10 02:27:25');

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
  INDEX `user_id`(`user_id`) USING BTREE,
  INDEX `accessibilities_ibfk_1`(`sml_id`) USING BTREE,
  CONSTRAINT `accessibilities_ibfk_1` FOREIGN KEY (`sml_id`) REFERENCES `sub_module_lists` (`sml_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `accessibilities_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 219 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

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
INSERT INTO `accessibilities` VALUES (59, 156, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (60, 157, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (61, 158, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (62, 159, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (80, 175, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (81, 178, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (82, 179, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (83, 180, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (85, 181, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (86, 187, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (87, 189, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
INSERT INTO `accessibilities` VALUES (88, 191, 1, '2022-04-25', '2022-04-25 00:00:00', '2022-04-25 00:00:00');
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
INSERT INTO `accessibilities` VALUES (133, 179, 2, '2022-05-06', '2022-05-06 05:58:55', '2022-05-06 05:58:55');
INSERT INTO `accessibilities` VALUES (134, 187, 2, '2022-05-06', '2022-05-06 05:58:57', '2022-05-06 05:58:57');
INSERT INTO `accessibilities` VALUES (135, 189, 2, '2022-05-06', '2022-05-06 05:59:00', '2022-05-06 05:59:00');
INSERT INTO `accessibilities` VALUES (136, 191, 2, '2022-05-06', '2022-05-06 05:59:01', '2022-05-06 05:59:01');
INSERT INTO `accessibilities` VALUES (137, 193, 2, '2022-05-06', '2022-05-06 05:59:01', '2022-05-06 05:59:01');
INSERT INTO `accessibilities` VALUES (138, 195, 2, '2022-05-06', '2022-05-06 05:59:02', '2022-05-06 05:59:02');
INSERT INTO `accessibilities` VALUES (159, 203, 1, '2022-05-18', '2022-05-18 03:08:00', '2022-05-18 03:08:00');
INSERT INTO `accessibilities` VALUES (160, 204, 1, '2022-05-18', '2022-05-18 03:53:43', '2022-05-18 03:53:43');
INSERT INTO `accessibilities` VALUES (161, 205, 1, '2022-05-18', '2022-05-18 06:02:00', '2022-05-18 06:02:00');
INSERT INTO `accessibilities` VALUES (162, 206, 1, '2022-05-18', '2022-05-18 06:02:01', '2022-05-18 06:02:01');
INSERT INTO `accessibilities` VALUES (163, 207, 1, '2022-05-18', '2022-05-18 06:02:02', '2022-05-18 06:02:02');
INSERT INTO `accessibilities` VALUES (165, 209, 1, '2022-05-20', '2022-05-20 02:09:49', '2022-05-20 02:09:49');
INSERT INTO `accessibilities` VALUES (166, 211, 1, '2022-05-22', '2022-05-22 15:14:56', '2022-05-22 15:14:56');
INSERT INTO `accessibilities` VALUES (167, 212, 1, '2022-05-22', '2022-05-22 15:14:57', '2022-05-22 15:14:57');
INSERT INTO `accessibilities` VALUES (168, 213, 1, '2022-05-22', '2022-05-22 15:14:58', '2022-05-22 15:14:58');
INSERT INTO `accessibilities` VALUES (169, 214, 1, '2022-05-22', '2022-05-22 15:14:59', '2022-05-22 15:14:59');
INSERT INTO `accessibilities` VALUES (170, 215, 1, '2022-05-22', '2022-05-22 15:14:59', '2022-05-22 15:14:59');
INSERT INTO `accessibilities` VALUES (171, 216, 1, '2022-05-22', '2022-05-22 15:32:27', '2022-05-22 15:32:27');
INSERT INTO `accessibilities` VALUES (175, 217, 1, '2022-05-24', '2022-05-24 03:38:06', '2022-05-24 03:38:06');
INSERT INTO `accessibilities` VALUES (176, 219, 1, '2022-05-24', '2022-05-24 03:38:07', '2022-05-24 03:38:07');
INSERT INTO `accessibilities` VALUES (177, 197, 1, '2022-05-24', '2022-05-24 03:40:01', '2022-05-24 03:40:01');
INSERT INTO `accessibilities` VALUES (178, 220, 1, '2022-05-25', '2022-05-25 07:48:20', '2022-05-25 07:48:20');
INSERT INTO `accessibilities` VALUES (179, 221, 1, '2022-05-25', '2022-05-25 07:48:21', '2022-05-25 07:48:21');
INSERT INTO `accessibilities` VALUES (180, 223, 1, '2022-05-31', '2022-05-31 06:36:24', '2022-05-31 06:36:24');
INSERT INTO `accessibilities` VALUES (181, 225, 1, '2022-06-01', '2022-06-01 05:57:06', '2022-06-01 05:57:06');
INSERT INTO `accessibilities` VALUES (182, 226, 1, '2022-06-01', '2022-06-01 05:57:07', '2022-06-01 05:57:07');
INSERT INTO `accessibilities` VALUES (183, 227, 1, '2022-06-01', '2022-06-01 06:50:59', '2022-06-01 06:50:59');
INSERT INTO `accessibilities` VALUES (184, 228, 1, '2022-06-01', '2022-06-01 06:51:00', '2022-06-01 06:51:00');
INSERT INTO `accessibilities` VALUES (189, 202, 1, '2022-06-02', '2022-06-02 06:09:37', '2022-06-02 06:09:37');
INSERT INTO `accessibilities` VALUES (190, 201, 1, '2022-06-02', '2022-06-02 06:10:05', '2022-06-02 06:10:05');
INSERT INTO `accessibilities` VALUES (191, 195, 1, '2022-06-02', '2022-06-02 06:11:36', '2022-06-02 06:11:36');
INSERT INTO `accessibilities` VALUES (192, 193, 1, '2022-06-02', '2022-06-02 06:12:14', '2022-06-02 06:12:14');
INSERT INTO `accessibilities` VALUES (193, 174, 1, '2022-06-02', '2022-06-02 06:12:20', '2022-06-02 06:12:20');
INSERT INTO `accessibilities` VALUES (194, 232, 1, '2022-06-02', '2022-06-02 06:17:06', '2022-06-02 06:17:06');
INSERT INTO `accessibilities` VALUES (195, 234, 1, '2022-06-02', '2022-06-02 08:17:45', '2022-06-02 08:17:45');
INSERT INTO `accessibilities` VALUES (196, 235, 1, '2022-06-02', '2022-06-02 08:17:45', '2022-06-02 08:17:45');
INSERT INTO `accessibilities` VALUES (197, 236, 1, '2022-06-02', '2022-06-02 08:17:46', '2022-06-02 08:17:46');
INSERT INTO `accessibilities` VALUES (198, 237, 1, '2022-06-02', '2022-06-02 08:17:47', '2022-06-02 08:17:47');
INSERT INTO `accessibilities` VALUES (199, 238, 1, '2022-06-02', '2022-06-02 08:17:48', '2022-06-02 08:17:48');
INSERT INTO `accessibilities` VALUES (200, 239, 1, '2022-06-02', '2022-06-02 08:20:40', '2022-06-02 08:20:40');
INSERT INTO `accessibilities` VALUES (201, 240, 1, '2022-06-02', '2022-06-02 08:22:42', '2022-06-02 08:22:42');
INSERT INTO `accessibilities` VALUES (202, 241, 1, '2022-06-02', '2022-06-02 08:22:43', '2022-06-02 08:22:43');
INSERT INTO `accessibilities` VALUES (203, 242, 1, '2022-06-02', '2022-06-02 08:22:43', '2022-06-02 08:22:43');
INSERT INTO `accessibilities` VALUES (204, 244, 1, '2022-06-02', '2022-06-02 08:22:44', '2022-06-02 08:22:44');
INSERT INTO `accessibilities` VALUES (205, 245, 1, '2022-06-02', '2022-06-02 08:22:45', '2022-06-02 08:22:45');
INSERT INTO `accessibilities` VALUES (206, 246, 1, '2022-06-02', '2022-06-02 08:22:46', '2022-06-02 08:22:46');
INSERT INTO `accessibilities` VALUES (207, 247, 1, '2022-06-02', '2022-06-02 08:22:47', '2022-06-02 08:22:47');
INSERT INTO `accessibilities` VALUES (208, 248, 1, '2022-06-02', '2022-06-02 08:26:24', '2022-06-02 08:26:24');
INSERT INTO `accessibilities` VALUES (209, 250, 1, '2022-06-02', '2022-06-02 08:27:43', '2022-06-02 08:27:43');
INSERT INTO `accessibilities` VALUES (210, 255, 1, '2022-06-06', '2022-06-06 02:22:40', '2022-06-06 02:22:40');
INSERT INTO `accessibilities` VALUES (211, 256, 1, '2022-06-06', '2022-06-06 02:22:41', '2022-06-06 02:22:41');
INSERT INTO `accessibilities` VALUES (212, 259, 1, '2022-06-06', '2022-06-06 03:53:24', '2022-06-06 03:53:24');
INSERT INTO `accessibilities` VALUES (213, 260, 1, '2022-06-13', '2022-06-13 03:00:57', '2022-06-13 03:00:57');
INSERT INTO `accessibilities` VALUES (214, 262, 1, '2022-06-13', '2022-06-13 03:00:57', '2022-06-13 03:00:57');
INSERT INTO `accessibilities` VALUES (215, 263, 1, '2022-06-22', '2022-06-22 03:14:51', '2022-06-22 03:14:51');
INSERT INTO `accessibilities` VALUES (216, 265, 1, '2022-06-24', '2022-06-24 05:49:38', '2022-06-24 05:49:38');
INSERT INTO `accessibilities` VALUES (217, 208, 1, '2022-07-15', '2022-07-15 06:28:37', '2022-07-15 06:28:37');
INSERT INTO `accessibilities` VALUES (218, 267, 1, '2022-07-21', '2022-07-21 02:45:51', '2022-07-21 02:45:51');

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
  `account_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `account_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `has_opening_balance` tinyint(1) NULL DEFAULT NULL,
  `account_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_type_id`) USING BTREE,
  INDEX `idfk_account_category_id`(`account_category_id`) USING BTREE,
  CONSTRAINT `idfk_account_category_id` FOREIGN KEY (`account_category_id`) REFERENCES `account_category` (`account_category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of account_type
-- ----------------------------
INSERT INTO `account_type` VALUES (1, '1000 ', 'CURRENT ASSETS', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (2, '1005', 'CASH AND CASH EQUIVALENTS', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (3, '1200', 'LOANS AND RECEIVABLES', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (4, '1349', 'OTHER ASSETS', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (5, '1500', 'NON-CURRENT ASSETS', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (6, '1505', 'PROPERTY PLANT AND EQUIPMENT', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (20, '1800', 'OTHER NON-CURRENT ASSETS', 0, 1, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (21, '2000', 'CURRENT LIABILITIES', 0, 2, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (22, '2600', 'NON-CURRENT LIABILITIES', 0, 2, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (23, '2700', 'OTHER NON-CURRENT LIABILITIES', 0, 2, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (24, '3000', 'STOCKHOLDER\'S EQUITY', 0, 3, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (25, '3005', 'CAPITAL STOCK - COMMON', 0, 3, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (26, ' 4000', 'INCOME FROM LENDING OPERATION', 0, 4, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (27, '4500', 'OTHER INCOME', 0, 4, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (28, '4550', 'COMMISSION INCOME', 0, 4, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (29, '5100', 'ADMINISTRATRIVE COST', 0, 5, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (32, '5170', 'OPERATING EXPENSES', 0, 5, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (33, '5800 ', 'INCOME FROM OPERATIONS', 0, 5, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (34, '5801', 'OTHER ITEMS-SUBSIDY GAIN/LOSSES', 0, 5, '2022-06-01 13:25:17', '2022-06-01 13:25:17');
INSERT INTO `account_type` VALUES (35, '5850 ', 'FINANCING COST', 0, 5, '2022-06-01 13:25:17', '2022-06-01 13:25:17');

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
INSERT INTO `accounting` VALUES (1, '2022-05-10', '2022-06-30', 'accrual', NULL, '2022-05-10 02:54:37', '2022-08-15 03:04:42');

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
  `bank_reconcillation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `statement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `account_type_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`account_id`) USING BTREE,
  UNIQUE INDEX `account`(`account_number`, `account_name`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 418 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of chart_of_accounts
-- ----------------------------
INSERT INTO `chart_of_accounts` VALUES (238, '1010 ', 'Cash on Hand', 'Cash on Hand', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:25:42', '2022-05-25 14:25:42');
INSERT INTO `chart_of_accounts` VALUES (239, '1015', 'Check and Other Cash Items (COCI)', 'Check and Other Cash Items (COCI)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:25:42', '2022-05-25 14:25:42');
INSERT INTO `chart_of_accounts` VALUES (240, '1020 ', 'Petty Cash Fund', 'Petty Cash Fund', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:28:01', '2022-05-25 14:28:01');
INSERT INTO `chart_of_accounts` VALUES (241, '1025', 'Cash in Bank (EWB)', 'Cash in Bank (EWB)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:29:43', '2022-05-25 14:29:43');
INSERT INTO `chart_of_accounts` VALUES (242, '1026', 'Cash in Bank (EWB-EGOV)', 'Cash in Bank (EWB-EGOV)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:31:26', '2022-05-25 14:31:26');
INSERT INTO `chart_of_accounts` VALUES (243, '1030', 'Cash in Bank (EBI-POS)', 'Cash in Bank (EBI-POS)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:32:15', '2022-05-25 14:32:15');
INSERT INTO `chart_of_accounts` VALUES (244, '1035', 'Cash in Bank (EBI-SAVINGS)', 'Cash in Bank (EBI-SAVINGS)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:32:54', '2022-05-25 14:32:54');
INSERT INTO `chart_of_accounts` VALUES (245, '1045', 'Cash in Bank (MYB)', 'Cash in Bank (MYB)', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:33:27', '2022-05-25 14:33:27');
INSERT INTO `chart_of_accounts` VALUES (246, '1050', 'Cash in Bank - Metrobank', 'Cash in Bank - Metrobank', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:37:22', '2022-05-25 14:37:22');
INSERT INTO `chart_of_accounts` VALUES (247, '1055', ' Cash in Bank-One Network Bank', ' Cash in Bank-One Network Bank', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:37:30', '2022-05-25 14:37:30');
INSERT INTO `chart_of_accounts` VALUES (248, '1060', ' Cash in Bank - BDO', ' Cash in Bank - BDO', NULL, 'yes', NULL, 'active', 2, '2022-05-25 14:37:38', '2022-05-25 14:37:38');
INSERT INTO `chart_of_accounts` VALUES (249, '1205 ', 'Loans Receivable - Current', 'Loans Receivable - Current', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:37:45', '2022-05-25 14:37:45');
INSERT INTO `chart_of_accounts` VALUES (250, '1255', 'Loans Receivable - Past Due', 'Loans Receivable - Past Due', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:42:35', '2022-05-25 14:42:35');
INSERT INTO `chart_of_accounts` VALUES (251, '1260', 'Loans Receivable - Restructured', 'Loans Receivable - Restructured', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:45:09', '2022-05-25 14:45:09');
INSERT INTO `chart_of_accounts` VALUES (252, '1265', 'Loans Receivable - Litigation Loans', 'Loans Receivable - Litigation Loans', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:45:35', '2022-05-25 14:45:35');
INSERT INTO `chart_of_accounts` VALUES (253, '1270', 'LaJhggHEdq5yKkPJdBXLMoAubyHwAB4ttD', 'LaJhggHEdq5yKkPJdBXLMoAubyHwAB4ttD', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:45:44', '2022-05-25 14:45:44');
INSERT INTO `chart_of_accounts` VALUES (254, '1300', 'Allowance for Probable Loans Losses', 'Allowance for Probable Loans Losses', NULL, 'yes', NULL, 'active', 3, '2022-05-25 14:45:52', '2022-05-25 14:45:52');
INSERT INTO `chart_of_accounts` VALUES (255, '1350', 'Advances to Officers and Employee', 'Advances to Officers and Employee', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:47:45', '2022-05-25 14:47:45');
INSERT INTO `chart_of_accounts` VALUES (256, '1355', 'Accounts Receivable Litigation', 'Accounts Receivable Litigation', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:01', '2022-05-25 14:52:01');
INSERT INTO `chart_of_accounts` VALUES (257, '1360', 'Other Receibables', 'Other Receibables', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:10', '2022-05-25 14:52:10');
INSERT INTO `chart_of_accounts` VALUES (258, '1406', 'Deffered Tax Asset', 'Deffered Tax Asset', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:17', '2022-05-25 14:52:17');
INSERT INTO `chart_of_accounts` VALUES (259, '1407', 'Deffered Asset', 'Deffered Asset', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:27', '2022-05-25 14:52:27');
INSERT INTO `chart_of_accounts` VALUES (260, '1408', 'Miscellaneous Asset', 'Miscellaneous Asset', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:35', '2022-05-25 14:52:35');
INSERT INTO `chart_of_accounts` VALUES (261, '1409', 'Input Tax', 'Input Tax', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:42', '2022-05-25 14:52:42');
INSERT INTO `chart_of_accounts` VALUES (262, '1410', 'Unused Supplies', 'Unused Supplies', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:52:50', '2022-05-25 14:52:50');
INSERT INTO `chart_of_accounts` VALUES (263, '1415', ' Prepaid Expense', ' Prepaid Expense', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:53:00', '2022-05-25 14:53:00');
INSERT INTO `chart_of_accounts` VALUES (264, '1420', 'Due from/to Nasipit-BXU & Gingoog', 'Due from/to Nasipit-BXU & Gingoog', NULL, 'yes', NULL, 'active', 4, '2022-05-25 14:57:06', '2022-05-25 14:57:06');
INSERT INTO `chart_of_accounts` VALUES (265, '1510', 'Furniture Fixture & Equipment', 'Furniture Fixture & Equipment', NULL, 'yes', NULL, 'active', 6, '2022-05-25 14:57:29', '2022-05-25 14:57:29');
INSERT INTO `chart_of_accounts` VALUES (266, '1515', ' Accumulate Depreciation - FFE', ' Accumulate Depreciation - FFE', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:01:55', '2022-05-25 15:01:55');
INSERT INTO `chart_of_accounts` VALUES (267, '1525', 'Office Equipment', 'Office Equipment', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:08', '2022-05-25 15:02:08');
INSERT INTO `chart_of_accounts` VALUES (268, '1530', 'Accu. Dep. - Office Equipment', 'Accu. Dep. - Office Equipment', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:21', '2022-05-25 15:02:21');
INSERT INTO `chart_of_accounts` VALUES (269, '1540', 'Transportation Equipment', 'Transportation Equipment', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:29', '2022-05-25 15:02:29');
INSERT INTO `chart_of_accounts` VALUES (270, '1545', 'Accu. Dep. - Transportation Equip', 'Accu. Dep. - Transportation Equip', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:36', '2022-05-25 15:02:36');
INSERT INTO `chart_of_accounts` VALUES (271, '1555', 'Leasehold Rights & Improvements', 'Leasehold Rights & Improvements', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:42', '2022-05-25 15:02:42');
INSERT INTO `chart_of_accounts` VALUES (272, '1560', 'Accu. Dep. - Leasehold Rights & Imp', 'Accu. Dep. - Leasehold Rights & Imp', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:49', '2022-05-25 15:02:49');
INSERT INTO `chart_of_accounts` VALUES (273, '1569', ' Other Intangeble Asset', ' Other Intangeble Asset', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:02:59', '2022-05-25 15:02:59');
INSERT INTO `chart_of_accounts` VALUES (274, '1570', 'AYajjmpDLunawN9mRtBUbWAMSNG9on1NRL', 'AYajjmpDLunawN9mRtBUbWAMSNG9on1NRL', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:06:55', '2022-05-25 15:06:55');
INSERT INTO `chart_of_accounts` VALUES (275, '1574', 'Computerization Cost', 'Computerization Cost', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:07:06', '2022-05-25 15:07:06');
INSERT INTO `chart_of_accounts` VALUES (276, '1575', 'Accu. amort-computerization cost', 'Accu. amort-computerization cost', NULL, 'yes', NULL, 'active', 6, '2022-05-25 15:07:12', '2022-05-25 15:07:12');
INSERT INTO `chart_of_accounts` VALUES (277, '1805', 'Organization Cost', 'Organization Cost', NULL, 'yes', NULL, 'active', 20, '2022-05-25 15:07:17', '2022-05-25 15:07:17');
INSERT INTO `chart_of_accounts` VALUES (278, '1810', 'Product/Business Development Cost', 'Product/Business Development Cost', NULL, 'yes', NULL, 'active', 20, '2022-05-25 15:11:55', '2022-05-25 15:11:55');
INSERT INTO `chart_of_accounts` VALUES (279, '1820', 'Other Funds and Deposits', 'Other Funds and Deposits', NULL, 'yes', NULL, 'active', 20, '2022-05-25 15:12:05', '2022-05-25 15:12:05');
INSERT INTO `chart_of_accounts` VALUES (280, '2010', 'Time Deposits', 'Time Deposits', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:14:20', '2022-05-25 15:14:20');
INSERT INTO `chart_of_accounts` VALUES (281, '2015', 'Notarial Payable', 'Notarial Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:20:24', '2022-05-25 15:20:24');
INSERT INTO `chart_of_accounts` VALUES (282, '2020', 'Affidavit - Payable', 'Affidavit - Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:21:11', '2022-05-25 15:21:11');
INSERT INTO `chart_of_accounts` VALUES (283, '2025', 'Accounts Payable - Loan Payment', 'Accounts Payable - Loan Payment', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:21:29', '2022-05-25 15:21:29');
INSERT INTO `chart_of_accounts` VALUES (284, '2026', ' ACCOUNTS PAYABLE - OTHERS', ' ACCOUNTS PAYABLE - OTHERS', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:21:48', '2022-05-25 15:21:48');
INSERT INTO `chart_of_accounts` VALUES (285, '2027', 'ACCOUNTS PAYABLE - STOCKHOLDERS', 'ACCOUNTS PAYABLE - STOCKHOLDERS', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:22:07', '2022-05-25 15:22:07');
INSERT INTO `chart_of_accounts` VALUES (286, '2030', 'Documentary Stamp Tax Payable', 'Documentary Stamp Tax Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:23:33', '2022-05-25 15:23:33');
INSERT INTO `chart_of_accounts` VALUES (287, '2035', ' Due to Regulatory Agencies', ' Due to Regulatory Agencies', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:23:33', '2022-05-25 15:23:33');
INSERT INTO `chart_of_accounts` VALUES (288, '2039', 'Life Insurance Payable', 'Life Insurance Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:24:15', '2022-05-25 15:24:15');
INSERT INTO `chart_of_accounts` VALUES (289, '2040', 'Loan Insurance Payable', 'Loan Insurance Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:24:53', '2022-05-25 15:24:53');
INSERT INTO `chart_of_accounts` VALUES (290, '2041', 'Employees Insurance Payable', 'Employees Insurance Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:25:47', '2022-05-25 15:25:47');
INSERT INTO `chart_of_accounts` VALUES (291, '2045', 'Over Payment', 'Over Payment', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:27:39', '2022-05-25 15:27:39');
INSERT INTO `chart_of_accounts` VALUES (292, '2046', ' Retirement Benefit Payable', ' Retirement Benefit Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:27:59', '2022-05-25 15:27:59');
INSERT INTO `chart_of_accounts` VALUES (293, '2050', 'SSS/HDMF Employees Loans Payable', 'SSS/HDMF Employees Loans Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:28:24', '2022-05-25 15:28:24');
INSERT INTO `chart_of_accounts` VALUES (294, '2055', ' SSS/HDMF/PHIC Empl Contri Payable', ' SSS/HDMF/PHIC Empl Contri Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:28:40', '2022-05-25 15:28:40');
INSERT INTO `chart_of_accounts` VALUES (295, '2060', 'Withholding Tax Payable Expanded', 'Withholding Tax Payable Expanded', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:29:01', '2022-05-25 15:29:01');
INSERT INTO `chart_of_accounts` VALUES (296, '2061', 'Withholding Tax Payble Compensation', 'Withholding Tax Payble Compensation', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:29:56', '2022-05-25 15:29:56');
INSERT INTO `chart_of_accounts` VALUES (297, '2065', 'VAT Payable', 'VAT Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:30:33', '2022-05-25 15:30:33');
INSERT INTO `chart_of_accounts` VALUES (298, '2070', 'Accrued Expenses Payable', 'Accrued Expenses Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:30:48', '2022-05-25 15:30:48');
INSERT INTO `chart_of_accounts` VALUES (299, '2075', ' Income Tax Payable', ' Income Tax Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:31:03', '2022-05-25 15:31:03');
INSERT INTO `chart_of_accounts` VALUES (300, '2076', 'BIR TAX ASSESSMENT PAYABLE', 'BIR TAX ASSESSMENT PAYABLE', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:31:19', '2022-05-25 15:31:19');
INSERT INTO `chart_of_accounts` VALUES (301, '2080', ' Deposit from Clients', ' Deposit from Clients', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:31:30', '2022-05-25 15:31:30');
INSERT INTO `chart_of_accounts` VALUES (302, '2085', 'Accounts Payable Check for Clearing', 'Accounts Payable Check for Clearing', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:31:47', '2022-05-25 15:31:47');
INSERT INTO `chart_of_accounts` VALUES (303, '2090', 'Trust Fund Payable', 'Trust Fund Payable', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:32:02', '2022-05-25 15:32:02');
INSERT INTO `chart_of_accounts` VALUES (304, '2095', 'Employees Trust Fund Contribution', 'Employees Trust Fund Contribution', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:44:37', '2022-05-25 15:44:37');
INSERT INTO `chart_of_accounts` VALUES (305, '2096', 'Employees Trust Fund Loan', 'Employees Trust Fund Loan', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:44:57', '2022-05-25 15:44:57');
INSERT INTO `chart_of_accounts` VALUES (306, '2100', 'Un-earned Interest & Discouts (UID)', 'Un-earned Interest & Discouts (UID)', NULL, 'yes', NULL, 'active', 21, '2022-05-25 15:45:16', '2022-05-25 15:45:16');
INSERT INTO `chart_of_accounts` VALUES (307, '2605', ' Loans Payable', ' Loans Payable', NULL, 'yes', NULL, 'active', 22, '2022-05-25 15:45:26', '2022-05-25 15:45:26');
INSERT INTO `chart_of_accounts` VALUES (308, '2610', 'Borrowed Funds', 'Borrowed Funds', NULL, 'yes', NULL, 'active', 22, '2022-05-25 15:45:33', '2022-05-25 15:45:33');
INSERT INTO `chart_of_accounts` VALUES (309, '2705', 'Other Non-Current Liabilities', 'Other Non-Current Liabilities', NULL, 'yes', NULL, 'active', 23, '2022-05-25 15:45:39', '2022-05-25 15:45:39');
INSERT INTO `chart_of_accounts` VALUES (310, '2710', 'Due to HO/BXU Branch-Nasipit', 'Due to HO/BXU Branch-Nasipit', NULL, 'yes', NULL, 'active', 23, '2022-05-25 15:45:44', '2022-05-25 15:45:44');
INSERT INTO `chart_of_accounts` VALUES (311, '2711', 'DUE TO CLIENTS', 'DUE TO CLIENTS', NULL, 'yes', NULL, 'active', 23, '2022-05-25 15:45:50', '2022-05-25 15:45:50');
INSERT INTO `chart_of_accounts` VALUES (312, '2712', 'DUE TO EMPLOYEE', 'DUE TO EMPLOYEE', NULL, 'yes', NULL, 'active', 23, '2022-05-25 15:45:57', '2022-05-25 15:45:57');
INSERT INTO `chart_of_accounts` VALUES (313, '2715', 'DEFFERED CREDITS', 'DEFFERED CREDITS', NULL, 'yes', NULL, 'active', 23, '2022-05-25 15:46:01', '2022-05-25 15:46:01');
INSERT INTO `chart_of_accounts` VALUES (314, '3010', 'Authorized Share Capital - Common', 'Authorized Share Capital - Common', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:49:28', '2022-05-25 15:49:28');
INSERT INTO `chart_of_accounts` VALUES (315, '3015', 'Un-issued Share Capital - Common', 'Un-issued Share Capital - Common', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:49:43', '2022-05-25 15:49:43');
INSERT INTO `chart_of_accounts` VALUES (316, '3020', 'Subscribed Share Capital - Common', 'Subscribed Share Capital - Common', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:50:01', '2022-05-25 15:50:01');
INSERT INTO `chart_of_accounts` VALUES (317, '3025', 'Subsciption Receivable - Common', 'Subsciption Receivable - Common', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:50:08', '2022-05-25 15:50:08');
INSERT INTO `chart_of_accounts` VALUES (318, '3030', 'CAPITAL STOCK-COMMON', 'CAPITAL STOCK-COMMON', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:50:13', '2022-05-25 15:50:13');
INSERT INTO `chart_of_accounts` VALUES (319, '3031', 'ADDITIONAL PAID-IN CAPITAL', 'ADDITIONAL PAID-IN CAPITAL', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:50:18', '2022-05-25 15:50:18');
INSERT INTO `chart_of_accounts` VALUES (320, '3032', 'STOCKHOLDER\'S EQUITY', 'STOCKHOLDER\'S EQUITY', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:50:23', '2022-05-25 15:50:23');
INSERT INTO `chart_of_accounts` VALUES (321, '3035', 'Treasury Shares Capital - Common', 'Treasury Shares Capital - Common', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:55:25', '2022-05-25 15:55:25');
INSERT INTO `chart_of_accounts` VALUES (322, '3100', 'CAPITAL STOCKS - PREFERRED', 'CAPITAL STOCKS - PREFERRED', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:55:34', '2022-05-25 15:55:34');
INSERT INTO `chart_of_accounts` VALUES (323, '3105', 'Authorized Share Capital - Preferred', 'Authorized Share Capital - Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:55:43', '2022-05-25 15:55:43');
INSERT INTO `chart_of_accounts` VALUES (324, '3110', 'Un-issued Share Capital-Preferred', 'Un-issued Share Capital-Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:58:40', '2022-05-25 15:58:40');
INSERT INTO `chart_of_accounts` VALUES (325, '3115', 'Subscribed Share Capital-Preferred', 'Subscribed Share Capital-Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:58:47', '2022-05-25 15:58:47');
INSERT INTO `chart_of_accounts` VALUES (326, '3120', 'Subscriptions Receivable-Preferred', 'Subscriptions Receivable-Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:58:53', '2022-05-25 15:58:53');
INSERT INTO `chart_of_accounts` VALUES (327, '3125', 'Paid-up Share Capital-Preferred', 'Paid-up Share Capital-Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:59:02', '2022-05-25 15:59:02');
INSERT INTO `chart_of_accounts` VALUES (328, '3130', 'Treasury Shares Capital-Preferred', 'Treasury Shares Capital-Preferred', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:59:36', '2022-05-25 15:59:36');
INSERT INTO `chart_of_accounts` VALUES (329, '3500', ' Dividend', ' Dividend', NULL, 'yes', NULL, 'active', 25, '2022-05-25 16:00:00', '2022-05-25 16:00:00');
INSERT INTO `chart_of_accounts` VALUES (330, '5105', 'Salaries & Wages', 'Salaries & Wages', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:00:05', '2022-05-25 16:00:05');
INSERT INTO `chart_of_accounts` VALUES (331, '5110', 'COLA', 'COLA', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:00:11', '2022-05-25 16:00:11');
INSERT INTO `chart_of_accounts` VALUES (332, '5115', 'Transportation Allowance', 'Transportation Allowance', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:00:16', '2022-05-25 16:00:16');
INSERT INTO `chart_of_accounts` VALUES (333, '5120', ' Employees Benefits', ' Employees Benefits', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:00:27', '2022-05-25 16:00:27');
INSERT INTO `chart_of_accounts` VALUES (334, '5125', 'Employee Bonus', 'Employee Bonus', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:00:31', '2022-05-25 16:00:31');
INSERT INTO `chart_of_accounts` VALUES (335, '5130', 'Employees Performance Incentives', 'Employees Performance Incentives', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:01:22', '2022-05-25 16:01:22');
INSERT INTO `chart_of_accounts` VALUES (336, '5135', 'SSS/HDMF/PHIC Employer Share', 'SSS/HDMF/PHIC Employer Share', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:01:27', '2022-05-25 16:01:27');
INSERT INTO `chart_of_accounts` VALUES (337, '5140', 'Leave Credits', 'Leave Credits', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:01:32', '2022-05-25 16:01:32');
INSERT INTO `chart_of_accounts` VALUES (338, '5150', 'Retirement Benefit Expense', 'Retirement Benefit Expense', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:01:36', '2022-05-25 16:01:36');
INSERT INTO `chart_of_accounts` VALUES (339, '5155', 'Director\'s Fee', 'Director\'s Fee', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:02:40', '2022-05-25 16:02:40');
INSERT INTO `chart_of_accounts` VALUES (340, '5160', 'Officer\'s Honorarium & Allowances', 'Officer\'s Honorarium & Allowances', NULL, 'yes', NULL, 'active', 29, '2022-05-25 16:02:44', '2022-05-25 16:02:44');
INSERT INTO `chart_of_accounts` VALUES (341, '5175', 'Professional Fees', 'Professional Fees', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:02:50', '2022-05-25 16:02:50');
INSERT INTO `chart_of_accounts` VALUES (342, '5180', 'Litigation Expense', 'Litigation Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:25', '2022-05-25 16:03:25');
INSERT INTO `chart_of_accounts` VALUES (343, '5185', 'Office Supplies', 'Office Supplies', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:33', '2022-05-25 16:03:33');
INSERT INTO `chart_of_accounts` VALUES (344, '5190', 'General Services', 'General Services', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:39', '2022-05-25 16:03:39');
INSERT INTO `chart_of_accounts` VALUES (345, '5191', ' Security Guard', ' Security Guard', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:44', '2022-05-25 16:03:44');
INSERT INTO `chart_of_accounts` VALUES (346, '5195', 'Fuel & Lubricants', 'Fuel & Lubricants', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:48', '2022-05-25 16:03:48');
INSERT INTO `chart_of_accounts` VALUES (347, '5200', 'Power, Light & Water', 'Power, Light & Water', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:52', '2022-05-25 16:03:52');
INSERT INTO `chart_of_accounts` VALUES (348, '5205', 'Traveling Expense', 'Traveling Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:03:59', '2022-05-25 16:03:59');
INSERT INTO `chart_of_accounts` VALUES (349, '5210', 'Insurance Expense', 'Insurance Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:04:03', '2022-05-25 16:04:03');
INSERT INTO `chart_of_accounts` VALUES (350, '5215', 'Repairs & Maintenance', 'Repairs & Maintenance', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:04:10', '2022-05-25 16:04:10');
INSERT INTO `chart_of_accounts` VALUES (351, '5220', ' Rentals Non VAT', ' Rentals Non VAT', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:28', '2022-05-25 16:05:28');
INSERT INTO `chart_of_accounts` VALUES (352, '5221', 'Rentals VAT', 'Rentals VAT', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:36', '2022-05-25 16:05:36');
INSERT INTO `chart_of_accounts` VALUES (353, '5225', 'Rent - Motor', 'Rent - Motor', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:39', '2022-05-25 16:05:39');
INSERT INTO `chart_of_accounts` VALUES (354, '5230', 'Collection Expense', 'Collection Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:42', '2022-05-25 16:05:42');
INSERT INTO `chart_of_accounts` VALUES (355, '5235', 'Communication Expenses', 'Communication Expenses', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:46', '2022-05-25 16:05:46');
INSERT INTO `chart_of_accounts` VALUES (356, '5240', 'Mobile Phone Expenses', 'Mobile Phone Expenses', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:49', '2022-05-25 16:05:49');
INSERT INTO `chart_of_accounts` VALUES (357, '5245', 'Internet Expenses', 'Internet Expenses', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:52', '2022-05-25 16:05:52');
INSERT INTO `chart_of_accounts` VALUES (358, '5250', ' Representation Expenses', ' Representation Expenses', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:54', '2022-05-25 16:05:54');
INSERT INTO `chart_of_accounts` VALUES (359, '5251', 'Meals & Snacks', 'Meals & Snacks', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:57', '2022-05-25 16:05:57');
INSERT INTO `chart_of_accounts` VALUES (360, '5255', 'Meeting & Conferences', 'Meeting & Conferences', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:05:59', '2022-05-25 16:05:59');
INSERT INTO `chart_of_accounts` VALUES (361, '5260', 'Advertising & Promotion', 'Advertising & Promotion', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:06:01', '2022-05-25 16:06:01');
INSERT INTO `chart_of_accounts` VALUES (362, '5265', 'axes and Licenses', 'axes and Licenses', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:06:04', '2022-05-25 16:06:04');
INSERT INTO `chart_of_accounts` VALUES (363, '5266', 'Penalties/Surcharges', 'Penalties/Surcharges', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:06:06', '2022-05-25 16:06:06');
INSERT INTO `chart_of_accounts` VALUES (364, '5267', 'Deficiency Tax Settlement', 'Deficiency Tax Settlement', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:06:08', '2022-05-25 16:06:08');
INSERT INTO `chart_of_accounts` VALUES (365, '5270', 'Training/Seminars', 'Training/Seminars', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:42:05', '2022-05-25 16:42:05');
INSERT INTO `chart_of_accounts` VALUES (366, '5275', 'Amort. of Leasehold Rights & Improv', 'Amort. of Leasehold Rights & Improv', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:44:30', '2022-05-25 16:44:30');
INSERT INTO `chart_of_accounts` VALUES (367, '5280', 'Amort. of Other Intangible Assets', 'Amort. of Other Intangible Assets', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:44:37', '2022-05-25 16:44:37');
INSERT INTO `chart_of_accounts` VALUES (368, '5282', 'Amort. of Computerization Cost', 'Amort. of Computerization Cost', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:44:44', '2022-05-25 16:44:44');
INSERT INTO `chart_of_accounts` VALUES (369, '5285', 'Depreciation Expense', 'Depreciation Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:07', '2022-05-25 16:50:07');
INSERT INTO `chart_of_accounts` VALUES (370, '5290', ' Provision for Losses - Others', ' Provision for Losses - Others', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:20', '2022-05-25 16:50:20');
INSERT INTO `chart_of_accounts` VALUES (371, '5295', 'Provision Income Tax', 'Provision Income Tax', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:23', '2022-05-25 16:50:23');
INSERT INTO `chart_of_accounts` VALUES (372, '5300', 'Income Tax Expense', 'Income Tax Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:32', '2022-05-25 16:50:32');
INSERT INTO `chart_of_accounts` VALUES (373, '5305', ' Provision year end Expense', ' Provision year end Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:40', '2022-05-25 16:50:40');
INSERT INTO `chart_of_accounts` VALUES (374, '5310', ' Micellaneous Expense', ' Micellaneous Expense', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:50:50', '2022-05-25 16:50:50');
INSERT INTO `chart_of_accounts` VALUES (375, '5315', 'Giveaways', 'Giveaways', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:51:11', '2022-05-25 16:51:11');
INSERT INTO `chart_of_accounts` VALUES (376, '5320', 'Bank Charges', 'Bank Charges', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:51:17', '2022-05-25 16:51:17');
INSERT INTO `chart_of_accounts` VALUES (377, '5325', 'Periodical,Magazine & Subscription', 'Periodical,Magazine & Subscription', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:20:43', '2022-05-25 16:20:43');
INSERT INTO `chart_of_accounts` VALUES (378, '5330', 'Donations/Charitable Contributions', 'Donations/Charitable Contributions', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:53:37', '2022-05-25 16:53:37');
INSERT INTO `chart_of_accounts` VALUES (379, '5335', 'Water Supply', 'Water Supply', NULL, 'yes', NULL, 'active', 32, '2022-05-25 16:53:43', '2022-05-25 16:53:43');
INSERT INTO `chart_of_accounts` VALUES (380, '5805', 'Gain/Losses on Sale Prop. & Equip', 'Gain/Losses on Sale Prop. & Equip', NULL, 'yes', NULL, 'active', 34, '2022-05-25 16:53:54', '2022-05-25 16:53:54');
INSERT INTO `chart_of_accounts` VALUES (381, '5810', 'Gains/Losses in Investment', 'Gains/Losses in Investment', NULL, 'yes', NULL, 'active', 34, '2022-05-25 16:58:44', '2022-05-25 16:58:44');
INSERT INTO `chart_of_accounts` VALUES (382, '5815', 'Gains/loses on Sale of Repo items', 'Gains/loses on Sale of Repo items', NULL, 'yes', NULL, 'active', 34, '2022-05-25 17:00:30', '2022-05-25 17:00:30');
INSERT INTO `chart_of_accounts` VALUES (383, '5820', 'Prior Years Adjustment', 'Prior Years Adjustment', NULL, 'yes', NULL, 'active', 34, '2022-05-26 14:02:42', '2022-05-26 14:02:42');
INSERT INTO `chart_of_accounts` VALUES (384, '5855', 'Interest Expense on Borrowings', 'Interest Expense on Borrowings', NULL, 'yes', NULL, 'active', 35, '2022-05-26 14:02:52', '2022-05-26 14:02:52');
INSERT INTO `chart_of_accounts` VALUES (385, '5865 ', 'Other Financing Charges', 'Other Financing Charges', NULL, 'yes', NULL, 'active', 35, '2022-05-25 15:44:05', '2022-05-25 15:44:05');
INSERT INTO `chart_of_accounts` VALUES (386, '1099', 'TOTAL CASH and CASH EQUIVALENTS', 'TOTAL CASH and CASH EQUIVALENTS', NULL, 'yes', NULL, 'active', 2, '2022-05-31 15:24:28', '2022-05-31 15:24:28');
INSERT INTO `chart_of_accounts` VALUES (387, '1305', 'TOTAL LOANS AND RECEIVABLES', 'TOTAL LOANS AND RECEIVABLES', NULL, 'yes', NULL, 'active', 3, '2022-05-31 15:25:58', '2022-05-31 15:25:58');
INSERT INTO `chart_of_accounts` VALUES (388, '1450', 'TOTAL OTHER ASSETS', 'TOTAL OTHER ASSETS', NULL, 'yes', NULL, 'active', 4, '2022-05-31 15:27:08', '2022-05-31 15:27:08');
INSERT INTO `chart_of_accounts` VALUES (389, '1506', 'Land', 'Land', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:28:10', '2022-05-31 15:28:10');
INSERT INTO `chart_of_accounts` VALUES (390, '1520', ' TOTAL FURNITURE FIXTURE & EQUIPMENT', ' TOTAL FURNITURE FIXTURE & EQUIPMENT', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:29:04', '2022-05-31 15:29:04');
INSERT INTO `chart_of_accounts` VALUES (391, '1535', 'TOTAL OFFICE EQUIPMENT', 'TOTAL OFFICE EQUIPMENT', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:29:59', '2022-05-31 15:29:59');
INSERT INTO `chart_of_accounts` VALUES (392, '1550', 'TOTAL TRANSPORTATION EQUIPMENT', 'TOTAL TRANSPORTATION EQUIPMENT', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:31:04', '2022-05-31 15:31:04');
INSERT INTO `chart_of_accounts` VALUES (393, '1565', 'TOTAL LEASEHOLD RIGHTS & IMPROV', 'TOTAL LEASEHOLD RIGHTS & IMPROV', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:32:02', '2022-05-31 15:32:02');
INSERT INTO `chart_of_accounts` VALUES (394, '1571', 'TOTAL OTHER INTANGIBLE ASSETS', 'TOTAL OTHER INTANGIBLE ASSETS', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:32:43', '2022-05-31 15:32:43');
INSERT INTO `chart_of_accounts` VALUES (395, '1576', 'TOTAL COMPUTERIZATION COST', 'TOTAL COMPUTERIZATION COST', NULL, 'yes', NULL, 'active', 6, '2022-05-31 15:33:15', '2022-05-31 15:33:15');
INSERT INTO `chart_of_accounts` VALUES (396, '1825', 'TOTAL OTHER NON-CURRENT ASSETS', 'TOTAL OTHER NON-CURRENT ASSETS', NULL, 'yes', NULL, 'active', 23, '2022-05-31 15:34:06', '2022-05-31 15:34:06');
INSERT INTO `chart_of_accounts` VALUES (397, '2110', 'TOTAL CURRENT LIABILITIES', 'TOTAL CURRENT LIABILITIES', NULL, 'yes', NULL, 'active', 21, '2022-05-31 15:34:46', '2022-05-31 15:34:46');
INSERT INTO `chart_of_accounts` VALUES (398, '2699', 'TOTAL NON-CURRENT LIABILITIES', 'TOTAL NON-CURRENT LIABILITIES', NULL, 'yes', NULL, 'active', 22, '2022-05-31 15:36:38', '2022-05-31 15:36:38');
INSERT INTO `chart_of_accounts` VALUES (399, '2799', 'TOTAL OTHER NON-CURRENT LIABILITIES', 'TOTAL OTHER NON-CURRENT LIABILITIES', NULL, 'yes', NULL, 'active', 22, '2022-05-31 15:37:34', '2022-05-31 15:37:34');
INSERT INTO `chart_of_accounts` VALUES (400, '3400', 'Current Earnings', 'Current Earnings', NULL, 'yes', NULL, 'active', 25, '2022-05-31 16:04:57', '2022-05-31 16:04:57');
INSERT INTO `chart_of_accounts` VALUES (401, '4010', 'Interest Income', 'Interest Income', NULL, 'yes', NULL, 'active', 25, '2022-05-31 16:06:11', '2022-05-31 16:06:11');
INSERT INTO `chart_of_accounts` VALUES (402, '4011', 'Prepaid Interest Income', 'Prepaid Interest Income', NULL, 'yes', NULL, 'active', 26, '2022-05-31 16:06:16', '2022-05-31 16:06:16');
INSERT INTO `chart_of_accounts` VALUES (403, '4015', 'Service Fees', 'Service Fees', NULL, 'yes', NULL, 'active', 26, '2022-05-31 16:08:12', '2022-05-31 16:08:12');
INSERT INTO `chart_of_accounts` VALUES (404, '4020', ' Filing Fees', ' Filing Fees', NULL, 'yes', NULL, 'active', 26, '2022-05-31 16:08:15', '2022-05-31 16:08:15');
INSERT INTO `chart_of_accounts` VALUES (405, '4025', 'Fines, Penalties, Surcharges', 'Fines, Penalties, Surcharges', NULL, 'yes', NULL, 'active', 26, '2022-05-31 16:08:26', '2022-05-31 16:08:26');
INSERT INTO `chart_of_accounts` VALUES (406, '4026', 'Past Due Interest Income', 'Past Due Interest Income', NULL, 'yes', NULL, 'active', 26, '2022-05-31 16:08:30', '2022-05-31 16:08:30');
INSERT INTO `chart_of_accounts` VALUES (407, '4505', 'Income/Interest from Investment/Dep', 'Income/Interest from Investment/Dep', NULL, 'yes', NULL, 'active', 27, '2022-05-31 16:09:16', '2022-05-31 16:09:16');
INSERT INTO `chart_of_accounts` VALUES (408, '4555', 'Commission Income - Notarial', 'Commission Income - Notarial', NULL, 'yes', NULL, 'active', 28, '2022-05-31 16:11:05', '2022-05-31 16:11:05');
INSERT INTO `chart_of_accounts` VALUES (409, '4560', 'Commission Income - Insurance', 'Commission Income - Insurance', NULL, 'yes', NULL, 'active', 28, '2022-05-31 16:11:08', '2022-05-31 16:11:08');
INSERT INTO `chart_of_accounts` VALUES (410, '4565', 'Commision Income - Affidavit', 'Commision Income - Affidavit', NULL, 'yes', NULL, 'active', 28, '2022-05-31 16:11:12', '2022-05-31 16:11:12');
INSERT INTO `chart_of_accounts` VALUES (411, '4600', 'Misscellaneous Income', 'Misscellaneous Income', NULL, 'yes', NULL, 'active', 28, '2022-05-31 16:11:17', '2022-05-31 16:11:17');
INSERT INTO `chart_of_accounts` VALUES (412, '4601', 'Gain From Sale', 'Gain From Sale', NULL, 'yes', NULL, 'active', 28, '2022-05-31 16:12:26', '2022-05-31 16:12:26');
INSERT INTO `chart_of_accounts` VALUES (413, '5165', 'TOTAL ADMINISTRATIVE COST', 'TOTAL ADMINISTRATIVE COST', NULL, 'yes', NULL, 'active', 29, '2022-05-31 16:13:28', '2022-05-31 16:13:28');
INSERT INTO `chart_of_accounts` VALUES (414, '5499', 'TOTAL OPERATING EXPENSES', 'TOTAL OPERATING EXPENSES', NULL, 'yes', NULL, 'active', 32, '2022-05-31 16:14:17', '2022-05-31 16:14:17');
INSERT INTO `chart_of_accounts` VALUES (415, '5825', 'TOTAL OTHER ITEMS-SUBSIDY GAIN/LOSS', 'TOTAL OTHER ITEMS-SUBSIDY GAIN/LOSS', NULL, 'yes', NULL, 'active', 34, '2022-05-31 16:15:25', '2022-05-31 16:15:25');
INSERT INTO `chart_of_accounts` VALUES (416, '5899', 'TOTAL OTHER ITEMS-SUBSIDY GAIN/LOSS', 'TOTAL OTHER ITEMS-SUBSIDY GAIN/LOSS', NULL, 'yes', NULL, 'active', 35, '2022-05-31 16:16:11', '2022-05-31 16:16:11');
INSERT INTO `chart_of_accounts` VALUES (417, '3300', 'Retained Earnings', 'Retained Earnings', NULL, 'yes', NULL, 'active', 25, '2022-05-25 15:59:51', '2022-05-25 15:59:51');

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
INSERT INTO `company` VALUES (1, 'Engtech Global Solutions Inc.s', '', 'pedales.rustom@gmail.com', '+639631433932', NULL, NULL, '2022-06-01 03:30:03');

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of currency
-- ----------------------------
INSERT INTO `currency` VALUES (1, 'Peso', 'PHP', 'active', '2022-08-03 15:21:08', '2022-08-15 03:05:44');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of customer
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of employee_addresses
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of journal_book
-- ----------------------------
INSERT INTO `journal_book` VALUES (1, 'CDB', 'CHECK DISBURSEMENT BOOK\r\n', 'CHECK DISBURSEMENT BOOK', '2066', 'Active', 'Active', '2022-06-08 02:04:47', '2022-06-08 02:04:47');
INSERT INTO `journal_book` VALUES (2, 'PJB\r\n', 'PURCHASE/PAYABLES JOURNAL BOOK\r\n', 'PURCHASE/PAYABLES JOURNAL BOOK', '0', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (3, 'SJB\r\n', 'SALES/RECIEVABLES JOURNAL BOOK\r\n', 'SALES/RECIEVABLES JOURNAL BOOK', '0', 'Active', 'Active', '2022-07-12 12:43:52', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (4, 'CRB\r\n', 'CASH RECEIPT BOOK\r\n', 'CASH RECEIPT BOOK', '1415', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (5, 'GJB\r\n', 'GENERAL JOURNAL BOOK\r\n', 'GENERAL JOURNAL BOOK', '3354', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (6, 'CSDB\r\n', 'CASH DISBURSMENT BOOK', 'CASH DISBURSMENT BOOK', '5165', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (7, 'CDPB\r\n', 'CASH DISBURSMENT BOOK', 'COLLECTION DEPOSITS BOOK', '651', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (8, 'LRB\r\n', 'LOAN RELEASES BOOK', 'LOAN RELEASES BOOK', '2362', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (9, 'LPB\r\n', 'LOAN PAYMENTS BOOK', 'LOAN PAYMENTS BOOK', '3210', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');
INSERT INTO `journal_book` VALUES (10, 'ODB\r\n', 'OTHER DEPOSIT BOOK', 'OTHER DEPOSIT BOOK', '0', 'Active', 'Active', '2022-06-08 02:05:48', '2022-06-08 02:05:48');

-- ----------------------------
-- Table structure for journal_entry
-- ----------------------------
DROP TABLE IF EXISTS `journal_entry`;
CREATE TABLE `journal_entry`  (
  `journal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `journal_date` date NULL DEFAULT NULL,
  `branch_id` int(11) NULL DEFAULT NULL,
  `book_id` int(11) NULL DEFAULT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `cheque_date` date NULL DEFAULT NULL,
  `cheque_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payee` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `remarks` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`journal_id`) USING BTREE,
  INDEX `book_id`(`book_id`) USING BTREE,
  CONSTRAINT `journal_entry_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `journal_book` (`book_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of journal_entry
-- ----------------------------

-- ----------------------------
-- Table structure for journal_entry_details
-- ----------------------------
DROP TABLE IF EXISTS `journal_entry_details`;
CREATE TABLE `journal_entry_details`  (
  `journal_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `account_id` int(11) UNSIGNED NULL DEFAULT NULL,
  `subsidiary_id` int(11) NULL DEFAULT NULL,
  `journal_details_account_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_debit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_credit` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `journal_details_description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `journal_details_ref_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`journal_details_id`) USING BTREE,
  INDEX `journal_subsidiary_id`(`subsidiary_id`) USING BTREE,
  INDEX `journal_entry_details_ibfk_3`(`journal_id`) USING BTREE,
  INDEX `account_id`(`account_id`) USING BTREE,
  CONSTRAINT `journal_entry_details_ibfk_2` FOREIGN KEY (`subsidiary_id`) REFERENCES `subsidiary` (`sub_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `journal_entry_details_ibfk_3` FOREIGN KEY (`journal_id`) REFERENCES `journal_entry` (`journal_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `journal_entry_details_ibfk_4` FOREIGN KEY (`account_id`) REFERENCES `chart_of_accounts` (`account_id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of journal_entry_details
-- ----------------------------
INSERT INTO `journal_entry_details` VALUES (69, 29, 238, 1, '1010', NULL, '2500', '0', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (70, 29, 238, 4, '1010', NULL, '500', '0', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (71, 29, 249, 7, '1205', NULL, '0', '1000', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (72, 29, 249, 12, '1205', NULL, '0', '500', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (73, 29, 248, 15, '1060', NULL, '0', '500', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (74, 30, 238, 1, '1010', NULL, '10000', '0', 'cash in', NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (75, 30, 241, 2, '1025', NULL, '0', '3000', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (76, 30, 251, 20, '1260', NULL, '0', '4000', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (77, 31, 238, 7, '1010', NULL, '10000', '0', 'hulam', NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (78, 31, 269, 4, '1540', NULL, '0', '5000', 'bayad ug sakyanan', NULL, NULL, NULL, NULL);
INSERT INTO `journal_entry_details` VALUES (79, 31, 300, 1, '2076', NULL, '0', '2000', 'tax', NULL, NULL, NULL, NULL);

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
INSERT INTO `personal_info` VALUES (2, 'Zetro', 'Armado', 'Patenio', 'male', 'zet', 'zet@gmail.com', '193399221', '2022-04-24 13:51:31', '2022-06-02 06:08:37');
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
) ENGINE = InnoDB AUTO_INCREMENT = 268 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = COMPACT;

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
INSERT INTO `sub_module_lists` VALUES (156, 5, 'systemSetup', 'System Setup', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (157, 5, 'systemSetup/general/company/update', 'Company Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (158, 5, 'systemSetup/general/accounting/update', 'Accounting Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (159, 5, 'systemSetup/general/currency/update', 'Currency Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (174, 7, 'dashboard', 'Dashboard Home', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (175, 5, 'companySettings', 'Company Settings (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (178, 5, 'JournalBook', 'JournalBook (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (179, 5, 'UserMasterFile', 'UserMasterFile (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (180, 5, 'accounting', 'accounting (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (181, 5, 'currency', 'currency (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (187, 5, 'systemSetup/general/userMasterFile/createOrUpdate', 'User Master FIle (Create or Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (189, 5, 'systemSetup/general/usermasterfile/searchAccount', 'User Master File (Search Account)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (191, 5, 'systemSetup/general/usermasterfile/fetchInfo', 'User Master File (Fetch Information)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (193, 5, 'systemSetup/general/usermasterfile/createOrUpdateAccessibility', 'User Master File ( Update Accessibility)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (195, 5, 'systemSetup/general/usermasterfile/createOrUpdate', 'User Master File ( Create User or Update User)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (197, 5, 'CategoryFile', 'Category File (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (201, 5, 'subsidiary', 'Subsidiary Panel', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (202, 5, 'systemSetup/general/journalBook/createOrUpdate', 'Journal Book (Create or Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (203, 5, 'systemSetup/general/journalBook/fetchBookInfo', 'Journal Book (Fetch Book Information) ', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (204, 5, 'systemSetup/general/journalBook/deleteBook', 'Journal Book (Delete Book Record)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (205, 5, 'systemSetup/general/categoryFile/createOrUpdate', 'Subsidiary Category File (Create or Update)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (206, 5, 'systemSetup/general/categoryFile/fetchCategoryInfo', 'Subsidiary Category File (Fetch Category Info)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (207, 5, 'systemSetup/general/categoryFile/deleteCategory', 'Subsidiary Category File (Delete Category)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (208, 4, 'reports', 'Report (Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (209, 4, 'reports/subsidiaryledger', 'Report (Subsidiary Ledger Panel)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (211, 4, 'reports/generalLedger', 'Report (General Ledger)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (212, 4, 'reports/trialBalance', 'Report (Trial Balance)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (213, 4, 'reports/incomeStatement', 'Report (Income Statement)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (214, 4, 'reports/bankReconcillation', 'Report (Bank Reconcillation)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (215, 4, 'reports/cashPosition', 'Report (Cash Position)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (216, 4, 'reports/cashTransactionBlotter', 'Report (Cash Transaction Blotter)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (217, 9, 'journal/journalEntryList', 'Journal Entry List', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (219, 9, 'journal/journalEntry', 'Journal Entry ', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (220, 4, 'reports/cheque', 'Cheque', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (221, 4, 'reports/postDatedCheque', 'Post-Dated Cheque', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (223, 8, 'accounts/getAccountTypeContent', 'Chart of Account  (Get Type Content)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (225, 8, 'accounts/saveType', 'Accounts VIew Type Modal', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (226, 8, 'accounts/saveClass', 'Accounts VIew ClassModal', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (227, 8, 'accounts/createNewType', 'Chart of Account save Type', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (228, 8, 'accounts/createNewClass', 'Chart of Account save Class', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (232, 4, 'reports/subsidiarySaveorEdit', 'Subsidiary Create or Update', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (234, 10, 'sales', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (235, 10, 'sales/store', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (236, 10, 'sales-datatable', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (237, 10, 'getsales', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (238, 10, 'sales/invoice', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (239, 10, 'sales/create/invoice', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (240, 10, 'sales/store', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (241, 10, 'sales-datatable', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (242, 10, 'getsales', 'sales', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (244, 10, 'expenses', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (245, 11, 'expenses/store', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (246, 11, 'expenses/void', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (247, 11, 'expense-datatable', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (248, 11, 'create/expense', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (250, 11, 'create/bill', 'expenses', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (255, 4, 'reports/subsidiaryViewInfo', 'Report (Subsidiary Fetch Information)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (256, 4, 'reports/subsidiaryDelete', 'Report (Subsidiary Delete)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (259, 9, 'journal', 'Journal VIew (NOT INCLUDE)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (260, 9, 'journal/saveJournalEntry', 'Journal (save Journal Entry)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (262, 9, 'journal/saveJournalEntryDetails', 'Journal Entry (save Journal Entry Details)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (263, 9, 'journal/JournalEntryFetch', 'Journal (Fetch Journal Information)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (265, 9, 'journal/JournalEntryPostUnpost', 'Journal (Set Unposted to Posted)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');
INSERT INTO `sub_module_lists` VALUES (267, 9, 'journal/searchJournalEntry', 'Journal (Search Journal Entry)', '2022-04-25 17:03:24', '2022-04-25 17:03:24');

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
  `sub_life_used` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
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
) ENGINE = InnoDB AUTO_INCREMENT = 567 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subsidiary
-- ----------------------------
INSERT INTO `subsidiary` VALUES (1, 48, 'MAIN BRANCE - BUTUAN BRANCE', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:24');
INSERT INTO `subsidiary` VALUES (2, 48, 'BRANCE 2 - NASIPIT BRANCE ', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:27');
INSERT INTO `subsidiary` VALUES (3, 6, 'MINDANAO NEWHOPE CORPORATION\r\n', 'Thunderlink Bldg. Ochoa Ave., B.C.\r\n', '3420999\r\n', NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:29');
INSERT INTO `subsidiary` VALUES (4, 48, 'BRANCH 3 - GINGOOG BRANCH\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:32');
INSERT INTO `subsidiary` VALUES (5, 48, 'HEAD OFFICE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:34');
INSERT INTO `subsidiary` VALUES (6, 4, 'MARK ANTHONY M. CHAVEZ\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:36');
INSERT INTO `subsidiary` VALUES (7, 4, 'ALAN L. JADOL\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:39');
INSERT INTO `subsidiary` VALUES (8, 4, 'JUVYLYN D. CACHO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:41');
INSERT INTO `subsidiary` VALUES (9, 4, 'LENE JOY S. GABAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:43');
INSERT INTO `subsidiary` VALUES (10, 4, 'JOMEL GALLENERO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:47');
INSERT INTO `subsidiary` VALUES (11, 13, 'LYNDON BUQUE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:53');
INSERT INTO `subsidiary` VALUES (12, 13, 'YVONNE ESPINA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:55');
INSERT INTO `subsidiary` VALUES (13, 13, 'LEONARDO ESPINA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:48:58');
INSERT INTO `subsidiary` VALUES (14, 4, 'JIMMY CASTILLO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:12');
INSERT INTO `subsidiary` VALUES (15, 4, 'CHRISTINE MAE J. MONGAYA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:16');
INSERT INTO `subsidiary` VALUES (16, 4, 'CHERRY MAE OLAR\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:19');
INSERT INTO `subsidiary` VALUES (17, 4, 'RYAN C. PLAZA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:21');
INSERT INTO `subsidiary` VALUES (18, 4, 'JUNVIC P. GUELOS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:26');
INSERT INTO `subsidiary` VALUES (19, 4, 'DENNIS GREGORIO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:28');
INSERT INTO `subsidiary` VALUES (20, 4, 'RECHILD C. JAPOS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:31');
INSERT INTO `subsidiary` VALUES (21, 9, 'ABAO NENA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:33');
INSERT INTO `subsidiary` VALUES (22, 4, 'RIC VARY CUBIO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:35');
INSERT INTO `subsidiary` VALUES (23, 4, 'ROLAND\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-09 14:49:40');
INSERT INTO `subsidiary` VALUES (24, 4, 'PHYSCHE CANONOY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:54:57');
INSERT INTO `subsidiary` VALUES (25, 6, 'SOCIAL SECURITY SYSTEM\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:01');
INSERT INTO `subsidiary` VALUES (26, 4, 'EARL FAJARDO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:04');
INSERT INTO `subsidiary` VALUES (27, 4, 'JOSE LANDINGIN JR.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:10');
INSERT INTO `subsidiary` VALUES (28, 4, 'LEMUEL ROY SALCEDO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:16');
INSERT INTO `subsidiary` VALUES (29, 4, 'RICO DUMOSMOG\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:20');
INSERT INTO `subsidiary` VALUES (30, 4, 'CHRISTINE SALMORO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:25');
INSERT INTO `subsidiary` VALUES (31, 9, 'JONATHAN MANABAN\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:29');
INSERT INTO `subsidiary` VALUES (32, 2, 'ENGELBERT CAMPOS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:35');
INSERT INTO `subsidiary` VALUES (33, 4, 'RANDY F. NAVARRO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:41');
INSERT INTO `subsidiary` VALUES (34, 6, 'MELVEEN PASCUBILLO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:44');
INSERT INTO `subsidiary` VALUES (35, 4, 'JESSE NIÑO A. CASTILLO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:49');
INSERT INTO `subsidiary` VALUES (36, 4, 'JOSEPH BAGUYO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:53');
INSERT INTO `subsidiary` VALUES (37, 4, 'SHERWIN COJO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:55:57');
INSERT INTO `subsidiary` VALUES (38, 6, 'GLOBE TELECOME\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:00');
INSERT INTO `subsidiary` VALUES (39, 6, 'KAHLIL L. LAMIGO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:10');
INSERT INTO `subsidiary` VALUES (40, 6, 'ARNEL JUDE L. VILLANUEVA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:14');
INSERT INTO `subsidiary` VALUES (41, 6, 'KAPANALIG SECURITY AGENCY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:19');
INSERT INTO `subsidiary` VALUES (42, 4, 'JUVELYN D. CACHO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:23');
INSERT INTO `subsidiary` VALUES (43, 4, 'CYRIEL N. TINGCOY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:26');
INSERT INTO `subsidiary` VALUES (44, 13, 'EDSEL MADELO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:30');
INSERT INTO `subsidiary` VALUES (45, 13, 'ARTIFICIO LACANG\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:32');
INSERT INTO `subsidiary` VALUES (46, 3, 'TWINSTAR GAS STATION\r\n', 'nasipit, agusan del norte\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:38');
INSERT INTO `subsidiary` VALUES (47, 3, 'PEARL POWER GAS STATION\r\n', 'butuan city\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:45');
INSERT INTO `subsidiary` VALUES (48, 13, 'RUEL RAGAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:55');
INSERT INTO `subsidiary` VALUES (49, 6, 'PHILAM LIFE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:56:58');
INSERT INTO `subsidiary` VALUES (50, 6, 'KAPANALIG SECURITY AGENCY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:05');
INSERT INTO `subsidiary` VALUES (51, 6, 'DANNY D. OYAO\r\n', 'BUTUAN CITY\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:11');
INSERT INTO `subsidiary` VALUES (52, 6, 'BUTUAN VPH REALTY CORP\r\n', 'BUTUAN CITY\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:16');
INSERT INTO `subsidiary` VALUES (53, 9, 'CALIXTO FELIAS\r\n', 'NASIPIT, A.D.N\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:21');
INSERT INTO `subsidiary` VALUES (54, 6, 'MICRO ACCESS LOANS CORP.\r\n', 'BUTUAN CITY\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-15 00:00:00', '2022-06-08 10:57:25');
INSERT INTO `subsidiary` VALUES (55, 3, 'SOLARIS GAS SERVICE STATION\r\n', 'J.C AQUINO, LIBERTAD, B.C\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:29');
INSERT INTO `subsidiary` VALUES (56, 4, 'DOMINADOR SALCEDO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 09:57:31');
INSERT INTO `subsidiary` VALUES (57, 9, 'ERASMO M. ALAAN\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:35');
INSERT INTO `subsidiary` VALUES (58, 9, 'ALLAN M. DAWAT\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 09:57:39');
INSERT INTO `subsidiary` VALUES (59, 9, 'MICHELLE M. TIMCANG\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 09:57:42');
INSERT INTO `subsidiary` VALUES (60, 9, 'ANTONIO S. REBOQUIO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:46');
INSERT INTO `subsidiary` VALUES (61, 4, 'JANINE L. DESCALLAR\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:57:49');
INSERT INTO `subsidiary` VALUES (62, 9, 'KAREN ALFARO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:02');
INSERT INTO `subsidiary` VALUES (63, 9, 'GY ENTERPRISES\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:11');
INSERT INTO `subsidiary` VALUES (64, 9, 'VIRGILITA HECHANOVA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:16');
INSERT INTO `subsidiary` VALUES (65, 6, 'DESMARK CORPORATION\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:34');
INSERT INTO `subsidiary` VALUES (66, 6, 'PAQUITO R. CASPE SR.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:41');
INSERT INTO `subsidiary` VALUES (67, 14, 'JOSELITO C. FERRER JR.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:58:47');
INSERT INTO `subsidiary` VALUES (68, 3, 'RINOGRAFIX\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 09:58:52');
INSERT INTO `subsidiary` VALUES (69, 6, 'ECOWHEELS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:23');
INSERT INTO `subsidiary` VALUES (70, 9, 'BSU PRINTS & GARMENTS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:30');
INSERT INTO `subsidiary` VALUES (71, 9, 'BSU PRINTS & GARMENTS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:34');
INSERT INTO `subsidiary` VALUES (72, 9, 'RHEA MARIE RAGO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:41');
INSERT INTO `subsidiary` VALUES (73, 9, 'SANDRA CECILIA D. FELIAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:47');
INSERT INTO `subsidiary` VALUES (74, 9, 'ROGELIO M. AQUINO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 10:59:56');
INSERT INTO `subsidiary` VALUES (75, 9, 'ALMONT HOTEL INC.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:12');
INSERT INTO `subsidiary` VALUES (76, 4, 'JOEL A. BALIGUAT\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:19');
INSERT INTO `subsidiary` VALUES (77, 9, 'ALBERT T. GALO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:26');
INSERT INTO `subsidiary` VALUES (78, 9, 'AGUSAN GREENFIELD RESOURCES & AGRO\r\n', 'TECH CORPORATION\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:33');
INSERT INTO `subsidiary` VALUES (79, 13, 'MAXIMILLAN T. GOMEZ\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:40');
INSERT INTO `subsidiary` VALUES (80, 9, 'WAYFARER\r\n', 'T. CALO, BUTUAN CITY\r\n', '3428827\r\n', NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:47');
INSERT INTO `subsidiary` VALUES (81, 9, 'SUPER CARRY POLLUTION TEST CO.\r\n', 'PILI DRIVE EXT., BUTUAN CITY\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:00:54');
INSERT INTO `subsidiary` VALUES (82, 9, 'MAC DARL ENTERPRISES\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:00');
INSERT INTO `subsidiary` VALUES (83, 6, 'CLIMBS\r\n', 'PILI DRIVE, BUTUAN CITY\r\n', NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:07');
INSERT INTO `subsidiary` VALUES (84, 9, 'PHILHEALTH\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:13');
INSERT INTO `subsidiary` VALUES (85, 9, 'JESUS A. TANTAY LAW OFFICE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:21');
INSERT INTO `subsidiary` VALUES (86, 9, 'BUREAU OF INTERNAL REVENUE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:29');
INSERT INTO `subsidiary` VALUES (87, 9, 'JANIFER CALUYONG\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:35');
INSERT INTO `subsidiary` VALUES (88, 9, 'CESAR B. GALERA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-15 00:00:00', '2022-06-08 11:01:46');
INSERT INTO `subsidiary` VALUES (89, 9, 'DIONESIA C. GARAN\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:01:57');
INSERT INTO `subsidiary` VALUES (90, 9, 'BP & CO.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:07');
INSERT INTO `subsidiary` VALUES (91, 9, 'GEMMA B. PEÑARANDA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:18');
INSERT INTO `subsidiary` VALUES (92, 9, 'RASERPROJECT\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:21');
INSERT INTO `subsidiary` VALUES (93, 6, 'AGUSAN DEL NORTE ELECTRIC COOP\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:26');
INSERT INTO `subsidiary` VALUES (94, 6, 'BUTUAN CITY WATER DISTRICT\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:34');
INSERT INTO `subsidiary` VALUES (95, 6, 'GOLDILOCKS BAKESHOP\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:49');
INSERT INTO `subsidiary` VALUES (96, 14, '9497 BUSINESS VENTURES CORP.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:02:53');
INSERT INTO `subsidiary` VALUES (97, 6, 'HOME DEVELOPMENT MUTUAL FUND\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:13');
INSERT INTO `subsidiary` VALUES (98, 9, 'RUBEN M. EMPAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:19');
INSERT INTO `subsidiary` VALUES (99, 6, 'PLDT\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:25');
INSERT INTO `subsidiary` VALUES (100, 6, 'GRAND WATERGATE SUITES CORP.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:31');
INSERT INTO `subsidiary` VALUES (101, 6, 'TIMBER CITY ACADEMY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:36');
INSERT INTO `subsidiary` VALUES (102, 6, 'NORTH-MIN AUTO DEALERSHIP, INC.\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:46');
INSERT INTO `subsidiary` VALUES (103, 6, 'MANILA AUTO CARE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:53');
INSERT INTO `subsidiary` VALUES (104, 6, 'DEPAUL SIGN FABRICATOR\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:03:57');
INSERT INTO `subsidiary` VALUES (105, 9, 'SANDRECS L. ESCRIBIR\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:04:11');
INSERT INTO `subsidiary` VALUES (106, 9, 'MICHAEL A. ARANDA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-08 00:00:00', '2022-06-08 11:04:17');
INSERT INTO `subsidiary` VALUES (107, 6, 'JMARY STEEL WORKS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:41:27');
INSERT INTO `subsidiary` VALUES (108, 9, 'BUTUAN CITY TREASURER\'S OFFICE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:13:58');
INSERT INTO `subsidiary` VALUES (109, 6, 'HI-PRECISION DIAGNOSTICS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:04');
INSERT INTO `subsidiary` VALUES (110, 6, 'ST. PETER\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:08');
INSERT INTO `subsidiary` VALUES (111, 9, 'DULCESIMO M. BETALAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:12');
INSERT INTO `subsidiary` VALUES (112, 9, 'RUBEN A. VISAYA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:17');
INSERT INTO `subsidiary` VALUES (113, 4, 'KURT DENNIS T. FELISILDA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:20');
INSERT INTO `subsidiary` VALUES (114, 6, 'G-HOVEN I.T SOLUTIONS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:23');
INSERT INTO `subsidiary` VALUES (115, 9, 'ARNEL CUENCA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:27');
INSERT INTO `subsidiary` VALUES (116, 4, 'CLIFORD V. LUCERO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:30');
INSERT INTO `subsidiary` VALUES (117, 6, 'LCG MARKETING PHILIPPINES CORP\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:33');
INSERT INTO `subsidiary` VALUES (118, 9, 'RICA MARIE MENDOZA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:35');
INSERT INTO `subsidiary` VALUES (119, 9, 'BONIFACIO CALIWAN\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:38');
INSERT INTO `subsidiary` VALUES (120, 9, 'FELIX JABLA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:40');
INSERT INTO `subsidiary` VALUES (121, 9, 'ANGELVY R. ZASPA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:43');
INSERT INTO `subsidiary` VALUES (122, 4, 'JING E. ABALOS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:45');
INSERT INTO `subsidiary` VALUES (123, 9, 'ARISTIDES AMIGABLE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:47');
INSERT INTO `subsidiary` VALUES (124, 9, 'FRANCISCA CAÑETE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:49');
INSERT INTO `subsidiary` VALUES (125, 9, 'MIGUEL SERDEÑA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:51');
INSERT INTO `subsidiary` VALUES (126, 9, 'ALEJANDRO T. LIM\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:14:59');
INSERT INTO `subsidiary` VALUES (127, 9, 'KARLOU T. MANGMANG\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:03');
INSERT INTO `subsidiary` VALUES (128, 9, 'FERDINAND DURANGO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:05');
INSERT INTO `subsidiary` VALUES (129, 9, 'LORENA B. BONGCO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:08');
INSERT INTO `subsidiary` VALUES (130, 9, 'MARRY JEAN Z. SALAMANCA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:10');
INSERT INTO `subsidiary` VALUES (131, 9, 'RUENA B. EMLANO\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:13');
INSERT INTO `subsidiary` VALUES (132, 9, 'CECILIA Y. SAJONIA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:15');
INSERT INTO `subsidiary` VALUES (133, 4, 'SONNY LEO JIM C. GUMAPAC\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:17');
INSERT INTO `subsidiary` VALUES (134, 4, 'ISRAEL LAPLANA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:19');
INSERT INTO `subsidiary` VALUES (135, 9, 'RICHARD G. GARAY\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:21');
INSERT INTO `subsidiary` VALUES (153, 6, 'BACONGA PATRIANA AND CO. CPAS\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:23');
INSERT INTO `subsidiary` VALUES (154, 9, 'HANS JONATHAN F. YEE\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:25');
INSERT INTO `subsidiary` VALUES (155, 9, 'ELIZA M. VILLANUEVA\r\n', NULL, NULL, NULL, NULL, NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:29');
INSERT INTO `subsidiary` VALUES (156, 50, 'LG AIRCON\r\n', NULL, NULL, '1530', '00000', '2015-01-31', '2015-01-31', '17495.00\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:32');
INSERT INTO `subsidiary` VALUES (157, 50, 'STEEL CABINET\r\n', NULL, NULL, '1530', '00000', '2015-02-02', '2015-02-02', '3510.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:34');
INSERT INTO `subsidiary` VALUES (158, 50, 'COMPUTER SET HP-DTAIO-5125\r\n', NULL, NULL, '1530', '00000', '2015-03-25', '2015-03-25', '18590.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:36');
INSERT INTO `subsidiary` VALUES (159, 50, '2 UNIT UPS INTEX BLACK 650VA\r\n', NULL, NULL, '1530', '00000', '2015-04-20', '2015-04-20', '3470.00', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:38');
INSERT INTO `subsidiary` VALUES (160, 50, 'COMPUTER SET W/WINDOWS ASUS\r\n', NULL, NULL, '1530', '00000', '2015-11-11', '2015-11-11', '21200.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:40');
INSERT INTO `subsidiary` VALUES (161, 50, 'I UNIT CAMERA\r\n', NULL, NULL, '1530', '00000', '2016-03-10', '2016-03-10', '27000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:42');
INSERT INTO `subsidiary` VALUES (162, 50, 'COMPUTER ACCESSORIES\r\n', NULL, NULL, '1530', '00000', '2016-05-23', '2016-05-23', '1990.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:44');
INSERT INTO `subsidiary` VALUES (163, 50, 'WIRELESS ROUTER SWTCH HUB/HYTAC HGB\r\n', NULL, NULL, '1530', '00000', '2016-06-10', '2016-06-10', '2795.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:46');
INSERT INTO `subsidiary` VALUES (164, 50, 'ACER BATTERY\r\n', NULL, NULL, '1530', '00000', '2016-06-22', '2016-06-22', '3300.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:49');
INSERT INTO `subsidiary` VALUES (165, 50, 'COMPUTER ACCESSORIES\r\n', NULL, NULL, '1530', '00000', '2016-08-16', '2016-08-16', '2705.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:53');
INSERT INTO `subsidiary` VALUES (166, 50, '1 UNIT ASUS LAPTOP\r\n', NULL, NULL, '1530', '00000', '2016-08-30', '2016-08-30', '33504.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:56');
INSERT INTO `subsidiary` VALUES (167, 50, '2 GB INTERNAL HDD\r\n', NULL, NULL, '1530', '00000', '2016-12-22', '2016-12-22', '3950.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:15:58');
INSERT INTO `subsidiary` VALUES (168, 50, 'MATERIALS FOR CCTV INSTALL NEW BLDG\r\n', NULL, NULL, '1530', '00000', '2017-07-03', '2017-07-03', '16688.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:00');
INSERT INTO `subsidiary` VALUES (169, 50, '3IN1 PRINTER & TRANSMITTER EPSON\r\n', NULL, NULL, '1530', '00000', '2017-02-15', '2017-02-15', '14890.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:02');
INSERT INTO `subsidiary` VALUES (170, 50, 'LAPTOP BATTERY\r\n', NULL, NULL, '1530', '00000', '2018-03-15', '2018-03-15', '1500.00\r\n', '3', '3', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:06');
INSERT INTO `subsidiary` VALUES (171, 50, '2U MB200MULTI BIOMETRIC & 1LOT SRVR\r\n', NULL, NULL, '1530', '00000', '2019-02-12', '2019-02-12', '32142.86\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:09');
INSERT INTO `subsidiary` VALUES (172, 50, 'DESKTOP COMPUTER-CLONED\r\n', NULL, NULL, '1530', '00001', NULL, NULL, '19000.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:16:12');
INSERT INTO `subsidiary` VALUES (173, 50, 'CASH VAULT\r\n', NULL, NULL, '1530', '00001', NULL, NULL, '1180.00', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:16:17');
INSERT INTO `subsidiary` VALUES (174, 50, 'UNNAMED\r\n', NULL, NULL, '1530', '00001', '2011-06-17', '2011-06-17', '280.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:26');
INSERT INTO `subsidiary` VALUES (175, 50, 'LG-COMPUTER SET W/ WINDOWS\r\n', NULL, NULL, '1530', '00001', '2011-10-12', '2011-10-12', '21895.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:30');
INSERT INTO `subsidiary` VALUES (176, 50, 'LAPTOP-COMPUTER ACER\r\n', NULL, NULL, '1530', '00001', '2011-12-16', '2011-12-16', '34900.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:32');
INSERT INTO `subsidiary` VALUES (177, 50, 'TELLER\'S CHAIR\r\n', NULL, NULL, '1530', '00001', '2013-03-19', '2013-03-19', '2979.00\r\n', '1', '1', '9.96', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:34');
INSERT INTO `subsidiary` VALUES (178, 50, '1 SET COMPUTER ACER\r\n', NULL, NULL, '1530', '00001', '2013-01-02', '2013-01-02', '22130.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:37');
INSERT INTO `subsidiary` VALUES (179, 50, 'UPS & PRINTER NASIPIT\r\n', NULL, NULL, '1530', '00001', '2013-04-15', '2013-04-15', '12745.00\r\n', '9', '9', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:39');
INSERT INTO `subsidiary` VALUES (180, 50, 'POWER INVERTER\r\n', NULL, NULL, '1530', '00001', '2013-05-13', '2013-05-13', '11600.00\r\n', '6', '6', '0.99', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:41');
INSERT INTO `subsidiary` VALUES (181, 50, 'POWER INVERTER\r\n', NULL, NULL, '1530', '00001', '2013-05-29', '2013-05-29', '4400.00\r\n', '6', '6', '1.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:43');
INSERT INTO `subsidiary` VALUES (182, 50, '1U UPS-BOOKKEEPERS STATION\r\n', NULL, NULL, '1530', '00001', '2013-07-10', '2013-07-10', '4184.00\r\n', '6', '6', '4.35', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:45');
INSERT INTO `subsidiary` VALUES (183, 50, '1U COMPUTER PRINTER EPSON LQ300+II\r\n', NULL, NULL, '1530', '00001', '2013-07-24', '2013-07-24', '5550.00\r\n', '6', '6', '1.08', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:47');
INSERT INTO `subsidiary` VALUES (184, 50, 'LCD PROJECTOR EPSON\r\n', NULL, NULL, '1530', '00001', '2013-05-23', '2013-05-23', '20500.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:49');
INSERT INTO `subsidiary` VALUES (185, 50, 'SPLIT TYPE AIRCON-LG INVERTER V\r\n', NULL, NULL, '1530', '00001', '2013-06-14', '2013-06-14', '41600.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:51');
INSERT INTO `subsidiary` VALUES (186, 50, '1U COMPUTER SERVER SAMSUNG\r\n', NULL, NULL, '1530', '00001', '2013-06-24', '2013-06-24', '36000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:53');
INSERT INTO `subsidiary` VALUES (187, 50, 'IU DESKTOP COMPUTER ACER\r\n', NULL, NULL, '1530', '00001', '2013-07-24', '2013-07-24', '19000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:56');
INSERT INTO `subsidiary` VALUES (188, 50, '4U CCTV CAMERA QUIBE\r\n', NULL, NULL, '1530', '00001', '2013-09-12', '2013-09-12', '25000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:16:57');
INSERT INTO `subsidiary` VALUES (189, 50, 'CCTV CAMERA\r\n', NULL, NULL, '1530', '00001', '2013-11-18', '2013-11-18', '2200.00\r\n', '12', '12', '4.51', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:02');
INSERT INTO `subsidiary` VALUES (190, 50, '1U PRINTER-EPSON L210\r\n', NULL, NULL, '1530', '00001', '2015-03-04', '2015-03-04', '7250.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:07');
INSERT INTO `subsidiary` VALUES (191, 50, '1U CANON CAMERA\r\n', NULL, NULL, '1530', '00001', '2016-03-10', '2016-03-10', '4948.50\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:09');
INSERT INTO `subsidiary` VALUES (192, 50, 'COMPUTER SET LENOVO\r\n', NULL, NULL, '1530', '00001', '2016-12-22', '2016-12-22', '18785.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:15');
INSERT INTO `subsidiary` VALUES (193, 50, 'BLUETOOTH SPEAKER\r\n', NULL, NULL, '1530', '00001', '2016-12-22', '2016-12-22', '995.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:17');
INSERT INTO `subsidiary` VALUES (194, 50, 'UPS\r\n', NULL, NULL, '1530', '00001', '2016-12-22', '2016-12-22', '2695.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:20');
INSERT INTO `subsidiary` VALUES (195, 50, 'IU APC BACK-UPS (SERVER)\r\n', NULL, NULL, '1530', '00001', '2016-03-16', '2016-03-16', '3350.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:24');
INSERT INTO `subsidiary` VALUES (196, 50, '1U AIRCON-KOPPEL\r\n', NULL, NULL, '1530', '00001', '2017-04-29', '2017-04-29', '116702.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:27');
INSERT INTO `subsidiary` VALUES (197, 50, 'CAMERA DAHUA  HDCVI/CCTV INSTALL\r\n', NULL, NULL, '1530', '00001', '2019-06-05', '2019-06-05', '3000.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:30');
INSERT INTO `subsidiary` VALUES (198, 50, '1SET COMPUTER-ACER\r\n', NULL, NULL, '1530', '00002', '2014-01-11', '2014-01-11', '19555.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:32');
INSERT INTO `subsidiary` VALUES (199, 50, 'OFFICE TABLE\r\n', NULL, NULL, '1530', '00002', '2014-06-03', '2014-06-03', '1200.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:35');
INSERT INTO `subsidiary` VALUES (200, 50, 'GANG CHAIR\r\n', NULL, NULL, '1530', '00002', '2014-07-04', '2014-07-04', '3000.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:37');
INSERT INTO `subsidiary` VALUES (201, 50, 'AIRCON-LG INVERTER V\r\n', NULL, NULL, '1530', '00002', '2014-07-03', '2014-07-03', '43000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:39');
INSERT INTO `subsidiary` VALUES (202, 50, '1 SAMSUNG CELLPHONE\r\n', NULL, NULL, '1530', '00002', '2014-08-28', '2014-08-28', '1490.00\r\n', '4', '4', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:42');
INSERT INTO `subsidiary` VALUES (203, 50, '1U COMPUTER SET\r\n', NULL, NULL, '1530', '00002', '2015-01-28', '2015-01-28', '17125.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:44');
INSERT INTO `subsidiary` VALUES (204, 50, '1U PRINTER-EPSON L210\r\n', NULL, NULL, '1530', '00002', '2015-01-28', '2015-01-28', '7795.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:46');
INSERT INTO `subsidiary` VALUES (205, 50, '1U CANON CAMERA\r\n', NULL, NULL, '1530', '00002', '2016-03-10', '2016-03-10', '4948.50\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:48');
INSERT INTO `subsidiary` VALUES (206, 50, 'UPS\r\n', NULL, NULL, '1530', '00002', '2016-12-28', '2016-12-28', '2695.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:50');
INSERT INTO `subsidiary` VALUES (208, 50, 'LED COMPUTER MONITOR-PHILLIPS\r\n', NULL, NULL, '1530', '00002', '2016-12-28', '2016-12-28', '4100.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:52');
INSERT INTO `subsidiary` VALUES (209, 50, 'HEAD PHONE-BLACK\r\n', NULL, NULL, '1530', '00002', '2016-12-28', '2016-12-28', '1499.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:54');
INSERT INTO `subsidiary` VALUES (210, 50, '4 CCTV CAMERA\r\n', NULL, NULL, '1530', '00002', '2017-02-07', '2017-02-07', '29545.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:57');
INSERT INTO `subsidiary` VALUES (211, 50, '1U AIRCON SAMSUNG\r\n', NULL, NULL, '1530', '00002', '2018-07-02', '2018-07-02', '45995.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:17:59');
INSERT INTO `subsidiary` VALUES (213, 50, 'LABOR PULL OUT/INSTALL AIRCON\r\n', NULL, NULL, '1530', '00002', '2015-07-03', '2015-07-03', '9000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:03');
INSERT INTO `subsidiary` VALUES (214, 50, 'UPS\r\n', NULL, NULL, '1530', '00001', '2011-08-29', '2011-08-29', '2750.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:05');
INSERT INTO `subsidiary` VALUES (215, 50, 'BAR STOOL #5027\r\n', NULL, NULL, '1515', '00000', '2015-01-28', '2015-01-28', '2571.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:08');
INSERT INTO `subsidiary` VALUES (216, 50, 'OFFICE CHAIR\r\n', NULL, NULL, '1515', '00000', '2015-01-28', '2015-01-28', '2187.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:10');
INSERT INTO `subsidiary` VALUES (217, 50, 'OFFICE TABLE\r\n', NULL, NULL, '1515', '00000', '2015-01-28', '2015-01-28', '2231.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:12');
INSERT INTO `subsidiary` VALUES (218, 50, '2U VISITORS CHAIR\r\n', NULL, NULL, '1515', '00000', '2015-07-20', '2015-07-20', '2296.80\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:18:14');
INSERT INTO `subsidiary` VALUES (219, 50, '1U EXECUTIVE CHAIR\r\n', NULL, NULL, '1515', '00000', '2015-07-20', '2015-07-20', '4725.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:16');
INSERT INTO `subsidiary` VALUES (220, 50, 'OFFICE TABLE & CHAIR\r\n', NULL, NULL, '1515', '00000', '2015-11-05', '2015-11-05', '7326.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:20');
INSERT INTO `subsidiary` VALUES (221, 50, 'AIRPOT\r\n', NULL, NULL, '1515', '00000', '2016-02-22', '2016-02-22', '2204.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:22');
INSERT INTO `subsidiary` VALUES (222, 50, '1 TABLE 26CX18.2 FOLDING CHAIR\r\n', NULL, NULL, '1515', '00000', '2016-08-10', '2016-08-10', '3515.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:25');
INSERT INTO `subsidiary` VALUES (223, 50, '2U VISITORS CHAIR\r\n', NULL, NULL, '1515', '00000', '2016-02-22', '2016-02-22', '2571.40\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:27');
INSERT INTO `subsidiary` VALUES (224, 50, '2PCS CASH BOX\r\n', NULL, NULL, '1515', '00000', '2016-10-10', '2016-10-10', '1039.50\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:35');
INSERT INTO `subsidiary` VALUES (225, 50, 'CASH VAULT-FIRE PROOF\r\n', NULL, NULL, '1515', '00000', '2016-10-10', '2016-10-10', '37250.15\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:38');
INSERT INTO `subsidiary` VALUES (226, 50, 'PORTABLE BBQ & FOLDING CHAIR\r\n', NULL, NULL, '1515', '00000', '2016-10-10', '2016-10-10', '3779.35\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:19:42');
INSERT INTO `subsidiary` VALUES (227, 50, '1U MICROWAVE STAND-COFFEE\r\n', NULL, NULL, '1515', '00000', '2016-02-27', '2016-02-27', '2314.80\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:28:54');
INSERT INTO `subsidiary` VALUES (228, 50, 'STEEL DIVIDER FOR SERVER\r\n', NULL, NULL, '1515', '00000', '2017-01-27', '2017-01-27', '4836.75\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:28:58');
INSERT INTO `subsidiary` VALUES (229, 50, '1 STEEL LADDER\r\n', NULL, NULL, '1515', '00000', '2018-02-26', '2018-02-26', '5370.00\r\n', '5', '5', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:29:01');
INSERT INTO `subsidiary` VALUES (230, 50, 'SLIDING WINDOW/WINDOW BLINDS\r\n', NULL, NULL, '1515', '00000', '2018-06-21', '2018-06-21', '7000.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:29:06');
INSERT INTO `subsidiary` VALUES (231, 50, 'OFFICE TABLE\r\n', NULL, NULL, '1515', '00001', NULL, NULL, '4195.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:29:08');
INSERT INTO `subsidiary` VALUES (232, 50, 'OFFICE BENCH\r\n', NULL, NULL, '1515', '00001', NULL, NULL, '1200.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:29:24');
INSERT INTO `subsidiary` VALUES (233, 50, 'EXECUTIVE CHAIR\r\n', NULL, NULL, '1515', '00001', NULL, NULL, '1700.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:29:27');
INSERT INTO `subsidiary` VALUES (234, 50, 'COMPUTER CHAIR\r\n', NULL, NULL, '1515', '00001', NULL, NULL, '2906.25\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:34');
INSERT INTO `subsidiary` VALUES (235, 50, 'EXECUTIVE TABLE\r\n', NULL, NULL, '1515', '00001', '2011-07-16', '2011-07-16', '4455.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:38');
INSERT INTO `subsidiary` VALUES (236, 50, 'CHAIR\r\n', NULL, NULL, '1515', '00001', '2011-07-16', '2011-07-16', '891.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:40');
INSERT INTO `subsidiary` VALUES (237, 50, 'COMPUTER CHAIR\r\n', NULL, NULL, '1515', '00001', '2011-12-19', '2011-12-19', '1638.00\r\n', '1', '1', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:43');
INSERT INTO `subsidiary` VALUES (238, 50, '1U OFFICE TABLE L-SHAPE JOF-888\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '2812.50\r\n', '6', '6', '10.02', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:45');
INSERT INTO `subsidiary` VALUES (239, 50, '1U OFFICE TABLE NO.1088\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '2230.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:47');
INSERT INTO `subsidiary` VALUES (240, 50, '1U OFFICE CHAIR TX-7804 BOOKKER\'S\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '1755.00\r\n', '6', '6', '9.97', NULL, '2022-06-09 00:00:00', '2022-06-09 15:30:55');
INSERT INTO `subsidiary` VALUES (241, 50, '1U EXECUTIVE CHAIR NO.1025\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '2565.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:31:30');
INSERT INTO `subsidiary` VALUES (242, 50, '1U MOBILE DRAWER JPC-001\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '2528.00\r\n', '6', '6', '9.95', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:02');
INSERT INTO `subsidiary` VALUES (243, 50, '1U COMPUTER TABLE FL-PC-1300\r\n', NULL, NULL, '1515', '00001', '2013-07-22', '2013-07-22', '1912.50\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:08');
INSERT INTO `subsidiary` VALUES (244, 50, '2U 4 SEATERS GANG CHAIR\r\n', NULL, NULL, '1515', '00001', '2013-07-23', '2013-07-23', '3000.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:12');
INSERT INTO `subsidiary` VALUES (245, 50, 'UNITS CHAIRS\r\n', NULL, NULL, '1515', '00001', '2013-07-25', '2013-07-25', '1894.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:14');
INSERT INTO `subsidiary` VALUES (246, 50, 'WINDOW GRILLS\r\n', NULL, NULL, '1515', '00001', '2013-08-16', '2013-08-16', '8000.00\r\n', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:17');
INSERT INTO `subsidiary` VALUES (247, 50, '2U COMPUTER CHAIRS\r\n', NULL, NULL, '1515', '00001', '2013-11-15', '2013-11-15', '3474.00\r\n', '2', '2', '5.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:19');
INSERT INTO `subsidiary` VALUES (248, 50, 'EXECUTIVE TABLE\r\n', NULL, NULL, '1515', '00001', '2013-11-22', '2013-11-22', '8475.00\r\n', '1', '1', '5.13', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:21');
INSERT INTO `subsidiary` VALUES (250, 50, '1U VISITORS CHAIR\r\n', NULL, NULL, '1515', '00001', '2016-02-22', '2016-02-22', '900.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:26');
INSERT INTO `subsidiary` VALUES (251, 50, 'OFFICE CHAIR\r\n', NULL, NULL, '1515', '00001', '2016-02-22', '2016-02-22', '2601.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:29');
INSERT INTO `subsidiary` VALUES (252, 50, '8PCS PLASTIC MONOBLOCK CHAIR\r\n', NULL, NULL, '1515', '00001', '2016-08-23', '2016-08-23', '4200.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:32');
INSERT INTO `subsidiary` VALUES (253, 50, '8PCS PLASTIC MONOBLOCK CHAIR\r\n', NULL, NULL, '1515', '00001', '2016-02-22', '2016-02-22', '3160.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:34');
INSERT INTO `subsidiary` VALUES (254, 50, 'YELLOW PLASTIC TABLE\r\n', NULL, NULL, '1515', '00001', '2016-05-07', '2016-05-07', '2515.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:36');
INSERT INTO `subsidiary` VALUES (255, 50, 'FIRE EXTINGUISHER\r\n', NULL, NULL, '1515', '00001', '2017-01-24', '2017-01-24', '1500.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:38');
INSERT INTO `subsidiary` VALUES (256, 50, 'LIGHTED SIGNAGE,PANAFLEX4X13 FT ETC\r\n', NULL, NULL, '1515', '00001', '2017-09-12', '2017-09-12', '23400.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:40');
INSERT INTO `subsidiary` VALUES (257, 50, 'WINDOW BLINDS\r\n', NULL, NULL, '1515', '00001', '2018-06-01', '2018-06-01', '14940.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:43');
INSERT INTO `subsidiary` VALUES (258, 50, '1U VISITOR\'S CHAIR\r\n', NULL, NULL, '1515', '00002', '2016-02-22', '2016-02-22', '900.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:46');
INSERT INTO `subsidiary` VALUES (259, 50, 'STEEL CABINET\r\n', NULL, NULL, '1515', '00002', '2016-02-22', '2016-02-22', '7628.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:49');
INSERT INTO `subsidiary` VALUES (260, 50, 'FIRE EXTINGUISHER\r\n', NULL, NULL, '1515', '00002', '2017-02-07', '2017-02-07', '1500.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:52');
INSERT INTO `subsidiary` VALUES (261, 50, 'VAULT & TABLE\r\n', NULL, NULL, '1515', '00002', '2018-03-16', '2018-03-16', '25464.04\r\n', '24', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:56');
INSERT INTO `subsidiary` VALUES (262, 50, 'TABLE 32X32\r\n', NULL, NULL, '1515', '00002', '2018-05-01', '2018-05-01', '1420.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:32:59');
INSERT INTO `subsidiary` VALUES (263, 50, 'TABLE\r\n', NULL, NULL, '1515', '00002', '2018-05-01', '2018-05-01', '3850.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:01');
INSERT INTO `subsidiary` VALUES (264, 50, 'KITCHEN TABLE/LABABO\r\n', NULL, NULL, '1515', '00002', '2018-05-01', '2018-05-01', '5295.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:04');
INSERT INTO `subsidiary` VALUES (265, 50, 'MSI-LOW CEILING LAMP APOLLO/BULB\r\n', NULL, NULL, '1515', '00002', '2018-06-20', '2018-06-20', '4678.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:07');
INSERT INTO `subsidiary` VALUES (266, 50, '2U GANG CHAIR 4 SEATERS\r\n', NULL, NULL, '1515', '00002', '2018-07-05', '2018-07-05', '14040.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:14');
INSERT INTO `subsidiary` VALUES (267, 50, 'TIRE WHEELS LMT993\r\n', NULL, NULL, '1545', '00000', '2016-06-01', '2016-06-01', '23000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:18');
INSERT INTO `subsidiary` VALUES (268, 50, '11 PLATES BATTERY\r\n', NULL, NULL, '1545', '00000', '2016-06-07', '2016-06-07', '4500.00\r\n', '6', '6', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:21');
INSERT INTO `subsidiary` VALUES (269, 50, 'MUGS & TIRE KFK558\r\n', NULL, NULL, '1545', '00000', '2017-03-03', '2017-03-03', '50000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:33:23');
INSERT INTO `subsidiary` VALUES (270, 50, 'MUGS & TIRE KFK558\r\n', NULL, NULL, '1545', '00000', '2017-06-02', '2017-06-02', '25000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:10');
INSERT INTO `subsidiary` VALUES (271, 50, '1PC MOTOLITE GOLD N76 HILUX\r\n', NULL, NULL, '1545', '00000', '2018-05-31', '2018-05-31', '6500.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:14');
INSERT INTO `subsidiary` VALUES (272, 50, '4 TIRES RADAR 235 XKZ118\r\n', NULL, NULL, '1545', '00000', '2018-07-02', '2018-07-02', '19200.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:18');
INSERT INTO `subsidiary` VALUES (273, 50, 'SPIDER HELMET\r\n', NULL, NULL, '1545', '00000', '2018-09-17', '2018-09-17', '3820.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:22');
INSERT INTO `subsidiary` VALUES (274, 50, 'GIVI BOX\r\n', NULL, NULL, '1545', '00000', '2018-09-17', '2018-09-17', '3800.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:26');
INSERT INTO `subsidiary` VALUES (275, 50, '10PCS VEST/SHIPPING FEE\r\n', NULL, NULL, '1545', '00000', '2018-09-26', '2018-09-26', '3032.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:28');
INSERT INTO `subsidiary` VALUES (276, 50, 'FORD-UWO323\r\n', NULL, NULL, '1545', '00000', '2019-07-02', '2019-07-02', '200000.00\r\n', '26', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:31');
INSERT INTO `subsidiary` VALUES (277, 50, 'FORD-CASA(PARTS/SERVICE DEPOSIT)\r\n', NULL, NULL, '1545', '00000', '2019-07-05', '2019-07-05', '16080.70\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:33');
INSERT INTO `subsidiary` VALUES (278, 50, 'FORD-BODY (BUILDING & REPAINTING)\r\n', NULL, NULL, '1545', '00000', '2019-07-17', '2019-07-17', '12500.00\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:36');
INSERT INTO `subsidiary` VALUES (279, 50, 'FORD-BATTERY & LUGNUT\r\n', NULL, NULL, '1545', '00000', '2019-07-22', '2019-07-22', '5892.86\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:39');
INSERT INTO `subsidiary` VALUES (280, 50, 'FORD-PARTS & LABOR\r\n', NULL, NULL, '1545', '00000', '2019-07-24', '2019-07-24', '5973.65\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:42');
INSERT INTO `subsidiary` VALUES (281, 50, 'FORD-PARTS DEPOSIT\r\n', NULL, NULL, '1545', '00000', '2019-07-24', '2019-07-24', '13958.35\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:44');
INSERT INTO `subsidiary` VALUES (282, 50, 'SPIDER HELMET\r\n', NULL, NULL, '1545', '00000', '2019-07-17', '2019-07-17', '10784.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:48');
INSERT INTO `subsidiary` VALUES (283, 50, 'HONDA CB110 BLUE MS41906\r\n', NULL, NULL, '1545', '00001', '2015-04-30', '2015-04-30', '10784.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:51');
INSERT INTO `subsidiary` VALUES (284, 50, 'HONDA CB110 BLUE MS51034\r\n', NULL, NULL, '1545', '00001', '2015-07-10', '2015-07-10', '66500.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:53');
INSERT INTO `subsidiary` VALUES (285, 50, 'MAGS FOR MULTICAB\r\n', NULL, NULL, '1545', '00001', '2016-09-13', '2016-09-13', '24075.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:55');
INSERT INTO `subsidiary` VALUES (286, 50, 'MULTICAB REPAIR\r\n', NULL, NULL, '1545', '00001', '2016-09-15', '2016-09-15', '39647.00\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:34:57');
INSERT INTO `subsidiary` VALUES (287, 50, 'REPAIR MULTICAB-CLIENT 1/27,26/16\r\n', NULL, NULL, '1545', '00001', '2016-01-27', '2016-01-27', '41039.00\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:00');
INSERT INTO `subsidiary` VALUES (288, 50, 'REPAIR MULTICAB\r\n', NULL, NULL, '1545', '00001', '2016-10-03', '2016-10-03', '25844.00\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:02');
INSERT INTO `subsidiary` VALUES (291, 50, 'RAIDER R SUZUKI 4979OF\r\n', NULL, NULL, '1545', '00001', '2011-12-01', '2011-12-01', '61850.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:04');
INSERT INTO `subsidiary` VALUES (292, 50, 'YAMAHA XTZ MS150101\r\n', NULL, NULL, '1545', '00001', '2017-01-04', '2017-01-04', '99080.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:06');
INSERT INTO `subsidiary` VALUES (293, 50, '1 MOTORCYCLE BOX MS41906\r\n', NULL, NULL, '1545', '00001', '2018-05-25', '2018-05-25', '700.00\r\n', '1', '1', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:08');
INSERT INTO `subsidiary` VALUES (294, 50, '3PCS HELMET @2,730 EACH\r\n', NULL, NULL, '1545', '00001', '2018-09-17', '2018-09-17', '8190.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:10');
INSERT INTO `subsidiary` VALUES (295, 50, 'HONDA CB110-SILVER MS13783\r\n', NULL, NULL, '1545', '00002', '2014-03-25', '2014-03-25', '81076.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:12');
INSERT INTO `subsidiary` VALUES (296, 50, 'HONDA CB110-SILVER MS55149\r\n', NULL, NULL, '1545', '00002', '2015-08-15', '2015-08-15', '81076.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:15');
INSERT INTO `subsidiary` VALUES (297, 50, 'ISUZU CROSSWIND-XKZ118\r\n', NULL, NULL, '1545', '00002', '2016-03-16', '2016-03-16', '320668.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:17');
INSERT INTO `subsidiary` VALUES (298, 50, '2ND HAND XRM BLACK-1864KJ\r\n', NULL, NULL, '1545', '00002', '2016-03-07', '2016-03-07', '35000.00\r\n', '24', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:19');
INSERT INTO `subsidiary` VALUES (299, 50, 'TIRE CROSSWIND PARTIAL\r\n', NULL, NULL, '1545', '00002', '2016-07-04', '2016-07-04', '15000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:21');
INSERT INTO `subsidiary` VALUES (300, 50, 'TIRE-CROSSWIND FULL PAYMENT\r\n', NULL, NULL, '1545', '00002', '2016-08-12', '2016-08-12', '15000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:24');
INSERT INTO `subsidiary` VALUES (301, 50, 'CROSSWIND BATTERY\r\n', NULL, NULL, '1545', '00002', '2016-09-07', '2016-09-07', '4000.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:26');
INSERT INTO `subsidiary` VALUES (302, 50, 'YAMAHA XTZ125 BLUE MS84310\r\n', NULL, NULL, '1545', '00002', '2016-07-18', '2016-07-18', '99380.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:28');
INSERT INTO `subsidiary` VALUES (303, 50, 'MIO SPORTY-ALFARO,KAREN MS48698\r\n', NULL, NULL, '1545', '00002', '2018-08-06', '2018-08-06', '24012.00\r\n', '36', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:29');
INSERT INTO `subsidiary` VALUES (304, 50, '2PCS HELMET @2,730 EACH\r\n', NULL, NULL, '1545', '00002', '2018-09-17', '2018-09-17', '5460.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:31');
INSERT INTO `subsidiary` VALUES (305, 50, 'HONDA XR150 RED 150107\r\n', NULL, NULL, '1545', '00002', '2019-06-10', '2019-06-10', '101820.00\r\n', '27', '36', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:33');
INSERT INTO `subsidiary` VALUES (306, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00000', '2018-07-06', '2018-07-06', '48342.73\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:35');
INSERT INTO `subsidiary` VALUES (307, 19, 'HILUX INSURANCE RENEWAL RGSTRATION\r\n', NULL, NULL, '1415', '00000', '2018-08-09', '2018-08-09', '14075.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:37');
INSERT INTO `subsidiary` VALUES (308, 19, 'XKZ118 INSURANCE RENWAL RGSTRATION\r\n', NULL, NULL, '1415', '00000', '2018-08-09', '2018-08-09', '10328.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:41');
INSERT INTO `subsidiary` VALUES (309, 19, 'PHILAM LIFE INSURANCE ADDTL\r\n', NULL, NULL, '1415', '00000', '2018-10-22', '2018-10-22', '4188.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:44');
INSERT INTO `subsidiary` VALUES (310, 19, 'PHILAM LIFE HEALTH LINK RENEWAL\r\n', NULL, NULL, '1415', '00000', '2018-10-23', '2018-10-23', '55000.50\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:46');
INSERT INTO `subsidiary` VALUES (311, 19, 'ST PETER ANNUAL FEE\r\n', NULL, NULL, '1415', '00000', '2019-01-22', '2019-01-22', '16000.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:48');
INSERT INTO `subsidiary` VALUES (312, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00000', '2019-01-31', '2019-01-31', '48342.73\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:49');
INSERT INTO `subsidiary` VALUES (313, 19, 'PHILAM LIFE INSURANCE-JCPA\r\n', NULL, NULL, '1415', '00000', '2019-02-06', '2019-02-06', '25727.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:35:54');
INSERT INTO `subsidiary` VALUES (314, 19, 'MIRAGELMT993 INSURANCE RNWAL RGSTRN\r\n', NULL, NULL, '1415', '00000', '2019-03-13', '2019-03-13', '13460.00\r\n', '9', '9', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:02');
INSERT INTO `subsidiary` VALUES (315, 19, 'CRYPTONKT4224 INSURNCE RNWAL RGSTRN\r\n', NULL, NULL, '1415', '00000', '2019-04-29', '2019-04-29', '537.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:04');
INSERT INTO `subsidiary` VALUES (316, 19, 'ANNUAL EXECUTIVE MEDICAL CHECK UP\r\n', NULL, NULL, '1415', '00000', '2019-07-10', '2019-07-10', '27000.00\r\n', '7', '7', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:07');
INSERT INTO `subsidiary` VALUES (318, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00000', '2019-07-12', '2019-07-12', '48342.73\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:09');
INSERT INTO `subsidiary` VALUES (319, 19, 'PHILAM LIFE INSURANCE JCPA ADDTL\r\n', NULL, NULL, '1415', '00000', '2019-01-24', '2019-01-24', '4860.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:10');
INSERT INTO `subsidiary` VALUES (320, 19, 'YAMAHA XTZ WHTE150101-INS RNWL REG\r\n', NULL, NULL, '1415', '00001', '2019-04-29', '2019-04-29', '690.00\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:12');
INSERT INTO `subsidiary` VALUES (321, 19, '1864KJ INSURANCE RNWAL REGISTRATION\r\n', NULL, NULL, '1415', '00001', '2019-06-21', '2019-06-21', '537.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:19');
INSERT INTO `subsidiary` VALUES (322, 19, 'MS41906 INSURANCE RNWAL RGSTRATION\r\n', NULL, NULL, '1415', '00001', '2019-03-13', '2019-03-13', '691.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:21');
INSERT INTO `subsidiary` VALUES (323, 19, 'MS13783 INSURANCE RNWL REGISTRATION\r\n', NULL, NULL, '1415', '00002', '2019-04-29', '2019-04-29', '691.00\r\n', '9', '9', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:23');
INSERT INTO `subsidiary` VALUES (324, 19, 'MS51034 INSURANCE RNWAL RGSTRATION\r\n', NULL, NULL, '1415', '00002', '2012-01-10', '2012-01-10', '541.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:26');
INSERT INTO `subsidiary` VALUES (325, 20, 'BLDG & LOT REAL PROPERTY TAX\r\n', NULL, NULL, '1415', '00000', '2019-03-13', '2019-03-13', '1676.72\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:28');
INSERT INTO `subsidiary` VALUES (326, 20, 'LMT993-LTO RNWAL REGISTRATION\r\n', NULL, NULL, '1415', '00000', '2019-04-29', '2019-04-29', '3030.00\r\n', '9', '9', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:29');
INSERT INTO `subsidiary` VALUES (327, 20, 'CRYPTON KT4224-LTO RNWAL RGSTRATION\r\n', NULL, NULL, '1415', '00000', '2019-07-03', '2019-07-03', '1490.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:31');
INSERT INTO `subsidiary` VALUES (328, 20, 'DST-FORM10-1\r\n', NULL, NULL, '1415', '00000', '2019-01-09', '2019-01-09', '49600.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:33');
INSERT INTO `subsidiary` VALUES (329, 20, 'BUSINESS PERMIT 2019-BUTUAN\r\n', NULL, NULL, '1415', '00001', '2019-01-24', '2019-01-24', '55827.04\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:35');
INSERT INTO `subsidiary` VALUES (330, 20, 'BUSINESS PERMIT 2019-BUTUAN\r\n', NULL, NULL, '1415', '00001', '2019-04-29', '2019-04-29', '1446.00\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:36:37');
INSERT INTO `subsidiary` VALUES (331, 20, '1864KJ LTO RNEWAL REGISTRATION\r\n', NULL, NULL, '1415', '00001', '2019-06-21', '2019-06-21', '1490.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:43');
INSERT INTO `subsidiary` VALUES (332, 20, 'MS41906 LTO RENWAL REGISTRATION\r\n', NULL, NULL, '1415', '00001', '2019-01-15', '2019-01-15', '1241.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:45');
INSERT INTO `subsidiary` VALUES (333, 20, 'BUSINESS PERMIT 2019-NASIPIT\r\n', NULL, NULL, '1415', '00002', '2019-03-13', '2019-03-13', '16433.28\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:47');
INSERT INTO `subsidiary` VALUES (334, 20, 'MS13783 LTO RENWL RGSTRATION\r\n', NULL, NULL, '1415', '00002', '2019-04-29', '2019-04-29', '1266.00\r\n', '9', '9', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:49');
INSERT INTO `subsidiary` VALUES (335, 20, 'MS51034 LTO RENWAL REGISTRATION\r\n', NULL, NULL, '1415', '00002', '2017-04-24', '2017-04-24', '1490.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:51');
INSERT INTO `subsidiary` VALUES (336, 22, 'BUTUAN VPH REALTY CORP\r\n', NULL, NULL, '1415', '00001', '2014-06-30', '2014-06-30', '69000.00\r\n', '2', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:58');
INSERT INTO `subsidiary` VALUES (337, 41, 'CALIXTO R FELIAS\r\n', NULL, NULL, '1415', '00002', '2014-06-30', '2014-06-30', '12000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:36:59');
INSERT INTO `subsidiary` VALUES (338, 23, 'UNIFORM-DOWN PAYMENT 2SETS G/B\r\n', NULL, NULL, '1415', '00000', '2019-04-09', '2019-04-09', '20000.00\r\n', '24', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:01');
INSERT INTO `subsidiary` VALUES (339, 23, 'UNIFORM-FULL PAYMENT 2SETS G/B\r\n', NULL, NULL, '1415', '00000', '2019-06-10', '2019-06-10', '25800.00\r\n', '24', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:03');
INSERT INTO `subsidiary` VALUES (340, 52, 'ACASO GENEFONA\r\n', NULL, NULL, '2100', '00002', '2019-01-10', '2019-01-10', '2970.00\r\n', '9', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:04');
INSERT INTO `subsidiary` VALUES (341, 52, 'GABO, RHAYMA\r\n', NULL, NULL, '2100', '00002', '2019-02-07', '2019-02-07', '2700.00\r\n', '8', '10', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:06');
INSERT INTO `subsidiary` VALUES (342, 52, 'PELAEZ, ALFREDO\r\n', NULL, NULL, '2100', '00002', '2019-02-21', '2019-02-21', '1050.00\r\n', '8', '10', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:08');
INSERT INTO `subsidiary` VALUES (343, 52, 'FELIAS, MANOLO\r\n', NULL, NULL, '2100', '00002', '2019-03-08', '2019-03-08', '945.00\r\n', '7', '9', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:09');
INSERT INTO `subsidiary` VALUES (344, 52, 'TIEMPO, ISIDRO\r\n', NULL, NULL, '2100', '00002', '2019-04-23', '2019-04-23', '480.00\r\n', '5', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:11');
INSERT INTO `subsidiary` VALUES (345, 52, 'BERNALDEZ, ALFREDO\r\n', NULL, NULL, '2100', '00002', '2019-06-24', '2019-06-24', '540.00\r\n', '3', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:12');
INSERT INTO `subsidiary` VALUES (346, 52, 'LORCA, ROSITA\r\n', NULL, NULL, '2100', '00002', '2019-07-25', '2019-07-25', '675.00\r\n', '2', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:14');
INSERT INTO `subsidiary` VALUES (347, 52, 'ORTIZ, CELSA\r\n', NULL, NULL, '2100', '00002', '2019-07-29', '2019-07-29', '645.00\r\n', '2', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:16');
INSERT INTO `subsidiary` VALUES (348, 52, 'ROJAS, NONITO\r\n', NULL, NULL, '2100', '00001', '2019-02-13', '2019-02-13', '600.00\r\n', '8', '10', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:18');
INSERT INTO `subsidiary` VALUES (349, 52, 'REMITAR, BASILIO\r\n', NULL, NULL, '2100', '00001', '2019-04-05', '2019-04-05', '720.00\r\n', '6', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:20');
INSERT INTO `subsidiary` VALUES (350, 52, 'REMITAR, BASILIO\r\n', NULL, NULL, '2100', '00001', '2019-05-24', '2019-05-24', '3150.00\r\n', '4', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:22');
INSERT INTO `subsidiary` VALUES (351, 52, 'ADLAON, ANTONIO\r\n', NULL, NULL, '2100', '00001', '2019-05-10', '2019-05-10', '840.00\r\n', '2', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:24');
INSERT INTO `subsidiary` VALUES (352, 52, 'APLAYA, ALLAN\r\n', NULL, NULL, '2100', '00001', '2019-07-24', '2019-07-24', '1125.00\r\n', '2', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:37:26');
INSERT INTO `subsidiary` VALUES (353, 51, 'SOFTWARE\r\n', NULL, NULL, '1570', '00000', NULL, NULL, '20445.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:31');
INSERT INTO `subsidiary` VALUES (354, 51, 'DELL POWER EDGE T130 SERVER\r\n', NULL, NULL, '1570', '00000', NULL, NULL, '21262.59\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:37:33');
INSERT INTO `subsidiary` VALUES (355, 51, 'SYSTEM INSTALLATION-06/28/17\r\n', NULL, NULL, '1570', '00000', '2017-06-28', '2017-06-28', '60000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:39');
INSERT INTO `subsidiary` VALUES (356, 51, 'SYSTEM INSTALLATION-09/22/17\r\n', NULL, NULL, '1570', '00000', '2017-09-22', '2017-09-22', '60000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:41');
INSERT INTO `subsidiary` VALUES (357, 51, 'SYSTEM INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2017-12-27', '2017-12-27', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:43');
INSERT INTO `subsidiary` VALUES (358, 51, 'SYSTEM INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2018-01-19', '2018-01-19', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:44');
INSERT INTO `subsidiary` VALUES (359, 51, 'SYSTEM INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2018-02-26', '2018-02-26', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:46');
INSERT INTO `subsidiary` VALUES (360, 51, 'SYSTEM  INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2018-03-26', '2018-03-26', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:49');
INSERT INTO `subsidiary` VALUES (361, 51, 'SYSTEM INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2018-04-17', '2018-04-17', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:51');
INSERT INTO `subsidiary` VALUES (362, 51, 'SYSTEM INSTALLATION\r\n', NULL, NULL, '1570', '00000', '2018-05-17', '2018-05-17', '20000.00\r\n', '47', '48', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:52');
INSERT INTO `subsidiary` VALUES (363, 54, 'OFFICIAL RECEIPTS-07/23/18\r\n', NULL, NULL, '1410', '00002', '2018-07-23', '2018-07-23', '25000.00\r\n', '431', '500', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:54');
INSERT INTO `subsidiary` VALUES (364, 54, 'OFFICIAL RECEIPTS-02/22/19\r\n', NULL, NULL, '1410', '00001', '2019-02-22', '2019-02-22', '29910.71\r\n', '244', '500', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:56');
INSERT INTO `subsidiary` VALUES (365, 28, '2PCS PIPE,36M THHN WIRE#10 100THNN\r\n', NULL, NULL, '1560', '00001', '2017-05-03', '2017-05-03', '3999.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:37:58');
INSERT INTO `subsidiary` VALUES (366, 28, '2PC MOULDING 1 1/2\r\n', NULL, NULL, '1560', '00001', '2017-05-18', '2017-05-18', '374.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:03');
INSERT INTO `subsidiary` VALUES (367, 28, 'TARPAULIN,EPOXY,BRUSH,BORAL\r\n', NULL, NULL, '1560', '00001', '2017-05-19', '2017-05-19', '4010.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:05');
INSERT INTO `subsidiary` VALUES (368, 28, 'CCTV INSTALLATION-7 CAMERAS\r\n', NULL, NULL, '1560', '00001', '2017-05-29', '2017-05-29', '3500.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:07');
INSERT INTO `subsidiary` VALUES (369, 28, 'INSTALL AIRCON,MAKER & SIGNS\r\n', NULL, NULL, '1560', '00001', '2017-05-30', '2017-05-30', '9635.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:09');
INSERT INTO `subsidiary` VALUES (370, 28, 'VARIOUS MATERIALS NEW OFFICE 050517\r\n', NULL, NULL, '1560', '00001', '2017-05-05', '2017-05-05', '8936.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:10');
INSERT INTO `subsidiary` VALUES (371, 28, 'VARIOUS MATERIALS-NEW OFFICE 050817\r\n', NULL, NULL, '1560', '00001', '2017-05-08', '2017-05-08', '3876.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:12');
INSERT INTO `subsidiary` VALUES (372, 28, 'VARIOUS MATERIALS-NEW OFFICE 051617\r\n', NULL, NULL, '1560', '00001', '2017-05-16', '2017-05-16', '6356.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:14');
INSERT INTO `subsidiary` VALUES (373, 28, 'MATERIALS FOR PAINTING NEW OFFICE\r\n', NULL, NULL, '1560', '00001', '2017-05-18', '2017-05-18', '22000.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:16');
INSERT INTO `subsidiary` VALUES (374, 28, 'LED LITE BULB12W/WOOD HANDLE/LOCK\r\n', NULL, NULL, '1560', '00001', '2017-05-19', '2017-05-19', '3792.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:24');
INSERT INTO `subsidiary` VALUES (375, 28, 'LABOR PAINTING-PARTIAL/MAT 4 PNTNG\r\n', NULL, NULL, '1560', '00001', '2017-05-20', '2017-05-20', '6898.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:27');
INSERT INTO `subsidiary` VALUES (376, 28, 'VAR MATERIALS/LABOR CLEANING-VCDU\r\n', NULL, NULL, '1560', '00001', '2017-05-22', '2017-05-22', '13741.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:29');
INSERT INTO `subsidiary` VALUES (377, 28, 'MOULDING/LIQ NAIL/PVC/HACKSW/TAPE\r\n', NULL, NULL, '1560', '00001', '2017-05-23', '2017-05-23', '4589.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:32');
INSERT INTO `subsidiary` VALUES (378, 28, 'ZU CONS-MAT/LABOR/EQUIPMENT\r\n', NULL, NULL, '1560', '00001', '2017-05-25', '2017-05-25', '86000.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:33');
INSERT INTO `subsidiary` VALUES (379, 28, 'LABOR PAINTING\r\n', NULL, NULL, '1560', '00001', '2017-05-25', '2017-05-25', '12000.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:38');
INSERT INTO `subsidiary` VALUES (380, 28, 'VARIOUS MATERIALS-VCDU 052917\r\n', NULL, NULL, '1560', '00001', '2017-05-29', '2017-05-29', '13220.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:44');
INSERT INTO `subsidiary` VALUES (381, 28, 'VARIOUS MATERIALS-VCDU 052917\r\n', NULL, NULL, '1560', '00001', '2017-05-29', '2017-05-29', '16191.00\r\n', '53', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:48');
INSERT INTO `subsidiary` VALUES (382, 28, 'VARIOUS MATERIALS-VCDU 060217\r\n', NULL, NULL, '1560', '00001', '2017-06-02', '2017-06-02', '2900.00\r\n', '52', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:53');
INSERT INTO `subsidiary` VALUES (383, 28, 'SUPPLY & INSTALL OF ALUMINUM WNDWS\r\n', NULL, NULL, '1560', '00001', '2017-06-06', '2017-06-06', '42000.00\r\n', '52', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:38:58');
INSERT INTO `subsidiary` VALUES (384, 28, 'LIGHTED SIGNAGE\r\n', NULL, NULL, '1560', '00001', '2017-05-31', '2017-05-31', '25000.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:01');
INSERT INTO `subsidiary` VALUES (385, 28, 'LABOR-ROMMEL TRILLO\r\n', NULL, NULL, '1560', '00001', '2018-07-12', '2018-07-12', '2550.00\r\n', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:04');
INSERT INTO `subsidiary` VALUES (386, 28, 'LABOR/ANGLE WALL/INSULATOR/DRILLSET\r\n', NULL, NULL, '1560', '00001', '2018-05-21', '2018-05-21', '2370.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:06');
INSERT INTO `subsidiary` VALUES (387, 28, '11M INSULATOR DOUBLE\r\n', NULL, NULL, '1560', '00001', '2018-05-22', '2018-05-22', '935.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:39:07');
INSERT INTO `subsidiary` VALUES (388, 28, 'CABINET DOOR-4 & 6 PANELS-1SET EACH\r\n', NULL, NULL, '1560', '00001', '2018-05-23', '2018-05-23', '6400.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:28');
INSERT INTO `subsidiary` VALUES (389, 28, 'LABOR\r\n', NULL, NULL, '1560', '00001', '2018-05-25', '2018-05-25', '1000.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:33');
INSERT INTO `subsidiary` VALUES (390, 28, 'LABOR/LGSCRW/CMENT/VAR MAT 053118\r\n', NULL, NULL, '1560', '00001', '2018-05-31', '2018-05-31', '1463.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:36');
INSERT INTO `subsidiary` VALUES (391, 28, 'P-MEGA/PURING/DRILLSET/MASONRY\r\n', NULL, NULL, '1560', '00001', '2018-06-04', '2018-06-04', '966.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:43');
INSERT INTO `subsidiary` VALUES (392, 28, 'LABOR 060518\r\n', NULL, NULL, '1560', '00001', '2018-06-05', '2018-06-05', '500.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:49');
INSERT INTO `subsidiary` VALUES (393, 28, 'LABOR/WALL FLOCKING/ZEAL\r\n', NULL, NULL, '1560', '00001', '2018-06-06', '2018-06-06', '1920.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:39:55');
INSERT INTO `subsidiary` VALUES (394, 28, 'LABOR/VARIOUS MATERIALS 060718\r\n', NULL, NULL, '1560', '00001', '2018-06-07', '2018-06-07', '2620.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:01');
INSERT INTO `subsidiary` VALUES (395, 28, 'LIGHTED SIGNAGE\r\n', NULL, NULL, '1560', '00002', '2017-11-14', '2017-11-14', '35000.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:04');
INSERT INTO `subsidiary` VALUES (396, 28, 'NAILS/HOLLOWBLOCK/TIEWRE/CMNT/INYAG\r\n', NULL, NULL, '1560', '00002', '2018-05-07', '2018-05-07', '1041.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:08');
INSERT INTO `subsidiary` VALUES (397, 28, 'PHL STNDRD/LAVATORY/LOCK DRAWER\r\n', NULL, NULL, '1560', '00002', '2018-05-08', '2018-05-08', '5189.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:11');
INSERT INTO `subsidiary` VALUES (398, 28, 'ELBW,PVC,SOLVNT,TAPELON,THRDED ELBW\r\n', NULL, NULL, '1560', '00002', '2018-05-12', '2018-05-12', '2485.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:15');
INSERT INTO `subsidiary` VALUES (399, 28, 'MARINE POXY/FLR DRAIN/ELBW/ETC\r\n', NULL, NULL, '1560', '00002', '2019-05-18', '2019-05-18', '1349.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:19');
INSERT INTO `subsidiary` VALUES (400, 28, 'LABOR\r\n', NULL, NULL, '1560', '00002', '2018-05-21', '2018-05-21', '500.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:22');
INSERT INTO `subsidiary` VALUES (401, 28, 'TILES/PLATINUM/SOLVNT/PVC CLIP\r\n', NULL, NULL, '1560', '00002', '2018-06-04', '2018-06-04', '207.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:25');
INSERT INTO `subsidiary` VALUES (402, 28, 'LABOR-ROMEL TRILLO\r\n', NULL, NULL, '1560', '00002', '2018-06-07', '2018-06-07', '100.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:52');
INSERT INTO `subsidiary` VALUES (403, 28, 'CEMENT/INAYAG\r\n', NULL, NULL, '1560', '00002', '2018-06-11', '2018-06-11', '250.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:40:58');
INSERT INTO `subsidiary` VALUES (404, 28, 'VARIOUS MAT FOR RENOV-061318\r\n', NULL, NULL, '1560', '00002', '2018-06-13', '2018-06-13', '2381.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:01');
INSERT INTO `subsidiary` VALUES (405, 28, 'MOLDNG,SURFACE BOX\r\n', NULL, NULL, '1560', '00002', '2018-06-13', '2018-06-13', '175.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:04');
INSERT INTO `subsidiary` VALUES (406, 28, 'LABOR/FEMALE ADOPTOR/WODTECK/ELBOW\r\n', NULL, NULL, '1560', '00002', '2018-06-18', '2018-06-18', '1808.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:08');
INSERT INTO `subsidiary` VALUES (407, 28, 'HINGE CONCEALED YALE/MLDING/WODTK\r\n', NULL, NULL, '1560', '00002', '2018-06-18', '2018-06-18', '1263.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:19');
INSERT INTO `subsidiary` VALUES (408, 28, 'LABOR-ROMEL TRILLO 062518\r\n', NULL, NULL, '1560', '00002', '2018-06-25', '2018-06-25', '750.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:23');
INSERT INTO `subsidiary` VALUES (409, 28, 'MARINE EPOXY,WIRE,MLDNG,PVC,ELBW\r\n', NULL, NULL, '1560', '00002', '2018-06-28', '2018-06-28', '781.00\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:25');
INSERT INTO `subsidiary` VALUES (411, 28, 'LABOR-ROMEL TRILLO 070518\r\n', NULL, NULL, '1560', '00002', '2018-07-05', '2018-07-05', '750.00\r\n', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:45');
INSERT INTO `subsidiary` VALUES (412, 28, 'PVC-PIPE,ELBW,BUSHING,CMNT,ETC\r\n', NULL, NULL, '1560', '00002', '2018-07-09', '2018-07-09', '3776.75\r\n', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:49');
INSERT INTO `subsidiary` VALUES (413, 28, '1SET WNDOW BLINDS/SLDNG WNDW\r\n', NULL, NULL, '1560', '00002', '2018-03-15', '2018-03-15', '6840.00\r\n', '24', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:53');
INSERT INTO `subsidiary` VALUES (414, 26, 'BORROWED FUNDS-ESPINA,L 030118\r\n', NULL, NULL, NULL, '', '2018-03-01', '2018-03-01', '400000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:56');
INSERT INTO `subsidiary` VALUES (415, 26, 'BORROWED FUNDS-ESPINA,L 051118\r\n', NULL, NULL, NULL, '', '2018-05-11', '2018-05-11', '300000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:41:59');
INSERT INTO `subsidiary` VALUES (416, 26, 'BORROWED FUNDS-ESPINA,L 081418\r\n', NULL, NULL, NULL, '', '2018-08-14', '2018-08-14', '400000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:01');
INSERT INTO `subsidiary` VALUES (417, 26, 'BORROWED FUNDS-GOMEZ,M 082918\r\n', NULL, NULL, NULL, '', '2018-08-29', '2018-08-29', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:06');
INSERT INTO `subsidiary` VALUES (418, 26, 'BORROWED FUNDS-GOMEZ,M 100218\r\n', NULL, NULL, NULL, '', '2018-10-02', '2018-10-02', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:08');
INSERT INTO `subsidiary` VALUES (419, 26, 'BORROWED FUNDS-GOMEZ,M 111618\r\n', NULL, NULL, NULL, '', '2018-11-16', '2018-11-16', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:11');
INSERT INTO `subsidiary` VALUES (420, 26, 'BORROWED FUNDS-GOMEZ,M 040219\r\n', NULL, NULL, NULL, '', '2019-04-02', '2019-04-02', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:14');
INSERT INTO `subsidiary` VALUES (421, 26, 'BORROWED FUNDS-GOMEZ, M 071019\r\n', NULL, NULL, NULL, '', '2019-07-10', '2019-07-10', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:17');
INSERT INTO `subsidiary` VALUES (422, 26, 'BORROWED FUNDS-GOMEZ,M 073019\r\n', NULL, NULL, NULL, '', '2019-07-30', '2019-07-30', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:21');
INSERT INTO `subsidiary` VALUES (423, 26, 'BORROWED FUNDS-CHAVEZ,M 082319\r\n', NULL, NULL, NULL, '', '2019-08-23', '2019-08-23', '200000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:25');
INSERT INTO `subsidiary` VALUES (424, 29, '1PC RAINCOAT 062215\r\n', NULL, NULL, NULL, '', '2015-11-07', '2015-11-07', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:27');
INSERT INTO `subsidiary` VALUES (425, 29, '1U CELLPHONE ACCTG\r\n', NULL, NULL, NULL, '', '2015-11-07', '2015-11-07', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:32');
INSERT INTO `subsidiary` VALUES (426, 29, 'NEWMEN KM-093 BLCK USB MULTIMEDIA\r\n', NULL, NULL, NULL, '', '2016-03-16', '2016-03-16', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:48');
INSERT INTO `subsidiary` VALUES (427, 29, 'DIVIDENDS 2018-4TH INSTALLMENT\r\n', NULL, NULL, NULL, '', '2018-08-20', '2018-08-20', '6666.67\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:50');
INSERT INTO `subsidiary` VALUES (428, 29, 'DIVIDENDS 2018-5TH INSTALLMENT\r\n', NULL, NULL, NULL, '', '2018-09-15', '2018-09-15', '6666.67\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:52');
INSERT INTO `subsidiary` VALUES (429, 29, 'DIVIDENDS 2018-6TH INSTALLMENT\r\n', NULL, NULL, NULL, '', '2018-10-15', '2018-10-15', '6666.67\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:54');
INSERT INTO `subsidiary` VALUES (430, 46, '2PCS HELMET 041015\r\n', NULL, NULL, NULL, '', '2015-04-10', '2015-04-10', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:56');
INSERT INTO `subsidiary` VALUES (431, 46, '1PC RAINCOAT 051215\r\n', NULL, NULL, NULL, '', '2015-05-12', '2015-05-12', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:42:58');
INSERT INTO `subsidiary` VALUES (432, 46, '1PC ADDING MACHINE-CASHIER 061015\r\n', NULL, NULL, NULL, '', '2015-06-10', '2015-06-10', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:43:00');
INSERT INTO `subsidiary` VALUES (433, 46, '2PCS RAINCOAT 062215\r\n', NULL, NULL, NULL, '', '2015-06-22', '2015-06-22', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:06');
INSERT INTO `subsidiary` VALUES (434, 46, '1 PAIR RAINBOOTS  063015\r\n', NULL, NULL, NULL, '', '2015-06-30', '2015-06-30', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:08');
INSERT INTO `subsidiary` VALUES (435, 46, '2U HELMET\r\n', NULL, NULL, NULL, '', '2015-07-30', '2015-07-30', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:10');
INSERT INTO `subsidiary` VALUES (436, 46, '1U HELMET 092115\r\n', NULL, NULL, NULL, '', '2015-09-21', '2015-09-21', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:12');
INSERT INTO `subsidiary` VALUES (437, 46, '2PCS FULLFACE HELMET 081016\r\n', NULL, NULL, NULL, '', '2016-08-10', '2016-08-10', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:14');
INSERT INTO `subsidiary` VALUES (438, 46, '2 RAINCOAT 110816\r\n', NULL, NULL, NULL, '', '2016-11-08', '2016-11-08', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:16');
INSERT INTO `subsidiary` VALUES (439, 46, '3 HELMET 110816\r\n', NULL, NULL, NULL, '', '2016-11-08', '2016-11-08', '3.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:18');
INSERT INTO `subsidiary` VALUES (440, 46, '1PC CYLINDER BLOCK  110816\r\n', NULL, NULL, NULL, '', '2016-11-08', '2016-11-08', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:21');
INSERT INTO `subsidiary` VALUES (441, 46, '2 RAINBOOTS 111716\r\n', NULL, NULL, NULL, '', '2016-11-17', '2016-11-17', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:25');
INSERT INTO `subsidiary` VALUES (442, 46, 'RICE COOKER  041916\r\n', NULL, NULL, NULL, '', '2016-04-19', '2016-04-19', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:34');
INSERT INTO `subsidiary` VALUES (443, 47, '1PC RAINCOAT 051215\r\n', NULL, NULL, NULL, '', '2015-05-12', '2015-05-12', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:48');
INSERT INTO `subsidiary` VALUES (444, 47, '1PC HELMET 041015\r\n', NULL, NULL, NULL, '', '2015-04-10', '2015-04-10', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:43:53');
INSERT INTO `subsidiary` VALUES (445, 47, 'CELLPHONE 043014\r\n', NULL, NULL, NULL, '', '2014-04-30', '2014-04-30', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:54:35');
INSERT INTO `subsidiary` VALUES (446, 47, '1PC ADDING MACHINE-CASHIER 061015\r\n', NULL, NULL, NULL, '', '2015-06-10', '2015-06-10', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:45:56');
INSERT INTO `subsidiary` VALUES (447, 47, '2PCS RAINCOAT 062215\r\n', NULL, NULL, NULL, '', '2015-06-22', '2015-06-22', '2.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:04');
INSERT INTO `subsidiary` VALUES (448, 47, '1 HELMET\r\n', NULL, NULL, NULL, '', '2015-07-22', '2015-07-22', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:07');
INSERT INTO `subsidiary` VALUES (449, 47, 'RAINCOAT 091615\r\n', NULL, NULL, NULL, '', '2015-09-16', '2015-09-16', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:10');
INSERT INTO `subsidiary` VALUES (450, 47, '1 HELMET  092115\r\n', NULL, NULL, NULL, '', '2015-09-21', '2015-09-21', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:12');
INSERT INTO `subsidiary` VALUES (451, 47, 'RICE COOKER\r\n', NULL, NULL, NULL, '', '2016-09-26', '2016-09-26', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:15');
INSERT INTO `subsidiary` VALUES (452, 47, 'RAINBOOT 112315\r\n', NULL, NULL, NULL, '', '2015-11-23', '2015-11-23', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:17');
INSERT INTO `subsidiary` VALUES (453, 47, 'HELMET  072116\r\n', NULL, NULL, NULL, '', '2016-07-21', '2016-07-21', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:21');
INSERT INTO `subsidiary` VALUES (454, 30, 'AIRCON NASIPIT-070314\r\n', NULL, NULL, NULL, '', '2014-07-03', '2014-07-03', '1.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:23');
INSERT INTO `subsidiary` VALUES (455, 30, 'HONDA XR150 RD/WHTE 150107 061019\r\n', NULL, NULL, NULL, '', '2019-06-10', '2019-06-10', '83820.00\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:26');
INSERT INTO `subsidiary` VALUES (456, 30, 'A/P OTHERS-YVONNE ESPINA 061819\r\n', NULL, NULL, NULL, '', '2019-06-18', '2019-06-18', '500000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:28');
INSERT INTO `subsidiary` VALUES (457, 30, 'FORD  070219\r\n', NULL, NULL, NULL, '', '2019-07-02', '2019-07-02', '80000.00\r\n', '2', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:46:30');
INSERT INTO `subsidiary` VALUES (458, 30, 'A/P OTHERS-YVONNE ESPINA 070819\r\n', NULL, NULL, NULL, '', '2019-07-08', '2019-07-08', '309300.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:35');
INSERT INTO `subsidiary` VALUES (459, 30, 'A/P OTHERS-YVONNE ESPINA 080519\r\n', NULL, NULL, NULL, '', '2019-08-05', '2019-08-05', '440000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:39');
INSERT INTO `subsidiary` VALUES (460, 9, 'ROMEO R. MANOS SR.\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:43');
INSERT INTO `subsidiary` VALUES (461, 6, 'JRS EXPRESS\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:46');
INSERT INTO `subsidiary` VALUES (462, 9, 'NENA VICENTE\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:48');
INSERT INTO `subsidiary` VALUES (463, 6, 'FORD\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:46:52');
INSERT INTO `subsidiary` VALUES (464, 6, 'PESIDAS WORKS DESIGN\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:23');
INSERT INTO `subsidiary` VALUES (465, 4, 'YRRA SECRETARIA\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:34');
INSERT INTO `subsidiary` VALUES (466, 9, 'CHARLIE AÑASCO\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:47');
INSERT INTO `subsidiary` VALUES (467, 9, 'ERIC K. AQUINO\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:51');
INSERT INTO `subsidiary` VALUES (468, 4, 'JOHN REY MARK D. JAMEN\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:53');
INSERT INTO `subsidiary` VALUES (469, 19, 'HILUX- RENEWAL INSURANCE\r\n', NULL, NULL, '1415', '00000', '2019-08-16', '2019-08-16', '15965.00', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:57');
INSERT INTO `subsidiary` VALUES (470, 19, 'MIO-MS48698- RENEWAL INSURANCE\r\n', NULL, NULL, '1415', '00000', '2019-09-11', '2019-09-11', '611.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:55:59');
INSERT INTO `subsidiary` VALUES (471, 19, 'PHILAM HEALTHLINK- RENEWAL\r\n', NULL, NULL, '1415', '00000', '2019-09-18', '2019-09-18', '47774.00', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:02');
INSERT INTO `subsidiary` VALUES (472, 19, '4979OF RENEWAL INSURANCE\r\n', NULL, NULL, '1415', '00001', '2019-09-11', '2019-09-11', '611.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:04');
INSERT INTO `subsidiary` VALUES (473, 19, 'XKZ118- RENEWAL INSURANCE\r\n', NULL, NULL, '1415', '00001', '2019-09-06', '2019-09-06', '3567.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:06');
INSERT INTO `subsidiary` VALUES (474, 19, 'MS55149-RENEWAL INSURANCE\r\n', NULL, NULL, '1415', '00002', '2019-09-11', '2019-09-11', '611.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:09');
INSERT INTO `subsidiary` VALUES (475, 20, 'HILUX- RENEWAL LTO\r\n', NULL, NULL, '1415', '00000', '2019-08-16', '2019-08-16', '3550.00', '5', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:11');
INSERT INTO `subsidiary` VALUES (476, 20, 'MS48698-MIO RENEWAL LTO\r\n', NULL, NULL, '1415', '00000', '2019-09-11', '2019-09-11', '1366.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:13');
INSERT INTO `subsidiary` VALUES (477, 20, '4979OF-RENEWAL LTO\r\n', NULL, NULL, '1415', '00001', '2019-09-11', '2019-09-11', '1241.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:18');
INSERT INTO `subsidiary` VALUES (478, 20, 'XKZ118- RENEWAL LTO\r\n', NULL, NULL, '1415', '00001', '2019-09-06', '2019-09-06', '5730.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:21');
INSERT INTO `subsidiary` VALUES (479, 20, 'MS55149- RENEWAL LTO\r\n', NULL, NULL, '1415', '00002', '2019-09-11', '2019-09-11', '1241.00', '4', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:23');
INSERT INTO `subsidiary` VALUES (480, 52, 'DURANGO, FERDINAND C.\r\n', NULL, NULL, '2100', '00001', '2019-08-13', '2019-08-13', '600.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:25');
INSERT INTO `subsidiary` VALUES (481, 52, 'ENDENCIA, IMELDA L.\r\n', NULL, NULL, '2100', '00001', '2019-08-13', '2019-08-13', '4000.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:28');
INSERT INTO `subsidiary` VALUES (482, 52, 'FLORES, MARIETTA\r\n', NULL, NULL, '2100', '00001', '2019-09-04', '2019-09-04', '198.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:31');
INSERT INTO `subsidiary` VALUES (483, 52, 'SILPA, FELIPA\r\n', NULL, NULL, '2100', '00001', '2019-09-12', '2019-09-12', '225.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:33');
INSERT INTO `subsidiary` VALUES (484, 52, 'SAJOR, DANILO M\r\n', NULL, NULL, '2100', '00001', '2019-09-25', '2019-09-25', '261.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:35');
INSERT INTO `subsidiary` VALUES (485, 52, 'JACUTIN, VIRGILIO Z\r\n', NULL, NULL, '2100', '00002', '2019-08-02', '2019-08-02', '300.00\r\n', '1', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:41');
INSERT INTO `subsidiary` VALUES (486, 52, 'BAGULOR, MARIO M\r\n', NULL, NULL, '2100', '00002', '2019-08-05', '2019-08-05', '300.00\r\n', '1', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:47');
INSERT INTO `subsidiary` VALUES (487, 52, 'ELCANO, JOSE V\r\n', NULL, NULL, '2100', '00002', '2019-08-05', '2019-08-05', '750.00\r\n', '1', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:53');
INSERT INTO `subsidiary` VALUES (488, 52, 'BALEÑA, PEPITO L\r\n', NULL, NULL, '2100', '00002', '2019-08-06', '2019-08-06', '1500.00\r\n', '1', '5', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:56');
INSERT INTO `subsidiary` VALUES (489, 52, 'BACALLA, LORNA M\r\n', NULL, NULL, '2100', '00002', '2019-08-07', '2019-08-07', '480.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:56:59');
INSERT INTO `subsidiary` VALUES (490, 52, 'JABLA, FELIX B\r\n', NULL, NULL, '2100', '00002', '2019-08-07', '2019-08-07', '264.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:00');
INSERT INTO `subsidiary` VALUES (491, 52, 'SABALLA, NICASIO P\r\n', NULL, NULL, '2100', '00002', '2019-08-07', '2019-08-07', '600.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:06');
INSERT INTO `subsidiary` VALUES (492, 52, 'TAMAYO, MAE G\r\n', NULL, NULL, '2100', '00002', '2019-08-07', '2019-08-07', '300.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:09');
INSERT INTO `subsidiary` VALUES (493, 52, 'TIEMPO, ISIDRO F\r\n', NULL, NULL, '2100', '00002', '2019-08-09', '2019-08-09', '120.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:12');
INSERT INTO `subsidiary` VALUES (494, 52, 'BALANAY, FLORENCIA P\r\n', NULL, NULL, '2100', '00002', '2019-08-13', '2019-08-13', '252.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:18');
INSERT INTO `subsidiary` VALUES (495, 52, 'GREGORIO, AZUCENA C\r\n', NULL, NULL, '2100', '00002', '2019-08-13', '2019-08-13', '312.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:23');
INSERT INTO `subsidiary` VALUES (496, 52, 'RAMIREZ, MONICA A\r\n', NULL, NULL, '2100', '00002', '2019-08-13', '2019-08-13', '660.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:26');
INSERT INTO `subsidiary` VALUES (497, 52, 'SAGARBARRIA, NELIA B\r\n', NULL, NULL, '2100', '00002', '2019-08-13', '2019-08-13', '252.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:28');
INSERT INTO `subsidiary` VALUES (498, 52, 'DAAROL, ALFREDO L\r\n', NULL, NULL, '2100', '00002', '2019-08-15', '2019-08-15', '264.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:57:30');
INSERT INTO `subsidiary` VALUES (499, 52, 'SILVERIO, VICTORIA A\r\n', NULL, NULL, '2100', '00002', '2019-08-20', '2019-08-20', '480.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:57:35');
INSERT INTO `subsidiary` VALUES (500, 52, 'SALARZA, BERNARDO SR\r\n', NULL, NULL, '2100', '00002', '2019-08-27', '2019-08-27', '600.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:40');
INSERT INTO `subsidiary` VALUES (501, 52, 'VERSOZA, CRESENCIO F\r\n', NULL, NULL, '2100', '00002', '2019-08-27', '2019-08-27', '360.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:46');
INSERT INTO `subsidiary` VALUES (502, 52, 'SULTAN, TEODORO C\r\n', NULL, NULL, '2100', '00002', '2019-08-28', '2019-08-28', '240.00\r\n', '1', '4', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:55');
INSERT INTO `subsidiary` VALUES (503, 52, 'PAGARA, TERESITA\r\n', NULL, NULL, '2100', '00002', '2019-09-13', '2019-09-13', '243.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:57:59');
INSERT INTO `subsidiary` VALUES (504, 52, 'TIGON, HERMENIGILDA\r\n', NULL, NULL, '2100', '00002', '2019-09-17', '2019-09-17', '180.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:01');
INSERT INTO `subsidiary` VALUES (505, 52, 'BITANCOR, AGUEDO O\r\n', NULL, NULL, '2100', '00002', '2019-09-26', '2019-09-26', '540.00\r\n', '0', '3', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:04');
INSERT INTO `subsidiary` VALUES (506, 6, 'NASIPIT WATER DISTRICT\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:06');
INSERT INTO `subsidiary` VALUES (507, 9, 'MA. PAULITA LOMONSOD\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:08');
INSERT INTO `subsidiary` VALUES (508, 9, 'TERESITA B. BALLARD\r\n', NULL, NULL, NULL, '', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:10');
INSERT INTO `subsidiary` VALUES (509, 50, 'EDIFIER SPEAKER\r\n', NULL, NULL, '1515', '00001', '2019-10-30', '2019-10-30', '4009.00\r\n', '24', '24', '10', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:12');
INSERT INTO `subsidiary` VALUES (510, 14, 'CASH OVERAGES\r\n', NULL, NULL, '1000', '00000', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:18');
INSERT INTO `subsidiary` VALUES (511, 20, 'YAMAHA XTZ 125 MS 84310\r\n', NULL, NULL, '1415', '00002', '2019-10-14', '2019-10-14', '1343.00\r\n', '2', '2', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:20');
INSERT INTO `subsidiary` VALUES (512, 19, 'YAMAHA XTZ 125 MS 84310\r\n', NULL, NULL, '1415', '00002', '2019-10-14', '2019-10-14', '691.00\r\n', '2', '2', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:25');
INSERT INTO `subsidiary` VALUES (513, 50, 'FORD RACK AND PINION\r\n', NULL, NULL, '1545', '00000', '2019-12-16', '2019-12-16', '24400.00\r\n', '12', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:58:28');
INSERT INTO `subsidiary` VALUES (514, 50, 'LEAF SPRING ASSEMBLY - HILUX\r\n', NULL, NULL, '1545', '00000', '2020-01-08', '2020-01-08', '21428.57\r\n', '11', '11', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:33');
INSERT INTO `subsidiary` VALUES (515, 50, 'HEAD UNIT FOR HILUX\r\n', NULL, NULL, '1545', '00000', '2020-01-15', '2020-01-15', '11000.00\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:35');
INSERT INTO `subsidiary` VALUES (516, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00000', '2020-01-15', '2020-01-15', '48342.73\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:38');
INSERT INTO `subsidiary` VALUES (517, 20, 'BUSINESS PERMIT 2020 - NASIPIT\r\n', NULL, NULL, '1415', '00002', '2020-01-24', '2020-01-24', '22492.00\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:41');
INSERT INTO `subsidiary` VALUES (518, 50, 'HILUX COIL SPRING\r\n', NULL, NULL, '1545', '00000', '2020-01-22', '2020-01-22', '17321.43\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:43');
INSERT INTO `subsidiary` VALUES (519, 20, 'BUSINESS PERMIT 2020-BUTUAN\r\n', NULL, NULL, '1415', '00001', '2020-01-28', '2020-01-28', '66770.00\r\n', '11', '11', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:45');
INSERT INTO `subsidiary` VALUES (520, 19, 'PHILAM LIFE INSURANCE JCPA\r\n', NULL, NULL, '1415', '00000', '2020-03-12', '2020-03-12', '21203.00\r\n', '10', '10', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:48');
INSERT INTO `subsidiary` VALUES (521, 50, '4 PCS. MAG WHEELS AND TIRES\r\n', NULL, NULL, '1545', '00002', '2020-03-13', '2020-03-13', '30000.00\r\n', '19', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:58:51');
INSERT INTO `subsidiary` VALUES (522, 19, 'MIRAGE LMT-993 LTO RENEWAL\r\n', NULL, NULL, '1415', '00000', '2020-05-21', '2020-05-21', '15588.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:56');
INSERT INTO `subsidiary` VALUES (523, 19, 'FORD FIESTA UWO-323 LTO RENEWAL\r\n', NULL, NULL, '1415', '00002', '2020-05-21', '2020-05-21', '11330.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:58:58');
INSERT INTO `subsidiary` VALUES (524, 19, 'HONDA CB110 MS-13783\r\n', NULL, NULL, '1415', '00002', '2020-05-21', '2020-05-21', '1428.00\r\n', '8', '8', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:00');
INSERT INTO `subsidiary` VALUES (525, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00000', '2020-07-15', '2020-07-15', '48342.73\r\n', '6', '6', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:03');
INSERT INTO `subsidiary` VALUES (526, 50, 'MOTOLITE BATTERY 11 PLATES\r\n', NULL, NULL, '1545', '00000', '2020-07-15', '2020-07-15', '6250.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:06');
INSERT INTO `subsidiary` VALUES (527, 20, 'KFK - 558 HILUX LTO RENEWAL\r\n', NULL, NULL, '1415', '00000', '2020-08-26', '2020-08-26', '19106.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:08');
INSERT INTO `subsidiary` VALUES (528, 20, 'HONDA XR - 150 15007 LTO RENEWAL\r\n', NULL, NULL, '1415', '00000', '2020-08-26', '2020-08-26', '1838.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:10');
INSERT INTO `subsidiary` VALUES (529, 20, 'MIO 48698 LTO RENEWAL\r\n', NULL, NULL, '1415', '00001', '2020-08-26', '2020-08-26', '1732.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:14');
INSERT INTO `subsidiary` VALUES (530, 20, 'ISUZU CROSSWIND XKZ 118 LTO RENEWAL\r\n', NULL, NULL, '1415', '00001', '2020-08-26', '2020-08-26', '4893.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:19');
INSERT INTO `subsidiary` VALUES (531, 20, 'XRM 1864K LTO RENEWAL\r\n', NULL, NULL, '1415', '00001', '2020-08-26', '2020-08-26', '1850.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:23');
INSERT INTO `subsidiary` VALUES (532, 20, 'CB110 41906 LTO RENEWAL\r\n', NULL, NULL, '1415', '00001', '2020-08-26', '2020-08-26', '1731.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:25');
INSERT INTO `subsidiary` VALUES (533, 19, 'PHILAM LIFE INSURANCE - HEALTH LINK\r\n', NULL, NULL, '1415', '00000', '2020-09-28', '2020-09-28', '44892.25\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:31');
INSERT INTO `subsidiary` VALUES (534, 50, 'SAMSUNG A11\r\n', NULL, NULL, '1515', '00000', '2020-12-18', '2020-12-18', '6390.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:34');
INSERT INTO `subsidiary` VALUES (535, 4, 'JEREMAE G. PAYOT\r\n', NULL, NULL, '1000', '00000', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 14:59:36');
INSERT INTO `subsidiary` VALUES (536, 54, 'OFFICIAL RECEIPTS - 01/18/2021\r\n', NULL, NULL, '1410', '00002', '2021-01-18', '2021-01-18', '29910.71\r\n', '12', '70', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:41');
INSERT INTO `subsidiary` VALUES (537, 19, 'PHILAM LIFE INSURANCE CEO\r\n', NULL, NULL, '1415', '00002', '2021-01-21', '2021-01-21', '48342.73\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:46');
INSERT INTO `subsidiary` VALUES (538, 50, 'TIRE - NITTO TIRE 275/55 R20\r\n', NULL, NULL, '1545', '00000', '2021-01-28', '2021-01-28', '50000.00\r\n', '12', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:52');
INSERT INTO `subsidiary` VALUES (539, 19, 'ST. PETER LIFE PLAN - CEO\r\n', NULL, NULL, '1415', '00000', '2021-02-08', '2021-02-08', '21280.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:59:55');
INSERT INTO `subsidiary` VALUES (540, 19, 'PHILAM ACCIDENT INSURANCE\r\n', NULL, NULL, '1415', '00000', '2021-02-16', '2021-02-16', '18421.00\r\n', '12', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:01');
INSERT INTO `subsidiary` VALUES (541, 54, 'OFFICIAL RECEIPTS-02-18-20\r\n', NULL, NULL, '1410', '00002', '2020-02-18', '2020-02-18', '29703.38\r\n', '12', '70', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:05');
INSERT INTO `subsidiary` VALUES (542, 19, 'FORD FIESTA - STRONHOLD INSURANCE\r\n', NULL, NULL, '1415', '00001', '2021-03-18', '2021-03-18', '9201.00\r\n', '11', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:12');
INSERT INTO `subsidiary` VALUES (543, 19, 'MIRAGE - STRONGHOLD INSURANCE\r\n', NULL, NULL, '1415', '00000', '2021-03-18', '2021-03-18', '13459.00\r\n', '11', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:22');
INSERT INTO `subsidiary` VALUES (544, 50, 'PRINTER - EPSON LQ310 (DOT MATRIX)\r\n', NULL, NULL, '1530', '00002', '2021-06-28', '2021-06-28', '11995.00\r\n', '8', '24', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:25');
INSERT INTO `subsidiary` VALUES (545, 19, 'PHILAM LIFE INSURANCE CEO\r\nCOMPUTER TABLE\r\n', NULL, NULL, '1415', '00000', '2021-07-12', '2021-07-12', '48342.73\r\n', '7', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 15:00:27');
INSERT INTO `subsidiary` VALUES (546, 50, 'AOC 22\" MONITOR & ACCESSORIES\r\n', NULL, NULL, '1530', '00000', '2021-07-29', '2021-07-29', '5800.00\r\n', '6', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:35');
INSERT INTO `subsidiary` VALUES (547, 50, 'COMPUTER TABLE\r\n', NULL, NULL, '1515', '00000', '2021-07-29', '2021-07-29', '1542.86\r\n', '6', '12', '10.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:37');
INSERT INTO `subsidiary` VALUES (548, 19, 'STRONG HOLD INSURANCE-HILUX KFK558\r\n', NULL, NULL, '1415', '00000', '2021-08-17', '2021-08-17', '15964.00\r\n', '6', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:42');
INSERT INTO `subsidiary` VALUES (549, 50, 'IMARFLEX CAR BATTERY - FORD FIESTA\r\n', NULL, NULL, '1545', '00001', '2021-08-23', '2021-08-23', '0.00\r\n', '6', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:44');
INSERT INTO `subsidiary` VALUES (550, 4, 'SSS CLAIM - CYRIEL\r\n', NULL, NULL, '2026', '00000', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:47');
INSERT INTO `subsidiary` VALUES (551, 4, 'SSS CLAIM - VILXED\r\n', NULL, NULL, '2026', '00000', NULL, NULL, '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:49');
INSERT INTO `subsidiary` VALUES (552, 4, 'YUMO, DIONESIO\r\n', NULL, NULL, '2026', '00000', NULL, NULL, '13102.67\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:52');
INSERT INTO `subsidiary` VALUES (553, 50, 'SPYDER HELMET 2PCS & ACCESSORIES\r\n', NULL, NULL, '1545', '00000', '2021-09-30', '2021-09-30', '34293.00\r\n', '4', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:55');
INSERT INTO `subsidiary` VALUES (554, 19, 'PHILAM HEALTH LINK - RENEWAL\r\n', NULL, NULL, '1415', '00000', '2021-10-08', '2021-10-08', '4524.00\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:00:57');
INSERT INTO `subsidiary` VALUES (555, 19, 'PHILAM JCPA ACCIDENT - RENEWAL\r\n', NULL, NULL, '1415', '00000', '2021-10-08', '2021-10-08', '9300.00\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:00');
INSERT INTO `subsidiary` VALUES (556, 50, 'AKRAPOVIC MUFFLER & ACCS. FOR XTZ\r\n', NULL, NULL, '1545', '00000', '2021-10-08', '2021-10-08', '10709.82\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:02');
INSERT INTO `subsidiary` VALUES (557, 50, 'EPSON LQ 310 PRINTER\r\n', NULL, NULL, '1530', '00001', '2021-10-14', '2021-10-14', '5803.57\r\n', '3', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:04');
INSERT INTO `subsidiary` VALUES (558, 50, 'TOYOTA TAIL LIGHT ASSEMBLY\r\n', NULL, NULL, '1545', '00000', '2021-10-13', '2021-10-13', '4464.29\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:07');
INSERT INTO `subsidiary` VALUES (559, 50, 'OUTLANDER SWAY BAR FOR HILUX\r\n', NULL, NULL, '1545', '00000', '2021-10-20', '2021-10-20', '5782.14\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:09');
INSERT INTO `subsidiary` VALUES (560, 50, 'HONDA XR125 FRONT FORK GENUINE\r\n', NULL, NULL, '1545', '00000', '2021-10-26', '2021-10-26', '0.00\r\n', '3', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:16');
INSERT INTO `subsidiary` VALUES (561, 50, '4PCS BF GOODRICH TIRES FOR ISUZU\r\n', NULL, NULL, '1545', '00000', '2021-12-02', '2021-12-02', '0.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:19');
INSERT INTO `subsidiary` VALUES (562, 6, 'ENGTECH GLOBAL SOLUTIONS, INC.\r\n', NULL, NULL, '1569', '00000', NULL, NULL, '450000.00\r\n', '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:24');
INSERT INTO `subsidiary` VALUES (563, 51, 'ENGTECH GLOBAL SOLUTIONS, INC.\r\n', NULL, NULL, '1570', '00000', '2021-12-02', '2021-12-02', '15114.00\r\n', '2', '60', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:28');
INSERT INTO `subsidiary` VALUES (564, 50, 'ONEAL MOTORCYCLE BOOTS\r\n', NULL, NULL, '1545', '00000', '2022-01-17', '2022-01-17', '14968.00\r\n', '1', '24', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:32');
INSERT INTO `subsidiary` VALUES (565, 19, 'PHILAM JCPA ACCIDENT INS-RENEWL2022\r\n', NULL, NULL, '1415', '00000', '2022-02-08', '2022-02-08', '0.00\r\n', '1', '12', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:35');
INSERT INTO `subsidiary` VALUES (566, 4, 'JOVELYN A. LOGARTA\r\n', NULL, NULL, '1000', '00000', NULL, NULL, NULL, '0', '0', '0.00', NULL, '2022-06-09 00:00:00', '2022-06-09 16:01:37');

-- ----------------------------
-- Table structure for subsidiary_category
-- ----------------------------
DROP TABLE IF EXISTS `subsidiary_category`;
CREATE TABLE `subsidiary_category`  (
  `sub_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_cat_code` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_cat_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `sub_cat_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`sub_cat_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 55 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of subsidiary_category
-- ----------------------------
INSERT INTO `subsidiary_category` VALUES (2, 'CUST', 'CUSTOMER', NULL, NULL, '2022-05-18 06:08:57', '2022-05-18 06:25:15');
INSERT INTO `subsidiary_category` VALUES (3, 'SUP', 'SUPPLIER', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:29');
INSERT INTO `subsidiary_category` VALUES (4, 'EMP', 'EMPLOYEE', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:29');
INSERT INTO `subsidiary_category` VALUES (5, 'PROJ', 'PROJECT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:29');
INSERT INTO `subsidiary_category` VALUES (6, 'COMP', 'COMPANY', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:29');
INSERT INTO `subsidiary_category` VALUES (7, 'OWNER', 'OWNER', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:29');
INSERT INTO `subsidiary_category` VALUES (9, 'CLIEN', 'CLIENT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (12, 'BORRO', 'BORROWER', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (13, 'INVES', 'INVESTOR', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (14, '00001', 'MICROFINANCE LOAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (15, '00002', 'PENSION LOAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (16, 'OE', 'OFFICE EQUIPMENT-H.O', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (17, 'TE', 'TRANSPORTATION EQUIPMENT-H.O', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (18, 'FFE', 'FURNITURE & FIXTURE EQUIPMENT-H.O', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (19, 'INSUR', 'INSURANCE EXPENSES', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (20, 'TAXES', 'TAXES & LICENSES', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (22, 'RENTL', 'RENTAL EXPENSE', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (23, 'EMBEN', 'EMPLOYEES BENEFIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (24, 'OIA', 'OTHER INTANGIBLE ASSET-HEAD OFFICE', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (26, 'BFUND', 'BORROWED FUNDS-HEAD OFFICE', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (27, 'OFSUP', 'OFFICE SUPPLIES-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (28, 'LEASE', 'LEASEHOLD RIGHTS & IMPROVEMENTS', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (29, 'MA', 'MISCELLANEOUS ASSET-HEAD OFFICE', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (30, 'APOTH', 'ACCOUNTS PAYABLE OTHERS', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (31, 'FFE-B', 'FURNITURE & FIXTURE EQUIP-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (32, 'FFE-N', 'FURNITURE & FIXTURE EQUIP-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (33, 'OE-B', 'OFFICE EQUIPMENT-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (34, 'OE-N', 'OFFICE EQUIPMENT-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (35, 'TE-B', 'TRANSPORTATION EQUIPMENT-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (36, 'TE-N', 'TRANSPORTATION EQUIPMENT-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (37, 'INS-B', 'INSURANCE-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (38, 'INS-N', 'INSURANCE-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (39, 'TAX-B', 'TAXES & LICENSES-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (40, 'TAX-N', 'TAXES & LICENSES-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (41, 'REN-N', 'RENTAL EXPENSE NON VAT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (42, 'OFS-N', 'OFFICE SUPPLIES-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (46, 'MA-B', 'MISCELLANEOUS ASSET-BUTUAN', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (47, 'MA-N', 'MISCELLANEOUS ASSET-NASIPIT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (48, 'BRNCH', 'BRANCH', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (50, 'DEPRE', 'ACCU. DEPRECIATION', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (51, 'AMORT ', 'ACCU. AMORTIZATION', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (52, 'UI&D', 'UNREAD INTEREST & DISCOUNT', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (53, 'MISCE', 'MISCELLANEOUS', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');
INSERT INTO `subsidiary_category` VALUES (54, 'SUPPLY', 'OFFICE SUPPLIES', NULL, NULL, '2022-05-18 06:25:25', '2022-05-18 06:25:25');

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
INSERT INTO `users` VALUES (1, 1, 'admin', '$2y$10$MCG/ne93UlRjG9omTjz6RO4/NhuWOGl57wPpWcp7nNMbBxKVzRHA6', 'NysqnywOrZ', 'active', 1, '6TBck5LbCycpaWpl3daxfUwJCmSMWdMX8YFmYScTf7krYvvUBwSCGKfFkqyt', '2021-09-01 11:34:14', '2022-05-06 05:48:15');
INSERT INTO `users` VALUES (2, 2, 'zetadmin', '$2y$10$MeHB1Z5KVmsYTM4XSf1URu0wTXEE8lDaCov4wKzXRmUxzXwugXIye', 'NysqnywOrZ', 'active', 1, 'nfv4IkK4WzLorIorsfIoJjR4UrY00tWgesTHptUZjwLowzdEl4hjuyPWUCw7', '2021-09-01 11:34:14', '2022-06-02 06:08:37');
INSERT INTO `users` VALUES (4, 9, 'tomtomy', '$2y$10$eY9r75BVKUxzPQMI5Gs25OfV.VgsBZ6KK.wHvhzpsqZE27bRIdQPm', '$2y$10$sfgoyx/XXm2cEImPekU3KOS5Np8Bw01wJRHoG4i5pu68s.GLKFmkK', 'active', 1, NULL, '2022-05-06 05:15:40', '2022-05-06 07:14:42');

SET FOREIGN_KEY_CHECKS = 1;

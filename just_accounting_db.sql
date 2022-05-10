/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : 127.0.0.1:3306
 Source Schema         : just_accounting_db

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 14/12/2021 08:03:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
  PRIMARY KEY (`account_type_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of accounting
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bill
-- ----------------------------
INSERT INTO `bill` VALUES (2, 98, '1001', '2021-11-24', '2021-11-24', 'supplier', 2, '5000', 1, 3, 'credit');

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
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of chart_of_accounts
-- ----------------------------
INSERT INTO `chart_of_accounts` VALUES (1, NULL, 'Cash on hand', NULL, NULL, NULL, 'active', 1, '2021-09-14 04:20:51', '2021-12-09 06:36:25');
INSERT INTO `chart_of_accounts` VALUES (2, NULL, 'Accounts Receivable (A/R)', NULL, NULL, 'investing', 'active', 3, '2021-09-14 06:27:14', '2021-09-14 06:27:14');
INSERT INTO `chart_of_accounts` VALUES (3, NULL, 'Accounts Payable (A/P)', NULL, NULL, NULL, 'active', 5, '2021-09-15 05:23:57', '2021-09-15 05:23:57');
INSERT INTO `chart_of_accounts` VALUES (4, NULL, 'Prepaid expenses', 'This is a description', NULL, 'investing', 'active', 9, '2021-09-16 07:31:55', '2021-09-16 07:31:55');
INSERT INTO `chart_of_accounts` VALUES (5, NULL, 'Office expenses', NULL, NULL, NULL, 'active', 16, '2021-09-16 08:51:59', '2021-09-17 01:59:20');
INSERT INTO `chart_of_accounts` VALUES (6, NULL, 'Petty cash', NULL, 1, 'operating', 'active', 1, '2021-09-16 08:57:36', '2021-09-17 01:59:04');
INSERT INTO `chart_of_accounts` VALUES (7, NULL, 'Cost of sales', NULL, NULL, NULL, 'active', 15, '2021-09-16 13:04:56', '2021-09-16 13:04:56');
INSERT INTO `chart_of_accounts` VALUES (8, NULL, 'Sales', NULL, NULL, NULL, 'active', 13, '2021-10-06 04:54:15', '2021-10-06 04:54:15');
INSERT INTO `chart_of_accounts` VALUES (9, NULL, 'Retained Earnings', NULL, NULL, 'investing', 'active', 12, '2021-10-22 01:00:43', '2021-10-22 01:00:57');

-- ----------------------------
-- Table structure for company
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company`  (
  `company_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`company_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of company
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of company_address
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of expense
-- ----------------------------
INSERT INTO `expense` VALUES (2, 97, 1, '2021-11-21 00:00:00', '125003625', 3, 'supplier', 3000.00, 1, 'credit');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of invoice
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of item_details
-- ----------------------------
INSERT INTO `item_details` VALUES (16, 1, 'description 1', 3, 500.00, 1500.00, 90);
INSERT INTO `item_details` VALUES (17, 2, '', 1, 25000.00, 25000.00, 91);

-- ----------------------------
-- Table structure for journal_entry
-- ----------------------------
DROP TABLE IF EXISTS `journal_entry`;
CREATE TABLE `journal_entry`  (
  `journal_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `journal_date` date NULL DEFAULT NULL,
  PRIMARY KEY (`journal_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of journal_entry
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
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of payment
-- ----------------------------

-- ----------------------------
-- Table structure for payment_method
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method`  (
  `payment_method_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`payment_method_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of products_services_category
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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 108 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transaction_details
-- ----------------------------
INSERT INTO `transaction_details` VALUES (106, 5, 97, 3000.00, '', NULL, NULL, 'debit');
INSERT INTO `transaction_details` VALUES (107, 5, 98, 5000.00, '1212', NULL, NULL, 'debit');

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
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 99 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (97, 4, 'note', NULL, 'void', '2021-11-23', '2021-11-23 01:37:27', '2021-11-25 03:21:09', 1, NULL);
INSERT INTO `transactions` VALUES (98, 3, 'note 1001', NULL, 'open', '2021-11-24', '2021-11-24 06:15:33', '2021-11-24 06:15:33', 1, NULL);

-- ----------------------------
-- Table structure for user_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE `user_roles`  (
  `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

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
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '$2y$10$aJWE1gL9WSc2UV8rXBeTOu/ONM49aXtPQNJ9AEFbhOO5Ai1hx.c/2', 'NysqnywOrZ', 'active', 1, 'iSUcAu2Pee2IUrjTypzlJu9eid2ciYsixB6l0pNqyAUg0CqFIAne4cf5J7xO', '2021-09-01 11:34:14', '2021-09-01 11:34:19');

SET FOREIGN_KEY_CHECKS = 1;

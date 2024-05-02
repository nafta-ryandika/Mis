-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.51-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mis
CREATE DATABASE IF NOT EXISTS `mis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mis`;

-- Dumping structure for table mis.m_access
CREATE TABLE IF NOT EXISTS `m_access` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `role_id` int(16) DEFAULT NULL,
  `menu_id` int(16) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_access: ~5 rows (approximately)
DELETE FROM `m_access`;
INSERT INTO `m_access` (`id`, `role_id`, `menu_id`, `created_by`, `created_at`) VALUES
	(1, 1, 1, 'Administrator', '2023-12-12 10:31:47'),
	(3, 2, 2, 'Administrator', '2023-12-12 10:32:49'),
	(4, 1, 3, 'Administrator', '2023-12-12 10:32:49'),
	(12, 1, 2, NULL, NULL),
	(17, 1, 4, NULL, NULL),
	(18, 1, 5, NULL, '2024-03-04 10:54:50'),
	(19, 1, 7, NULL, '2024-03-18 15:24:46');

-- Dumping structure for table mis.m_audit_shift
CREATE TABLE IF NOT EXISTS `m_audit_shift` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `start` time DEFAULT NULL,
  `end` time DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_audit_shift: ~4 rows (approximately)
DELETE FROM `m_audit_shift`;
INSERT INTO `m_audit_shift` (`id`, `start`, `end`, `created_by`, `created_at`) VALUES
	(1, '06:00:00', '15:00:00', 'administrator', '2024-01-30 11:29:27'),
	(2, '07:00:00', '16:00:00', 'administrator', '2024-01-30 11:29:27'),
	(3, '08:00:00', '17:00:00', 'administrator', '2024-01-30 11:29:27'),
	(4, '13:00:00', '22:00:00', 'administrator', '2024-01-30 11:29:27'),
	(5, '22:00:00', '07:00:00', 'administrator', '2024-01-30 11:29:27');

-- Dumping structure for table mis.m_company
CREATE TABLE IF NOT EXISTS `m_company` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `company` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_company: ~1 rows (approximately)
DELETE FROM `m_company`;
INSERT INTO `m_company` (`id`, `company`, `created_by`, `created_at`) VALUES
	(1, 'PT MEGA MARINE PRIDE', 'administrator', '2024-01-30 11:13:48');

-- Dumping structure for table mis.m_department
CREATE TABLE IF NOT EXISTS `m_department` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `department` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_department: ~10 rows (approximately)
DELETE FROM `m_department`;
INSERT INTO `m_department` (`id`, `department`, `created_by`, `created_at`) VALUES
	(1, 'COORPORATE', 'administrator', '2024-01-30 09:55:30'),
	(2, 'FA-CUSTOMS', 'administrator', '2024-01-30 09:55:30'),
	(3, 'PURCHASING', 'administrator', '2024-01-30 09:55:30'),
	(4, 'IT', 'administrator', '2024-01-30 09:55:30'),
	(5, 'HRM/GA-HSE', 'administrator', '2024-01-30 09:55:30'),
	(6, 'QUALITY', 'administrator', '2024-01-30 09:55:30'),
	(7, 'OPERATIONAL', 'administrator', '2024-01-30 09:55:30'),
	(8, 'PRODUCTION', 'administrator', '2024-01-30 09:55:30'),
	(9, 'MARKETING', 'administrator', '2024-01-30 09:55:30'),
	(10, 'EXIM', 'administrator', '2024-01-30 09:55:30');

-- Dumping structure for table mis.m_division
CREATE TABLE IF NOT EXISTS `m_division` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `department_id` int(16) NOT NULL,
  `division` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`department_id`) USING BTREE,
  KEY `department_id` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_division: ~4 rows (approximately)
DELETE FROM `m_division`;
INSERT INTO `m_division` (`id`, `department_id`, `division`, `created_by`, `created_at`) VALUES
	(1, 4, 'IT', 'administrator', '2024-01-30 10:22:25'),
	(2, 4, 'IT - HARDWARE / NETWORKING', 'administrator', '2024-01-30 10:25:04'),
	(3, 4, 'IT - SOFTWARE', 'administrator', '2024-01-30 10:25:04'),
	(4, 4, 'IT- IT DOCUMENTATION & WAREHOUSE', 'administrator', '2024-01-30 10:25:04');

-- Dumping structure for table mis.m_employee
CREATE TABLE IF NOT EXISTS `m_employee` (
  `id` varchar(16) NOT NULL,
  `card` varchar(16) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `company_id` int(16) DEFAULT NULL,
  `department_id` int(16) DEFAULT NULL,
  `division_id` int(16) DEFAULT NULL,
  `position_id` int(16) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `card` (`card`),
  KEY `department_id` (`department_id`),
  KEY `division_id` (`division_id`),
  KEY `position_id` (`position_id`),
  KEY `company_id` (`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_employee: ~1 rows (approximately)
DELETE FROM `m_employee`;
INSERT INTO `m_employee` (`id`, `card`, `name`, `company_id`, `department_id`, `division_id`, `position_id`, `created_by`, `created_at`) VALUES
	('123456', '', 'Andi', 1, 4, 1, 7, 'administrator', '2024-01-31 09:19:59');

-- Dumping structure for table mis.m_menu
CREATE TABLE IF NOT EXISTS `m_menu` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `menu` varchar(128) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '0 = hide; 1 show;',
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_menu: ~6 rows (approximately)
DELETE FROM `m_menu`;
INSERT INTO `m_menu` (`id`, `menu`, `status`, `created_by`, `created_at`) VALUES
	(1, 'Administrator', 1, 'Administrator', '2023-12-12 10:43:22'),
	(2, 'User', 1, 'Administrator', '2023-12-12 10:43:22'),
	(3, 'Menu', 1, 'Administrator', '2023-12-12 10:43:22'),
	(4, 'HRD', 1, 'admin', NULL),
	(5, 'Report', 1, 'admin', '2024-03-04 10:54:21'),
	(6, 'Report Audit', 1, 'admin', '2024-03-15 10:08:15'),
	(7, 'User_management', 0, 'admin', '2024-03-18 15:24:16');

-- Dumping structure for table mis.m_necessity
CREATE TABLE IF NOT EXISTS `m_necessity` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `necessity` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_necessity: ~4 rows (approximately)
DELETE FROM `m_necessity`;
INSERT INTO `m_necessity` (`id`, `necessity`, `created_by`, `created_at`) VALUES
	(1, 'Tugas untuk mengurus kepentingan perusahaan', 'administrator', '2024-01-30 11:27:27'),
	(2, 'Ijin keluar sementara', 'administrator', '2024-01-30 11:27:27'),
	(3, 'Ijin pulang untuk mengurus kepentingan pribadi', 'administrator', '2024-01-30 11:27:27'),
	(4, 'Ijin pulang karena sakit', 'administrator', '2024-01-30 11:27:27'),
	(5, 'Lain - lain', 'administrator', '2024-01-30 11:27:27');

-- Dumping structure for table mis.m_position
CREATE TABLE IF NOT EXISTS `m_position` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `position` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_position: ~11 rows (approximately)
DELETE FROM `m_position`;
INSERT INTO `m_position` (`id`, `position`, `created_by`, `created_at`) VALUES
	(1, 'DIRECTOR', 'administrator', '2024-01-31 10:45:26'),
	(2, 'SENIOR MANAGER', 'administrator', '2024-01-31 10:45:26'),
	(3, 'GENERAL MANAGER', 'administrator', '2024-01-31 10:45:26'),
	(4, 'MANAGER', 'administrator', '2024-01-31 10:45:26'),
	(5, 'GENERAL SECTION HEAD', 'administrator', '2024-01-31 10:45:26'),
	(6, 'SECTION HEAD', 'administrator', '2024-01-31 10:45:26'),
	(7, 'SUPERVISOR', 'administrator', '2024-01-31 10:45:26'),
	(8, 'ASISTEN SUPERVISOR', 'administrator', '2024-01-31 10:45:26'),
	(9, 'OPERATOR KANTOR/ADMIN', 'administrator', '2024-01-31 10:45:26'),
	(10, 'OPERATOR NON BORONGAN/ADMIN', 'administrator', '2024-01-31 10:45:26'),
	(11, 'OPERATOR TIME BASED', 'administrator', '2024-01-31 10:45:26'),
	(12, 'OPERATOR BORONGAN', 'administrator', '2024-01-31 10:45:26');

-- Dumping structure for table mis.m_role
CREATE TABLE IF NOT EXISTS `m_role` (
  `id` int(16) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_role: ~2 rows (approximately)
DELETE FROM `m_role`;
INSERT INTO `m_role` (`id`, `role`, `created_by`, `created_at`) VALUES
	(1, 'Administrator', 'Administrator', '2023-12-12 10:38:47'),
	(2, 'User', 'Administrator', '2023-12-12 10:38:50');

-- Dumping structure for table mis.m_submenu
CREATE TABLE IF NOT EXISTS `m_submenu` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `menu_id` int(16) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_submenu: ~7 rows (approximately)
DELETE FROM `m_submenu`;
INSERT INTO `m_submenu` (`id`, `menu_id`, `title`, `url`, `icon`, `status`, `created_by`, `created_at`) VALUES
	(1, 1, 'Dashboard', 'administrator', 'fas fa-fw fa-tachometer-alt', 1, 'Administrator', '2023-12-12 10:28:19'),
	(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1, 'Administrator', '2023-12-12 10:28:19'),
	(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1, 'Administrator', '2023-12-12 10:28:19'),
	(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1, 'Administrator', '2023-12-12 10:28:19'),
	(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1, 'Administrator', '2023-12-12 10:28:19'),
	(7, 1, 'Role', 'administrator/role', 'fas fa-fw fa-key', 1, 'Administrator', '2023-12-12 10:28:19'),
	(9, 4, 'Exit Permit', 'hrd', 'fas fa-fw fa-file-signature', 1, NULL, NULL),
	(10, 5, 'Report Exit Permit', 'report/exitPermit', 'fas fa-fw fa-print', 1, NULL, '2024-03-04 10:00:23'),
	(11, 1, 'User', 'user_management', 'fas fa-fw fa-user', 1, NULL, '2024-03-18 14:51:33');

-- Dumping structure for table mis.m_token
CREATE TABLE IF NOT EXISTS `m_token` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(16) NOT NULL,
  `token` varchar(128) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_token: ~2 rows (approximately)
DELETE FROM `m_token`;
INSERT INTO `m_token` (`id`, `user_id`, `token`, `created_at`) VALUES
	(4, 'coba', 'xyUjSmX+AEkwYRrFBdGl2C2r5vLgj06uzbZT2iOSKdU=', '2024-01-04 08:43:24'),
	(5, 'coba', 'L8Ba28doMtle31D4CdTIIbdBao4/Qal2koZ8+GyhHzY=', '2024-01-04 08:45:58');

-- Dumping structure for table mis.m_user
CREATE TABLE IF NOT EXISTS `m_user` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(16) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `company_id` int(16) DEFAULT '1',
  `department_id` int(16) DEFAULT NULL,
  `division_id` int(16) DEFAULT NULL,
  `role_id` int(16) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_user: ~3 rows (approximately)
DELETE FROM `m_user`;
INSERT INTO `m_user` (`id`, `user_id`, `name`, `email`, `image`, `password`, `company_id`, `department_id`, `division_id`, `role_id`, `status`, `created_by`, `created_at`) VALUES
	(1, 'admin', 'admin', 'sysdev@megamarinepride.com', 'default.png', '$2y$10$31nTmbo9IVv6NnjV7FHNHetkM4aIr18q8XRsRsI/y7qHXaNvtYKxK', 1, 4, 1, 1, 1, 'administrator', '2023-11-29 07:41:59'),
	(2, 'user', 'user', 'user@gmail.com', 'default.png', '$2y$10$mqX3iwzex/G/K2cEd5Yer.2DOAYn2AF0G1rFyW249xPh6dS5pX8Fq', 1, 4, 1, 2, 1, 'administrator', '2023-12-08 05:19:30'),
	(6, 'coba', 'coba', 'coba@gmail.com', 'default.jpg', '$2y$10$nJtl8t6Ad8W1y69gos6Vc.Wpv8NIq3fxtoUExl.pqkwePuXBbXes2', 1, 4, 1, 2, 1, 'administrator', '2024-01-03 07:28:55');

-- Dumping structure for table mis.t_exit_permit
CREATE TABLE IF NOT EXISTS `t_exit_permit` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `employee_id` int(16) DEFAULT NULL,
  `date_in` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `necessity_id` int(16) DEFAULT NULL,
  `remark` text,
  `status` tinyint(4) DEFAULT '0',
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `log_by` varchar(256) DEFAULT NULL,
  `log_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `date_in` (`date_in`),
  KEY `time_in` (`time_in`),
  KEY `date_out` (`date_out`),
  KEY `time_out` (`time_out`),
  KEY `necessity_id` (`necessity_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.t_exit_permit: ~13 rows (approximately)
DELETE FROM `t_exit_permit`;
INSERT INTO `t_exit_permit` (`id`, `employee_id`, `date_in`, `time_in`, `date_out`, `time_out`, `necessity_id`, `remark`, `status`, `created_by`, `created_at`, `log_by`, `log_at`) VALUES
	(14, 123456, '2024-02-21', '11:08:28', NULL, NULL, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 0, 'admin', '2024-02-21 11:08:28', NULL, NULL),
	(15, 123456, '2024-02-23', '14:15:55', '2024-02-23', '14:36:19', 1, 'test', 1, 'admin', '2024-02-23 14:15:55', 'admin', '2024-02-23 14:36:19'),
	(16, 123456, '2024-02-23', '14:37:49', '2024-02-23', '14:38:05', 1, 'test', 1, 'admin', '2024-02-23 14:37:49', 'admin', '2024-02-23 14:38:05'),
	(17, 123456, '2024-02-23', '14:38:18', '2024-02-23', '14:38:29', 1, 'test', 1, 'admin', '2024-02-23 14:38:18', 'admin', '2024-02-23 14:38:29'),
	(19, 123456, '2024-02-23', '14:50:20', NULL, NULL, 1, 'test', 3, 'admin', '2024-02-23 14:50:20', NULL, NULL),
	(20, 123456, '2024-02-27', '09:59:14', '2024-02-27', '09:59:32', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 1, 'admin', '2024-02-27 09:59:14', 'admin', '2024-02-27 09:59:32'),
	(21, 123456, '2024-02-27', '11:08:15', '2024-02-27', '11:08:31', 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 1, 'admin', '2024-02-27 11:08:15', 'admin', '2024-02-27 11:08:31'),
	(22, 123456, '2024-02-27', '11:08:43', NULL, NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 2, 'admin', '2024-02-27 11:08:43', 'admin', '2024-02-27 11:08:49'),
	(23, 123456, '2024-02-27', '11:28:09', NULL, NULL, 1, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', 2, 'admin', '2024-02-27 11:28:09', 'admin', '2024-02-27 11:53:51'),
	(24, 123456, '2024-02-27', '11:54:33', NULL, NULL, 5, 'test new data from uncomplete data', 2, 'admin', '2024-02-27 11:54:33', 'admin', '2024-02-28 14:12:14'),
	(25, 123456, '2024-02-28', '14:12:20', '2024-02-28', '14:12:33', 1, 'test', 1, 'admin', '2024-02-28 14:12:20', 'admin', '2024-02-28 14:12:33'),
	(26, 123456, '2024-02-29', '13:34:45', '2024-03-01', '14:27:11', 5, '1', 1, 'admin', '2024-02-29 13:34:45', 'admin', '2024-03-04 09:15:21'),
	(27, 123456, '2024-03-04', '09:18:11', '2024-03-04', '09:19:04', 4, '1 edit', 1, 'admin', '2024-03-04 09:18:11', 'admin', '2024-03-04 09:19:04'),
	(28, 123456, '2024-03-04', '09:31:15', '2024-03-04', '14:54:00', 5, '-', 1, 'admin', '2024-03-04 09:31:15', 'admin', '2024-03-04 14:54:00'),
	(29, 123456, '2024-03-19', '16:17:41', '2024-03-19', '16:22:37', 2, 'tugas perusahaan', 1, 'admin', '2024-03-19 16:17:41', 'admin', '2024-03-19 16:22:37');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

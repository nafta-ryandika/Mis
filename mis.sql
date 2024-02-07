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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_access: ~5 rows (approximately)
DELETE FROM `m_access`;
INSERT INTO `m_access` (`id`, `role_id`, `menu_id`, `created_by`, `created_at`) VALUES
	(1, 1, 1, 'Administrator', '2023-12-12 10:31:47'),
	(3, 2, 2, 'Administrator', '2023-12-12 10:32:49'),
	(4, 1, 3, 'Administrator', '2023-12-12 10:32:49'),
	(12, 1, 2, NULL, NULL),
	(17, 1, 4, NULL, NULL);

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

-- Dumping data for table mis.m_department: ~8 rows (approximately)
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
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_menu: ~4 rows (approximately)
DELETE FROM `m_menu`;
INSERT INTO `m_menu` (`id`, `menu`, `created_by`, `created_at`) VALUES
	(1, 'Administrator', 'Administrator', '2023-12-12 10:43:22'),
	(2, 'User', 'Administrator', '2023-12-12 10:43:22'),
	(3, 'Menu', 'Administrator', '2023-12-12 10:43:22'),
	(4, 'HRD', 'admin', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_submenu: ~7 rows (approximately)
DELETE FROM `m_submenu`;
INSERT INTO `m_submenu` (`id`, `menu_id`, `title`, `url`, `icon`, `status`, `created_by`, `created_at`) VALUES
	(1, 1, 'Dashboard', 'administrator', 'fas fa-fw fa-tachometer-alt', 1, 'Administrator', '2023-12-12 10:28:19'),
	(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1, 'Administrator', '2023-12-12 10:28:19'),
	(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1, 'Administrator', '2023-12-12 10:28:19'),
	(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1, 'Administrator', '2023-12-12 10:28:19'),
	(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1, 'Administrator', '2023-12-12 10:28:19'),
	(7, 1, 'Role', 'administrator/role', 'fas fa-fw fa-user-tie', 1, 'Administrator', '2023-12-12 10:28:19'),
	(9, 4, 'Exit Permit', 'hrd', 'fas fa-fw fa-file-signature', 1, NULL, NULL);

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
  `user_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `department` varchar(256) DEFAULT NULL,
  `division` varchar(256) DEFAULT NULL,
  `role_id` int(16) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_user: ~3 rows (approximately)
DELETE FROM `m_user`;
INSERT INTO `m_user` (`id`, `user_id`, `name`, `email`, `image`, `password`, `department`, `division`, `role_id`, `status`, `created_by`, `created_at`) VALUES
	(1, 'admin', 'admin', 'sysdev@megamarinepride.com', 'default.png', '$2y$10$31nTmbo9IVv6NnjV7FHNHetkM4aIr18q8XRsRsI/y7qHXaNvtYKxK', '', '', 1, 1, 'administrator', '2023-11-29 07:41:59'),
	(2, 'user', 'user', 'user@gmail.com', 'default.png', '$2y$10$mqX3iwzex/G/K2cEd5Yer.2DOAYn2AF0G1rFyW249xPh6dS5pX8Fq', '', '', 2, 1, 'administrator', '2023-12-08 05:19:30'),
	(6, 'coba', 'coba', 'coba@gmail.com', 'default.jpg', '$2y$10$nJtl8t6Ad8W1y69gos6Vc.Wpv8NIq3fxtoUExl.pqkwePuXBbXes2', '', '', 2, 1, 'administrator', '2024-01-03 07:28:55');

-- Dumping structure for table mis.t_exit_permit
CREATE TABLE IF NOT EXISTS `t_exit_permit` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `employee_id` int(16) DEFAULT NULL,
  `date_in` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `necessity_id` int(16) DEFAULT NULL,
  `remark` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  KEY `date_in` (`date_in`),
  KEY `time_in` (`time_in`),
  KEY `date_out` (`date_out`),
  KEY `time_out` (`time_out`),
  KEY `necessity_id` (`necessity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.t_exit_permit: ~0 rows (approximately)
DELETE FROM `t_exit_permit`;
INSERT INTO `t_exit_permit` (`id`, `employee_id`, `date_in`, `time_in`, `date_out`, `time_out`, `necessity_id`, `remark`, `created_by`, `created_at`) VALUES
	(1, 123456, '2024-01-31', '11:02:11', '2024-01-31', '12:00:00', 5, 'test', 'administrator', '2024-01-31 11:02:23');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

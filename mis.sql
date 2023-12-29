-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.51-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6778
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_access: ~4 rows (approximately)
DELETE FROM `m_access`;
INSERT INTO `m_access` (`id`, `role_id`, `menu_id`, `created_by`, `created_at`) VALUES
	(1, 1, 1, 'Administrator', '2023-12-12 10:31:47'),
	(2, 1, 2, 'Administrator', '2023-12-12 10:31:47'),
	(3, 2, 2, 'Administrator', '2023-12-12 10:32:49'),
	(4, 1, 3, 'Administrator', '2023-12-12 10:32:49');

-- Dumping structure for table mis.m_menu
CREATE TABLE IF NOT EXISTS `m_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu` varchar(128) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_menu: ~2 rows (approximately)
DELETE FROM `m_menu`;
INSERT INTO `m_menu` (`id`, `menu`, `created_by`, `created_at`) VALUES
	(1, 'Administrator', 'Administrator', '2023-12-12 10:43:22'),
	(2, 'User', 'Administrator', '2023-12-12 10:43:22'),
	(3, 'Menu', 'Administrator', '2023-12-12 10:43:22'),
	(4, 'test', NULL, NULL);

-- Dumping structure for table mis.m_role
CREATE TABLE IF NOT EXISTS `m_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(256) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_role: ~2 rows (approximately)
DELETE FROM `m_role`;
INSERT INTO `m_role` (`id`, `role`, `created_by`, `created_at`) VALUES
	(1, 'Administrator', 'Administrator', '2023-12-12 10:38:47'),
	(2, 'User', 'Administrator', '2023-12-12 10:38:50');

-- Dumping structure for table mis.m_submenu
CREATE TABLE IF NOT EXISTS `m_submenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table mis.m_submenu: ~7 rows (approximately)
DELETE FROM `m_submenu`;
INSERT INTO `m_submenu` (`id`, `menu_id`, `title`, `url`, `icon`, `status`, `created_by`, `created_at`) VALUES
	(1, 1, 'Dashboard', 'administrator', 'fas fa-fw fa-tachometer-alt', 1, 'Administrator', '2023-12-12 10:28:19'),
	(2, 2, 'My Profile', 'user', 'fas fa-fw fa-user', 1, 'Administrator', '2023-12-12 10:28:19'),
	(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1, 'Administrator', '2023-12-12 10:28:19'),
	(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1, 'Administrator', '2023-12-12 10:28:19'),
	(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1, 'Administrator', '2023-12-12 10:28:19'),
	(6, 1, 'test', 'coba/coba', 'fab fa-fw fa-youtube', 1, NULL, NULL),
	(7, 1, 'Role', 'administrator/role', 'fas fa-fw fa-user-tie', 1, NULL, NULL);

-- Dumping structure for table mis.m_user
CREATE TABLE IF NOT EXISTS `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(16) NOT NULL DEFAULT '',
  `name` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `department` varchar(256) DEFAULT NULL,
  `division` varchar(256) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(256) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mis.m_user: ~2 rows (approximately)
DELETE FROM `m_user`;
INSERT INTO `m_user` (`id`, `user_id`, `name`, `email`, `image`, `password`, `department`, `division`, `role_id`, `status`, `created_by`, `created_at`) VALUES
	(1, 'admin', 'admin', 'sysdev@megamarinepride.com', 'default.png', '$2y$10$31nTmbo9IVv6NnjV7FHNHetkM4aIr18q8XRsRsI/y7qHXaNvtYKxK', '', '', 1, 1, 'administrator', '2023-11-29 07:41:59'),
	(2, 'user', 'user', 'user@gmail.com', 'default.png', '$2y$10$mqX3iwzex/G/K2cEd5Yer.2DOAYn2AF0G1rFyW249xPh6dS5pX8Fq', '', '', 2, 1, 'administrator', '2023-12-08 05:19:30');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

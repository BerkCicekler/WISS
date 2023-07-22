-- --------------------------------------------------------
-- Sunucu:                       127.0.0.1
-- Sunucu sürümü:                10.4.21-MariaDB - mariadb.org binary distribution
-- Sunucu İşletim Sistemi:       Win64
-- HeidiSQL Sürüm:               11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- wiss için veritabanı yapısı dökülüyor
CREATE DATABASE IF NOT EXISTS `wiss` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci */;
USE `wiss`;

-- tablo yapısı dökülüyor wiss.accounts
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `password` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `name` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `position` varchar(150) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '[]',
  `authority` int(1) NOT NULL DEFAULT 0,
  `selectedLanguage` varchar(3) COLLATE utf8mb4_turkish_ci DEFAULT 'TR',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.accounts: ~3 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `accounts`;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`id`, `username`, `password`, `name`, `position`, `authority`, `selectedLanguage`) VALUES
	(1, 'admin', 'admin', 'Wiro', '[]', 2, 'TR');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.cellphonebrands
CREATE TABLE IF NOT EXISTS `cellphonebrands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.cellphonebrands: ~8 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `cellphonebrands`;
/*!40000 ALTER TABLE `cellphonebrands` DISABLE KEYS */;
INSERT INTO `cellphonebrands` (`id`, `value`) VALUES
	(1, 'Apple'),
	(2, 'General Mobile'),
	(3, 'Honor'),
	(4, 'Huawei'),
	(5, 'Oppo'),
	(6, 'Realme'),
	(7, 'Samsung'),
	(8, 'Xiaomi');
/*!40000 ALTER TABLE `cellphonebrands` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.cellphonedebits
CREATE TABLE IF NOT EXISTS `cellphonedebits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cellPhoneId` int(11) NOT NULL DEFAULT 0,
  `employeeId` int(11) NOT NULL DEFAULT 0,
  `debitStartDate` date DEFAULT NULL,
  `debitEndDate` date DEFAULT NULL,
  `extensionNumber` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.cellphones
CREATE TABLE IF NOT EXISTS `cellphones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(2) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `model` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `serialNumber` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `IMEI` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `wifiMac` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `adapter` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `purchaseDate` date NOT NULL,
  `isTrash` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.computerantivirus
CREATE TABLE IF NOT EXISTS `computerantivirus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computerantivirus: ~3 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computerantivirus`;
/*!40000 ALTER TABLE `computerantivirus` DISABLE KEYS */;
INSERT INTO `computerantivirus` (`id`, `value`) VALUES
	(1, ' '),
	(2, 'Eset'),
	(3, 'None');
/*!40000 ALTER TABLE `computerantivirus` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computerbrands
CREATE TABLE IF NOT EXISTS `computerbrands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computerbrands: ~10 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computerbrands`;
/*!40000 ALTER TABLE `computerbrands` DISABLE KEYS */;
INSERT INTO `computerbrands` (`id`, `value`) VALUES
	(1, ' '),
	(2, 'Acer'),
	(3, 'Apple'),
	(4, 'Asus'),
	(5, 'Dell'),
	(6, 'Hp'),
	(7, 'Lenovo'),
	(8, 'Samsung'),
	(9, 'Sony'),
	(10, 'Toshiba');
/*!40000 ALTER TABLE `computerbrands` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computerdebits
CREATE TABLE IF NOT EXISTS `computerdebits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `computerId` int(11) DEFAULT NULL,
  `employeeId` int(11) DEFAULT NULL,
  `debitStartDate` date DEFAULT NULL,
  `debitEndDate` date DEFAULT NULL,
  `mouse` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `adapter` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `bag` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `keyboard` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `monitor` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.computerkinds
CREATE TABLE IF NOT EXISTS `computerkinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computerkinds: ~4 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computerkinds`;
/*!40000 ALTER TABLE `computerkinds` DISABLE KEYS */;
INSERT INTO `computerkinds` (`id`, `value`) VALUES
	(1, ' '),
	(2, 'Laptop'),
	(3, 'Desktop'),
	(4, 'AIO');
/*!40000 ALTER TABLE `computerkinds` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computerofficeprograms
CREATE TABLE IF NOT EXISTS `computerofficeprograms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computerofficeprograms: ~5 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computerofficeprograms`;
/*!40000 ALTER TABLE `computerofficeprograms` DISABLE KEYS */;
INSERT INTO `computerofficeprograms` (`id`, `value`) VALUES
	(3, ' '),
	(4, 'Office 2019'),
	(5, 'Office 2010'),
	(6, 'Libre Office'),
	(7, 'None');
/*!40000 ALTER TABLE `computerofficeprograms` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computeros
CREATE TABLE IF NOT EXISTS `computeros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computeros: ~5 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computeros`;
/*!40000 ALTER TABLE `computeros` DISABLE KEYS */;
INSERT INTO `computeros` (`id`, `value`) VALUES
	(1, ' '),
	(2, 'Windows 11'),
	(3, 'Windows 10'),
	(4, 'Windows 8'),
	(5, 'Windows 7');
/*!40000 ALTER TABLE `computeros` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computerram
CREATE TABLE IF NOT EXISTS `computerram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.computerram: ~7 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `computerram`;
/*!40000 ALTER TABLE `computerram` DISABLE KEYS */;
INSERT INTO `computerram` (`id`, `value`) VALUES
	(1, '1 GB'),
	(2, '2 GB'),
	(3, '3 GB'),
	(4, '4 GB'),
	(5, '8 GB'),
	(6, '12 GB'),
	(7, '16 GB');
/*!40000 ALTER TABLE `computerram` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.computers
CREATE TABLE IF NOT EXISTS `computers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `brand` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `model` varchar(40) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `serialNumber` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `CPU` varchar(40) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `RAM` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `disk` varchar(40) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `dateOfPurchase` date DEFAULT NULL,
  `wifiMac` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `ethMac` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `OS` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `officePrograms` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `antiVirus` varchar(2) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `isTrash` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '',
  `surname` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL,
  `position` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `birthDate` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `socialIdentityNumber` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `workGroup` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `homeAddress` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `phoneNumber` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `startWorkDate` date DEFAULT NULL,
  `dismissalDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.fieldequipments
CREATE TABLE IF NOT EXISTS `fieldequipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) DEFAULT NULL,
  `type` varchar(1) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `model` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `debitStartDate` date DEFAULT NULL,
  `debitEndDate` date DEFAULT NULL,
  `isTrash` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.fieldequipmenttypes
CREATE TABLE IF NOT EXISTS `fieldequipmenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- tablo yapısı dökülüyor wiss.networkdbrands
CREATE TABLE IF NOT EXISTS `networkdbrands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;


-- tablo yapısı dökülüyor wiss.networkdevicedebits
CREATE TABLE IF NOT EXISTS `networkdevicedebits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `networkDeviceId` int(11) NOT NULL DEFAULT 0,
  `employeeId` int(11) NOT NULL DEFAULT 0,
  `debitStartDate` date DEFAULT NULL,
  `debitEndDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

-- wiss.networkdevicedebits: ~0 rows (yaklaşık) tablosu için veriler indiriliyor
DELETE FROM `networkdevicedebits`;
/*!40000 ALTER TABLE `networkdevicedebits` DISABLE KEYS */;
/*!40000 ALTER TABLE `networkdevicedebits` ENABLE KEYS */;

-- tablo yapısı dökülüyor wiss.networkdevices
CREATE TABLE IF NOT EXISTS `networkdevices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(3) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `brand` varchar(3) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `model` varchar(50) COLLATE utf8mb4_turkish_ci NOT NULL DEFAULT '0',
  `serialNumber` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `purchaseDate` date DEFAULT NULL,
  `isTrash` int(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;



-- tablo yapısı dökülüyor wiss.networkdkinds
CREATE TABLE IF NOT EXISTS `networkdkinds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;



-- tablo yapısı dökülüyor wiss.positions
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;


/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bank_mini_sekolah
DROP DATABASE IF EXISTS `bank_mini_sekolah`;
CREATE DATABASE IF NOT EXISTS `bank_mini_sekolah` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bank_mini_sekolah`;

-- Dumping structure for table bank_mini_sekolah.log_aktivitas
DROP TABLE IF EXISTS `log_aktivitas`;
CREATE TABLE IF NOT EXISTS `log_aktivitas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `aksi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bank_mini_sekolah.log_aktivitas: ~0 rows (approximately)
DELETE FROM `log_aktivitas`;

-- Dumping structure for table bank_mini_sekolah.nasabah
DROP TABLE IF EXISTS `nasabah`;
CREATE TABLE IF NOT EXISTS `nasabah` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nis` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `saldo` decimal(12,2) DEFAULT '0.00',
  `pin_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nis` (`nis`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `nasabah_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bank_mini_sekolah.nasabah: ~0 rows (approximately)
DELETE FROM `nasabah`;

-- Dumping structure for table bank_mini_sekolah.transaksi
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nasabah_id` int NOT NULL,
  `petugas_id` int DEFAULT NULL,
  `jenis` enum('setor','tarik') COLLATE utf8mb4_general_ci NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `saldo_setelah` decimal(12,2) NOT NULL,
  `status` enum('aktif','batal') COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `nasabah_id` (`nasabah_id`),
  KEY `petugas_id` (`petugas_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`nasabah_id`) REFERENCES `nasabah` (`id`),
  CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bank_mini_sekolah.transaksi: ~0 rows (approximately)
DELETE FROM `transaksi`;

-- Dumping structure for table bank_mini_sekolah.transfer
DROP TABLE IF EXISTS `transfer`;
CREATE TABLE IF NOT EXISTS `transfer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dari_nasabah` int NOT NULL,
  `ke_nasabah` int NOT NULL,
  `nominal` decimal(12,2) NOT NULL,
  `status` enum('aktif','batal') COLLATE utf8mb4_general_ci DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `dari_nasabah` (`dari_nasabah`),
  KEY `ke_nasabah` (`ke_nasabah`),
  CONSTRAINT `transfer_ibfk_1` FOREIGN KEY (`dari_nasabah`) REFERENCES `nasabah` (`id`),
  CONSTRAINT `transfer_ibfk_2` FOREIGN KEY (`ke_nasabah`) REFERENCES `nasabah` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bank_mini_sekolah.transfer: ~0 rows (approximately)
DELETE FROM `transfer`;

-- Dumping structure for table bank_mini_sekolah.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','petugas','nasabah') COLLATE utf8mb4_general_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bank_mini_sekolah.users: ~1 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `username`, `password`, `role`, `last_login`, `created_at`) VALUES
	(4, 'admin', '$2y$10$q5jCUlRRYiNT2fDHTjn1HeiqrxjobNegpDOe0hY9PghwNUhPle//6', 'admin', NULL, '2026-02-09 15:45:38');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

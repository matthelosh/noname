-- Valentina Studio --
-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE TABLE "menus" ----------------------------------------
-- CREATE TABLE `menus`( 
-- 	`id` BigInt( 20 ) UNSIGNED AUTO_INCREMENT NOT NULL,
-- 	`parent_id` Int( 11 ) NOT NULL DEFAULT 0,
-- 	`url` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
-- 	`icon` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
-- 	`label` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
-- 	`created_at` Timestamp NULL DEFAULT NULL,
-- 	`updated_at` Timestamp NULL DEFAULT NULL,
-- 	PRIMARY KEY ( `id` ) )
-- CHARACTER SET = utf8mb4
-- COLLATE = utf8mb4_unicode_ci
-- ENGINE = InnoDB
-- AUTO_INCREMENT = 23;
-- -------------------------------------------------------------


-- Dump data of "menus" ------------------------------------
BEGIN;

INSERT INTO `menus`(`id`,`parent_id`,`url`,`icon`,`label`,`created_at`,`updated_at`) VALUES 
( '1', '0', '/dashboard', 'home', 'Beranda', NULL, NULL ),
( '2', '0', '/dashboard/about', 'information', 'Tentang', NULL, NULL ),
( '3', '0', '#', 'database', 'Data Master', NULL, NULL ),
( '4', '0', '#', 'tablet-dashboard', 'Administrasi', NULL, NULL ),
( '5', '0', '#', 'dip-switch', 'Pengaturan', NULL, NULL ),
( '6', '0', '#', 'tools', 'Alat', NULL, NULL ),
( '7', '3', '/dashboard/user', 'account-tie', 'Pengguna', NULL, NULL ),
( '8', '3', '/dashboard/siswa', 'school', 'Siswa', NULL, NULL ),
( '9', '3', '/dashboard/kelas', 'office-building', 'Kelas', NULL, NULL ),
( '10', '3', '/dashboard/rombel', 'google-classroom', 'Rombel', NULL, NULL ),
( '11', '4', '/dashboard/pembelajaran', 'bookshelf', 'Pembelajaran', NULL, NULL ),
( '12', '4', '/dashboard/penilaian', 'check-box-multiple-outline', 'Penilaian', NULL, NULL ),
( '13', '4', '/dashboard/rapor', 'book-open', 'Rapor', NULL, NULL ),
( '14', '5', '/dashboard/sekolah', 'office-building-outline', 'Sekolah', NULL, NULL ),
( '15', '5', '/dashboard/periode', 'calendar-month', 'Periode', NULL, NULL ),
( '16', '5', '/dashboard/logs', 'notification-clear-all', 'Catatan Log', NULL, NULL ),
( '17', '6', '/dashboard/backup', 'database-export', 'Cadangkan Data', NULL, NULL ),
( '18', '6', '/dashboard/restore', 'database-import', 'Pulihkan Data', NULL, NULL ),
( '19', '3', '/dashboard/mapel', 'book-open', 'Mapel', NULL, NULL ),
( '20', '3', '/dashboard/prosem', 'notebook', 'Prosem', NULL, NULL ),
( '21', '5', '/dashboard/pengaturan/rapor', 'book-open', 'Pengaturan Rapor', NULL, NULL ),
( '22', '3', '/dashboard/guru', 'teach', 'Guru', NULL, NULL );
COMMIT;
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------



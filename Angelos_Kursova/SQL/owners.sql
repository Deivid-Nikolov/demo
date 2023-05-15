-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            10.4.28-MariaDB - mariadb.org binary distribution
-- ОС на сървъра:                Win64
-- HeidiSQL Версия:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Дъмп структура за таблица angelos_kursova.owners
CREATE TABLE IF NOT EXISTS `owners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `egn` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `yearly_income` int(11) DEFAULT NULL,
  `has_family` enum('YES','NO') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица angelos_kursova.owners: ~2 rows (приблизително)
INSERT INTO `owners` (`id`, `first_name`, `middle_name`, `last_name`, `egn`, `email`, `number`, `address`, `yearly_income`, `has_family`) VALUES
	(2, 'Marta', 'Probnova', 'Karneva', '9402241320', 'marta@abv.bg', '0892345553', 'Lukovit Lilov 19', 5000, 'NO'),
	(3, 'Христо', 'Йосифов', 'Маринов', '8911119084', 'hristo@abv.bg', '089 542 1212', 'Kyustendil Georgi Dimitrov 22', 8500, 'YES');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

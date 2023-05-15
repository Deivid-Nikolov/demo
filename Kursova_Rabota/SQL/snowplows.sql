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

-- Дъмп структура за таблица kursova_rabota.snowplows
CREATE TABLE IF NOT EXISTS `snowplows` (
  `snowplow_id` int(11) NOT NULL AUTO_INCREMENT,
  `year` year(4) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `length_m` decimal(20,6) DEFAULT NULL,
  `width_m` decimal(20,6) DEFAULT NULL,
  `height_m` decimal(20,6) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`snowplow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица kursova_rabota.snowplows: ~5 rows (приблизително)
INSERT INTO `snowplows` (`snowplow_id`, `year`, `brand`, `model`, `number`, `length_m`, `width_m`, `height_m`, `color`) VALUES
	(1, '2012', 'Toyota', 'Land Cruiser', 'BP3328MB', 4.940000, 1.940000, 1.880000, 'white'),
	(2, '2010', 'Iveco', 'TRAKKER AD/AT 380T41', 'BH4032EE', 7.680000, 2.550000, 3.106000, 'white'),
	(3, '2010', 'Mercedes-Benz', 'Atego 1223', 'M5234EM', 6.380000, 2.520000, 3.480000, 'red'),
	(4, '1991', 'MAN', '19.272', 'BP1100EM', 6.975000, 2.031000, 3.487000, 'orange'),
	(5, '2002', 'Scania ', '114 4X4', 'BP2901EE', 8.930000, 2.490000, 3.576000, 'orange');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

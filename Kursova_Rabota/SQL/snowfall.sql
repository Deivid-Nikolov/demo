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

-- Дъмп структура за таблица kursova_rabota.snowfall
CREATE TABLE IF NOT EXISTS `snowfall` (
  `snowfall_id` int(11) NOT NULL AUTO_INCREMENT,
  `snowfall_date` date DEFAULT NULL,
  `snowplow_id` int(11) DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `clearing_time` time DEFAULT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`snowfall_id`),
  KEY `snowplow_id` (`snowplow_id`) USING BTREE,
  KEY `snowfall_driver` (`driver_id`),
  CONSTRAINT `fk_snowfall` FOREIGN KEY (`snowplow_id`) REFERENCES `snowplows` (`snowplow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица kursova_rabota.snowfall: ~4 rows (приблизително)
INSERT INTO `snowfall` (`snowfall_id`, `snowfall_date`, `snowplow_id`, `departure_time`, `clearing_time`, `driver_id`, `notes`) VALUES
	(1, '2023-01-14', 4, '07:25:47', '01:48:44', 1, 'No problem'),
	(2, '2023-01-18', 4, '06:45:05', '02:09:19', 5, 'The snowplow\'s engine broke'),
	(3, '2023-01-21', 1, '07:48:17', '01:27:41', 6, 'No problem'),
	(4, '2023-01-28', 3, '05:44:41', '00:36:57', 2, 'No problem');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

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

-- Дъмп структура за таблица kursova_rabota.drivers
CREATE TABLE IF NOT EXISTS `drivers` (
  `driver_id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `licence` enum('B','B1','C','C1','D','D1') DEFAULT NULL,
  `citizen_number` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`driver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица kursova_rabota.drivers: ~7 rows (приблизително)
INSERT INTO `drivers` (`driver_id`, `first_name`, `middle_name`, `last_name`, `licence`, `citizen_number`, `address`) VALUES
	(1, 'Дейвид', 'Николов', 'Дениславов', 'D1', '8904218915', 'Улица Георги Димитров'),
	(3, 'Генади', 'Кръстев', 'Лилов', 'D', '9512302030', 'Перуша - Ботевград'),
	(9, 'Благо', 'Георгиев', 'Йосифов', 'D', '9512302030', 'Улица Библейска'),
	(10, 'Гаврил', 'Кръстев', 'Лилов', 'C1', '9606138110', 'Христо Ботев 19'),
	(12, 'Цветан', 'Фиданов', 'Литов', 'C', '7911203900', 'Улица Найден Геров 11'),
	(13, 'Малин', 'Пешев', 'Кръстев', 'C', '8811029019', 'Улица Немска Изгода 20'),
	(14, 'Генчо', 'Рашков', 'Патроников', 'B', '0101302029', 'Калиманджара'),
	(15, 'Цветомир', 'Теодоров', 'Дяков', 'C', '9702220101', 'Улица Незабравка'),
	(16, 'Петър', 'Стефанов', 'Владов', 'C1', '8811029019', 'Ботевград Витоша 8');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

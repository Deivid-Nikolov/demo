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

-- Дъмп структура за таблица ivo_kursova.projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type` enum('fundraising','non-profit','civil-league','charity') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `financement` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица ivo_kursova.projects: ~2 rows (приблизително)
INSERT INTO `projects` (`id`, `name`, `type`, `description`, `financement`) VALUES
	(4, 'BlackLiveMatters', 'fundraising', 'Ние сме развълнувани да обявим нашето предстоящо събитие за набиране на средства, посветено на подобряването на живота на кучетата от приютите в нашата общност. Присъединете се към нас за една вечер на стоплящи сърцето истории, интерактивни дейности и възможности да се свържете с други любители на кучета, които споделят страст към хуманното отношение към животните. Заедно можем да променим живота на тези космати приятели.', 'Furry Paws'),
	(6, 'ProgrammingGeeks', 'charity', 'Събиране на анонимните пияници', 'Собствени Активи'),
	(8, 'The Futerist', 'charity', 'Let\'s embrace the future together.', 'The Government');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

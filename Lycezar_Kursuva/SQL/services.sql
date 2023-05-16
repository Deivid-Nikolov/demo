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

-- Дъмп структура за таблица lycezar_kursova.services
CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `kind` enum('hairstyle','massage') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Дъмп данни за таблица lycezar_kursova.services: ~7 rows (приблизително)
INSERT INTO `services` (`id`, `name`, `price`, `description`, `kind`) VALUES
	(1, 'Swedish hairstyle', 20, 'дддд', 'hairstyle'),
	(2, 'SCALP TREATMENT', 20, 'Individuals who experience dry and itchy scalp may request for a scalp treatment. This service delivers a lovely feeling, and it restores the oil production in the scalp to promote healthy hair growth. Scalp treatment can use for individuals with oily scalp or those with a dry, flaky scalp. Maintaining a healthy scalp is necessary to have healthy hair. Read our blog on curly hair tips.', 'hairstyle'),
	(3, 'Deep Tissue Massage', 21, 'A step above a Swedish massage, the deep tissue massage uses more pressure and is aimed at releasing toxins built up in your muscles and blood. If you have muscle soreness, tightness, trigger points, or injury, the slow strokes and deep finger pressure reach the deepest layers of your muscles and tissue to relieve chronic pain.', 'massage'),
	(4, 'HOT OIL TREATMENT', 15, 'Hot oil treatment is one of the most favoured when customers desire quick shine and close the hair cuticle. This results in soft hair that looks and smooth and well-nourished feel. The method usually needs 30 minutes to 1 hour depending on the hair situation and health. The oil treatment needs to apply on the hair for about 15-20 minutes then wash out. Clients with coloured hair as well as those with dry and frizzy hair can help from this hair treatment.', 'hairstyle'),
	(5, 'Aromatherapy Massage', 30, 'If essential oils are a passion of yours, you’ll love an aromatherapy massage. Your massage therapist will use an essential oil diffuser and diluted essential oils on their hands so your skin can absorb the oils.', 'massage'),
	(6, 'MOISTURE TREATMENT', 35, 'Rejuvenate dry and thirsty tresses with a moisture protein treatment. The creme deep conditioning treatment, a quality moisture treatment can cure typical hair woes such as split ends and lack of shine. Olaplex Hair Perfector No 3 is a famous repairing treatment that is rubbed into the hair during a luxurious and cozy service and can be added to the price of your weekly blowout. It’s best for overprocessed, heat damaged, dried, and desperate hair that requires a little love. Add a moisture treatment to your next colouring service and your hair will be happy.', 'hairstyle'),
	(8, 'Tanta', 222, 'Jls', 'massage');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

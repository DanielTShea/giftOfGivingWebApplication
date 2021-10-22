-- MariaDB dump 10.19  Distrib 10.4.19-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: giftofgivingdb
-- ------------------------------------------------------
-- Server version	10.4.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist` (
  `wishlist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login_information_id` int(10) unsigned NOT NULL,
  `item_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `item_description` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `item_link` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `quantity` decimal(10,0) DEFAULT NULL,
  `item_price` decimal(10,0) DEFAULT NULL,
  `birthday_gift` tinyint(1) DEFAULT NULL,
  `holiday_gift` tinyint(1) DEFAULT NULL,
  `already_purchased` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`wishlist_id`),
  KEY `login_wishlist_fk` (`login_information_id`),
  CONSTRAINT `login_wishlist_fk` FOREIGN KEY (`login_information_id`) REFERENCES `login_information` (`login_information_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (1,1,'donkey','kong','donkey',2,2,1,1,1),(2,9,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,0),(3,2,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,0),(4,2,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,1),(5,3,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,0),(6,3,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,1),(7,4,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,0),(8,4,'Vortex','Best football ever','https://nerf.hasbro.com/en-us',1,13,1,1,1);
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-08-14 14:14:14

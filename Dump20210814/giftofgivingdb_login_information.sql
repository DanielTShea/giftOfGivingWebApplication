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
-- Table structure for table `login_information`
--

DROP TABLE IF EXISTS `login_information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_information` (
  `login_information_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) CHARACTER SET utf8 NOT NULL,
  `login_password` char(60) NOT NULL,
  PRIMARY KEY (`login_information_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_information`
--

LOCK TABLES `login_information` WRITE;
/*!40000 ALTER TABLE `login_information` DISABLE KEYS */;
INSERT INTO `login_information` VALUES (1,'hello','hello'),(2,'Mike','$2y$10$XLdKCE2qgwPDK01N5KikgOsnTMILzvOhD5Q0uaoSaTvTG24GOmNv6'),(3,'Carol','$2y$10$YiggjL09c95V7WivMYHdLOabBTwjR9MJjq8FjiVTnX0pNN/PLXNcO'),(4,'Greg','$2y$10$pavYE7N5y2sNqqyRaevVMeskZ7D3u/1Uc2Jd16Rhqc.IG9EnjJiI.'),(5,'Peter','$2y$10$m1HlM22Fkt1oVy6XBR0dJ.TVAdKNE1A51ymOGTuP4IF4IiiVNpbui'),(6,'Bobby','$2y$10$JhcLPh6Rh7iFRvGGnzYhDuwclz.nBnot2i60u0fGHHe57shG/xI6C'),(7,'Marcia','$2y$10$/eJF13hx53wp8B1On1nWqOGy784ZQnd9k28CrNQ6rRYC1eDu5GsOO'),(8,'Jan','$2y$10$50a5QfSwC0X1O3ovvcrIAue.qcLJ6B2oXN9JZWlQIfpqMl34SQneO'),(9,'Cindy','$2y$10$3VU9tWjgzKekPYwajR8I1uV.Wt/553HSpPw8o7WEKj1xiQ7zait4y');
/*!40000 ALTER TABLE `login_information` ENABLE KEYS */;
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

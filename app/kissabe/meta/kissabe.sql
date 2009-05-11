-- MySQL dump 10.11
--
-- Host: localhost    Database: kissabe_v3
-- ------------------------------------------------------
-- Server version	5.0.75-0ubuntu10

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
-- Table structure for table `ownership`
--

DROP TABLE IF EXISTS `ownership`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `ownership` (
  `id` int(16) NOT NULL auto_increment,
  `user_id` int(16) NOT NULL,
  `url_id` int(16) NOT NULL,
  `created_by` varchar(32) NOT NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `type` enum('created','favorited') NOT NULL,
  `status` enum('live','dead') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `url_id` (`url_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `ownership`
--

LOCK TABLES `ownership` WRITE;
/*!40000 ALTER TABLE `ownership` DISABLE KEYS */;
INSERT INTO `ownership` VALUES (1,1,1,'127.0.0.1','2009-04-04 13:45:37','created','live'),(2,1,2,'127.0.0.1','2009-04-04 13:59:51','created','live'),(3,1,3,'127.0.0.1','2009-04-05 18:19:58','created','live'),(4,1,4,'127.0.0.1','2009-04-11 13:28:39','created','live'),(5,1,5,'127.0.0.1','2009-04-12 14:54:35','created','live'),(6,1,6,'127.0.0.1','2009-04-28 19:13:42','created','live'),(7,1,7,'127.0.0.1','2009-04-28 19:19:10','created','live');
/*!40000 ALTER TABLE `ownership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statistic`
--

DROP TABLE IF EXISTS `statistic`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `statistic` (
  `id` int(16) NOT NULL,
  `st_key` varchar(256) NOT NULL,
  `st_value` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `statistic`
--

LOCK TABLES `statistic` WRITE;
/*!40000 ALTER TABLE `statistic` DISABLE KEYS */;
/*!40000 ALTER TABLE `statistic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `url`
--

DROP TABLE IF EXISTS `url`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `url` (
  `id` int(16) NOT NULL auto_increment,
  `code` varchar(256) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `domain` varchar(256) NOT NULL,
  `type` enum('url','email','text','image') NOT NULL,
  `status` enum('live','dead') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `url`
--

LOCK TABLES `url` WRITE;
/*!40000 ALTER TABLE `url` DISABLE KEYS */;
INSERT INTO `url` VALUES (1,'1','http://localhost/kissabe/assets/uploads/images/e8cf94649fe4b1e80c1e4e1029e9e290','localhost','image','live'),(2,'2','http://localhost/kissabe/assets/uploads/images/e8cf94649fe4b1e80c1e4e1029e9e290.png','localhost','image','live'),(3,'3','http://localhost/kissabe/assets/uploads/texts/f7027ab9a598e527db5ccec4bf113d9e.txt','localhost','text','live'),(4,'4','http://localhost/kissabe/assets/uploads/texts/667a4af374347aaebc6d04d8572fbb85.txt','localhost','text','live'),(5,'5','http://localhost/kissabe/assets/uploads/texts/0cc175b9c0f1b6a831c399e269772661.txt','localhost','text','live'),(6,'6','http://localhost/kissabe/assets/uploads/texts/6a204bd89f3c8348afd5c77c717a097a.txt','localhost','text','live'),(7,'7','http://localhost/kissabe/assets/uploads/texts/b0d3b936209392b74942075a66b514ff.txt','localhost','text','live');
/*!40000 ALTER TABLE `url` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user` (
  `id` int(16) NOT NULL,
  `username` varchar(256) NOT NULL,
  `password` varchar(512) NOT NULL,
  `email` varchar(512) NOT NULL,
  `created_by` varchar(32) NOT NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `status` enum('pending','live','dead') NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (0,'anonymous','','hasan@ozgan.net','127.0.0.1','2009-03-15 15:25:56','live');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor`
--

DROP TABLE IF EXISTS `visitor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `visitor` (
  `id` int(16) NOT NULL auto_increment,
  `user_id` int(16) NOT NULL,
  `url_id` int(16) NOT NULL,
  `referrer` varchar(1024) NOT NULL,
  `created_by` varchar(32) NOT NULL,
  `created_on` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `status` enum('live','dead') NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `url_id` (`url_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `visitor`
--

LOCK TABLES `visitor` WRITE;
/*!40000 ALTER TABLE `visitor` DISABLE KEYS */;
INSERT INTO `visitor` VALUES (1,0,1,'','127.0.0.1','2009-04-05 14:28:12','live'),(2,0,1,'','127.0.0.1','2009-04-05 14:28:58','live'),(3,0,1,'','127.0.0.1','2009-04-16 18:48:44','live'),(4,0,4,'','127.0.0.1','2009-04-16 18:48:51','live'),(5,0,7,'','127.0.0.1','2009-04-28 19:19:58','live'),(6,0,7,'','127.0.0.1','2009-04-28 19:20:08','live'),(7,0,6,'','127.0.0.1','2009-04-28 19:20:15','live'),(8,0,5,'','127.0.0.1','2009-04-28 19:20:23','live'),(9,0,4,'','127.0.0.1','2009-04-28 19:20:36','live'),(10,0,6,'','127.0.0.1','2009-04-28 19:53:56','live');
/*!40000 ALTER TABLE `visitor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2009-04-29  4:54:47

CREATE DATABASE  IF NOT EXISTS `heroku_de4e6e6a36fcb39` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `heroku_de4e6e6a36fcb39`;
-- MySQL dump 10.13  Distrib 5.6.17, for osx10.6 (i386)
--
-- Host: us-cdbr-iron-east-04.cleardb.net    Database: heroku_de4e6e6a36fcb39
-- ------------------------------------------------------
-- Server version	5.5.46-log

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
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deliveries` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `orderID` int(255) NOT NULL,
  PRIMARY KEY (`userID`,`orderID`),
  KEY `orderID` (`orderID`),
  CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deliveries`
--

LOCK TABLES `deliveries` WRITE;
/*!40000 ALTER TABLE `deliveries` DISABLE KEYS */;
/*!40000 ALTER TABLE `deliveries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milestones`
--

DROP TABLE IF EXISTS `milestones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milestones` (
  `orderID` int(255) NOT NULL,
  `orderTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pickedupTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pickingupTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `storingTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deliveryTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deliveredTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`orderID`),
  CONSTRAINT `milestones_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milestones`
--

LOCK TABLES `milestones` WRITE;
/*!40000 ALTER TABLE `milestones` DISABLE KEYS */;
INSERT INTO `milestones` VALUES (432,'2016-10-25 17:49:58','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(442,'2016-10-26 06:57:31','2016-10-26 16:57:26','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(452,'2016-10-26 09:53:01','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(462,'2016-10-26 15:50:45','2016-10-26 10:23:28','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 01:50:45'),(472,'2016-10-27 02:13:06','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(482,'2016-10-26 17:47:48','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 03:47:48'),(492,'2016-10-27 03:06:27','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00'),(502,'2016-10-26 17:43:45','2016-10-27 03:41:20','2016-10-27 03:36:10','2016-10-27 03:42:29','2016-10-27 03:42:58','2016-10-27 03:43:38'),(512,'2016-10-26 18:45:27','2016-10-27 04:39:05','2016-10-27 04:36:24','2016-10-27 04:39:36','2016-10-27 04:45:12','2016-10-27 04:45:27'),(522,'2016-10-26 19:07:17','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:07:17'),(532,'2016-10-26 19:08:42','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:08:42'),(542,'2016-10-26 19:22:39','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:22:39'),(552,'2016-10-26 19:22:36','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:22:36'),(562,'2016-10-26 19:22:36','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:22:35'),(572,'2016-10-26 19:22:34','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:22:34'),(582,'2016-10-26 19:37:51','2016-10-27 05:29:46','2016-10-27 05:26:34','2016-10-27 05:30:21','0000-00-00 00:00:00','2016-10-27 05:37:50'),(592,'2016-10-26 19:43:33','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:43:33'),(602,'2016-10-26 19:43:42','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:43:42'),(612,'2016-10-26 19:53:11','2016-10-27 05:47:20','2016-10-27 05:46:52','2016-10-27 05:47:22','0000-00-00 00:00:00','2016-10-27 05:53:11'),(622,'2016-10-26 19:53:11','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','2016-10-27 05:53:11'),(632,'2016-10-26 19:57:28','2016-10-27 05:54:21','2016-10-27 05:54:00','2016-10-27 05:54:24','0000-00-00 00:00:00','2016-10-27 05:57:28'),(642,'2016-10-26 19:59:04','2016-10-27 05:58:48','2016-10-27 05:58:43','2016-10-27 05:58:49','0000-00-00 00:00:00','2016-10-27 05:59:04'),(652,'2016-10-26 20:03:03','2016-10-27 06:02:47','2016-10-27 06:02:42','2016-10-27 06:02:49','0000-00-00 00:00:00','2016-10-27 06:03:03'),(662,'2016-10-26 20:35:38','2016-10-27 06:35:18','2016-10-27 06:35:10','2016-10-27 06:35:20','0000-00-00 00:00:00','2016-10-27 06:35:38'),(672,'2016-10-26 23:44:00','2016-10-27 09:41:44','2016-10-27 09:39:33','2016-10-27 09:41:55','0000-00-00 00:00:00','2016-10-27 09:44:00'),(682,'2016-10-27 12:41:39','2016-10-27 22:41:24','2016-10-27 22:41:17','2016-10-27 22:41:25','0000-00-00 00:00:00','2016-10-27 22:41:39'),(692,'2016-10-27 12:44:46','2016-10-27 22:44:16','2016-10-27 22:44:05','2016-10-27 22:44:18','0000-00-00 00:00:00','2016-10-27 22:44:46');
/*!40000 ALTER TABLE `milestones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `orderID` int(255) NOT NULL AUTO_INCREMENT,
  `userID` int(255) NOT NULL,
  `orderStatus` int(255) NOT NULL,
  `description` varchar(140) DEFAULT NULL,
  `signature` tinyint(1) DEFAULT NULL,
  `deliveryPriority` varchar(255) NOT NULL,
  `pickupAddress` varchar(255) DEFAULT NULL,
  `pickupPostcode` int(4) DEFAULT NULL,
  `pickupState` char(3) DEFAULT NULL,
  `pickupTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deliveryAddress` varchar(255) NOT NULL,
  `deliveryPostcode` int(4) DEFAULT NULL,
  `deliveryState` char(3) DEFAULT NULL,
  `deliveryTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recipientName` varchar(255) DEFAULT NULL,
  `recipientPhone` varchar(16) DEFAULT NULL,
  `driverID` int(32) DEFAULT NULL,
  PRIMARY KEY (`orderID`),
  UNIQUE KEY `orderID_UNIQUE` (`orderID`),
  KEY `userID` (`userID`),
  CONSTRAINT `driverID` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=702 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (252,492,5,'Test Edit 3',0,'Standard','23 dawawd ROAD, Suburb',4000,'QLD','2016-10-26 15:42:30','242 dawawd ROAD, Suburb',4100,'QLD','2016-09-20 14:32:00','Kerman','0411111111',502),(262,492,3,'This is an order made by bill for greg.',0,'Standard','23 dawawd ROAD, Suburb',4050,'QLD','2016-10-26 15:30:34','242 dawawd ROAD, Suburb',4060,'NSW','2016-09-20 14:32:00','Kerman','0411111111',742),(272,522,2,'Another test description',0,'Standard','12 wdadaw Road, dawawd',4100,'VIC','2016-10-26 07:29:22','15 wdadaw Road, dawawd',4400,'ACT','2016-09-13 14:32:00','Bert Renolds','0411111111',NULL),(302,612,5,'eteta',0,'Standard','110 Test road, dwdaw',4000,'VIC','2016-10-26 17:02:00','12 dwwad road, waddaw',4000,'SA','2016-12-12 02:53:00','Bob','0411111111',502),(332,622,5,'One tonne of mayo',1,'Express','30 Herp Street, DerpVille',2000,'NSW','2016-10-26 11:10:26','30 Derp Street, HerpVille',4000,'QLD','2016-10-27 10:00:00','May Oh','0400000001',742),(352,522,1,'a test',0,'Express','8 Somewhere Street, Somewhere',3000,'NSW','2016-10-26 17:51:52','32 John Way, FALCON',4000,'QLD','2016-10-22 12:58:00','Bob Marley','0429129498',502),(372,522,0,'a test',0,'Express','8 Somewhere Street, Somewhere',3000,'NSW','2016-10-21 08:57:00','32 John Way, FALCON',4000,'QLD','2016-10-22 12:58:00','Bob Marley','0429129498',NULL),(382,672,1,'A test order',1,'Express','60, Somewhere Lane, Somewhere',4000,'QLD','2016-10-26 17:52:23','30 Derp Street, HerpVille',4012,'QLD','2016-10-29 12:59:00','John Doe','0429129498',502),(392,672,5,'A test order',1,'Express','60, Somewhere Lane, Somewhere',4000,'QLD','2016-10-26 16:37:01','30 Derp Street, HerpVille',4012,'QLD','2016-10-29 12:59:00','John Doe','0429129498',NULL),(402,672,0,'A second test',0,'Standard','60, Somewhere Lane, Somewhere',4000,'QLD','2016-10-24 10:56:00','8 Somewhere Street, Somewhere',3000,'NSW','2016-10-25 11:57:00','John Dor','0400000000',NULL),(412,672,0,'Third test order',0,'Express','50, Somewhere Drive, AnotherPlace',3000,'NSW','2016-10-26 11:57:00','32 John Way, Falcon',4000,'QLD','2016-10-25 17:58:00','John Hoe','0400000000',NULL),(422,672,0,'Order 1 for Testing Edit Order',1,'Express','30 Herp Street, DerpVille',3000,'QLD','2016-10-28 22:58:00','32, John Way, Falcon',4000,'QLD','2016-10-29 08:57:00','Bob Marley','0429129498',NULL),(432,672,2,'test order for milestones',1,'Standard','30, Something Street, Somewhere',4000,'QLD','2016-10-25 07:51:51','32, John Way, Falcon',3000,'VIC','2016-10-28 10:05:03','Rama Ramathan','0400000000',NULL),(442,312,2,'New test2 order for status',0,'Standard','123 wad road, daw',4000,'QLD','2016-11-22 14:38:43','123 wad road, daw',4000,'NSW','2016-11-27 12:11:43','wad','0411111111',NULL),(452,312,2,'New test2',0,'Standard','123 dawawd road, waawd',4000,'ACT','2016-10-25 23:56:13','123 wda road, awawd',4500,'QLD','2016-10-29 14:13:18','wdadaw','0411111111',NULL),(462,312,5,'Test3',0,'Standard','123 awdawd ROAD, dawawd',4000,'ACT','2016-10-26 15:50:45','123 awdawd ROAD, dawawd',4000,'SA','2016-12-29 15:21:49','Bob','0411111111',NULL),(472,542,0,'This is a selenium test order',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-12-12 08:30:00','200 Test STREET, Suburb',4100,'QLD','2016-12-13 08:30:00','Testrecp','0411111111',NULL),(482,612,5,'Test Order 42',0,'Standard','123 dawdaw ROAD, dawdaw',4000,'QLD','2016-10-26 17:47:48','321 dawdaw ROAD, dawdaw',4000,'QLD','2016-10-29 12:31:09','awddaw','0411111111',NULL),(492,542,0,'Another Test 52',0,'Standard','123 wdaadw ROAD, dawawd',4000,'QLD','2016-10-31 12:21:24','321 wdaadw ROAD, dawawd',4000,'QLD','2016-10-31 14:33:24','wdaawd','0411111111',NULL),(502,612,5,'Test order 52',0,'Standard','123 wadawd ROAD, wdadaw',4000,'QLD','2016-10-26 17:43:43','321 wdadaw ROAD, wdadw',4000,'QLD','2016-12-27 18:32:25','dawawd','0411111111',742),(512,612,5,'Selenium Order',1,'Standard','123 Test ROAD, Suburb',4000,'QLD','2016-10-26 18:45:27','321 Test STREET, Suburb',4100,'QLD','2016-12-21 09:00:00','John','0411111111',792),(522,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:07:17','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(532,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:08:42','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(542,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:22:39','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(552,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:22:36','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(562,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:22:35','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(572,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:22:34','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(582,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:37:50','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(592,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:43:33','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(602,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:43:42','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(612,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:53:11','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(622,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:53:11','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',NULL),(632,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:57:28','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(642,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 19:59:04','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(652,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 20:03:03','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(662,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 20:35:38','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(672,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-26 23:44:00','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(682,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-27 12:41:39','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792),(692,612,5,'Selenium Testing',1,'Standard','110 Test ROAD, Suburb',4000,'QLD','2016-10-27 12:44:46','123 Test STREET, Suburb',4000,'QLD','2016-12-20 09:30:00','John Doe','0411111111',792);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `packages`
--

DROP TABLE IF EXISTS `packages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `packages` (
  `packageID` int(255) NOT NULL AUTO_INCREMENT,
  `orderID` int(255) NOT NULL,
  `packageStatus` varchar(255) DEFAULT NULL,
  `packageWeight` int(4) NOT NULL,
  `pickupTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stored` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delivery` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delivered` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `packageDescription` varchar(255) NOT NULL,
  PRIMARY KEY (`packageID`),
  KEY `orderID` (`orderID`),
  CONSTRAINT `packages_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`)
) ENGINE=InnoDB AUTO_INCREMENT=882 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `packages`
--

LOCK TABLES `packages` WRITE;
/*!40000 ALTER TABLE `packages` DISABLE KEYS */;
INSERT INTO `packages` VALUES (512,352,NULL,2,'2016-10-20 06:43:12','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','test'),(532,372,NULL,2,'2016-10-20 06:52:38','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','test'),(542,392,NULL,50,'2016-10-22 13:04:43','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','A test package'),(552,402,NULL,29,'2016-10-22 13:08:17','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','test 2'),(562,412,NULL,20,'2016-10-22 13:10:22','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','First Package'),(572,412,NULL,50,'2016-10-22 13:10:23','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Second Package'),(582,422,NULL,23,'2016-10-22 14:47:53','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Package 1 for Testing Edit Order'),(592,432,NULL,20,'2016-10-25 07:49:58','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','test package'),(602,442,NULL,20,'2016-10-25 23:38:04','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Pack1'),(612,452,NULL,15,'2016-10-25 23:53:07','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','pack1'),(622,462,NULL,25,'2016-10-26 00:22:45','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Pack1'),(632,472,NULL,15,'2016-10-26 16:13:06','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(642,472,NULL,20,'2016-10-26 16:13:06','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package 2'),(652,482,NULL,12,'2016-10-26 16:58:34','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Pack1'),(662,492,NULL,12,'2016-10-26 17:06:33','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Pack1'),(672,502,NULL,14,'2016-10-26 17:19:45','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','pack1'),(682,512,NULL,10,'2016-10-26 18:01:05','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Sel Pack 1'),(692,512,NULL,12,'2016-10-26 18:01:05','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Sel Pack 2'),(702,522,NULL,12,'2016-10-26 19:04:38','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(712,532,NULL,12,'2016-10-26 19:07:45','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(722,542,NULL,12,'2016-10-26 19:11:33','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(732,552,NULL,12,'2016-10-26 19:14:29','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(742,562,NULL,12,'2016-10-26 19:16:49','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(752,572,NULL,12,'2016-10-26 19:20:36','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(762,582,NULL,12,'2016-10-26 19:23:45','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(772,592,NULL,12,'2016-10-26 19:42:44','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(782,602,NULL,12,'2016-10-26 19:42:55','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(792,612,NULL,12,'2016-10-26 19:44:07','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(802,622,NULL,12,'2016-10-26 19:51:59','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(812,632,NULL,12,'2016-10-26 19:53:40','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(822,642,NULL,12,'2016-10-26 19:58:37','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(832,652,NULL,12,'2016-10-26 20:02:36','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(842,662,NULL,12,'2016-10-26 20:35:04','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(852,672,NULL,12,'2016-10-26 23:38:38','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(862,682,NULL,12,'2016-10-27 12:41:10','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1'),(872,692,NULL,12,'2016-10-27 12:43:53','0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00','Test Sel Package1');
/*!40000 ALTER TABLE `packages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `orderID` int(255) NOT NULL,
  `userID` int(255) NOT NULL,
  `paymentType` varchar(255) NOT NULL,
  `paymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paymentAmount` double NOT NULL,
  PRIMARY KEY (`orderID`),
  KEY `orderID` (`orderID`),
  KEY `userID` (`userID`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`),
  CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (252,492,'Check','2016-10-26 15:48:03',42),(262,332,'Check','2016-10-12 13:01:00',212),(272,522,'Cash','2016-10-26 17:43:10',42.42),(302,612,'Cash','2016-10-27 00:53:28',5),(332,622,'Cash','2016-10-20 10:00:00',100.23),(412,672,'Cash','2016-10-25 12:00:00',30),(422,672,'Cash','2016-10-28 22:56:00',20.1),(432,672,'Check','2016-10-25 17:51:43',30),(442,312,'Cash','2016-10-26 09:38:52',20),(452,312,'Cash','2016-10-26 09:53:54',100),(462,312,'Cash','2016-10-26 10:22:59',25),(502,612,'Cash','2016-10-27 03:40:36',15),(512,612,'Cash','2016-10-27 04:38:40',15),(582,612,'Cash','2016-10-27 05:29:34',15),(612,612,'Cash','2016-10-27 05:47:18',15),(632,612,'Cash','2016-10-27 05:54:19',15),(642,612,'Cash','2016-10-27 05:58:47',15),(652,612,'Cash','2016-10-27 06:02:46',15),(662,612,'Cash','2016-10-27 06:35:17',15),(672,612,'Cash','2016-10-27 09:41:40',15),(682,612,'Cash','2016-10-27 22:41:23',15),(692,612,'Cash','2016-10-27 22:44:15',15);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `rowID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(255) NOT NULL,
  `role` int(11) NOT NULL,
  PRIMARY KEY (`rowID`),
  UNIQUE KEY `rowID_UNIQUE` (`rowID`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=652 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (12,312,3),(22,322,0),(82,332,3),(92,342,0),(142,352,0),(152,362,0),(202,402,4),(282,432,0),(332,442,3),(362,452,0),(372,462,0),(382,472,3),(392,482,0),(402,492,0),(412,502,1),(422,512,2),(432,522,0),(442,532,2),(452,542,0),(462,552,0),(472,562,0),(482,572,0),(492,582,0),(502,592,0),(512,602,0),(522,612,0),(532,622,0),(542,642,0),(572,672,0),(582,692,0),(592,742,1),(602,752,0),(642,792,1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(45) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phoneNumber` varchar(16) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` int(4) DEFAULT NULL,
  `state` char(3) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `userID_UNIQUE` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=802 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (312,'bill@email.com','1f1020e233f90fce5d4f4b4b5ab91f0fbc85ca67fb601b6a139dda71fac37dd8','51704705457cfde8b4e9c82.20976734','Bill','Nye','0411111111','',0,''),(322,'michael.smallcombe@connect.qut.edu.au','f77317242743decf94a6c132310a82a28c56997e670a2fb1166dbfc76fd66ab0','31065398657cfe889e57328.59155647','Michael','Smallcombe','0400000000','8 Something Lane, Somewhere',4000,'QLD'),(332,'manager@onthespot.com.au','10d28e0485fca6af2316695532749738d98919fa2c6d48f10e199551a4ccc561','197374328857d028d7c5c376.41481491','John','Smith','0400000000','28 Somewhere Street, Someplace',4000,'ACT'),(342,'driver@onthespot.com.au','22ca9aad4044d1508464ac2c201332ff965db7ecca6e496b064a0f6400e8d556','3996729757d02b9679f189.60873610','Bob','Marley','0400000000','28 Somewhere Street, Someplace',4000,'NSW'),(352,'misha@youtube.com','956552a3a79668c1a0fe894681b0e353bc8cf24c3d5259fffdda68aff9ab3e05','24820542257d03531206d29.05509250','Misha','Misha','00000000','',0,''),(362,'test42@email.com','b6dabbc22953b60497460d0d371540616840f2b308ff6542c64acf9a2257363f','188041075257d0a6e98689e0.75627665','Greg','Mills','0411111113','',0,''),(402,'test@test.com','8f675c4cd2b54acc138e262ef62bfa5a2a870e65a25f3ba6ed8e751665c4dad7','101958912157d0acfd74a2d1.52566672','chuck','norris','0411111111','',0,''),(432,'fake@email.com','7be7d5134916e04b6939103c3e4f1f523216de26b2d91285d990b69cb1653c21','118612491657d7ce22310ff6.79229679','fakey','user','0123456789','',0,''),(442,'fake2@email.com','0378811b5efdc09032f39e1f2d8ac75e890f991b55ce92072678c757cca58daa','121143111657d7d20c4f36a4.97297395','fake','userr','0123456789','',0,''),(452,'test123@email.com','d200f5f252a1c02116c5280562b628fa88f167c6b5f29acafcd5160c7dc36801','176058284457d8b256a60a74.10622471','Robert','Mills','0411111111','',0,''),(462,'test13@email.com','53892bc0f84a1f234c7b2cb7d38046366b0bed324ccb37809da608c9a73a8c3c','187361697657d8baff08ec07.20947708','Albert','Mills','0411111111','',0,''),(472,'bill2@email.com','c6e786a74886c0258ca302b8b7f47e50ceed995d7cf350e12f52a121d239289e','139475589757d8bce1267999.46346936','Bill2','Manager','0411111111','',0,''),(482,'test123@test.com','d1ebe8281e22caf7b49ccda8bcca3448f61651ef0677c3073dcc1dce9f22ff7f','182138904757d9e012d8b633.16647689','Daniel','test','0411111111','',0,''),(492,'greg@email.com','9610c8321b22d76708400e40076e6588ca2dfea60a10becd09040f897028daba','184216758157dcd6d4f329c1.19676411','Greg','Mills','0411111111','110 Test RD, Suburb',4000,'QLD'),(502,'driver1@onthespot.com.au','d5fe9540e961748c059fd49ff36a5f5b722839429cccddcac897ad21b59a1f4d','89542151857e15435171e15.65504215','Mark','Gibb','0491 570 156','94 Anderson Street, Northside',4029,'QLD'),(512,'coordinator1@onthespot.com.au','e3f2c9757842d9c09fa86b30045b0701ed9076adccd5fe51dfb3d7c2fe0ba591','70180235157e154d15b7f43.20198923','Dave','Newman','0491 570 110','15 Bayview Close, Tieri',4709,'NSW'),(522,'customer1@email.com','dbccb5753b398455d3ab1953a7a18c0cd946a96b933a14219b21dc6d5fea9425','45763008857e155869a84e6.82224590','Norman','Thompson','0491 248 129','70 Ashton Road, WOGOLIN',6370,'WA'),(532,'coordinator@email.com','7991da1e3c1397b9868872ae098b59171640501da5fd8f2a44d26e7754994522','24669819757e289707ff546.03152509','Janet','Jones','0411111111','',0,''),(542,'customer@email.com','a9b7839406c2c7763c2392b19e3aec4935079fb6125fcb54a48727c34c9da30e','198981262257e28a11de3769.66905741','Bobby','Bobstacle','0411111111','123 dawwad Road, dawawd',4100,'WA'),(552,'stranger@email.com','6f27ec60005a586e12a4d67e50c0c90544203404a713987ccf445229d7963efd','146157299857e29f58e7b8e1.01021262','Herp','Derp','0425 230 129','30 Mill Lane, Merp',3000,'ACT'),(612,'grg8spam@gmail.com','ef69c49da80ad5003e263b200d716d5174ed6d9b3cff64c6537b826abec1b93b','159842814157fd9e76915443.86336054','Greg','Mills','0411111111','',0,''),(622,'derp@herp.com','375f49899cbc0d3a99a0c8374300ab42e7a2a879f9e1319770d3050db8a918b9','130899537457fe1a8acc7af7.66861239','Derp','Herp','0400000000','94 Anderson Street, Northside',4000,'QLD'),(672,'michael.smallcombe@gmail.com','1c3997846ef67faf685bad14e5fdf0c67705e8ccc48b897ea4459656d8db03dd','2047883181580b632a243668.87647120','Michael','Small','0491 570 156','60, Something Lane, Somewhere',4000,'QLD'),(692,'newcustomer@email.com','d1f76658be3a8bf11b5b4408a4827dfdde2fd5b09027db9810c198462e22b83b','124213020258104ca7e02030.06694112','Bwdaawd','awdawddaw','0411111111','',0,''),(702,'driver2@email.com','f8808ff7d899ccd644c0462393a07272f761e89f9ad8628b31306a93fe925cbd','33535178158104eb0bd95b1.97298249','Dr','ver','0411111111','',0,''),(712,'DRIVER3@email.com','85b9b784cb89a1323be4bc8c15a5e2d6f0f70087a7a07da634c67489442fa3e8','126311843758104f0eda2936.46214225','awdwda','awddaw','0411111111','',0,''),(722,'driver4@email.com','08a7fc6cf78bf2489254a2234e3e65c252d178e32eaa33df5bb98741cb427a11','155290619458104f9f011707.23271030','Arnold','Driver','0411111111','',0,''),(732,'driver5@email.com','5a1257b713d0da21ffed9ec702a7683eaa4f14b3a4210456a7ac1493810f6abb','55240999458104fdb886e77.50202495','Nancy','Drew','0411111111','',0,''),(742,'driver6@email.com','764eccc9e7770567a59faecc03e159d91da01e0f03c95017ca8f7155e1959965','22954639758105011f23c46.32355039','Harvey','Dent','0411111111','',0,''),(752,'test@email.com','a13a21de6188b03011d1abf4b736ebdd07ee6c8ed2ba61c1ffc5786346b9f58d','3138971845810a23377d1a1.37187936','Test','Test','0411111111','8 Something Lane, Somewhere',4001,'QLD'),(792,'driver@email.com','f449dcd42b3111794e5fb985986ff58cbd5648e33b231d638b9a5b723aa82294','6995956045810ed64c9edc1.19853247','Pat','Ratt','0411111111','',0,'');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'heroku_de4e6e6a36fcb39'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-28 17:15:40

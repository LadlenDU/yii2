-- MySQL dump 10.13  Distrib 5.6.33, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: ridik
-- ------------------------------------------------------
-- Server version	5.6.33-0ubuntu0.14.04.1

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
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('admin','14',1505586697);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('admin',1,NULL,NULL,NULL,1505586684,1505586684);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `court`
--

DROP TABLE IF EXISTS `court`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `court` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL COMMENT 'адрес - если был указан одной строкой',
  `region` varchar(255) DEFAULT NULL COMMENT 'регион (область)',
  `regionId` varchar(255) DEFAULT NULL COMMENT 'код региона (области)',
  `district` varchar(255) DEFAULT NULL COMMENT 'район',
  `districtId` varchar(255) DEFAULT NULL COMMENT 'код района',
  `city` varchar(255) DEFAULT NULL COMMENT 'город (населённый пункт)',
  `cityId` varchar(255) DEFAULT NULL COMMENT 'код города (населённого пункта)',
  `street` varchar(255) DEFAULT NULL COMMENT 'улица',
  `streetId` varchar(255) DEFAULT NULL COMMENT 'код улицы',
  `building` varchar(255) DEFAULT NULL COMMENT 'дом (строение)',
  `buildingId` varchar(255) DEFAULT NULL COMMENT 'код дома (строения)',
  `phone` varchar(255) DEFAULT NULL,
  `name_of_payee` varchar(255) DEFAULT NULL COMMENT 'наименование получателя платежа',
  `BIC` varchar(255) DEFAULT NULL COMMENT 'БИК',
  `beneficiary_account_number` varchar(255) DEFAULT NULL COMMENT 'номер счета получателя платежа',
  `INN` varchar(255) DEFAULT NULL COMMENT 'ИНН',
  `KPP` varchar(255) DEFAULT NULL COMMENT 'КПП',
  `OKTMO` varchar(255) DEFAULT NULL COMMENT 'ОКТМО',
  `beneficiary_bank_name` varchar(255) DEFAULT NULL COMMENT 'наименование банка получателя платежа',
  `KBK` varchar(255) DEFAULT NULL COMMENT 'КБК',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `court`
--

LOCK TABLES `court` WRITE;
/*!40000 ALTER TABLE `court` DISABLE KEYS */;
INSERT INTO `court` VALUES (1,'Наименование','',NULL,NULL,'','','Серково д.','','-','','','','7(123)456-78-90','<Наименование получателя платежа>','<БИК>','<Номер счета получателя платежа>','<ИНН>','<КПП>','<ОКТМО>','<Наименование банка получателя платежа>','<КБК>');
/*!40000 ALTER TABLE `court` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debt_details`
--

DROP TABLE IF EXISTS `debt_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debt_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debtor_id` int(11) DEFAULT NULL,
  `amount` decimal(8,2) DEFAULT NULL,
  `amount_additional_services` decimal(8,2) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `public_service_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-debt_details-debtor_id` (`debtor_id`),
  KEY `idx-debt_details-public_service_id` (`public_service_id`),
  CONSTRAINT `fk-debt_details-debtor_id` FOREIGN KEY (`debtor_id`) REFERENCES `debtor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-debt_details-public_service_id` FOREIGN KEY (`public_service_id`) REFERENCES `public_service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debt_details`
--

LOCK TABLES `debt_details` WRITE;
/*!40000 ALTER TABLE `debt_details` DISABLE KEYS */;
INSERT INTO `debt_details` VALUES (36,41,50000.00,0.00,NULL,'2017-08-24 00:00:00',NULL),(37,42,1336.44,0.00,NULL,NULL,NULL),(38,43,1324.40,0.00,NULL,NULL,NULL),(39,44,314.10,0.00,NULL,'2017-08-11 00:00:00',NULL),(40,45,1501.99,0.00,NULL,NULL,NULL),(41,46,0.93,0.00,NULL,'2017-08-16 00:00:00',NULL),(42,47,1312.36,0.00,NULL,NULL,NULL),(43,48,1357.51,0.00,NULL,NULL,NULL);
/*!40000 ALTER TABLE `debt_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debtor`
--

DROP TABLE IF EXISTS `debtor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debtor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `name_mixed` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `regionId` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `districtId` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `cityId` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `streetId` varchar(255) DEFAULT NULL,
  `building` varchar(255) DEFAULT NULL,
  `buildingId` varchar(255) DEFAULT NULL,
  `appartment` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `LS_EIRC` varchar(255) DEFAULT NULL COMMENT 'ЛС ЕИРЦ',
  `LS_IKU_provider` varchar(255) DEFAULT NULL COMMENT 'ЛС ИКУ/поставщика',
  `IKU` varchar(255) DEFAULT NULL,
  `space_common` float DEFAULT NULL,
  `space_living` float DEFAULT NULL,
  `privatized` smallint(6) DEFAULT NULL,
  `general_manager_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-debtor-general_manager_id` (`general_manager_id`),
  CONSTRAINT `fk-debtor-general_manager_id` FOREIGN KEY (`general_manager_id`) REFERENCES `general_manager` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debtor`
--

LOCK TABLES `debtor` WRITE;
/*!40000 ALTER TABLE `debtor` DISABLE KEYS */;
INSERT INTO `debtor` VALUES (41,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88759595','2000005793','',NULL,NULL,1,NULL),(42,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734826','2000005796','',NULL,NULL,1,NULL),(43,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734827','2000005797','',NULL,NULL,1,NULL),(44,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734828','2000005798','',NULL,NULL,1,NULL),(45,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734831','2000005801','',NULL,NULL,1,NULL),(46,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734834','2000005804','',NULL,NULL,1,NULL),(47,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734837','2000005807','',NULL,NULL,1,NULL),(48,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Серково д.',NULL,'-',NULL,'',NULL,'','','88734840','2000005810','',NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `debtor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `debtor_public_service`
--

DROP TABLE IF EXISTS `debtor_public_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `debtor_public_service` (
  `debtor_id` int(11) NOT NULL DEFAULT '0',
  `public_service_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`debtor_id`,`public_service_id`),
  KEY `idx-debtor_public_service-debtor_id` (`debtor_id`),
  KEY `idx-debtor_public_service-public_service_id` (`public_service_id`),
  CONSTRAINT `fk-debtor_public_service-debtor_id` FOREIGN KEY (`debtor_id`) REFERENCES `debtor` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-debtor_public_service-public_service_id` FOREIGN KEY (`public_service_id`) REFERENCES `public_service` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `debtor_public_service`
--

LOCK TABLES `debtor_public_service` WRITE;
/*!40000 ALTER TABLE `debtor_public_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `debtor_public_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dynagrid`
--

DROP TABLE IF EXISTS `dynagrid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dynagrid` (
  `id` varchar(100) NOT NULL,
  `filter_id` varchar(100) DEFAULT NULL,
  `sort_id` varchar(100) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `dynagrid_FK1` (`filter_id`),
  KEY `dynagrid_FK2` (`sort_id`),
  CONSTRAINT `dynagrid_FK1` FOREIGN KEY (`filter_id`) REFERENCES `dynagrid_dtl` (`id`),
  CONSTRAINT `dynagrid_FK2` FOREIGN KEY (`sort_id`) REFERENCES `dynagrid_dtl` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dynagrid`
--

LOCK TABLES `dynagrid` WRITE;
/*!40000 ALTER TABLE `dynagrid` DISABLE KEYS */;
/*!40000 ALTER TABLE `dynagrid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dynagrid_dtl`
--

DROP TABLE IF EXISTS `dynagrid_dtl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dynagrid_dtl` (
  `id` varchar(100) NOT NULL,
  `category` varchar(10) NOT NULL,
  `name` varchar(150) NOT NULL,
  `data` text,
  `dynagrid_id` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dynagrid_dtl`
--

LOCK TABLES `dynagrid_dtl` WRITE;
/*!40000 ALTER TABLE `dynagrid_dtl` DISABLE KEYS */;
/*!40000 ALTER TABLE `dynagrid_dtl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_manager`
--

DROP TABLE IF EXISTS `general_manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `second_name` varchar(255) DEFAULT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_manager`
--

LOCK TABLES `general_manager` WRITE;
/*!40000 ALTER TABLE `general_manager` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `individual`
--

DROP TABLE IF EXISTS `individual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `individual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_info_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL COMMENT 'ФИО',
  `INN` varchar(40) DEFAULT NULL COMMENT 'ИНН',
  `checking_account_num` varchar(40) DEFAULT NULL COMMENT '№ расчетного счета',
  PRIMARY KEY (`id`),
  KEY `idx-individual-user_info_id` (`user_info_id`),
  CONSTRAINT `fk-individual-user_info_id` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `individual`
--

LOCK TABLES `individual` WRITE;
/*!40000 ALTER TABLE `individual` DISABLE KEYS */;
/*!40000 ALTER TABLE `individual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `individual_entrepreneur`
--

DROP TABLE IF EXISTS `individual_entrepreneur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `individual_entrepreneur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_info_id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL COMMENT 'ФИО',
  `OGRN` varchar(40) DEFAULT NULL COMMENT 'ОГРН',
  `INN` varchar(40) DEFAULT NULL COMMENT 'ИНН',
  `BIC` varchar(40) DEFAULT NULL COMMENT 'БИК',
  `checking_account_num` varchar(40) DEFAULT NULL COMMENT '№ расчетного счета',
  PRIMARY KEY (`id`),
  KEY `idx-individual_entrepreneur-user_info_id` (`user_info_id`),
  CONSTRAINT `fk-individual_entrepreneur-user_info_id` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `individual_entrepreneur`
--

LOCK TABLES `individual_entrepreneur` WRITE;
/*!40000 ALTER TABLE `individual_entrepreneur` DISABLE KEYS */;
INSERT INTO `individual_entrepreneur` VALUES (1,1,'Долгов Дмитрий Станиславович mod','2469293479','12345567799','28493379','009434232443');
/*!40000 ALTER TABLE `individual_entrepreneur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `legal_entity`
--

DROP TABLE IF EXISTS `legal_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `legal_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_info_id` int(11) NOT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `INN` varchar(40) DEFAULT NULL COMMENT 'ИНН',
  `KPP` varchar(40) DEFAULT NULL COMMENT 'КПП',
  `OGRN` varchar(40) DEFAULT NULL COMMENT 'ОГРН',
  `BIC` varchar(40) DEFAULT NULL COMMENT 'БИК',
  `checking_account_num` varchar(40) DEFAULT NULL COMMENT '№ расчетного счета',
  `CEO_name` varchar(255) DEFAULT NULL COMMENT 'ФИО Генерального директора',
  PRIMARY KEY (`id`),
  KEY `idx-legal_entity-user_info_id` (`user_info_id`),
  CONSTRAINT `fk-legal_entity-user_info_id` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `legal_entity`
--

LOCK TABLES `legal_entity` WRITE;
/*!40000 ALTER TABLE `legal_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `legal_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1504552479),('m130524_201442_init',1504552483),('m140101_100000_dynagrid',1505765619),('m140209_132017_init',1505291419),('m140403_174025_create_account_table',1505291420),('m140504_113157_update_tables',1505291422),('m140504_130429_create_token_table',1505291423),('m140506_102106_rbac_init',1504944491),('m140830_171933_fix_ip_field',1505291424),('m140830_172703_change_account_table_name',1505291425),('m141222_110026_update_ip_field',1505291425),('m141222_135246_alter_username_length',1505291426),('m150429_155009_create_page_table',1504659733),('m150614_103145_update_social_account_table',1505291427),('m150623_212711_fix_username_notnull',1505291427),('m151218_234654_add_timezone_to_profile',1505291428),('m160929_103127_add_last_login_at_to_user_table',1505291428),('m170912_083845_create_junction_table_for_page_and_tree_tables',1505205588),('m170915_003300_create_registration_type_table',1505454167),('m170915_003305_create_user_info_table',1505454252),('m170915_005746_create_legal_entity_table',1505454253),('m170915_013513_create_individual_entrepreneur_table',1505454253),('m170915_053239_create_individual_table',1505454254),('m170916_172241_create_tariff_plan',1505602153),('m170916_173427_create_tariff_plan_table',1505606171),('m170916_173428_add_balance_column_to_user_info_table',1505606351),('m170916_224734_add_general_manager_table',1505606351),('m170916_224809_add_debtor_table',1505606351),('m170916_224825_add_public_service_table',1505606351),('m170916_224843_add_debt_details_table',1505606352),('m170917_000629_create_general_manager_table',1505606889),('m170917_000644_create_debtor_table',1505607099),('m170917_000655_create_public_service_table',1505607099),('m170917_000706_create_debt_details_table',1505607301),('m170917_000722_create_junction_table_for_debtor_and_public_service_tables',1505607302),('m170918_114233_add_balance_column_to_debtor_table',1505734983),('m170918_121909_add_phone_column_to_debtor_table',1505737290),('m170918_122857_add_name_mixed_column_to_debtor_table',1505737745),('m170918_125158_add_amount_additional_services_column_to_debt_details_table',1505739124),('m170918_143446_add_IKU_column_to_debtor_table',1505745299),('m170919_135725_change_column_timestamp_of_table_debt_details',1505829502),('m170919_182456_create_court_table',1505845985),('m170919_194556_add_region_column_to_court_table',1505850385),('m170920_201139_rename_house_column_in_debtor_table',1505938649),('m170920_220138_rename_locality_column_in_debtor_table',1505944999),('m170920_222808_rename_locality_column_in_debtor_table',1505946566),('m170921_114817_add_missedregion_columns_to_debtor_table',1505994707),('m230416_200116_tree',1504986354);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page`
--

DROP TABLE IF EXISTS `page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `published` tinyint(1) DEFAULT '1',
  `content` text,
  `title_browser` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(200) DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `alias_and_published` (`alias`,`published`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page`
--

LOCK TABLES `page` WRITE;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` VALUES (1,'тестовая страница','testovaa-stranica',1,'<p>Это содержание тестовой страницы.<br></p><hr><ol><li>Ещё текст</li><li>Ещё текст 1<br></li><li>Ещё текст<span class=\"redactor-invisible-space\"></span> 2</li></ol><p><br></p><p><br></p><p><img src=\"/images/59b35b407141c.png\" style=\"width: 180px; height: 190px;\" width=\"180\" height=\"190\"><img src=\"/images/59b35aa573ade.jpg\" style=\"width: 164px; height: 128px;\" width=\"164\" height=\"128\"></p><p><br></p>','Это заголовок браузера','кейворд1, кейворд2','some META description','2017-09-07 18:10:36','2017-09-09 03:14:06'),(2,'тестовая страница 2','testovaa-stranica-2',1,'<p \"=\"\">это содержание тестовой страницы 2</p><p \"=\"\">это содержание тестовой страницы 2<br></p>','','','','2017-09-11 07:36:33','2017-09-11 07:36:33');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_tree`
--

DROP TABLE IF EXISTS `page_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `page_tree` (
  `page_id` int(11) NOT NULL DEFAULT '0',
  `tree_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`,`tree_id`),
  KEY `idx-page_tree-page_id` (`page_id`),
  KEY `idx-page_tree-tree_id` (`tree_id`),
  CONSTRAINT `fk-page_tree-page_id` FOREIGN KEY (`page_id`) REFERENCES `page` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-page_tree-tree_id` FOREIGN KEY (`tree_id`) REFERENCES `tree` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_tree`
--

LOCK TABLES `page_tree` WRITE;
/*!40000 ALTER TABLE `page_tree` DISABLE KEYS */;
INSERT INTO `page_tree` VALUES (1,3),(1,34),(2,1),(2,40);
/*!40000 ALTER TABLE `page_tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8_unicode_ci,
  `timezone` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `fk_user_profile` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_service`
--

DROP TABLE IF EXISTS `public_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_service`
--

LOCK TABLES `public_service` WRITE;
/*!40000 ALTER TABLE `public_service` DISABLE KEYS */;
/*!40000 ALTER TABLE `public_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration_type`
--

DROP TABLE IF EXISTS `registration_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `short_name` varchar(10) DEFAULT NULL,
  `table_name` varchar(40) DEFAULT NULL COMMENT 'Таблица в БД с информацией.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration_type`
--

LOCK TABLES `registration_type` WRITE;
/*!40000 ALTER TABLE `registration_type` DISABLE KEYS */;
INSERT INTO `registration_type` VALUES (1,'юридическое лицо','ЮЛ','legal_entity'),(2,'индивидуальный предприниматель','ИП','individual_entrepreneur'),(3,'физическое лицо','ФЛ','individual');
/*!40000 ALTER TABLE `registration_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `social_account`
--

DROP TABLE IF EXISTS `social_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `code` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  UNIQUE KEY `account_unique_code` (`code`),
  KEY `fk_user_account` (`user_id`),
  CONSTRAINT `fk_user_account` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `social_account`
--

LOCK TABLES `social_account` WRITE;
/*!40000 ALTER TABLE `social_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `social_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tariff_plan`
--

DROP TABLE IF EXISTS `tariff_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tariff_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tariff_plan`
--

LOCK TABLES `tariff_plan` WRITE;
/*!40000 ALTER TABLE `tariff_plan` DISABLE KEYS */;
/*!40000 ALTER TABLE `tariff_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`),
  CONSTRAINT `fk_user_token` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tree`
--

DROP TABLE IF EXISTS `tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tree` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `root` int(11) DEFAULT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `lvl` smallint(5) NOT NULL,
  `name` varchar(60) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `icon_type` smallint(1) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `selected` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  `collapsed` tinyint(1) NOT NULL DEFAULT '0',
  `movable_u` tinyint(1) NOT NULL DEFAULT '1',
  `movable_d` tinyint(1) NOT NULL DEFAULT '1',
  `movable_l` tinyint(1) NOT NULL DEFAULT '1',
  `movable_r` tinyint(1) NOT NULL DEFAULT '1',
  `removable` tinyint(1) NOT NULL DEFAULT '1',
  `removable_all` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tree_NK1` (`root`),
  KEY `tree_NK2` (`lft`),
  KEY `tree_NK3` (`rgt`),
  KEY `tree_NK4` (`lvl`),
  KEY `tree_NK5` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tree`
--

LOCK TABLES `tree` WRITE;
/*!40000 ALTER TABLE `tree` DISABLE KEYS */;
INSERT INTO `tree` VALUES (1,1,1,6,0,'тестовое название 2 mod 3','',1,1,0,0,0,1,0,1,1,1,1,1,0),(2,1,2,3,1,'ttt','',1,1,0,0,1,1,0,1,1,1,1,1,1),(3,1,4,5,1,'Page 2','',1,1,0,0,0,1,0,1,1,1,1,1,0),(4,4,1,2,0,'название 2','',1,0,0,0,0,1,0,1,1,1,1,1,0),(13,13,1,2,0,'назв8','',1,0,0,0,0,1,0,1,1,1,1,1,0),(14,14,1,2,0,'назв9','',1,0,0,0,0,1,0,1,1,1,1,1,0),(15,15,1,2,0,'назв10','',1,0,0,0,0,1,0,1,1,1,1,1,0),(17,17,1,2,0,'pga1','',1,0,0,0,0,1,0,1,1,1,1,1,0),(22,22,1,2,0,'pg2','',1,0,0,0,0,1,0,1,1,1,1,1,0),(29,29,1,2,0,'pg3','',1,0,0,0,0,1,0,1,1,1,1,1,0),(30,30,1,2,0,'pg4','',1,0,0,0,0,1,0,1,1,1,1,1,0),(32,32,1,2,0,'pg5','',1,0,0,0,0,1,0,1,1,1,1,1,0),(33,33,1,2,0,'pg6','',1,0,0,0,0,1,0,1,1,1,1,1,0),(34,34,1,2,0,'pga2','',1,1,0,0,0,1,0,1,1,1,1,1,0),(40,40,1,2,0,'pga3','',1,1,0,0,0,1,0,1,1,1,1,1,0),(44,44,1,2,0,'pga4','',1,1,0,0,0,1,0,1,1,1,1,1,0);
/*!40000 ALTER TABLE `tree` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `flags` int(11) NOT NULL DEFAULT '0',
  `last_login_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_unique_username` (`username`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (14,'Ladlen','TwilightTower@mail.ru','$2y$10$zWYpRPQ61n6X6hM.AtvBCO92AFokKE3IdRcdzxTBLYUjSn9Bav8we','OKg23fsJbdlUb8K07gBo6O2U8x9sAjvj',1505480948,NULL,NULL,'192.168.68.1',1505480898,1505480898,0,1505978334),(15,'LadlenImap','TwilightTowerImap@gmail.com','$2y$10$l9fdWHBgDM46f.EYywkCV.BrGXAVGIzGvTtFO7jq4xgsS4vjCJnEW','PVG6nWiAvoiof54wO66CUemh1YzbBTRJ',1505575627,NULL,NULL,'192.168.68.1',1505575601,1505575601,0,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `complete` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Завершен ли процесс заполнения информации',
  `registration_type_id` int(11) DEFAULT NULL COMMENT 'Вариант регистрации',
  `balance` decimal(8,2) DEFAULT '0.00',
  `tariff_plan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx-user_info-user_id` (`user_id`),
  KEY `idx-user_info-registration_type_id` (`registration_type_id`),
  KEY `idx-user_info-tariff_plan_id` (`tariff_plan_id`),
  CONSTRAINT `fk-user_info-registration_type_id` FOREIGN KEY (`registration_type_id`) REFERENCES `registration_type` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-user_info-tariff_plan_id` FOREIGN KEY (`tariff_plan_id`) REFERENCES `tariff_plan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk-user_info-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (1,14,1,2,0.00,NULL),(2,15,1,1,0.00,NULL);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_orig`
--

DROP TABLE IF EXISTS `user_orig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_orig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_orig`
--

LOCK TABLES `user_orig` WRITE;
/*!40000 ALTER TABLE `user_orig` DISABLE KEYS */;
INSERT INTO `user_orig` VALUES (1,'Ladlen','b7ea7RvqVn4-3-Yk-D_WQYlsSEJStC-u','$2y$13$lCyaI7eIKTOIsMPigT8XreOBIpbmSvtfjvC294L5trbYYh1MuG7lG',NULL,'TwilightTower@mail.ru',10,1504553567,1504553567);
/*!40000 ALTER TABLE `user_orig` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-21 18:01:39

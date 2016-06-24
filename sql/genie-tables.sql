-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: eugenie_staging
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_idx` (`parent_id`),
  CONSTRAINT `c_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_online_resources`
--

DROP TABLE IF EXISTS `categories_online_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_online_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned DEFAULT NULL,
  `online_resource_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_resource_id_idx` (`online_resource_id`),
  KEY `category_id_idx` (`category_id`),
  CONSTRAINT `online_resource_id` FOREIGN KEY (`online_resource_id`) REFERENCES `online_resources` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_responses_statements`
--

DROP TABLE IF EXISTS `categories_responses_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_responses_statements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `responses_statement_id` int(10) unsigned NOT NULL,
  `weighting` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `top_interest` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_responses_categories_categories1_idx` (`category_id`),
  KEY `fk_categories_responses_statements_responses_statements1_idx` (`responses_statement_id`),
  CONSTRAINT `fk_categories_responses_statements_responses_statements1` FOREIGN KEY (`responses_statement_id`) REFERENCES `responses_statements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_responses_categories_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1329 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_services`
--

DROP TABLE IF EXISTS `categories_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_idx` (`category_id`),
  KEY `service_idx` (`service_id`),
  CONSTRAINT `cs_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cs_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1468 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `categories_statements`
--

DROP TABLE IF EXISTS `categories_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_statements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `statement_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_idx` (`category_id`),
  KEY `statement_idx` (`statement_id`),
  CONSTRAINT `cst_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cst_statement` FOREIGN KEY (`statement_id`) REFERENCES `statements` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conditions`
--

DROP TABLE IF EXISTS `conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conditions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_conditions_categories1_idx` (`category_id`),
  CONSTRAINT `fk_conditions_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `conditions_responses`
--

DROP TABLE IF EXISTS `conditions_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conditions_responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `condition_id` int(10) unsigned NOT NULL,
  `response_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cr_condition_idx` (`condition_id`),
  KEY `cr_response_idx` (`response_id`),
  CONSTRAINT `cr_condition` FOREIGN KEY (`condition_id`) REFERENCES `conditions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `cr_response` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=370 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `question` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `favourites`
--

DROP TABLE IF EXISTS `favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favourites` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_idx` (`user_id`),
  KEY `service_idx` (`service_id`),
  CONSTRAINT `f_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `f_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `i18n`
--

DROP TABLE IF EXISTS `i18n`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM AUTO_INCREMENT=965 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `network_categories`
--

DROP TABLE IF EXISTS `network_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `network_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_network_categories_network_categories1_idx` (`parent_id`),
  CONSTRAINT `fk_network_categories_network_categories1` FOREIGN KEY (`parent_id`) REFERENCES `network_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `network_members`
--

DROP TABLE IF EXISTS `network_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `network_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `frequency` enum('daily','weekly','monthly','less') NOT NULL DEFAULT 'less',
  `diagram_x` smallint(5) unsigned DEFAULT '0',
  `diagram_y` smallint(5) unsigned DEFAULT '0',
  `other` varchar(200) DEFAULT NULL,
  `Interests` text,
  `Statement1` varchar(255) DEFAULT NULL,
  `Statement2` varchar(255) DEFAULT NULL,
  `Statement3` varchar(255) DEFAULT NULL,
  `Statement4` varchar(255) DEFAULT NULL,
  `Statement5` varchar(255) DEFAULT NULL,
  `Statement6` varchar(255) DEFAULT NULL,
  `Statement7` varchar(255) DEFAULT NULL,
  `Statement8` varchar(255) DEFAULT NULL,
  `Statement9` varchar(255) DEFAULT NULL,
  `Statement10` varchar(255) DEFAULT NULL,
  `Statement11` varchar(255) DEFAULT NULL,
  `Statement12` varchar(255) DEFAULT NULL,
  `Statement13` varchar(255) DEFAULT NULL,
  `network_category_id` int(10) unsigned NOT NULL,
  `response_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_contacts_contact_categories1_idx` (`network_category_id`),
  KEY `fk_contacts_responses1_idx` (`response_id`),
  CONSTRAINT `fk_nwm_contact_categories1` FOREIGN KEY (`network_category_id`) REFERENCES `network_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_nwm_responses1` FOREIGN KEY (`response_id`) REFERENCES `responses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=1041 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `network_types`
--

DROP TABLE IF EXISTS `network_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `network_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `ruleset` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_ruleset` (`ruleset`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `online_resources`
--

DROP TABLE IF EXISTS `online_resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` text,
  `age_lower` tinyint(3) DEFAULT '1',
  `age_upper` tinyint(3) DEFAULT '99',
  `gender_m` tinyint(1) DEFAULT '1',
  `gender_f` tinyint(1) DEFAULT '1',
  `category` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `disable_editing` tinyint(1) DEFAULT '0',
  `slug` varchar(300) DEFAULT NULL,
  `image_path` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `content` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `title` char(5) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `age` char(5) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `marital_status` char(1) DEFAULT NULL,
  `postcode` char(9) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `telephone` char(15) DEFAULT NULL,
  `network_type` enum('diverse','family_friend_centered','friend_centered','family_centered','family_friend_supported','friend_supported','family_supported','isolated','highly_isolated') DEFAULT NULL,
  `network_type_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_idx` (`user_id`),
  KEY `fk_responses_network_types1_idx` (`network_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=322 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `responses_statements`
--

DROP TABLE IF EXISTS `responses_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responses_statements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `response_id` int(10) unsigned NOT NULL,
  `statement_id` int(10) unsigned NOT NULL,
  `weighting` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `no_mixtures` (`response_id`,`statement_id`),
  KEY `statement_id_idx` (`statement_id`),
  KEY `response_idx` (`response_id`),
  KEY `order` (`weighting`,`response_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3063 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `contact_name` varchar(200) DEFAULT NULL,
  `address_1` varchar(200) DEFAULT NULL,
  `address_2` varchar(200) DEFAULT NULL,
  `address_3` varchar(200) DEFAULT NULL,
  `town` varchar(200) DEFAULT NULL,
  `postcode` char(9) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` text,
  `time_details` varchar(200) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  `facebook_url` varchar(200) DEFAULT NULL,
  `age_lower` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `age_upper` tinyint(3) unsigned NOT NULL DEFAULT '150',
  `gender_m` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gender_f` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lang` char(3) NOT NULL DEFAULT 'eng',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `disable_editing` tinyint(1) DEFAULT '0' COMMENT 'Disallow Champions from editing this service.',
  `slug` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=787 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services_edits`
--

DROP TABLE IF EXISTS `services_edits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_edits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_id_before_save` int(11) DEFAULT NULL,
  `version_id_after_save` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `action` enum('create','update','delete','') DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services_revs`
--

DROP TABLE IF EXISTS `services_revs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services_revs` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(10) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact_name` varchar(200) DEFAULT NULL,
  `address_1` varchar(200) DEFAULT NULL,
  `address_2` varchar(200) DEFAULT NULL,
  `address_3` varchar(200) DEFAULT NULL,
  `town` varchar(200) DEFAULT NULL,
  `postcode` char(9) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `description` text,
  `time_details` varchar(200) DEFAULT NULL,
  `twitter` varchar(45) DEFAULT NULL,
  `facebook_url` varchar(200) DEFAULT NULL,
  `age_lower` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `age_upper` tinyint(3) unsigned NOT NULL DEFAULT '150',
  `gender_m` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `gender_f` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `lang` char(3) NOT NULL DEFAULT 'eng',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  `disable_editing` tinyint(1) DEFAULT '0' COMMENT 'Disallow Champions from editing this service.',
  `slug` varchar(300) DEFAULT NULL,
  `Category` text,
  `Video` text,
  `version_created` datetime NOT NULL,
  PRIMARY KEY (`version_id`),
  UNIQUE KEY `version_id` (`version_id`)
) ENGINE=InnoDB AUTO_INCREMENT=773 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statements`
--

DROP TABLE IF EXISTS `statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `statement` varchar(200) NOT NULL,
  `description` text,
  `order` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ordering` (`order`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `top_interests`
--

DROP TABLE IF EXISTS `top_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `top_interests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `response_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` char(40) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `forgot_password_key` char(20) DEFAULT NULL,
  `role` char(1) DEFAULT NULL,
  `facilitator_id` int(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `url` varchar(200) NOT NULL,
  `embed_code` text NOT NULL,
  `thumb_url` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_videos_services1_idx` (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-24 12:34:53

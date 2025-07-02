-- MySQL dump 10.16  Distrib 10.2.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cnics-mci_prod
-- ------------------------------------------------------
-- Server version	10.2.18-MariaDB-10.2.18+maria~jessie

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
-- Table structure for table `test_event_derived_datas`
--

DROP TABLE IF EXISTS `test_event_derived_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_event_derived_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL COMMENT 'foreign key into events table',
  `outcome` enum('Definite','Probable','No','No [resuscitated cardiac arrest]') DEFAULT NULL,
  `primary_secondary` enum('Primary','Secondary') DEFAULT NULL,
  `false_positive_event` tinyint(1) DEFAULT NULL,
  `secondary_cause` enum('MVA','Overdose','Anaphlaxis','GI bleed','Sepsis/bacteremia','Procedure related','Arrhythmia','Cocaine or other illicit drug induced vasospasm','Hypertensive urgency/emergency','Hypoxia','Hypotension','Other','NC') DEFAULT NULL,
  `secondary_cause_other` varchar(100) DEFAULT NULL,
  `false_positive_reason` enum('Congestive heart failure','Myocarditis','Pericarditis','Pulmonary embolism','Renal failure','Severe sepsis/shock','Other') DEFAULT NULL,
  `ci` tinyint(1) DEFAULT NULL,
  `ci_type` enum('CABG/Surgery','PCI/Angioplasty','Stent','Unknown','NC') DEFAULT NULL,
  `ecg_type` enum('STEMI','non-STEMI','Other/Uninterpretable','New LBBB','Normal','No EKG','NC') DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `event_id` (`event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3063 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;


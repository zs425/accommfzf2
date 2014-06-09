/*
SQLyog Ultimate v8.55 
MySQL - 5.5.27 : Database - acewebde_centraldb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `bao_records` */

DROP TABLE IF EXISTS `bao_records`;

CREATE TABLE `bao_records` (
  `baorecord_id` int(11) NOT NULL AUTO_INCREMENT,
  `baorecord_name` varchar(255) DEFAULT NULL,
  `baorecord_shortdesc` text,
  `baorecord_description` text,
  `baorecord_category` varchar(45) DEFAULT NULL,
  `baorecord_source` varchar(45) DEFAULT NULL,
  `baorecord_source_id` varchar(255) DEFAULT NULL,
  `baorecord_country` varchar(45) DEFAULT NULL,
  `baorecord_state` varchar(3) DEFAULT NULL,
  `baorecord_region` varchar(255) DEFAULT NULL,
  `baorecord_region_id` int(11) DEFAULT NULL,
  `baorecord_area` varchar(150) DEFAULT NULL,
  `baorecord_area_id` int(11) DEFAULT NULL,
  `baorecord_city` varchar(255) DEFAULT NULL,
  `baorecord_city_id` int(11) DEFAULT NULL,
  `baorecord_address` tinytext,
  `baorecord_postcode` varchar(10) DEFAULT NULL,
  `baorecord_phone` varchar(90) DEFAULT NULL,
  `baorecord_email` varchar(255) DEFAULT NULL,
  `baorecord_website` varchar(255) DEFAULT NULL,
  `baorecord_lat` varchar(45) DEFAULT NULL,
  `baorecord_lon` varchar(45) DEFAULT NULL,
  `baorecord_photo` varchar(255) DEFAULT NULL,
  `baorecord_star_rating` decimal(2,1) DEFAULT '0.0',
  `baorecord_lowrate` decimal(7,2) DEFAULT '0.00',
  `baorecord_highrate` decimal(7,2) DEFAULT NULL,
  `baorecord_rate_basis` varchar(45) DEFAULT NULL,
  `baorecord_checkin` varchar(255) DEFAULT NULL,
  `baorecord_checkout` varchar(45) DEFAULT NULL,
  `baorecord_frequency` varchar(180) DEFAULT NULL,
  `baorecord_start` varchar(10) DEFAULT NULL,
  `baorecord_end` varchar(10) DEFAULT NULL,
  `baorecord_created` int(10) unsigned DEFAULT '0',
  `baorecord_modified` int(10) unsigned DEFAULT '0',
  `baorecord_deleted` tinyint(3) unsigned DEFAULT '0',
  `baorecord_has_duplicate` varchar(10) DEFAULT NULL,
  `baorecord_duplicate_of` int(11) DEFAULT NULL,
  `baorecord_is_default` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`baorecord_id`),
  KEY `state_region` (`baorecord_state`,`baorecord_region`),
  KEY `source` (`baorecord_source`),
  KEY `modified` (`baorecord_modified`),
  KEY `source_dest_id` (`baorecord_source`)
) ENGINE=InnoDB AUTO_INCREMENT=52302 DEFAULT CHARSET=utf8;

/*Table structure for table `hotel_rooms` */

DROP TABLE IF EXISTS `hotel_rooms`;

CREATE TABLE `hotel_rooms` (
  `hotelroom_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hotelroom_name` varchar(255) DEFAULT NULL,
  `hotelroom_shortdesc` text,
  `hotelroom_description` text,
  `hotelroom_lowrate` decimal(5,2) DEFAULT '0.00',
  `hotelroom_highrate` decimal(5,2) unsigned DEFAULT '0.00',
  `hotelroom_rate_basis` varchar(45) DEFAULT NULL,
  `hotelroom_extraperson` decimal(5,2) unsigned DEFAULT '0.00',
  `hotelroom_guestmax` tinyint(3) unsigned DEFAULT '0',
  `hotelroom_source` varchar(45) DEFAULT NULL,
  `hotelroom_source_id` varchar(45) DEFAULT NULL,
  `hotelroom_record_id` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`hotelroom_id`),
  KEY `record_id` (`hotelroom_record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58765 DEFAULT CHARSET=utf8;

/*Table structure for table `records_attributes` */

DROP TABLE IF EXISTS `records_attributes`;

CREATE TABLE `records_attributes` (
  `baorecordattr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baorecordattr_type` varchar(45) DEFAULT NULL,
  `baorecordattr_code` varchar(45) DEFAULT NULL,
  `baorecordattr_name` varchar(255) DEFAULT NULL,
  `baorecordattr_record_type` varchar(45) DEFAULT NULL,
  `baorecordattr_record_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`baorecordattr_id`),
  KEY `record_id` (`baorecordattr_record_id`),
  KEY `types` (`baorecordattr_record_type`,`baorecordattr_code`,`baorecordattr_type`)
) ENGINE=InnoDB AUTO_INCREMENT=1716138 DEFAULT CHARSET=utf8;

/*Table structure for table `records_info` */

DROP TABLE IF EXISTS `records_info`;

CREATE TABLE `records_info` (
  `recordinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recordinfo_code` varchar(45) DEFAULT NULL,
  `recordinfo_title` varchar(255) DEFAULT NULL,
  `recordinfo_body` text,
  `recordinfo_record_id` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`recordinfo_id`),
  KEY `record_id` (`recordinfo_record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=46506 DEFAULT CHARSET=utf8 COMMENT='contains additional info such as hotel policy, guaranteePoli';

/*Table structure for table `records_multimedia` */

DROP TABLE IF EXISTS `records_multimedia`;

CREATE TABLE `records_multimedia` (
  `recordmultimedia_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `recordmultimedia_type` varchar(45) DEFAULT NULL,
  `recordmultimedia_path` varchar(255) DEFAULT NULL,
  `recordmultimedia_description` tinytext,
  `recordmultimedia_width` int(10) unsigned DEFAULT NULL,
  `recordmultimedia_height` int(10) unsigned DEFAULT NULL,
  `recordmultimedia_source` varchar(45) DEFAULT NULL,
  `recordmultimedia_record_type` varchar(45) DEFAULT NULL,
  `recordmultimedia_record_id` int(10) unsigned DEFAULT NULL,
  `recordmultimedia_s3bucket` varchar(45) DEFAULT NULL,
  `recordmultimedia_exists` tinyint(3) DEFAULT NULL,
  PRIMARY KEY (`recordmultimedia_id`),
  KEY `record_id` (`recordmultimedia_record_id`),
  KEY `path_record` (`recordmultimedia_path`,`recordmultimedia_record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=238680 DEFAULT CHARSET=utf8 COMMENT='contains photos, video etc.';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

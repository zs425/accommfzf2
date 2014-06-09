DROP TABLE IF EXISTS `destinations`;
CREATE TABLE `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `abbr` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `tier` int(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `children` varchar(2000) CHARACTER SET latin1 DEFAULT NULL,
  `lat` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `lon` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `geonames_id` int(11) DEFAULT NULL,
  `geonames_parent` int(11) DEFAULT NULL,
  `roamfree_id` int(11) DEFAULT NULL,
  `roamfree_parent` int(11) DEFAULT NULL,
  `v3_id` int(11) DEFAULT NULL,
  `expedia_id` int(11) DEFAULT NULL,
  `laterooms_id` int(11) DEFAULT NULL,
  `viator_id` int(11) DEFAULT NULL,
  `woe_id` int(11) DEFAULT NULL,
  `wiki_id` int(11) DEFAULT NULL,
  `osm_id` int(11) DEFAULT NULL,
  `iata_code` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `iso` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `locode` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `atdw_code` int(11) DEFAULT NULL,
  `alternateNames` varchar(3000) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminName1` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminName2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminName3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminName4` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminName5` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_bbox` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_fcode` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_population` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_fclName` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_srtm3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `wikipedia_url` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `bbox` varchar(255) DEFAULT NULL,
  `postCode` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_fcl` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `geonames_adminId1` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminId2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminId3` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminId4` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `geonames_adminId5` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `original_source` varchar(50) NOT NULL DEFAULT 'geonames',
  `placeTypeName` varchar(80) DEFAULT NULL,
  `placeTypeCode` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13717 DEFAULT CHARSET=utf8;

ALTER TABLE `destinations` MODIFY COLUMN `expedia_id` varchar(255);
ALTER TABLE `destinations` ADD COLUMN `state_name` varchar(255) AFTER `roamfree_parent`;
ALTER TABLE `destinations` ADD COLUMN `state_source` varchar(255) AFTER `state_name`;
ALTER TABLE `destinations` ADD COLUMN `region_name` varchar(255) AFTER `state_source`;
ALTER TABLE `destinations` ADD COLUMN `region_source` varchar(255) AFTER `region_name`;
ALTER TABLE `destinations` ADD COLUMN `area_name` varchar(255) AFTER `region_source`;
ALTER TABLE `destinations` ADD COLUMN `area_source` varchar(255) AFTER `area_name`;
ALTER TABLE `destinations` ADD COLUMN `destination_type` varchar(255) AFTER `roamfree_parent`;
DROP TABLE IF EXISTS `roamfree_countries`;
CREATE TABLE `roamfree_countries` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `roamfreeName` varchar(255) DEFAULT NULL,
  `liveHotels` int(10) DEFAULT NULL,
  `roamfreeId` int(10) DEFAULT NULL,
  `isoCode` varchar(10) DEFAULT NULL,
  `added` varchar(20) DEFAULT NULL,
  `modified` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- ----------------------------
-- Table structure for roamfree_destinations
-- ----------------------------
DROP TABLE IF EXISTS `roamfree_destinations`;
CREATE TABLE `roamfree_destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `roamfree_name` varchar(255) DEFAULT NULL,
  `roamfree_id` int(11) DEFAULT NULL,
  `dest_type` varchar(255) DEFAULT NULL,
  `state_name` varchar(255) DEFAULT NULL,
  `state_source` varchar(255) DEFAULT NULL,
  `region_name` varchar(255) DEFAULT NULL,
  `region_source` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `area_source` varchar(255) DEFAULT NULL,
  `live_hotels` int(20) DEFAULT NULL,
  `roamfree_parent` int(20) DEFAULT NULL,
  `level` int(5) DEFAULT NULL,
  `destination_id` int(20) DEFAULT NULL,
  `added` varchar(20) DEFAULT NULL,
  `modified` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `queue`;

CREATE TABLE `queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(255) DEFAULT NULL,
  `message` varchar(600) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `queue_progress`;

CREATE TABLE `queue_progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `queue_name` varchar(255) DEFAULT NULL,
  `total` int(255) DEFAULT NULL,
  `progress` int(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
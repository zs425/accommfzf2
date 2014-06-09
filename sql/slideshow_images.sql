/*
 Database - accomm_newcms
*/


DROP TABLE IF EXISTS `slideshow_images`;

CREATE TABLE `slideshow_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `slideshow_id` int(11) NOT NULL,
  `image_path` varchar(400) NOT NULL,
  `thumb_path` varchar(400) NOT NULL,
  `image_desc` varchar(200) NOT NULL,
  `width` int(4) DEFAULT NULL,
  `height` int(4) DEFAULT NULL,
  `order_index` int(11) NOT NULL DEFAULT '0',
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `discription` varchar(500) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `linktext` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`image_id`)
)
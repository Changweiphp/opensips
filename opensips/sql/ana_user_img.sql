CREATE TABLE IF NOT EXISTS `ana_user_img` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(64) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

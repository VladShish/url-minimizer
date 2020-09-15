CREATE TABLE `minimized_urls` (
  `minimized_url_id` int NOT NULL AUTO_INCREMENT,
  `hash` char(10) NOT NULL,
  `url` varchar(255) NOT NULL,
  `date_expire` datetime NOT NULL,
  `user_id` varchar(30) NOT NULL,
  `count` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`minimized_url_id`),
  UNIQUE KEY `minimized_urls_hash_user_id_uindex` (`hash`,`user_id`),
  KEY `minimized_user_id_date_expire` (`user_id`,`date_expire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
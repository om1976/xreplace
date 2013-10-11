CREATE DATABASE  IF NOT EXISTS `xreplace`;
USE `xreplace`;

DROP TABLE IF EXISTS `ed_categories`;
CREATE TABLE `ed_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `link` varchar(40) DEFAULT NULL,
  `vsetv_id` int(11) DEFAULT NULL,
  `name` varchar(45) NOT NULL,
  `language` varchar(45) DEFAULT NULL,
  `timezone` varchar(45) DEFAULT NULL,
  `selected` enum('','selected') DEFAULT '',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(40) NOT NULL,
  `edited_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(40) DEFAULT NULL,
  `info` text,
  `sample_text` text,
  PRIMARY KEY (`id`),
  KEY `fk_categories_users1` (`added_by`),
  KEY `fk_categories_users2` (`edited_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ed_groups`;

CREATE TABLE `ed_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('expanded','compact','norules') DEFAULT NULL,
  `global` enum('global') DEFAULT NULL,
  `deleted` int(1) unsigned DEFAULT '0',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(40) NOT NULL,
  `edited_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(40) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_groups_users1` (`added_by`),
  KEY `fk_groups_users2` (`edited_by`),
  KEY `fk_ed_groups_ed_categories1` (`category_id`),
  CONSTRAINT `fk_ed_groups_ed_categories1` FOREIGN KEY (`category_id`) REFERENCES `ed_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ed_rules`;

CREATE TABLE `ed_rules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL,
  `pattern` varchar(2048) DEFAULT NULL,
  `separator` varchar(1) DEFAULT NULL,
  `modifiers` varchar(20) DEFAULT NULL,
  `replacement` varchar(2048) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `order` int(10) unsigned DEFAULT '1',
  `deleted` int(1) unsigned DEFAULT '0',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` varchar(40) DEFAULT NULL,
  `edited_at` timestamp NULL DEFAULT NULL,
  `edited_by` varchar(40) DEFAULT NULL,
  `times_used` int(11) DEFAULT '0',
  `total_time` double DEFAULT '0' COMMENT 'Total time in seconds',
  `used_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_rules_users1` (`added_by`),
  KEY `fk_rules_users2` (`edited_by`),
  KEY `fk_ed_rules_ed_groups1` (`group_id`),
  CONSTRAINT `fk_ed_rules_ed_groups1` FOREIGN KEY (`group_id`) REFERENCES `ed_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `ed_menu`;

CREATE TABLE `ed_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT NULL,
  `section` varchar(64) NOT NULL,
  `link` varchar(256) DEFAULT NULL,
  `ru_title` varchar(45) DEFAULT NULL,
  `en_title` varchar(45) DEFAULT NULL,
  `order` int(11) DEFAULT '1',
  `display` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_menu_menu1` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `ed_menu` VALUES (1,NULL,'editor','editor','Редактор','Editor',1,3),(2,NULL,'faq','editor/faq','Справка','Guide',2,3);
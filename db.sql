CREATE TABLE `proxy_list` (
	`ip` CHAR(15) NOT NULL,
	`port` SMALLINT(6) UNSIGNED NOT NULL,
	`type_enum` TINYINT(1) UNSIGNED NOT NULL COMMENT 'Смотри класс Mapper',
	`hide_enum` TINYINT(1) UNSIGNED NULL DEFAULT NULL COMMENT 'Смотри класс Mapper',
	`country_enum` SMALLINT(3) UNSIGNED NULL DEFAULT NULL COMMENT 'Смотри класс Mapper',
	`ping` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'В миллисекундах',
	`score` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ban index',
	`date_update` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`added_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`ip`, `port`, `type_enum`),
	INDEX `hide_enum` (`hide_enum`),
	INDEX `country_enum` (`country_enum`),
	INDEX `ping_score` (`ping`, `score`)
)
	COLLATE='utf8_general_ci'
	ENGINE=MyISAM;

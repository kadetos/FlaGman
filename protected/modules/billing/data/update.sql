INSERT INTO `%prefix%_usermenu` VALUES ('0', '10', '1', 'Магазин', '/billing/buy', 'Магазин', '/billing/buy');

CREATE TABLE IF NOT EXISTS `%prefix%_billing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tariff` tinyint(2) unsigned NOT NULL,
  `sum` smallint(4) unsigned NOT NULL,
  `days` smallint(4) unsigned NOT NULL,
  `status` enum('created','paid','cancel','return','stop') NOT NULL DEFAULT 'created',
  `create` int(11) unsigned NOT NULL,
  `update` int(11) unsigned NOT NULL,
  `desc` varchar(255) NOT NULL,
  `server` int(11) unsigned NOT NULL,
  `auth` varchar(3) NOT NULL,
  `steamid` varchar(32) NOT NULL,
  `password` char(32) DEFAULT NULL,
  `nickname` varchar(32) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `%prefix%_config` (
  `status` enum('ENABLED','ADMIN','UNBAN','DISABLED') NOT NULL DEFAULT 'DISABLED',
  `day` smallint(4) unsigned NOT NULL,
  `threeday` smallint(4) unsigned NOT NULL,
  `weekly` smallint(4) unsigned NOT NULL,
  `mounth` smallint(4) unsigned NOT NULL,
  `permanently` smallint(4) unsigned NOT NULL,
  PRIMARY KEY (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `%prefix%_config` VALUES ('DISABLED', '10', '20', '30', '40', '50');

CREATE TABLE IF NOT EXISTS `%prefix%_tariff` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `cost` int(9) unsigned NOT NULL,
  `flags` varchar(22) NOT NULL,
  `servers` varchar(50) NOT NULL,
  `days` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE `iine_votes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `created` int(10) unsigned NOT NULL default '0',
  `dirname` varchar(50) NOT NULL,
  `content_id` int(10) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;
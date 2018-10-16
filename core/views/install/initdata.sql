DROP TABLE IF EXISTS `doufox_admin`;
CREATE TABLE IF NOT EXISTS `doufox_admin` (
  `userid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `roleid` smallint(5) DEFAULT '0',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `auth` text NOT NULL,
  `list_size` smallint(5) NOT NULL,
  `left_width` smallint(5) NOT NULL DEFAULT '150',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_admin` (`userid`, `username`, `password`, `roleid`, `realname`, `auth`, `list_size`, `left_width`) VALUES (1, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 1, '超级管理员', '', 10, 150);

DROP TABLE IF EXISTS `doufox_account`;
CREATE TABLE IF NOT EXISTS `doufox_account` (
  `userid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `roleid` smallint(5) DEFAULT '0',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `auth` text NOT NULL,
  `list_size` smallint(5) NOT NULL,
  `left_width` smallint(5) NOT NULL DEFAULT '150',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_account` (`userid`, `username`, `password`, `roleid`, `realname`, `auth`, `list_size`, `left_width`) VALUES (1, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 1, '超级管理员', '', 10, 150);

DROP TABLE IF EXISTS `doufox_block`;
CREATE TABLE IF NOT EXISTS `doufox_block` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_category`;
CREATE TABLE IF NOT EXISTS `doufox_category` (
  `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(1) NOT NULL,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `parentid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `arrparentid` varchar(255) NOT NULL,
  `child` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `arrchildid` varchar(255) NOT NULL,
  `catname` varchar(30) NOT NULL,
  `image` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keywords` varchar(255) NOT NULL,
  `seo_description` varchar(255) NOT NULL,
  `catdir` varchar(30) NOT NULL,
  `url` varchar(100) NOT NULL,
  `http` varchar(255) NOT NULL,
  `items` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `listorder` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `ispost` smallint(2) NOT NULL,
  `verify` smallint(2) NOT NULL DEFAULT '0',
  `islook` smallint(2) NOT NULL,
  `categorytpl` varchar(50) NOT NULL,
  `listtpl` varchar(50) NOT NULL,
  `showtpl` varchar(50) NOT NULL,
  `pagetpl` varchar(50) NOT NULL,
  `pagesize` smallint(5) NOT NULL,
  PRIMARY KEY (`catid`),
  KEY `listorder` (`listorder`,`child`),
  KEY `ismenu` (`ismenu`),
  KEY `parentid` (`parentid`),
  KEY `modelid` (`modelid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_content`;
CREATE TABLE IF NOT EXISTS `doufox_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `modelid` smallint(5) NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `thumb` varchar(255) NOT NULL DEFAULT '',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL,
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `hits` smallint(5) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `member` (`catid`,`status`,`time`),
  KEY `list` (`catid`,`status`,`time`),
  KEY `top` (`catid`,`status`,`hits`),
  KEY `admin` (`listorder`,`catid`,`modelid`,`status`,`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_content_article`;
CREATE TABLE IF NOT EXISTS `doufox_content_article` (
  `id` mediumint(8) NOT NULL,
  `catid` smallint(5) NOT NULL,
  `content` mediumtext NOT NULL,
  `tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_content_product`;
CREATE TABLE IF NOT EXISTS `doufox_content_product` (
  `id` mediumint(8) NOT NULL,
  `catid` smallint(5) NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_form_comment`;
CREATE TABLE IF NOT EXISTS `doufox_form_comment` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cid` mediumint(8) NOT NULL,
  `userid` mediumint(8) NOT NULL,
  `username` char(20) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY `userid` (`userid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_form_gestbook`;
CREATE TABLE IF NOT EXISTS `doufox_form_gestbook` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cid` mediumint(8) NOT NULL,
  `userid` mediumint(8) NOT NULL,
  `username` char(20) NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `time` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` char(20) DEFAULT NULL,
  `yourname` varchar(255) DEFAULT NULL,
  `yourqq` varchar(255) DEFAULT NULL,
  `messagecontent` text,
  `yourphoneno` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY `userid` (`userid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_member`;
CREATE TABLE IF NOT EXISTS `doufox_member` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `salt` char(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT '',
  `modelid` smallint(5) NOT NULL,
  `credits` int(10) NOT NULL,
  `regdate` int(10) unsigned NOT NULL DEFAULT '0',
  `regip` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_model`;
CREATE TABLE IF NOT EXISTS `doufox_model` (
  `modelid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(3) NOT NULL,
  `modelname` char(30) NOT NULL,
  `tablename` char(20) NOT NULL,
  `categorytpl` varchar(30) NOT NULL,
  `listtpl` varchar(30) NOT NULL,
  `showtpl` varchar(30) NOT NULL,
  `joinid` smallint(5) DEFAULT NULL,
  `setting` text,
  PRIMARY KEY (`modelid`),
  KEY `typeid` (`typeid`),
  KEY `joinid` (`joinid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_model` (`modelid`, `typeid`, `modelname`, `tablename`, `categorytpl`, `listtpl`, `showtpl`, `joinid`, `setting`) VALUES
(1, 1, '文章模型', 'content_article', 'category_article.html', 'list_article.html', 'show_article.html', 0, 'a:1:{s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}'),
(2, 1, '产品模型', 'content_product', 'category_product.html', 'list_product.html', 'show_product.html', 0, 'a:1:{s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}'),
(3, 3, '在线留言', 'form_gestbook', 'form.html', 'list_gestbook.html', 'show_gestbook.html', 0, ''),
(4, 3, '文章评论', 'form_comment', 'form.html', 'list_comment.html', 'show_comment.html', 0, '');

DROP TABLE IF EXISTS `doufox_model_field`;
CREATE TABLE IF NOT EXISTS `doufox_model_field` (
  `fieldid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `field` varchar(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(15) NOT NULL,
  `length` char(10) NOT NULL,
  `indexkey` varchar(10) NOT NULL,
  `isshow` tinyint(1) NOT NULL,
  `tips` text NOT NULL,
  `not_null` tinyint(1) NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL,
  `errortips` varchar(255) NOT NULL,
  `formtype` varchar(20) NOT NULL,
  `setting` mediumtext NOT NULL,
  `listorder` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fieldid`),
  KEY `modelid` (`modelid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_model_field` (`fieldid`, `modelid`, `field`, `name`, `type`, `length`, `indexkey`, `isshow`, `tips`, `not_null`, `pattern`, `errortips`, `formtype`, `setting`, `listorder`, `disabled`) VALUES
(1, 1, 'content', '内容 ', '', '', '', 1, '', 0, '', '', 'editor', '', 0, 0),
(2, 2, 'content', '内容 ', '', '', '', 1, '', 0, '', '', 'editor', '', 0, 0),
(3, 3, 'yourname', '您的姓名', '', '', '', 1, '', 1, '', '', 'input', 'array (\n  ''size'' => ''150'',\n  ''default'' => '''',\n)', 0, 0),
(4, 3, 'yourqq', '联系QQ', '', '', '', 1, '', 0, '', '', 'input', 'array (\n  ''size'' => ''150'',\n  ''default'' => '''',\n)', 0, 0),
(8, 3, 'yourphoneno', '联系电话', '', '', '', 1, '', 1, '/^[0-9.-]+$/', '请填入您的联系电话，方便我们联系您', 'input', 'array (\n  ''size'' => ''150'',\n  ''default'' => '''',\n)', 0, 0),
(7, 3, 'messagecontent', '留言内容', 'TEXT', '50000', '', 1, '', 1, '', '', 'textarea', 'array (\n  ''width'' => ''400'',\n  ''height'' => ''90'',\n  ''default'' => ''留下您的手机号码，我们会尽快回复您！'',\n)', 0, 0),
(9, 1, 'tag', '标签', '', '', '', 1, '', 0, '', '', 'input', 'array (\n  ''size'' => ''150'',\n  ''default'' => '''',\n)', 0, 0);

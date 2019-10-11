DROP TABLE IF EXISTS `doufox_account`;
CREATE TABLE IF NOT EXISTS `doufox_account` (
  `userid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) DEFAULT NULL,
  `password` VARCHAR(32) DEFAULT NULL,
  `roleid` smallint(5) DEFAULT '0',
  `realname` VARCHAR(50) NOT NULL DEFAULT '',
  `auth` TEXT NOT NULL,
  `list_size` smallint(5) NOT NULL,
  `left_width` smallint(5) NOT NULL DEFAULT '150',
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`userid`),
  KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_account` (`userid`, `username`, `password`, `roleid`, `realname`, `auth`, `list_size`, `left_width`) VALUES (1, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 1, '超级管理员', '', 10, 150);

DROP TABLE IF EXISTS `doufox_block`;
CREATE TABLE IF NOT EXISTS `doufox_block` (
  `id` smallint(8) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL,
  `name` VARCHAR(50) NOT NULL,
  `remark` VARCHAR(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_category`;
CREATE TABLE IF NOT EXISTS `doufox_category` (
  `catid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(1) NOT NULL,
  `modelid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `parentid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `arrparentid` VARCHAR(255) NOT NULL,
  `child` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `arrchildid` VARCHAR(255) NOT NULL,
  `catname` VARCHAR(30) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `seo_title` VARCHAR(255) NOT NULL,
  `seo_keywords` VARCHAR(255) NOT NULL,
  `seo_description` VARCHAR(255) NOT NULL,
  `catdir` VARCHAR(30) NOT NULL,
  `url` VARCHAR(100) NOT NULL,
  `http` VARCHAR(255) NOT NULL,
  `items` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `listorder` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `ismenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ispost` smallint(2) NOT NULL,
  `verify` smallint(2) NOT NULL DEFAULT '0',
  `islook` smallint(2) NOT NULL,
  `categorytpl` VARCHAR(50) NOT NULL,
  `listtpl` VARCHAR(50) NOT NULL,
  `showtpl` VARCHAR(50) NOT NULL,
  `searchtpl` VARCHAR(30) NOT NULL,
  `pagetpl` VARCHAR(50) NOT NULL,
  `pagesize` smallint(5) NOT NULL,
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`catid`),
  KEY `listorder` (`listorder`,`child`),
  KEY `ismenu` (`ismenu`),
  KEY `parentid` (`parentid`),
  KEY `modelid` (`modelid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_content`;
CREATE TABLE IF NOT EXISTS `doufox_content` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `modelid` smallint(5) NOT NULL,
  `title` VARCHAR(80) NOT NULL DEFAULT '',
  `thumb` VARCHAR(255) NOT NULL DEFAULT '',
  `keywords` VARCHAR(255) NOT NULL DEFAULT '',
  `description` VARCHAR(255) NOT NULL,
  `url` char(100) NOT NULL,
  `listorder` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `hits` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
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
  `tag` VARCHAR(255) DEFAULT NULL,
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
  `listorder` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `ip` char(20) DEFAULT NULL,
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
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
  `listorder` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `ip` char(20) DEFAULT NULL,
  `yourname` VARCHAR(255) DEFAULT NULL,
  `yourqq` VARCHAR(255) DEFAULT NULL,
  `messagecontent` TEXT,
  `yourphoneno` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listorder` (`listorder`),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY `userid` (`userid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_member`;
CREATE TABLE IF NOT EXISTS `doufox_member` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` char(20) NOT NULL DEFAULT '',
  `nickname` VARCHAR(50) DEFAULT '',
  `password` char(32) NOT NULL DEFAULT '',
  `salt` char(10) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `avatar` VARCHAR(100) NOT NULL DEFAULT '',
  `modelid` smallint(5) NOT NULL,
  `credits` INT(10) NOT NULL,
  `regdate` INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `regip` VARCHAR(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `doufox_model`;
CREATE TABLE IF NOT EXISTS `doufox_model`(
  `modelid` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(3) NOT NULL,
  `modelname` char(30) NOT NULL,
  `tablename` char(20) NOT NULL,
  `categorytpl` VARCHAR(30) NOT NULL,
  `listtpl` VARCHAR(30) NOT NULL,
  `showtpl` VARCHAR(30) NOT NULL,
  `searchtpl` VARCHAR(30) NOT NULL,
  `joinid` smallint(5) DEFAULT NULL,
  `setting` TEXT,
  `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`modelid`),
  KEY `typeid` (`typeid`),
  KEY `joinid` (`joinid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `doufox_model` (`modelid`, `typeid`, `modelname`, `tablename`, `categorytpl`, `listtpl`, `showtpl`, `searchtpl`, `joinid`, `setting`) VALUES
(1, 1, '文章模型', 'content_article', 'category_article.html', 'list_article.html', 'show_article.html', 'search.html', 0, 'a:1:{s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}'),
(2, 1, '产品模型', 'content_product', 'category_product.html', 'list_product.html', 'show_product.html', 'search.html', 0, 'a:1:{s:7:"default";a:4:{s:5:"title";a:2:{s:4:"name";s:6:"标题";s:4:"show";s:1:"1";}s:8:"keywords";a:2:{s:4:"name";s:9:"关键字";s:4:"show";s:1:"1";}s:5:"thumb";a:2:{s:4:"name";s:9:"缩略图";s:4:"show";s:1:"1";}s:11:"description";a:2:{s:4:"name";s:6:"描述";s:4:"show";s:1:"1";}}}'),
(3, 3, '在线留言', 'form_gestbook', 'form.html', 'list_gestbook.html', 'show_gestbook.html', 'search.html', 0, 'a:1:{s:7:"default";a:5:{s:8:"username";a:2:{s:4:"name";s:9:"用户名";s:4:"show";s:1:"0";}s:9:"listorder";a:2:{s:4:"name";s:12:"排序编号";s:4:"show";s:1:"0";}s:6:"status";a:2:{s:4:"name";s:6:"状态";s:4:"show";s:1:"0";}s:4:"time";a:2:{s:4:"name";s:12:"提交时间";s:4:"show";s:1:"0";}s:2:"ip";a:2:{s:4:"name";s:8:"IP地址";s:4:"show";s:1:"0";}}}'),
(4, 3, '文章评论', 'form_comment', 'form.html', 'list_comment.html', 'show_comment.html', 'search.html', 0, 'a:1:{s:7:"default";a:5:{s:8:"username";a:2:{s:4:"name";s:9:"用户名";s:4:"show";s:1:"1";}s:9:"listorder";a:2:{s:4:"name";s:12:"排序编号";s:4:"show";s:1:"1";}s:6:"status";a:2:{s:4:"name";s:6:"状态";s:4:"show";s:1:"1";}s:4:"time";a:2:{s:4:"name";s:12:"提交时间";s:4:"show";s:1:"1";}s:2:"ip";a:2:{s:4:"name";s:8:"IP地址";s:4:"show";s:1:"1";}}}');

DROP TABLE IF EXISTS `doufox_model_field`;
CREATE TABLE IF NOT EXISTS `doufox_model_field`(
  `fieldid` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `modelid` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `field` VARCHAR(20) NOT NULL,
  `name` VARCHAR(30) NOT NULL,
  `type` VARCHAR(15) NOT NULL,
  `length` char(10) NOT NULL,
  `indexkey` VARCHAR(10) NOT NULL,
  `isshow` tinyint(1) NOT NULL,
  `tips` TEXT NOT NULL,
  `not_null` tinyint(1) NOT NULL DEFAULT '0',
  `pattern` VARCHAR(255) NOT NULL,
  `errortips` VARCHAR(255) NOT NULL,
  `formtype` VARCHAR(20) NOT NULL,
  `setting` mediumtext NOT NULL,
  `listorder` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `disabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
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

DROP TABLE IF EXISTS `doufox_plugin`;
CREATE TABLE IF NOT EXISTS `doufox_plugin`(
    `id` SMALLINT(8) NOT NULL AUTO_INCREMENT,
    `official` TINYINT(1) NOT NULL COMMENT '官方提供',
    `name` VARCHAR(50) NOT NULL '插件名称',
    `version` VARCHAR(100) NOT NULL '插件版本',
    `url` VARCHAR(255) NOT NULL '插件地址',
    `description` MEDIUMTEXT NOT NULL '插件描述',
    `author` VARCHAR(255) NOT NULL '作者',
    `author_url` VARCHAR(255) NOT NULL '作者地址',
    `status` TINYINT(1) NOT NULL COMMENT '状态',
    `setting` TEXT COMMENT '配置',
    `create_time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
    `time` INT(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
    PRIMARY KEY(`id`)
) ENGINE = MyISAM DEFAULT CHARSET = utf8;

INSERT INTO `doufox_plugin` (`official`, `name`, `version`, `url`, `description`, `author`, `author_url`, `status`) VALUES (1, '温馨提示', '1.1', 'https://doufox.com', '内置插件，它会在你管理主页面显示一句温馨的小提示。', 'doufox', 'https://doufox.com', 1);
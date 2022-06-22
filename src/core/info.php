<?php

if (!defined('IN_CRONLITE')) {
    exit('Access Deined!');
}

/**
 * 系统基本属性
 */
define('APP_NAME', 'Doufox'); // 系统名称
define('APP_SITE', 'http://doufox.com'); // 系统官方网站
define('APP_VERSION', '0.0.3'); // 系统版本
define('APP_RELEASE', '20220622'); // 系统发布日期
define('APP_DEBUG', 0); // 系统调试
header('Content-Type: text/html; charset=utf-8');
header('X-Powered-By: ' . APP_NAME);
header('Copyright: ' . APP_NAME);

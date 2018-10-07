<?php
/**
 * 系统基本属性
 */
define('APP_NAME', 'doufox'); // 系统名称
define('APP_SITE', 'https://doufox.com/'); // 系统官方网站
define('APP_VERSION', '0.0.1'); // 系统版本
define('APP_RELEASE', '20181008'); // 系统发布日期
define('APP_DEBUG', 0); // 系统调试
header('Content-Type: text/html; charset=utf-8');
header('X-Powered-By: ' . APP_NAME);
header('Copyright: ' . APP_NAME);

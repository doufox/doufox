<?php
error_reporting(E_ALL ^ E_NOTICE);
/**
 * 系统入口文件
 */
define('ENTRY_FILE', basename(__FILE__)); // 定义入口文件
define('DS', DIRECTORY_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__)); // 定义根路径
include PATH_ROOT . DS . 'core' . DS . 'core.php'; // 加载系统
core::load(); // 运行系统

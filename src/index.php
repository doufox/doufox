<?php

/**
 * 系统入口文件
 */
define('ENTRY_FILE', basename(__FILE__)); // 定义入口文件
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', dirname(__FILE__)); // 定义根路径
include ROOT_PATH . DS . 'core' . DS . 'core.php'; // 加载系统
core::load(); // 运行系统

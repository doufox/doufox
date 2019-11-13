<?php
/**
 * 系统入口文件
 */
define('ENTRY_FILE', 'index.php'); // 定义入口文件
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR); // 定义根路径
include ROOT_PATH . 'core' . DIRECTORY_SEPARATOR . 'core.php'; // 加载系统
core::load(); // 运行系统

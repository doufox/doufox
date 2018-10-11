<?php
define('DS', DIRECTORY_SEPARATOR);
define('ENTRY_FILE', 'index.php'); // 系统入口文件
define('ROOT_PATH', dirname(__FILE__) . DS); // 系统根路径
include ROOT_PATH . 'core' . DS . 'app.php'; // 加载系统
cms::run(); // 运行系统

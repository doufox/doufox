<?php

define('DS', DIRECTORY_SEPARATOR);
define('ENTRY_FILE', 'index.php'); // 系统入口文件
define('CORE_DIR', 'core'); // 系统核心模块
define('ROOT_PATH', dirname(__FILE__) . DS); // 系统根路径

include ROOT_PATH . CORE_DIR . DS . 'app.php';
cms::run();

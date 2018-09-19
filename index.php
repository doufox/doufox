<?php

define('DS', DIRECTORY_SEPARATOR);
define('ENTRY_FILE', 'index.php'); // 系统入口文件, 即当前文件
define('CORE_DIR', 'core'); // 系统核心模块所在目录
define('ROOT_PATH', dirname(__FILE__) . DS); // 网站文件跟目录, 即当前文件所在目录

include ROOT_PATH . CORE_DIR . DS . 'app.php';
cms::run();

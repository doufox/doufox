<?php

/**
 * 系统入口文件
 */
define('IN_CMS', true);
error_reporting(E_ALL ^ E_NOTICE);

/**
 * 系统常量配置
 */
date_default_timezone_set('Asia/Shanghai'); // 系统时区设置
define('ENTRY_SCRIPT_NAME', 'index.php'); // 系统入口文件
define('DS', DIRECTORY_SEPARATOR);
define('APP_START_TIME', microtime(true)); // 设置程序开始执行时间

define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''); // 来源
define('HTTP_HOST', $_SERVER['HTTP_HOST']); // host
define('HTTP_PRE', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://'); // http协议
define('HTTP_URL', HTTP_PRE . HTTP_HOST . DS); // 当前网站的完整网址
define('COOKIE_PRE', 'df_'); // Cookie 前缀, 同一个域名下安装多套系统时, 请修改Cookie前缀

define('CORE_PATH', dirname(__FILE__) . DS); // 系统核心模块所在路径, 即当前路径
define('DATA_DIR', 'data'); // 系统数据文件夹名
define('STATIC_DIR', 'static'); // 系统静态资源文件夹名
define('MODEL_DIR', 'models'); // 数据模型文件夹
define('CONTROLLER_DIR', 'controllers'); // 控制器文件夹

define('ADMIN_PATH', CORE_PATH . 'admin' . DS); // 系统后台管理模块的路径
define('INSTALL_PATH', CORE_PATH . 'install' . DS); // 系统安装模块
define('DATA_PATH', ROOT_PATH . DATA_DIR . DS); // 系统数据目录的路径
define('STATIC_PATH', DATA_PATH . STATIC_DIR . DS); // 系统静态资源路径
define('THEME_PATH', DATA_PATH . 'theme' . DS); // 网站的桌面端模板目录的路径
define('MODEL_PATH', CORE_PATH . MODEL_DIR . DS); // 系统数据模型路径
define('CONTROLLER_PATH', CORE_PATH . CONTROLLER_DIR . DS); // 控制器路径
define('THEME_PATH_MOBILE', DATA_PATH . 'theme_mobile' . DS); // 网站移动端模板目录的路径

cms::load_file(CORE_PATH . 'info.php');
cms::load_file(CORE_PATH . 'library' . DS . 'global.function.php'); // 加载全局函数
cms::load_class('Model', '', 0);

header('Content-Type: text/html; charset=utf-8');
header('X-Powered-By: ' . APP_NAME);
header('Copyright: ' . APP_NAME);

/**
 * 系统核心APP
 */
abstract class cms
{
    public static $namespace;
    public static $controller;
    public static $action;
    public static $pathinfo;

    /**
     * 项目运行函数
     */
    public static function run()
    {
        self::parse_request();
        self::load_theme();
        self::load_app();
    }

    /**
     * 分析URL信息
     */
    private static function parse_request()
    {
        self::$pathinfo = explode('/', $_SERVER['PATH_INFO']);
        $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
        parse_str($path_url_string, $url_info_array);
        $namespace_name = trim((isset($url_info_array['s']) && $url_info_array['s']) ? $url_info_array['s'] : '');
        if (isset($url_info_array['s']) && $url_info_array['s']) {
            $namespace_name = $url_info_array['s'];
        } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == 'admin') {
            $namespace_name = 'admin';
            $controller_name = 'Index';
        }
        // $controller_name = trim((isset($url_info_array['c']) && $url_info_array['c']) ? $url_info_array['c'] : 'Index');
        if (isset(self::$pathinfo[1])) {
            if (self::$pathinfo[1] == DATA_DIR || self::$pathinfo[1] == CORE_DIR) {
                header("HTTP/1.0 403 Forbidden");
                exit();
            } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == STATIC_DIR) {
                $controller_name = STATIC_DIR; // 静态资源
            } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == 'theme') {
                $controller_name = 'theme'; // 主题资源
            }
        } else if (isset($url_info_array['c']) && $url_info_array['c']) {
            $controller_name = trim($url_info_array['c']);
        } else {
            $controller_name = 'Index'; // controller默认为index
        }
        $action_name = trim((isset($url_info_array['a']) && $url_info_array['a']) ? $url_info_array['a'] : 'index'); // action默认为index
        self::$namespace = strtolower($namespace_name);
        self::$controller = ucfirst(strtolower($controller_name));
        self::$action = strtolower($action_name);
        $_GET = array_merge($_GET, $url_info_array);
        return true;
    }

    /**
     * 控制器处理
     */
    public static function load_app()
    {
        static $_app = array();
        $app_id = self::$controller . '_' . self::$action;
        if (!isset($_app[$app_id]) || $_app[$app_id] == null) {
            $namespace = self::$namespace;
            $controller = self::$controller . 'Controller';
            $action = self::$action . 'Action';
            self::load_file(CONTROLLER_PATH . 'Controller.php');
            if ($namespace && is_dir(CONTROLLER_PATH . $namespace)) {
                $controller_file = CONTROLLER_PATH . $namespace . DS . $controller . '.php';
                if (!is_file($controller_file)) {
                    exit('Controller does not exist.');
                }
                if (is_file(CONTROLLER_PATH . $namespace . DS . 'Controller.php')) {
                    self::load_file(CONTROLLER_PATH . $namespace . DS . 'Controller.php');
                }
                self::load_file($controller_file);
            } elseif (is_file(CONTROLLER_PATH . $controller . '.php')) {
                self::load_file(CONTROLLER_PATH . $controller . '.php');
            } else {
                exit('Controller does not exist.');
            }
            if (method_exists($controller, $action)) {
                $app_object = new $controller();
                $_app[$app_id] = $app_object->$action();
            } else {
                exit('Action does not exist.');
            }
        }
        return $_app[$app_id];
    }

    /**
     * 加载主题
     */
    public static function load_theme()
    {
        $config = self::load_config('config');
        define('SITE_THEME', $config['SITE_THEME']);
        define('SITE_THEME_MOBILE', $config['SITE_THEME_MOBILE']);
        if ($config['SITE_MOBILE'] == true && is_mobile()) {
            define('THEME_TYPE', 'theme_mobile'); // 当前加载的主题类型
            define('THEME_CURRENT', THEME_PATH_MOBILE);
            define('THEME_DIR', is_dir(THEME_PATH_MOBILE . SITE_THEME_MOBILE) ? SITE_THEME_MOBILE : 'default');
        } else {
            define('THEME_TYPE', 'theme_desktop'); // 当前加载的主题类型
            define('THEME_CURRENT', THEME_PATH);
            define('THEME_DIR', is_dir(THEME_PATH . SITE_THEME) ? SITE_THEME : 'default');
        }
    }
    /**
     * 静态加载文件(相当于PHP函数require_once)
     */
    public static function load_file($file_name)
    {
        static $_inc_files = array();
        // 参数分析
        if (!$file_name) {
            return false;
        }

        if (!isset($_inc_files[$file_name])) {
            if (!file_exists($file_name)) {
                exit('The file:' . $file_name . ' not found!');
            }
            include_once $file_name;
            $_inc_files[$file_name] = true;
        }
        return $_inc_files[$file_name];
    }

    /**
     * 加载自定义配置文件
     * @param string $file 配置文件
     * @param string $key  要获取的配置荐
     * @param string $default  默认配置。当获取配置项目失败时该值发生作用。
     */
    public static function load_config($file)
    {
        static $configs = array();
        $path = DATA_PATH . 'config' . DS . $file . '.ini.php';
        if (file_exists($path)) {
            $configs[$file] = include $path;
            return $configs[$file];
        }
    }

    /**
     * 加载数据模型
     * @param string $classname 类名
     */
    public static function load_model($table_name)
    {
        $model_name = ucfirst(strtolower($table_name)) . 'Model';
        return self::load_class($model_name, 'models');
    }

    /**
     * 加载类
     * @param string $classname 类名
     * @param string $path 扩展地址
     * @param intger $initialize 是否初始化
     */
    public static function load_class($classname, $path = '', $initialize = 1)
    {
        static $classes = array();
        if (empty($path)) {
            $path = 'library';
        }

        $key = md5($path . $classname);
        if (isset($classes[$key])) {
            if (!empty($classes[$key])) {
                return $classes[$key];
            } else {
                return true;
            }
        }
        if (file_exists(CORE_PATH . $path . DS . $classname . '.class.php')) {
            include CORE_PATH . $path . DS . $classname . '.class.php';
            $name = $classname;
            if ($initialize) {
                $classes[$key] = new $name;
            } else {
                $classes[$key] = true;
            }
            return $classes[$key];
        } else {
            return false;
        }
    }

    /**
     * 获取当前运行的namespace名称
     */
    public static function get_namespace_id()
    {
        return strtolower(self::$namespace);
    }

    /**
     * 获取当前运行的controller名称
     */
    public static function get_controller_id()
    {
        return strtolower(self::$controller);
    }

    /**
     * 获取当前运行的action名称
     */
    public static function get_action_id()
    {
        return self::$action;
    }

}

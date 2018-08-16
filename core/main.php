<?php

/**
 * 框架入口文件
 */
define('IN_CMS', true);
error_reporting(E_ALL ^ E_NOTICE);

/**
 * 系统常量配置
 */
date_default_timezone_set('Asia/Shanghai'); // 时区设置

define('ENTRY_SCRIPT_NAME', 'index.php'); // 定义入口文件名
define('SYS_START_TIME', microtime(true)); // 设置程序开始执行时间

define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''); // 来源
define('HTTP_HOST', $_SERVER['HTTP_HOST']); // host
define('HTTP_PRE', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://'); // http协议
define('HTTP_URL', HTTP_PRE . HTTP_HOST); // 当前URL
define('COOKIE_PRE', 'ui_'); // Cookie 前缀，同一域名下安装多套系统时，请修改Cookie前缀

define('CORE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR); // 核心文件所在路径, 即当前路径
define('MODEL_DIR', CORE_PATH . 'models' . DIRECTORY_SEPARATOR); // model目录的路径
define('INSTALL_PATH', CORE_PATH . 'install' . DIRECTORY_SEPARATOR); // 系统安装入口
define('CONTROLLER_DIR', CORE_PATH . 'controllers' . DIRECTORY_SEPARATOR); // controller目录的路径

define('ADMIN_DIR', 'admin'); // 后台管理文件夹
define('ADMIN_PATH', CORE_PATH . ADMIN_DIR . DIRECTORY_SEPARATOR); // 后台管理模板的路径
define('DATA_NAME', 'data'); // 系统数据文件夹名
define('DATA_DIR', ROOT_PATH . DATA_NAME . DIRECTORY_SEPARATOR); // 数据目录的路径
define('STATIC_NAME', 'static'); // 静态资源文件夹名
define('STATIC_DIR', STATIC_NAME . DIRECTORY_SEPARATOR); // 前端静态调用文件的路径
define('THEME_PATH', DATA_DIR . 'theme' . DIRECTORY_SEPARATOR); // 桌面端模板目录的路径
define('THEME_MOBILE_PATH', DATA_DIR . 'theme_mobile' . DIRECTORY_SEPARATOR); // 移动端模板目录的路径

xiaocms::load_file(CORE_PATH . 'library' . DIRECTORY_SEPARATOR . 'global.function.php'); // 加载全局函数
xiaocms::load_file(CORE_PATH . 'version.php');
xiaocms::load_class('Model', '', 0);

/**
 * 系统核心全局控制类
 */

abstract class xiaocms
{
    public static $namespace;
    public static $controller;
    public static $action;
    public static $pathinfo;

    /**
     * 分析URL信息
     */
    private static function parse_request()
    {
        self::$pathinfo = explode('/', $_SERVER['PATH_INFO']);
        $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
        parse_str($path_url_string, $url_info_array);
        $namespace_name = trim((isset($url_info_array['s']) && $url_info_array['s']) ? $url_info_array['s'] : '');
        // $controller_name = trim((isset($url_info_array['c']) && $url_info_array['c']) ? $url_info_array['c'] : 'Index');
        if (isset(self::$pathinfo[1])) {
            if (self::$pathinfo[1] == DATA_NAME || self::$pathinfo[1] == CORE_NAME) {
                exit('Access Deined!');
            } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == STATIC_NAME) {
                $controller_name = STATIC_NAME; // 静态资源
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
     * 项目运行函数
     */
    public static function run()
    {
        self::parse_request();
        print(self::$pathinfo[0]);
        $config = self::load_config('config');
        if ($config['SITE_MOBILE'] == true && is_mobile()) {
            $config['SITE_THEME'] = (is_dir(THEME_PATH . 'mobile') ? 'mobile' : $config['SITE_THEME']);
        }
        static $_app = array();
        $app_id = self::$controller . '_' . self::$action;
        define('SYS_THEME_DIR', $config['SITE_THEME'] . DIRECTORY_SEPARATOR); // 模板风格
        define('THEME_NAME', $config['SITE_THEME']); // 模板风格名字
        if (!isset($_app[$app_id]) || $_app[$app_id] == null) {
            $namespace = self::$namespace;
            $controller = self::$controller . 'Controller';
            $action = self::$action . 'Action';
            self::load_file(CONTROLLER_DIR . 'Controller.php');
            if ($namespace && is_dir(CONTROLLER_DIR . $namespace)) {
                $controller_file = CONTROLLER_DIR . $namespace . DIRECTORY_SEPARATOR . $controller . '.php';
                if (!is_file($controller_file)) {
                    exit('Controller does not exist.');
                }

                if (is_file(CONTROLLER_DIR . $namespace . DIRECTORY_SEPARATOR . 'Controller.php')) {
                    self::load_file(CONTROLLER_DIR . $namespace . DIRECTORY_SEPARATOR . 'Controller.php');
                }

                self::load_file($controller_file);
            } elseif (is_file(CONTROLLER_DIR . $controller . '.php')) {
                self::load_file(CONTROLLER_DIR . $controller . '.php');
            } else {
                exit('Controller does not exist.');
            }
            $app_object = new $controller();
            if (method_exists($controller, $action)) {
                $_app[$app_id] = $app_object->$action();
            } else {
                exit('Action does not exist.');
            }
        }
        return $_app[$app_id];
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
        $path = ROOT_PATH . 'data' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file . '.ini.php';
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
        if (file_exists(CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php')) {
            include CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
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

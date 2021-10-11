<?php

// 系统入口文件
define('IN_CMS', true);
error_reporting(E_ALL ^ E_NOTICE);

// 系统常量
date_default_timezone_set('Asia/Shanghai'); // 系统时区设置
define('DS', DIRECTORY_SEPARATOR);
define('APP_START_TIME', isset($_SERVER['REQUSET_TIME']) ? $_SERVER['REQUSET_TIME'] : microtime(true)); // 设置程序开始执行时间
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''); // 来源
define('HTTP_HOST', $_SERVER['HTTP_HOST']); // host
define('HTTP_PRE', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://'); // http协议
define('HTTP_URL', HTTP_PRE . HTTP_HOST . DS); // 当前网站的完整域名
define('COOKIE_PRE', 'dou_'); // Cookie 前缀, 同一个域名下安装多套系统时, 请修改Cookie前缀

// 文件夹
define('CORE_DIR', 'core'); // 核心模块文件夹
define('DATA_DIR', 'data'); // 数据模块文件夹
define('MODEL_DIR', 'models'); // 数据模型文件夹
define('VIEW_DIR', 'views'); // 视图模板文件夹
define('CTRL_DIR', 'controllers'); // 控制器文件夹
define('STATIC_DIR', 'static'); // 静态文件夹
define('PLUGIN_DIR', 'plugin'); // 插件文件夹
define('THEME_DIR', 'theme'); // 主题模板文件夹

// 路径
define('CORE_PATH', dirname(__FILE__) . DS); // 核心模块路径
define('DATA_PATH', ROOT_PATH . DATA_DIR . DS); // 数据模块路径
define('MODEL_PATH', CORE_PATH . MODEL_DIR . DS); // 数据模型路径
define('VIEW_PATH', CORE_PATH . VIEW_DIR . DS); // 视图模板路径
define('CTRL_PATH', CORE_PATH . CTRL_DIR . DS); // 控制器路径
define('STATIC_PATH', ROOT_PATH . STATIC_DIR . DS); // 静态资源路径
define('ADMIN_PATH', VIEW_PATH . 'admin' . DS); // 后台管理视图模块路径
define('PUBLIC_PATH', VIEW_PATH . 'public' . DS); // 站点前台视图模板路径
define('INSTALL_PATH', VIEW_PATH . 'install' . DS); // 安装模块路径
define('THEME_PATH', ROOT_PATH . THEME_DIR . DS); // 主题模板路径
define('PLUGIN_PATH', ROOT_PATH . PLUGIN_DIR . DS); // 插件路径

core::load_file(CORE_PATH . 'info.php'); // 系统基本信息
core::load_file(CORE_PATH . 'library' . DS . 'global.function.php'); // 全局函数
core::load_class('Model', '', 0);

/**
 * 系统核心
 */
abstract class core
{
    public static $namespace;
    public static $controller;
    public static $action;
    public static $config;
    public static $router;

    /**
     * 加载应用
     */
    public static function load()
    {
        self::$config = self::load_config('config');
        self::$router = self::load_class('router');
        $request = self::$router->get();

        self::$namespace = $request['namespace'];
        self::$controller = $request['controller'];
        self::$action = $request['action'];
        self::load_theme();
        self::load_app();
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
            self::load_file(CTRL_PATH . 'Controller.php');
            if ($namespace && is_dir(CTRL_PATH . $namespace)) {
                $controller_file = CTRL_PATH . $namespace . DS . $controller . '.php';
                if (!is_file($controller_file)) {
                    exit('Controller does not exist.');
                }
                if (is_file(CTRL_PATH . $namespace . DS . 'Controller.php')) {
                    include_once CTRL_PATH . $namespace . DS . 'Controller.php';
                }
                include_once $controller_file;
            } elseif (is_file(CTRL_PATH . $controller . '.php')) {
                include_once CTRL_PATH . $controller . '.php';
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
        if (is_mobile() && !empty(self::$config['SITE_MOBILE']) && is_dir(THEME_PATH . self::$config['SITE_MOBILE'])) {
            // 设置了移动端主题并且是移动端访问
            define('SITE_THEME', self::$config['SITE_MOBILE']);
        } else {
            define('SITE_THEME', is_dir(THEME_PATH . self::$config['SITE_THEME']) ? self::$config['SITE_THEME'] : 'default');
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
     * @return mixed
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
     * 获取当前运行配置信息
     * @param string $key
     * @return array
     */
    public static function get_site_config($key = '')
    {
        if (isset($key) && isset(self::$config[$key])) {
            return self::$config[$key];
        }
        return self::$config;
    }

    /**
     * 获取当前运行的namespace名称
     * @return string
     */
    public static function get_namespace_id()
    {
        return strtolower(self::$namespace);
    }

    /**
     * 获取当前运行的controller名称
     * @return string
     */
    public static function get_controller_id()
    {
        return strtolower(self::$controller);
    }

    /**
     * 获取当前运行的action名称
     * @return string
     */
    public static function get_action_id()
    {
        return self::$action;
    }
}

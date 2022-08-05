<?php

// 系统入口文件
define('IN_CRONLITE', true);

// 系统常量
date_default_timezone_set('Asia/Shanghai'); // 系统时区设置
define('APP_START_TIME', isset($_SERVER['REQUSET_TIME']) ? $_SERVER['REQUSET_TIME'] : microtime(true)); // 设置程序开始执行时间
define('HTTP_REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''); // 来源
define('HTTP_HOST', $_SERVER['HTTP_HOST']); // host
define('HTTP_PRE', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://'); // http协议
define('HTTP_URL', HTTP_PRE . HTTP_HOST); // 当前网站的完整域名
define('COOKIE_PRE', 'dou_'); // Cookie 前缀, 同一个域名下安装多套系统时, 请修改Cookie前缀

// 文件夹
define('DIR_CORE', 'core'); // 核心模块文件夹
define('DIR_DATA', 'data'); // 数据模块文件夹
define('DIR_PLUGIN', 'plugin'); // 插件文件夹
define('DIR_TEMPLATE', 'template'); // 主题模板文件夹

// 路径
define('PATH_CORE', dirname(__FILE__)); // 核心模块路径
define('PATH_DATA', PATH_ROOT . DS . DIR_DATA); // 数据模块路径
define('PATH_CACHE', PATH_ROOT . DS . 'cache'); // 数据缓存路径
define('PATH_STATIC', PATH_ROOT . DS . 'static' . DS); // 静态资源路径
define('PATH_TEMPLATE', PATH_ROOT . DS . DIR_TEMPLATE); // 主题模板路径
define('PATH_PLUGIN', PATH_ROOT . DS . DIR_PLUGIN . DS); // 插件路径
define('PATH_MODEL', PATH_CORE . DS . 'models' . DS); // 数据模型路径
define('PATH_VIEW', PATH_CORE . DS . 'views' . DS); // 视图模板路径
define('PATH_CONTROLER', PATH_CORE . DS . 'controllers' . DS); // 控制器路径

core::load_file(PATH_CORE . DS . 'info.php'); // 系统基本信息
core::load_file(PATH_CORE . DS . 'library' . DS . 'global.function.php'); // 全局函数
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
        self::load_template();
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
            self::load_file(PATH_CONTROLER . 'Controller.php');
            if ($namespace && is_dir(PATH_CONTROLER . $namespace)) {
                $controller_file = PATH_CONTROLER . $namespace . DS . $controller . '.php';
                if (!is_file($controller_file)) {
                    exit('Controller does not exist.');
                }
                if (is_file(PATH_CONTROLER . $namespace . DS . 'Controller.php')) {
                    include_once PATH_CONTROLER . $namespace . DS . 'Controller.php';
                }
                include_once $controller_file;
            } elseif (is_file(PATH_CONTROLER . $controller . '.php')) {
                include_once PATH_CONTROLER . $controller . '.php';
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
    public static function load_template()
    {
        if (is_mobile() && !empty(self::$config['SITE_MOBILE']) && is_dir(PATH_TEMPLATE . DS . self::$config['SITE_MOBILE'])) {
            // 设置了移动端主题并且是移动端访问
            define('SITE_THEME', self::$config['SITE_MOBILE']);
        } else {
            define('SITE_THEME', is_dir(PATH_TEMPLATE . DS . self::$config['SITE_THEME']) ? self::$config['SITE_THEME'] : 'default');
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
        $path = PATH_DATA . DS . 'config' . DS . $file . '.ini.php';
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
        if (file_exists(PATH_CORE . DS . $path . DS . $classname . '.class.php')) {
            include PATH_CORE . DS . $path . DS . $classname . '.class.php';
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

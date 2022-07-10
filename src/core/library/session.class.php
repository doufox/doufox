<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * Session Class
 * 处理 Session 操作
 */
class Session
{

    /**
     * session的启动状态
     *
     * @var boolean
     */
    protected static $_start = false;

    /**
     * 构造方法
     *
     * @access public
     * @return void
     */
    public function __construct()
    {

        // 设置session的生存周期
        $this->_setTimeout();

        // 启动session
        $this->start();
        return true;
    }

    /**
     * 启动session
     *
     * @access public
     * @return boolean
     */
    public static function start()
    {

        if (self::$_start === true) {
            return true;
        }

        // 设置项目系统session的存放目录
        $sessionPath = CACHE_PATH . DS .'session' . DS;
        if (is_dir($sessionPath) && is_writable($sessionPath)) {
            session_save_path($sessionPath);
        }

        session_start();
        self::$_start = true;
        return true;
    }

    /**
     * 设置session变量的值
     *
     * @access public
     *
     * @param string $key session变量名
     * @param mixed $value session值
     *
     * @return boolean
     */
    public static function set($key, $value = null)
    {

        // 参数分析
        if (!$key) {
            return false;
        }

        // 分析是否开启session
        if (self::$_start === false) {
            self::start();
        }

        $_SESSION[$key] = $value;
        return true;
    }

    /**
     * 获取某session变量的值
     *
     * @access public
     *
     * @param string $key session变量名
     * @param mixted $default 默认值
     *
     * @return mixted
     */
    public static function get($key, $default = null)
    {

        // 参数分析
        if (!$key) {
            return isset($_SESSION) ? $_SESSION : null;
        }

        // 分析是否开启session
        if (self::$_start === false) {
            self::start();
        }

        // 当查询的session不存在时，返回默认值
        if (!isset($_SESSION[$key])) {
            return $default;
        }

        return $_SESSION[$key];
    }

    /**
     * 删除某session的值
     *
     * @access public
     * @return boolean
     */
    public static function delete($key)
    {

        // 参数分析
        if (!$key) {
            return false;
        }

        if (!isset($_SESSION[$key])) {
            return false;
        }

        unset($_SESSION[$key]);
        return true;
    }

    /**
     * 清空session值
     *
     * @access public
     * @return boolean
     */
    public static function clear()
    {

        $_SESSION = array();
        return true;
    }

    /**
     * 注销session
     *
     * @access public
     * @return boolean
     */
    public static function destory()
    {

        if (self::$_start === true) {
            unset($_SESSION);
            session_destroy();
        }

        return true;
    }

    /**
     * 停止session写入
     *
     * @access public
     * @return boolean
     */
    public static function close()
    {

        if (self::$_start === true) {
            session_write_close();
        }

        return true;
    }

    /**
     * 设置session最大存活时间.
     *
     * @access protected
     * @return boolean
     */
    protected static function _setTimeout()
    {

        // 获取session的系统配置信息
        return ini_set('session.gc_maxlifetime', 21600);
    }

    /**
     * 析构函数
     *
     * @access public
     * @return void
     */
    public function __destruct()
    {

        $this->close();
        return true;
    }
}

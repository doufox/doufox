<?php
/**
 * cookie class file
 * 用于cookie处理操作
 */

if (!defined('IN_CMS')) {
    exit();
}

class cookie
{

    /**
     * Cookie存贮默认配置信息
     *
     * @var array
     */
    protected static $_defaultConfig = array(
        'expire' => 3600,
        'path' => '/',
        'domain' => null,
    );

    /**
     * 获取某cookie变量的值
     *
     * @access public
     *
     * @param string $cookieName cookie变量名
     * @param mixed $default 默认值
     *
     * @return mixed
     */
    public static function get($cookieName = null, $default = null)
    {

        //参数分析
        if (!$cookieName) {
            return isset($_COOKIE) ? $_COOKIE : null;
        }
        $cookieName = COOKIE_PRE . $cookieName;

        return isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : $default;
    }

    /**
     * 设置某cookie变量的值
     *
     * @access public
     *
     * @param string $name cookie的变量名
     * @param mixed $value cookie值
     * @param integer $expire cookie的生存周期
     * @param string $path cookie所存放的目录
     * @param string $domain cookie所支持的域名
     *
     * @return boolean
     */
    public static function set($name, $value, $expire = null, $path = null, $domain = null)
    {

        //参数分析
        if (!$name) {
            return false;
        }
        $name = COOKIE_PRE . $name;
        $expire = is_null($expire) ? self::$_defaultConfig['expire'] : time() + $expire;
        if (is_null($path)) {
            $path = '/';
        }

        $expire = time() + $expire;
        setcookie($name, $value, $expire, $path, $domain);
        $_COOKIE[$name] = $value;

        return true;
    }

    /**
     * 删除某个Cookie变量
     *
     * @access public
     * @param string $name cookie的名称
     * @return boolean
     */
    public static function delete($name)
    {

        //参数分析
        if (!$name) {
            return false;
        }

        self::set($name, null, '-3600');
        unset($_COOKIE[COOKIE_PRE . $name]);

        return true;
    }

    /**
     * 清空cookie
     *
     * @access public
     * @return boolean
     */
    public static function clear()
    {

        if (isset($_COOKIE)) {
            unset($_COOKIE);
        }

        return true;
    }

}

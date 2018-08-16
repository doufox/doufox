<?php
/**
 * mysql数据库驱动,完成对mysql数据库的操作
 */

if (!defined('IN_CMS')) {
    exit();
}

class mysql
{

    public static $instance;
    public $db_link;

    /**
     * 构造函数
     */
    public function __construct($params = array())
    {
        // 检测参数信息是否完整
        if (!$params['host'] || !$params['username'] || !$params['dbname']) {
            exit('Mysql数据库配置文件不完整');
        }

        // 实例化mysql连接ID
        $this->db_link = @mysql_connect($params['host'], $params['username'], $params['password']);
        if (!$this->db_link) {
            exit('Mysql服务器连接失败 ');
        } else {
            if (mysql_select_db($params['dbname'], $this->db_link)) {
                //设置数据库编码
                mysql_query("SET NAMES {$params['charset']}", $this->db_link);
                if (version_compare($this->get_server_info(), '5.0.2', '>=')) {
                    mysql_query("SET SESSION SQL_MODE=''", $this->db_link);
                }

            } else {
                exit('MySQL服务器无法连接数据库表');
            }
        }
        return true;
    }

    /**
     * 执行SQL语句
     */
    public function query($sql)
    {
        $result = mysql_query($sql, $this->db_link);
        //获取当前运行的namespace、controller及action名称
        $namespace_id = xiaocms::get_namespace_id();
        $controller_id = xiaocms::get_controller_id();
        $action_id = xiaocms::get_action_id();
        $namespace_code = $namespace_id ? '[' . $namespace_id . ']' : '';

        return $result;
    }

    /**
     * 获取mysql数据库服务器信息
     */
    public function get_server_info()
    {
        return mysql_get_server_info($this->db_link);
    }

    /**
     * 获取mysql错误描述信息
     */
    public function error()
    {
        $error = ($this->db_link) ? mysql_error($this->db_link) : mysql_error();
        return function_exists('iconv') ? iconv('GBK', 'UTF-8', $error) : $error;
    }

    /**
     * 获取mysql错误信息代码
     */
    public function errno()
    {
        return ($this->db_link) ? mysql_errno($this->db_link) : mysql_errno();
    }

    /**
     * 通过一个SQL语句获取一行信息(字段型)
     */
    public function fetch_row($sql)
    {
        if (strtolower(substr($sql, 0, 6)) == 'select' && !stripos($sql, 'limit') !== false) {
            $sql .= ' LIMIT 1';
        }

        $result = $this->query($sql);
        if (!$result) {
            return false;
        }

        $rows = mysql_fetch_assoc($result);
        mysql_free_result($result);
        return $rows;
    }

    /**
     * 通过一个SQL语句获取全部信息(字段型)
     */
    public function get_array($sql)
    {
        $result = $this->query($sql);
        if (!$result) {
            return false;
        }

        $myrow = array();
        while ($row = mysql_fetch_assoc($result)) {
            $myrow[] = $row;
        }
        mysql_free_result($result);
        return $myrow;
    }

    /**
     * 获取insert_id
     */
    public function insert_id()
    {
        return ($id = mysql_insert_id($this->db_link)) >= 0 ? $id : mysql_result($this->query("SELECT last_insert_id()"));
    }

    /**
     * 字段的数量
     */
    public function num_fields($sql)
    {
        $result = $this->query($sql);
        return mysql_num_fields($result);
    }

    /**
     * 结果集中的数量
     */
    public function num_rows($sql)
    {
        $result = $this->query($sql);
        return mysql_num_rows($result);
    }

    /**
     * 获取字段类型
     */
    public function get_fields_type($table_name)
    {
        if (!$table_name) {
            return false;
        }

        $res = mysql_query("SELECT * FROM {$table_name}");
        $types = array();
        while ($row = mysql_fetch_field($res)) {
            $types[$row->name] = $row->type;
        }
        mysql_free_result($res);
        return $types;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        if ($this->db_link) {
            @mysql_close($this->db_link);
        }

    }

    /**
     * 单例模式
     */
    public static function getInstance($params)
    {
        if (!self::$instance) {
            self::$instance = new self($params);
        }
        return self::$instance;
    }
}

<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * 数据库
 */
class DatabaseController extends API
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 系统基本配置
     */
    public function indexAction()
    {
        $this->response(401, null, 'error');
    }

    /**
     * 检测数据库是否可用
     */
    public function testAction()
    {
        // 测试连接
        $db_host = $_POST['tdb_host'];
        $db_username = $_POST['tdb_username'];
        $db_password = $_POST['tdb_password'];
        $db_name = $_POST['tdb_name'];
        $db_prefix = $_POST['tdb_prefix'];
        if (!mysql_connect($db_host, $db_username, $db_password)) {
            exit("<script>alert('无法连接到数据库, 请检查数据库配置信息');</script>");
        }

        if (!mysql_select_db($db_name)) {
            if (!mysql_query("CREATE DATABASE " . $db_name)) {
                exit("<script>alert('无法创建数据库\n\n请通过其他方式建立数据库');</script>");
            }

            mysql_select_db($db_name);
        }
        $tables = array();
        $query = mysql_list_tables($db_name);
        while ($r = mysql_fetch_row($query)) {
            $tables[] = $r[0];
        }
        if (is_array($tables) && in_array($db_prefix . 'content', $tables)) {
            exit('<script>alert("注意：检测到已有相同前缀的数据表");</script>');
        }
        exit('<script>alert("数据库连接正常");</script>');
    }
}

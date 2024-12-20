<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * 系统安装模块
 */
class IndexController
{
    public $status; // 状态

    public function __construct()
    {
        $this->status = 'default';
        if (file_exists(PATH_DATA . DS . 'installed')) {
            $this->status = 'success';
            include $this->views('install/installed');
            exit();
        }
        if (!is_writable(PATH_DATA)) {
            exit('系统数据目录（/' . DIR_DATA . '/）没有读写权限, 安装程序无法进行 !');
        }
    }

    public function indexAction()
    {
        $step = trim($_REQUEST['step']) ? trim($_REQUEST['step']) : 1;
        switch ($step) {
            case '1': // 安装许可协议
                include $this->views('install/1');
                break;
            case '2': // 环境检测 填写配置信息
                if (PHP_VERSION < '5.2.0') {
                    $error = '服务器环境PHP版本低于5.2, 无法进行安装！';
                }
                if (!function_exists("session_start")) {
                    $error = '服务器环境不支持session, 无法进行安装！';
                }
                if (!extension_loaded('mysql') && !extension_loaded('mysqli') && !extension_loaded('mariadb')) {
                    $error = '服务器环境不支持mysql, 无法进行安装！';
                }
                if (!function_exists('imagejpeg')) {
                    $error = '服务器环境不支持GD库(jpeg), 无法进行安装！';
                }
                if (!function_exists('imagegif')) {
                    $error = '服务器环境不支持GD库(gif), 无法进行安装！';
                }
                if (!function_exists('imagepng')) {
                    $error = '服务器环境不支持GD库(png), 无法进行安装！';
                }
                if (!function_exists('json_decode')) {
                    $error = '服务器环境不支持JSON, 无法进行安装！';
                }
                if (!is_writable(PATH_DATA)) {
                    $error = '系统目录data没有写入权限, 无法进行安装！';
                }
                if (!is_writable(PATH_ROOT . DS . 'upload')) {
                    $error = '系统目录upload没有写入权限, 无法进行安装！';
                }
                include $this->views('install/2');
                break;
            case '3': // 安装
                function dexit($msg)
                {
                    echo '<script>alert("' . $msg . '");window.history.back();</script>';
                    exit;
                }
                $tdb_host     = $_POST['db_host'];
                $tdb_username = $_POST['db_username'];
                $tdb_password = $_POST['db_password'];
                $tdb_name     = $_POST['db_name'];
                $tdb_prefix   = $_POST['db_prefix'];
                // $import    = $_POST['import'];
                $username     = $_POST['username'];
                $password     = $_POST['password'];

                if (!preg_match('/^[a-z0-9]+$/i', $username) || strlen($password) < 5) {
                    dexit('超级管理员帐号不符合要求');
                }
                if (strlen($password) < 5) {
                    dexit('超级管理员的密码最少5位');
                }
                if (!@mysql_connect($tdb_host, $tdb_username, $tdb_password)) {
                    dexit('无法连接到数据库, 请检查数据库配置信息');
                }
                $tdb_name or dexit('连接正常\n\n不过您没有填写数据库名');
                if (!mysql_select_db($tdb_name)) {
                    if (!mysql_query("CREATE DATABASE " . $tdb_name)) {
                        dexit('无法创建数据库\n\n请通过其他方式建立数据库');
                    }
                }
                mysql_query('SET NAMES utf8mb4');

                // 保存数据库配置文件
                $content = "<?php" . PHP_EOL . "if (!defined('IN_CRONLITE')) exit();" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL . PHP_EOL;
                $content .= "    'db_host'     => '{$tdb_host}'," . PHP_EOL;
                $content .= "    'db_username' => '{$tdb_username}'," . PHP_EOL;
                $content .= "    'db_password' => '{$tdb_password}'," . PHP_EOL;
                $content .= "    'db_name'     => '{$tdb_name}'," . PHP_EOL;
                $content .= "    'db_prefix'   => '{$tdb_prefix}'," . PHP_EOL;
                $content .= "    'db_charset'  => 'utf8mb4'" . PHP_EOL;
                $content .= PHP_EOL . ");";
                if (!file_put_contents(PATH_DATA . DS . 'config' . DS . 'database.ini.php', $content)) {
                    dexit('数据库配置文件保存失败, 请检查文件权限！');
                }

                // // 保存管理员配置文件
                // $admincontent  = "<?php" . PHP_EOL . "if (!defined('IN_CRONLITE')) exit();" . PHP_EOL . PHP_EOL . "return array(" . PHP_EOL . PHP_EOL;
                // $admincontent .= " 'ADMIN_NAME' => '" . $username . "', " . PHP_EOL;
                // $admincontent .= " 'ADMIN_PASS' => '" . md5(md5($password)) . "', " . PHP_EOL;
                // $admincontent .= PHP_EOL . ");";
                // if (!file_put_contents(PATH_DATA . DS . 'config' . DS . 'admin.ini.php', $admincontent)) {
                //     dexit('数据库配置文件保存失败, 请检查文件权限！');
                // }

                // 导入表结构
                $sql = file_get_contents(PATH_VIEW . 'install' . DS . 'initdata.sql');
                // 表前缀处理
                $sql = str_replace('doufox_', $tdb_prefix, $sql);
                // 超级管理员默认帐号密码
                $sql = preg_replace("/\s*'admin'\s*,\s*'c3284d0f94606de1fd2af172aba15bf3'/", " '" . $username . "', '" . md5(md5($password)) . "'", $sql);
                $time = time();
                $this->installsql($sql, $time);
                // 展示安装成功页
                $time = md5($time); // 成功页验证时间戳
                include $this->views('install/3');
                break;
            case 'db_test':
                // 测试连接
                $tdb_host     = $_POST['tdb_host'];
                $tdb_username = $_POST['tdb_username'];
                $tdb_password = $_POST['tdb_password'];
                $tdb_name     = $_POST['tdb_name'];
                $tdb_prefix   = $_POST['tdb_prefix'];
                if (!mysql_connect($tdb_host, $tdb_username, $tdb_password)) {
                    exit("<script>alert('无法连接到数据库, 请检查数据库配置信息');</script>");
                }

                if (!mysql_select_db($tdb_name)) {
                    if (!mysql_query("CREATE DATABASE " . $tdb_name)) {
                        exit("<script>alert('无法创建数据库\n\n请通过其他方式建立数据库');</script>");
                    }

                    mysql_select_db($tdb_name);
                }
                $tables = array();
                $query = mysql_list_tables($tdb_name);
                while ($r = mysql_fetch_row($query)) {
                    $tables[] = $r[0];
                }
                if (is_array($tables) && in_array($tdb_prefix . 'content', $tables)) {
                    exit('<script>alert("注意：系统检测到已有相同前缀的数据表\n\n如果继续安装将会清空现有数据\n\n如果需要保留现有数据, 请修改数据表前缀");</script>');
                }
                exit('<script>alert("数据库连接正常");</script>');

                break;
        }
    }

    // 执行sql语句
    private function installsql($sql, $time)
    {
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));

        foreach ($queriesarray as $query) {
            $queries = explode('\n', trim($query));
            foreach ($queries as $query) {
                $ret[$num] .= $query[0] == '#' || $query[0] . $query[1] == '--' ? '' : $query;
            }
            $num++;
        }
        unset($sql);
        foreach ($ret as $query) {
            if (trim($query) != '') {
                mysql_query($query) or die(exit('数据导入出错<hr>' . mysql_error() . '<br>SQL语句：<br>' . $query));
            }
        }
        file_put_contents(PATH_DATA . DS . 'installed', $time);
    }

    /** 加载视图模板文件，系统内置默认模板
     * @param string $file 文件名 如 admin/login、install/footer
     */
    protected function views($file)
    {
        return PATH_VIEW . $file . '.tpl.php';
    }
}

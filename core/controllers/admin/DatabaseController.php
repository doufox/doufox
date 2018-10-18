<?php

class DatabaseController extends Admin
{

    /*
     * 数据备份
     */
    public function indexAction()
    {
        $action = $this->get('action');
        $size = $this->get('size');
        if ($this->isPostForm()) {
            $size = 2048; //每个分卷文件大小
            $tables = $this->post('table');
            if (empty($tables)) {
                $this->show_message('您还没有选择要备份的表。');
            }

            set_cache('bakup_tables', array('tables' => $tables, 'time' => time()));
            $this->show_message('正在备份数据...', 1, url('admin/database/index', array('action' => 1, 'size' => $size)));
        }
        if ($action) {
            $fileid = $this->get('fileid');
            $random = $this->get('random');
            $tableid = $this->get('tableid');
            $startfrom = $this->get('startfrom');
            $this->export_database($size, $action, $fileid, $random, $tableid, $startfrom);
        } else {
            $data = $this->getTables();
            include $this->admin_tpl('database_list');
        }
    }

    /*
     * 数据恢复
     */
    public function importAction()
    {
        $file_list = cms::load_class('file_list');

        $dir = DATA_PATH . 'bakup' . DS;
        $path = $this->get('path');
        if ($path && is_dir($dir . $path)) {
            $fileid = $this->get('fileid');
            $this->importdb($path, $fileid);
            exit;
        }
        if ($this->isPostForm()) {
            $paths = $this->post('paths');
            if (is_array($paths)) {
                foreach ($paths as $path) {
                    $file_list->delete_dir($dir . $path);
                    @rmdir($dir . $path);
                }
            }
            $this->show_message('操作成功', 1, url('admin/database/import'));
        }
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }

        $data = $file_list->get_file_list($dir); //扫描备份目录
        $list = array();
        if ($data) {
            foreach ($data as $path) {
                if (!in_array($path, array('.', '..')) && is_dir($dir . $path)) {
                    $size = 0;
                    $_dir = scandir($dir . $path);
                    foreach ($_dir as $c) {
                        $size += filesize($dir . $path . DS . $c);
                    }
                    $sqldir = DS . DATA_DIR . DS . 'bakup' . DS . $path . DS;
                    $list[] = array('path' => $path, 'size' => formatFileSize($size, 2), 'sqldir' => $sqldir);
                    clearstatcache();
                }
            }
        }
        include $this->admin_tpl('database_import');
    }

    /*
     * 修复表
     */
    public function repairAction()
    {
        $name = $this->get('name');
        $this->content->query("repair table $name");
        $this->show_message('修复成功', 1, url('admin/database/index'));
    }

    /*
     * 优化表
     */
    public function optimizeAction()
    {
        $name = $this->get('name');
        $this->content->query("optimize table $name");
        $this->show_message('修复成功', 1, url('admin/database/index'));
    }

    /*
     * 表结构
     */
    public function structureAction()
    {
        $name = $this->get('name');
        $data = $this->content->execute("SHOW CREATE TABLE $name", false);
        echo '<div class="subnav"><pre>' . $data['Create Table'] . '</pre></div>';
    }

    /*
     * 表数据
     */
    public function selectAction()
    {
        $name = $this->get('name');
        $data = $this->content->execute("SELECT * FROM $name LIMIT 10");
        if (empty($data)) {
            exit('合计： 0 条数据');
        }
        echo '合计：' . count($data) . ' 条数据（最多 10 条）';
        echo '<style>';
        echo 'table {border-collapse: collapse;border-spacing: 0;}';
        echo 'td {white-space: nowrap;padding: 5px;}';
        echo '</style>';
        echo '<div class="subnav"><table border="1">';
        foreach ($data as $v) {
            echo '<tr>';
            foreach ($v as $i) {
                echo '<td>' .$i. '</td>';
            }
            echo '</tr>';
        }
        echo '</table></div>';
    }

    /*
     * 取当前数据库中的所有表信息
     */
    private function getTables()
    {
        $data = $this->content->execute('SHOW TABLE STATUS FROM `' . $this->content->dbname . '`');
        foreach ($data as $key => $t) {
            $data[$key]['tables_sys'] = substr($t['Name'], 0, strlen($this->content->prefix)) != $this->content->prefix ? 0 : 1;
        }
        return $data;
    }

    /**
     * 数据库导出方法
     * @param  $sizelimit 卷大小
     * @param  $action 操作
     * @param  $fileid 卷标
     * @param  $random 随机字段
     * @param  $tableid
     * @param  $startfrom
     */
    private function export_database($sizelimit, $action, $fileid, $random, $tableid, $startfrom)
    {
		if (function_exists('set_time_limit')) {
			set_time_limit(0);
		} else {
			ini_set('max_execution_time', 0);
		}
        $dumpcharset = 'utf8';
        $fileid = ($fileid != '') ? $fileid : 1;
        $c_data = get_cache('bakup_tables');
        $tables = $c_data['tables'];
        $time = $c_data['time'];
        if (empty($tables)) {
            $this->show_message('数据缓存不存在，请重新选择备份');
        }

        if ($fileid == 1) {
            $random = mt_rand(1000, 9999);
        }

        $this->content->query("SET NAMES 'utf8';\n\n");
        $tabledump = '';
        $tableid = ($tableid != '') ? $tableid : 0;
        $startfrom = ($startfrom != '') ? intval($startfrom) : 0;
        for ($i = $tableid; $i < count($tables) && strlen($tabledump) < $sizelimit * 1000; $i++) {
            $offset = 100;
            if (!$startfrom) {
                $tabledump .= "DROP TABLE IF EXISTS `$tables[$i]`;\n";
                $createtable = $this->content->execute("SHOW CREATE TABLE `$tables[$i]` ", false);
                $tabledump .= $createtable['Create Table'] . ";\n\n";
                $tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=[a-zA-Z0-9]+/", "DEFAULT CHARSET=utf8", $tabledump);
            }
            $numrows = $offset;
            while (strlen($tabledump) < $sizelimit * 1000 && $numrows == $offset) {
                $sql = "SELECT * FROM `$tables[$i]` LIMIT $startfrom, $offset";
                $numfields = $this->content->num_fields($sql);
                $numrows = $this->content->num_rows($sql);
                //获取表字段
                $fields_data = $this->content->execute("SHOW COLUMNS FROM `$tables[$i]`");
                $fields_name = array();
                foreach ($fields_data as $r) {
                    $fields_name[$r['Field']] = $r['Type'];
                }
                $rows = $this->content->execute($sql);
                $name = array_keys($fields_name);
                $r = array();
                if ($rows) {
                    foreach ($rows as $row) {
                        $r[] = $row;
                        $comma = "";
                        $tabledump .= "INSERT INTO `$tables[$i]` VALUES(";
                        for ($j = 0; $j < $numfields; $j++) {
                            $tabledump .= $comma . "'" . mysql_escape_string($row[$name[$j]]) . "'";
                            $comma = ",";
                        }
                        $tabledump .= ");\n";
                    }
                }
                $startfrom += $offset;
            }
            $tabledump .= "\n";
            $startfrom = $numrows == $offset ? $startfrom : 0;
        }
        $i = $startfrom ? $i - 1 : $i;
        $dir = DATA_PATH . 'bakup' . DS;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
            file_put_contents($dir . 'index.html', '');
        }
        $bakfile_path = $dir . DS . $time . DS;
        if (trim($tabledump)) {
            $tabledump = "# name: " . APP_NAME . " db bakup file\n# version: " . APP_VERSION . " \n# time: " . date('Y-m-d H:i:s') . "\n# ------------------------\n\n\n" . $tabledump;
            $tableid = $i;
            $filename = 'tables_' . date('Ymd') . '_' . $random . '_' . $fileid . '.sql';
            $altid = $fileid;
            $fileid++;
            if (!is_dir($bakfile_path)) {
                mkdir($bakfile_path, 0777);
            }

            $bakfile = $bakfile_path . $filename;
            file_put_contents($bakfile, $tabledump);
            @chmod($bakfile, 0777);
            $url = url('admin/database/index', array('size' => $sizelimit, 'action' => $action, 'fileid' => $fileid, 'random' => $random, 'tableid' => $tableid, 'startfrom' => $startfrom));
            $this->show_message("备份$filename", 1, $url);
        } else {
            file_put_contents($bakfile_path . 'index.html', '');
            delete_cache('bakup_tables');
            $this->show_message("备份完成", 1, url('admin/database/index'));
        }
    }

    /**
     * 数据库恢复
     */
    private function importdb($path, $fileid = 1)
    {
        $dir = DATA_PATH . 'bakup' . DS;
        $fid = $fileid ? $fileid : 1;

        $data = scandir($dir . $path); //扫描备份目录
        $list = array();
        foreach ($data as $t) {
            if (is_file($dir . $path . DS . $t) && substr($t, -3) == 'sql') {
                $id = substr(strrchr($t, '_'), 1, -4);
                $list[$id] = $t;
            }
        }
        if (!isset($list[$fid])) {
            $this->show_message('恢复完毕', 1, url('admin/database/index'));
        }

        $file = $list[$fid];
        $sql = file_get_contents($dir . $path . DS . $file);
        $this->sql_execute($sql);
        $fid++;
        $this->show_message('恢复数据库文件卷' . $file, 1, url('admin/database/import', array('path' => $path, 'fileid' => $fid)));
    }

    /**
     * 执行SQL
     * @param  $sql
     */
    private function sql_execute($sql)
    {
        $sqls = $this->sql_split($sql);
        $result = 0;
        if (is_array($sqls)) {
            foreach ($sqls as $sql) {
                if (trim($sql) != '') {
                    $this->content->query($sql);
                    $result += mysql_affected_rows();
                }
            }
        } else {
            $this->content->query($sqls);
            $result += mysql_affected_rows();
        }
        return $result;
    }

    private function sql_split($sql)
    {
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach ($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach ($queries as $query) {
                $str1 = substr($query, 0, 1);
                if ($str1 != '#' && $str1 != '-') {
                    $ret[$num] .= $query;
                }

            }
            $num++;
        }
        return ($ret);
    }

}

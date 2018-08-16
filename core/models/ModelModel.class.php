<?php

class ModelModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'modelid';
    }

    public function set($modelid = 0, $data)
    {
        if ($modelid) {
            // 修改模型
            $this->update($data, 'modelid=' . $modelid);
            return $modelid;
        }
        // 添加模型入库
        $this->insert($data);
        $modelid = $this->get_insert_id();
        if (empty($modelid)) {
            return false;
        }

        // 根据类别创建表
        $table = $this->prefix . $data['tablename'];
        if ($data['typeid'] == 1) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . $table . "` (`id` MEDIUMINT( 8 ) NOT NULL ,`catid` SMALLINT( 5 ) NOT NULL ,`content` MEDIUMTEXT NOT NULL ,PRIMARY KEY (`id`), KEY `catid` (`catid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            $this->query($sql);
            //内容表默认字段
            $this->query("INSERT INTO `" . $this->prefix . "model_field` (fieldid,modelid,field,name,formtype,isshow) VALUES (NULL, $modelid,'content','内容 ','editor',1)");
        } elseif ($data['typeid'] == 2) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . $table . "` (`id` MEDIUMINT( 8 ) NOT NULL ,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            $this->query($sql);
        } elseif ($data['typeid'] == 3) {
            $sql = "CREATE TABLE IF NOT EXISTS `" . $table . "` (`id` mediumint(8) NOT NULL AUTO_INCREMENT,`cid` mediumint(8) NOT NULL,`userid` mediumint(8) NOT NULL,`username` char(20) NOT NULL,`listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',`status` tinyint(2) unsigned NOT NULL DEFAULT '1',`time` int(10) unsigned NOT NULL DEFAULT '0', `ip` char(20) NULL,PRIMARY KEY (`id`),KEY `listorder` (`listorder`),KEY `status` (`status`),KEY `time` (`time`),KEY `userid` (`userid`),KEY `cid` (`cid`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
            $this->query($sql);
        }
        // 创建Model
        $this->create_model($data['tablename']);
        return $modelid;
    }

    // 删除模型
    public function del($data)
    {
        $table = $this->prefix . $data['tablename'];
        $this->query('DROP TABLE IF EXISTS `' . $table . '`');
        $this->delete('modelid=' . $data['modelid']);
        $this->del_model($data['tablename']);
        $this->query('DELETE FROM `' . $this->prefix . 'model_field` where modelid=' . $data['modelid']);
    }

    // 创建模型
    protected function create_model($table)
    {
        $table = ucfirst($table);

        $content = "<?php" . PHP_EOL . PHP_EOL .
            "class " . $table . "Model extends Model {" . PHP_EOL . PHP_EOL .
            "    public function get_primary_key() {" . PHP_EOL .
            "        return \$this->primary_key = 'id';" . PHP_EOL .
            "    }" . PHP_EOL . PHP_EOL .
            "    public function get_fields() {" . PHP_EOL .
            "        return \$this->get_table_fields();" . PHP_EOL .
            "    }" . PHP_EOL . PHP_EOL .
            "}";
        $file = MODEL_DIR . $table . 'Model.class.php';
        file_put_contents($file, $content);
    }

    // 删除模型文件
    protected function del_model($table)
    {
        $table = ucfirst($table);

        $file = MODEL_DIR . $table . 'Model.class.php';
        if (file_exists($file)) {@unlink($file);}
    }
}

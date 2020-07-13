<?php
if (!defined('IN_CMS')) {
    exit();
}

class Model_fieldModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'fieldid';
    }

    public function set($fieldid = 0, $data)
    {
        if ($fieldid) {
            // 修改字段
            $this->update($data, 'fieldid=' . $fieldid);
            return true;
            exit;
        }
        $this->insert($data);
        $id = $this->get_insert_id();
        if (!$id) {
            return false;
        }

        $model = $this->from('model')->where('modelid=' . $data['modelid'])->select(false);
        if (empty($model)) {
            $this->delete('fieldid=' . $id);
            return false;
        };
        if (in_array($data['formtype'], array('merge')) || $data['merge']) {
            return true;
        }
        // 不处理的字段
        if (in_array($data['formtype'], array('editor', 'checkbox', 'files', 'fields'))) {
            $data['type'] = 'TEXT';
        }

        if ($data['formtype'] == 'date') {
            $data['type'] = 'INT';
            $data['length'] = 10;
        }
        if ($data['formtype'] == 'input') {
            $data['type'] = 'VARCHAR';
            $data['length'] = 255;
        }
        if ($data['formtype'] == 'image') {
            $data['type'] = 'VARCHAR';
            $data['length'] = 255;
        }
        if ($data['formtype'] == 'file') {
            $data['type'] = 'VARCHAR';
            $data['length'] = 255;
        }
        // 添加字段到附表
        $table = $this->prefix . $model['tablename'];
        if (in_array($data['type'], array('INT', 'TINYINT', 'SMALLINT', 'MEDIUMINT', 'CHAR', 'VARCHAR'))) {
            $length = $data['length'] ? $data['length'] : 255;
            $length = $data['length'] < 255 ? $data['length'] : 255;
            $sql = "ALTER TABLE `" . $table . "` ADD `" . $data['field'] . "` " . $data['type'] . " (" . $length . ") NULL";
        } elseif (in_array($data['type'], array('CHAR', 'VARCHAR'))) {
            $length = $data['length'] ? $data['length'] : 255;
            $length = $data['length'] < 255 ? $data['length'] : 255;
            $sql = "ALTER TABLE `" . $table . "` ADD `" . $data['field'] . "` " . $data['type'] . " (" . $length . ") CHARACTER SET utf8 COLLATE utf8_general_ci NULL";
        } elseif (in_array($data['type'], array('DECIMAL', 'FLOAT', 'DOUBLE'))) {
            $length = strpos($data['length'], ',') === false ? $data['length'] . ',0' : $data['length'];
            $sql = "ALTER TABLE `" . $table . "` ADD `" . $data['field'] . "` " . $data['type'] . " (" . $length . ") NULL";
        } else {
            $sql = "ALTER TABLE `" . $table . "` ADD `" . $data['field'] . "` " . $data['type'] . " CHARACTER SET utf8 COLLATE utf8_general_ci NULL";
        }
        $this->query($sql);
        if ($data['indexkey']) {
            $sql = "ALTER TABLE `" . $table . "` ADD " . $data['indexkey'] . " (`" . $data['field'] . "`) ";
            $this->query($sql);
        }
        return true;
    }

    public function del($data)
    {
        $this->delete('fieldid=' . $data['fieldid']);
        if (in_array($data['formtype'], array('merge')) || $data['merge']) {
            return true;
        }
        // 不处理的字段
        // 删除附表结构
        $model = $this->from('model')->where('modelid=' . $data['modelid'])->select(false);
        if (empty($model)) {
            return false;
        }

        $table = $this->prefix . $model['tablename'];
        $sql = "ALTER TABLE `" . $table . "` DROP `" . $data['field'] . "`";
        $this->query($sql);
        return true;
    }
}

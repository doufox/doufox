<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class ContentModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'id';
    }

    public function get_fields()
    {
        return $this->get_table_fields();
    }

    public function set($id, $tablename, $data)
    {
        if (!$this->is_table_exists($tablename)) {
            return $tablename . '表不存在';
        }

        $table = core::load_model($tablename); // 加载附表Model
        if (empty($data['catid'])) {
            return '请选择发布栏目';
        }

        // 将数组转换为字符串
        foreach ($data as $i => $t) {
            if (is_array($t)) {
                $data[$i] = array2string($t);
            }
        }
        // 描述截取
        if (empty($data['description']) && isset($data['content'])) {
            $len = isset($data['add_introduce']) && $data['add_introduce'] && $data['introcude_length'] ? $data['introcude_length'] : 200;
            $data['description'] = str_replace(array(' ', PHP_EOL, '　　'), array('', '', ''), strcut(clearhtml($data['content']), $len));
        }
        // 提取缩略图
        if (empty($data['thumb']) && isset($data['content']) && isset($data['auto_thumb']) && $data['auto_thumb']) {
            $content = htmlspecialchars_decode($data['content']);
            if (preg_match('/<img(.+)>/Ui', $content, $img)) {
                $img = str_replace(array('\\', '"'), array('', '\''), $img[1]);
                if (preg_match('/src=\'(.+)\'/Ui', $img, $src)) {
                    $data['thumb'] = $src[1];
                }
            }
        }
        // 关键字处理
        if ($data['keywords']) {
            $data['keywords'] = str_replace('，', ',', $data['keywords']);
        }
        if ($id) {
            // 修改
            $this->update($data, 'id=' . $id);
            $table->update($data, 'id=' . $id);
        } else {
            // 添加
            $this->insert($data);
            $id = $this->get_insert_id();
            if (empty($id)) {
                return '发布失败';
            }

            $data['id'] = $id;
            $table->insert($data);
        }

        return $id;
    }

    /**
     * 删除
     */
    public function del($id, $catid)
    {
        $cat = get_cache('category');
        $table = $cat[$catid]['tablename'];
        if (empty($table) || empty($id)) {
            return false;
        }

        $data = $this->find($id);
        if (empty($data)) {
            return false;
        }

        $this->delete('id=' . $id);
        $this->query('delete from ' . $this->prefix . $table . ' where id=' . $id);

        // 删除静态文件
        $filehtml = substr($data['url'], strlen(Controller::get_base_url()));
        $filehtml = substr($filehtml, 0, 9) == 'index.php' ? null : $filehtml;
        if ($filehtml && file_exists(PATH_ROOT . DS . $filehtml)) {
            @unlink($filehtml);
        }

        // 删除缩略图
        if ($data['thumb'] && file_exists(PATH_ROOT . DS . $data['thumb'])) {
            @unlink(PATH_ROOT . DS . $data['thumb']);
        }

        $ext = substr(strrchr(trim($data['thumb']), '.'), 1);
        $site_config = core::get_site_config();
        $thumb = $data['thumb'] . '.thumb.' . $site_config['SITE_THUMB_WIDTH'] . 'x' . $site_config['SITE_THUMB_HEIGHT'] . '.' . $ext;
        if (file_exists(PATH_ROOT . DS . $thumb)) {
            @unlink(PATH_ROOT . DS . $thumb);
        }

        // 删除关联表单数据
        $mods = get_cache('contentmodel');
        $mod = $mods[$data['modelid']];
        if ($mod['joinid']) {
            $form = get_cache('formmodel');
            $join = $form[$mod['joinid']];
            if ($join) {
                $this->query('delete from ' . $this->prefix . $join['tablename'] . ' where cid=' . $id);
            }
        }
    }

    /**
     * 更新URL地址
     */
    public function url($id, $url)
    {
        $this->update(array('url' => $url), 'id=' . $id);
    }
}

<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class CategoryModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'catid';
    }

    public function set($catid, $data)
    {
        unset($data['catid']);
        if ($catid) {
            unset($data['typeid'], $data['modelid']);
            $this->update($data, 'catid=' . $catid);
            $this->repair();
            return $catid;
        } else {
            $this->insert($data);
        }
        $catid = $this->get_insert_id();
        $this->repair();
        return empty($catid) ? '添加失败' : $catid;
    }

    /**
     * 删除栏目及数据
     * @param int $catid
     * @return boolean
     */
    public function del($catid)
    {
        if (empty($catid)) {
            return false;
        }

        $this->repair($catid); // 修复该栏目数据
        $data = $this->child($catid, true);
        if (empty($data)) {
            return false;
        }

        // 转换为数组
        $catids = explode(',', $data);
        // 加载栏目缓存文件
        $category = get_cache('category');
        foreach ($catids as $catid) {
            if (empty($catid)) {
                continue;
            }

            // 删除栏目数据
            $this->delete('catid=' . $catid);
            // 删除内容表数据
            if ($category[$catid]['tablename']) {
                $this->query('DELETE FROM `' . $this->prefix . 'content` WHERE `catid`=' . $catid);
                $this->query('DELETE FROM `' . $this->prefix . $category[$catid]['tablename'] . '` WHERE `catid`=' . $catid);
            }
        }
        return true;
    }

    /**
     * 递归查找所有子栏目ID
     * @param int $catid
     * @param boolean $parent
     * @param int $typeid
     * @return string
     */
    public function child($catid, $parent = false, $typeid = 0)
    {
        $data = $this->find($catid);
        if (empty($data)) {
            return false;
        }

        $str = '';
        if ($data['child'] && $data['arrchildid']) { // 存在子栏目
            if ($parent && ($typeid ? $typeid == $data['typeid'] : true)) {
                $str .= $catid . ',';
            }

            $arrchildid = $data['arrchildid'];
            $ids = array();
            if ($arrchildid) {
                $ids = explode(',', $arrchildid);
            }

            foreach ($ids as $id) {
                $str .= $this->child($id, $parent, $typeid);
            }
        } else {
            if ($typeid ? $typeid == $data['typeid'] : true) {
                $str .= $catid . ',';
            }
        }
        return $str;
    }

    /**
     * 递归修复所有栏目的子类id和同级分类id
     * @param int $parentid
     */
    public function repair($parentid = 0)
    {
        $data = $this->where('parentid=?', $parentid)->order('listorder ASC')->select();
        foreach ($data as $t) {
            // 检查该栏目下是否有子栏目
            $catid = $t['catid'];
            $parentid = $t['parentid'];
            // 当前栏目的所有父栏目ID(arrparentid)
            $arrparentid = array();
            foreach ($data as $s) {
                $arrparentid[] = $s['catid'];
            }
            // 组合父栏目ID
            $arrparentid = implode(',', $arrparentid);
            // 查询子栏目
            $s_data = $this->where('parentid=?', $t['catid'])->order('listorder ASC')->select();
            if ($s_data) { // 存在子栏目
                // 当前栏目的所有子栏目ID($arrchildid)
                $arrchildid = array();
                foreach ($s_data as $s) {
                    $arrchildid[] = $s['catid'];
                }
                // 组合子栏目ID
                $arrchildid = implode(',', $arrchildid);
                $this->update(array('child' => 1, 'arrchildid' => $arrchildid, 'arrparentid' => $arrparentid), 'catid=' . $catid);
                $this->repair($catid); // 递归调用
            } else { // 没有子栏目
                $this->update(array('child' => 0, 'arrchildid' => '', 'arrparentid' => $arrparentid), 'catid=' . $catid);
            }
        }
    }

    /**
     * 验证栏目路径是否存在
     * @param int $catid
     * @param string $catpath
     * @return boolean
     */
    public function check_catpath($catid = 0, $catpath)
    {
        if (empty($catpath)) {
            return true;
        }

        $this->where('catpath=?', $catpath);
        if ($catid) {
            $this->where('catid<>?', $catid);
        }

        $data = $this->select(false);
        return empty($data) ? false : true;
    }

    /**
     * 设置栏目URL
     */
    public function url($id, $url)
    {
        $this->update(array('url' => $url), 'catid=' . $id);
    }

    /**
     * 递归查询所有父级栏目信息
     * @param int $catid 当前栏目ID
     * @return array
     */
    public function getParentData($catid)
    {
        $cat = $this->find($catid);
        if ($cat['parentid']) {
            $cat = $this->getParentData($cat['parentid']);
        }

        return $cat;
    }

    /**
     * 获取子栏目ID列表
     */
    private function getArrchildid($catid, $data)
    {
        $arrchildid = $catid;
        foreach ($data as $m) {
            if ($m['catid'] != $catid && $m['parentid'] == $catid) {
                $arrchildid .= ',' . $this->getArrchildid($m['catid'], $data);
            }
        }
        return $arrchildid;
    }
}

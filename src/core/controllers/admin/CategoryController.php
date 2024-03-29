<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class CategoryController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if ($this->isPostForm()) {
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int) str_replace('order_', '', $var);
                    $this->category->update(array('listorder' => $value), 'catid=' . $id);
                }
            }
        }

        $content_models = get_cache('contentmodel');
        $page_models = get_cache('pagemodel');
        $tree = core::load_class('tree');
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys = array();
        $result = $this->category->order('listorder ASC')->select();
        // 栏目类型
        $types = array(
            1 => '', // 内容模型
            2 => '', // 单页模型
            3 => '<font color="blue">外部链接</font>',
            4 => '<font color="green">独立单页</font>',
        );
        if (!empty($result)) {
            foreach ($result as $r) {
                $r['typename'] = $types[$r['typeid']]; // 栏目类型
                if ($r['typeid'] == 1) {
                    $r['typename'] = @$content_models[$r['modelid']]['modelname']; // 读取模型
                } else if ($r['typeid'] == 2) {
                    $r['typename'] = @$page_models[$r['modelid']]['modelname']; // 读取模型
                }

                $r['manage_edit'] = '<a href="' . url('admin/category/edit', array('catid' => $r['catid'])) . '">编辑</a>';
                $r['manage_add'] = '<a href="' . url('admin/category/add', array('catid' => $r['catid'])) . '" >添加子栏目</a>';
                $r['manage_del'] = '<a href="#" class="category-btn-delete" name="删除栏目" data-id="' . $r['catid'] . '" data-name="' . $r['catname'] . '">删除</a>';
                $r['isdisplay'] = $r['ismenu'] ? '是' : '<font color="blue">否</font>';
                $r['catname'] = "<a href='$r[url]' target='_blank'>" . $r['catname'] . "</a>";
                $r['manage_content'] = '<a href="' . url('admin/content/index', array('catid' => $r['catid'])) . '" >' . $r['items'] . '</a>';
                $categorys[$r['catid']] = $r;
            }
        }
        $str = "
        <tr>
            <td><input name='order_\$catid' type='text' size='1' value='\$listorder' class='input-text-c'></td>
            <td>\$catid</td>
            <td>\$spacer\$catname</td>
            <td>\$catpath</td>
            <td>\$typename</td>
            <td>\$manage_content</td>
            <td>\$isdisplay</td>
            <td>\$manage_edit \$manage_add \$manage_del</td>
        </tr>";
        $tree->init($categorys);
        $categorys = $tree->get_tree(0, $str);
        $msg = '';
        include $this->views('admin/category/list');
    }

    /**
     * 添加栏目
     */
    public function addAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if ($data['typeid'] == 1) {
                if (empty($data['modelid'])) {
                    $this->show_message('请选择内容模型');
                }
            } elseif ($data['typeid'] == 2) {
                // if (empty($data['content'])) {
                //     $this->show_message('单网页内容不能为空');
                // }
            } elseif ($data['typeid'] == 3) {
                if (empty($data['http'])) {
                    $this->show_message('没有输入外部连接地址');
                }
            }  elseif ($data['typeid'] == 4) {
                // if (empty($data['content'])) {
                //     $this->show_message('独立网页内容不能为空');
                // }
            } else {
                $this->show_message('请选择栏目类型');
            }
            if ($this->post('addall')) {
                // 批量添加
                $names = $this->post('names');
                if (empty($names)) {
                    $this->show_message('请填写栏目名称');
                }
                $names = explode(chr(13), $names);
                $y = $n = 0;
                foreach ($names as $val) {
                    list($catname, $catpath) = explode('|', $val);
                    $catpath = $catpath ? $catpath : word2pinyin($catname);
                    if ($this->category->check_catpath(0, $catpath)) {
                        $catpath .= rand(0, 9); // 相同目录的添加随机数防止重复
                    }

                    $data['catname'] = $catname;
                    $data['catpath'] = $catpath;
                    $catid = $this->category->set(0, $data);
                    if (!is_numeric($catid)) {
                        $n++;
                    } else {
                        $this->category->url($catid, getCaturl($data));
                        $y++;
                    }
                }
                // $html = '<script type="text/javascript">parent.document.getElementById("leftMain").src ="' . url("admin/content/category") . '";</script>';
                $this->show_message($this->getCacheCode('category') . '批量添加成功', 1, url('admin/category/index'));
            } else {
                if (empty($data['catname'])) {
                    $this->show_message('请填写栏目名称');
                }

                if ($this->category->check_catpath(0, $data['catpath'])) {
                    $this->show_message('栏目路径为空或者已经存在');
                }

                $result = $this->category->set(0, $data);
                if (!is_numeric($result)) {
                    $this->show_message($result);
                }

                $data['catid'] = $result;
                $this->category->url($result, getCaturl($data));
                $this->show_message($this->getCacheCode('category') . '添加成功', 1, url('admin/category/index'));
            }
        } else {
            $msg = '';
            $data = array(
                'catname' => '',
                'catpath' => '',
                'typeid' => '',
                'modelid' => '',
                'categorytpl' => '',
                'listtpl' => '',
                'showtpl' => '',
                'searchtpl' => '',
                'msgtpl' => '',
                'http' => '',
                'islook' => '',
                'ispost' => '',
                'verify' => '',
                'isnewtab' => '',
                'pagesize' => '',
                'image' => '',
                'seo_title' => '',
                'seo_keywords' => '',
                'seo_description' => ''
            );
        }
        $content_model = get_cache('contentmodel');
        $page_model = get_cache('pagemodel');
        $catdata = $this->category->order('listorder ASC')->select();
        $catid = (int) $this->get('catid');
        $json_m = json_encode($content_model + $page_model);

        $json_model = $json_m ? $json_m : '""';
        $add = 1;

        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  |-', '  |-');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $category_select = array();
        if (!empty($catdata)) {
            foreach ($catdata as $r) {

                $category_select[$r['catid']] = $r;
            }
        }
        $str = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
        $tree->init($category_select);
        $category_select = $tree->get_tree_category(0, $str, '2', $catid);

        include $this->views('admin/category/add');
    }

    /**
     * 修改栏目
     */
    public function editAction()
    {
        $catid = (int) $this->get('catid');
        if (empty($catid)) {
            $this->show_message('栏目ID不存在');
        }
        $data = $this->category->find($catid);
        if ($this->isPostForm()) {
            unset($data, $catid);
            $catid = (int) $this->post('catid');
            if (empty($catid)) {
                $this->show_message('栏目ID不存在');
            }
            $data = $this->post('data');
            if (empty($data['catname'])) {
                $this->show_message('请填写栏目名称');
            }
            if ($this->category->check_catpath($catid, $data['catpath'])) {
                $this->show_message('栏目路径为空或者已经存在');
            }
            // $data['typeid'] = $this->post('typeid');
            $result = $this->category->set($catid, $data);
            if (is_numeric($result)) {
                $html = '<script type="text/javascript">parent.document.getElementById("leftMain").src ="' . url("admin/content/category") . '";</script>';
                $this->show_message($this->getCacheCode('category') . $data['catname'] . ' 修改成功' . $html, 1, url('admin/category/index'));
            } else {
                $this->show_message('操作失败');
            }
        }
        $content_model = get_cache('contentmodel');
        $page_model = get_cache('pagemodel');
        $catdata = $this->category->order('listorder ASC')->select();
        $json_m = json_encode($content_model + $page_model);

        $json_model = $json_m ? $json_m : '""';
        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  |-', '  |-');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $category_select = array();

        if (!empty($catdata)) {
            foreach ($catdata as $r) {
                $category_select[$r['catid']] = $r;
            }
        }
        $str = "<option value='\$catid' \$selected>\$spacer \$catname</option>";
        $tree->init($category_select);
        $category_select = $tree->get_tree_category(0, $str, '2', $data['parentid']);
        include $this->views('admin/category/add');
    }

    /**
     * 删除栏目
     */
    public function delAction()
    {
        $catid = $catid ? $catid : (int) $this->get('catid');
        if (empty($catid)) {
            $this->show_message('栏目ID不存在');
        }

        if ($this->category->del($catid)) {
            $html = '<script type="text/javascript">parent.document.getElementById("leftMain").src ="' . url("admin/content/category") . '";</script>';
            $this->show_message($this->getCacheCode('category') . '删除成功' . $html, 1, url('admin/category/index'));
        } else {
            $this->show_message('删除失败');
        }
    }

    /**
     * 更新栏目缓存
     */
    public function cacheAction($show = 0)
    {
        $this->category->repair(); // 递归修复栏目数据
        $model = get_cache('contentmodel');
        $data = $this->category->order('listorder ASC')->select();
        $category = $category_dir = array();
        foreach ($data as $t) {
            $catid = $t['catid'];
            $category[$catid] = $t;
            if ($t['typeid'] == 1 || $t['typeid'] == 4) {
                $category[$catid]['tablename'] = $tablename = $model[$t['modelid']]['tablename'];
                $category[$catid]['modelname'] = $model[$t['modelid']]['modelname'];
            }
            $category[$catid]['arrchilds'] = $catid; // 所有子栏目集,默认当前栏目ID
            if ($t['typeid'] != 3) {
                if ($t['child']) {
                    $category[$catid]['arrchilds'] = $this->category->child($catid) . $catid;
                }

                $total_num = $this->category->count('content', 'id', 'catid IN (' . $category[$catid]['arrchilds'] . ')');
                $category[$catid]['items'] = $total_num;
                $this->category->update(array('items' => $total_num), 'catid=' . $catid);
            }
            $category[$catid]['content'] = htmlspecialchars_decode($category[$catid]['content']);
            // 更新分页数量
            if (empty($t['pagesize'])) {
                $pcat = $this->category->getParentData($catid);
                $category[$catid]['pagesize'] = $pcat['pagesize'] ? $pcat['pagesize'] : 10;
                $this->category->update(array('pagesize' => $category[$catid]['pagesize']), 'catid=' . $catid);
            }
        }
        set_cache('category', $category);
        $category = get_cache('category');
        // 更新URL与栏目模型id集合
        foreach ($data as $t) {
            $category[$t['catid']]['url'] = $url = getCaturl($t);
            $this->category->update(array('url' => $url), 'catid=' . $t['catid']);
            $category_dir[$t['catpath']] = $t['catid'];
            if ($t['child'] == 0) {
                $category[$t['catid']]['arrmodelid'][] = $t['modelid'];
            } else {
                $category[$t['catid']]['arrmodelid'] = array();
                $ids = _catposids($t['catid'], NULL, $category);
                $ids = explode(',', $ids);
                foreach ($ids as $id) {
                    if ($id && $id != $t['catid']) {
                        $category[$t['catid']]['arrmodelid'][] = $category[$id]['modelid'];
                    }
                }
            }
            $category[$t['catid']]['arrmodelid'] = array_unique($category[$t['catid']]['arrmodelid']);
        }
        // 保存到缓存文件
        set_cache('category', $category);
        set_cache('category_dir', $category_dir);
        $show or $this->show_message('缓存更新成功', 1, url('admin/category/index'));
    }
}

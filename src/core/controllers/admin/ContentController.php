<?php
if (!defined('IN_CMS')) {
    exit();
}

class ContentController extends Admin
{

    public function indexAction()
    {
        // print_r($_SERVER['REQUEST_METHOD'] == 'POST');
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->post('submit') && $this->post('form') == 'search') {
                $username = $this->post('username');
                $catid = (int) $this->post('catid');
                $stype = $this->post('stype');
            } elseif ($this->post('submit_order') && $this->post('form') == 'order') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'order_') !== false) {
                        $id = (int) str_replace('order_', '', $var);
                        $this->content->update(array('listorder' => $value), 'id=' . $id);
                    }
                }
                $this->show_message('修改成功', 1);
            } elseif ($this->post('submit_del') && $this->post('form') == 'del') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $this->delAction($_id, $_catid, 1);
                    }
                }
                $this->show_message('删除成功', 1);
            } elseif ($this->post('submit_status_1') && $this->post('form') == 'status_1') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $this->content->update(array('status' => 1), 'id=' . (int) $_id);
                    }
                }
                $this->show_message('设置成功', 1, '', 500);
            } elseif ($this->post('submit_status_2') && $this->post('form') == 'status_2') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $this->content->update(array('status' => 2), 'id=' . (int) $_id);
                    }
                }
                $this->show_message('设置成功', 1);
            } elseif ($this->post('submit_status_3') && $this->post('form') == 'status_3') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $this->content->update(array('status' => 3), 'id=' . (int) $_id);
                    }
                }
                $this->show_message('设置成功', 1);
            } elseif ($this->post('submit_status_0') && $this->post('form') == 'status_0') {
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $this->content->update(array('status' => 0), 'id=' . (int) $_id);
                    }
                }
                $this->show_message('设置成功', 1);
            } elseif ($this->post('submit_move') && $this->post('form') == 'move') {
                $mcatid = (int) $this->post('movecatid');
                if (empty($mcatid)) {
                    $this->show_message('请选择目标栏目！');
                }

                $mcat = $this->category_cache[$mcatid];
                $mtable = core::load_model($mcat['tablename']);
                foreach ($_POST as $var => $value) {
                    if (strpos($var, 'del_') !== false) {
                        $ids = str_replace('del_', '', $var);
                        list($_id, $_catid) = explode('_', $ids);
                        $cat = $this->category_cache[$_catid];
                        if ($cat['modelid'] == $mcat['modelid']) {
                            $this->content->update(array('catid' => $mcatid), 'id=' . (int) $_id);
                            $mtable->update(array('catid' => $mcatid), 'id=' . (int) $_id);
                        }
                    }
                }
                $this->show_message('移动成功', 1);
            }
        }
        $catid = (int) $this->get('catid');
        $status = $this->get('status');
        $username = $this->get('username');
        $page = (int) $this->get('page');
        $page = (!$page) ? 1 : $page;
        $pagination = core::load_class('pagination');
        $pagination->loadconfig();

        $cats = $this->category_cache; // 读取栏目缓存
        // print_r(json_encode($cats));
        // return;
        if (empty($catid) || (int) $catid < 1) {
            // 取第一个栏目 ID
            if (reset($cats)) {
                $catid = (int) $cats[key($cats)]['catid'];
            } else {
                $this->show_message('缺少栏目id参数');
            }
        }

        $where = 'catid=' . $catid;
        if ($status == 1) {
            $where .= ' AND status=1';
        } elseif ($status == 2) {
            $where .= ' AND status=2';
        } elseif ($status == 3) {
            $where .= ' AND status=3';
        } elseif ($status == '0') {
            $where .= ' AND status=0';
        }
        if ($username) {
            $where .= " AND username='" . $username . "'";
        }

        $total = $this->content->count('content', NULL, $where);
        $count = array();
        $count[0] = $this->content->count('content', NULL, 'catid=' . $catid . ' AND status=0');
        $count[1] = $this->content->count('content', NULL, 'catid=' . $catid . ' AND status=1');
        $count[2] = $this->content->count('content', NULL, 'catid=' . $catid . ' AND status=2');
        $count[3] = $this->content->count('content', NULL, 'catid=' . $catid . ' AND status=3');

        $modelid = $cats[$catid]['modelid'];
        $pagesize = 15;
        $urlparam = array();
        $urlparam['catid'] = $catid;
        $urlparam['modelid'] = $modelid;
        if ($status) {
            $urlparam['status'] = $status;
        }

        if ($username) {
            $urlparam['username'] = $username;
        }

        $urlparam['page'] = '{page}';
        $url = url('admin/content/index', $urlparam);
        $list = $this->content->page_limit($page, $pagesize)->where($where)->order(array('listorder DESC', 'time DESC'))->select();

        $pagination = $pagination->total($total)->url($url)->num($pagesize)->page($page)->output();
        $join = $this->getModelJoin($modelid);

        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  |-', '  |-');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys = array();
        $nav_categorys = array(); // 内容管理-栏目导航
        foreach ($cats as $cid => $r) {
            // 组合左侧类型导航
            if ($r['typeid'] == 1) {
                $r['icon_type'] = 'glyphicon glyphicon-list-alt'; // 栏目
            } else if ($r['typeid'] == 2) {
                $r['icon_type'] = 'glyphicon glyphicon-file'; // 内置页面
            } else if ($r['typeid'] == 3) {
                $r['icon_type'] = 'glyphicon glyphicon-link'; // 链接
            } else {
                $r['icon_type'] = 'glyphicon glyphicon-book'; // 独立页面
            }
            $r['urla'] = url('admin/content/index', array('catid' => $r['catid']));
            $nav_categorys[$r['catid']] = $r;

            if ($modelid && $modelid != $r['modelid']) {
                continue;
            }

            $r['disabled'] = $r['child'] ? 'disabled' : '';
            $r['selected'] = $cid == $catid ? 'selected' : '';
            $categorys[$cid] = $r;
        }
        // 下拉选择
        $str = "<option value='\$catid' \$selected \$disabled>\$spacer\$catname</option>";
        $tree->init($categorys);
        $category = $tree->get_tree(0, $str);

        if (!empty($nav_categorys)) { // 组合左侧类型导航
            $tree->init($nav_categorys);
            $strs = "<span class='\$icon_type'></span><a href='\$urla'>\$catname</a>";
            $strs2 = "<span class='folder'>\$catname</span>";
            $nav_categorys = $tree->get_treeview(0, 'category_nav', $strs, $strs2, 0, 'filetree');
        } else {
            $categornav_categorysys = '没有分类请添加或刷新';
        }
        $typeid = $cats[$catid]['typeid'];
        if ($typeid == 2) {
            $data = $cats[$catid];
            include $this->admin_view('content/cate-page'); // 页面内容
        } elseif ($typeid == 3) {
            $data = $cats[$catid];
            include $this->admin_view('content/cate-link'); // 链接内容
        } elseif ($typeid == 4) {
            $data = $cats[$catid];
            include $this->admin_view('content/cate-single'); // 独立页面内容
        }  else {
            include $this->admin_view('content/list'); // 栏目内容列表
        }
    }

    /**
     * 所有内容列表
     */
    public function allAction()
    {
        $catid = (int) $this->get('catid');
        $status = $this->get('status');
        $username = $this->get('username');
        $title = $this->get('title');
        $page = (int) $this->get('page');
        $page = (!$page) ? 1 : $page;
        $where = ' ';
        if ($catid) {
            $where .= ' catid=' . $catid;
        }
        if (!empty($username)) {
            $where .= " AND username='" . $username . "'";
        }
        // if (!empty($title)) {
        //     $where .= " AND `title` LIKE '%' . $title . '%'";
        //     // $this->content->where("`title` LIKE  ?", '%' . $title . '%');
        // }
        $statusNum = array(
            0 => $this->content->count('content', NULL, $where . " AND status='0'"),
            1 => $this->content->count('content', NULL, $where . " AND status='1'"),
            2 => $this->content->count('content', NULL, $where . " AND status='2'"),
            3 => $this->content->count('content', NULL, $where . " AND status='3'"),
        );
        echo '<br/>where条件1' . $where . " AND status='0'" . PHP_EOL;
        $where = array();
        if ($catid) {
            $where[] = 'catid=' . $catid;
        }
        if (!empty($username)) {
            $where[] = "username='" . $username . "'";
        }
        if ($status == '0') {
            $where[] = "status='0'";
        } elseif (isset($status) && !empty($status)) {
            $where[] = "status='" . $status . "'";
        }

        echo '<br/>where条件2' . json_encode($where) . PHP_EOL;
        // $where = ' status=0';
        // 分页
        $pagesize = 15;
        $urlparam = array();
        if ($catid) {
            $urlparam['catid'] = $catid;
        }
        if ($title) {
            $urlparam['title'] = $title;
        }
        if ($modelid) {
            $urlparam['modelid'] = $modelid;
        }
        if ($status) {
            $urlparam['status'] = $status;
        }
        if ($username) {
            $urlparam['username'] = $username;
        }
        $urlparam['page'] = '{page}';
        $url = url('admin/content/all', $urlparam);
        $total = $this->content->count('content', NULL, $where);
        echo '<br/>分页，总数' . $total . PHP_EOL;
        // 列表
        // $list = $this->content->page_limit($page, $pagesize)->where($where)->order(array('listorder DESC', 'time DESC'))->select();
        // $list = $this->content->page_limit($page, $pagesize)->select();
        echo '<br/>列表长度' . count($list) . PHP_EOL;
        $pagination = core::load_class('pagination');
        $pagination->loadconfig();
        $pagination = $pagination->total($total)->url($url)->num($pagesize)->page($page)->output();

        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  |-', '  |-');
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $categorys = array();
        $cats = $this->category_cache; // 读取栏目缓存
        foreach ($cats as $cid => $r) {
            $r['disabled'] = $r['child'] ? 'disabled' : '';
            $r['selected'] = $cid == $catid ? 'selected' : '';
            $categorys[$cid] = $r;
        }
        $tree->init($categorys);
        $category = $tree->get_tree(0, "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>");
        include $this->admin_view('content/all');
    }

    /**
     * 显示栏目菜单列表
     */
    public function categoryAction()
    {
        $catlist = $this->category_cache; //读取文件缓存

        // 读取数据库后台不会根据排序显示
        // $catlist =  $this->category->findAll('catid,typeid,parentid,child,http,catname');
        $tree = core::load_class('tree');
        $categorys = array();
        if (!empty($catlist)) {
            foreach ($catlist as $r) {
                if ($r['typeid'] == 1) {
                    $r['icon_type'] = 'glyphicon glyphicon-list-alt'; // 栏目
                } else if ($r['typeid'] == 2) {
                    $r['icon_type'] = 'glyphicon glyphicon-file'; // 内置页面
                } else if ($r['typeid'] == 3) {
                    $r['icon_type'] = 'glyphicon glyphicon-link'; // 链接
                } else {
                    $r['icon_type'] = 'glyphicon glyphicon-book'; // 独立页面
                }
                $r['urla'] = url('admin/content/index', array('catid' => $r['catid']));
                $categorys[$r['catid']] = $r;
            }
        }

        if (!empty($categorys)) {
            $tree->init($categorys);
            $strs = "<span class='\$icon_type'><a href='\$urla' target='right' onclick='open_list(this)'>\$catname</a></span>";
            $strs2 = "<span class='folder'>\$catname</span>";
            $categorys = $tree->get_treeview(0, 'category_tree', $strs, $strs2);
        } else {
            $categorys = '没有分类请添加或刷新';
        }
        include $this->admin_view('content/category');
    }

    /**
     * 发布
     */
    public function addAction()
    {
        $catid = (int) $this->get('catid');
        $modelid = (int) $this->get('modelid');
        $model = get_cache('contentmodel');
        if (!isset($model[$modelid])) {
            $this->show_message('模型不存在');
        }

        $fields = $model[$modelid]['fields'];
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (empty($data['catid'])) {
                $this->show_message('请选择发布栏目');
            }
            if (empty($data['title'])) {
                $this->show_message('标题没有填写');
            }
            if ($this->category_cache[$data['catid']]['modelid'] != $modelid) {
                $this->show_message('栏目模型对不上，请重新选择栏目');
            }
            $this->checkFields($fields, $data, 1); // 验证自定义字段
            $data['username'] = $this->session->get('user_id');
            $data['create_time'] = time(); // 创建时间
            $data['time'] = $data['time'] ? $data['time'] : $data['create_time']; // 更新时间
            $data['modelid'] = $modelid;
            $result = $this->content->set(0, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                $this->show_message($result);
            }
            $data['id'] = $result;
            $this->content->url($result, getUrl($data));
            $msg = '<a href="' . url('admin/content/add', array('catid' => $data['catid'], 'modelid' => $modelid)) . '" style="font-size:14px;">继续添加</a>&nbsp;&nbsp;<a href="' . url('admin/content/index', array('modelid' => $modelid, 'catid' => $catid)) . '" style="font-size:14px;">返回列表</a>';
            $this->show_message('添加成功, 您可以继续操作' . '<div style="padding-top:10px;">' . $msg . '</div>', 1, 0, 5);
        }
        $data_fields = $this->getFields($fields, $data);
        $data = array('catid' => $this->get('catid'));
        $model = $model[$modelid];

        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  ', '  ');
        $tree->nbsp = '&nbsp;';
        $categorys = array();
        foreach ($this->category_cache as $cid => $r) {
            if ($modelid && $modelid != $r['modelid']) {
                continue;
            }

            $r['disabled'] = $r['child'] ? 'disabled' : '';
            $r['selected'] = $cid == $catid ? 'selected' : '';
            $categorys[$cid] = $r;
        }
        $str = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
        $tree->init($categorys);
        $category = $tree->get_tree(0, $str);

        include $this->admin_view('content/add');
    }

    /**
     * 修改
     */
    public function editAction()
    {
        $id = (int) $this->get('id');
        $data = $this->content->find($id);
        if (empty($data)) {
            $this->show_message('内容不存在');
        }

        $catid = $data['catid'];
        $modelid = $data['modelid'];
        $model = get_cache('contentmodel');
        if (!isset($model[$modelid])) {
            $this->show_message('模型不存在');
        }

        $fields = $model[$modelid]['fields'];
        if ($this->isPostForm()) {
            unset($data);
            $data = $this->post('data');
            if (empty($data['title'])) {
                $this->show_message('标题没有填写');
            }

            if ($data['catid'] != $catid && $modelid != $this->category_cache[$data['catid']]['modelid']) {
                $this->show_message('栏目模型对不上，请重新选择栏目');
            }

            //验证自定义字段
            $this->checkFields($fields, $data, 1);
            $data['time'] = $data['time'] ? $data['time'] : time();

            $data['modelid'] = (int) $modelid;
            $result = $this->content->set($id, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                $this->show_message($result);
            }

            $this->show_message('修改成功', 1);
        }
        // 附表内容
        $table = core::load_model($model[$modelid]['tablename']);
        $table_data = $table->find($id);
        if ($table_data) {
            $data = array_merge($data, $table_data);
        }
        // 合并主表和附表
        // 自定义字段
        $data_fields = $this->getFields($fields, $data);
        $backurl = HTTP_REFERER;
        $model = $model[$modelid];
        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  ', '  ');
        $tree->nbsp = '&nbsp;';
        $categorys = array();
        foreach ($this->category_cache as $cid => $r) {
            if ($modelid && $modelid != $r['modelid']) {
                continue;
            }

            $r['disabled'] = $r['child'] ? 'disabled' : '';
            $r['selected'] = $cid == $catid ? 'selected' : '';
            $categorys[$cid] = $r;
        }
        $str = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
        $tree->init($categorys);
        $category = $tree->get_tree(0, $str);

        include $this->admin_view('content/add');
    }

    /**
     * 预览内容
     */
    public function previewAction()
    {
        $id = (int) $this->get('id');
        // 主表内容
        $data = $this->content->find($id);
        if (empty($data)) {
            $this->show_message('内容不存在');
        }

        $data['catname'] = $this->category_cache[$data['catid']]['catname'];
        $data['modelname'] = $this->category_cache[$data['catid']]['modelname'];
        $modelid = $data['modelid'];
        $model = get_cache('contentmodel');
        if (!isset($model[$modelid])) {
            $this->show_message('模型不存在');
        }

        // 附表内容
        $table = core::load_model($model[$modelid]['tablename']);
        $table_data = $table->find($id);
        if ($table_data) {
            $data = array_merge($data, $table_data);
        }
        // 合并主表和附表
        // 自定义字段
        $fields = $model[$modelid]['fields'];
        $data_fields = $this->getFields($fields, $data);
        $model = $model[$modelid];
        include $this->admin_view('content/preview');
    }

    /**
     * 删除
     */
    public function delAction($id = 0, $catid = 0, $all = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        $catid = $catid ? $catid : (int) $this->get('catid');
        $all = $all ? $all : $this->get('all');
        $back = HTTP_REFERER;
        $model = get_cache('contentmodel');

        $this->content->del($id, $catid);
        $all or $this->show_message('操作成功', 1, $back);
    }

    /**
     * 标题是否重复检查
     */
    public function ajaxtitleAction()
    {
        $title = $this->post('title');
        $id = (int) $this->post('id');
        if (empty($title)) {
            exit('不能为空');
        }

        $where = $id ? "title='" . $title . "' and id<>" . $id : "title='" . $title . "'";
        $data = $this->content->getOne($where);
        if ($data) {
            exit('<div class="onFocus">已有相同的标题存在</div>');
        }

        exit('');
    }

    /**
     * 更新url地址
     */
    public function updateurlAction()
    {
        if ($this->isPostForm()) {
            $catids = $this->post('catids');
            $cats = NULL;
            if ($catids && !in_array(0, $catids)) {
                $cats = @implode(',', $catids);
            } else {
                foreach ($this->category_cache as $c) {
                    if ($c['typeid'] == 1) {
                        $cats[$c['catid']] = $c['catid'];
                    }

                }
                $cats = @implode(',', $cats);
            }
            if (empty($cats)) {
                echo '<style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <font color=red>栏目列表为空，请选择栏目！</font>
                </div>';
                exit;
            }
            $url = url('admin/content/updateurl', array('submit' => 1, 'catids' => $cats, 'nums' => $this->post('nums')));
            echo '
            <style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
            <div style="font-size:12px;padding-top:0px;">
            <meta http-equiv="refresh" content="0; url=' . $url . '">
            <a href="' . $url . '">如果您的浏览器没有自动跳转，请点击这里</a>
            </div>
            </div>
            ';
            exit;
        }
        if ($this->get('submit')) {
            $mark = 0;
            $cats = array();
            $catids = $this->get('catids');
            $cats = @explode(',', $catids);
            $catid = $this->get('catid') ? $this->get('catid') : $cats[0];
            $cat = isset($this->category_cache[$catid]) ? $this->category_cache[$catid] : NULL;
            if (!$cat) {
                echo '
                <style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <font color=green>更新完毕！</font>
                </div>
                ';
                exit;
            }
            $page = $this->get('page') ? $this->get('page') : 1;
            $nums = $this->get('nums') ? $this->get('nums') : 100;
            $where = 'catid IN (' . $cat['arrchilds'] . ')';
            $count = $this->content->count('content', 'id', $where);
            $total = ceil($count / $nums);
            $list = $this->content->from('content', 'id,time,catid')->where($where)->page_limit($page, $nums)->select();
            if (empty($list)) {
                $mark = $_catid = 0;
                foreach ($cats as $c) {
                    if ($catid == $c) {
                        $mark = 1;
                        continue;
                    }
                    if ($mark == 1) {
                        $_catid = $c;
                        break;
                    }
                }
                if (!isset($this->category_cache[$_catid])) {
                    echo '
                    <style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
                    <div style="font-size:12px;padding-top:0px;">
                    <font color=green>更新完毕！</font>
                    </div>
                    ';
                    exit;
                }
                $url = url('admin/content/updateurl', array('submit' => 1, 'nums' => $nums, 'page' => 1, 'catid' => $_catid, 'catids' => $catids));
                echo '
                <style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <meta http-equiv="refresh" content="0; url=' . $url . '">
                <a href="' . $url . '">正在更新' . $this->category_cache[$_catid]['catname'] . '</a>
                </div>
                ';
                exit;
            } else {
                foreach ($list as $t) {
                    $this->content->update(array('url' => getUrl($t)), 'id=' . $t['id']);
                }
                $url = url('admin/content/updateurl', array('submit' => 1, 'nums' => $nums, 'page' => $page + 1, 'catid' => $catid, 'catids' => $catids));
                echo '
                <style type="text/css">body{margin:0;overflow: hidden;}div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <meta http-equiv="refresh" content="0; url=' . $url . '">
                <a href="' . $url . '">正在更新 ' . $this->category_cache[$_catid]['catname'] . $this->category_cache[$catid]['catname'] . $page . $total . '</a>
                </div>
                ';
                exit;
            }
        } else {
            $tree = core::load_class('tree');
            $tree->icon = array(' ', '  |-', '  |-');
            $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
            $categorys = array();
            foreach ($this->category_cache as $cid => $r) {
                if ($modelid && $modelid != $r['modelid']) {
                    continue;
                }

                $r['disabled'] = $r['child'] ? 'disabled' : '';
                $r['selected'] = $cid == $catid ? 'selected' : '';
                $categorys[$cid] = $r;
            }
            $str = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
            $tree->init($categorys);
            $category = $tree->get_tree(0, $str);
            include $this->admin_view('content/updateurl');
        }
    }

}

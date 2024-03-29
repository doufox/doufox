<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class ContentController extends API
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $id = (int) $this->get('id');
        if ($id) {
            // 指定栏目
            $this->get_content($id);
        }
        $data = array(
            'title' => $this->site_config['SITE_TITLE'],
            'keywords' => $this->site_config['SITE_KEYWORDS'],
            'description' => $this->site_config['SITE_DESCRIPTION'],
        );
        $this->response(400, $data, 'Success');
    }

    /**
     * 发布
     */
    public function addAction()
    {
        if (!$this->is_logged()) {
            $this->response(401, NULL, 'Unauthorized');
        }
        if ($this->is_post()) {
            $data = $this->post();
            $catid = (int) $this->post('catid');
            $modelid = (int) $this->post('modelid');
            if (empty($catid)) {
                $this->response(400, $data, 'Need Key `catid`');
            }
            if (empty($modelid)) {
                $this->response(400, $data, 'Need Key `modelid`');
            }
            $model = get_cache('contentmodel');
            if (!isset($model[$modelid])) {
                $this->response(404, $data, 'Not Found contentmodel');
            }
            if (empty($data['title'])) {
                $this->response(404, $data, 'Need Key `title`');
            }
            $fields = $model[$modelid]['fields'];

            if ($this->category_cache[$data['catid']]['modelid'] != $modelid) {
                $this->show_message('栏目模型对不上，请重新选择栏目');
            }

            $this->checkFields($fields, $data, 1); // 验证自定义字段
            
            $data['username'] = $this->session->get('member_id');
            $data['time'] = $data['time'] ? $data['time'] : time();
            $data['modelid'] = $modelid;
            $result = $this->content->set(0, $model[$modelid]['tablename'], $data);
            if (!is_numeric($result)) {
                $this->show_message($result);
            }

            $data['id'] = $result;
            $this->content->url($result, getUrl($data));
            $msg = '<a href="' . url('admin/content/add', array('catid' => $data['catid'], 'modelid' => $modelid)) . '" style="font-size:14px;">继续添加</a>&nbsp;&nbsp;<a href="' . url('admin/content/index', array('modelid' => $modelid, 'catid' => $catid)) . '" style="font-size:14px;">返回列表</a>';
            $this->show_message('添加成功, 您可以继续操作' . '<div style="padding-top:10px;">' . $msg . '</div>', 1, 0, 5);
            $this->response(200, $data, 'Success');
        } else {
            $this->response(405, NULL, 'Method Not Allowed');
        }
    }

    /**
     * 修改
     */
    public function editAction()
    {
        if (!$this->is_logged()) {
            $this->response(401, NULL, 'Unauthorized');
        }
        $id = (int) $this->get('id');
        if (empty($id)) {
            $this->response(404, NULL, 'Need Key `id`');
        }
        $data = $this->content->find($id);
        if (empty($data)) {
            $this->response(404, NULL, 'Not Found');
        }

        $catid = $data['catid'];
        $modelid = $data['modelid'];
        $model = get_cache('contentmodel');
        if (!isset($model[$modelid])) {
            $this->response(404, NULL, 'contentmodel not found');
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
        //附表内容
        $table = core::load_model($model[$modelid]['tablename']);
        $table_data = $table->find($id);
        if ($table_data) {
            $data = array_merge($data, $table_data);
        }
        //合并主表和附表
        //自定义字段
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

        include $this->views('admin/content/add');
    }

    /**
     * 删除
     */
    public function delAction($id = 0, $catid = 0, $all = 0)
    {
        if (!$this->is_logged()) {
            $this->response(401, NULL, 'Unauthorized');
        }
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
                echo '<style type="text/css">div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <font color=red>栏目列表为空，请选择栏目！</font>
                </div>';
                exit;
            }
            $url = url('admin/content/updateurl', array('submit' => 1, 'catids' => $cats, 'nums' => $this->post('nums')));
            echo '<style type="text/css">div, a { color: #777777;}</style>
            <div style="font-size:12px;padding-top:0px;">
            <meta http-equiv="refresh" content="0; url=' . $url . '">
            <a href="' . $url . '">如果您的浏览器没有自动跳转，请点击这里</a>
            </div>
            </div>';
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
                echo '<style type="text/css">div, a { color: #777777;}</style>
                <div style="font-size:12px;padding-top:0px;">
                <font color=green>更新完毕！</font>
                </div>';
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
                    <style type="text/css">div, a { color: #777777;}</style>
                    <div style="font-size:12px;padding-top:0px;">
                    <font color=green>更新完毕！</font>
                    </div>
                    ';
                    exit;
                }
                $url = url('admin/content/updateurl', array('submit' => 1, 'nums' => $nums, 'page' => 1, 'catid' => $_catid, 'catids' => $catids));
                echo '
                <style type="text/css">div, a { color: #777777;}</style>
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
                <style type="text/css">div, a { color: #777777;}</style>
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
            include $this->views('admin/content/url');
        }
    }

    /**
     * 点击量
     */
    public function hitsAction()
    {
        $id = (int) $this->get('id');
        if (empty($id)) {
            $this->response(400, NULL, 'Need Key `id`');
        }
        $data = $this->content->find($id, 'hits');
        if (empty($data)) {
            $this->response(404, NULL, 'Not found');
        }
        $count = $data['hits'] + 1;
        $this->content->update(array('hits' => 'hits+1'), 'id=' . $id);
        $this->response(200, array('hits' => $count), 'success');
    }

    /**
     * 内容展示
     */
    private function get_content($id)
    {
        $page = (int) $this->get('page');
        $page = $page ? $page : 1;
        $id = $id ? $id : (int) $this->get('id');
        if (!isset($id)) {
            $this->response(403, NULL, 'Need Key `id`');
        }
        $data = $this->content->find($id);
        if (empty($data)) {
            $this->response(404, NULL, 'Not Found');
        }
        if (!$data['status']) {
            $this->response(401, NULL, 'Under review');
        }
        $model = get_cache('contentmodel');
        if (!isset($model[$data['modelid']]) || empty($model[$data['modelid']])) {
            $this->response(401, NULL, 'model Not Found');
        }
        $catid = $data['catid'];
        $cat = $this->category_cache[$catid];
        if ($cat['islook'] && !$this->getMember) {
            $this->response(401, NULL, '当前栏目游客不允许查看！');
        }

        $table = core::load_model($cat['tablename']);
        $_data = $table->find($id);
        $data = array_merge($data, $_data); // 合并主表和附表
        $data = $this->getFieldData($model[$cat['modelid']], $data);
        if (isset($data['content']) && strpos($data['content'], '{-page-}') !== false) {
            $content = explode('{-page-}', $data['content']);
            $pageid = count($content) >= $page ? ($page - 1) : (count($content) - 1);
            $data['content'] = $content[$pageid];
            $page_id = 1;
            $pagination = array();
            foreach ($content as $t) {
                $pagination[$page_id] = getUrl($data, $page_id);
                $page_id++;
            }
            $this->view->assign('content_page', $pagination);
        }
        $prev = $this->content->getOne("`catid`=$catid AND `id`<$id AND `status`!=0 ORDER BY `id` DESC", NULL, 'title, id');
        $next = $this->content->getOne("`catid`=$catid AND `id`>$id AND `status`!=0", NULL, 'title, id');
        $seo = showSeo($data, $page);
        $tmp = array(
            'seo' => $seo,
            'prev' => $prev,
            'page' => $page,
            'next' => $next,
            'pageurl' => getUrl($data, $page),
            'pagination' => $pagination,
        );
        $tmp = array_merge($tmp, $data);
        $this->response(200, $tmp, 'success');
    }
}

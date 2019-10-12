<?php

class CreatehtmlController extends Admin
{

    private $tree;

    public function __construct()
    {
        parent::__construct();
        if ($this->site_config['DIY_URL'] != 2) {
            $this->show_message('请开启系统生成静态功能', 2, url('admin/config', array('type' => 5)));
        }

        $this->tree = core::load_class('tree');
    }

    /**
     * 页面静态化
     */
    public function indexAction()
    {
        include $this->admin_view('html/index');
    }

    /**
     * 生成首页
     */
    public function homeAction()
    {
        ob_start();
        core::load_file(CTRL_PATH . 'IndexController.php');
        $c = new IndexController();
        $c->indexAction();
        if (!file_put_contents(ROOT_PATH . 'index.html', ob_get_clean(), LOCK_EX)) {
            $this->show_message($url . '生成失败！', 2, '');
        }

        $this->show_message('首页生成成功', 1, '#');
    }

    /**
     * 栏目页生成静态
     */
    public function categoryAction()
    {
        if ($this->isPostForm()) {
            $catid = $this->post('catid');
            if (!empty($catid)) {
                $this->show_message('正在生成栏目，请稍候', 1, url('admin/createhtml/one_cat', array('create' => 1, 'catid' => $catid)), 100);
            } else {
                $this->show_message('正在生成栏目，请稍候', 1, url('admin/createhtml/all_cat', array('create' => 1)), 100);
            }
        }
        $show = '请选择要生成的栏目页';
        $catdata = $this->category->order('listorder ASC, catid ASC')->select();
        $catid = (int) $this->get('catid');
        $tree = core::load_class('tree');
        $tree->icon = array(' ', '├', '   ∟');
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
        include $this->admin_view('html/create_html');
    }

    /**
     * 生成一个栏目
     */
    public function one_catAction()
    {
        $create = $this->get('create');
        if (empty($create)) {exit;}

        $catid = $this->get('catid');
        $page = $this->get('page') ? $this->get('page') : 0;
        $cat = $this->category_cache[$catid];
        if ($cat['typeid'] == 3) {
            $this->show_message('[' . $cat['catname'] . '] ' . ' 属于外链无法生成', 1, '#');
        } else if ($cat['typeid'] == 2) { //单页面
            $this->create_category_html($cat);
        } else {
            $db = core::load_model('content');
            // $total = $this->db->set_table_name('content')->count('`status`!=0 AND `catid` IN (' . $cat['allchildids'] . ')');
            $total = $db->count('`status`!=0 AND `catid` IN (' . $cat['allchildids'] . ')');
            $pagesize = $cat['pagesize'];
            $totalpage = ceil($total / $pagesize); //该栏目的总页数
            $totalpage = $totalpage ? $totalpage : 1;
            $this->create_category_html($cat, $page);
            $nextpage = $page + 1; //下一个列表页
        }
        if ($page >= $totalpage) { //如果传入分页数量大于分页总数 则生成完毕，比如分页总数是5 传入第六页那么生成完毕
            $this->show_message('[' . $cat['catname'] . '] ' . ' 生成完成', 1, '#');
        }
        $url = url('admin/createhtml/one_cat', array('page' => $nextpage, 'catid' => $catid, 'isall' => $isall, 'key' => $key, 'create' => 1));
        $this->show_message('[' . $cat['catname'] . '] ' . $cat['url'] . ' (' . $page . '/共' . $totalpage . '页)', 1, $url, 100);
    }

    /**
     * 生成全部栏目
     */
    public function all_catAction()
    {
        $create = $this->get('create');
        if (empty($create)) {
            exit;
        }

        $catid = $this->get('catid');
        $loop = $this->get('loop');
        $page = $this->get('page') ? $this->get('page') : 0;
        if (empty($catid) && !isset($loop)) {
            $cats = $this->category_cache;
            $fcat = array_shift($cats);
            $catid = $fcat['catid'];
        }
        if (isset($this->category_cache[$catid])) {
            $cat = $this->category_cache[$catid];
            $nextpage = 0;
            $nextcatid = $catid;
            if ($cat['typeid'] == 3) {

            } elseif ($cat['typeid'] == 2) {
                $this->create_category_html($cat);
            } elseif ($cat['typeid'] == 1) {
                $db = core::load_model('content');
                // $total = $this->db->set_table_name('content')->count('`status`!=0 AND `catid` IN (' . $cat['allchildids'] . ')');
                $total = $db->count('`status`!=0 AND `catid` IN (' . $cat['allchildids'] . ')');
                $pagesize = $cat['pagesize'];
                $totalpage = ceil($total / $pagesize); //该栏目的总页数
                $totalpage = $totalpage ? $totalpage : 1;
                $this->create_category_html($cat, $page);
                $nextpage = $page + 1; //下一个列表页
            }
            if ($page >= $totalpage) {
                $nextpage = 0;
                $nextcatid = $this->get_next_catid($catid);
            }
            $url = url('admin/createhtml/all_cat', array('page' => $nextpage, 'catid' => $nextcatid, 'create' => 1, 'loop' => 1));
            $this->show_message('[' . $cat['catname'] . '] ' . $cat['url'] . ' (' . $page . '/共' . $totalpage . '页)', 1, $url, 100);
        } else {
            $this->show_message('生成全部栏目页完成', 1, '#');
        }
    }

    /**
     * 获取下一栏目id
     */
    private function get_next_catid($catid)
    {
        $_selected = 0;
        foreach ($this->category_cache as $k => $t) {
            if ($_selected == 1) {
                $nextcatid = $k;
                break;
            }
            if ($k == $catid) {
                $_selected = 1;
            }

        }
        return $nextcatid;
    }

    /**
     * 内容页生成静态
     */
    public function showAction()
    {
        if ($this->isPostForm()) {
            $catid = $this->post('catid');
            $time = $this->post('time');
            $time = $time ? $time : 0;
            $this->show_message('正在生成内容页，请稍候', 1, url('admin/createhtml/all_show', array('create' => 1, 'catid' => $catid, 'time' => $time)), 100);
        }
        $isshow = 1;
        $show = '按照栏目生成内容页';
        $catdata = $this->category->order('listorder ASC, catid ASC')->select();
        $catid = (int) $this->get('catid');
        $tree = core::load_class('tree');
        $tree->icon = array(' ', '├', '   ∟');
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
        include $this->admin_view('html/create_html');
    }

    /**
     * 内容页生成静态
     */
    public function all_showAction()
    {
        $create = $this->get('create');
        if (empty($create)) {
            exit;
        }

        $catid = isset($catid) ? $catid : (int) $this->get('catid');
        $time = isset($time) ? $time : (int) $this->get('time');
        $page = $this->get('page') ? $this->get('page') : 1;
        if ($time) {
            $this->show_skip(null, $page, $time);
        } else if ($catid) {
            $cats = $this->category_cache[$catid]['allchildids'];
            $this->show_skip($cats, $page, $time);
        } else {
            $this->show_skip(null, $page, null);
        }
    }

    /**
     * 生成内容跳转
     */
    private function show_skip($cats, $page, $time)
    {
        $db = core::load_model('content');
        if ($time) {
            $a = $time * 3600;
            $b = time() - $a;
            $where = 'time > ' . $b;
            $total = $db->count($where);
        } else if ($cats) {
            $total = $db->count('`catid` IN(' . $cats . ') AND `status`!=0');
        } else {
            $total = $db->count('`status`!=0');
        }
        $pagesize = 10;
        $totalpage = ceil($total / $pagesize);
        if ($time) {
            $data = $db->page_limit($page, $pagesize)->where($where)->order('id ASC')->select();
        } else if ($cats) {
            $data = $db->page_limit($page, $pagesize)->where('`catid` IN(' . $cats . ')')->order('id ASC')->select();
        } else {
            $data = $db->page_limit($page, $pagesize)->where('`status`!=0')->order('id ASC')->select();
        }

        if (empty($data)) {
            $this->show_message('生成内容页完成', 1, '#');
        }
        foreach ($data as $t) {
            $this->create_show_html($t);
        }
        $url = url('admin/createhtml/all_show', array('page' => $page + 1, 'create' => 1, 'catid' => $cats, 'time' => $time));
        $this->show_message('正在生成' . ' (' . $page . '/共' . $total . '页)', 1, $url, 100);
    }

    /**
     * 生成栏目html
     */
    protected function create_category_html($cat, $page = 0)
    {
        $cat['page'] = $page;
        if (!empty($page)) {
            $url = preg_replace('#{([a-z_0-9]+)}#e', "\$cat[\\1]", $this->site_config['LIST_PAGE_URL']);
        } else {
            $url = preg_replace('#{([a-z_0-9]+)}#e', "\$cat[\\1]", $this->site_config['LIST_URL']);
        }
        $url = $cat['catdir'] . DS . $url;
        if (substr($url, -5) != '.html') {
            mkdirs(ROOT_PATH . $url);
            $htmlfile = ROOT_PATH . $url . DS . 'index.html';
        } else {
            mkdirs(ROOT_PATH . dirname($url));
            $htmlfile = ROOT_PATH . $url;
        }
        ob_start();
        $_GET['catid'] = $cat['catid'];
        $_GET['page'] = $page;
        core::load_file(CTRL_PATH . 'IndexController.php');
        $c = new IndexController();
        $c->listAction();
        if (!file_put_contents($htmlfile, ob_get_clean(), LOCK_EX)) {
            $this->show_message($url . '生成失败！', 2, '');
        }

        return true;
    }

    /**
     * 生成内容html
     */
    protected function create_show_html($content, $page = 0)
    {
        //获取url
        $content['catdir'] = $this->category_cache[$content['catid']]['catdir'];
        $content['page'] = $page;
        if (!empty($page)) {
            $url = preg_replace('#{([a-z_0-9]+)}#e', '\$content[\\1]', $this->site_config['SHOW_PAGE_URL']);
        } else {
            $url = preg_replace('#{([a-z_0-9]+)}#e', '\$content[\\1]', $this->site_config['SHOW_URL']);
        }
        $url = SITE_PATH . $url;
        if (substr($url, -5) != '.html') {
            mkdirs(ROOT_PATH . $url);
            $htmlfile = ROOT_PATH . $url . DS . 'index.html';
        } else {
            mkdirs(ROOT_PATH . dirname($url));
            $htmlfile = ROOT_PATH . $url;
        }

        ob_start();
        $id = $content['id'];
        //以下代码和首页部分代码无区别 唯一的区别就是少了一层主表数据查询
        $category = $this->category_cache[$content['catid']];
        $db = core::load_model($category['tablename']);
        $content_add = $db->find($id);
        $content_add = $this->handle_fields($this->content_model[$content['modelid']]['fields'], $content_add);
        $content = $content_add ? array_merge($content, $content_add) : $content;
        if (strpos($content_add['content'], '[XiaoCms-page]') !== false) {
            $pdata = array_filter(explode('[XiaoCms-page]', $content_add['content']));
            $pagenumber = count($pdata);
            $content['content'] = $pdata[$content['page'] - 1];
            $pageurl = $this->view->get_show_url($content, 1);
            $pagelist = core::load_class('pagination');
            $pagelist = $pagelist->total($pagenumber)->url($pageurl)->num(1)->hide()->page($content['page'])->output();
            $this->view->assign('pagelist', $pagelist);
        }
        //状态未审核就删除处理
        if ($content['status'] == 0) {
            if (is_file($htmlfile)) {
                @unlink($htmlfile);
                if (isset($pagenumber)) {
                    for ($i = 1; $i <= $pagenumber; $i++) {
                        $content['page'] = $i;
                        $url = preg_replace('#{([a-z_0-9]+)}#e', '\$content[\\1]', $this->site_config['SHOW_PAGE_URL']);
                        $url = SITE_PATH . $url;
                        if (substr($url, -5) != '.html') {
                            mkdirs(ROOT_PATH . $url);
                            $htmlfile = ROOT_PATH . $url . DS . 'index.html';
                        } else {
                            mkdirs(ROOT_PATH . dirname($url));
                            $htmlfile = ROOT_PATH . $url;
                        }
                        @unlink($htmlfile);
                    }
                }
            }
            return false;
        }
        //状态未审核就删除处理结束

        $content['cat'] = $category;
        $prev_page = $this->db->set_table_name('content')->order('id DESC')->getOne(array('id<?', 'catid=' . $content['catid'], 'status!=0'), $id);
        if ($prev_page) {
            $prev_page['url'] = $this->view->get_show_url($prev_page);
        }

        $next_page = $this->db->set_table_name('content')->order('id ASC')->getOne(array('id>?', 'catid=' . $content['catid'], 'status!=0'), $id);
        if ($next_page) {
            $next_page['url'] = $this->view->get_show_url($next_page);
        }

        $this->view->assign($content);
        $this->view->assign($this->showSeo($content, $content['page']));
        $this->view->assign(array(
            'prev_page' => $prev_page,
            'next_page' => $next_page,
        ));

        //全局变量传入模板
        $this->view->assign(array(
            'cats' => $this->category_cache,
            'member' => $this->member_info,
            'site_url' => HTTP_URL,
            'site_name' => $this->site_config['SITE_NAME'],
            'site_template' => HTTP_URL . basename(THEME_PATH_D) . '/',
        ));
        $this->view->display($category['showtpl']);

        if (!file_put_contents($htmlfile, ob_get_clean(), LOCK_EX)) {
            $this->show_message($htmlfile . '生成失败！', 2, '');
        }

        if (isset($pagenumber) && $page < $pagenumber) {
            $this->create_show_html($content, $page + 1);
        }

        return true;
    }

}

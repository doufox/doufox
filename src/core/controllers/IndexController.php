<?php

class IndexController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * 首页
     */
    public function indexAction()
    {
        $this->view->assign(array(
            'index' => 1,
            'site_title' => $this->site_config['SITE_TITLE'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
        ));
        $this->view->display('index.html');
    }

    /**
     * 栏目列表页
     */
    public function categoryAction()
    {
        $catid = (int) $this->get('catid');
        $catpath = $this->get('catpath');
        $page = (int) $this->get('page');
        $page = $page ? $page : 1;
        if ($catpath && empty($catid)) {
            $catid = $this->category_dir_cache[$catpath];
        }

        $cat = $this->category_cache[$catid];
        if (empty($cat)) {
            header('HTTP/1.1 404 Not Found');
            $this->show_message('当前栏目不存在');
        }

        if ($cat['islook'] && !$this->getMember) {
            $this->show_message('当前栏目游客不允许查看');
        }

        $this->view->assign($cat);
        $this->view->assign(listSeo($cat, $page));
        if ($cat['typeid'] == 1) {
            // 内部栏目
            $this->view->assign(array(
                'page' => $page,
                'catid' => $catid,
                'pageurl' => urlencode(getCaturl($cat, '{page}')),
            ));
            $this->view->display($cat['child'] == 1 ? $cat['categorytpl'] : $cat['listtpl']);
        } elseif ($cat['typeid'] == 2) {
            // 内部单页
            $this->view->display($cat['pagetpl']);
        } elseif ($cat['typeid'] == 3) {
            // 外部链接
            if ($cat['redirect'] == 1) {
                // 直接跳转
                header('Location: ' . $cat['url']);
            } else {
                // 打开页面跳转确认页
                $this->view->display('redirect.html');
            }
        } else {
            // 独立页面
            // print_r($cat);
            $this->view->display_html($cat['catpath'], $cat['content']);
            // $this->view->display_html('<div>single page</div><h1>{$site_name} <small>{$catname}</small></h1>');
        }
    }

    /**
     * 内容详情页
     */
    public function showAction()
    {
        $page = (int) $this->get('page');
        $page = $page ? $page : 1;
        $id = (int) $this->get('id');
        $data = $this->content->find($id);
        $model = get_cache('contentmodel');
        if (empty($data)) {
            header('HTTP/1.1 404 Not Found');
            $this->show_message('不存在此内容！');
        }
        if (!$data['status']) {
            $this->show_message('此内容正在审核中不能查看！');
        }

        if (!isset($model[$data['modelid']]) || empty($model[$data['modelid']])) {
            $this->show_message('此内容模型不存在');
        }

        $catid = $data['catid'];
        $cat = $this->category_cache[$catid];
        if ($cat['islook'] && !$this->getMember) {
            $this->show_message('当前栏目游客不允许查看');
        }

        $table = core::load_model($cat['tablename']);
        $_data = $table->find($id);
        $data = array_merge($data, $_data); //合并主表和附表
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
        $prev_page = $this->content->getOne("`catid`=$catid AND `id`<$id AND `status`!=0 ORDER BY `id` DESC", null, 'title,url');
        $next_page = $this->content->getOne("`catid`=$catid AND `id`>$id AND `status`!=0", null, 'title,url');
        $seo = showSeo($data, $page);
        $this->view->assign(array(
            'cat' => $cat,
            'page' => $page,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'pageurl' => urlencode(getUrl($data, '{page}')),
        ));
        $this->view->assign($data);
        $this->view->assign($seo);
        $this->view->display($cat['showtpl']);
    }

    /**
     * 内容搜索
     */
    public function searchAction()
    {
        $kw = $this->get('kw');
        $catid = $this->get('catid');
        $kw = urldecode($kw);
        if (!$kw) {
            $this->show_message('请输入关键字');
        }

        $page = (int) $this->get('page');
        $page = (!$page) ? 1 : $page;
        $pagination = core::load_class('pagination');
        $pagination->loadconfig();
        $pagesize = 10;
        $urlparam = array();
        if ($kw) {
            $urlparam['kw'] = $kw;
        }

        $where = "title like '%" . $kw . "%'";
        $catid = $catid ? $catid : (int) $this->get('catid');
        if ($catid) {
            $where .= " AND catid='" . $catid . "'";
            $urlparam['catid'] = $catid;
            $cat = $this->category_cache[$catid];
        }

        $total = $this->content->count('content', null, $where);
        $urlparam['page'] = '{page}';
        $url = url('index/search', $urlparam);
        $data = $this->content->page_limit($page, $pagesize)->where($where)->order(array('listorder DESC', 'id DESC'))->select();
        $pagination = $pagination->total($total)->url($url)->num($pagesize)->page($page)->output();
        $this->view->assign(listSeo($cat, $page, $kw));
        $this->view->assign(array(
            'id' => $id,
            'pagination' => $pagination,
            'searchdata' => $data,
            'searchnum' => $total,
            'kw' => $kw,
            'catid' => $catid,
        ));
        $tplfile = $cat && $cat['searchtpl'] ? $cat['searchtpl'] : 'search.html';
        $this->view->display($tplfile);
    }

    /**
     * 游客投稿
     */
    public function postAction()
    {
        if ($this->post('select') && $this->isPostForm()) {
            $this->redirect(url('index/post', array('catid' => (int) $this->post('catid'))));
        }

        $catid = (int) $this->get('catid');
        $tree = core::load_class('tree');
        $tree->icon = array(' ', '  ', '  ');
        $tree->nbsp = '&nbsp;';
        $categorys = array();
        foreach ($this->category_cache as $cid => $r) {
            if ($r['ispost'] != 1 || $r['typeid'] != 1) {
                continue;
            }

            $r['disabled'] = $r['child'] ? 'disabled' : '';
            $r['selected'] = $cid == $catid ? 'selected' : '';
            $categorys[$cid] = $r;
        }
        $str = "<option value='\$catid' \$selected \$disabled>\$spacer \$catname</option>";
        $tree->init($categorys);
        $categorys = $tree->get_tree(0, $str);
        if (empty($catid)) {
            $this->view->assign(array(
                'select' => 1,
                'post_category' => $categorys,
            ));
        } else {
            if (!isset($this->category_cache[$catid])) {
                $this->show_message('栏目不存在');
            }

            $modelid = $this->category_cache[$catid]['modelid'];
            $model = get_cache('contentmodel');
            if (!isset($model[$modelid])) {
                $this->show_message('模型不存在');
            }

            // 投稿权限验证
            if ($this->category_cache[$catid]['ispost'] != 1) {
                $this->show_message('该栏目不能投稿');
            }

            $fields = $model[$modelid]['fields'];
            if ($this->category_cache[$catid]['child']) {
                $this->show_message('该栏目不能发布，请在其子栏目中发布');
            }

            if ($this->post('data') && $this->isPostForm()) {
                if (!$this->checkCode($this->post('code'))) {
                    $this->show_message('验证码不正确');
                }

                $data = $this->post('data');
                $data['catid'] = $catid;
                $data['username'] = get_user_ip();
                $data['time'] = time();
                $data['create_time'] = $data['time']; // 创建时间
                $data['status'] = 0;
                $data['modelid'] = (int) $modelid;
                if (empty($data['title'])) {
                    $this->show_message('请填写标题');
                }

                $this->checkFields($fields, $data, 3);
                $result = $this->content->set(0, $model[$modelid]['tablename'], $data);
                $data['id'] = $result;
                if (!is_numeric($result)) {
                    $this->show_message($result);
                }

                $this->content->url($result, getUrl($data));
                $this->show_message('投稿成功，需要管理员审核之后才能显示', 1, url('index'));
            }
            //自定义字段
            $data_fields = $this->getFields($fields);
            $this->view->assign(array(
                'model' => $model[$modelid],
                'catid' => $catid,
                'data_fields' => $data_fields,
            ));
        }
        $this->view->assign(array(
            'site_title' => '在线投稿 - ' . $this->site_config['SITE_NAME'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
            'page_title' => '在线投稿',
            'page_url' => url('index/post'),
            'page_position' => "<a href=\"" . url('index/post') . "\" title=\"在线投稿\">在线投稿</a>",
        ));
        $this->view->display('post.html');
    }

    /*
     * 表单提交页面
     */
    public function formAction()
    {
        $modelid = (int) $this->get('modelid');
        if (empty($modelid)) {
            $this->show_message('表单模型参数不存在');
        }

        $formmodel = get_cache('formmodel');
        $model = $formmodel[$modelid];
        unset($formmodel);
        if (empty($model)) {
            $this->show_message('表单模型' . $modelid . '不存在');
        }

        $this->form = core::load_model($model['tablename']);
        $this->modelid = $modelid;

        $cid = (int) $this->get('cid');
        $joinmodel = get_cache('joinmodel');
        $joindata = isset($joinmodel[$model['joinid']]) ? $joinmodel[$model['joinid']] : null;
        $backurl = null;
        if ($joindata && empty($cid)) {
            $this->show_message('cid参数不能为空，缺少关联' . $joindata['modelname'] . 'id');
        }

        if ($joindata) { //关联内容数据
            $cdata = null;
            if ($joindata['typeid'] == 1) {
                $cdata = $this->content->getOne('id=' . $cid . ' AND modelid=' . $model['joinid']);
                $backurl = isset($cdata['url']) ? $cdata['url'] : null;
            } elseif ($joindata['typeid'] == 2) {
                $cdata = $this->member->getOne('id=' . $cid . ' AND modelid=' . $model['joinid']);
            }
            if (empty($cdata)) {
                $this->show_message('关联' . $joindata['modelname'] . 'id:' . $cid . '不存在');
            }

        }
        if ($this->isPostForm()) {
            //会员投稿权限验证
            if ($model['setting']['form']['code'] && !$this->checkCode($this->post('code'))) {
                $this->show_message('验证码不正确');
            }

            if ($model['setting']['form']['post'] && empty($this->memberinfo)) {
                $this->show_message('游客不允许提交');
            }

            if ($model['setting']['form']['num'] && $this->check_num($joindata, $cid)) {
                $this->show_message('您已经提交过了，不能重复提交');
            }

            if ($model['setting']['form']['time'] && $this->check_ip($joindata, $cid, $model['setting']['form']['time'])) {
                $this->show_message('同一IP在' . $model['setting']['form']['time'] . '分钟内不能重复提交');
            }

            $data = $this->post('data');
            $this->checkFields($model['fields'], $data, 3);
            $data['cid'] = $cid;
            $data['ip'] = get_user_ip();
            $data['userid'] = empty($this->memberinfo) ? 0 : $this->memberinfo['id'];
            $data['username'] = empty($this->memberinfo) ? '' : $this->memberinfo['username'];
            $data['time'] = time();
            $data['status'] = empty($model['setting']['form']['check']) ? 1 : 0;
            //数组转化为字符
            foreach ($data as $i => $t) {
                if (is_array($t)) {
                    $data[$i] = array2string($t);
                }

            }
            if ($data['id'] = $this->form->insert($data)) {
                if (!$backurl) {$backurl = HTTP_REFERER;}

                $this->show_message($data['status'] ? '提交成功' : '提交成功，等待审核', 1, $backurl);
            } else {
                $this->show_message('提交失败');
            }
        }
        $this->view->assign(array(
            'site_title' => $model['modelname'] . ' - ' . $this->site_config['SITE_NAME'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],

            'modelid' => $modelid,
            'form_name' => $model['modelname'],
            'table' => $model['tablename'],
            'fields' => $this->getFields($model['fields'], null, $model['setting']['form']['field']),
            'code' => $model['setting']['form']['code'],
            'cdata' => $cdata,
            'joindata' => $joindata,
        ));
        $this->view->display($model['categorytpl']);
    }

    /*
     * 表单提交同一会员（游客）提交一次
     */
    private function check_num($joindata, $cid)
    {
        if (empty($this->memberinfo)) {
            $select = $this->form->from(null, 'id');
            $select->where('ip=?', client::get_user_ip());
            $select->where('userid=0 AND username=?', '');
            if ($joindata && $cid) {
                $select->where('cid=' . $cid);
            }

            $data = $select->select(false);
            if ($data) {
                return true;
            }

        } else {
            $select = $this->form->from(null, 'id');
            $select->where('userid=?', $this->memberinfo['id']);
            $select->where('username=?', $this->memberinfo['username']);
            if ($joindata && $cid) {
                $select->where('cid=' . $cid);
            }

            $data = $select->select(false);
            if ($data) {
                return true;
            }

        }
        return false;
    }

    /*
     * 表单提交同一IP提交间隔
     */
    private function check_ip($joindata, $cid, $time)
    {
        $time = $time * 60; //秒
        $select = $this->form->from(null, 'id,time');
        $select->where('ip=?', get_user_ip());
        if ($joindata && $cid) {
            $select->where('cid=' . $cid);
        }

        $select->order('time DESC');
        $data = $select->select(false);
        if (empty($data)) {
            return false;
        }

        if (time() - $data['time'] < $time) {
            return true;
        }

        return false;
    }

    /**
     * 站点地图
     */
    public function sitemapAction()
    {
        $this->view->assign(array(
            'site_title' => '网站地图 - ' . $this->site_config['SITE_TITLE'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
            'page_title' => '网站地图',
            'page_url' => url('index/sitemap'),
            'page_position' => "<a href=\"" . url('index/sitemap') . "\" title=\"网站地图\">网站地图</a>",
        ));
        $this->view->display('sitemap.html');
    }
}

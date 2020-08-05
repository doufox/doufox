<?php
if (!defined('IN_CMS')) {
    exit();
}

class IndexController extends API
{
    private $memberdata;
    private $form;
    private $cmodel;
    private $nav;

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->response();
    }

    /**
     * 内容展示
     */
    public function showAction()
    {
        $page = (int) $this->get('page');
        $page = $page ? $page : 1;
        $id = (int) $this->get('id');
        $data = $this->content->find($id);
        if (empty($data)) {
            $this->response(404, NULL, '内容不存在！');
            exit();
        }
        if (!$data['status']) {
            $this->response(401, NULL, '内容正在审核中不能查看！');
            exit();
        }
        $model = get_cache('contentmodel');
        if (!isset($model[$data['modelid']]) || empty($model[$data['modelid']])) {
            $this->response(401, NULL, '内容模型不存在！');
            exit();
        }
        $catid = $data['catid'];
        $cat = $this->category_cache[$catid];
        if ($cat['islook'] && !$this->getMember) {
            $this->response(401, NULL, '当前栏目游客不允许查看！');
            exit();
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
            'pageurl' => getUrl($data, '{page}'),
            'pagination' => $pagination,
        );
        $tmp = array_merge($tmp, $data);
        $this->response(200, $tmp, 'success');
    }

    /**
     * 移动客户端模板Ajax数据调用
     */
    public function mobiledataAction()
    {
        $tpl = $this->post('tpl');
        $page = $this->post('page');
        $catid = $this->post('catid');
        $this->view->assign(array(
            'page' => $page + 1,
            'catid' => $catid,
        ));
        $this->view->display($tpl);
    }

    /**
     * 移动客户端获取栏目数据
     */
    public function categoryAction()
    {
        $this->view->assign('site_title', '栏目-' . $this->site_config['SITE_NAME']);
        $this->response(200, $this->view, 'success');
    }

    /**
     * Jquery-autocomplete插件搜索提示
     */
    public function searchAction()
    {
        $kw = str_replace(' ', '%', urldecode($this->get('q')));
        $mid = (int) $this->get('modelid');
        if ($kw) {
            $query = $this->content->where('title like ?', '%' . $kw . '%');
            $query->where('status!=0');
            if ($mid) {
                $query->where('modelid=' . $mid);
            }

            $data = $query->order('time desc')->limit(10)->select();
            if ($data) {
                foreach ($data as $t) {
                    echo $t['title'] . PHP_EOL;
                }
            }
        }
    }

    /**
     * 会员登录信息JS调用
     */
    public function userAction()
    {
        ob_start();
        $this->view->display('member/user.html');
        $html = ob_get_contents();
        ob_clean();
        $html = addslashes(str_replace(array("\r", "\n", "\t", chr(13)), array('', '', '', ''), $html));
        echo 'document.write("' . $html . '");';
    }

    /**
     * 更新浏览数
     */
    public function hitsAction()
    {
        $id = (int) $this->get('id');
        if (empty($id)) {
            exit('document.write(\'0\');');
        }

        $data = $this->content->find($id, 'hits');
        if (empty($data)) {
            exit('document.write(\'0\');');
        }

        $hits = $data['hits'] + 1;
        $this->content->update(array('hits' => 'hits+1'), 'id=' . $id);
        echo "document.write('$hits');";
    }

    /**
     * 更新浏览统计,测试用
     */
    public function countAction()
    {
        header('Content-Type:application/json');
        $id = (int) $this->get('id');
        if (empty($id)) {
            $raw = array(
                'code' => 200,
                'data' => array(
                    'hits' => 0,
                ),
                'message' => 'success',
            );
            $raw = json_encode($raw);
            exit($raw);
        }
        $data = $this->content->find($id, 'hits');
        if (empty($data)) {
            $raw = array(
                'code' => 200,
                'data' => array(
                    'hits' => 0,
                ),
                'message' => 'success',
            );
            $raw = json_encode($raw);
            exit($raw);
        }
        $count = $data['hits'] + 1;
        $this->content->update(array('hits' => 'hits+1'), 'id=' . $id);
        $raw = array(
            'code' => 200,
            'data' => array(
                'hits' => $count,
            ),
            'message' => 'success',
        );
        $raw = json_encode($raw);

        echo $raw;
    }

    /**
     * 生成拼音
     */
    public function pinyinAction()
    {
        echo word2pinyin($this->post('name'));
    }

}

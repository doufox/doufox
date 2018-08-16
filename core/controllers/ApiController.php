<?php

class ApiController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取关键字
     */
    public function ajaxkwAction()
    {
        $data = $this->post('data');
        if (empty($data)) {
            exit('');
        }

        echo getKw($data);
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
        $this->view->display('category.html');
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
     * 验证码
     */
    public function checkcodeAction()
    {
        $api = xiaocms::load_class('checkcode');
        $width = $this->get('width');
        $height = $this->get('height');
        if ($width) {
            $api->width = $width;
        }

        if ($height) {
            $api->height = $height;
        }

        $api->doimage();
        $this->session->set('checkcode', $api->get_code());
    }

    /**
     * 生成拼音
     */
    public function pinyinAction()
    {
        echo word2pinyin($this->post('name'));
    }

}

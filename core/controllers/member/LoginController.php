<?php

class LoginController extends Member
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 登录
     */
    public function indexAction()
    {
        if (!$this->isLogin(1)) {
            $this->show_message('您不能重复登录', 2, url('member/index'));
        }

        if ($this->isPostForm()) {
            $data = $this->post('data');
            if ($this->site_config['MEMBER_LOGINCODE'] && !$this->checkCode($this->post('code'))) {
                $this->show_message('验证码不正确');
            }

            if (empty($data['username']) || empty($data['password'])) {
                $this->show_message('用户名或密码不能为空');
            }

            $member = $this->member->where('username=?', $data['username'])->select(false);
            $time = empty($data['cookie']) ? 24 * 3600 : 360 * 24 * 3600; //会话保存时间。
            $backurl = $data['back'] ? urldecode($data['back']) : url('member/index');
            if (empty($member)) {
                $this->show_message('会员名不存在');
            }

            if ($member['password'] != md5(md5($data['password']))) {
                $this->show_message('密码错误');
            }

            $this->cookie->set('member_id', $member['id'], $time);
            $this->cookie->set('member_code', substr(md5($this->site_config['RAND_CODE'] . $member['id']), 5, 20), $time);
            $this->show_message('登录成功', 1, $backurl);
        }
        $backurl = $this->get('back') ? $this->get('back') : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('member/index'));
        $this->view->assign(array(
            'config' => $this->site_config,
            'site_title' => '会员登录 - ' . $this->site_config['SITE_NAME'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
            'page_title' => '会员登录',
            'page_url' => url('member/login'),
            'page_position' => "<a href=\"" . url('member/login') . "\" title=\"会员登录\">会员登录</a>",
            'backurl' => urlencode($backurl),
        ));
        $this->view->display('member/login.html');
    }

    /**
     * 退出登录
     */
    public function outAction()
    {
        if ($this->session->get('member_id')) {
            $this->session->delete('member_id');
        }

        if ($this->cookie->get('member_id')) {
            $this->cookie->delete('member_id');
        }

        if ($this->cookie->get('member_code')) {
            $this->cookie->delete('member_code');
        }

        $this->show_message('退出成功', 1, '/');
    }

}

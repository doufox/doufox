<?php

class RegisterController extends Member
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 注册
     */
    public function indexAction()
    {
        if (!$this->site_config['MEMBER_REGISTER']) {
            $this->show_message('系统未开放会员注册功能');
        }

        if (!$this->isLogin(1)) {
            $this->show_message('您已经登录了，不能再次注册。', url('member/'));
        }

        if ($this->isPostForm()) {
            $data = $this->post('data');
            if ($this->site_config['MEMBER_REGCODE'] && !$this->checkCode($this->post('code'))) {
                $this->show_message('验证码不正确');
            }

            $this->check($data);
            $uid = $this->reg($data);
            if (empty($uid)) {
                $this->show_message('注册失败');
            }

            $this->cookie->set('member_id', $uid, 24 * 3600); //登录cookie
            $this->cookie->set('member_code', substr(md5($this->site_config['RAND_CODE'] . $uid), 5, 20), $time);
            $this->show_message('注册成功', 1, url('member/index'));
        }
        $this->view->assign(array(
            'config' => $this->site_config,
            'membermodel' => $this->membermodel,
            'site_title' => '会员注册 - ' . $this->site_config['SITE_NAME'],
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
            'member_default_modelid' => $this->site_config['MEMBER_MODELID'],

        ));
        $this->view->display('member/register.html');
    }

    /**
     * 验证
     */
    private function check($data)
    {

        if (empty($data['username'])) {
            $this->show_message('请填写会员名');
        }

        if (!$this->is_username($data['username'])) {
            $this->show_message('两次输入密码不一致');
        }

        if (empty($data['password'])) {
            $this->show_message('密码不能为空');
        }

        if ($data['password'] != $data['password2']) {
            $this->show_message('两次输入密码不一致');
        }

        if (!is_email($data['email'])) {
            $this->show_message('邮箱格式不正确');
        }

        $member = $this->member->from(null, 'id')->where('email=?', $data['email'])->select(false);
        if ($member) {
            $this->show_message('邮箱已经存在，请重新注册');
        }

        $member = $this->member->from(null, 'id')->where('username=?', $data['username'])->select(false);
        if ($member) {
            $this->show_message('会员已经存在');
        }

    }

    /**
     * 注册
     */
    private function reg($data)
    {
        if (empty($data)) {
            return false;
        }

        $data['regdate'] = time();
        $data['regip'] = get_user_ip();
        $data['status'] = $this->site_config['MEMBER_STATUS'] ? 0 : 1;
        $data['modelid'] = (!isset($data['modelid']) || empty($data['modelid'])) ? $this->site_config['MEMBER_MODELID'] : $data['modelid'];
        if (!isset($this->membermodel[$data['modelid']])) {
            $this->show_message('会员模型不存在');
        }

        $data['password'] = md5(md5($data['password']));
        return $this->member->insert($data);
    }

    /**
     * 检查会员名是否符合规定
     */
    private function is_username($username)
    {
        $strlen = strlen($username);
        if (!preg_match('/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/', $username)) {
            return false;
        } elseif (20 < $strlen || $strlen < 2) {
            return false;
        }
        return true;
    }

}

<?php
if (!defined('IN_CMS')) {
    exit();
}

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
            $this->show_message('系统未开放用户注册功能');
        }

        if (!$this->isLogin(1)) {
            $this->show_message('您已经登录了，不能再次注册。', url('member/index'));
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
            'membermodel' => $this->membermodel,
            'site_title' => '用户注册 - ' . $this->site_config['SITE_NAME'],
            'page_title' => '用户注册',
            'page_url' => url('member/register'),
            'page_position' => '<a href="' . url('member/register') . '" title="用户注册">用户注册</a>',
            'site_keywords' => $this->site_config['SITE_KEYWORDS'],
            'site_description' => $this->site_config['SITE_DESCRIPTION'],
            'member_default_modelid' => $this->site_config['MEMBER_MODELID'],
            'member_logincode' => $this->site_config['MEMBER_LOGINCODE'],
        ));
        $this->view->display('member/register.html');
    }

    /**
     * 验证表单内容
     */
    private function check($data)
    {

        if (empty($data['username'])) {
            $this->show_message('用户名不能为空', 2);
        }

        if (!verify_username($data['username'])) {
            $this->show_message('用户名不规范', 2);
        }

        if ($this->member->getOne('username=?', $data['username'])) {
            $this->show_message('用户名【' . $data['username'] . '】已经存在', 2);
        }

        if (empty($data['password'])) {
            $this->show_message('密码不能为空', 2);
        }

        if (strlen($data['password']) < 6) {
            $this->show_message('密码最少6位数', 2);
        }

        if ($data['password'] != $data['password2']) {
            $this->show_message('两次输入密码不一致', 2);
        }

        if (!verify_email($data['email'])) {
            $this->show_message('邮箱格式不正确', 2);
        }

        if ($this->member->getOne('email=?', $data['email'])) {
            $this->show_message('邮箱已注册，请使用其它邮箱');
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

        $data['modelid'] = (!isset($data['modelid']) || empty($data['modelid'])) ? $this->site_config['MEMBER_MODELID'] : $data['modelid'];
        if (!isset($this->membermodel[$data['modelid']])) {
            $this->show_message('用户模型不存在');
        }
        $data['regdate'] = time();
        $data['regip'] = get_user_ip();
        $data['status'] = $this->site_config['MEMBER_STATUS'] ? 0 : 1;
        $data['password'] = md5(md5($data['password']));
        return $this->member->insert($data);
    }

}

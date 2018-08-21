<?php

class LoginController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $admin = cms::load_config('admin');

        $url = isset($_GET['url']) && $_GET['url'] ? urldecode($this->get('url')) : url('admin//');
        if ($this->isPostForm()) {
            if (!$this->checkCode($this->post('code'))) {
                $this->show_message('验证码不正确');
            }

            if ($this->cookie->get('admin_login')) {
                $this->show_message('密码错误次数过多，请15分钟后重新登录');
            }

            if (isset($this->site['SITE_ADMIN_CODE']) && $this->site['SITE_ADMIN_CODE'] && !$this->checkCode($this->post('code'))) {
                $this->adminMsg(lang('code'), url('admin/login'));
            }

            $username = $this->post('username');
            $password = $this->post('password');
            if ($admin['ADMIN_NAME'] == $username && $admin['ADMIN_PASS'] == md5(md5($password))) {
                $this->session->set('user_id', $username);
                if ($this->session->get('admin_login_error_num')) {
                    $this->session->delete('admin_login_error_num'); // 如果存在登录错误次数则删除
                }
                $this->show_message('登录成功', 1, $url);
            } else {
                if ($this->session->get('admin_login_error_num')) {
                    $error = (int) $this->session->get('admin_login_error_num') - 1;
                    if ($error <= 1) {
                        $this->session->delete('admin_login_error_num');
                        $this->cookie->set('admin_login', 1, 60 * 15);
                    } else {
                        $this->session->set('admin_login_error_num', $error);
                    }
                } else {
                    $error = 10;
                    $this->session->set('admin_login_error_num', 10);
                }
                $this->show_message('账户或密码不正确，您还可以尝试' . $error . '次', 2, url('admin/login', array('url' => $this->get('url'))));
            }
        }
        include $this->admin_tpl('login');
    }

    public function logoutAction()
    {
        if ($this->session->get('user_id')) {
            $this->session->delete('user_id');
        }

        $this->show_message('已经退出登录', 1, url('admin/login'));
    }
}

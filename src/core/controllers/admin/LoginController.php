<?php
if (!defined('IN_CMS')) {
    exit();
}

class LoginController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $isneedcode = $this->site_config['ADMIN_LOGINCODE'];
        if ($this->isPostForm()) {
            if (isset($isneedcode) && $isneedcode && !$this->checkCode($this->post('code'))) {
                $this->show_message('验证码不正确', 2, url('admin/login'));
            }

            if ($this->cookie->get('admin_login')) {
                $this->show_message('密码错误次数过多，请15分钟后重新登录');
            }

            $username = $this->post('username');
            $password = $this->post('password');
            $admin = $this->account->getOne('username=?', $username);
            if ($admin['username'] == $username && $admin['password'] == md5(md5($password))) {
                session::set('user_id', $admin['userid']);
                if (session::get('admin_login_error_num')) {
                    session::delete('admin_login_error_num');
                }
                $name = $admin['realname'] ? $admin['realname'] : $username;
                $this->show_message('欢迎您！' . $name . ' 登录成功', 1, url('admin'));
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
                $this->show_message('账户或密码不正确，您还可以尝试' . $error . '次', 2, url('admin/login'));
            }
        }

        include $this->admin_view('access/login');
    }

    public function forgotAction()
    {
        // if ($this->session->get('user_id')) {
        //     $this->session->delete('user_id');
        // }
        // $this->show_message('已经退出登录', 1, url('admin/login'));
        include $this->admin_view('access/forgot');
    }

    public function pswdresetAction()
    {
        // if ($this->session->get('user_id')) {
        //     $this->session->delete('user_id');
        // }
        // $this->show_message('已经退出登录', 1, url('admin/login'));
        include $this->admin_view('access/resetpswd');
    }

    public function logoutAction()
    {
        if ($this->session->get('user_id')) {
            $this->session->delete('user_id');
        }

        $this->show_message('已经退出登录', 1, url('admin/login'));
    }
}

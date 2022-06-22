<?php
if (!defined('IN_CRONLITE')) {
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
                $this->show_message('密码错误次数过多，请15分钟后重新登录', 2, url('admin/login'));
            }

            $username = $this->post('username');
            if (empty($username)) {
                $this->show_message('用户名不能为空', 2, url('admin/login'));
            }

            $password = $this->post('password');
            if (empty($password)) {
                $this->show_message('密码不能为空', 2, url('admin/login'));
            }

            // $admin = $this->account->getOne('username=?', $username);
            $admin = $this->member->getOne('username=?', $username);
            if ($admin['password'] == md5(md5($password))) {
                $_memberinfo = $this->member->find($admin['id']);
                $member_table = $this->membermodel[$_memberinfo['modelid']]['tablename'];
                if ($_memberinfo && $member_table == 'member_admin') {
                    session::set('member_id', $admin['id']);

                    $time = empty($data['cookie']) ? 24 * 3600 : 360 * 24 * 3600; // 会话保存时间。
                    $this->cookie->set('member_id', $admin['id'], $time);
                    $this->cookie->set('member_code', substr(md5($this->site_config['RAND_CODE'] . $admin['id']), 5, 20), $time);

                    if (session::get('admin_login_error_num')) {
                        session::delete('admin_login_error_num');
                    }

                    // $name = $admin['realname'] ? $admin['realname'] : $username;
                    $back_url = $this->get('url');
                    if ($back_url) {
                        $this->redirect(urldecode($back_url));
                    } else {
                        $this->redirect(url('admin'));
                    }
                    // $this->show_message('欢迎您！' . $name . ' 登录成功', 1, url('admin'));
                }
            }
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

        include $this->views('admin/access/login');
    }

    public function forgotAction()
    {
        include $this->views('admin/access/forgot');
    }

    public function pswdresetAction()
    {
        include $this->views('admin/access/resetpswd');
    }

    public function logoutAction()
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

        $this->show_message('已经退出登录', 1, url('admin/login'));
    }
}

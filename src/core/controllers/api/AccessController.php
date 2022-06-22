<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class AccessController extends API
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
        if ($this->is_logged()) {
            $data = array(
                'profile' => url('member/index/edit'),
                'content' => url('member/content'),
                'password' => url('member/index/password'),
            );
        } else {
            $data = array(
                'login' => url('member/login'),
                'register' => url('member/register'),
                'post' => url('index/post'),
            );
        }
        $this->response(401, $data, 'what do you want to do');
    }

    /**
     * 验证码
     */
    public function checkcodeAction()
    {
        $checkcode = core::load_class('checkcode');
        $width = $this->get('width');
        $height = $this->get('height');
        if ($width) {
            $checkcode->width = $width;
        }

        if ($height) {
            $checkcode->height = $height;
        }

        $checkcode->doimage();

        $this->session->set('checkcode', $checkcode->get_code());
    }

}

<?php

class AccessController extends Api
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
     * 验证码
     */
    public function checkcodeAction()
    {
        $api = cms::load_class('checkcode');
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

}

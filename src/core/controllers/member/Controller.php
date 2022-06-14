<?php
if (!defined('IN_CMS')) {
    exit();
}

class Member extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 前台登陆检查
     */
    protected function isLogin($return = 0)
    {
        if ($this->memberinfo) {
            return false;
        }
        if ($return) {
            return true;
        }

        $back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : url('member/index');
        $this->redirect(url('member/login', array('back' => urlencode($back))));
    }

}

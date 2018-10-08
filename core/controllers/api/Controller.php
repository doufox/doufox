<?php

class Api extends Controller
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

    protected function inlogged()
    {
        if ($this->memberinfo) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * API Response
     */
    public function response($code = 400, $data = array(), $msg = 'error')
    {
        header('Content-Type:application/json');
        $raw = array(
            'code' => $code,
            'data' => isset($data) ? $data : new ArrayObject(),
            'msg' => $msg,
        );
        $raw = json_encode($raw);
        echo $raw;
    }
}

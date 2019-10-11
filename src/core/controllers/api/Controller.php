<?php

class Api extends Controller
{

    protected $userid;

    public function __construct()
    {
        parent::__construct();
        $this->userid = $this->session->get('user_id');
    }

    /**
     * 前台登陆检查
     */
    public function is_admin_login($return = 0)
    {
        $userid = $this->session->get('user_id');
        if (empty($this->userid)) {
            $this->response(401, null, 'Unauthorized');
        }
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
        // echo $raw;
        exit($raw);
    }
}

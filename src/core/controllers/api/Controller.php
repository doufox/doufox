<?php
if (!defined('IN_CMS')) {
    exit();
}

class API extends Controller
{

    protected $userid;

    public function __construct()
    {
        parent::__construct();
        $this->userid = $this->session->get('member_id');
    }

    /**
     * 前台登陆检查
     */
    public function is_admin_login($return = 0)
    {
        $userid = $this->session->get('member_id');
        if (empty($this->userid)) {
            $this->response(401, NULL, 'Unauthorized');
        }
    }

    /**
     * 是否POST请求类型
     */
    public static function is_post()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    /**
     * 是否GET请求类型
     */
    public static function is_get()
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }

    /**
     * API Response
     */
    public function response($code = 400, $data = NULL, $msg = 'Error')
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        // header("Access-Control-Allow-Headers: DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Authorization");
        header("Content-Type: application/json");
        $raw = array(
            'code' => $code,
            'data' => isset($data) && !empty($data) ? $data : NULL,
            'msg' => $msg,
        );
        $raw = json_encode($raw);
        // echo $raw;
        exit($raw);
    }
}

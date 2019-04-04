<?php

class MemberController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->response();
    }

    /**
     * Email是否重复检查
     */
    public function ajaxemailAction()
    {
        $email = $this->post('email');
        if (empty($email)) {
            $this->response(200, 'empty', 'Email 地址不能为空');
            exit();
        }
        if (!verify_email($email)) {
            $this->response(200, 'incorrect', 'Email 地址格式不正确');
            exit();
        }
        $id = $this->post('id');
        $where = $id ? "email='" . $email . "' and id<>" . $id : "email='" . $email . "'";
        $data = $this->member->getOne($where);
        if ($data) {
            $this->response(200, 'existed', 'Email 地址已经存在');
            exit();
        }
        $this->response(200, 'available', 'Email 地址可以使用');
        exit();
    }

}

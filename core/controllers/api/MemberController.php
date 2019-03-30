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
        if (!verify_email($email)) {
            $this->response(200, null, 'Email格式不正确');
            exit();
        }
        $id = $this->post('id');
        if (empty($email)) {
            $this->response(200, null, 'Email不能为空');
            exit();
        }
        $where = $id ? "email='" . $email . "' and id<>" . $id : "email='" . $email . "'";
        $data = $this->member->getOne($where);
        if ($data) {
            $this->response(200, null, 'Email已经存在');
            exit();
        }
        $this->response(200, null, 'Email 可以使用');
        exit();
    }

}

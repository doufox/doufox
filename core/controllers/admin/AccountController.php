<?php
/**
 * 后台账号管理
 */
class AccountController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->show_message('账号管理');
    }

}

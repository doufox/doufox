<?php
if (!defined('IN_CMS')) {
    exit();
}

class WeixinController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->response(401, null, 'Weixin Api');
    }

}

<?php
if (!defined('IN_CMS')) {
    exit();
}

class BackupController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        include $this->admin_view('backup');
    }

}

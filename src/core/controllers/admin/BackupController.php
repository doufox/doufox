<?php
if (!defined('IN_CRONLITE')) {
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
        include $this->views('admin/backup');
    }

}

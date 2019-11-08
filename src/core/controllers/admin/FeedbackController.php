<?php

class FeedbackController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        include $this->admin_view('feedback/help');
    }
}

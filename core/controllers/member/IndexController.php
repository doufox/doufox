<?php

class IndexController extends Member
{
    private $memberdata;
    private $form;
    private $cmodel;
    private $nav;
    public function __construct()
    {
        parent::__construct();
        $this->isLogin(); //登录验证
        $this->memberdata = xiaocms::load_model($this->membermodel[$this->memberinfo['modelid']]['tablename']);

        if (!$this->memberinfo['status']) {
            $this->show_message('您还没有通过审核。', 2, url('index/index/'));
        }
        //判断审核
        $this->form = $this->getFormMember();
        $this->cmodel = get_cache('model');
        $navigation = $this->nav = array();
        if ($this->cmodel) {
            foreach ($this->cmodel as $t) {
                $navigation[$t['modelid']] = array('name' => $t['modelname'], 'url' => url('member/content/', array('modelid' => $t['modelid'])));
                if (empty($this->nav)) {
                    $this->nav = url('member/content/', array('modelid' => $t['modelid']));
                }

            }
        }
        if ($this->form) {
            foreach ($this->form as $t) {
                $navigation[$t['tablename']] = array('name' => $t['modelname'], 'url' => url('member/content/form', array('modelid' => $t['modelid'])));
                if (empty($this->nav)) {
                    $this->nav = url('member/content/form', array('modelid' => $t['modelid']));
                }

            }
        }
        $this->view->assign('navigation', $navigation);
    }

    public function indexAction()
    {
        $this->view->assign(array(
            'member_index' => 1,
            'model' => get_cache('model'),
            'form' => $this->getFormMember(),
            'site_title' => '会员中心 - ' . $this->site_config['SITE_NAME'],
        ));
        $this->view->display('member/index.html');
    }

    /**
     * 会员列表
     */
    public function listAction()
    {
        $page = (int) $this->get('page');
        $page = $page ? $page : 1;
        $mid = (int) $this->get('modelid');
        if ($mid && !isset($this->membermodel[$mid])) {
            $this->show_message('会员模型不存在');
        }

        $this->view->assign(array(
            'page' => $page,
            'modelid' => $mid,
        ));
        $this->view->display('list_member.html');
    }

    /**
     * 资料修改
     */
    public function editAction()
    {
        $modelid = $this->memberinfo[modelid];
        $fields = $this->membermodel[$modelid]['fields'];
        if ($this->isPostForm()) {
            $data = $this->post('data');
            $memberdata = $this->memberdata->find($this->memberinfo['id']);
            if (is_array($data)) {
                foreach ($data as $i => $t) {
                    if (is_array($t)) {
                        $data[$i] = array2string($t);
                    }
                }}
            if ($memberdata) {
                //修改附表内容
                $this->memberdata->update($data, 'id=' . $this->memberinfo['id']);
            } else {
                $data['id'] = $this->memberinfo['id'];
                $this->memberdata->insert($data);
            }
            $this->show_message('修改成功', 1, url('member/index/edit'));
        }
        //自定义字段
        $data_fields = $this->getFields($fields, $this->memberinfo);
        $this->view->assign(array(
            'data_fields' => $data_fields,
            'site_title' => '修改资料 - 会员中心 - ' . $this->site_config['SITE_NAME'],
        ));
        $this->view->display('member/edit.html');
    }

    /**
     * 密码修改
     */
    public function passwordAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (empty($data['password2'])) {
                $this->show_message('新密码不能为空。');
            }

            if ($data['password2'] != $data['password3']) {
                $this->show_message('两次密码输入不一致。');
            }

            $this->member->update(array('password' => md5(md5($data['password2']))), 'id=' . $this->memberinfo['id']);
            $this->show_message('操作成功', 1, url('member/index/password'));
        }
        $this->view->assign(array(
            'site_title' => '修改密码 - 会员中心 - ' . $this->site_config['SITE_NAME'],
        ));
        $this->view->display('member/password.html');
    }

}

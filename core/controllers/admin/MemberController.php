<?php

class MemberController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        if ($this->post('submit_status_1') && $this->post('form') == 'status_1') {
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_mid) = explode('_', $ids);
                    $this->member->update(array('status' => 1), 'id=' . $_id);
                }
            }
        } elseif ($this->post('submit_status_0') && $this->post('form') == 'status_0') {
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'del_') !== false) {
                    $ids = str_replace('del_', '', $var);
                    list($_id, $_mid) = explode('_', $ids);
                    $this->member->update(array('status' => 0), 'id=' . $_id);
                }
            }
        }
        $page = (int) $this->get('page');
        $page = (!$page) ? 1 : $page;
        $modelid = (int) $this->get('modelid');
        $pagination = core::load_class('pagination');
        $pagination->loadconfig();
        $where = '1';
        if ($modelid) {
            $where .= ' and modelid=' . $modelid;
        }

        $total = $this->member->count('member', null, $where);
        $pagesize = 15; //分页数量
        $urlparam = array();
        if ($modelid) {
            $urlparam['modelid'] = $modelid;
        }

        $urlparam['status'] = $status;
        $urlparam['page'] = '{page}';
        $url = url('admin/member/index', $urlparam);
        $select = $this->member->page_limit($page, $pagesize)->order(array('status ASC', 'id DESC'));
        if ($modelid) {
            $select->where('modelid=' . $modelid);
        }

        $list = $select->select();
        $pagination = $pagination->total($total)->url($url)->num($pagesize)->page($page)->output();

        $membermodel = $this->membermodel;
        include $this->admin_tpl('member_list');
    }

    /*
     * 修改资料
     */
    public function editAction()
    {
        $id = (int) $this->get('id');
        $data = $this->member->find($id);
        if (empty($data)) {
            $this->show_message('会员不存在');
        }

        $model = $this->membermodel[$data['modelid']];
        if (empty($model)) {
            $this->show_message('会员模型不存在');
        }

        $info = core::load_model($model['tablename']);
        $_data = $info->find($id);
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if ($this->post('password')) {
                $data['password'] = md5(md5($this->post('password')));
            }

            foreach ($data as $i => $t) {
                if (is_array($t)) {
                    $data[$i] = array2string($t);
                }

            }
            $this->member->update($data, 'id=' . $id);
            if ($_data) {
                $info->update($data, 'id=' . $id); //修改附表内容
            } else {
                $data['id'] = $id;
                $info->insert($data); //新增附表内容
            }
            $this->show_message('修改成功', 1, url('admin/member/edit', array('id' => $id)));
        }
        $fields = $this->membermodel[$data['modelid']]['fields'];
        $data_fields = $this->getFields($fields, $_data);
        $count = array();
        $count[0] = $this->member->count('member', null, '1');
        $count[1] = $this->member->count('member', null, 'status=1');
        $count[2] = $this->member->count('member', null, 'status=0');
        $model = $model;
        $info = $_data;
        include $this->admin_tpl('member_edit');
    }

    /**
     * 删除会员
     */
    public function delAction()
    {
        $id = (int) $this->get('id');
        if (empty($id)) {
            $this->show_message('参数不存在');
        }

        $data = $this->member->find($id);
        if (empty($data)) {
            $this->show_message('会员不存在');
        }

        $modelist = $this->member->from('model')->where('typeid=1')->select();

        //删除会员
        $this->member->delete('id=' . $id);
        //删除模型数据
        $table = $this->membermodel[$data['modelid']]['tablename'];
        if ($table) {
            $model = core::load_model($table);
            $model->delete('id=' . $id);
        }

        //删除关联表单
        $form = get_cache('formmodel');
        if ($form) {
            foreach ($form as $m) {
                $db = core::load_model($m['tablename']);
                $db->delete('userid=' . $id);
            }
        }
        //删除会员附件目录
        $path = 'upload/member/' . $id . '/';
        if (file_exists($path)) {
            $file_list = core::load_class('file_list');

            $file_list->delete_dir($path);
        }
        $this->show_message('删除成功', 1, url('admin/member'));
    }

    /**
     * Email是否重复检查
     */
    public function ajaxemailAction()
    {
        $email = $this->post('email');
        if (!is_email($email)) {
            exit('<b><font color=red>Email格式不正确</font></b>');
        }

        $id = $this->post('id');
        if (empty($email)) {
            exit('<b><font color=red>Email不能为空</font></b>');
        }

        $where = $id ? "email='" . $email . "' and id<>" . $id : "email='" . $email . "'";
        $data = $this->member->getOne($where);
        if ($data) {
            exit('<b><font color=red>Email已经存在</font></b>');
        }

        exit('<b><font color=green>√</font></b>');
    }

}

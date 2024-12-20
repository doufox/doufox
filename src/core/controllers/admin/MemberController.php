<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

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
        $status = $this->get('status');
        $pagination = core::load_class('pagination');
        $pagination->loadconfig();
        $where = '1';
        $params = array();
        $params['page'] = '{page}';
        if ($modelid) {
            $params['modelid'] = $modelid;
            $where .= ' AND modelid=' . $modelid;
        }
        if ($status == '1') {
            $params['status'] = 1;
            $where .= ' AND status=1';
        } elseif ($status == '0') {
            $params['status'] = 0;
            $where .= ' AND status=0';
        }

        $pagesize = 15; // 分页数量
        $total = $this->member->count('member', NULL, $where);
        $url = url('admin/member/index', $params);
        $list = $this->member->page_limit($page, $pagesize)->where($where)->order(array('status ASC', 'id DESC'))->select();
        $pagination = $pagination->total($total)->url($url)->num($pagesize)->page($page)->output();
        $membermodel = $this->membermodel;
        include $this->views('admin/member/list');
    }

    /*
     * 添加用户
     */
    public function addAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            $this->check($data);
            $data['modelid'] = (!isset($data['modelid']) || empty($data['modelid'])) ? $this->site_config['MEMBER_MODELID'] : $data['modelid'];
            if (!isset($this->membermodel[$data['modelid']])) {
                $this->show_message('用户模型不存在');
            }
            $data['password'] = md5(md5($data['password']));
            $data['regdate'] = time();
            $data['regip'] = get_user_ip();
            $data['status'] = $data['status'] || 0;
            $this->member->insert($data);
            $this->show_message('添加成功', 1, url('admin/member'));
        }
        $membermodel = $this->membermodel;
        include $this->views('admin/member/add');
    }

    /*
     * 修改资料
     */
    public function editAction()
    {
        $id = (int) $this->get('id');
        $data = $this->member->find($id);
        if (empty($data)) {
            $this->show_message('ID为' . $id . '的用户不存在！');
        }

        $model = $this->membermodel[$data['modelid']];
        if (empty($model)) {
            $this->show_message('用户模型不存在');
        }
        $info = core::load_model($model['tablename']);
        if (empty($info)) {
            $this->show_message('模型文件不存在');
        }
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
        $count[0] = $this->member->count('member', NULL, '1');
        $count[1] = $this->member->count('member', NULL, 'status=1');
        $count[2] = $this->member->count('member', NULL, 'status=0');
        $info = $_data;
        include $this->views('admin/member/edit');
    }

    /**
     * 删除用户
     */
    public function delAction()
    {
        $id = (int) $this->get('id');
        if ($id == 1) {
            // 禁止删除超级管理员
            $this->show_message('禁止操作');
        }
        if (empty($id)) {
            $this->show_message('缺失参数 id');
        }

        $data = $this->member->find($id);
        if (empty($data)) {
            $this->show_message('用户不存在');
        }

        $modelist = $this->member->from('contentmodel')->where('typeid=1')->select();

        // 删除用户
        $this->member->delete('id=' . $id);
        // 删除用户模型数据
        $table = $this->membermodel[$data['modelid']]['tablename'];
        if ($table) {
            $model = core::load_model($table);
            $model->delete('id=' . $id);
        }

        // 删除关联表单
        $form = get_cache('formmodel');
        if ($form) {
            foreach ($form as $m) {
                $db = core::load_model($m['tablename']);
                $db->delete('userid=' . $id);
            }
        }
        // 删除用户附件目录
        $path = 'upload/member/' . $id . '/';
        if (file_exists($path)) {
            $file_list = core::load_class('file_list');
            $file_list->delete_dir($path);
        }
        $this->show_message('删除成功', 1, url('admin/member'));
    }

    /**
     * 验证表单内容
     */
    private function check($data)
    {

        if (empty($data['username'])) {
            $this->show_message('用户名不能为空', 2);
        }

        if (!verify_username($data['username'])) {
            $this->show_message('用户名不规范', 2);
        }

        if ($this->member->getOne('username=?', $data['username'])) {
            $this->show_message('用户名【' . $data['username'] . '】已经存在', 2);
        }

        if (empty($data['password'])) {
            $this->show_message('密码不能为空', 2);
        }

        if (strlen($data['password']) < 6) {
            $this->show_message('密码最少6位数', 2);
        }

        if (!verify_email($data['email'])) {
            $this->show_message('邮箱格式不正确');
        }

        if ($this->member->getOne('email=?', $data['email'])) {
            $this->show_message('邮箱已注册，请使用其它邮箱');
        }
    }
}

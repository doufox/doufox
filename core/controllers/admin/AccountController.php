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
        $list = $this->account->select();
        include $this->admin_tpl('account/list');
    }

    public function addAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (!$data['username']) {
                $this->show_message('用户名不能为空', 2);
            }

            if (strlen($data['password']) < 6) {
                $this->show_message('密码最少6位数', 2);
            }

            $data['password'] = md5(md5($data['password']));
            if ($this->account->getOne('username=?', $data['username'])) {
                $this->show_message('已存在相同的用户名', 2);
            }

            $auth = $this->post('auth');
            $data['auth'] = array2string($auth);
            $this->account->insert($data);
            $this->cacheAction();
            $this->show_message('添加成功', 1, url('admin/account'));
        }
        $cats = get_cache('category');
        include $this->admin_tpl('account/add');
    }

    public function editAction()
    {
        $userid = (int) $this->get('userid');
        $data = $this->account->find($userid);
        $auth = string2array($data['auth']);
        $cats = get_cache('category');

        if (empty($data)) {
            $this->show_message('该用户不存在', 2);
        }

        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $this->show_message('密码最少6位数', 2);
                }
                $data['password'] = md5(md5($data['password']));
            } else {
                unset($data['password']);
            }
            $auth = $this->post('auth');
            $data['auth'] = array2string($auth);
            $this->account->update($data, 'userid=?', $userid);
            $this->cacheAction();
            $this->show_message('修改成功', 1);
        }
        include $this->admin_tpl('account/add');
    }

    public function delAction()
    {
        $userid = (int) $this->get('userid');
        if (empty($userid)) {
            $this->show_message('用户不存在', 2);
        }

        if ($this->userid == $userid) {
            $this->show_message('自己不能删除自己', 2);
        }

        $this->account->delete('userid=?', $userid);
        $this->cacheAction();
        $this->show_message('删除成功', 1, url('admin/account'));
    }

    /**
     * 更新缓存文件
     */
    public function cacheAction()
    {
        $data = array();
        foreach ($this->account->select() as $t) {
            unset($t['password']);
            $data[$t['userid']] = $t;
        }
        set_cache('account', $data);
    }

    public function meAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (!empty($data['password'])) {
                if (strlen($data['password']) < 6) {
                    $this->show_message('密码最少6位数', 2);
                }
                $data['password'] = md5(md5($data['password']));
            } else {
                unset($data['password']);
            }
            $this->account->update($data, 'userid=?', $this->userid);
            $this->cacheAction();
            $this->show_message('修改成功', 1);
        }
        $data = $this->account->find($this->userid);
        include $this->admin_tpl('account/me');
    }
}

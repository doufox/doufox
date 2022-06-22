<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * 后台账号管理
 */
class MenuController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $list = $this->menu->select();
        $page_title = '系统账号管理';
        include $this->views('admin/menu/list');
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
            if ($this->menu->getOne('username=?', $data['username'])) {
                $this->show_message('已存在相同的用户名', 2);
            }

            $auth = $this->post('auth');
            $data['auth'] = array2string($auth);
            $this->menu->insert($data);
            $this->cacheAction();
            $this->show_message('添加成功', 1, url('admin/menu'));
        }
        $page_title = '添加账号';
        $cats = get_cache('category');
        include $this->views('admin/menu/add');
    }

    public function editAction()
    {
        $userid = (int) $this->get('userid');
        $data = $this->menu->find($userid);
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
            $this->menu->update($data, 'userid=?', $userid);
            $this->cacheAction();
            $this->show_message('修改成功', 1);
        }
        $page_title = '修改账号';
        include $this->views('admin/menu/edit');
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

        $this->menu->delete('userid=?', $userid);
        $this->cacheAction();
        $this->show_message('删除成功', 1, url('admin/menu'));
    }

    /**
     * 更新缓存文件
     */
    public function cacheAction()
    {
        $data = array();
        foreach ($this->menu->select() as $t) {
            unset($t['password']);
            $data[$t['userid']] = $t;
        }
        set_cache('menu', $data);
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
            $this->menu->update($data, 'userid=?', $this->userid);
            $this->cacheAction();
            $this->show_message('修改成功', 1);
        }
        $data = $this->menu->find($this->userid);
        $page_title = '我的信息';
        include $this->views('admin/menu/me');
    }
}

<?php
if (!defined('IN_CMS')) {
    exit();
}

/**
 * 后台账号管理
 */
class AccountController extends API
{

    public function __construct()
    {
        parent::__construct();
        $this->is_admin_login();
    }

    public function indexAction()
    {
        $this->response();
    }

    public function listAction()
    {
        $list = $this->account->select();
        $this->response(200, $list, 'OK');
    }

    public function addAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (!$data['username']) {
                $this->response(400, NULL, '用户名不能为空');
            }

            if (strlen($data['password']) < 6) {
                $this->response(400, NULL, '密码最少6位数');
            }

            $data['password'] = md5(md5($data['password']));
            if ($this->account->getOne('username=?', $data['username'])) {
                $this->response(400, NULL, '已存在相同的用户名');
            }

            $auth = $this->post('auth');
            $data['auth'] = array2string($auth);
            $this->account->insert($data);
            $this->cacheAction();
            $this->response(200, NULL, '添加成功');
        } else {
            $this->response();
        }
    }

    public function editAction()
    {
        $userid = (int) $this->get('userid');
        $data = $this->account->find($userid);
        $auth = string2array($data['auth']);
        $cats = get_cache('category');

        if (empty($data)) {
            $this->response(404, NULL, 'Not Found');
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
            $this->response(200, NULL, 'OK');
        } else {
            $this->response();
        }
    }

    public function deleteAction()
    {
        $userid = (int) $this->get('userid');
        if (empty($userid)) {
            $this->response(400, NULL, 'Need userid');
        }
        if ($this->userid == $userid) {
            $this->response(406, NULL, 'Can Not Delete Yourself');
        }
        $data = $this->account->find($userid);
        if (empty($data)) {
            $this->response(404, NULL, 'Not Found');
        }

        $this->account->delete('userid=?', $userid);
        $this->cacheAction();
        $this->response(200, NULL, 'OK');
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
                    $this->response(400, NULL, '密码最少6位数');
                }
                $data['password'] = md5(md5($data['password']));
            } else {
                unset($data['password']);
            }
            $this->account->update($data, 'userid=?', $this->userid);
            $this->cacheAction();
            $this->response(200, NULL, 'OK');
        }
        $data = $this->account->find($this->userid);
        $this->response(200, $data, 'OK');
    }
}

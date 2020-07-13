<?php
if (!defined('IN_CMS')) {
    exit();
}

class MemberController extends Api
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->response();
    }

    /**
     * 用户列表
     */
    public function listAction()
    {
        $page = (int) $this->get('page', 1); // 当前页
        if ($page < 1) {
            $this->response(403, null, '页码不能小于1');
        }
        $pagesize = (int) $this->get('pagesize', 10); // 分页大小
        if ($pagesize < 1) {
            $this->response(403, null, '分页大小不能小于1');
        }
        $modelid = (int) $this->get('modelid');
        $where = '1';
        if ($modelid) {
            $where .= ' and modelid=' . $modelid;
        }

        $total = $this->member->count('member', null, $where);
        $totalpage = ceil($total / $pagesize);
        if ($page > $totalpage) {
            $this->response(403, null, '页码超出范围');
        }

        $select = $this->member->page_limit($page, $pagesize)->order(array('status ASC', 'id DESC'));
        if ($modelid) {
            $select->where('modelid=' . $modelid);
        }
        $list = $select->from('member', 'id,nickname,avatar,status,credits,regdate')->select();
        // $list = $select->select(); // avatar,credits,email,id,modelid,nickname,password,regdate,regip,salt,status,username
        $data = array(
            'list' => $list,
            'page' => $page,
            'pagesize' => $pagesize,
            'total' => $total,
            'totalpage' => $totalpage
        );
        $this->response(200, $data, 'success');
    }

    /**
     * Email是否重复检查
     */
    public function ajaxemailAction()
    {
        $email = $this->post('email');
        if (empty($email)) {
            $this->response(200, 'empty', 'Email 地址不能为空');
            exit();
        }
        if (!verify_email($email)) {
            $this->response(200, 'incorrect', 'Email 地址格式不正确');
            exit();
        }
        $id = $this->post('id');
        $where = $id ? "email='" . $email . "' and id<>" . $id : "email='" . $email . "'";
        $data = $this->member->getOne($where);
        if ($data) {
            $this->response(200, 'existed', 'Email 地址已经存在');
            exit();
        }
        $this->response(200, 'available', 'Email 地址可以使用');
        exit();
    }
}

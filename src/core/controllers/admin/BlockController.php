<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class BlockController extends Admin
{

    private $block;
    private $type;
    private $msg_result;

    public function __construct()
    {
        parent::__construct();
        $this->block = core::load_model('block');
        $this->type = array(1 => '文字', 2 => '图片', 3 => '编辑器');
    }

    public function indexAction()
    {
        $this->load_list();
    }

    public function addAction()
    {
        if ($this->isPostForm()) {
            $data = $this->post('data');
            if (empty($data['type'])) {
                $this->msg_result = '类型不能为空，请重新选择';
                $this->load_add($data);
            }
            if (empty($data['name'])) {
                $this->msg_result = '名称不能为空，请重新填写';
                $this->load_add($data);
            }
            $data['content'] = $data['content_' . $data['type']];
            if (empty($data['content'])) {
                $this->msg_result = '内容不能为空，请重新填写';
                $this->load_add($data);
            }

            $this->block->insert($data);
            $this->msg_result = '添加成功';
            $this->cacheAction();
            $this->load_list();
        } else {
            $this->load_add();
        }
    }

    public function editAction($id = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        $data = $this->block->find($id);
        if (empty($data)) {
            $this->msg_result = '区块不存在';
            $this->load_list();
        }

        if ($this->isPostForm()) {
            unset($data);
            $data = $this->post('data');
            if (empty($data['type'])) {
                $this->msg_result = '类型不能为空，请重新选择';
                $this->load_edit($id);
            }
            if (empty($data['name'])) {
                $this->msg_result = '名称不能为空，请重新填写';
                $this->load_edit($id);
            }

            $data['content'] = $data['content_' . $data['type']];
            if (empty($data['content'])) {
                $this->msg_result = '内容不能为空，请重新填写';
                $this->load_edit($id);
            }

            $this->block->update($data, 'id=' . $id);
            $this->cacheAction();
            $this->msg_result = '编辑成功';
            $this->load_edit($id);
        }
        $type = $this->type;
        include $this->views('admin/block/add');
    }

    public function delAction($id = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        $this->block->delete('id=' . $id);
        $this->cacheAction();
        $this->msg_result = '删除成功';
        $this->load_list();
    }

    public function cacheAction($show = 0)
    {
        $list = $this->block->findAll();
        $data = array();
        foreach ($list as $t) {
            $data[$t['id']] = $t;
        }
        set_cache('block', $data);
        if ($show) $this->show_message('缓存更新成功', 1);
    }

    private function load_list()
    {
        $type = $this->type;
        $msg = $this->msg_result;
        $list = $this->block->findAll('id, type, name, remark');
        include $this->views('admin/block/list');
        exit;
    }

    private function load_add($data = null)
    {
        $type = $this->type;
        $msg = $this->msg_result;
        $data['type'] = $data['type'] ? $data['type'] : 1; // 设置默认类型
        include $this->views('admin/block/add');
        exit;
    }

    private function load_edit($id = 0)
    {
        $data = $this->block->find($id);
        if (empty($data)) {
            $this->msg_result = '区块不存在';
            $this->load_list();
        }
        $msg = $this->msg_result;
        $type = $this->type;
        include $this->views('admin/block/add');
        exit;
    }

}

<?php

class BlockController extends Admin {
    
    private $block;
    private $type;
    
    public function __construct() {
		parent::__construct();
		$this->block = xiaocms::load_model('block');
		$this->type  = array(1=>'文字', 2=>'图片', 3=>'编辑器');		
	}
    
    public function indexAction() {

		$type     = $this->type;
	    $list = $this->block->findAll('id,type,name');
	    include $this->admin_tpl('block_list');
    }
    
    public function addAction() {
        if ($this->post('submit')) {
            $data = $this->post('data');
            if (empty($data['type'])) $this->show_message('编辑类型不能为空');
			$data['content'] = $data['content_' . $data['type']];
            if (empty($data['name']) || empty($data['content'])) $this->show_message('名称或者内容不能为空');
            $this->block->insert($data);
            $this->show_message($this->getCacheCode('block') . '添加成功', 1, url('admin/block'));
        }
		$type = $this->type;
		$data['type'] = 3;//设置默认类型
        include $this->admin_tpl('block_add');
    }
    
    public function editAction() {
        $id   = (int)$this->get('id');
        $data = $this->block->find($id);
        if (empty($data)) $this->show_message('区块不存在');
        if ($this->post('submit')) {
            unset($data);
            $data = $this->post('data');
            if (empty($data['type'])) $this->show_message('类型不能为空');
			$data['content'] = $data['content_' . $data['type']];
            if (empty($data['name']) || empty($data['content'])) $this->show_message('名称或者内容不能为空');
            $this->block->update($data, 'id=' . $id);
            $this->show_message($this->getCacheCode('block') . '编辑成功', 1, url('admin/block'));
        }
		$type = $this->type;
	    include $this->admin_tpl('block_add');
    }
    
    public function delAction($id=0, $all=0) {
	    $id  = $id  ? $id  : (int)$this->get('id');
	    $all = $all ? $all : $this->get('all');
	    $this->block->delete('id=' . $id);
	    $all or $this->show_message($this->getCacheCode('block') . '删除成功', 1 , url('admin/block/index'));
	}
    
    public function cacheAction($show=0) {
	    $list = $this->block->findAll();
	    $data = array();
	    foreach ($list as $t) {
	        $data[$t['id']] = $t;
	    }
	    set_cache('block', $data);
	    $show or $this->show_message('缓存更新成功', 1);
	}

}
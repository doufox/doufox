<?php

class FormController extends Admin {

	protected $cid;
	protected $modelid;
	protected $model;
	protected $table;
	protected $form;
	protected $join;
	protected $join_info;
    public function __construct() {
		parent::__construct();
		$formmodel     = get_cache('formmodel');
		$this->cid     = (int)$this->get('cid');
		$this->modelid = (int)$this->get('modelid');
		if (empty($this->modelid)) $this->show_message('表单模型id不存在');
		$this->model   = $formmodel[$this->modelid];
		if (empty($this->model)) $this->show_message('表单模型不存在');
		$this->table   = $this->model['tablename'];
		$this->form    = xiaocms::load_model($this->table);
		$joinmodel     = get_cache('joinmodel');
		$this->join    = isset($joinmodel[$this->model['joinid']]) ? $joinmodel[$this->model['joinid']] : null;
		$this->join_info     = '独立表单';
		if ($this->join) {
		   $this->join_info  = '已关联' . $this->join['modelname'];
		}
		$cid   = $this->cid;
		$modelid   = $this->modelid;
		$model     = $this->model;
	}
	
	/**
	 * 表单内容管理
	 */
	public function listAction() {
		$cid       = (int)$this->get('cid');
		$modelid   =  (int)$this->get('modelid');

	    if ($this->post('submit_del') && $this->post('form')=='del') {
	        foreach ($_POST as $var=>$value) {
	            if (strpos($var, 'del_')!==false) {
	                $_id = (int)str_replace('del_', '', $var);
	                $this->delAction($_id, 1);
	            }
	        }
			$this->show_message('删除成功', 1);

	    } elseif ($this->post('submit_status_0') && $this->post('form')=='status_0') {
	        foreach ($_POST as $var=>$value) {
	            if (strpos($var, 'del_')!==false) {
	                $_id = (int)str_replace('del_', '', $var);
	                $this->form->update(array('status'=>0), 'id=' . $_id);
	            }
	        }
			$this->show_message('修改成功', 1);

	    } elseif ($this->post('submit_status_1') && $this->post('form')=='status_1') {
	        foreach ($_POST as $var=>$value) {
	            if (strpos($var, 'del_')!==false) {
	                $_id = (int)str_replace('del_', '', $var);
	                $this->form->update(array('status'=>1), 'id=' . $_id);
	            }
	        }
			$this->show_message('修改成功', 1);
	    } 
		$page     = $this->get('page')     ? $this->get('page') : 1;
		$userid   = (int)$this->get('userid');
	    $pagelist = xiaocms::load_class('pagelist');
		$pagelist->loadconfig();
	    $where    = 'id>0';
		if ($userid) $where .= ' and userid=' . $userid;
		if ($this->cid) $where .= ' and cid=' . $this->cid;
	    $total    = $this->content->count($this->table, 'id', $where);
	    $pagesize = 15;//分页数量
	    $urlparam = array(
			'userid' => $userid,
			'cid'    => $this->cid,
			'page'   => '{page}',
			'modelid'=> $this->modelid,
		);
	    $url      = url('admin/form/list', $urlparam);
	    $list     = $this->form->page_limit($page, $pagesize)->where($where)->order(array('id DESC'))->select();
	    $pagelist = $pagelist->total($total)->url($url)->num($pagesize)->page($page)->output();

		$model     = $this->model;
		$join     = empty($this->join) ? 0 : 1;
	    include $this->admin_tpl('form_list');
	}
	
	/**
	 * 表单配置
	 */
	public function configAction() {
		if ($this->isPostForm()) {
		    $data = $this->post('data');
			$cfg  = $this->post('setting');
			$field= array();
			if ($cfg['form']['field']) {
			    foreach ($cfg['form']['field'] as $c=>$t) {
				    if ($t) $field[]  = $c;
				}
				$cfg['form']['field'] = $field;
			}
			$cfg  = array_merge($this->model['setting'], $cfg);
		    $set  = array(
			    'modelname'   => $data['modelname'],
				'setting'     => array2string($cfg),
				'categorytpl' => $data['categorytpl'],
			);
			$model= xiaocms::load_model('model');
			$model->update($set, 'modelid=' . $this->modelid);
			$this->show_message($this->getCacheCode('model') . '操作成功', 1);
		}
		$count[1] = $this->content->count($this->table, null, 'status=1');
		$count[0] = $this->content->count($this->table, null, 'status=0');
		$count[3] = $this->content->count($this->table, null, 'status=3');

		$form_url  = SITE_PATH . 'index.php?c=index&a=form&modelid=' . $this->model['modelid'] ;

        $list_code = '
{xiao:list table=' . $this->model['tablename'] . '   num=10}
表单字段信息 例如：id：{xiao:$xiao[\'id\']} 更多信息请参考官方模板帮助文档
{/xiao:list}';
        if ($this->join) {
		    $list_code = '
{xiao:list table=' . $this->model['tablename'] . ' cid=被关联的文章id(例如：$id) num=10}
表单字段信息 例如：id：{xiao:$xiao[\'id\']} 更多信息请参考官方模板帮助文档
{/xiao:list}';
		$form_url  = SITE_PATH . 'index.php?c=form&a=post&modelid=' . $this->model['modelid'] . 'cid=$id ($id是被关联内容的id变量)';
        }
		
		$cid       = $this->cid;
		$modelid = $this->modelid;
		$model     = $this->model;		
		$join_info     = $this->join_info;
		$join      = empty($this->join) ? 0 : 1;
	    include $this->admin_tpl('form_config');
	}
	

	
	/**
	 * 修改内容
	 */
	public function editAction() {
		$id = (int)$this->get('id');

		if (empty($id)) $this->show_message('表单内容不存在');
		if ($this->isPostForm()) {
		    $data = $this->post('data');
			$cid  = (int)$this->post('cid');
			if ($this->join && empty($cid)) $this->show_message('参数不完整，缺少文档cid');
			$this->checkFields($this->model['fields'], $data, 1);
			$data['cid']        = $cid;
			//数组转化为字符
			foreach ($data as $i=>$t) {
				if (is_array($t)) $data[$i] = array2string($t);
			}
			if ($this->form->update($data, 'id=' . $id)) {
				$data['id'] = $id;
			    $this->show_message('修改成功', 1, url('admin/form/list', array('modelid'=>$this->modelid, 'cid'=>$this->cid)));
			} else {
			    $this->show_message('操作失败');
			}
		}
		$data     = $this->form->find($id);
		if (empty($data)) $this->show_message('表单内容不存在');
		$modelid = $this->modelid;

		$model     = $this->model;
		$join_info     = $this->join_info;
		$cid    = $data['cid'];
		if($cid) $ciddata  = $this->content->find($cid,'title');
		$join   = empty($this->join) ? 0 : 1;
		$fields = $this->getFields($this->model['fields'], $data, $this->model['setting']['form']['field']);
	    include $this->admin_tpl('form_edit');
	}
	
	/**
	 * 删除
	 */
	public function delAction($id=0, $all=0) {
	    $id    = $id  ? $id  : (int)$this->get('id');
	    $all   = $all ? $all : $this->get('all');
	    $this->form->delete('id=' . (int)$id);
	    $all or $this->show_message('操作成功', 1, url('admin/form/list', array('modelid'=>$this->modelid, 'cid'=>$this->cid)));
	}
	
}
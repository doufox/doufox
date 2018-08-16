<?php

class ModelController extends Admin {
    
    protected $_model;
	protected $modeltype; //模型类型
	protected $typeid;
    
    public function __construct() {
		parent::__construct();
		$this->modeltype = array(
		    1 => 'content', //内容表模型
			2 => 'member',  //会员表模型
			3 => 'form',    //表单表模型
		);
		$this->_model = xiaocms::load_model('model');
	    $this->typeid = $this->get('typeid') ? $this->get('typeid') : 1;
		if (!isset($this->modeltype[$this->typeid])) $this->show_message('模型类型不存在');

	}

	public function indexAction() {
		    $typeid    = $this->typeid;
			$modeltype = $this->modeltype;
			$typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);
			$list  = $this->_model->where('typeid=' . $this->typeid)->select();
			include $this->admin_tpl('model_list');
	}
	
	/*
	 * 添加模型
	 */
	public function addAction() {
	    if ($this->post('submit')) {
	        $tablename = $this->post('tablename');
	        if (!$tablename) $this->show_message('数据表名不能为空！');
	        if (!preg_match('/^[0-9a-z]+$/', $tablename)) $this->show_message('数据表名只能由小写字母和数字组成！');
	        $category  = $this->post('categorytpl') ? $this->post('categorytpl') : ($this->typeid == 3 ? 'form.html' : 'category_' . $tablename . '.html') ;
	        $list      = $this->post('listtpl')     ? $this->post('listtpl') : 'list_' . $tablename . '.html';
	        $show      = $this->post('showtpl')     ? $this->post('showtpl') : 'show_' . $tablename . '.html';
			$tablename = $this->modeltype[$this->typeid]. '_' . $tablename;
	        $data      = array(
	            'tablename'   => $tablename,
	            'modelname'   => $this->post('modelname'),
	            'categorytpl' => $category,
	            'listtpl'     => $list,
	            'showtpl'     => $show,
				'typeid'      => $this->typeid,
	        );
	        if ($this->_model->is_table_exists($tablename)) $this->show_message('数据表名已经存在');
	        if ($modelid = $this->_model->set(0, $data)) {
			    if ($this->typeid != 3) {
					$join = $this->post('join');
					if (is_array($join) && $join) {
					    foreach ($join as $id) {
						    $this->_model->set($id, array('joinid'=>$modelid));
						}
					}
				}
			    $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/index/', array('typeid'=>$this->typeid)));
			} else {
			    $this->show_message('添加失败');
			}
	    }
		$fdata = get_cache('formmodel');
		$jdata = array();
		if ($fdata) {
		    foreach ($fdata as $t) {
			    if (!empty($t['joinid'])) $jdata[] = $t['modelid'];
			}
		}
		
		$typeid    = $this->typeid;
		$modeltype = $this->modeltype;
		$typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);
		$join      = array();
		$formmodel = $fdata;
		$joindata  = $jdata;

	    include $this->admin_tpl('model_add');
	}
	
	/*
	 * 修改模型
	 */
    public function editAction() {
	    if ($this->post('submit')) {
	        $modelid  = (int)$this->post('modelid');
			$data     = $this->_model->find($modelid);
			if (empty($data)) $this->show_message('该模型不存在！');
	        $category = $this->post('categorytpl');
	        $list     = $this->post('listtpl');
	        $show     = $this->post('showtpl');
	        $update   = array(
	            'listtpl'     => $list,
	            'showtpl'     => $show,
				'joinid'      => $this->post('joinid'),
	            'modelname'   => $this->post('modelname'),
	            'categorytpl' => $category,
	        );
	        $this->_model->set($modelid, $update);
			if ($this->typeid != 3) {
				$join = $this->post('join');
				$this->_model->update(array('joinid'=>0), 'joinid=' . $modelid);
				if (is_array($join) && $join) {
					foreach ($join as $id) {
						$this->_model->set($id, array('joinid'=>$modelid));
					}
				}
			}
	        $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/index/', array('typeid'=>$this->typeid)));
	    }
	    $modelid = (int)$this->get('modelid');
		$fdata   = get_cache('formmodel');
		$jdata   = $join = array();
		$data    = $this->_model->find($modelid);
		if ($fdata) {
		    foreach ($fdata as $t) {
			    if (!empty($t['joinid']))     $jdata[] = $t['modelid'];
				if ($t['joinid'] == $modelid) $join[]  = $t['modelid'];
			}
		}
		    $typeid    = $this->typeid;
			$modeltype = $this->modeltype;
			$typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);

			$joindata  = $jdata;
		    $formmodel = $fdata;
	    include $this->admin_tpl('model_add');
	}
	
	/*
	 * 删除模型
	 */
	public function delAction() {
	    $mid  = (int)$this->get('modelid');
	    $data = $this->_model->find($mid);
	    if (!$data) $this->show_message('该模型不存在！');
	    $this->_model->del($data);
		$name = $this->typeid == 1 ? 'model' : $this->modeltype[$this->typeid] . 'model';
		$data = get_cache($name);
		unset($data[$mid]);
		set_cache($name, $data);
	    $this->show_message($this->getCacheCode('model') . '删除成功', 1, url('admin/model/index/', array('typeid'=>$this->typeid)));
	}
	
	/**
	 * 字段管理
	 */
	public function fieldsAction() {
	    $modelid = (int)$this->get('modelid');
	    $data    = $this->_model->find($modelid);
	    if (!$data) $this->show_message('该模型不存在！');
	    $table   = xiaocms::load_model($data['tablename']);
	    $field   = xiaocms::load_model('model_field');
	    if ($this->post('submit')) {
	        foreach ($_POST as $var=>$value) {
	            if (strpos($var, 'order_')!==false) {
	                $id = (int)str_replace('order_', '', $var);
	                $field->update(array('listorder'=>$value), 'fieldid=' . $id);
	            }
	        }
			$this->show_message($this->getCacheCode('model') . '操作成功', 1 ,url('admin/model/fields/', array('modelid'=>$modelid, 'typeid'=>$this->typeid)));
	    }
		$setting = string2array($data['setting']);
		$typeid    = $this->typeid;
		$modeltype = $this->modeltype;
		$typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);
		$list    = $field->where('modelid=' . $modelid)->order('listorder ASC')->select();
		$content = $setting['default'];
		
	    include $this->admin_tpl('model_fields');
	}
	
	/**
	 * 添加字段
	 */
	public function addfieldAction() {
	    $modelid    = (int)$this->get('modelid');
	    $model_data = $this->_model->find($modelid);
	    $field      = xiaocms::load_model('model_field');
	    if (!$model_data) $this->show_message('该模型不存在！');
	    if ($this->post('submit')) {
	        if ($this->typeid != 3) $table = xiaocms::load_model($this->modeltype[$this->typeid]);
	        $table_data = xiaocms::load_model($model_data['tablename']);
	        //主表和附表字段集合
	        $t_fields   = $this->typeid == 3 ? array() : $table->get_fields();
	        $d_fields   = $table_data->get_fields();
	        $fields     = array_unique(array_merge($t_fields, $d_fields));
	        //判断新加字段是否存在
	        $fieldname  = $this->post('field');
	        if (empty($fieldname ) || !preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{0,19}$/', $fieldname)) $this->show_message('该字段格式不正确');
	        if (in_array($fieldname, $fields)) $this->show_message('该字段已经存在' );
	        $name  = $this->post('name');
	        if (empty($name))  $this->show_message('请填写字段别名！');
	        $ftype = $this->post('formtype');
	        if (empty($ftype)) $this->show_message('请选择字段类别！');
	        $type  = $this->post('type');
			$merge = $this->post('merge');
	        if (empty($merge) && !in_array($ftype, array('input', 'image', 'file', 'editor', 'checkbox', 'files', 'merge', 'date', 'fields')) && empty($type)) {
			    $this->show_message('请选择字段类型');
			}
	        $data  = array(
	            'modelid'   => $this->post('modelid'),
	            'field'     => $fieldname,
	            'name'      => $name,
	            'formtype'  => $ftype,
	            'tips'      => $this->post('tips'),
	            'pattern'   => $this->post('pattern'),
	            'errortips' => $this->post('errortips'),
	            'setting'   => addslashes(var_export($_POST['setting'], true)),
				'type'      => $type,
				'length'    => $this->post('length'),
				'indexkey'  => $this->post('indexkey'),
				'isshow'    => isset($_POST['isshow']) ? $this->post('isshow') : 1,
				'not_null'  => $this->post('not_null'),
				'pattern'   => $this->post('pattern'),
				'errortips' => $this->post('errortips'),
				'merge'     => $merge,
	        );
	        //添加字段入库
	        if ($field->set(0, $data)) {
	            $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/fields/', array('modelid'=>$modelid, 'typeid'=>$this->typeid)), 3, 1, 1);
	        } else {
	            $this->show_message('添加失败');
	        }
	    }
	    //加载字段配置文件
	    $formtype = formtype();
		
	    $typeid    = $this->typeid;
	    $modeltype = $this->modeltype;
	    $typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);
	    $merge      = $field->where('modelid=' . $modelid)->where('formtype=?', 'fields')->select();
	    include $this->admin_tpl('model_addfield');
	}
	
	/**
	 * 修改字段
	 */
	public function editfieldAction() {
	    $field   = xiaocms::load_model('model_field');
	    $fieldid = (int)$this->get('fieldid');
	    $data    = $field->getOne('fieldid=' . $fieldid);
	    if (empty($data)) $this->show_message('字段不存在！');
	    $modelid    = $data['modelid'];
	    $model_data = $this->_model->find($modelid);
	    if (!$model_data) $this->show_message('该模型不存在！');
	    if ($this->post('submit')) {
	        $fieldid = $this->post('fieldid');
	        if (empty($fieldid)) $this->show_message('字段不存在！');
	        $name    = $this->post('name');
	        if (empty($name)) $this->show_message('请填写字段别名！');
	        $setting = $_POST['setting'];
	        $data    = array(
	            'name'      => $name,
	            'tips'      => $this->post('tips'),
	            'pattern'   => $this->post('pattern'),
	            'errortips' => $this->post('errortips'),
	            'setting'   => addslashes(var_export($setting, true)),
				'isshow'    => isset($_POST['isshow']) ? $this->post('isshow') : 1,
				'not_null'  => $this->post('not_null'),
				'pattern'   => $this->post('pattern'),
				'errortips' => $this->post('errortips'),
				'merge'     => $this->post('merge'),
	        );
	        //字段入库
	        if ($field->set($fieldid, $data)) {
	            $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/fields/', array('typeid'=>$this->typeid, 'modelid'=>$modelid)));
	        } else {
	            $this->show_message('修改失败');
	        }
	    }
	    //加载字段配置文件
	    $formtype = formtype();
		
	    $typeid    = $this->typeid;
	    $modeltype = $this->modeltype;
	    $typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);
	    $merge      = $field->where('modelid=' . $modelid)->where('formtype=?', 'fields')->select();

	    include $this->admin_tpl('model_addfield');
	}
	
	/**
	 * 修改默认字段
	 */
	public function ajaxeditAction() {
	    $modelid = (int)$this->get('modelid');
		$name    = $this->get('name');
	    $data    = $this->_model->find($modelid);
	    if (empty($data)) $this->show_message('该模型不存在！');
		$setting = string2array($data['setting']);
		if (!isset($setting['default'][$name])) $this->show_message('该字段不存在！');
		$field   = $setting['default'][$name];
	    if ($this->post('submit')) {
			$setting['default'][$name] = $this->post('data');
			$this->_model->update(array('setting'=>array2string($setting)), 'modelid=' . $modelid);
			$this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/fields/', array('typeid'=>$this->typeid, 'modelid'=>$modelid)));
	    }

		    $typeid    = $this->typeid;
			$modeltype = $this->modeltype;
			$typename  = array(1 => '内容模型',2 => '会员模型',3 => '表单模型',);

			$name    = $data['modelname'];
	        $data    = $field;

	    include $this->admin_tpl('model_ajaxedit');
	}
	
	/**
	 * 动态加载字段类型配置信息
	 */
	public function ajaxformtypeAction() {
	    $type = $this->get('type');
	    if (empty($type)) exit('');
	    $func = 'form_' . $type;
	    if (!function_exists($func)) exit('');
	    eval('echo ' . $func . '();');
	    
	}
	
	/**
	 * 禁用/启用字段
	 */
	public function disableAction() {
	    $field   = xiaocms::load_model('model_field');
	    $fieldid = (int)$this->get('fieldid');
	    $data    = $field->getOne('fieldid=' . $fieldid);
	    if (empty($data)) $this->show_message('该字段不存在！');
	    $disable = $data['disabled'] == 1 ? 0 : 1;
	    $field->update(array('disabled'=>$disable), 'fieldid=' . $fieldid);
	    $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/fields/', array('typeid'=>$this->typeid, 'modelid'=>$data['modelid'])));
	}
	
	/**
	 * 删除字段
	 */
	public function delfieldAction() {
	    $field   = xiaocms::load_model('model_field');
	    $fieldid = (int)$this->get('fieldid');
	    $data    = $field->getOne('fieldid=' . $fieldid);
	    if (empty($data)) $this->show_message('该字段不存在！');
		if ($data['field'] == 'content') $this->show_message('系统字段不能删除');
	    if ($field->del($data)) {
	        $this->show_message($this->getCacheCode('model') . '删除成功', 1,url('admin/model/fields/', array('typeid'=>$this->typeid, 'modelid'=>$data['modelid'])));
	    } else {
	        $this->show_message('删除失败');
	    }
	}
	
	
	/**
	 * 更新模型缓存
	 * array(
	 *     '模型ID'=> array(
	 *                    ...模型字段
	 *                    'content' => array(
	 *                        内容模型默认字段
	 *                    ),
	 *                    'fields'=> array(
	 *                                   'data'  => array(
	 *                                             ...该模型的可用字段
	 *                                           ),
	 *                                   'merge' => array(
	 *                                             ...组合字段
	 *                                           ),
	 *                                   'mergefields' => array(
	 *                                             被组合过的字段（将不会被单独显示）
	 *                                           ),
	 *                               ),
	 *                ),
	 * );
	 */
	public function cacheAction($show=0) {
		$file_list=xiaocms::load_class('file_list');
		$file_list->delete_dir($this->_model->cache_dir);
		if (!file_exists($this->_model->cache_dir)) mkdir($this->_model->cache_dir, 0777, true);
	    $field = xiaocms::load_model('model_field');
		foreach ($this->modeltype as $typeid=>$c) {
	        $model = $this->_model->where('typeid=' . $typeid)->select();
	        $data  = array();
			foreach ($model as $t) {
			    $setting   = string2array($t['setting']);
				if ($setting['disable'] == 1) continue;
				$id        = $t['modelid'];
				$data[$id] = $t;
				$fields    = $field->where('modelid=' . $id)->where('disabled=0')->order('listorder ASC')->select();
				$_fields   = $merge  = array();
				foreach ($fields as $k=>$f) {
				    $_fields[$f['field']] = $f;
				    if ($f['formtype'] == 'merge') {
						$setting = string2array($f['setting']);
						if (preg_match_all('/\{([a-zA-Z]{1}[a-zA-Z]{0,19})\}/Ui', $setting['content'], $fs)) {
						    $mergefields = $fs[1];
					        $_fields[$f['field']]['data'] = $mergefields;
							$merge = array_merge($merge, $mergefields);
						}
					}
				}
				if ($typeid == 1 && !isset($setting['default'])) {
				    $setting['default'] = array(
					    'title'         => array('name'=>'标题', 'show'=>1),
					    'keywords'      => array('name'=>'关键字', 'show'=>1),
					    'thumb'         => array('name'=>'缩略图', 'show'=>1),
					    'description'   => array('name'=>'描述',   'show'=>1),
					);
					$this->_model->update(array('setting'=>array2string($setting)), 'modelid=' . $id);
				}
				$data[$id]['fields']['data']  = $_fields;
				$data[$id]['fields']['merge'] = $merge;
				$data[$id]['setting']         = $setting;
				$data[$id]['content']         = $setting['default'];
			}
	        //保存到缓存文件中
	        $name = $typeid == 1 ? 'model' : $c . 'model';
			set_cache($name, $data);
		}
		//缓存关联表单被关联的模型
		$join = array();
		$data = $this->_model->where('typeid=3')->select();
		if ($data) {
		    foreach ($data as $t) {
			    if ($t['joinid'] && !isset($join[$t['joinid']])) {
				    $join[$t['joinid']] = $this->_model->where('modelid=' . $t['joinid'])->select(false);
				}
			}
		}
		set_cache('joinmodel', $join);
	    $show or $this->show_message('缓存更新成功',1);
	}
	
	/*
	 * 禁用/启用模型
	 */
	public function cdisabledAction() {
	    $modelid = (int)$this->get('modelid');
	    $data    = $this->_model->find($modelid);
	    if (!$data) $this->show_message('该模型不存在！');
		$setting = string2array($data['setting']);
	    $setting['disable'] = $setting['disable'] == 1 ? 0 : 1;
	    $this->_model->update(array('setting'=>array2string($setting)), 'modelid=' . $modelid);
	    $this->show_message($this->getCacheCode('model') . '操作成功', 1, url('admin/model/index/', array('typeid'=>$this->typeid)));
	}

}
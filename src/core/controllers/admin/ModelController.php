<?php
if (!defined('IN_CMS')) {
    exit();
}

class ModelController extends Admin
{

    protected $_model;
    protected $modelType; // 模型类型
    protected $typeid;
    protected $modelTypeName;
    protected $modelCacheName;

    public function __construct()
    {
        parent::__construct();
        $this->modelType = array(
            1 => 'content', // 内容模型表
            2 => 'member',  // 用户模型表
            3 => 'form',    // 表单模型表
            4 => 'page',    // 单页模型表
        );
        $this->modelTypeName = array(
            1 => '内容模型',
            2 => '用户模型',
            3 => '表单模型',
            4 => '单页模型',
        );
        $this->typeid = $this->get('typeid') ? $this->get('typeid') : 1;
        if (!isset($this->modelType[$this->typeid])) {
            $this->show_message('模型类型不存在');
        }
        if ($this->typeid == 1) {
            $this->modelCacheName = 'contentmodel';
        } else if ($this->typeid == 2 || $this->typeid == 3) {
            $this->modelCacheName = $this->modelType[$this->typeid] . 'model';
        } else if ($this->typeid == 4) {
            $this->modelCacheName = 'pagemodel';
        }
        $this->_model = core::load_model('model');
    }

    public function indexAction()
    {
        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $modelTypeName = $this->modelTypeName;
        $modelname = $modelTypeName[$typeid];
        $list = $this->_model->where('typeid=' . $typeid)->select();
        include $this->views('admin/model/list');
    }

    public function addAction()
    {
        if ($this->isPostForm()) {
            $modelname = $this->post('modelname');
            if (!$modelname) {
                $this->show_message('模型名称不能为空！');
            }
            $tablename = $this->post('tablename');
            if (!$tablename) {
                $this->show_message('数据表名不能为空！');
            }

            if (!preg_match('/^[0-9a-z]+$/', $tablename)) {
                $this->show_message('数据表名只能由小写字母和数字组成！');
            }

            $category = $this->post('categorytpl') ? $this->post('categorytpl') : ($this->typeid == 3 ? 'form.html' : 'category_' . $tablename . '.html');
            $list = $this->post('listtpl') ? $this->post('listtpl') : 'list_' . $tablename . '.html';
            $show = $this->post('showtpl') ? $this->post('showtpl') : 'show_' . $tablename . '.html';
            $search = $this->post('searchtpl') ? $this->post('searchtpl') : 'search_' . $tablename . '.html';
            $pagetpl = $this->post('pagetpl') ? $this->post('pagetpl') : 'page.html';
            $msgtpl = $this->post('msgtpl') ? $this->post('msgtpl') : '';
            $tablename = $this->modelType[$this->typeid] . '_' . $tablename;
            if ($this->_model->is_table_exists($tablename)) {
                $this->show_message('数据表名已经存在');
            }

            $data = array(
                'tablename' => $tablename,
                'modelname' => $modelname,
                'categorytpl' => $category,
                'listtpl' => $list,
                'showtpl' => $show,
                'searchtpl' => $search,
                'pagetpl' => $pagetpl,
                'msgtpl' => $msgtpl,
                'typeid' => $this->typeid
            );
            if ($modelid = $this->_model->set(0, $data)) {
                if ($this->typeid != 3) {
                    $join = $this->post('join');
                    if (is_array($join) && $join) foreach ($join as $id) {
                        $this->_model->set($id, array('joinid' => $modelid));
                    }
                }
                $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/index', array('typeid' => $this->typeid)));
            } else {
                $this->show_message('添加失败');
            }
        }
        $formmodel = array();
        $formmodel = get_cache('formmodel');
        if ($formmodel) foreach ($formmodel as $k => $v) {
            $formmodel[$k]['select_status'] = empty($v['joinid']) ? '' : 'disabled'; // 一个非表单模型可以对应绑定多个表单模型，表单模型已被关联时，则不能再被别的模型关联
        }
        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $modelTypeName = $this->modelTypeName;
        $page_title = '添加' . $modelTypeName[$typeid]; // 格式：添加表单模型
        include $this->views('admin/model/add');
    }

    public function editAction()
    {
        if ($this->isPostForm()) {
            $modelid = (int) $this->post('modelid');
            $data = $this->_model->find($modelid);
            if (empty($data)) {
                $this->show_message('该模型不存在！');
            }

            $update = array(
                'joinid' => $this->post('joinid'),
                'modelname' => $this->post('modelname'),
                'categorytpl' => $this->post('categorytpl') ? $this->post('categorytpl') : '',
                'listtpl' => $this->post('listtpl') ? $this->post('listtpl') : '',
                'showtpl' => $this->post('showtpl') ? $this->post('showtpl') : '',
                'searchtpl' => $this->post('searchtpl') ? $this->post('searchtpl') : '',
                'pagetpl' => $this->post('pagetpl') ? $this->post('pagetpl') : '',
                'msgtpl' => $this->post('msgtpl') ? $this->post('msgtpl') : ''
            );
            $this->_model->set($modelid, $update);
            if ($this->typeid != 3) {
                $join = $this->post('join');
                $this->_model->update(array('joinid' => 0), 'joinid=' . $modelid);
                if (is_array($join) && $join) foreach ($join as $id) {
                    $this->_model->set($id, array('joinid' => $modelid));
                }
            }
            $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/index/', array('typeid' => $this->typeid)));
        }
        $modelid = (int) $this->get('modelid');
        $formmodel = array();
        $formmodel = get_cache('formmodel');
        $data = $this->_model->find($modelid);
        // print_r($formmodel);
        if ($formmodel) foreach ($formmodel as $k => $v) {
            if (empty($v['joinid'])) {
                $formmodel[$k]['select_status'] = ''; // 未被关联
            } elseif ($v['joinid'] == $modelid) {
                $formmodel[$k]['select_status'] = 'checked'; // 已被当前模型关联
            } else {
                $formmodel[$k]['select_status'] = 'disabled'; // 已被其他模型关联
            }
        }
        // print_r($formmodel);
        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $modelTypeName = $this->modelTypeName;
        $page_title = '编辑' . $modelTypeName[$typeid] . '[' . $data['modelname'] . ']'; // 格式：编辑表单模型[文章评论]
        include $this->views('admin/model/add');
    }

    public function delAction()
    {
        $mid = (int) $this->get('modelid');
        $data = $this->_model->find($mid);
        if (!$data) {
            $this->show_message('该模型不存在！');
        }

        $this->_model->del($data);
        $data = get_cache($this->modelCacheName);
        unset($data[$mid]);
        set_cache($this->modelCacheName, $data);
        $this->show_message($this->getCacheCode($this->modelCacheName) . '删除成功', 1, url('admin/model/index/', array('typeid' => $this->typeid)));
    }

    /**
     * 字段管理
     */
    public function fieldsAction()
    {
        $modelid = (int) $this->get('modelid');
        $data = $this->_model->find($modelid);
        if (!$data) {
            $this->show_message('该模型不存在！');
        }

        $table = core::load_model($data['tablename']);
        $field = core::load_model('model_field');
        if ($this->isPostForm()) {
            foreach ($_POST as $var => $value) {
                if (strpos($var, 'order_') !== false) {
                    $id = (int) str_replace('order_', '', $var);
                    $field->update(array('listorder' => $value), 'fieldid=' . $id);
                }
            }
            $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/fields', array('modelid' => $modelid, 'typeid' => $this->typeid)));
        }
        $setting = string2array($data['setting']);
        $baseFields = $setting['default'];
        $typeid = $this->typeid;
        $modelTypeName = $this->modelTypeName;
        $list = $field->where('modelid=' . $modelid)->order('listorder ASC')->select();
        include $this->views('admin/model/fields');
    }

    /**
     * 添加字段
     */
    public function addfieldAction()
    {
        $modelid = (int) $this->get('modelid');
        $model_data = $this->_model->find($modelid);
        $field = core::load_model('model_field');
        if (!$model_data) {
            $this->show_message('该模型不存在！');
        }

        if ($this->isPostForm()) {
            if ($this->typeid != 3) {
                $table = core::load_model($this->modelType[$this->typeid]);
            }

            $table_data = core::load_model($model_data['tablename']);
            //主表和附表字段集合
            $t_fields = $this->typeid == 3 ? array() : $table->get_fields();
            $d_fields = $table_data->get_fields();
            $fields = array_unique(array_merge($t_fields, $d_fields));
            //判断新加字段是否存在
            $fieldname = $this->post('field');
            if (empty($fieldname) || !preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{0,19}$/', $fieldname)) {
                $this->show_message('该字段格式不正确');
            }

            if (in_array($fieldname, $fields)) {
                $this->show_message('该字段已经存在');
            }

            $name = $this->post('name');
            if (empty($name)) {
                $this->show_message('请填写字段别名！');
            }

            $ftype = $this->post('formtype');
            if (empty($ftype)) {
                $this->show_message('请选择字段类别！');
            }

            $type = $this->post('type');
            $merge = $this->post('merge');
            if (empty($merge) && !in_array($ftype, array('input', 'image', 'file', 'editor', 'checkbox', 'files', 'merge', 'date', 'fields')) && empty($type)) {
                $this->show_message('请选择字段类型');
            }
            $data = array(
                'modelid' => $this->post('modelid'),
                'field' => $fieldname,
                'name' => $name,
                'formtype' => $ftype,
                'tips' => $this->post('tips'),
                'pattern' => $this->post('pattern'),
                'errortips' => $this->post('errortips'),
                'setting' => addslashes(var_export($_POST['setting'], true)),
                'type' => $type,
                'length' => $this->post('length'),
                'indexkey' => $this->post('indexkey'),
                'isshow' => isset($_POST['isshow']) ? $this->post('isshow') : 1,
                'not_null' => $this->post('not_null'),
                'pattern' => $this->post('pattern'),
                'errortips' => $this->post('errortips'),
                'merge' => $merge,
            );
            //添加字段入库
            if ($field->set(0, $data)) {
                $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/fields/', array('modelid' => $modelid, 'typeid' => $this->typeid)), 3, 1, 1);
            } else {
                $this->show_message('添加失败');
            }
        }
        // 加载字段配置文件
        $formtype = form_type();

        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $typename = $this->modelTypeName;
        $merge = $field->where('modelid=' . $modelid)->where('formtype=?', 'fields')->select();
        include $this->views('admin/model/addfield');
    }

    /**
     * 修改字段
     */
    public function editfieldAction()
    {
        $field = core::load_model('model_field');
        $fieldid = (int) $this->get('fieldid');
        $data = $field->getOne('fieldid=' . $fieldid);
        if (empty($data)) {
            $this->show_message('字段不存在！');
        }

        $modelid = $data['modelid'];
        $model_data = $this->_model->find($modelid);
        if (!$model_data) {
            $this->show_message('该模型不存在！');
        }

        if ($this->isPostForm()) {
            $fieldid = $this->post('fieldid');
            if (empty($fieldid)) {
                $this->show_message('字段不存在！');
            }

            $name = $this->post('name');
            if (empty($name)) {
                $this->show_message('请填写字段别名！');
            }

            $setting = $_POST['setting'];
            $data = array(
                'name' => $name,
                'tips' => $this->post('tips'),
                'pattern' => $this->post('pattern'),
                'errortips' => $this->post('errortips'),
                'setting' => addslashes(var_export($setting, true)),
                'isshow' => isset($_POST['isshow']) ? $this->post('isshow') : 1,
                'not_null' => $this->post('not_null'),
                'pattern' => $this->post('pattern'),
                'errortips' => $this->post('errortips'),
                'merge' => $this->post('merge'),
            );
            //字段入库
            if ($field->set($fieldid, $data)) {
                $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/fields/', array('typeid' => $this->typeid, 'modelid' => $modelid)));
            } else {
                $this->show_message('修改失败');
            }
        }
        // 加载字段配置文件
        $formtype = form_type();

        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $typename = $this->modelTypeName;
        $merge = $field->where('modelid=' . $modelid)->where('formtype=?', 'fields')->select();

        include $this->views('admin/model/addfield');
    }

    /**
     * 修改默认字段
     */
    public function ajaxeditAction()
    {
        $modelid = (int) $this->get('modelid');
        $name = $this->get('name');
        $data = $this->_model->find($modelid);
        if (empty($data)) {
            $this->show_message('该模型不存在！');
        }

        $setting = string2array($data['setting']);
        if (!isset($setting['default'][$name])) {
            $this->show_message('该字段不存在！');
        }

        $field = $setting['default'][$name];
        if ($this->isPostForm()) {
            $setting['default'][$name] = $this->post('data');
            $this->_model->update(array('setting' => array2string($setting)), 'modelid=' . $modelid);
            $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/fields/', array('typeid' => $this->typeid, 'modelid' => $modelid)));
        }

        $typeid = $this->typeid;
        $modeltype = $this->modelType;
        $typename = $this->modelTypeName;
        $name = $data['modelname'];
        $data = $field;

        include $this->views('admin/model/ajaxedit');
    }

    /**
     * 动态加载字段类型配置信息
     */
    public function ajaxformtypeAction()
    {
        $type = $this->get('type');
        if (empty($type)) {
            exit('');
        }

        $func = 'form_' . $type;
        if (!function_exists($func)) {
            exit('');
        }

        eval('echo ' . $func . '();');
    }

    /**
     * 禁用/启用字段
     */
    public function disableAction()
    {
        $field = core::load_model('model_field');
        $fieldid = (int) $this->get('fieldid');
        $data = $field->getOne('fieldid=' . $fieldid);
        if (empty($data)) {
            $this->show_message('该字段不存在！');
        }

        $disable = $data['disabled'] == 1 ? 0 : 1;
        $field->update(array('disabled' => $disable), 'fieldid=' . $fieldid);
        $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/fields/', array('typeid' => $this->typeid, 'modelid' => $data['modelid'])));
    }

    /**
     * 删除字段
     */
    public function delfieldAction()
    {
        $field = core::load_model('model_field');
        $fieldid = (int) $this->get('fieldid');
        $data = $field->getOne('fieldid=' . $fieldid);
        if (empty($data)) {
            $this->show_message('该字段不存在！');
        }

        if ($data['field'] == 'content') {
            $this->show_message('系统字段不能删除');
        }

        if ($field->del($data)) {
            $this->show_message($this->getCacheCode($this->modelCacheName) . '删除成功', 1, url('admin/model/fields/', array('typeid' => $this->typeid, 'modelid' => $data['modelid'])));
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
    public function cacheAction($show = 0)
    {
        $file_list = core::load_class('file_list');
        $file_list->delete_dir($this->_model->cache_dir);
        if (!file_exists($this->_model->cache_dir)) {
            mkdir($this->_model->cache_dir, 0777, true);
        }

        $field = core::load_model('model_field');
        foreach ($this->modelType as $typeid => $c) {
            $model = $this->_model->where('typeid=' . $typeid)->select();
            $data = array();
            foreach ($model as $t) {
                $setting = string2array($t['setting']);
                if ($setting['disable'] == 1) {
                    continue;
                }

                $id = $t['modelid'];
                $data[$id] = $t;
                $fields = $field->where('modelid=' . $id)->where('disabled=0')->order('listorder ASC')->select();
                $_fields = $merge = array();
                foreach ($fields as $k => $f) {
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
                if (!isset($setting['default'])) {
                    // 内置字段
                    if ($typeid == 1 || $typeid == 4) {
                        // 内容模型/页面模型
                        $setting['default'] = array(
                            'title' => array('name' => '标题', 'show' => 1),
                            'keywords' => array('name' => '关键字', 'show' => 1),
                            'thumb' => array('name' => '缩略图', 'show' => 1),
                            'description' => array('name' => '描述', 'show' => 1)
                        );
                    } elseif ($typeid == 2) {
                        // 用户模型
                        $setting['default'] = array(
                            'username' => array('name' => '用户名', 'show' => 1),
                            'nickname' => array('name' => '用户昵称', 'show' => 1),
                            'realname' => array('name' => '真实姓名', 'show' => 1),
                            'email' => array('name' => '邮箱地址', 'show' => 1),
                            'avatar' => array('name' => '用户头像', 'show' => 1),
                            'regdate' => array('name' => '注册时间', 'show' => 1),
                            'regip' => array('name' => '注册IP', 'show' => 1),
                            'status' => array('name' => '用户状态', 'show' => 1)
                        );
                    } elseif ($typeid == 3) {
                        // 表单模型
                        $setting['default'] = array(
                            'username' => array('name' => '用户名', 'show' => 1),
                            'listorder' => array('name' => '排序编号', 'show' => 1),
                            'status' => array('name' => '状态', 'show' => 1),
                            'time' => array('name' => '提交时间', 'show' => 1),
                            'ip' => array('name' => 'IP地址', 'show' => 1)
                        );
                    }
                    $this->_model->update(array('setting' => array2string($setting)), 'modelid=' . $id);
                }
                $data[$id]['fields']['data'] = $_fields;
                $data[$id]['fields']['merge'] = $merge;
                $data[$id]['setting'] = $setting;
                $data[$id]['content'] = $setting['default'];
            }
            // 保存到缓存文件中
            set_cache($c . 'model', $data);
        }
        // 缓存关联表单被关联的模型
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
        $show or $this->show_message('缓存更新成功', 1);
    }

    /*
     * 禁用/启用模型
     */
    public function cdisabledAction()
    {
        $modelid = (int) $this->get('modelid');
        $data = $this->_model->find($modelid);
        if (!$data) {
            $this->show_message('该模型不存在！');
        }

        $setting = string2array($data['setting']);
        $setting['disable'] = $setting['disable'] == 1 ? 0 : 1;
        $this->_model->update(array('setting' => array2string($setting)), 'modelid=' . $modelid);
        $this->show_message($this->getCacheCode($this->modelCacheName) . '操作成功', 1, url('admin/model/index', array('typeid' => $this->typeid)));
    }

}

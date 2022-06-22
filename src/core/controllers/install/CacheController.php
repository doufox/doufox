<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class CacheController extends Controller
{

    protected $_model;
    protected $modelType; // 模型类型
    protected $typeid;
    protected $modelTypeName;
    protected $modelCacheName;

    public function __construct()
    {
        if (!file_exists(DATA_PATH . DS .'installed')) {
            // 未安装
            http_response_code(400);
            exit();
        }
        $time = $this->get('time') ? $this->get('time') : '';
        if (empty($time)) {
            // 未提供安装日期
            http_response_code(403);
            exit();
        }
        $_time = file_get_contents(DATA_PATH . DS .'installed');
        if ($time != md5($_time)) {
            // 验证失败
            http_response_code(401);
            exit();
        }

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

    /**
     * 更新模型缓存
     */
    public function indexAction()
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
                if (isset($setting['disable']) && $setting['disable'] == 1) {
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
        echo '<script type="text/javascript">window.parent.updateSuccess();</script>';
    }
}

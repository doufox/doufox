<?php

class PluginController extends Admin
{

    private $plugin;

    public function __construct()
    {
        parent::__construct();
        $this->plugin = core::load_model('plugin');
    }

    public function indexAction()
    {
        $list = $this->plugin->findAll('id, official, name, version, url, description, author, author_url, status');
        include $this->admin_view('plugin/list');
    }

    public function addAction()
    {
        include $this->admin_view('plugin/add');
    }

    public function settingAction()
    {
        $id = (int) $this->get('id');
        $data = $this->plugin->find($id);
        if (empty($data)) {
            $this->show_message('区块不存在');
        }

        if ($this->isPostForm()) {
            unset($data);
            $data = $this->post('data');

            if (empty($data['name']) || empty($data['content'])) {
                $this->show_message('名称或者内容不能为空');
            }

            $this->plugin->update($data, 'id=' . $id);
            $this->show_message($this->getCacheCode('plugin') . '编辑成功', 1, url('admin/plugin'));
        }
        include $this->admin_view('plugin/setting');
    }

    public function delAction($id = 0, $all = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        $all = $all ? $all : $this->get('all');
        $this->plugin->delete('id=' . $id);
        $all or $this->show_message($this->getCacheCode('plugin') . '删除成功', 1, url('admin/plugin/index'));
    }

    public function cacheAction($show = 0)
    {
        $list = $this->plugin->findAll();
        $data = array();
        if (!empty($list)) {
            foreach ($list as $t) {
                $data[$t['id']] = $t;
            }
        }
        set_cache('plugin', $data);
        $show or $this->show_message('缓存更新成功', 1);
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        unset($plugin);
    }
}

<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

class PluginController extends Admin
{

    private $msg_result;

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $this->load_list();
    }

    public function doAction()
    {
        // /admin/plugin/do?mod=oauth
        $id = (int) $this->get('id');
        $data = $this->plugin->find($id);
        if (empty($data)) {
            $this->show_message('插件不存在');
        }
        // // 每个管理界面顶部插入样式和内容
        // addHookAction('admin_head', 'plugin_helloworld_css');
        // addHookAction('admin_top', 'plugin_helloworld');
    }

    public function infoAction()
    {
        $id = (int) $this->get('id');
        $data = $this->plugin->find($id);
        if (empty($data)) {
            $this->show_message('插件不存在');
        }
        $data['has_config'] = false;
        $settings_file = PATH_PLUGIN . $data['plugin'] . DS . $data['plugin'] . '_settings.php';
        if (file_exists($settings_file)) {
            $data['has_config'] = true;
            $data['setting'] = string2array($data['setting']);
        }

        include $this->views('admin/plugin/info');
    }

    public function settingAction()
    {
        $id = (int) $this->get('id');
        $data = $this->plugin->find($id);
        if (empty($data)) {
            $this->show_message('插件不存在');
        }
        $settings_file = PATH_PLUGIN . $data['plugin'] . DS . $data['plugin'] . '_settings.php';
        if (!file_exists($settings_file)) {
            $this->show_message('插件不存在配置项 ！');
        }
        if ($this->isPostForm()) {
            $settings = $this->post('settings');
            $post_data = array(
                'setting' => array2string($settings)
            );
            $this->plugin->update($post_data, 'id=' . $id);
            $this->show_message(
                $this->getCacheCode('plugin') . '编辑成功',
                1,
                url('admin/plugin/setting', array('id' => $id))
            );
        }

        $settings = string2array($data['setting']);
        include $this->views('admin/plugin/setting');
    }

    public function testAction()
    {

        $plugin = get_cache('plugin');
        // print_r($plugin);
        // $a  = array(
        //     'name' => 'Hello World',
        //     'plugin' => 'helloworld',
        //     'version' => '1.0',
        //     'description' => '内置插件，它会在您每个管理页面显示一句"Hello World !"。',
        //     'url' => 'http://doufox.com',
        //     'author' => 'doufox',
        //     'author_url' => 'http://doufox.com'
        // );
        // $this->plugin->insert($a);
    }

    public function reloadAction()
    {
        $f = getPluginFiles();
        $num = 0;
        foreach ($f as $i) {
            $pd = getPluginData($i);
            // print_r($pd);
            if (empty($pd['name']) || empty($pd['plugin'])) {
                // 不是插件
                continue;
            }
            if ($this->plugin->getOne('plugin=?', $pd['plugin'])) {
                // 已存在数据库
                continue;
            }
            $num++;
            $this->plugin->insert($pd);
        }
        unset($f);
        if ($num) {
            $this->show_message($this->getCacheCode('plugin') . '更新成功', 1, url('admin/plugin/index'));
        }
        $this->show_message($this->getCacheCode('plugin') . '操作结束', 1, url('admin/plugin/index'));
    }

    public function delAction($id = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        if (!empty($id)) {
            $this->plugin->delete('id=' . $id);
            $this->msg_result = '删除成功';
            $this->cacheAction();
            $this->load_list();
        }
        $this->msg_result = '参数缺失，未做任何操作';
        $this->load_list();
    }

    public function openAction($id = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        if (!empty($id)) {
            $this->plugin->update(array('status' => 1), 'id=' . $id);
            $this->msg_result = '启用成功';
            $this->cacheAction();
            $this->load_list();
        }
        $this->msg_result = '参数缺失，未做任何操作';
        $this->load_list();
    }

    public function closeAction($id = 0)
    {
        $id = $id ? $id : (int) $this->get('id');
        if (!empty($id)) {
            $this->plugin->update(array('status' => 0), 'id=' . $id);
            $this->msg_result = '关闭成功';
            $this->cacheAction();
            $this->load_list();
        }
        $this->msg_result = '参数缺失，未做任何操作';
        $this->load_list();
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
        if ($show) $this->show_message('缓存更新成功', 1);
    }

    private function load_list()
    {
        $msg = $this->msg_result;
        $list = $this->plugin->findAll('id, official, plugin, name, version, url, description, author, author_url, status');
        include $this->views('admin/plugin/list');
        exit;
    }

    /**
     * 析构函数
     */
    public function __destruct()
    {
        unset($plugin);
    }
}

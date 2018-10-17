<?php
/**
 * Router Class
 * 路由处理
 */

if (!defined('IN_CMS')) {
    exit();
}

class Router
{
    protected $url;
    protected $namespace_name;
    protected $controller_name;
    protected $action_name;

    public function __construct()
    {
        // parent::__construct();
        $root = $_SERVER['SCRIPT_NAME'];
        $this->url = strtolower(trim(str_replace($root, '', $_SERVER['PATH_INFO']), '/'));
        $this->namespace_name = '';
        $this->controller_name = 'index';
        $this->action_name = 'index';
        $this->router = array();
        // $this->get();
    }

    public function get()
    {
        if (!empty($this->url)) {
            // 如果为空，则是访问根地址
            $URI = array();
            $URI = explode('/', $this->url);
            // 如果function为空 则默认访问index
            if (count($URI) == 1) {
                if ($this->inNameSpace($URI[0])) {
                    $this->namespace_name = $URI[0];
                } else if ($this->isController('', $URI[0])) {
                    $this->controller_name = $URI[0];
                } else {
                    $this->action_name = $URI[0];
                }
            } else if (count($URI) == 2) {
                if ($this->inNameSpace($URI[0])) {
                    $this->namespace_name = $URI[0];
                    if ($this->isController($URI[0] . DS, $URI[1])) {
                        $this->controller_name = $URI[1];
                    } else {
                        $this->action_name = $URI[1];
                    }
                } else if ($this->isController('', $URI[0])) {
                    $this->controller_name = $URI[0];
                }
            } else if (count($URI) > 2) {
                if ($this->inNameSpace($URI[0])) {
                    $this->namespace_name = $URI[0];
                    if ($this->isController($URI[0] . DS, $URI[1])) {
                        $this->controller_name = $URI[1];
                        $this->action_name = $URI[2];
                    } else {
                        $this->action_name = $URI[1];
                    }
                } else if ($this->isController('', $URI[0])) {
                    $this->controller_name = $URI[0];
                    if ($URI[0] != 'theme' && $URI[0] != 'static') {
                        $this->action_name = $URI[1];
                    }
                } else {
                    $this->action_name = $URI[0];
                }
            }
        } else {
            $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
            parse_str($path_url_string, $url_info_array);
            $this->namespace_name = trim((isset($url_info_array['s']) && $url_info_array['s']) ? $url_info_array['s'] : '');
            $this->controller_name = trim((isset($url_info_array['c']) && $url_info_array['c']) ? $url_info_array['c'] : 'index');
            $this->action_name = trim((isset($url_info_array['a']) && $url_info_array['a']) ? $url_info_array['a'] : 'index');
        }

        $this->router['namespace'] = strtolower($this->namespace_name);
        $this->router['controller'] = ucfirst(strtolower($this->controller_name));
        $this->router['action'] = strtolower($this->action_name);
        return $this->router;
        // return array(
        //     'namespace'  => strtolower($this->namespace_name),
        //     'controller' => ucfirst(strtolower($this->controller_name)),
        //     'action'     => strtolower($this->action_name)
        // );
    }

    protected function inNameSpace($path)
    {
        if (is_dir(ROOT_PATH . 'core/controllers/' . $path)) {
            return true;
        }
        return false;
    }

    protected function isController($path = '', $file)
    {
        if (is_file(ROOT_PATH . 'core/controllers/' . $path . ucfirst($file) . 'Controller.php')) {
            return true;
        }
        return false;
    }
}

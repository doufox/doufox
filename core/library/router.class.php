<?php
/**
 * router class
 *
 */

if (!defined('IN_CMS')) {
    exit();
}

class router
{
    private $router;
    private $url;
    private $namespace_name;
    private $controller_name;
    private $action_name;

    public function __construct()
    {
        $this->url = strtolower(trim(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PATH_INFO']), '/'));
        $this->namespace_name = '';
        $this->controller_name = 'index';
        $this->action_name = 'index';
        $this->router = array();
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

        $this->router['namespace']  = strtolower($this->namespace_name);
        $this->router['controller'] = ucfirst(strtolower($this->controller_name));
        $this->router['action']     = strtolower($this->action_name);
        return $this->router;
    }

    private function inNameSpace($path)
    {
        if (is_dir(CONTROLLER_PATH . $path)) {
            return true;
        }
        return false;
    }

    private function isController($path = '', $file)
    {
        if (is_file(CONTROLLER_PATH . $path . ucfirst($file) . 'Controller.php')) {
            return true;
        }
        return false;
    }

    /**
     * destructor
     *
     * @access public
     * @return void
     */
    public function __destruct()
    {
        if (isset($this->router)) {
            unset($this->router);
        }
        if (isset($this->url)) {
            unset($this->url);
        }
    }
}

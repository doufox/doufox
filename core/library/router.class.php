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
    private $path_info;
    private $search_array;
    private $search_string;

    public function __construct()
    {
        $this->path_info = strtolower(trim(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PATH_INFO']), '/'));
        $this->search_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
        parse_str($this->search_string, $this->search_array);
        $_GET = array_merge($_GET, $this->search_array);
    }

    public function get()
    {
        $namespace = '';
        $controller = 'Index';
        $action = 'index';
        if (!empty($this->path_info)) {
            // 如果为空，则是访问根地址
            $URI = array();
            $URI = explode('/', $this->path_info);
            // 如果function为空 则默认访问index
            if (count($URI) == 1) {
                if ($this->inNameSpace($URI[0])) {
                    $namespace = $URI[0];
                } else if ($this->isController('', $URI[0])) {
                    $controller = $URI[0];
                } else {
                    $action = $URI[0];
                }
            } else if (count($URI) == 2) {
                if ($this->inNameSpace($URI[0])) {
                    $namespace = $URI[0];
                    if ($this->isController($URI[0] . DS, $URI[1])) {
                        $controller = $URI[1];
                    } else {
                        $action = $URI[1];
                    }
                } else if ($this->isController('', $URI[0])) {
                    $controller = $URI[0];
                }
            } else if (count($URI) > 2) {
                if ($this->inNameSpace($URI[0])) {
                    $namespace = $URI[0];
                    if ($this->isController($URI[0] . DS, $URI[1])) {
                        $controller = $URI[1];
                        $action = $URI[2];
                    } else {
                        $action = $URI[1];
                    }
                } else if ($this->isController('', $URI[0])) {
                    $controller = $URI[0];
                    if ($URI[0] != 'theme' && $URI[0] != 'static') {
                        $action = $URI[1];
                    }
                } else {
                    $action = $URI[0];
                }
            }
        } else {
            $namespace  = trim((isset($this->search_array['s']) && $this->search_array['s']) ? $this->search_array['s'] : '');
            $controller = trim((isset($this->search_array['c']) && $this->search_array['c']) ? $this->search_array['c'] : 'Index');
            $action     = trim((isset($this->search_array['a']) && $this->search_array['a']) ? $this->search_array['a'] : 'index');
        }
        // return $this->router =  array(
        //     'GET' => array_merge($_GET, $this->search_array),
        //     'namespace' => strtolower($namespace),
        //     'controller' => ucfirst(strtolower($controller)),
        //     'action' => strtolower($action)
        // );
        $this->router['namespace'] = strtolower($namespace);
        $this->router['controller'] = ucfirst(strtolower($controller));
        $this->router['action'] = strtolower($action);
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
        if (isset($this->path_info)) {
            unset($this->path_info);
        }
        if (isset($this->search_array)) {
            unset($this->search_array);
        }
        if (isset($this->search_string)) {
            unset($this->search_string);
        }
    }
}



// self::$pathinfo = explode('/', $_SERVER['PATH_INFO']);
// $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
// parse_str($path_url_string, $url_info_array);
// $namespace_name = trim((isset($url_info_array['s']) && $url_info_array['s']) ? $url_info_array['s'] : '');
// if (isset($url_info_array['s']) && $url_info_array['s']) {
//     $namespace_name = $url_info_array['s'];
// } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == 'admin') {
//     $namespace_name = 'admin';
//     $controller_name = 'Index';
// }
// // $controller_name = trim((isset($url_info_array['c']) && $url_info_array['c']) ? $url_info_array['c'] : 'Index');
// if (isset(self::$pathinfo[1])) {
//     if (self::$pathinfo[1] == DATA_DIR || self::$pathinfo[1] == CORE_DIR) {
//         header("HTTP/1.0 403 Forbidden");
//         exit();
//     } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == STATIC_DIR) {
//         $controller_name = STATIC_DIR; // 静态资源
//     } else if (isset(self::$pathinfo[1]) && self::$pathinfo[1] == 'theme') {
//         $controller_name = 'theme'; // 主题资源
//     }
// } else if (isset($url_info_array['c']) && $url_info_array['c']) {
//     $controller_name = trim($url_info_array['c']);
// } else {
//     $controller_name = 'Index'; // controller默认为index
// }
// $action_name = trim((isset($url_info_array['a']) && $url_info_array['a']) ? $url_info_array['a'] : 'index'); // action默认为index
// self::$namespace = strtolower($namespace_name);
// self::$controller = ucfirst(strtolower($controller_name));
// self::$action = strtolower($action_name);

// $path_url_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
// parse_str($path_url_string, $url_info_array);

// self::$router     = core::load_class('router')->parse_request();
// self::$namespace  = self::$router['namespace'];
// self::$controller = self::$router['controller'];
// self::$action     = self::$router['action'];
// $_GET             = array_merge($_GET, $url_info_array);
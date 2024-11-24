<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * router class
 * 路由处理类
 */
class router
{
    private $router;
    private $path_info;
    private $search_array;
    private $search_string;
    private $namespace_admin;

    public function __construct()
    {
        $this->path_info = $this->removeQueryString(
            isset($_SERVER['PATH_INFO']) ?
                strtolower(trim(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['PATH_INFO']), '/'))
                :
                strtolower(trim(str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']), '/'))
        );
        // print_r($this->path_info);exit;
        $this->search_string = isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] ? $_SERVER['QUERY_STRING'] : $_SERVER['REQUEST_URI'];
        parse_str($this->search_string, $this->search_array);
        // print_r($this->search_array);exit;
        $_GET = array_merge($_GET, $this->search_array);
        // 管理员命名空间优先排除
        $this->namespace_admin = core::get_site_config('ADMIN_LOGINPATH');
    }

    public function removeQueryString($url)
    {
        $pos = strpos($url, '?');
        return $pos === false ? $url : substr($url, 0, $pos);
    }

    public function get()
    {
        $namespace = '';
        $controller = 'Index';
        $action = 'index';
        if (!empty($this->path_info)) {
            // 先解析路由查看是否内容路径
            $result = $this->parseContentURL($this->path_info);

            if ($result) {
                $namespace = '';
                $controller = 'Index';
                // action 重写
                $action = $result['action'];
                // URL参数重写
                $_GET = array_merge($_GET, $result);
            } else {
                $URI = array();
                $URI = explode('/', $this->path_info);
                // 如果function为空 则默认访问index
                $path_count = count($URI);
                if ($path_count == 1) {
                    if ($this->inNameSpace($URI[0])) {
                        $namespace = $URI[0];
                        if (!empty($this->namespace_admin) && $this->namespace_admin != 'admin') {
                            if ($namespace == 'admin') {
                                $namespace = '';
                            } else if ($namespace == $this->namespace_admin) {
                                // 自定义后台路径
                                $namespace = 'admin';
                            }
                        }
                        $controller = 'Index';
                        $action = 'index';
                    } else if ($this->isController('', $URI[0])) {
                        $controller = $URI[0];
                        $action = 'index';
                    } else {
                        $action = $URI[0];
                    }
                } else if ($path_count == 2) {
                    if ($this->inNameSpace($URI[0])) {
                        $namespace = $URI[0];
                        if (!empty($this->namespace_admin) && $this->namespace_admin != 'admin') {
                            if ($namespace == 'admin') {
                                $namespace = '';
                            } else if ($namespace == $this->namespace_admin) {
                                // 自定义后台路径
                                $namespace = 'admin';
                            }
                        }
                        if ($this->isController($namespace . DS, $URI[1])) {
                            $controller = $URI[1];
                            $action = 'index';
                        } else {
                            $action = $URI[1];
                        }
                    } else if ($this->isController('', $URI[0])) {
                        $controller = $URI[0];
                    }
                } else if ($path_count > 2) {
                    if ($this->inNameSpace($URI[0])) {
                        $namespace = $URI[0];
                        if (!empty($this->namespace_admin) && $this->namespace_admin != 'admin') {
                            if ($namespace == 'admin') {
                                $namespace = '';
                            } else if ($namespace == $this->namespace_admin) {
                                // 自定义后台路径
                                $namespace = 'admin';
                            }
                        }
                        if ($this->isController($namespace . DS, $URI[1])) {
                            $controller = $URI[1];
                            $action = $URI[2];
                        } else {
                            $action = $URI[1];
                        }
                    } else if ($this->isController('', $URI[0])) {
                        $controller = $URI[0];
                        if ($URI[0] != 'template' && $URI[0] != 'static') {
                            $action = $URI[1];
                        }
                    } else {
                        $action = $URI[0];
                    }
                }
            }
        } else {
            $namespace  = trim(!empty($this->search_array['s']) ? $this->search_array['s'] : '');
            $controller = trim(!empty($this->search_array['c']) ? $this->search_array['c'] : 'Index');
            $action     = trim(!empty($this->search_array['a']) ? $this->search_array['a'] : 'index');
            if (!empty($this->namespace_admin) && $this->namespace_admin != 'admin') {
                if ($namespace == 'admin') {
                    $namespace = '';
                } else if ($namespace == $this->namespace_admin) {
                    // 自定义后台路径
                    $namespace = 'admin';
                }
            }
        }
        // print_r($namespace);echo 345;exit;
        $this->router['namespace'] = strtolower($namespace);
        $this->router['controller'] = ucfirst(strtolower($controller));
        $this->router['action'] = strtolower($action);
        return $this->router;
    }

    /**
     * 根据路由配置信息解析路由并返回对应控制器和参数
     *
     * @param string $path 路由字符串
     * @return array 包含控制器和参数的数组
     */
    private function parseContentURL($path)
    {
        // 路由配置信息
        $config = [
            'SHOW_URL'      => core::get_site_config('SHOW_URL'),
            'SHOW_PAGE_URL' => core::get_site_config('SHOW_PAGE_URL'),
            'LIST_URL'      => core::get_site_config('LIST_URL'),
            'LIST_PAGE_URL' => core::get_site_config('LIST_PAGE_URL'),
        ];
        // echo 'URL内容分割: ' . $path . PHP_EOL;
        // /^(?=.*[a-zA-Z])[a-zA-Z0-9]*$/ // 匹配栏目地址，字符，可以有字母和数字组成，数字可有可无，但必须有字母。
        foreach ($config as $key => $value) {
            $pattern = str_replace(['{catpath}', '{catid}', '{page}', '{id}'], ['([a-zA-Z]+[a-zA-Z0-9]+)', '([0-9]+)', '([0-9]+)', '([0-9]+)'], $value);
            // $pattern = '/^' . str_replace(array('/', '-', '_'), array('\/', '\-', '\_'), $pattern) . '$/';
            $pattern = '/^' . str_replace(['/'], ['\/'], $pattern) . '$/';
            if (preg_match($pattern, $path, $matches)) {
                // print_r($matches) . PHP_EOL;
                switch ($key) {
                    case 'LIST_URL':
                        // 栏目页
                        if (is_numeric($matches[1])) {
                            return array('action' => 'category', 'catid' => $matches[1]);
                        }
                        return array('action' => 'category', 'catpath' => $matches[1]);
                    case 'LIST_PAGE_URL':
                        // 栏目页，分页
                        if (is_numeric($matches[1])) {
                            return array('action' => 'category', 'catid' => $matches[1], 'page' => $matches[2]);
                        }
                        return array('action' => 'category', 'catpath' => $matches[1], 'page' => $matches[2]);
                    case 'SHOW_URL':
                        // 内容页，显示
                        return array('action' => 'show', 'id' => $matches[1]);
                    case 'SHOW_PAGE_URL':
                        // 内容页，分页
                        return array('action' => 'show', 'id' => $matches[1], 'page' => $matches[2]);
                        // default:
                        //     return array('action' => '');
                }
            }
        }
        // 未匹配到内容URL
        return false;
    }

    private function inNameSpace($path)
    {
        if (!empty($this->namespace_admin) && $path == $this->namespace_admin) {
            // 属于自定义后台路径返回true
            return true;
        }
        if (is_dir(PATH_CONTROLER . $path)) {
            return true;
        }
        return false;
    }

    private function isController($path = '', $file)
    {
        if (is_file(PATH_CONTROLER . $path . ucfirst($file) . 'Controller.php')) {
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

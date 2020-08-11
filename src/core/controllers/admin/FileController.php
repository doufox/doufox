<?php
if (!defined('IN_CMS')) {
    exit();
}

class FileController extends Admin
{

    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        // $file_list = core::load_class('file_list');
        // $path_list = $file_list->get_file_list(ROOT_PATH);
        // $list = array();
        // foreach ($path_list as $x) {
        //     $list[] = array(
        //         'path' => $x,
        //         'image' => THEME_DIR . DS . $x . DS . 'preview.png',
        //     );
        // }
        // unset($file_list, $path_list);
        // print_r($file_list);
        // print_r($path_list);
        // $root_path = ROOT_PATH;
        // $num_files = 3;
        // $num_folders = 5;
        // $all_files_size = 0;
        // include $this->admin_view('file/list');
        $this->listAction();
    }

    /** 目录浏览
     * 
     */
    public function listAction()
    {
        $admin = $this->get('admin');
        // if (empty($admin) && $this->memberinfo) {
        //     $id = $this->memberinfo['id'];
        //     if ($id) {
        //         $this->dir .= 'member/' . $id . '/'; //会员附件目录
        //         if (!file_exists($this->dir)) {
        //             mkdir($this->dir);
        //         }
        //     }
        // } elseif (!$this->session->get('user_id')) {
        //     $this->attMsg('游客不允许操作');
        // }
        $this->dir = ROOT_PATH;
        $dir = $this->get('dir') ? $this->get('dir') : '';
        $dir = str_replace(array('..\\', '../', './', '.\\'), '', trim($dir));

        $dir = substr($dir, 0, 1) == '/' ? substr($dir, 1) : $dir;
        $dir = str_replace(array('\\', '//'), '/', $dir);
        $file_list = core::load_class('file_list');
        $data = $file_list->get_file_list($this->dir . $dir);
        $list = array();
        if ($data) {
            foreach ($data as $name) {
                // if ($name == 'index.html') {
                //     continue;
                // }

                // if (empty($admin) && strpos($name, '.thumb.') !== false) {
                //     continue;
                // }

                $path = $dir . $name . '/';
                $isdir = is_dir($this->dir . $path);
                if ($isdir) {
                    $ico = 'dir.gif';
                } else {
                    $ico = $this->get_file_icon_class($name);
                }
                $list[] = array(
                    'name' => $name,
                    'dir' => $path,
                    'path' => $this->dir . $path,
                    'ico' => $ico,
                    'isdir' => $isdir,
                    'url' => $isdir ? url('admin/file/list', array('dir' => $path)) : url('admin/file/view', array('file' => $path)) ,
                );
            }
        }
        $pdir = url('admin/file/list', array('dir' => str_replace(basename($dir), '', $dir)));
        $dir = $this->dir . $dir;
        $istop = $dir ? 1 : 0;
        include $this->admin_view('file/list');
    }

    /**
     * 文件格式图标
     * @param string $path
     * @return string
     */
    private function get_file_icon_class($path)
    {
        // get extension
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'ico':
            case 'gif':
            case 'jpg':
            case 'jpeg':
            case 'jpc':
            case 'jp2':
            case 'jpx':
            case 'xbm':
            case 'wbmp':
            case 'png':
            case 'bmp':
            case 'tif':
            case 'tiff':
            case 'svg':
                $img = 'jpg.gif';
                break;
            case 'passwd':
            case 'ftpquota':
            case 'sql':
            case 'js':
            case 'json':
            case 'sh':
            case 'config':
            case 'twig':
            case 'tpl':
            case 'md':
            case 'gitignore':
            case 'c':
            case 'cpp':
            case 'cs':
            case 'py':
            case 'map':
            case 'lock':
            case 'dtd':
                $img = 'php.gif';
                break;
            case 'txt':
            case 'ini':
            case 'conf':
            case 'log':
            case 'htaccess':
                $img = 'txt.gif';
                break;
            case 'css':
            case 'less':
            case 'sass':
            case 'scss':
                $img = 'css.gif';
                break;
            case 'zip':
            case 'gz':
                $img = 'zip.gif';
                break;
            case 'rar':
            case 'tar':
            case '7z':
                $img = 'rar.gif';
                break;
            case 'php':
            case 'php4':
            case 'php5':
            case 'phps':
            case 'phtml':
                $img = 'php.gif';
                break;
            case 'htm':
            case 'html':
            case 'shtml':
            case 'xhtml':
                $img = 'html.gif';
                break;
            case 'xml':
            case 'xsl':
                $img = 'xml.gif';
                break;
            case 'wav':
            case 'mp3':
            case 'mp2':
            case 'm4a':
            case 'aac':
            case 'ogg':
            case 'oga':
            case 'wma':
            case 'mka':
            case 'flac':
            case 'ac3':
            case 'tds':
                $img = 'wav.gif';
                break;
            case 'm3u':
            case 'm3u8':
            case 'pls':
            case 'cue':
                $img = 'wav.gif';
                break;
            case 'avi':
            case 'mpg':
            case 'mpeg':
            case 'mp4':
            case 'm4v':
            case 'flv':
            case 'f4v':
            case 'ogm':
            case 'ogv':
            case 'mov':
            case 'mkv':
            case '3gp':
            case 'asf':
            case 'wmv':
                $img = 'mpeg.gif';
                break;
            case 'eml':
            case 'msg':
                $img = 'txt.gif';
                break;
            case 'xls':
            case 'xlsx':
            case 'ods':
                $img = 'xls.gif';
                break;
            case 'csv':
                $img = 'csv.gif';
                break;
            case 'bak':
                $img = 'fa fa-clipboard';
                break;
            case 'doc':
            case 'docx':
            case 'odt':
                $img = 'doc.gif';
                break;
            case 'ppt':
            case 'pptx':
                $img = 'fa fa-file-powerpoint-o';
                break;
            case 'ttf':
            case 'ttc':
            case 'otf':
            case 'woff':
            case 'woff2':
            case 'eot':
            case 'fon':
                $img = 'fa fa-font';
                break;
            case 'pdf':
                $img = 'pdf.gif';
                break;
            case 'psd':
            case 'ai':
            case 'eps':
            case 'fla':
            case 'swf':
                $img = 'psd.gif';
                break;
            case 'exe':
            case 'msi':
                $img = 'exe.gif';
                break;
            case 'bat':
                $img = 'fa fa-terminal';
                break;
            default:
                $img = 'blank.gif';
        }

        return $img;
    }
}

<?php
if (!defined('IN_CMS')) {
    exit();
}

class FileController extends Admin
{

    public function __construct()
    {
        parent::__construct();
        $this->root_path = ROOT_PATH;
        $this->exclude_items = array(); // 禁止访问的文件列表
        $this->is_windows = DIRECTORY_SEPARATOR == '\\';
        $this->iconv_input_encoding = 'UTF-8';
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
        // $admin = $this->get('admin');
        // if (empty($admin) && $this->memberinfo) {
        //     $id = $this->memberinfo['id'];
        //     if ($id) {
        //         $this->root_path .= 'member/' . $id . '/'; //会员附件目录
        //         if (!file_exists($this->root_path)) {
        //             mkdir($this->root_path);
        //         }
        //     }
        // } elseif (!$this->session->get('user_id')) {
        //     $this->attMsg('游客不允许操作');
        // }
        $dir = $this->get('dir') ? $this->get('dir') : '';
        $dir = str_replace(array('..\\', '../', './', '.\\'), '', trim($dir));

        $dir = substr($dir, 0, 1) == '/' ? substr($dir, 1) : $dir;
        $dir = str_replace(array('\\', '//'), '/', $dir);
        $file_list = core::load_class('file_list');
        $data = $file_list->get_file_list($this->root_path . $dir);
        $list = array();
        if ($data) {
            foreach ($data as $name) {
                $path = $dir . $name . '/';
                $isdir = is_dir($this->root_path . $path);
                if ($isdir) {
                    $ico = 'dir.gif';
                } else {
                    $path = $dir . $name;
                    $ico = $this->get_file_icon_class($name);
                }
                $list[] = array(
                    'name' => $name,
                    'dir' => $path,
                    'path' => $this->root_path . $path,
                    'ico' => $ico,
                    'isdir' => $isdir,
                    'url' => $isdir ? url('admin/file/list', array('dir' => $path)) : url('admin/file/view', array('file' => $path)),
                );
            }
        }
        $pdir = url('admin/file/list', array('dir' => str_replace(basename($dir), '', $dir)));
        $dir = $this->root_path . $dir;
        $istop = $dir ? 1 : 0;
        include $this->admin_view('file/list');
    }

    /** 文件预览
     * 
     */
    public function viewAction()
    {
        $filename = $this->get('file') ? $this->get('file') : '';
        $filename = str_replace(array('..\\', '../', './', '.\\'), '', trim($filename));
        $file = substr($filename, 0, 1) == '/' ? substr($filename, 1) : $filename;
        $file = str_replace(array('\\', '//'), '/', $file);
        $file_path = $this->root_path . $file;
        $filename = $this->convert_filename($filename);
        // $file = $_GET['view'];
        // $quickView = (isset($_GET['quickView']) && $_GET['quickView'] == 1) ? true : false;
        $quickView = true;
        // $file = fm_clean_path($file, false);
        // $file = str_replace('/', '', $file);
        if ($file == '' || !is_file($file_path) || in_array($file, $this->exclude_items)) {
            $this->show_message('文件不存在！');
            // fm_redirect(FM_SELF_URL . '?p=' . urlencode(FM_PATH));
        }

        $file_url = $this->get_base_url() . $this->convert_filename($file);
        $download_url = url('admin/file/download', array('file' => $filename));
        // $file_path = $path . '/' . $file;

        $ext = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
        $mime_type = $this->get_mime_type($file_path);
        $filesize = $this->get_filesize(filesize($file_path));

        $is_zip = false;
        $is_gzip = false;
        $is_image = false;
        $is_audio = false;
        $is_video = false;
        $is_text = false;
        $is_onlineViewer = false;

        $file_type = '文件';
        $filenames = false; // for zip
        $content = ''; // for text
        // $online_viewer = strtolower(FM_DOC_VIEWER);

        // if ($online_viewer && $online_viewer !== 'false' && in_array($ext, fm_get_onlineViewer_exts())) {
        //     $is_onlineViewer = true;
        // } else
        if ($ext == 'zip' || $ext == 'tar') {
            $is_zip = true;
            $file_type = '压缩包';
            $filenames = $this->get_zip_info($file_path, $ext);
            $total_files = 0;
            $total_comp = 0;
            $total_uncomp = 0;
            $content = '';
            if ($filenames == false) {
                $content = '<p>压缩包无法识别</p>';
            } else {
                foreach ($filenames as $fn) {
                    if ($fn['folder']) {
                        $content = $content . '<b>' . $this->encode_html($fn['name']) . '</b><br>';
                    } else {
                        $total_files++;
                        $content = $content .  $fn['name'] . ' (' . $this->get_filesize($fn['filesize']) . ')<br>';
                    }
                    $total_comp += $fn['compressed_size'];
                    $total_uncomp += $fn['filesize'];
                }
                $ratio = round(($total_comp / $total_uncomp) * 100);
                $total_comp = $this->get_filesize($total_comp);
                $total_uncomp = $this->get_filesize($total_uncomp);
            }
        } elseif (in_array($ext, $this->get_image_exts())) {
            $is_image = true;
            $file_type = '图片';
            $image_size = getimagesize($file_path);
            $image_size = (isset($image_size[0]) ? $image_size[0] : '0') . ' x ' . (isset($image_size[1]) ? $image_size[1] : '0');
            $content = $this->encode_html($file_url);
        } elseif (in_array($ext, $this->get_audio_exts())) {
            $is_audio = true;
            $file_type = '音频';
            $content = $this->encode_html($file_url);
        } elseif (in_array($ext, $this->get_video_exts())) {
            $is_video = true;
            $file_type = '视频';
            $content = $this->encode_html($file_url);
        } elseif (in_array($ext, $this->get_text_exts()) || substr($mime_type, 0, 4) == 'text' || in_array($mime_type, $this->get_text_mimes())) {
            $is_text = true;
            $file_type = '文本';
            $content = file_get_contents($file_path);
            $is_utf8 = $this->is_utf8($content);
            $charset = $is_utf8 ? 'utf-8' : '8 bit';
            if (function_exists('iconv')) {
                if (!$is_utf8) {
                    $content = iconv($this->iconv_input_encoding, 'UTF-8//IGNORE', $content);
                }
            }
            if (FM_USE_HIGHLIGHTJS) {
                // highlight
                $hljs_classes = array(
                    'shtml' => 'xml',
                    'htaccess' => 'apache',
                    'phtml' => 'php',
                    'lock' => 'json',
                    'svg' => 'xml',
                );
                $hljs_class = isset($hljs_classes[$ext]) ? 'lang-' . $hljs_classes[$ext] : 'lang-' . $ext;
                if (empty($ext) || in_array(strtolower($file), $this->get_text_names()) || preg_match('#\.min\.(css|js)$#i', $file)) {
                    $hljs_class = 'nohighlight';
                }
                $content = '<pre class="with-hljs"><code class="' . $hljs_class . '">' . $this->encode_html($content) . '</code></pre>';
            } elseif (in_array($ext, array('php', 'php4', 'php5', 'phtml', 'phps'))) {
                // php highlight
                $content = highlight_string($content, true);
            } else {
                $content = '<pre>' . $this->encode_html($content) . '</pre>';
            }
            // echo $content;
        }
        include $this->admin_view('file/view');
    }

    /**
     * 文件下载
     */
    public function downloadAction()
    {
        $filename = $this->get('file') ? $this->get('file') : '';
        $filename = str_replace(array('..\\', '../', './', '.\\'), '', trim($filename));
        $file = substr($filename, 0, 1) == '/' ? substr($filename, 1) : $filename;
        $file = str_replace(array('\\', '//'), '/', $file);
        $file_path = $this->root_path . $file;

        if ($filename != '' && $file_path != '' && is_file($file_path)) {
            $this->download_file($file_path, $filename, 1024);
            exit;
        } else {
            $this->show_message('文件不存在');
        }
    }

    /**
     * 文本编辑
     */
    public function editAction()
    {
        $filename = $this->get('file') ? $this->get('file') : '';
        $filename = str_replace(array('..\\', '../', './', '.\\'), '', trim($filename));
        $file = substr($filename, 0, 1) == '/' ? substr($filename, 1) : $filename;
        $file = str_replace(array('\\', '//'), '/', $file);
        $file_path = $this->root_path . $file;

        if ($filename != '' && $file_path != '' && is_file($file_path)) {
            $content = file_get_contents($file_path);
            include $this->admin_view('file/edit');
        } else {
            $this->show_message('文件不存在');
        }
    }

    /**
     * 文件删除
     */
    public function delAction() {

        $filename = $this->get('file') ? $this->get('file') : '';
        $filename = str_replace(array('..\\', '../', './', '.\\'), '', trim($filename));
        $file = substr($filename, 0, 1) == '/' ? substr($filename, 1) : $filename;
        $file = str_replace(array('\\', '//'), '/', $file);
        $file_path = $this->root_path . $file;
        $folder = '';

        // Delete file / folder
        if ($file != '' && $file != '..' && $file != '.') {
            $is_dir = is_dir($file_path);
            $parent = files_get_parent_path($file);
            if (fm_rdelete($file_path)) {
                $msg = $is_dir ? 'Folder <b>%s</b> deleted' : 'File <b>%s</b> deleted';
                fm_set_msg(sprintf($msg, $this->encode_html($file)));
                $this->redirect(url('admin/file/list', array('dir' => $parent)));
            } else {
                $msg = $is_dir ? 'Folder <b>%s</b> not deleted' : 'File <b>%s</b> not deleted';
                fm_set_msg(sprintf($msg, $this->encode_html($file)), 'error');
                $this->redirect(url('admin/file/list', array('dir' => $parent)));
            }
        } else {
            $this->show_message('错误的文件');
        }
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


    /**
     * Get mime type
     * @param string $file_path
     * @return mixed|string
     */
    private function get_mime_type($file_path)
    {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $file_path);
            finfo_close($finfo);
            return $mime;
        } elseif (function_exists('mime_content_type')) {
            return mime_content_type($file_path);
        } elseif (!stristr(ini_get('disable_functions'), 'shell_exec')) {
            $file = escapeshellarg($file_path);
            $mime = shell_exec('file -bi ' . $file);
            return $mime;
        } else {
            return '--';
        }
    }


    /**
     * Get nice filesize
     * @param int $size
     * @return string
     */
    function get_filesize($size)
    {
        $size = (float) $size;
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return sprintf('%s %s', round($size / pow(1024, $power), 2), $units[$power]);
    }

    /**
     * 图片文件扩展类型
     * @return array
     */
    function get_image_exts()
    {
        return array('ico', 'gif', 'jpg', 'jpeg', 'jpc', 'jp2', 'jpx', 'xbm', 'wbmp', 'png', 'bmp', 'tif', 'tiff', 'psd', 'svg');
    }

    /**
     * 视频文件扩展类型
     * @return array
     */
    function get_video_exts()
    {
        return array('avi', 'webm', 'wmv', 'mp4', 'm4v', 'ogm', 'ogv', 'mov', 'mkv');
    }

    /**
     * 音频文件扩展类型
     * @return array
     */
    function get_audio_exts()
    {
        return array('wav', 'mp3', 'ogg', 'm4a');
    }

    /**
     * 文本文件扩展类型
     * @return array
     */
    function get_text_exts()
    {
        return array(
            'txt', 'css', 'ini', 'conf', 'log', 'htaccess', 'passwd', 'ftpquota', 'sql', 'js', 'json', 'sh', 'config',
            'php', 'php4', 'php5', 'phps', 'phtml', 'htm', 'html', 'shtml', 'xhtml', 'xml', 'xsl', 'm3u', 'm3u8', 'pls', 'cue',
            'eml', 'msg', 'csv', 'bat', 'twig', 'tpl', 'md', 'gitignore', 'less', 'sass', 'scss', 'c', 'cpp', 'cs', 'py',
            'map', 'lock', 'dtd', 'svg', 'scss', 'asp', 'aspx', 'asx', 'asmx', 'ashx', 'jsx', 'jsp', 'jspx', 'cfm', 'cgi'
        );
    }

    /**
     * Get mime types of text files
     * @return array
     */
    function get_text_mimes()
    {
        return array(
            'application/xml',
            'application/javascript',
            'application/x-javascript',
            'image/svg+xml',
            'message/rfc822',
        );
    }

    /**
     * Get file names of text files w/o extensions
     * @return array
     */
    function get_text_names()
    {
        return array(
            'license',
            'readme',
            'authors',
            'contributors',
            'changelog',
        );
    }

    /**
     * 获取压缩包文件信息
     * @param string $path
     * @return array|bool
     */
    function get_zip_info($path, $ext)
    {
        if ($ext == 'zip' && function_exists('zip_open')) {
            $arch = zip_open($path);
            if ($arch) {
                $filenames = array();
                while ($zip_entry = zip_read($arch)) {
                    $zip_name = zip_entry_name($zip_entry);
                    $zip_folder = substr($zip_name, -1) == '/';
                    $filenames[] = array(
                        'name' => $zip_name,
                        'filesize' => zip_entry_filesize($zip_entry),
                        'compressed_size' => zip_entry_compressedsize($zip_entry),
                        'folder' => $zip_folder
                        //'compression_method' => zip_entry_compressionmethod($zip_entry),
                    );
                }
                zip_close($arch);
                return $filenames;
            }
        } elseif ($ext == 'tar' && class_exists('PharData')) {
            $archive = new PharData($path);
            $filenames = array();
            foreach (new RecursiveIteratorIterator($archive) as $file) {
                $parent_info = $file->getPathInfo();
                $zip_name = str_replace("phar://" . $path, '', $file->getPathName());
                $zip_name = substr($zip_name, ($pos = strpos($zip_name, '/')) !== false ? $pos + 1 : 0);
                $zip_folder = $parent_info->getFileName();
                $zip_info = new SplFileInfo($file);
                $filenames[] = array(
                    'name' => $zip_name,
                    'filesize' => $zip_info->getSize(),
                    'compressed_size' => $file->getCompressedSize(),
                    'folder' => $zip_folder
                );
            }
            return $filenames;
        }
        return false;
    }

    /**
     * Encode html entities
     * @param string $text
     * @return string
     */
    function encode_html($text)
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }


    /**
     * Convert file name to UTF-8 in Windows
     * @param string $filename
     * @return string
     */
    function convert_filename($filename)
    {
        if ($this->convert_filename && function_exists('iconv')) {
            $filename = iconv($this->iconv_input_encoding, 'UTF-8//IGNORE', $filename);
        }
        return $filename;
    }

    /**
     * 检查文件编码是否为UTF-8
     * @param string $string
     * @return int
     */
    function is_utf8($string)
    {
        return preg_match('//u', $string);
    }

    /**
     * 取文件MIME类型
     * @param string $string
     * @return string
     */
    function get_file_mimes($extension)
    {
        $fileTypes['swf'] = 'application/x-shockwave-flash';
        $fileTypes['pdf'] = 'application/pdf';
        $fileTypes['exe'] = 'application/octet-stream';
        $fileTypes['zip'] = 'application/zip';
        $fileTypes['doc'] = 'application/msword';
        $fileTypes['xls'] = 'application/vnd.ms-excel';
        $fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
        $fileTypes['gif'] = 'image/gif';
        $fileTypes['png'] = 'image/png';
        $fileTypes['jpeg'] = 'image/jpg';
        $fileTypes['jpg'] = 'image/jpg';
        $fileTypes['rar'] = 'application/rar';

        $fileTypes['ra'] = 'audio/x-pn-realaudio';
        $fileTypes['ram'] = 'audio/x-pn-realaudio';
        $fileTypes['ogg'] = 'audio/x-pn-realaudio';

        $fileTypes['wav'] = 'video/x-msvideo';
        $fileTypes['wmv'] = 'video/x-msvideo';
        $fileTypes['avi'] = 'video/x-msvideo';
        $fileTypes['asf'] = 'video/x-msvideo';
        $fileTypes['divx'] = 'video/x-msvideo';

        $fileTypes['mp3'] = 'audio/mpeg';
        $fileTypes['mp4'] = 'audio/mpeg';
        $fileTypes['mpeg'] = 'video/mpeg';
        $fileTypes['mpg'] = 'video/mpeg';
        $fileTypes['mpe'] = 'video/mpeg';
        $fileTypes['mov'] = 'video/quicktime';
        $fileTypes['swf'] = 'video/quicktime';
        $fileTypes['3gp'] = 'video/quicktime';
        $fileTypes['m4a'] = 'video/quicktime';
        $fileTypes['aac'] = 'video/quicktime';
        $fileTypes['m3u'] = 'video/quicktime';

        $fileTypes['php'] = array('application/x-php');
        $fileTypes['html'] = array('text/html');
        $fileTypes['txt'] = array('text/plain');
        return $fileTypes[$extension];
    }


    /*
    Parameters: downloadFile(File Location, File Name,
    max speed, is streaming
    If streaming - videos will show as videos, images as images
    instead of download prompt
    https://stackoverflow.com/a/13821992/1164642
    */
    function download_file($fileLocation, $fileName, $chunkSize = 1024)
    {
        if (connection_status() != 0) {
            return (false);
        }
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        $contentType = $this->get_file_mimes($extension);
        header("Cache-Control: public");
        header("Content-Transfer-Encoding: binary\n");
        header("Content-Type: $contentType");

        $contentDisposition = 'attachment';

        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            $fileName = preg_replace('/\./', '%2e', $fileName, substr_count($fileName, '.') - 1);
            header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
        } else {
            header("Content-Disposition: $contentDisposition;filename=\"$fileName\"");
        }

        header("Accept-Ranges: bytes");
        $range = 0;
        $size = filesize($fileLocation);

        if (isset($_SERVER['HTTP_RANGE'])) {
            list($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);
            str_replace($range, "-", $range);
            $size2 = $size - 1;
            $new_length = $size - $range;
            header("HTTP/1.1 206 Partial Content");
            header("Content-Length: $new_length");
            header("Content-Range: bytes $range$size2/$size");
        } else {
            $size2 = $size - 1;
            header("Content-Range: bytes 0-$size2/$size");
            header("Content-Length: " . $size);
        }

        if ($size == 0) {
            die('Zero byte file! Aborting download');
        }
        @ini_set('magic_quotes_runtime', 0);
        $fp = fopen("$fileLocation", "rb");

        fseek($fp, $range);

        while (!feof($fp) and (connection_status() == 0)) {
            @set_time_limit(0);
            print(@fread($fp, 1024 * $chunkSize));
            flush();
            ob_flush();
            sleep(1);
        }
        fclose($fp);

        return ((connection_status() == 0) and !connection_aborted());
    }
}

<?php

class AttachmentController extends Controller
{

    protected $dir;

    public function __construct() {
		parent::__construct();
		if (xiaocms::get_action_id() != 'ajaxswfupload' && !$this->session->get('user_id') && !$this->cookie->get('member_id')) $this->attMsg('无权限操作，请登录。');
		$this->dir = 'upload/';
	}
	
	/**
	 * 目录浏览
	 */
	public function albumAction() {
		$admin  = $this->get('admin');
		if (empty($admin) && $this->memberinfo) {
			$id = $this->memberinfo['id'];
			if ($id) {
			    $this->dir .= 'member/' . $id . '/'; //会员附件目录
				if (!file_exists($this->dir)) mkdir($this->dir);
			}
		} elseif (!$this->session->get('user_id')) {
		    $this->attMsg('游客不允许操作');
		}
	    $iframe = $this->get('iframe') ? 1 : 0;
        $dir    = $this->get('dir') ? $this->get('dir') : '';
		$dir = str_replace(array('..\\', '../', './', '.\\'), '', trim($dir));

        $dir    = substr($dir, 0, 1) == '/' ? substr($dir, 1) : $dir;
        $dir    = str_replace(array('\\', '//'), '/', $dir);
	    $file_list=xiaocms::load_class('file_list');
        $data   = $file_list->get_file_list($this->dir . $dir);
        $list   = array();
        if ($data) {
            foreach ($data as $t) {
                if ($t == 'index.html') continue;
				if (empty($admin) && strpos($t, '.thumb.') !== false) continue;
                $path = $dir . $t . '/';
                $ext  = is_dir($this->dir . $path) ? 'dir' : strtolower(trim(substr(strrchr($t, '.'), 1, 10)));
                $ico  = file_exists(ROOT_PATH . ADMIN_DIR . DIRECTORY_SEPARATOR . 'img/ext/' . $ext . '.gif') ? $ext . '.gif' : $ext . '.png';

                $list[] = array(
                    'name'     => $t, 
                    'dir'      => $path, 
                    'path'     => $this->dir . $path, 
                    'ico'      => $ico,
                    'isdir'    => is_dir($this->dir . $path) ? 1 : 0, 
                    'url'      => is_dir($this->dir . $path) ? url('attachment/album', array('dir'=>$path, 'iframe'=>$iframe, 'admin'=>$admin)) : '',
                );
            }
        }
        $pdir   = url('attachment/album', array('dir'=>str_replace(basename($dir), '', $dir),'iframe'=>$iframe, 'admin'=>$admin));
        $dir    = $this->dir. $dir;
        $istop  = $dir ? 1 : 0;
        include $this->admin_tpl('attachment_album');
	}

	
    /**
	 * 上传图片(单)
	 */
	public function imageAction() {
	    if ($this->post('submit')) {
		    $mark = $this->memberinfo ? false : true;
			$w = $this->site_config['SITE_THUMB_WIDTH'];
			$h = $this->site_config['SITE_THUMB_HEIGHT'];
	        $img  = array('w'=>$w, 'h'=>$h, 't'=>0);
			$size = (int)$this->post('size');
	        $data = $this->upload('file', array('jpeg', 'jpg', 'gif', 'png'), $size, $img, $mark, $this->post('admin'));
            if ($data['result']) {
                $row = array(
                    'error'    => 1,
                    'msg'      => $data['result'],
                    'filename' => '',
                );
            } else {
                $row = array(
                    'error'    => 0,
                    'msg'      => '图片上传成功，请单击“确定”按钮关闭对话框',
                    'filename' =>  $data['path'], //全路径
                );
            }
			$data = $row;
			$url   = url('attachment/image', array('w'=>$w, 'h'=>$h, 'size'=>$size, 'admin'=>$this->post('admin')));
			$note = '图片格式jpg、jpeg、gif、png，图片大小不超过' . $size . 'MB';
			include $this->admin_tpl('file_upload_result');
	    } else {
		    $w = (int)$this->get('w');
			$h = (int)$this->get('h');
			$s = (int)$this->get('size') ? (int)$this->get('size') : 2;
		    if ($w && empty($h)) {
				$w = $this->site_config['SITE_THUMB_WIDTH'];
				$h = $this->site_config['SITE_THUMB_HEIGHT'];
			} 
			$admin   = $this->getAdmin();
			$note    = '图片格式jpg、jpeg、gif、png，图片大小不超过' .$s . 'MB';
			$size    = $s;
			$isimage = 1; //如果是图片上传，就显示高宽输入框
	    	include $this->admin_tpl('file_upload');

	    }
	}
    
    /**
     * 多文件（图片）上传
     */
    public function filesAction() {
        $setting  = urldecode($this->get('setting'));
        list($type, $size) = explode('|', $setting);
        if (empty($type) || empty($size)) $this->attMsg('传递参数不正确');
        $type     = base64_decode($type);
        $size     = (int)$size;
        $filesize = 1024 * $size; //转换成MB
        $_type    = explode(',', $type);
        $data     = '';
        foreach ($_type as $t) {
            $data.= '*.' . $t . ';';
        }

		$admin     = $this->getAdmin();
        $sessionid = '1';
    	include $this->admin_tpl('attachment_swfupload');
    }
	
	/**
	 * 上传文件(单)
	 */
    public function fileAction() {
	    $type = urldecode($this->get('type'));
	    $type = base64_decode($type);
		$size = (int)$this->get('size');
	    $this->view->assign('note', '文件格式'.$type.'，文件大小不超过'.$size.'MB');
	    if ($this->post('submit')) {
	        $data = $this->upload('file', explode(',', $type), $size, null, null, $this->post('admin'));
            if ($data['result']) {
                $row = array(
                    'error'    => 1,
                    'msg'      => $data['result'],
                    'filename' => '',
                );
            } else {
                $row = array(
                    'error'    => 0,
                    'msg'      => '文件上传成功，请单击“确定”按钮关闭对话框',
                    'filename' =>  $data['path'], //全路径
                );
            }
			$data = $row;
			$url  = url('attachment/file', array('size'=>$size, 'type'=>$this->get('type'), 'admin'=>$this->post('admin')));
         	include $this->admin_tpl('file_upload_result');
	    } else {
		    $admin = $this->getAdmin();
         	include $this->admin_tpl('file_upload');

	    }
	}
    
    /**
     * 文件上传
     * @param  $fields 上传字段 'file'
     * @param  $type   文件类型  array(jpg,gif)
     * @param  $size   文件大小  MB
     * @param  $img    图片配置参数  
     * @param  $mark   图片水印  
     * @param  $admin  是否来自后台  
     * @param  $stype  上传方式  swf或者ke  
     * @return Array   返回数组
     */
    private function upload($fields, $type, $size, $img=null, $mark=true, $admin=0, $stype=null) {
	    $path     = $this->dir;
		$upload   = xiaocms::load_class('file_upload');
		if (empty($admin) && $this->memberinfo) {
			$uid  = $this->memberinfo['id']; //会员附件归类
			if ($uid) {
			    $path .= 'member/' . $uid . '/';
			}
		} elseif (!$this->session->get('user_id')) {
		    if (!$this->post('SWFUPLOADSESSID')) $this->attMsg('无权限', $stype);
		}
	    $upload->set($_FILES[$fields])
               ->set_limit_size(1024*1024*$size) //限制2Mb
               ->set_limit_type($type);
        //设置路径和名称
        $ext      = $upload->fileext();
        if (in_array($ext, array('jpg','jpeg','bmp','png','gif'))) {
            $dir  = 'image';
            $upload->set_image($img['w'], $img['h'], $img['t']);
        } else {
            $dir  = 'file';
        }
        $path    .= $dir . '/' . date('Ym') . '/';
        $file     = $upload->filename();
	    $filename = md5(time() . $file) . '.' . $ext;
        $result   = $upload->upload($path, $filename);
		//上传成功处理图片
        if (!$result && $dir == 'image') $this->watermark($path . $filename);
        return array('result'=>$result, 'path'=>  SITE_PATH . $path . $filename, 'file'=>$file , 'ext'=>$dir=='image' ? 1 : $ext);
    }
	
	/**
     * Swf上传
     */
    public function ajaxswfuploadAction() {
        if ($this->post('submit')) {
            $type  = $this->post('type');
            $_type = explode(',', $type);
            if (empty($_type))   exit('0,' . '文件类型参数错误');
            $size  = (int)$this->post('size');
            if (empty($size))    exit('0,' . '文件大小参数错误');
            $data  = $this->upload('Filedata', $_type, $size, null, null, $this->post('admin'), 'swf');
            if ($data['result']) exit('0,' . $data['result']); 
            //唯一ID,文件全路径,扩展名,文件名称
            exit(time() . rand(0, 999) . ',' . $data['path'] . ',' . $data['ext'] . ',' . str_replace('|', '_', $data['file']));
        } else {
            exit('0,' . '提交错误');
        }
    }
	
	/**
     * KE上传
     */
	public function kindeditor_uploadAction() {

	    //定义允许上传的文件扩展名
		$ext = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file'  => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		//检查目录
		$dir  = $this->get('dir') ? $this->get('dir') : 'image';
		if (!isset($ext[$dir])) {
		    echo json_encode(array('error' => 1, 'message' => '上传目录('.$dir.')不正确'));exit;
		}
		$img  = $dir == 'image' ? 1 : 0;
		$size = $img ? 2 : 100;
		//检查文件大小
		if (is_null($_FILES['imgFile']['size']) || $_FILES['imgFile']['size'] > $size * 1024 * 1024) {
		    echo json_encode(array('error' => 1, 'message' => '不能超过'.$size.'MB'));exit;
		}
		$data = $this->upload('imgFile', $ext[$dir], $size, $img, null, $this->getAdmin(), 'ke');
		if ($data['result']) {
			echo json_encode(array('error' => 1, 'message' => $data['result']));exit;
		} else {
			echo json_encode(array('error' => 0, 'url' => $data['path']));exit;
		}
	}
	
	/**
     * KE浏览
     */
	public function kindeditor_managerAction() {
		$root_path = ROOT_PATH . $this->dir;
		$root_url  = SITE_PATH . $this->dir;
		//用户目录设定
		$admin     = $this->getAdmin();
		if (empty($admin) && $this->memberinfo) {
			$id    = $this->memberinfo['id'];
			if ($id) { //会员附件目录
			    $root_path .= 'member/' . $id . '/'; 
				$root_url  .= 'member/' . $id . '/'; 
				if (!file_exists($root_path)) mkdir($root_path);
			}
		} elseif (!$this->session->get('user_id')) {
		    //属于游客
			exit;
		}
		//图片扩展名
		$ext_arr  = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
		//目录名
		$dir_name = $this->get('dir') == 'image' ? 'image' : 'file';
		if ($dir_name !== '') {
			$root_path .= $dir_name . "/";
			$root_url  .= $dir_name . "/";
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
		}
		//根据path参数，设置各路径和URL
		if (empty($_GET['path'])) {
			$current_path     = realpath($root_path) . '/';
			$current_url      = $root_url;
			$current_dir_path = '';
			$moveup_dir_path  = '';
		} else {
			$_GET['path']     = str_replace('%2F', '', $_GET['path']);
			$current_path     = realpath($root_path) . '/' . $_GET['path'];
			$current_url      = $root_url . $_GET['path'];
			$current_dir_path = $_GET['path'];
			$moveup_dir_path  = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		}
		echo realpath($root_path);
		//排序形式，name or size or type
		$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path)) {
			echo 'Access is not allowed.';
			exit;
		}
		//最后一个字符不是/
		if (!preg_match('/\/$/', $current_path)) {
			echo 'Parameter is not valid.';
			exit;
		}
		//目录不存在或不是目录
		if (!file_exists($current_path) || !is_dir($current_path)) {
			echo 'Directory does not exist.';
			exit;
		}
		//遍历目录取得文件信息
		$file_list  = array();
		if ($handle = opendir($current_path)) {
			$i      = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.' || strpos($filename, '.thumb.') !== false) continue;
				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir']   = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir']   = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = filesize($file);
					$file_list[$i]['dir_path'] = '';
					$file_ext                  = strtolower(substr(strrchr($file, '.'), 1));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename']     = $filename; //文件名，包含扩展名
				$file_list[$i]['datetime']     = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}

		//排序
		function cmp_func($a, $b) {
			global $order;
			if ($a['is_dir'] && !$b['is_dir']) {
				return -1;
			} else if (!$a['is_dir'] && $b['is_dir']) {
				return 1;
			} else {
				if ($order == 'size') {
					if ($a['filesize'] > $b['filesize']) {
						return 1;
					} else if ($a['filesize'] < $b['filesize']) {
						return -1;
					} else {
						return 0;
					}
				} else if ($order == 'type') {
					return strcmp($a['filetype'], $b['filetype']);
				} else {
					return strcmp($a['filename'], $b['filename']);
				}
			}
		}
		usort($file_list, 'cmp_func');
		$result = array();
		//相对于根目录的上一级目录
		$result['moveup_dir_path']  = $moveup_dir_path;
		//相对于根目录的当前目录
		$result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
		$result['current_url']      = $current_url;
		//文件数
		$result['total_count']      = count($file_list);
		//文件列表数组
		$result['file_list']        = $file_list;
		//输出JSON字符串
		echo json_encode($result);
	}
	

	/**
     * 判断是否来自后台
     */
	private function getAdmin() {
	    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] && stripos($_SERVER['HTTP_REFERER'], 's=admin') !== false) {
		    return 1;
		}
		return 0;
	}
	
	/**
     * 消息提示
     */
	private function attMsg($msg, $stype=null) {
	    if ($stype == 'swf') {
		    exit('0,' . $msg);
		} elseif ($stype == 'ke') {
		    echo json_encode(array('error' => 1, 'message' => $msg));exit;
		} elseif ($stype == 'ue') {
		    echo json_encode(array('state' => $msg));exit;
		}
	    exit("<div style='padding-top:40px;text-align:center;font-size:14px;'><font color=red>×</font>&nbsp;&nbsp;" . $msg . "</div>");
	}

}

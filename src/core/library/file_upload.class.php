<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

/**
 * file_upload class file
 */
class file_upload
{

    /**
     * 文件大小
     *
     * @var integer
     */
    protected $limit_size;

    /**
     * 文件名字
     *
     * @var string
     */
    protected $file_name;

    /**
     * 文件类型
     *
     * @var string
     */
    protected $limit_type;

    /**
     * 图片模式
     *
     * @var array
     */
    protected $image;

    /**
     * 构造函数
     *
     * @access public
     * @return boolean
     */
    public function __construct()
    {
        $this->limit_size = 2097152; // 默认文件大小 2M
        return true;
    }

    /**
     * 取得文件扩展
     *
     * @return 扩展名
     */
    public function fileext()
    {
        return strtolower(trim(substr(strrchr($this->file_name['name'], '.'), 1, 10)));
    }

    /**
     * 取得文件名
     * 带扩展名和不带扩展名
     * @return
     */
    public function filename($ext = false)
    {
        return $ext ? $this->file_name['name'] : str_replace('.' . $this->fileext(), '', $this->file_name['name']);
    }

    /**
     * 设置文件字段,$_FIELDS['file']
     * @param  $file
     */
    public function set($file)
    {
        $this->file_name = $file;
        return $this;
    }

    /**
     * 设置图片模式
     * @param int $w
     * @param int $h
     * @param int $t
     * @return file_upload
     */
    public function set_image($w, $h, $t)
    {
        $this->image = array($w, $h, $t);
        return $this;
    }

    /**
     * 设置上传文件的大小限制.
     *
     * @param integer $size
     * @return unkonow
     */
    public function set_limit_size($size)
    {
        if ($size) {
            $this->limit_size = $size;
        }

        return $this;
    }

    /**
     * 设置上传文件允许的格式
     *
     * @param string $type
     * @return unkonow
     */
    public function set_limit_type($type)
    {
        if (!$type || !is_array($type)) {
            return false;
        }

        $this->limit_type = $type;
        return $this;
    }

    /**
     * 验证上传文件的格式
     *
     * @return boolean
     */
    protected function parse_mimetype()
    {
        if (!in_array($this->fileext(), $this->limit_type)) {
            return '您上传的文件格式不正确';
        }
        return false;
    }

    /**
     * 上传文件
     *
     * @param string $paht 上传后的目标目录/结尾
     * @param string $file_name 上传后的目标文件名
     * @return boolean 上传成功返回0，返回错误信息
     */
    public function upload($path, $file_name)
    {
        $result = $this->parse_init();
        if ($result) {
            return $result;
        }

        // 验证路径
        if (!is_dir($path)) {
            $file_list = core::load_class('file_list');
            $file_list->make_dir($path);
        }
        if (!@move_uploaded_file($this->file_name['tmp_name'], $path . $file_name)) {
            return $file_name . '文件移动失败，请检查服务器临时目录权限';
        }
        $this->image($path, $file_name);
        return false;
    }

    /**
     * 验证文件
     */
    protected function parse_init()
    {
        if (is_null($this->file_name['size']) || $this->file_name['size'] > $this->limit_size) {
            return '文件大小超出上传限制';
        }
        if ($this->limit_type) {
            return $this->parse_mimetype();
        }

        return false;
    }

    /**
     * 处理图片，生成缩略图和剪切图
     * @param $path
     * @param $file_name
     * @return boolean
     */
    protected function image($path, $file_name)
    {
        if (empty($this->image)) {
            return false;
        }

        // 图片处理
        $width = (int) $this->image['0'];
        $height = (int) $this->image['1'];
        $type = $this->image['2'];
        if (empty($width) || empty($height)) {
            return false;
        }

        $srcfile = $path . $file_name;
        $tofile = $srcfile . '.thumb.' . $width . 'x' . $height . '.' . $this->fileext();
        // $tofile  = $srcfile;
        list($src_w, $src_h, $src_t) = getimagesize($srcfile); // 获取原图尺寸
        $dst_scale = $width / $height; // 目标图像长宽比
        $src_scale = $src_h / $src_w; // 原图长宽比
        if ($src_scale >= $dst_scale) { // 过高
            $w = intval($src_w);
            $h = intval($dst_scale * $w);
            $x = 0;
            $y = ($src_h - $h) / 3;
        } else { // 过宽
            $h = intval($src_h);
            $w = intval($h / $dst_scale);
            $x = ($src_w - $w) / 2;
            $y = 0;
        }
        switch ($src_t) {
            case 1: // 图片类型，1是gif图
                $source = @imagecreatefromgif($srcfile);
                break;
            case 2: // 图片类型，2是jpg图
                $source = @imagecreatefromjpeg($srcfile);
                break;
            case 3: // 图片类型，3是png图
                $source = @imagecreatefrompng($srcfile);
                break;
        }
        if ($type) {
            // 剪裁
            $target = imagecreatetruecolor($width, $height);
            imagecopy($target, $source, 0, 0, 0, 0, $width, $height);
        } else {
            // 缩放
            $scale = $width / $w;
            $target = imagecreatetruecolor($width, $height);
            $final_w = intval($w * $scale);
            $final_h = intval($h * $scale);
            imagecopyresampled($target, $source, 0, 0, 0, 0, $final_w, $final_h, $w, $h);
        }
        imagejpeg($target, $tofile);
        imagedestroy($target);
    }
}

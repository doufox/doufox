<?php
/**
 * 生成验证码
 * 类用法
 * $checkcode = new checkcode();
 * $checkcode->doimage();
 * 取得验证
 * $_SESSION['code']=$checkcode->get_code();
 */

if (!defined('IN_CMS')) {
    exit();
}

class checkcode
{

    //验证码的宽度
    public $width = 80;

    //验证码的高
    public $height = 30;

    //设置字体的地址
    private $font;

    //设置字体色
    public $font_color;

    //设置随机生成因子
    public $charset = 'abcdefghkmnprstuvwyzABCDEFGHKLMNPRSTUVWYZ23456789';

    //设置背景色
    public $background = '#ffffff';

    //生成验证码字符数
    public $code_len = 4;

    //字体大小
    public $font_size = 12;

    //验证码
    private $code;

    //图片内存
    private $img;

    //文字X轴开始的地方
    private $x_start;

    public function __construct()
    {
        $this->font = STATIC_PATH . 'fonts/elephant.ttf';
    }

    /**
     * 生成随机验证码。
     */
    protected function creat_code()
    {
        $code = '';
        $charset_len = strlen($this->charset) - 1;
        for ($i = 0; $i < $this->code_len; $i++) {
            $code .= $this->charset[rand(1, $charset_len)];
        }
        $this->code = $code;
    }

    /**
     * 获取验证码
     */
    public function get_code()
    {
        return strtolower($this->code);
    }

    /**
     * 生成图片
     */
    public function doimage($mode = 0)
    {
        $code = $this->creat_code();
        $this->img = imagecreatetruecolor($this->width, $this->height);
        if (!$this->font_color) {
            $this->font_color = imagecolorallocate($this->img, rand(0, 156), rand(0, 156), rand(0, 156));
        } else {
            $this->font_color = imagecolorallocate($this->img, hexdec(substr($this->font_color, 1, 2)), hexdec(substr($this->font_color, 3, 2)), hexdec(substr($this->font_color, 5, 2)));
        }
        //设置背景色
        $background = imagecolorallocate($this->img, hexdec(substr($this->background, 1, 2)), hexdec(substr($this->background, 3, 2)), hexdec(substr($this->background, 5, 2)));
        //画一个柜形，设置背景颜色。
        imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $background);
        $this->creat_font();
        $this->output($mode);
    }

    /**
     * 生成文字
     */
    private function creat_font()
    {
        $x = $this->width / $this->code_len;
        for ($i = 0; $i < $this->code_len; $i++) {
            imagettftext($this->img, $this->font_size, rand(-30, 30), $x * $i + rand(0, 5), $this->height / 1.4, $this->font_color, $this->font, $this->code[$i]);
            if ($i == 0) {
                $this->x_start = $x * $i + 5;
            }

        }
    }

    /**
     * 输出图片
     */
    private function output($mode = 0)
    {
        if ($mode) {
            header('content-type:image/jpeg');
            imagejpeg($this->img, '', 70);
        } else {
            header("content-type:image/png");
            imagepng($this->img);
        }
        imagedestroy($this->img);
    }

}

<?php
if (!defined('IN_CMS')) exit();
return array(

    /* Site Config */
    'SITE_NAME'               => 'DouFox', // 网站名称
    'SITE_THEME'              => 'default', // 桌面端主题样式, 默认default
    'SITE_THEME_MOBILE'       => 'default', // 移动端主题样式, 默认default
    'SITE_MOBILE'             => true, // 移动端主题样式, 默认关闭
    'SITE_TITLE'              => '首页标题', // 网站首页SEO标题
    'SITE_SLOGAN'             => '头部标语', // 网站头部标语
    'SITE_KEYWORDS'           => '关键字', // 网站SEO关键字
    'SITE_DESCRIPTION'        => '网站描述', // 网站SEO描述信息
    'SITE_WATERMARK'          => '2', // 水印功能
    'SITE_WATERMARK_ALPHA'    => '55', // 图片水印透明度
    'SITE_WATERMARK_TEXT'     => '23432534634564564575', // 文字水印
    'SITE_WATERMARK_SIZE'     => '14', // 文字大小
    'SITE_WATERMARK_POS'      => '5', // 水印位置
    'SITE_THUMB_WIDTH'        => '200', // 内容缩略图默认宽度
    'SITE_THUMB_HEIGHT'       => '200', // 内容缩略图默认高度
    'MEMBER_MODELID'          => '0', // 默认会员模型
    'MEMBER_REGISTER'         => '1', // 新会员注册
    'MEMBER_STATUS'           => '1', // 新会员审核
    'MEMBER_REGCODE'          => '1', // 注册验证码
    'MEMBER_LOGINCODE'        => '1', // 登录验证码
    'DIY_URL'                 => '0', // 开启伪静态
    'LIST_URL'                => '{dir}.html', // 栏目url
    'LIST_PAGE_URL'           => '{dir}_{page}.html', // 栏目带分页url
    'SHOW_URL'                => '{dir}/{id}.html', // 内容页url
    'SHOW_PAGE_URL'           => '{dir}/{id}_{page}.html', // 内容分页url
    'HIDE_ENTRY_FILE'         => false, // 当入口文件为服务器设置的默认索引文件（如index.php）时，设置才会生效
    'URL_LIST_TYPE'           => false, // 栏目参数形式，ID形式：catid=123，目录形式：catdir=catdir
    'WEIXIN_MP_OPENED'        => false, // 微信公众号开关
    'WEIXIN_MP_URL'           => '', // 接收来自微信服务器的请求,必须以http://或https://开头
    'WEIXIN_MP_TOKEN'         => '', // 微信服务器的验证token,必须为英文或数字，长度为3-32字符
    'WEIXIN_MP_AESKEY'        => '', // EncodingAESKey,消息加密密钥由43位字符组成
    'RAND_CODE'               => '1284adb94da485e70f8c3064da8232d9', // 随机代码

);
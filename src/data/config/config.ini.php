<?php
if (!defined('IN_CRONLITE')) {
    exit();
}

return array(
    'SITE_NAME'               => 'Doufox', // 网站名称
    'SITE_THEME'              => 'bootstrap', // 桌面端主题样式, 默认default
    'SITE_MOBILE'             => 'mobile', // 移动端主题样式, 默认mobile
    'SITE_TITLE'              => 'Doufox网站内容管理系统', // 网站首页SEO标题
    'SITE_SLOGAN'             => '宣传标语', // 网站宣传标语
    'SITE_KEYWORDS'           => 'Doufox,CMS,PHP,网站管理系统', // 网站SEO关键字
    'SITE_DESCRIPTION'        => 'Doufox是一款基于PHP和MySQL的功能强大的网站内容管理系统。', // 网站SEO描述信息
    'SITE_WATERMARK'          => '2', // 水印功能
    'SITE_WATERMARK_ALPHA'    => '55', // 图片水印透明度
    'SITE_WATERMARK_TEXT'     => '豆文库', // 文字水印
    'SITE_WATERMARK_SIZE'     => '14', // 文字大小
    'SITE_WATERMARK_POS'      => '5', // 水印位置
    'SITE_THUMB_WIDTH'        => '200', // 内容缩略图默认宽度
    'SITE_THUMB_HEIGHT'       => '200', // 内容缩略图默认高度
    'MEMBER_MODELID'          => '0', // 默认会员模型
    'MEMBER_REGISTER'         => '1', // 新会员注册
    'MEMBER_STATUS'           => '1', // 新会员审核
    'MEMBER_REGCODE'          => '1', // 注册验证码
    'MEMBER_LOGINCODE'        => '1', // 登录验证码
    'DIY_URL'                 => '1', // 开启伪静态
    'INDEX_URL'               => 'index.html', // 首页url
    'LIST_URL'                => '{catpath}.html', // 栏目url
    'LIST_PAGE_URL'           => '{catpath}-{page}.html', // 栏目带分页url
    'SHOW_URL'                => 'article-{id}.html', // 内容页url
    'SHOW_PAGE_URL'           => 'article-{id}-{page}.html', // 内容分页url
    'HIDE_ENTRY_FILE'         => '1', // 隐藏入口文件需要服务器配置默认文件，如index.php。当服务器配置的默认文件与程序入口文件一致时，设置才生效
    'URL_LIST_TYPE'           => '1', // 栏目参数形式，ID形式：catid=123，目录形式：catpath=catpath
    'WEIXIN_MP_OPENED'        => '', // 微信公众号开关
    'WEIXIN_MP_URL'           => '', // 接收来自微信服务器的请求,必须以http://或https://开头
    'WEIXIN_MP_TOKEN'         => '', // 微信服务器的验证token,必须为英文或数字，长度为3-32字符
    'WEIXIN_MP_AESKEY'        => '', // EncodingAESKey,消息加密密钥由43位字符组成
    'RAND_CODE'               => '0334a4d29d7e47628d2bf52017b46644', // 随机代码
    'ADMIN_LOGINCODE'         => '0', // 后台登录需要输入验证码
    'ADMIN_LOGINPATH'         => 'doudou', // 后台登录路径默认admin
    'SITE_ICP_FILING_NUMBER'  => '沪ICP备12345678号', // 网站ICP备案号
    'STORAGE_TYPE'            => '0', // 附件存储形式

);
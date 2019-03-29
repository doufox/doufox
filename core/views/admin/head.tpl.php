<div class="header">
    <h1 class="title"><a href="<?php echo url('admin'); ?>">网站管理系统</a></h1>
    <ul id="menu" class="menu">
        <li id="M_200"><a href="javascript:_open_url(200,'<?php echo url('admin/category'); ?>');">栏目</a></li>
        <li id="M_300"><a href="javascript:_open_url(300,'<?php echo url('admin/block'); ?>');">区块</a></li>
        <li id="M_400"><a href="javascript:_open_url(400,'<?php echo url('admin/member'); ?>');">会员</a></li>
        <li id="M_401"><a href="javascript:_open_url(401,'<?php echo url('admin/account'); ?>');">账号</a></li>
        <li id="M_500">
            <a href="javascript:_open_url(500,'<?php echo url('admin/model'); ?>');">模型</a>
            <ul>
                <li id="M_501"><a href="javascript:_open_url(501,'<?php echo url('admin/model'); ?>');">内容模型</a></li>
                <li id="M_501"><a href="javascript:_open_url(501,'<?php echo url('admin/model', array('typeid'=>2)); ?>');">会员模型</a></li>
                <li id="M_502"><a href="javascript:_open_url(502,'<?php echo url('admin/model', array('typeid'=>3)); ?>');">表单模型</a></li>
                <li class="menubtm"></li>
                <?php if (is_array($menu)) {foreach ($menu as $t) {?>
                <li id="M_5<?php echo $t['id'] ?>">
                    <a href="javascript:_open_url(5<?php echo $t['id'] ?>,'<?php echo $t['url'] ?>');"><?php echo $t['name'] ?></a>
                </li>
                <?php }}?>
                <li class="menubtm"></li>
            </ul>
        </li>
        <li id="M_104">
            <a href="javascript:_open_url(104, '<?php echo url('admin/config/index'); ?>');">设置</a>
            <ul>
                <li id="M_1041"><a href="javascript:_open_url(1041,'<?php echo url('admin/config/index', array('type'=>1)); ?>');">网站信息</a></li>
                <li id="M_1042"><a href="javascript:_open_url(1042,'<?php echo url('admin/config/index', array('type'=>2)); ?>');">水印设置</a></li>
                <li id="M_1043"><a href="javascript:_open_url(1043,'<?php echo url('admin/config/index', array('type'=>3)); ?>');">帐号配置</a></li>
                <li id="M_1044"><a href="javascript:_open_url(1044,'<?php echo url('admin/config/index', array('type'=>4)); ?>');">会员配置</a></li>
                <li id="M_1045"><a href="javascript:_open_url(1045,'<?php echo url('admin/config/index', array('type'=>5)); ?>');">URL设置</a></li>
                <li id="M_1046"><a href="javascript:_open_url(1046,'<?php echo url('admin/config/index', array('type'=>6)); ?>');">微信配置</a></li>
                <li class="menubtm"></li>
            </ul>
        </li>
        <li id="M_105">
            <a href="javascript:void(0);">管理</a>
            <ul>
                <li id="M_1051"><a href="javascript:_open_url(1051,'<?php echo url('admin/template'); ?>');">模板管理</a></li>
                <li id="M_1052"><a href="javascript:_open_url(1052,'<?php echo url('admin/attachment'); ?>');">附件管理</a></li>
                <li id="M_1053"><a href="javascript:_open_url(1053,'<?php echo url('admin/database'); ?>');">数据库管理</a></li>
                <li id="M_1054"><a href="javascript:_open_url(1054,'<?php echo url('admin/backup'); ?>');">备份管理</a></li>
                <li class="menubtm"></li>
                <li id="M_1055"><a href="javascript:_open_url(1055,'<?php echo url('admin/createhtml/index'); ?>');">静态页面管理</a>
                <li id="M_1056"><a href="javascript:_open_url(1056,'<?php echo url('admin/index/cache'); ?>');">更新缓存</a></li>
                <li id="M_1057"><a href="javascript:_open_url(1057,'<?php echo url('admin/content/updateurl'); ?>');">更新内容URL</a></li>
                <li class="menubtm"></li>
            </ul>
        </li>
        
        <li id="M_108" class="account">
            <a href="javascript:void(0);">您好，<?php echo $name; ?></a>
            <ul>
                <li id="M_1081"><a href="javascript:_open_url(1081,'<?php echo url('admin/account/me'); ?>');">我的账号</a></li>
                <li id="M_1082"><a href="javascript:_open_url(1081,'<?php echo url('admin/account/me'); ?>');" title="帮助">帮助</a></li>
                <li id="M_1082"><a href="javascript:logout();" title="退出系统">退出系统</a></li>
                <li class="menubtm"></li>
            </ul>
        </li>
    </ul>
</div>

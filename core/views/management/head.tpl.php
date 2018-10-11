<div class="header">
    <h1 class="title">网站管理系统后台</h1>
    <ul id="menu">
        <li id="_MP100" class="focused"><a href="<?php echo url('admin'); ?>">主页</a></li>
        <li id="_MP101"><a href="javascript:_MP(101,'<?php echo url('admin/category'); ?>');">栏目</a></li>
        <li id="_MP102"><a href="javascript:_MP(102,'<?php echo url('admin/block'); ?>');">区块</a></li>
        <?php if ($MEMBER_REGISTER) {?>
        <li id="_MP103"><a href="javascript:_MP(103,'<?php echo url('admin/member'); ?>');">会员</a></li>
        <?php }?>
        <li id="_MP104">
            <a href="javascript:_MP(104, '<?php echo url('admin/index/config'); ?>');">设置</a>
            <ul>
                <li id="_MP1041"><a href="javascript:_MP(1041,'<?php echo url('admin/index/config', array('type'=> 1)); ?>');">系统设置</a></li>
                <li id="_MP1042"><a href="javascript:_MP(1042,'<?php echo url('admin/index/config', array('type'=> 2)); ?>');">水印设置</a></li>
                <li id="_MP1043"><a href="javascript:_MP(1043,'<?php echo url('admin/index/config', array('type'=> 3)); ?>');">后台密码</a></li>
                <li id="_MP1044"><a href="javascript:_MP(1044,'<?php echo url('admin/index/config', array('type'=> 4)); ?>');">会员配置</a></li>
                <li id="_MP1045"><a href="javascript:_MP(1045,'<?php echo url('admin/index/config', array('type'=> 5)); ?>');">URL设置</a></li>
                <li id="_MP107"><a href="javascript:_MP(107,'<?php echo url('admin/index/cache'); ?>');">更新缓存</a></li>
                <li id="_MP403"><a href="javascript:_MP(403,'<?php echo url('admin/content/updateurl'); ?>');">更新内容URL</a></li>
                <li id="_MP403"><a href="javascript:_MP(403,'<?php echo url('admin/database'); ?>');">数据库备份</a></li>
                <li id="_MP1046"><a href="javascript:_MP(1046,'<?php echo url('admin/model'); ?>');">内容模型</a></li>
                <li id="_MP1047"><a href="javascript:_MP(1047,'<?php echo url('admin/model', array('typeid'=> 3)); ?>');">表单模型</a></li>
                <?php if (is_array($menu)) {foreach ($menu as $t) {?>
                <li id="_MP9<?php echo $t['id'] ?>">
                    <a href="javascript:_MP(9<?php echo $t['id'] ?>,'<?php echo $t['url'] ?>');"><?php echo $t['name'] ?></a>
                </li>
                <?php }}?>
                <li class="menubtm"></li>
            </ul>
        </li>
        <li id="_MP105"><a href="javascript:_MP(105,'<?php echo url('admin/template'); ?>');">模板</a></li>
        <li id="_MP106">
            <a href="javascript:_MP(106,'<?php echo url('admin/createhtml'); ?>');">生成</a>
            <ul>
                <li id="_MP1061"><a href="javascript:_MP(1061,'<?php echo url('admin/createhtml/index'); ?>&a=index');">生成首页</a></li>
                <li id="_MP1062"><a href="javascript:_MP(1062,'<?php echo url('admin/createhtml'); ?>&a=category');">生成栏目页</a></li>
                <li id="_MP1063"><a href="javascript:_MP(1063,'<?php echo url('admin/createhtml'); ?>&a=show');">生成内容页</a></li>
                <li class="menubtm"></li>
            </ul>
        </li>
        <li id="_MP107"><a href="javascript:_MP(107,'<?php echo url('admin/attachment'); ?>');">附件</a></li>
    </ul>
    <div class="user">
        <span><?php echo $username; ?>&nbsp;</span>
        <a href="javascript:void(0);" onClick="logout();">退出</a>
    </div>
</div>

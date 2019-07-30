<div class="container">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo url('admin'); ?>">内容管理系统</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul id="menu" class="menu nav navbar-nav">
                    <li><a href="<?php echo url('admin/content'); ?>">内容</a></li>
                    <li><a href="<?php echo url('admin/category'); ?>">栏目</a></li>
                    <li><a href="<?php echo url('admin/block'); ?>">区块</a></li>
                    <li><a href="<?php echo url('admin/member'); ?>">会员</a></li>
                    <li><a href="<?php echo url('admin/config'); ?>">设置</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">模型&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/model'); ?>">内容模型</a></li>
                            <li><a href="<?php echo url('admin/model', array('typeid' => 2)); ?>">会员模型</a></li>
                            <li><a href="<?php echo url('admin/model', array('typeid' => 3)); ?>">表单模型</a></li>
                            <?php if (is_array($this->menu_model)) { ?>
                                <li role="separator" class="divider"></li>
                                <?php foreach ($this->menu_model as $t) { ?>
                                    <li><a href="<?php echo $t['url'] ?>"><?php echo $t['name'] ?></a></li>
                                <?php }
                            } ?>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">管理&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/account'); ?>">账号管理</a></li>
                            <li><a href="<?php echo url('admin/template'); ?>">模板管理</a></li>
                            <li><a href="<?php echo url('admin/attachment'); ?>">附件管理</a></li>
                            <li><a href="<?php echo url('admin/database'); ?>">数据库管理</a></li>
                            <li><a href="<?php echo url('admin/backup'); ?>">备份管理</a></li>
                            <li><a href="<?php echo url('admin/cache'); ?>">缓存管理</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo url('admin/createhtml/index'); ?>">静态页面管理</a>
                            <li><a href="<?php echo url('admin/cache/update'); ?>">更新全站缓存</a></li>
                            <li><a href="<?php echo url('admin/content/updateurl'); ?>">更新内容URL</a></li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="account dropdown">
                        <a href="javascript:void(0);" data-toggle="dropdown">您好，<?php echo $this->current_account_name; ?>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/account/me'); ?>">我的账号</a></li>
                            <li><a href="<?php echo url('admin/account/me'); ?>" title="帮助">帮助</a></li>
                            <li><a href="<?php echo HTTP_URL; ?>" title="网站首页" target="_blank">网站首页</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="javascript:logout();" title="退出系统">退出系统</a></li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
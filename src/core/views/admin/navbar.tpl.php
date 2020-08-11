<div class="container-fluid">
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
                    <li <?php if ($this->current_nav == 'content') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/content'); ?>">内容</a>
                    </li>
                    <li <?php if ($this->current_nav == 'category') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/category'); ?>">栏目</a>
                    </li>
                    <li <?php if ($this->current_nav == 'block') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/block'); ?>">区块</a>
                    </li>
                    <li <?php if ($this->current_nav == 'member') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/member'); ?>">会员</a>
                    </li>
                    <li <?php if ($this->current_nav == 'plugin') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/plugin'); ?>">插件</a>
                    </li>
                    <li <?php if ($this->current_nav == 'config') echo 'class="active"'; ?>>
                        <a href="<?php echo url('admin/config'); ?>">设置</a>
                    </li>
                    <li class="dropdown <?php if ($this->current_nav == 'model') echo 'active'; ?>">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">模型&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/model', array('typeid' => 1)); ?>">内容模型</a></li>
                            <li><a href="<?php echo url('admin/model', array('typeid' => 2)); ?>">会员模型</a></li>
                            <li><a href="<?php echo url('admin/model', array('typeid' => 3)); ?>">表单模型</a></li>
                            <li><a href="<?php echo url('admin/model', array('typeid' => 4)); ?>">单页模型</a></li>
                            <?php if (is_array($this->menu_model)) { ?>
                                <li role="separator" class="divider"></li>
                                <?php foreach ($this->menu_model as $t) { ?>
                                    <li><a href="<?php echo $t['url'] ?>"><?php echo $t['name'] ?></a></li>
                                <?php }
                            } ?>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                    <li class="dropdown <?php if ($this->current_nav == 'manage') echo 'active'; ?>">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">管理&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/account'); ?>">后台账号</a></li>
                            <li><a href="<?php echo url('admin/file'); ?>">文件管理</a></li>
                            <li><a href="<?php echo url('admin/template'); ?>">模板主题</a></li>
                            <li><a href="<?php echo url('admin/attachment'); ?>">附件管理</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo url('admin/database'); ?>">数据库</a></li>
                            <li><a href="<?php echo url('admin/backup'); ?>">备份管理</a></li>
                            <li><a href="<?php echo url('admin/cache'); ?>">缓存文件</a></li>
                            <li><a href="<?php echo url('admin/session'); ?>">用户会话</a></li>
                            <li><a href="<?php echo url('admin/html'); ?>">网页静态化</a>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo url('admin/cache/update'); ?>">更新全站缓存</a></li>
                            <li><a href="<?php echo url('admin/content/updateurl'); ?>">更新内容URL</a></li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="account dropdown">
                        <a href="javascript:void(0);" data-toggle="dropdown">您好，<?php echo $this->current_account['name']; ?>&nbsp;<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('admin/account/me'); ?>">我的账号</a></li>
                            <li><a href="<?php echo url('admin/feedback'); ?>" title="帮助信息">帮助信息</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="<?php echo HTTP_URL; ?>" title="网站首页" target="_blank">网站首页</a></li>
                            <li><a href="<?php echo url('member/index'); ?>" title="用户中心" target="_blank">用户中心</a></li>
                            <li role="separator" class="divider"></li>
                        </ul>
                    </li>
                    <li><a href="#" id="btn-logout" data-toggle="modal" data-target="#modal-confirm" title="退出系统后台">退出</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?php doHookAction('admin_top'); echo PHP_EOL; ?>
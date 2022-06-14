<?php include $this->views("install/header");?>

<div class="panel-body">
    <p class="lead text-center">使用说明</p>
    <hr />
    <p>欢迎使用 <?php echo APP_NAME; ?> 网站内容管理系统</p>
    <p>您可以在基于 MIT 许可证的授权下, 使用本系统</p>
    <p>我们追求目标: 实现一套通用、简单、自由、开源的网站内容管理系统</p>
    <p>官方网站: <a target="_blank" href="<?php echo APP_SITE; ?>"><?php echo APP_SITE; ?></a></p>
    <hr />
    <div class="text-center">
        <a class="btn btn-default" href="<?php echo url('install', array('step' => 2)); ?>">开始安装</a>
    </div>
</div>

<?php include $this->views("install/footer");?>

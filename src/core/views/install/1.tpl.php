<?php include $this->install_view("header");?>

<div class="panel-body">
    <p class="lead text-center">使用说明</p>
    <hr />
    <p>欢迎使用网站管理系统</p>
    <p>你可以在基于MIT许可证的授权下, 使用本系统</p>
    <p>我们追求目标: 实现一套通用、简单、自由、开源的网站管理系统</p>
    <p>官方网站: <a target="_blank" href="<?php echo APP_SITE; ?>"><?php echo APP_SITE; ?></a></p>
    <hr />
    <div class="text-center">
        <a class="btn btn-default" href="<?php echo url('install', array('step' => 2)); ?>">开始安装</a>
    </div>
</div>

<?php include $this->install_view("footer");?>

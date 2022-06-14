<?php include $this->views("install/header");?>

    <script type="text/javascript">
        function $(ID) {return document.getElementById(ID);}
    </script>
    <div class="panel-body">
        <p class="lead text-center">安装成功</p>
        <hr />
        <p>
            <label>后台管理地址：</label>
            <a href="<?php echo url('admin'); ?>"><?php echo url('admin'); ?></a>
        </p>
        <p>
            <label>超级管理员账号：</label>
            <span><?php echo $username; ?></span>
        </p>
        <p>
            <label>超级管理员密码：</label>
            <span><?php echo $password; ?></span>
        </p>
        <hr />
        <div class="text-center">
            <a class="btn btn-default" href="<?php echo url('admin'); ?>">登录后台</a>
        </div>
    </div>

<?php include $this->views("install/footer");?>
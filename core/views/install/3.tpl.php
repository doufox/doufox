<?php include $this->install_tpl("header");?>

    <script type="text/javascript">
        function $(ID) {return document.getElementById(ID);}
    </script>
    <p class="lead text-center">安装成功</p>
    <hr />
    <div class="panel-body">
        <div class="form-group">
            <label class="col-sm-4 control-label">后台管理地址：</label>
            <div class="col-sm-8">
                <a href="<?php echo url('admin'); ?>"><?php echo url('admin'); ?></a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">超级管理员账号：</label>
            <div class="col-sm-8"><?php echo $username; ?></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">超级管理员密码：</label>
            <div class="col-sm-8"><?php echo $password; ?></div>
        </div>
    </div>
    <hr />
    <div class="text-center">
        <a class="btn btn-default" href="<?php echo url('admin'); ?>">登录后台</a>
    </div>

<?php include $this->install_tpl("footer");?>
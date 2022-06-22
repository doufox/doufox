<?php include $this->views("install/header");?>

    <div class="panel-body">
        <p class="lead text-center">处理中。。</p>
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
        <iframe src="<?php echo url('install/cache', array('time' => $time)); ?>" width="0" height="0" frameborder="0"></iframe>
        <div id="update-tips">
            <p class="alert alert-info">加载缓存中。。。</p>
        </div>
        <div class="text-center success" style="display: none;">
            <a class="btn btn-default" href="<?php echo url('admin'); ?>">登录后台</a>
        </div>
    </div>

<script type="text/javascript">
    function updateSuccess() {
        $('#update-tips p').text('系统已安装成功，模型数据已加载成功。');
        $('#update-tips p').removeClass('alert-info').addClass('alert-success');
        $('.lead').text('安装成功');
        $('.success').show();
    }
</script>

<?php include $this->views("install/footer");?>
<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">缓存文件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/cache'); ?>">全部缓存</a>
                    <a class="list-group-item" href="<?php echo url('admin/cache/update'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">更新全站缓存</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/cache'); ?>">缓存列表</a>
                    </div>
                </div>
                <div class="panel-body">
                    <form method="post" action="<?php echo url('admin/cache/update', array('show' => 1), 1); ?>" target="cache_if"></form>
                    <iframe id="cache_if" name="cache_if" width="0" height="0" frameborder="0" style="display: none;"></iframe>
                    <iframe id="hidden" name="hidden" width="0" height="0" frameborder="0" style="display: none;"></iframe>
                    <div id="update-tips" class="alert alert-info" role="alert">
                        <p>缓存更新中。。。</p>
                    </div>
                    <div class="update-success" style="display: none;">
                        <p class="alert alert-success">全站缓存更新成功</p>
                        <a class="btn btn-default" href="<?php echo url('admin/cache'); ?>">缓存列表</a>
                        <a class="btn btn-default" href="<?php echo url('admin'); ?>">主界面</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.forms[0].submit();

    function updateTips(tips) {
        $('#update-tips').append(tips);
    }

    function updateSuccess() {
        $('.update-success').show();
    }
</script>

<?php include $this->views('admin/footer'); ?>
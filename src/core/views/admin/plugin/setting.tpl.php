<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">插件管理</span></div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/plugin'); ?>">全部插件</a>
                    <a class="list-group-item" href="<?php echo url('admin/plugin/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="" method="post" class="form-inline">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">插件配置</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/plugin/info', array('id' => $data['id'])); ?>">详情</a>
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/plugin'); ?>">列表</a>
                        </div>
                    </div>
                    <form method="post" action="" class="form-horizontal">
                        <div class="panel-body">
                            <input name="id" type="hidden" value="<?php echo $data['id']; ?>">
                            <?php include $settings_file; ?>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" name="submit" class="btn btn-default">提交</button>
                        </div>
                    </form>

                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    function select_type(id) {
        $("#text_1").hide();
        $("#text_2").hide();
        $("#text_3").hide();
        $("#text_" + id).show();
    }
    <?php if ($data['type']) { ?>
        $("#text_<?php echo $data['type']; ?>").show();
    <?php } ?>
</script>

<?php include $this->views('admin/footer'); ?>
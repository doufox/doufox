<?php include $this->views('admin/header');?>
<?php include $this->views('admin/navbar');?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/file/index'); ?>">文件列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/file/index'); ?>">文件上传</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件编辑：<?php echo $file; ?></span>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs">新建</button>
                    </div>
                </div>
                <div class="panel-body">
                    <p>
                        <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">返回</button>
                        <?php if ($is_text) { ?>
                        <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">保存</a>
                        <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑</a>
                        <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑器编辑</a>
                        <?php } if ($is_zip) { ?>
                        <a href="<?php echo url('admin/file/unzip', array('file' => $filename)); ?>" class="btn btn-default">解压</a>
                        <a href="<?php echo url('admin/file/unzip', array('file' => $filename, 'tofolder' => 1)); ?>" class="btn btn-default">解压到</a>
                        <?php } ?>
                        <a href="<?php echo url('admin/file/download', array('file' => $filename)); ?>" class="btn btn-default">下载</a>
                    </p>
                    <?php if ($is_text) {
                        echo $content;
                    } ?>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default" onclick="javascript:window.history.back();">返回</button>
                    <?php if ($is_text) { ?>
                    <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">保存</a>
                    <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑</a>
                    <a href="<?php echo url('admin/file/edit', array('file' => $filename)); ?>" class="btn btn-default">编辑器编辑</a>
                    <?php } if ($is_zip) { ?>
                    <a href="<?php echo url('admin/file/unzip', array('file' => $filename)); ?>" class="btn btn-default">解压</a>
                    <a href="<?php echo url('admin/file/unzip', array('file' => $filename, 'tofolder' => 1)); ?>" class="btn btn-default">解压到</a>
                    <?php } ?>
                    <a href="<?php echo url('admin/file/download', array('file' => $filename)); ?>" class="btn btn-default">下载</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer');?>

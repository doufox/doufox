<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/file/index'); ?>">文件列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/file/index', array('dir' => $dir)); ?>">文件上传</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">文件管理(当前目录：<?php echo $dir; ?>)</span>
                    <div class="pull-right">
                        <button class="btn btn-default btn-xs">新建</button>
                    </div>
                </div>
                <div class="panel-body">
                    <p><b>Uploading files</b></p>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="p" value="<?php echo $dir; ?>">
                        <input type="hidden" name="upl" value="1">
                        <input  class="btn btn-default btn-xs" type="file" name="upload[]"><br>
                        <input  class="btn btn-default btn-xs" type="file" name="upload[]"><br>
                        <input  class="btn btn-default btn-xs" type="file" name="upload[]"><br>
                        <input  class="btn btn-default btn-xs" type="file" name="upload[]"><br>
                        <input  class="btn btn-default btn-xs" type="file" name="upload[]"><br>
                        <br>
                        <p>
                            <button class="btn btn-default btn-xs"><i class="icon-apply"></i> 上传</button> &nbsp;
                            <a class="btn btn-default btn-xs" href="?p=<?php echo urlencode(FM_PATH) ?>"><i class="icon-cancel"></i> Cancel</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>
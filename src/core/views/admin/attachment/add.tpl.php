<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">附件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/attachment/index'); ?>">附件列表</a>
                    <a class="list-group-item active" href="<?php echo url('admin/attachment/add'); ?>">添加附件</a>
                    <a class="list-group-item" href="<?php echo url('admin/attachment/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">上传附件</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/attachment/index'); ?>">附件列表</a>
                    </div>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#single" aria-controls="single" role="tab" data-toggle="tab">单个文件</a></li>
                        <li role="presentation"><a href="#multi" aria-controls="multi" role="tab" data-toggle="tab">批量上传</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="single" class="tab-pane active">
                            <p><?php echo $note; ?></p>
                            <form method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="filename" id="filename" value="<?php echo $fielname; ?>">
                                <input type="hidden" name="size" id="size" value="<?php echo $size; ?>">
                                <input type="hidden" name="admin" id="admin" value="<?php echo $admin; ?>">
                                <div class="input-group">
                                    <input class="form-control" id="ui-display-file" type="text" placeholder="请选择文件..." readonly />
                                    <input class="form-control" id="ui-input-file" type="file" name="file" style="display: none; width:0; height:0;" />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-default" onclick="open_file_select();">选择文件</button>
                                    </div>
                                </div>
                                <hr />
                                <button type="button" class="btn btn-default" onclick="open_file_select();">选择文件</button>
                                <button type="submit" class="btn btn-default" name="submit" onclick="this.innerText='正在上传';">点击上传</button>
                            </form>
                        </div>
                        <div role="tabpanel" id="multi" class="tab-pane active">
                            批量上传
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function open_file_select() {
        document.getElementById("ui-input-file").dispatchEvent(new MouseEvent('click'));
    }
    document.getElementById("ui-input-file").onchange = function() {
        document.getElementById("ui-display-file").value = this.value;
    }
</script>
<?php include $this->admin_view('footer'); ?>
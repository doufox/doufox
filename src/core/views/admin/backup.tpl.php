<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="list-group">
                <a class="list-group-item active" href="<?php echo url('admin/backup'); ?>">备份管理</a>
                <a class="list-group-item" href="<?php echo url('admin/database'); ?>">数据库备份</a>
                <a class="list-group-item" href="<?php echo url('admin/backup/files'); ?>">系统备份</a>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">备份管理</div>
                <div class="panel-body">备份管理正在开发中</div>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>
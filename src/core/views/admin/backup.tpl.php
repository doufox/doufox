<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item active" href="<?php echo url('admin/backup'); ?>">备份管理</a>
        <a class="list-group-item" href="<?php echo url('admin/database'); ?>">数据库备份</a>
        <a class="list-group-item" href="<?php echo url('admin/backup/files'); ?>">系统备份</a>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">备份管理</div>
            <div class="panel-body">备份管理正在开发中</div>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>
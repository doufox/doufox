<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">静态化管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/createhtml/index'); ?>">页面静态化</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/home'); ?>">生成首页</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/category'); ?>">生成栏目页</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/show'); ?>">生成内容页</a>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">生成栏目静态页</div>
            <div class="panel-body">
                内容区域
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>
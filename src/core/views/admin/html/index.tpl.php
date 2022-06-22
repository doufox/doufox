<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">静态化管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/html/index'); ?>">页面静态化</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/home'); ?>">生成首页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/category'); ?>">生成栏目页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/show'); ?>">生成内容页</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">生成栏目静态页</div>
                <div class="panel-body">
                    内容区域
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>
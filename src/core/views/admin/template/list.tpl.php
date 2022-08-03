<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">模板管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/template/index'); ?>">模板管理</a>
                    <a class="list-group-item" href="<?php echo url('admin/template/add'); ?>">添加模板</a>
                    <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="<?php echo url('admin/template/updatefilename'); ?>" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">模板管理</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/template/add'); ?>">添加</a>
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/template/index'); ?>">列表</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <?php foreach ($list as $v) { ?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="thumbnail">
                                        <img src="<?php echo $v['image']; ?>" alt="模板预览图">
                                        <div class="caption">
                                            <h3><?php echo $v['template']; ?></h3>
                                            <p>
                                                <a href="<?php echo url('admin/template/item', array('template' => $v['template'])); ?>" class="btn btn-primary btn-sm" role="button">详情</a>
                                                <a href="<?php echo url('index', array('template' => $v['template'])); ?>" class="btn btn-default btn-sm" role="button">启用</a>
                                                <a href="#" class="btn btn-danger btn-sm" role="button">删除</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <hr />
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>
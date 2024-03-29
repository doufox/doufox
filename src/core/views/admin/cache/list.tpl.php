
<?php include $this->views('admin/header');?>
<?php include $this->views('admin/navbar');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">缓存文件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/cache'); ?>">全部缓存</a>
                    <a class="list-group-item" href="<?php echo url('admin/cache/update'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <!-- <form action="" method="post"></form> -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">缓存列表</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/cache/update'); ?>">刷新全站缓存</a>
                    </div>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>类型</th>
                            <th>文件</th>
                            <th>大小</th>
                            <th>生成时间</th>
                            <th>更新时间</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($list as $v) { ?>
                            <tr>
                                <td><?php echo $v['index']; ?></td>
                                <td><?php echo $v['desc']; ?></td>
                                <td><?php echo $v['name']; ?></td>
                                <td><?php echo $v['size'] ?></td>
                                <td><?php echo $v['ctime']; ?></td>
                                <td><?php echo $v['mtime']; ?></td>
                                <td>
                                    <a href="<?php echo $v['update']; ?>">刷新</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="panel-body">缓存目录：/cache/</div>
            </div>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer');?>
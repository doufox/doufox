<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">会话管理</span></div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/session'); ?>">全部会话</a>
        </div>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">会话列表</span>
                <div class="pull-right">
                    <span>会话总数：<?php echo $idx; ?></span>
                </div>
            </div>
            <div class="panel-body">存储位置：/data/session</div>
            <table class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>文件名</th>
                        <th>大小</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $v) { ?>
                        <tr>
                            <td><?php echo $v['index']; ?></td>
                            <td><?php echo $v['name']; ?></td>
                            <td><?php echo $v['size'] ?></td>
                            <td><?php echo $v['ctime']; ?></td>
                            <td><?php echo $v['mtime']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="panel-body"></div>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer'); ?>
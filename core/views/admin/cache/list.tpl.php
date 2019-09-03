
<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">缓存文件管理</span></div>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo url('admin/cache'); ?>">全部缓存</a>
            <a class="list-group-item" href="<?php echo url('admin/cache/update'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post"></form>
        <div class="panel panel-default">
            <div class="panel-heading">
                <span class="panel-title">缓存列表</span>
                <div class="pull-right">
                    <a href="<?php echo url('admin/cache/update'); ?>">刷新全站缓存</a>
                </div>
            </div>
            <div class="panel-body">缓存目录：/data/cache/</div>
            <table class="table table-bordered table-hover" width="100%">
                <thead>
                    <tr>
                        <th width="60">排序</th>
                        <th width="80">类型</th>
                        <th>文件名</th>
                        <th width="100">文件大小</th>
                        <th width="80">内容数量</th>
                        <th width="150">上次更新时间</th>
                        <th width="150">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($list as $v) { ?>
                        <tr>
                            <td>
                                <label class="label-group"><input class="selectform" type="checkbox" name="paths[]" value="<?php echo $v['path'] ?>" />选择</label>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s', $v['path']) ?></td>
                            <td><?php echo $v['sqldir'] ?></td>
                            <td><?php echo $v['size'] ?></td>
                            <td>
                                <a href="javascript:admin_command.confirmurl('<?php echo url("admin/database/import", array("path" => $v['path'])) ?>', '确定恢复数据库吗')">恢复</a>
                                <a href="javascript:showTableBackups(<?php echo $v['path'] ?>);">预览</a>
                                <a href="javascript:void(0);">下载</a>
                                <a href="javascript:admin_command.confirmurl('<?php echo url("admin/database", array("path" => $v['path'])) ?>', '确定删除吗？');">删除</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>1</td>
                        <td>系统账号</td>
                        <td>data/cache/account.cache.php</td>
                        <td>1KB</td>
                        <td>10</td>
                        <td>2019-07-07 12:34:00</td>
                        <td>预览 刷新 删除</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>区块</td>
                        <td>data/cache/block.cache.php</td>
                        <td>1KB</td>
                        <td>10</td>
                        <td>2019-07-07 12:34:00</td>
                        <td>预览 刷新 删除</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>栏目</td>
                        <td>data/cache/category.cache.php</td>
                        <td>1KB</td>
                        <td>10</td>
                        <td>2019-07-07 12:34:00</td>
                        <td>预览 刷新 删除</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>栏目</td>
                        <td>data/cache/model.cache.php</td>
                        <td>1KB</td>
                        <td>10</td>
                        <td>2019-07-07 12:34:00</td>
                        <td>预览 刷新 删除</td>
                    </tr>
                </tbody>
            </table>
            <div class="panel-body">
                <!-- <button type="submit" class="btn btn-default" value="排序" name="submit" onClick="$('#load').show()">排序</button>
                <span class="show-tips">排序方式为 “由小到大” 更改排序后请更新缓存</span> -->
                <span id="load" style="display:none"><img src="/static/img/loading.gif"></span>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
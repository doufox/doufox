
<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/cache'); ?>">全部缓存</a>
        <a class="list-group-item" href="<?php echo url('admin/cache/add'); ?>">添加栏目</a>
        <a class="list-group-item" href="<?php echo url('admin/cache/update'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">缓存文件管理</div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th align="left" width="48">排序</th>
                            <th align="left">类型</th>
                            <th align="left">文件名</th>
                            <th align="left" width="100">文件大小</th>
                            <th align="left" width="80">内容数量</th>
                            <th align="left" width="150">上次更新时间</th>
                            <th align="left" width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>
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
        </form>
    </div>
</div>

<?php include $this->admin_tpl('footer');?>
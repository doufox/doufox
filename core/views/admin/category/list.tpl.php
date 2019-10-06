<?php include $this->admin_tpl('header');?>
<?php include $this->admin_tpl('navbar');?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading"><span class="panel-title">栏目管理</span></div>
        <div class="list-group">
            <a class="list-group-item active" href="<?php echo url('admin/category'); ?>">全部栏目</a>
            <a class="list-group-item" href="<?php echo url('admin/category/add'); ?>">添加栏目</a>
            <a class="list-group-item" href="<?php echo url('admin/category/cache'); ?>">更新缓存</a>
        </div>
    </div>
    <div class="page_content">
        <form action="" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">栏目管理</span>
                    <div class="pull-right">
                        <a href="<?php echo url('admin/category/add'); ?>">添加</a>
                    </div>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th align="left" width="48">排序</th>
                            <th align="left" width="58">栏目ID</th>
                            <th align="left">栏目名称</th>
                            <th align="left" width="100">栏目目录</th>
                            <th align="left" width="80">类型</th>
                            <th align="left" width="80">内容数量</th>
                            <th align="left" width="50">显示</th>
                            <th align="left" width="150">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo $categorys; ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <button type="submit" class="btn btn-default" value="排序" name="submit" onClick="$('#load').show()">排序</button>
                    <span class="show-tips">排序方式为 “由小到大” 更改排序后请更新缓存</span>
                    <span id="load" style="display:none"><img src="/static/img/loading.gif"></span>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(".category-btn-delete").click(function (e) {
        e.preventDefault();
        var t = e.target;
        if (t && t.dataset && t.dataset.id && t.dataset.name) {
            document.getElementById("modal-confirm-url").href = "<?php echo url('admin/category/del', array('catid' => '')); ?>" + t.dataset.id;
            document.getElementById("modal-confirm-body").innerText = '确定删除『' + t.dataset.name + '』栏目吗？';
            $("#modal-confirm").modal();
        }
    })
</script>

<?php include $this->admin_tpl('footer');?>
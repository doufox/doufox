<?php include $this->admin_view('header');?>
<?php include $this->admin_view('navbar');?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">插件管理</span></div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/plugin'); ?>">全部插件</a>
                    <a class="list-group-item" href="<?php echo url('admin/plugin/add'); ?>">添加插件</a>
                    <a class="list-group-item" href="<?php echo url('admin/plugin/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">插件管理</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/plugin/reload'); ?>">重载</a>
                    </div>
                </div>
                <table class="table table-bordered table-hover" width="100%">
                    <thead>
                        <tr>
                            <th>名称</th>
                            <th>目录</th>
                            <th>版本</th>
                            <th>作者</th>
                            <th>插件主页</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                    <tbody>
                        <?php if (is_array($list)) { foreach ($list as $t) { ?>
                        <tr>
                            <td><a href="<?php echo url('admin/plugin/setting',array('id'=>$t['id'])); ?>"><?php echo $t['name']; ?></a></td>
                            <td><?php echo $t['plugin']; ?></td>
                            <td><?php echo $t['version']; ?></td>
                            <td><a href="<?php echo $t['author_url']; ?>" target="_blank" title="访问插件作者"><?php echo $t['author']; ?></a></td>
                            <td><a href="<?php echo $t['url']; ?>" target="_blank" title="访问插件主页">插件主页</a></td>
                            <td><?php echo status_label($t['status'], '开启', '关闭'); ?></td>
                            <td>
                                <a name="plugin-description" data-container="body" data-trigger="hover" data-placement="top" data-toggle="popover" data-content="<?php echo $t['description']; ?>">说明</a>
                                <a href="<?php echo url('admin/plugin/setting', array('id'=>$t['id'])); ?>">设置</a>
                            <?php if ((bool) $t['status']) { ?>
                                <a href="<?php echo url('admin/plugin/close', array('id'=>$t['id'])); ?>">关闭</a>
                            <?php } else { ?>
                                <a href="<?php echo url('admin/plugin/open', array('id'=>$t['id'])); ?>">开启</a>
                            <?php } ?>
                                <a href="#modal-confirm" data-toggle="modal" name="删除插件" onclick="plugin_delete(this);" data-id="<?php echo $t['id']; ?>" data-name="<?php echo $t['name']; ?>">删除</a>
                            </td>
                        </tr>
                        <?php } } ?>
                    </tbody>
                </table>
                <div class="panel-body">
                    <p>说明<br />重载：将插件信息存入数据库并做缓存处理<br />更新缓存：将插件配置信息缓存</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function plugin_delete(e) {
        if (e && e.dataset && e.dataset.id && e.dataset.name) {
            document.getElementById("modal-confirm-url").href = "<?php echo url('admin/plugin/del', array('id' => '')); ?>" + e.dataset.id;
            document.getElementById("modal-confirm-body").innerText = '确定删除插件"' + e.dataset.name + '"吗？';
        }
    }
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>

<?php include $this->admin_view('footer');?>

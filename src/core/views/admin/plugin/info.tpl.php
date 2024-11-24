<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="panel-title">插件管理</span></div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/plugin'); ?>">全部插件</a>
                    <a class="list-group-item" href="<?php echo url('admin/plugin/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="" method="post" class="form-inline">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">插件详情</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/plugin'); ?>">列表</a>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-condensed">
                        <tr>
                            <th width="90">名称</th>
                            <td><?php echo $data['name']; ?></td>
                        </tr>
                        <tr>
                            <th>目录</th>
                            <td><?php echo $data['plugin']; ?></td>
                        </tr>
                        <tr>
                            <th>版本</th>
                            <td><?php echo $data['version']; ?></td>
                        </tr>
                        <tr>
                            <th>状态</th>
                            <td><?php echo status_label($data['status'], '开启', '关闭'); ?></td>
                        </tr>
                        <tr>
                            <th>网站</th>
                            <td><a href="<?php echo $data['url']; ?>"><?php echo $data['url']; ?></a></td>
                        </tr>
                        <tr>
                            <th>制作者</th>
                            <td><?php echo $data['author']; ?></td>
                        </tr>
                        <tr>
                            <th>制作者网站</th>
                            <td><a href="<?php echo $data['author_url']; ?>"><?php echo $data['author_url']; ?></a></td>
                        </tr>
                        <tr>
                            <th>描述</th>
                            <td><?php echo $data['description']; ?></td>
                        </tr>
                        <tr>
                            <th>官方版</th>
                            <td><?php echo status_label($data['official'], '官方版', '非官方版'); ?></td>
                        </tr>
                    </table>
                    <div class="panel-footer">
                        <?php if ((bool) $data['has_config']) { ?>
                            <a class="btn btn-default" href="<?php echo url('admin/plugin/setting', array('id'=>$data['id'])); ?>">设置</a>
                        <?php } ?>
                        <?php if ((bool) $data['status']) { ?>
                            <a class="btn btn-default" href="<?php echo url('admin/plugin/close', array('id'=>$data['id'])); ?>">关闭</a>
                        <?php } else { ?>
                            <a class="btn btn-default" href="<?php echo url('admin/plugin/open', array('id'=>$data['id'])); ?>">开启</a>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>
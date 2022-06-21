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
                    <a class="list-group-item" href="<?php echo url('admin/template/add', array('theme' => urldecode($theme), 'dir' => urldecode($dir))); ?>">添加模板</a>
                    <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <form action="<?php echo url('admin/template/updatefilename'); ?>" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title">模板详情</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/template/index'); ?>">列表</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form form-inline">
                            <select class="form-control" onchange="window.location.href = this.options[this.selectedIndex].value;">
                                <option disabled>==切换主题==</option>
                                <?php foreach ($theme_list as $v) { ?>
                                    <option <?php echo $v == $theme ? 'selected' : ''; ?> value="<?php echo url('admin/template/item', array('theme' => $v)); ?>"><?php echo ucfirst($v); ?></option>
                                <?php } ?>
                            </select>
                            <?php if ($dir != '/') { ?>
                                <a class="btn btn-default" href="<?php echo $top_url; ?>">返回上一级</a>
                            <?php } ?>
                            <span class="input-group">
                                <span class="input-group-addon">当前位置</span>
                                <input type="text" class="form-control" size="20" readonly value="<?php echo $cur_path; ?>" placeholder="当前位置" />
                            </span>
                        </div>
                    </div>
                    <table class="table table-bordered table-condensed table-hover" width="100%">
                        <thead>
                            <tr>
                                <th>文件</th>
                                <th width="200">备注</th>
                                <th width="100">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (is_array($list)) {
                                foreach ($list as $v) :
                                    $filename = basename($v);
                                    if (is_dir($v)) {
                                        echo '<tr>';
                                        echo '<td><img src="/static/img/folder-closed.gif" /> <a href="' . url('admin/template/item', array('theme' => urldecode($theme), 'dir' => urldecode($dir . $filename . DS))) . '">' . $filename . '</a></td>';
                                        echo '<td><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td>';
                                        echo '<td><a class="btn btn-default btn-sm" href="' . url('admin/template/item', array('theme' => urldecode($theme), 'dir' => urldecode($dir . $filename . DS))) . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a></td>';
                                        echo '</tr>';
                                    }
                                endforeach;
                                foreach ($list as $v) :
                                    $filename = basename($v);
                                    if (!is_dir($v)) {
                                        echo '<tr>';
                                        echo '<td><img src="/static/img/file.gif" /> ' . $filename . '</td>';
                                        echo '<td><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td>';
                                        $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
                                        if (in_array($ext, array('html', 'css', 'js', 'txt'))) {
                                            echo '<td> <a class="btn btn-default btn-sm" href="' . url('admin/template/edit', array('theme' => urldecode($theme), 'dir' => urldecode($dir), 'file' => urldecode($filename))) . '"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></td>';
                                        } else {
                                            echo '<td></td>';
                                        }
                                        echo '</tr>';
                                    }
                                endforeach;
                            } ?>
                        </tbody>
                    </table>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default btn-sm" name="dosubmit" value="更新备注">更新备注</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include $this->views('admin/footer'); ?>
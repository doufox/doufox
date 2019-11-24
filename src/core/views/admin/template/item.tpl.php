<?php include $this->admin_view('header'); ?>

<?php include $this->admin_view('navbar'); ?>

<div class="container">
    <div class="page_menu">
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
    <div class="page_content">
        <form action="<?php echo url('admin/template/updatefilename'); ?>" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">模板详情</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/template/index'); ?>">列表</a>
                    </div>
                </div>
                <div class="panel-body">
                    <p>
                        <select class="form-control" style="width: 100px;">
                            <?php foreach ($theme_list as $v) { ?>
                                <option <?php echo $v == $item ? 'selected' : ''; ?>><?php echo $v; ?></option>
                            <?php } ?>
                        </select>
                        <?php if ($dir != '') { ?>
                            <a class="btn btn-default" href="<?php echo $top_url; ?>">返回上一级</a>
                        <?php } ?>
                        <a class="btn btn-default" href="#">当前位置：<?php echo $local ?></a>
                    </p>
                </div>
                <table class="table table-bordered table-condensed table-hover" width="100%">
                    <thead>
                        <tr>
                            <th align="left">文件</th>
                            <th align="left">备注</th>
                            <th align="left">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (is_array($list)) {
                            foreach ($list as $v) :
                                $filename = basename($v);
                                if (is_dir($v))
                                    echo '<tr><td align="left"><img src="/static/img/folder-closed.gif" /> <a href="' . url('admin/template/edit', array('dir' => urldecode($dir . $filename . DS))) . '">' . $filename . '</a></td><td align="left"><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td><td></td> </tr>';
                            endforeach;
                            foreach ($list as $v) :
                                $filename = basename($v);
                                if (!is_dir($v)) {
                                    echo '<tr><td align="left"><img src="/static/img/file.gif" /> ' . $filename . '</td><td align="left"><input type="text" class="form-control input-sm" name="file_explan[' . $encode_local . '][' . $filename . ']" value="' . (isset($file_explan[$encode_local][$filename]) ? $file_explan[$encode_local][$filename] : "") . '"></td>';
                                    $ext = strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
                                    if (in_array($ext, array('html', 'css', 'js'))) {
                                        echo '<td> <a href="' . url('admin/template/edit', array('dir' => urldecode($dir), 'file' => urldecode($filename))) . '">编辑</a> </td></tr>';
                                    } else {
                                        echo '<td></td></tr>';
                                    }
                                }
                            endforeach;
                        } ?>
                    </tbody>
                </table>
                <hr />
                <button type="submit" class="btn btn-default" name="dosubmit" value="更新备注">更新备注</button>
            </div>
        </form>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>
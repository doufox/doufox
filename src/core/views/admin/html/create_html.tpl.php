<?php include $this->admin_view('header'); ?>
<?php include $this->admin_view('navbar'); ?>
<?php include $this->admin_view('common/msg');?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">静态化管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/html/index'); ?>">页面静态化</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/home'); ?>">生成首页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/category'); ?>">生成栏目页</a>
                    <a class="list-group-item" href="<?php echo url('admin/html/show'); ?>">生成内容页</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">生成栏目静态页</div>
                <div class="panel-body">
                    <?php if (!function_exists('ob_start')) { ?>
                        <font color="red">无法生成静态文件，请开启OB函数！</font>
                    <?php } ?>
                    <form action="" method="post" target="result" class="form-inline">
                        <table width="100%" class="table_form">
                            <?php if ($isshow) { ?>
                                <tr>
                                    <th width="160">按照时间生成内容页：</th>
                                    <td>
                                        <input type="text" class="form-control" name="time" value="24" size="5" />小时
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th width="160"><?php echo $show; ?>：</th>
                                <td>
                                    <select class="form-control" name="catid">
                                        <option value="0">=== 全部栏目 ===</option>
                                        <?php echo $category_select; ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <hr />
                    <button class="btn btn-default" type="submit" name="submit" value="开始生成">开始生成</button>
                    <div class="show-tips">请确保生成html目录拥有写入权限</div>
                    <iframe name="result" frameborder="0" id="result" width="100%" height="400"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $this->admin_view('footer'); ?>
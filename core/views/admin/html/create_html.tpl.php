<?php include $this->admin_tpl('header'); ?>
<?php include $this->admin_tpl('navbar'); ?>

<div class="container">
    <div class="panel panel-default page_menu">
        <div class="panel-heading">
            <span class="panel-title">静态化管理</span>
        </div>
        <div class="list-group">
            <a class="list-group-item" href="<?php echo url('admin/createhtml/index'); ?>">页面静态化</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/home'); ?>">生成首页</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/category'); ?>">生成栏目页</a>
            <a class="list-group-item" href="<?php echo url('admin/createhtml/show'); ?>">生成内容页</a>
        </div>
    </div>
    <div class="page_content">
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

<?php include $this->admin_tpl('footer'); ?>
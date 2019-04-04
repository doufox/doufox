<?php include $this->admin_tpl('header');?>

<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/createhtml/index'); ?>">页面静态化</a>
        <a href="<?php echo url('admin/createhtml/home'); ?>">生成首页</a>
        <a href="<?php echo url('admin/createhtml/category'); ?>">生成栏目页</a>
        <a href="<?php echo url('admin/createhtml/show'); ?>">生成内容页</a>
    </div>
    <div class="table-form">
        <div class="pad-10">
            <?php if (!function_exists('ob_start')) {?>
            <font color="red">无法生成静态文件，请开启OB函数！</font>
            <?php }?>
            <form action="" method="post" target='result' style="margin-bottom:20px;">
                <table width="100%" class="table_form">
                    <?php if ($isshow) {?>
                    <tr>
                        <th width="160">按照时间生成内容页：</th>
                        <td>
                            <input type="text" class="input-text" name="time" value="24" size="5"/>小时
                            <input type="submit" class="button" name="submit" value="开始生成"/>
                        </td>
                    </tr>
                    <?php }?>
                    <tr>
                        <th width="160"><?php echo $show; ?>：</th>
                        <td>
                            <select class="select" name="catid">
                                <option value="0">=== 全部栏目 ===</option>
                                <?php echo $category_select; ?>
                            </select>
                            <input class="button" type="submit" name="submit" value="开始生成"/>
                            <div class="show-tips">请确保生成html目录拥有写入权限</div>
                        </td>
                    </tr>
                </table>
            </form>
            <iframe name="result" frameborder="0" id="result" width="100%" height="400"></iframe>
        </div>
    </div>
</div>
</body>
</html>
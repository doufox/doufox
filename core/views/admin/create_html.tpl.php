<?php include $this->admin_tpl('header');?>


<div class="subnav">
	<div class="table-form">
		<div class="pad-10">
            <?php if (!function_exists('ob_start')) { ?>
            <font color="red">无法生成静态文件，请开启OB函数！</font>
            <?php } ?>
            <table width="100%" class="table_form">
            <tr >
            <?php if ($isshow) {?>
                <form action="" method="post" target='result' style="margin-bottom:20px;">
                <th width="180">按照时间生成内容页：</th>
                <td width="200">
                <input type="text" class="input-text" size="5" value="24" name="time">/小时
                <input class="button" type="submit" name="submit" value="开始生成" />&nbsp;&nbsp;</td>
            </form>
            <?php } ?>

            <form action="" method="post" target='result' style="margin-bottom:20px;">
                <th width="160"><?php echo $show; ?>： </th>
                <td>
                <select class="select" name="catid">
                <option value="0">全部</option>
                <?php echo $category_select; ?>
                </select><input class="button" type="submit" name="submit" value="开始生成" /><div class="onShow">请确保生成html目录拥有写入权限</div>&nbsp;&nbsp;
                </td>
            </form>
            </tr>

            </table>
            <iframe name="result" frameborder="0" id="result" width="100%" height="400"></iframe>
        </div>
	</div>
</div>
</body>
</html>
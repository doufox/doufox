<?php include $this->_include('header.html'); echo PHP_EOL;  if (!$select) { ?>
    <script type="text/javascript">
        function reload_code() {
            document.getElementById('code').src = '<?php echo url("api/access/checkcode", array("width"=>80, "height"=>28)); ?>&' + Math.random();
        }
    </script>
    <script type="text/javascript" src="/static/js/jquery.min.js"></script>
    <script type="text/javascript" src="/static/js/dialog.js?skin=green"></script>
    <script type="text/javascript" src="/static/js/admin.js"></script>
<?php } ?>

<div class="main">
    <div class="post bg">
        <?php include $this->_include('crumbs.html'); echo PHP_EOL; ?>
        <form action="" method="post">
<?php if ($select) { ?>
            <input name="select" type="hidden" value="1" />
            <div style="text-align:center;padding:20px;">
                <select name="catid">
                    <option> -选择投稿栏目- </option>
                    <?php echo $post_category; ?>
                </select>
                &nbsp;
                <input type="submit" class="button" value="我要投稿" name="submit">
            </div>
<?php } else { ?>
            <div>
                <div>投稿栏目：<?php echo $cats[$catid]['catname']; ?></div>
                <div><a href="<?php echo url('index/post'); ?>">返回重选</a></div>
            </div>
    <?php if ($model['content']['title']['show']) { ?>
            <div>
                <div><font color="red">*</font>&nbsp;<?php echo $model['content']['title']['name']; ?>：</div>
                <div><input type="text" class="input-text" size="50" id="title" value="<?php echo $data['title']; ?>" name="data[title]" onBlur="admin_command.get_kw()"></div>
                <div class="show-tips" id="title_text"></div>
            </div>
    <?php }  if ($model['content']['description']['show']) { ?>
            <div>
                <div><?php echo $model['content']['description']['name']; ?>：</div>
                <div><textarea style="width:490px;height:66px;" id="description" name="data[description]"><?php echo $data['description']; ?></textarea></div>
            </div>
    <?php }  echo $data_fields; ?>
            <div>
                <div>验证码：</div>
                <div>
                    <input name="code" type="text" class="input-text" size=10 />
                    <img id="code" title="看不清楚？换一张" style="cursor:pointer;" align="absmiddle" onclick="reload_code();" src="<?php echo url('api/access/checkcode', array('width'=>80, 'height'=>28)); ?>"/>
                </div>
            </div>
            <div>
                <input type="submit" class="button" value="提 交" name="submit">
            </div>

<?php } ?>
        </form>
    </div>
</div>

<?php include $this->_include('footer.html'); echo PHP_EOL; ?>
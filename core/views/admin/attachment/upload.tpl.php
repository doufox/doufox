<?php include $this->admin_tpl('header'); ?>

<form method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="filename" id="filename" value="<?php echo $fielname; ?>">
    <input type="hidden" name="size" id="size" value="<?php echo $size; ?>">
    <input type="hidden" name="admin" id="admin" value="<?php echo $admin; ?>">
    <div class="input-group">
        <input class="form-control" id="ui-display-file" type="text" placeholder="请选择文件..." readonly />
        <input class="form-control" id="ui-input-file" type="file" name="file" style="display: none; width:0; height:0;" />
        <div class="input-group-btn">
            <button type="button" class="btn btn-default" onclick="open_file_select();">选择文件</button>
            <button type="submit" class="btn btn-default" name="submit" onclick="this.innerText='正在上传';">点击上传</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    function open_file_select() {
        document.getElementById("ui-input-file").dispatchEvent(new MouseEvent('click'));
    }
    document.getElementById("ui-input-file").onchange = function() {
        document.getElementById("ui-display-file").value = this.value;
    }
</script>

</body>
</html>
<?php include $this->admin_tpl('header');?>

<script type="text/javascript">
    top.document.getElementById('position').innerHTML = '备份管理';
</script>
<div class="subnav">
    <div class="content-menu">
        <a href="<?php echo url('admin/backup'); ?>" class="on">备份管理</a>
        <a href="<?php echo url('admin/database'); ?>" class="add">数据库备份</a>
    </div>
    <div class="table-list">
    </div>
</div>

</body>
</html>
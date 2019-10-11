<?php include $this->install_tpl("header"); ?>

<div class="panel-body text-center">
    <p class="lead">温馨提示</p>
    <hr />
    <h2>系统已经安装</h2>
    <p>如需重新安装, 请删除 installed 文件</p>
    <hr />
    <p>
        <a class="btn btn-default" href="<?php echo HTTP_URL; ?>">浏览网站</a>
    </p>
</div>

<?php include $this->install_tpl("footer"); ?>
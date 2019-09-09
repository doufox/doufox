<footer class="footer navbar navbar-default navbar-fixed-bottom">
    <div class="container">
        <div class="navbar-inner navbar-content-center" style="padding-top:15px;">
            <ul class="navbar-left list-inline text-center text-muted credit">
                <li>
                    <span class="co">&copy; CopyRight <?php echo date('Y'); ?> <?php echo ucfirst(APP_NAME); ?> All Rights Reserved.</span>
                </li>
            </ul>
            <div class="legal text-right list-inline">
                <span class="co">Powered by <a href="https://crogram.com" target="_blank">Crogram</a></span>
            </div>
        </div>
    </div>
</footer>

<!-- 退出提示 -->
<div class="modal fade" id="modal-logout" tabindex="-1" role="dialog" aria-labelledby="aria-modal-logout">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="aria-modal-logout">系统提示</h4>
            </div>
            <div class="modal-body">
                <p>确定退出登录吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a type="button" class="btn btn-primary" href="<?php echo url("admin/login/logout"); ?>">确定</a>
            </div>
        </div>
    </div>
</div>

</body>

</html>
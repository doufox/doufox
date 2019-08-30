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

<script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
    // window.onresize = function() {
    //     var heights = document.documentElement.clientHeight;
    //     document.getElementById('rightMain').height = heights - 90;
    //     document.getElementById('leftMain').height = heights - 90;
    // }
    // window.onresize();

    // function _open_url(id, url) {
    //     var title = $("#M_" + id).find('a').html();
    //     document.getElementById('position').innerHTML = title;
    //     document.getElementById('rightMain').src = url;
    //     $('.focused').removeClass("focused");
    //     $('#M_' + id).addClass("focused");
    // }

    function logout() {
        if (confirm('确定退出吗'))
            top.location = '<?php echo url("admin/login/logout"); ?>';
        return false;
    }

    function refresh() {
        document.getElementById('leftMain').src = "<?php echo url('admin/content/category'); ?>";
    }
</script>
<script type="text/javascript" src="/static/js/admin.js"></script>

</body>

</html>
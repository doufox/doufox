<div class="footer-sticky"></div>
<div class="footer">
    <div class="container-fluid">
        <footer class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-text">Powered by <a href="<?php echo APP_SITE;?>" target="_blank"><?php echo ucfirst(APP_NAME); ?></a></div>
                <div class="navbar-text pull-right hidden-xs">
                    <span>Copyright &copy; </span>
                    <span class="hidden-xs"><?php echo date("Y"); ?></span>
                    <span><a href="https://crogram.com/" target="_blank">Crogram</a> All Rights Reserved.</span>
                </div>
            </container-fluid>
        </footer>
    </div>
</div>

<!-- 确认提示 -->
<div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="modal-confirm" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-confirm-title">系统提示</h4>
            </div>
            <div class="modal-body" id="modal-confirm-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a href="#" type="button" id="modal-confirm-url" class="btn btn-primary">确定</a>
            </div>
        </div>
    </div>
</div>

<!-- 提示 -->
<div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="modal-alert" style="display: none;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-alert-title">系统提示</h4>
            </div>
            <div class="modal-body" id="modal-alert-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">确定</button>
            </div>
        </div>
    </div>
</div>

<!-- 上传文件 -->
<div class="modal fade" id="modal-file-upload-view" tabindex="-1" role="dialog" aria-labelledby="aria-modal-file-upload">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="关闭"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-file-upload-title">上传文件</h4>
            </div>
            <div class="modal-body">
                <iframe id="modal-file-upload-body" width="100%" frameborder="0" onload="setIframeHeight(this);"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="modal-file-upload-cancel" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" id="modal-file-upload-ok">确定</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.admin_command = {
        sitepath: window.location.origin + window.location.pathname,
        redirect: function (url) {
            location.href = url
        },
        confirmurl: function (url, message) {
            if (confirm(message)) this.redirect(url);
        },
        preview_img: function (id, ) {
            if (!id) {
                return;
            }
            var filepath = document.getElementById(id).value;
            if (filepath) {
                document.getElementById('imgPreview' + id).style.position = 'relative';
                document.getElementById('imgPreview' + id).innerHTML = '<div id="imgPreviewContainer" style="position: absolute; top: 34px; left: 0; display: block;"><img src="' + filepath + '" style="width: 280px; display: inline;"></div>';
                // remove dom onmouseout
                document.getElementById(id).onmouseout = function () {
                    document.getElementById('imgPreview' + id).innerHTML = '';
                    document.getElementById('imgPreview' + id).style.position = '';
                    document.getElementById(id).onmouseout = null;
                }
            }
        }
    }

    /**
     * 高度自适应
     * @param {Object} iframe iframe 对象
     */
    function setIframeHeight(iframe) {
        if (iframe) {
            var iframeWin = iframe.contentWindow || iframe.contentDocument.parentWindow;
            if (iframeWin.document.body) {
                iframe.height = iframeWin.document.documentElement.scrollHeight || iframeWin.document.body.scrollHeight;
            }
        }
    };
    $("#modal-alert").on("hide.bs.modal", function() {
        document.getElementById("modal-alert-title").innerText = "系统提示";
        document.getElementById("modal-alert-body").innerText = "";
    })
    $("#modal-confirm").on("hide.bs.modal", function() {
        document.getElementById("modal-confirm-url").href = "";
        document.getElementById("modal-confirm-title").innerText = "系统提示";
        document.getElementById("modal-confirm-body").innerText = "";
    })
    $("#btn-logout").click(function () {
        document.getElementById("modal-confirm-url").href = "<?php echo url('admin/login/logout'); ?>";
        document.getElementById("modal-confirm-body").innerText = "确定退出登录吗？";
    })
    $("#modal-file-upload-view").on("hide.bs.modal", function() {
        document.getElementById("modal-file-upload-title").innerText = "";
        document.getElementById("modal-file-upload-body").src = "";
        document.getElementById("modal-file-upload-body").height = "";
        document.getElementById("modal-file-upload-body").dataset.target = "";
        $("#modal-file-upload-cancel").unbind();
        $("#modal-file-upload-ok").unbind();
    });
    function showImageUpload(target, type, width, height, size) {
        $("#modal-file-upload-view").modal();
        if (type && type == "gallery") {
            document.getElementById("modal-file-upload-title").innerText = "选择图片(未实现)";
            document.getElementById("modal-file-upload-body").src = "<?php echo url('admin/attachment/uploadimage', array('w' => '', 'h' => '', 'size' => '')); ?>";
            return;
        }
        $("#modal-file-upload-ok").unbind();
        $("#modal-file-upload-ok").click(function () {
            var filename = document.getElementById("modal-file-upload-body").contentWindow.document.getElementById("filename").value;
            if (filename) {
                $("#" + target).val(filename);
            } else {
                $("#modal-alert").modal();
                document.getElementById("modal-alert-body").innerText = "您还没有上传";
            }
            $("#modal-file-upload-view").modal("hide");
        })
        document.getElementById("modal-file-upload-title").innerText = "上传图片";
        document.getElementById("modal-file-upload-body").src = "<?php echo url('admin/attachment/uploadimage', array('w' => '', 'h' => '', 'size' => '')); ?>";
    }
    var admin = {
        showFileUpload: function (target, method, type, size) {
            $("#modal-file-upload-view").modal();
            $("#modal-file-upload-ok").unbind();
            $("#modal-file-upload-ok").click(function () {
                var filename = document.getElementById("modal-file-upload-body").contentWindow.document.getElementById("filename").value;
                if (filename) {
                    $("#" + target).val(filename);
                    $("#modal-file-upload-view").modal("hide");
                } else {
                    $("#modal-alert").modal();
                    document.getElementById("modal-alert-body").innerText = "您还没有上传";
                }
                $("#modal-file-upload-view").modal("hide");
            });
            if (method && method == "select") {
                document.getElementById("modal-file-upload-title").innerText = "选择文件(未实现)";
                document.getElementById("modal-file-upload-body").src = "<?php echo url('admin/attachment/file', array('type' => '" + type + "', 'size' => '" + size + "')); ?>";
                return;
            }
            document.getElementById("modal-file-upload-title").innerText = "上传文件";
            document.getElementById("modal-file-upload-body").src = "<?php echo url('admin/attachment/file', array('type' => '" + type + "', 'size' => '" + size + "')); ?>";
        },
        showFilesUpload: function (target, setting) {
            document.getElementById("modal-file-upload-title").innerText = "批量上传";
            document.getElementById("modal-file-upload-body").src = "<?php echo url('admin/attachment/files', array('setting' => '" + setting + "')); ?>";
            $("#modal-file-upload-view").modal();
            $("#modal-file-upload-ok").unbind();
            $("#modal-file-upload-ok").click(function () {
                var names = document.getElementById("modal-file-upload-body").contentWindow.document.getElementById("att-name").innerHTML;
                var files = document.getElementById("modal-file-upload-body").contentWindow.document.getElementById("att-status").innerHTML;
                names = names.split('|');
                files = files.split('|');
                if (files) {
                    for (var id in files) {
                        var filepath = files[id];
                        var filename = names[id] || "";
                        if (filepath) {
                            admin.addNullFileLine(target, id, filename, filepath);
                        }
                    }
                    $("#" + target).val(filename);
                    $("#modal-file-upload-view").modal("hide");
                } else {
                    $("#modal-alert").modal();
                    document.getElementById("modal-alert-body").innerText = "您还没有上传";
                }
                $("#modal-file-upload-view").modal("hide");
            });
        },
        addNullFileLine: function (obj, id, filename, filepath) {
            id = id || parseInt(Math.random() * 1000);
            filename = filename || "";
            filepath = filepath || "";
            var c = '<p id="files_' + id + '">';
            c += '<input type="text" class="form-control" style="width:100px;" value="' + filename + '" name="data[' + obj + '][alt][]" placeholder="图片说明">';
            c += '<input type="text" class="form-control" style="width:300px;" value="' + filepath + '" name="data[' + obj + '][file][]" placeholder="图片地址">';
            c += '<button type="button" class="btn btn-default" onclick="admin.removeDIV(\'' + id + '\');">删除</button></p>';
            $('#' + obj + '-sort-items').append(c);
        },
        removeDIV: function (fileid) {
            $('#files_' + fileid).remove();
        }
    };
</script>
<?php doHookAction('admin_footer'); echo PHP_EOL; ?>
</body>
</html>
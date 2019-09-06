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
    },
    uploadImage: function (obj, w, h, size) {
        var url = this.sitepath + '?c=attachment&a=image&w=' + w + '&h=' + h + '&size=' + size;
        var winid = 'win_' + obj;
        window.art.dialog({
            id: winid,
            iframe: url,
            title: '上传',
            opacity: 0.2,
            width: '450',
            height: '100',
            lock: true
        },
            function () {
                var d = window.art.dialog({
                    id: winid
                }).data.iframe;
                var filename = d.document.getElementById('filename').value;
                if (filename) {
                    $("#" + obj).val(filename);
                } else {
                    alert('您还没有上传');
                    return false;
                }
            },
            function () {
                window.art.dialog({
                    id: winid
                }).close();
            }
        );
        void (0);
    },
    uploadFile: function (obj, type, size) {
        var url = this.sitepath + '?c=attachment&a=file&type=' + type + '&size=' + size;
        var winid = 'win_' + obj;
        window.top.art.dialog({
            id: winid,
            iframe: url,
            title: '上传',
            opacity: 0.2,
            width: '470',
            height: '150',
            lock: true
        },
            function () {
                var d = window.top.art.dialog({
                    id: winid
                }).data.iframe;
                var filename = d.document.getElementById('filename').value;
                if (filename) {
                    $("#" + obj).val(filename);
                } else {
                    alert('您还没有上传');
                    return false;
                }
            },
            function () {
                window.top.art.dialog({
                    id: winid
                }).close();
            }
        );
        void (0);
    },
    uploadFiles: function (obj, setting) {
        var url = this.sitepath + '?c=attachment&a=files&setting=' + setting;
        var winid = 'win_' + obj;
        window.top.art.dialog({
            id: winid,
            iframe: url,
            title: '上传',
            opacity: 0.2,
            width: '500',
            height: '420',
            lock: true
        },
            function () {
                var d = window.top.art.dialog({
                    id: winid
                }).data.iframe;
                var files = d.document.getElementById('att-status').innerHTML;
                var names = d.document.getElementById('att-name').innerHTML;
                var file = files.split('|');
                var name = names.split('|');
                for (var id in file) {
                    var filepath = file[id];
                    var filename = name[id];
                    if (filepath) {
                        var c = '<li id="files_' + id + '">';
                        c += '<input type="text" class="input-text" style="width:310px;" value="' + filepath + '" name="data[' + obj + '][file][]">';
                        c += '<input type="text" class="input-text" style="width:160px;" value="' + filename + '" name="data[' + obj + '][alt][]">';
                        c += '<a href="javascript:admin_command.removediv(\'' + id + '\');">删除</a></li>';
                        $('#' + obj + '-sort-items').append(c);
                    }
                }

            },
            function () {
                window.top.art.dialog({
                    id: winid
                }).close();
            }
        );
        void (0);
    },
    get_kw: function () {
        $.post(this.sitepath + '?s=api&a=ajaxkw&id=' + Math.random(), {
            data: $('#title').val()
        }, function (res) {
            if (res && res.data && $('#keywords').val() == '') {
                $('#keywords').val(res.data);
            }
        });
    },
    removediv: function (fileid) {
        $('#files_' + fileid).remove();
    },
    add_null_file: function (obj) {
        var id = parseInt(Math.random() * 1000);
        var c = '<li id="files_' + id + '">';
        c += '<input type="text" class="input-text" style="width:310px;" value="" name="data[' + obj + '][file][]">';
        c += '<input type="text" class="input-text" style="width:160px;" value="" name="data[' + obj + '][alt][]">';
        c += '<a href="javascript:admin_command.removediv(\'' + id + '\');">删除</a></li>';
        $('#' + obj + '-sort-items').append(c);
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
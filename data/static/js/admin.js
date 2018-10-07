function confirmurl(url, message) {
    if (confirm(message)) redirect(url);
}

function redirect(url) {
    location.href = url;
}

function preview(obj) {
    $("#imgPreview" + obj).html('');
}

function preview2(obj) {
    var filepath = $('#' + obj).val();
    if (filepath) {
        $("#imgPreview" + obj).html('<div id="imgPreviewContainer" style="position: absolute; top: 0px; left: 10px; display: block;"><img src="' + filepath + '" style="width: 280px; display: inline;"></div>');
    }
}

function uploadImage(obj, w, h, size) {
    var url = sitepath + '?c=attachment&a=image&w=' + w + '&h=' + h + '&size=' + size;
    var winid = 'win_' + obj;
    window.top.art.dialog({ id: winid, iframe: url, title: '上传', opacity: 0.2, width: '450', height: '100', lock: true },
        function() {
            var d = window.top.art.dialog({ id: winid }).data.iframe;
            var filename = d.document.getElementById('filename').value;
            if (filename) {
                $("#" + obj).val(filename);
            } else {
                alert('您还没有上传');
                return false;
            }
        },
        function() {
            window.top.art.dialog({ id: winid }).close();
        }
    );
    void(0);
}

function uploadFile(obj, type, size) {
    var url = sitepath + '?c=attachment&a=file&type=' + type + '&size=' + size;
    var winid = 'win_' + obj;
    window.top.art.dialog({ id: winid, iframe: url, title: '上传', opacity: 0.2, width: '470', height: '150', lock: true },
        function() {
            var d = window.top.art.dialog({ id: winid }).data.iframe;
            var filename = d.document.getElementById('filename').value;
            if (filename) {
                $("#" + obj).val(filename);
            } else {
                alert('您还没有上传');
                return false;
            }
        },
        function() {
            window.top.art.dialog({ id: winid }).close();
        }
    );
    void(0);
}

function uploadFiles(obj, setting) {
    var url = sitepath + '?c=attachment&a=files&setting=' + setting;
    var winid = 'win_' + obj;
    window.top.art.dialog({ id: winid, iframe: url, title: '上传', opacity: 0.2, width: '500', height: '420', lock: true },
        function() {
            var d = window.top.art.dialog({ id: winid }).data.iframe;
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
                    c += '<a href="javascript:removediv(\'' + id + '\');">删除</a></li>';
                    $('#' + obj + '-sort-items').append(c);
                }
            }

        },
        function() {
            window.top.art.dialog({ id: winid }).close();
        }
    );
    void(0);
}

function get_kw() {
    $.post(sitepath + '?c=api&a=ajaxkw&id=' + Math.random(), { data: $('#title').val() }, function(data) {
        if (data && $('#keywords').val() == '') $('#keywords').val(data);
    });
}

function removediv(fileid) {
    $('#files_' + fileid).remove();
}

function add_null_file(obj) {
    var id = parseInt(Math.random() * 1000);
    var c = '<li id="files_' + id + '">';
    c += '<input type="text" class="input-text" style="width:310px;" value="" name="data[' + obj + '][file][]">';
    c += '<input type="text" class="input-text" style="width:160px;" value="" name="data[' + obj + '][alt][]">';
    c += '<a href="javascript:removediv(\'' + id + '\');">删除</a></li>';
    $('#' + obj + '-sort-items').append(c);
}
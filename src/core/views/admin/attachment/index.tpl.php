<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">附件管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item active" href="<?php echo url('admin/attachment/index'); ?>">附件列表</a>
                    <a class="list-group-item" href="<?php echo url('admin/attachment/add'); ?>">添加附件</a>
                    <a class="list-group-item" href="<?php echo url('admin/attachment/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">附件列表</span>
                    <div class="pull-right">
                        <a class="btn btn-default btn-xs" href="<?php echo url('admin/attachment/add'); ?>">添加附件</a>
                    </div>
                </div>
                <div class="panel-body">
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/attachment/index'); ?>">全部</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/attachment/index', array('status'=>3)); ?>">已删除(<?php echo $count[3]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/attachment/index', array('status'=>0)); ?>">孤立文件(<?php echo $count[0]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/attachment/build'); ?>">扫描文件(<?php echo $count[0]; ?>)</a>
                    <a class="btn btn-default btn-sm" href="<?php echo url('admin/attachment/add'); ?>">本地上传</a>
                </div>
                <table class="table table-bordered table-condensed table-hover" id="imgPreview">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>文件类型</th>
                            <th>文件名</th>
                            <th>上传时间</th>
                            <th>文件大小</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (is_array($list)) { foreach ($list as $k => $t) { ?>
                        <tr>
                            <td><?php echo $t['id']; ?></td>
                            <td><?php echo $t['mimetype']; ?></td>
                            <td>
                                <a href="<?php echo $t['filepath']; ?>" target="_blank" title="新窗口打开" rel="<?php echo $t['filepath']; ?>"><?php echo $t['filename']; ?></a>
                            </td>
                            <td><?php echo date('Y-m-d H:i:s', $t['create_time']); ?></td>
                            <td><?php echo formatFileSize($t['filesize']); ?></td>
                            <td>
                                <a href="<?php echo url("admin/attachment/view", array("id" => $t['id'])); ?>">详情</a>
                                <a href="<?php echo url('admin/attachment/edit', array('id' => $t['id'])); ?>">编辑</a>
                                <a href="#modal-attachment-delete" data-toggle="modal" name="删除账号" onclick="account_delete(this);" data-id="<?php echo $t['userid']; ?>" data-name="<?php echo $t['username']; ?>">删除</a>
                            </td>
                        </tr>
                    <?php } } ?>
                    </tbody>
                </table>
                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    (function(c) {
        c.expr[':'].linkingToImage = function(a, g, e) {
            return !!(c(a).attr(e[3]) && c(a).attr(e[3]).match(/\.(gif|jpe?g|png|bmp)$/i))
        };
        c.fn.imgPreview = function(j) {
            var b = c.extend({
                    imgCSS: {},
                    distanceFromCursor: {
                        top: 10,
                        left: 10
                    },
                    preloadImages: true,
                    onShow: function() {},
                    onHide: function() {},
                    onLoad: function() {},
                    containerID: 'imgPreviewContainer',
                    containerLoadingClass: 'loading',
                    thumbPrefix: '',
                    srcAttr: 'href'
                }, j),
                d = c('<div/>').attr('id', b.containerID).append('<img/>').hide().css('position', 'absolute').appendTo('body'),
                f = c('img', d).css(b.imgCSS),
                h = this.filter(':linkingToImage(' + b.srcAttr + ')');

            function i(a) {
                return a.replace(/(\/?)([^\/]+)$/, '$1' + b.thumbPrefix + '$2')
            }
            if (b.preloadImages) {
                (function(a) {
                    var g = new Image(),
                        e = arguments.callee;
                    g.src = i(c(h[a]).attr(b.srcAttr));
                    g.onload = function() {
                        h[a + 1] && e(a + 1)
                    }
                })(0)
            }
            h.mousemove(function(a) {
                d.css({
                    top: a.pageY + b.distanceFromCursor.top + 'px',
                    left: a.pageX + b.distanceFromCursor.left + 'px'
                })
            }).hover(function() {
                var a = this;
                d.addClass(b.containerLoadingClass).show();
                f.load(function() {
                    d.removeClass(b.containerLoadingClass);
                    f.show();
                    b.onLoad.call(f[0], a)
                }).attr('src', i(c(a).attr(b.srcAttr)));
                b.onShow.call(d[0], a)
            }, function() {
                d.hide();
                f.unbind('load').attr('src', '').hide();
                b.onHide.call(d[0], this)
            });
            return this
        }
    })(jQuery);
    $(function() {
        var obj = $("#imgPreview a[rel]");
        if (obj.length > 0) {
            $('#imgPreview a[rel]').imgPreview({
                srcAttr: 'rel',
                imgCSS: {
                    width: 200
                }
            });
        }
    });
    $(function() {
        set_status_empty();
    });

    function set_status_empty() {
        parent.window.$('#att-status').html('');
        parent.window.$('#att-name').html('');
    }

    function album_cancel(obj) {
        var src = $(obj).children("a").attr("rel");
        var filename = $(obj).children("a").attr("title");
        if ($(obj).hasClass('on')) {
            $(obj).removeClass("on");
            var imgstr = parent.window.$("#att-status").html();
            var length = $("a[class='on']").children("a").length;
            var strs = filenames = '';
            for (var i = 0; i < length; i++) {
                strs += '|' + $("a[class='on']").children("a").eq(i).attr('rel');
                filenames += '|' + $("a[class='on']").children("a").eq(i).attr('title');
            }
            parent.window.$('#att-status').html(strs);
            parent.window.$('#att-name').html(filenames);
        } else {
            var num = parent.window.$('#att-status').html().split('|').length;
            var file_upload_limit = '';
            $(obj).addClass("on");
            parent.window.$('#att-status').append('|' + src);
            parent.window.$('#att-name').append('|' + filename);
        }
    }
</script>

<?php include $this->views('admin/footer'); ?>
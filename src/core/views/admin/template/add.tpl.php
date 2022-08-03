<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<script type="text/javascript" src="/static/kindeditor/kindeditor.min.js"></script>

<style type="text/css">
    #codeTextarea {
        height: 500px;
        width: 90%;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">模板管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/template/index'); ?>">模板管理</a>
                    <a class="list-group-item active" href="<?php echo url('admin/template/add', array('template' => urldecode($template), 'dir' => urldecode($dir))); ?>">添加模板</a>
                    <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <form method="post" action="" class="form-inline">
            <div class="col-sm-9 col-md-9 col-lg-10 page_content">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title"><?php echo $filename ? '编辑' : '添加' ?>模板</span>
                        <div class="pull-right">
                            <a class="btn btn-default btn-xs" href="<?php echo url('admin/template/index'); ?>">列表</a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <p>
                            <?php if ($this->get('a') == 'edit'): ?>
                                <a class="btn btn-default" href="<?php echo $top_url; ?>">返回上一级</a>
                                <span class="input-group">
                                    <span class="input-group-addon">当前位置</span>
                                    <input type="text" class="form-control" size="20" readonly value="<?php echo $cur_path; ?>" placeholder="当前位置" />
                                </span>
                            <?php else: ?>
                                <a class="btn btn-default" href="<?php echo url('admin/template/item', array('template' => urldecode($template), 'dir' => urldecode($dir))); ?>">
                                    <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 返回
                                </a>
                                <span class="input-group">
                                    <span class="input-group-addon">文件保存位置<?php echo $cur_path; ?></span>
                                    <input type="text" class="form-control" size="20" value="" name="file_name" placeholder="文件名" />
                                </span>
                                <span class="show-tips">只支持后缀为html、js、css、txt。</span>
                            <?php endif; ?>
                        </p>
                        <textarea name="file_content" id="codeTextarea"><?php echo $filecontent; ?></textarea>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
KindEditor.ready(function(K) {
    K.create('#codeTextarea', {
        width: '100%',
        designMode: false, // 代码模式
        autoHeightMode : true,
        resizeMode: false,
        resizeType: 1,
        items : ['fullscreen', 'source']
    });
});
</script>

<?php include $this->views('admin/footer'); ?>
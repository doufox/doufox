<?php include $this->admin_view('header'); ?>

<?php include $this->admin_view('navbar'); ?>

<style type="text/css">
    #codeTextarea {
        height: 500px;
        width: 98%;
        background: none
    }

    .textAreaWithLines {
        font-family: courier;
        border: 1px solid #ddd;
    }

    .textAreaWithLines textarea,
    .textAreaWithLines div {
        border: 0px;
        line-height: 120%;
        font-size: 12px;
    }

    .lineObj {
        color: #666;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-2 page_menu">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title">模板管理</span>
                </div>
                <div class="list-group">
                    <a class="list-group-item" href="<?php echo url('admin/template/index'); ?>">模板管理</a>
                    <a class="list-group-item active" href="<?php echo url('admin/template/add'); ?>">添加模板</a>
                    <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-9 col-lg-10 page_content">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo $filename ? '编辑' : '添加' ?>模板</div>
                <?php if (!is_writable($filepath)) { ?>
                    <div class="panel-body">
                        <b style="color:red"><?php echo $filepath . '不可写'; ?></b>
                    </div>
                <?php } ?>
                <div class="panel-body">
                    <form method="post" action="" class="form-inline">
                        <?php if ($this->get('a') == 'edit') { ?>
                            <p>
                                <a class="btn btn-default" href="<?php echo $top_url; ?>">返回上一级</a>
                                <a class="btn btn-default">当前位置：<?php echo $local ?></a>
                            </p>
                        <?php } else { ?>
                            <a class="btn btn-default" href="<?php echo url('admin/template'); ?>">返回</a>
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo $local; ?></span>
                                <input type="text" class="form-control" size="20" value="" name="file_name" placeholder="文件名" />
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">文件类型 <span class="caret"></span></button>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li><a href="#">HTML</a></li>
                                        <li><a href="#">CSS</a></li>
                                        <li><a href="#">JS</a></li>
                                        <li role="separator" class="divider"></li>
                                    </ul>
                                </div>
                            </div>
                            <span class="show-tips">只支持后缀为.html、.js、.css。</span>
                        <?php } ?>
                        <hr />
                        <textarea name="file_content" id="codeTextarea"><?php echo $filecontent; ?></textarea>
                        <hr />
                        <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var lineObjOffsetTop = 2;

    function createTextAreaWithLines(id) {
        var el = document.createElement('DIV');
        var ta = document.getElementById(id);
        ta.parentNode.insertBefore(el, ta);
        el.appendChild(ta);
        el.className = 'textAreaWithLines';
        el.style.width = (ta.offsetWidth + 30) + 'px';
        ta.style.position = 'absolute';
        ta.style.left = '30px';
        el.style.height = (ta.offsetHeight + 2) + 'px';
        el.style.overflow = 'hidden';
        el.style.position = 'relative';
        el.style.width = (ta.offsetWidth + 30) + 'px';
        var lineObj = document.createElement('DIV');
        lineObj.style.position = 'absolute';
        lineObj.style.top = lineObjOffsetTop + 'px';
        lineObj.style.left = '0px';
        lineObj.style.width = '27px';
        el.insertBefore(lineObj, ta);
        lineObj.style.textAlign = 'right';
        lineObj.className = 'lineObj';
        var string = '';
        for (var no = 1; no < 2000; no++) {
            if (string.length > 0) string = string + '<br>';
            string = string + no;
        }
        ta.onkeydown = function() {
            positionLineObj(lineObj, ta);
        };
        ta.onmousedown = function() {
            positionLineObj(lineObj, ta);
        };
        ta.onscroll = function() {
            positionLineObj(lineObj, ta);
        };
        ta.onblur = function() {
            positionLineObj(lineObj, ta);
        };
        ta.onfocus = function() {
            positionLineObj(lineObj, ta);
        };
        ta.onmouseover = function() {
            positionLineObj(lineObj, ta);
        };
        lineObj.innerHTML = string;
    }

    function positionLineObj(obj, ta) {
        obj.style.top = (ta.scrollTop * -1 + lineObjOffsetTop) + 'px';
    }
    createTextAreaWithLines('codeTextarea');
</script>

<?php include $this->admin_view('footer'); ?>
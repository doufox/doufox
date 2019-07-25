<?php include $this->admin_tpl('header'); ?>

<?php include $this->admin_tpl('navbar'); ?>

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
    <div class="list-group page_menu">
        <a class="list-group-item" href="<?php echo url('admin/template/index'); ?>">模板管理</a>
        <a class="list-group-item" href="<?php echo url('admin/template/add'); ?>">添加模板</a>
        <a class="list-group-item" href="<?php echo url('admin/template/cache'); ?>">更新缓存</a>
    </div>
    <div class="page_content">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $filename ? '编辑' : '添加' ?>模板</div>
            <?php if (!is_writable($filepath)) { ?>
                <div class="panel-body">
                    <b style="color:red"><?php echo $filepath . '不可写'; ?></b>
                </div>
            <?php } ?>
            <div class="panel-body">
                <form method="post" action="" class="form-inline">
                    <p>
                        <span>当前位置：<?php echo $local; ?></span>
                        <?php if ($this->get('a') == 'add') { ?>
                            <input type="text" class="form-control input-sm" size="20" value="" name="file_name">
                            <span class="show-tips">只支持后缀为.html、.js、.css。</span>
                        <?php } ?>
                    </p>
                    <textarea name="file_content" id="codeTextarea"><?php echo $filecontent; ?></textarea>
                    <hr />
                    <button type="submit" class="btn btn-default" value="提交" name="submit">提交</button>
                </form>
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

<?php include $this->admin_tpl('footer'); ?>
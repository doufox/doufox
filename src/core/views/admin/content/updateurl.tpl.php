<?php include $this->views('admin/header'); ?>
<?php include $this->views('admin/navbar'); ?>
<?php include $this->views('admin/common/msg');?>

<div class="container-fluid">
    <form action="" method="post" target="result" class="form-inline">
        <div class="panel panel-default">
            <div class="panel-heading">更新内容URL</div>
            <div class="panel-body">
                <table width="100%" class="table_form">
                    <tr>
                        <th width="100">选择栏目</th>
                        <td>
                            <select class="form-control" name="catids[]" style="width:200px;" size=10 multiple>
                                <option value="0">=== 全部栏目 ===</option>
                                <?php echo $category; ?>
                            </select>
                            <div class="show-tips">表单列表模板</div>
                        </td>
                    </tr>
                    <tr>
                        <th>每次执行数量</th>
                        <td><input type="text" class="form-control" size="10" value="100" name="nums" /></td>
                    </tr>
                    <tr>
                        <th>运行状态</th>
                        <td style="padding-left:2px;">
                            <iframe name="result" frameborder="0" id="result" width="100%" height="30"></iframe>
                        </td>
                    </tr>
                </table>
                <hr />
                <button class="btn btn-default" type="submit" name="submit" value="开始执行">开始执行</button>
            </div>
        </div>
    </form>
</div>

<?php include $this->views('admin/footer'); ?>
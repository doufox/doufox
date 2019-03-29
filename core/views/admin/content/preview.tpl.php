<?php include $this->admin_tpl('header');?>

<table width="100%" class="table_form">
    <tbody>
        <tr>
            <th width="80">栏目ID：</th>
            <td><?php echo $catid; ?></td>
        </tr>
        <tr>
            <th>栏目名称：</th>
            <td><?php echo $catname; ?></td>
        </tr>
        <tr>
            <th>发表时间：</th>
            <td><?php echo date("Y-m-d H:i:s", $data['time']); ?></td>
        </tr>
        <tr>
            <th>阅读数：</th>
            <td><?php echo $data['hits']; ?></td>
        </tr>
        <?php if ($model['content']['title']['show']) { ?>
        <tr>
            <th><?php echo $model['content']['title']['name']; ?>：</th>
            <td><?php echo $data['title']; ?></td>
        </tr>
        <?php } if ($model['content']['thumb']['show']) { ?>
        <tr>
            <th><?php echo $model['content']['thumb']['name']; ?>：</th>
            <td>
                <input hidden value="<?php echo $data['thumb']; ?>" id="-thumb">
                <span onmouseover="admin_command.preview2('-thumb');" onmouseout="admin_command.preview('-thumb');"><?php echo $data['thumb']; ?></span>
                <div id="imgPreview-thumb" style="position:relative;"></div>
            </td>
        </tr>
        <?php } if ($model['content']['keywords']['show']) { ?>
        <tr>
            <th><?php echo $model['content']['keywords']['name']; ?>：</th>
            <td><?php echo $data['keywords']; ?></td>
        </tr>
        <?php } if ($model['content']['description']['show']) { ?>
        <tr>
            <th><?php echo $model['content']['description']['name']; ?>：</th>
            <td><?php echo $data['description']; ?></td>
        </tr>
        <?php } echo $data_fields; ?>
        <tr>
            <th>状态：</th>
            <td>
                <?php if (!isset($data['status']) || $data['status']==1) { ?>正常<?php } ?>
                <?php if ($data['status']==2) { ?>头条<?php } ?>
                <?php if ($data['status']==3) { ?>推荐<?php } ?>
                <?php if (isset($data['status']) && $data['status']==0) { ?>未审核<?php } ?>
            </td>
        </tr>
    </tbody>
</table>

</body>
</html>

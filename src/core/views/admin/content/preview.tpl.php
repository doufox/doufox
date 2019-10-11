<?php include $this->admin_tpl('header');?>

<table width="100%" class="table_form">
    <tbody>
        <tr>
            <th width="80">ID：</th>
            <td><?php echo $data['id']; ?></td>
        </tr>
        <tr>
            <th width="80">栏目：</th>
            <td><?php echo $data['catname'] . '(ID:' . $data['catid'] . ')'; ?></td>
        </tr>
        <tr>
            <th width="80">模型：</th>
            <td><?php echo $data['modelname'] . '(ID:' . $data['modelid'] . ')'; ?></td>
        </tr>
        <tr>
            <th>发表时间：</th>
            <td><?php echo date("Y-m-d H:i:s", $data['time']); ?></td>
        </tr>
        <tr>
            <th>点击量：</th>
            <td><?php echo $data['hits']; ?></td>
        </tr>
        <tr>
            <th>地址：</th>
            <td><?php echo $data['url']; ?></td>
        </tr>
        <?php if ($model['content']['title']['show']) { ?>
        <tr>
            <!-- title -->
            <th><?php echo $model['content']['title']['name']; ?>：</th>
            <td><?php echo $data['title']; ?></td>
        </tr>
        <?php } if ($model['content']['thumb']['show']) { ?>
        <tr>
            <!-- thumb -->
            <th><?php echo $model['content']['thumb']['name']; ?>：</th>
            <td>
                <input hidden value="<?php echo $data['thumb']; ?>" id="-thumb">
                <span onmouseover="admin_command.preview_img('-thumb');"><?php echo $data['thumb']; ?></span>
                <div id="imgPreview-thumb" style="position:relative;"></div>
            </td>
        </tr>
        <?php } if ($model['content']['keywords']['show']) { ?>
        <tr>
            <!-- keywords -->
            <th><?php echo $model['content']['keywords']['name']; ?>：</th>
            <td><?php echo $data['keywords']; ?></td>
        </tr>
        <?php } if ($model['content']['description']['show']) { ?>
        <tr>
            <!-- description -->
            <th><?php echo $model['content']['description']['name']; ?>：</th>
            <td><?php echo $data['description']; ?></td>
        </tr>
        <?php }
            // echo $data_fields;
        ?>
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

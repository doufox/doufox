<?php include $this->admin_tpl('header');?>

<div class="subnav">
    <div class="table-list">
        <form method="post" action="" id="myform" name="myform">
        <input name="filename" id="filename" type="hidden" value="<?php echo $data['filename']; ?>">
            <div>
            <div class="bk10"></div> <div class="bk10"></div> 
            <table width="100%">
            <tr>
            <td align="center"><?php echo $data['msg']; ?></td>
            </tr>
            </table>
            <div class="show-tips"><?php echo $note; ?></div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
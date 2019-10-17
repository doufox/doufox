<?php include $this->_include('header.html'); echo PHP_EOL; ?>
<div class="blank10 clear"></div>
<div class="main ">
 <div class=" bg">
  <div class="crumbs"><a href="<?php echo $site_url; ?>">Home</a>&nbsp;>>&nbsp;<?php echo $form_name; ?></div>
  <div class="item-list">
   <form action="" method="post">
    <table width="100%" class="table_form ">
    <tr>
     <th width="100"></th>
     <td></td>
     </tr>
<?php echo $fields;  if ($code) { ?>
     <tr>
     <th>验证码：</th>
     <td><input name="code" type="text" class="input-text" size=10 /><img src="<?php echo url('api/access/checkcode', array('width'=>80,'height'=>25)); ?>" align="absmiddle"></td>
     </tr>
<?php } ?>
     <tr>
     <th >&nbsp;</th>
     <td ><input type="submit" class="button" value="提 交" name="submit"></td>
     </tr>
    </table>
   </form>
  </div>
 </div>
</div>
<div class="clear blank10"></div>
<?php include $this->_include('footer.html'); echo PHP_EOL; ?>
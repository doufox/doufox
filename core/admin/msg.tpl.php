<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>提示信息</title>
<style type="text/css">
<!--
body, h1, p, a, img {margin:0;padding:0;}
body{
	text-align:center;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
	font-size: 12px;
	line-height: 1.5;
}
h1,p{padding-left:100px; text-align:left;}
h1{font-size:14px; margin-top:12px;}
p{font-size:12px; line-height:150%;padding:10px 10px 10px 100px;line-height:18px;}
.box_border{margin:180px auto 0;width:420px; padding:20px 0;}
#right{border:1px solid #A6DFA6; background:#EEF9EE;}
#right h1{color:#237E29;}
#right a:link,a:visited{color: #237E29;text-decoration: none;}
#right a:hover,a:active{color: #237E29;text-decoration: underline;}
#wrong{border:1px solid #FDBD77; background:#FFFDD7;}
#wrong h1{color:#f30;}
#wrong a:link,a:visited{color: #f30;text-decoration: none;}
#wrong a:hover,a:active{color: #0066FF;text-decoration: underline;}
.c_red{color:#FF0000;}
#right a{color: #237E29;}
#wrong a{color: #f30;}
-->
</style>
</head>
<body>
<div class="box_border" <?php if ($status==1){ ?>id="right" <?php }else{?> id="wrong" <?php } ?>>
  <div class="content">
	<h1><?php echo $msg; ?></h1>
    <p><?php if ($url == null){ ?>
	<a href="javascript:history.back();" >[点这里返回上一页]</a>
	<?php }elseif($url == 'close'){ ?>
	<input type="button" name="close" value=" 关闭 " onClick="window.close();">
	<?php }elseif($url == 'back'){ ?>
	<script type="text/javascript">setTimeout(function(){history.back();}, <?php echo $time; ?>);</script>
	<?php }else{?>
	<a href="<?=$url?>">如果您的浏览器没有自动跳转，请点击这里</a>
	<script type="text/javascript">setTimeout("location.href='<?=$url?>';", <?php echo $time; ?>);</script>   
	<?php } ?>
  </div>
</div>
</body>
</html>
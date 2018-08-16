<?php include $this->admin_tpl('header');?>
<style> 
.uploadlay {}
#ui-upload-holder{ position:relative;width:60px;height:25px;border:1px solid silver; overflow:hidden;float: left;} 
#ui-upload-input{ position:absolute;top:0px;right:0px;height:100%;cursor:pointer; opacity:0;filter:alpha(opacity:0);z-index:999;float:left;} 
#ui-upload-txt{ position:absolute;top:0px;left:0px;width:100%;height:100%;line-height:25px;text-align:center;} 
#ui-upload-button {position:relative;padding-left:10px;padding-top:1px;height:25px;overflow:hidden;float: left;}
#ui-upload-filepath{ position:relative; border:1px solid silver; width:210px; height:25px; overflow:hidden; float:left;border-right:none;} 
#ui-upload-filepathtxt{ position:absolute; top:0px;left:0px; width:100%;height:25px; border:0px; line-height:25px; } 
.uploadlay{padding-left:25px;} 
</style>
<div class="subnav">
	<div class="table-list">
		<form method="post" action="" id="myform" name="myform" enctype="multipart/form-data">
		<input name="filename" id="filename" type="hidden" value="<?php echo $fielname; ?>">
		<input name="size" id="size" type="hidden" value="<?php echo $size; ?>">
		<input name="admin" id="admin" type="hidden" value="<?php echo $admin; ?>">
		<div class="pad-10">
			<div class="col-tab">

				<div class="uploadlay"> 
						<div id="ui-upload-filepath"> 
							<input type="text" id="ui-upload-filepathtxt" class="filepathtxt" disabled /> 
						</div> 
						<div id="ui-upload-holder"> 
							<div id="ui-upload-txt">浏览</div> 
							<input type="file" id="ui-upload-input" name="file" /> 
						</div>
						<div id="ui-upload-button"> 
							<input type="submit" class="button" value="点击上传" name="submit" align="absmiddle" <?php if ($isimage) {?>onClick="this.value='正在上传'"<?php } else { ?>onClick="uploading()"<?php };?> />
						</div>
					</div>
					<script> 
					document.getElementById("ui-upload-input").onchange=function(){ 
						document.getElementById("ui-upload-filepathtxt").value = this.value; 
					}
					</script>
				<div class="onShow"><?php echo $note; ?></div>
			</div>
		</div>
		</form>
	</div>
</div>
</body>
</html>
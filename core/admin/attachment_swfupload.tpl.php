<?php include $this->admin_tpl('header');?>

<link href="/static/swfupload/swfupload.css" rel="stylesheet" type="text/css" />
<script language="javascript">
var viewpath = "/static/img/";
</script>
<script type="text/javascript" src="/static/swfupload/swfupload.js"></script>
<script type="text/javascript" src="/static/swfupload/fileprogress.js"></script>
<script type="text/javascript" src="/static/swfupload/handlers.js"></script>
<script type="text/javascript">
var swfu = '';
$(document).ready(function(){
	swfu = new SWFUpload({
		flash_url:"/static/swfupload/swfupload.swf?"+Math.random(),
		upload_url:"<?php echo url('attachment/ajaxswfupload/'); ?>",
		file_post_name : "Filedata",
		post_params:{"SWFUPLOADSESSID":"<?php echo $sessionid; ?>","submit":"1", "type":"<?php echo $type; ?>", "size":"<?php echo $size; ?>", "admin":"<?php echo $admin; ?>"},
		file_size_limit:"<?php echo $filesize; ?>",
		file_types:"<?php echo $data; ?>",
		file_types_description:"All Files",
		file_upload_limit:"10",
		custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},

		button_image_url: "",
		button_width: 75,
		button_height: 28,
		button_placeholder_id: "buttonPlaceHolder",
		button_text_style: "",
		button_text_top_padding: 3,
		button_text_left_padding: 12,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,

		file_dialog_start_handler : fileDialogStart,
		file_queued_handler : fileQueued,
		file_queue_error_handler:fileQueueError,
		file_dialog_complete_handler:fileDialogComplete,
		upload_progress_handler:uploadProgress,
		upload_error_handler:uploadError,
		upload_success_handler:uploadSuccess,
		upload_complete_handler:uploadComplete
	});
})
</script>

<div class="pad-10">
    <div class="col-tab">
        <ul class="tabBut cu-li">
            <li onclick="SwapTab('swf','on','',2,1);" id="tab_swf_1"  class="on">上传附件</li>
			<li onclick="SwapTab('swf','on','',2,2);" id="tab_swf_2">目录浏览</li>
        </ul>
        <div id="div_swf_1" class="content pad-10 ">
            <div>
				<div class="addnew" id="addnew">
					<span id="buttonPlaceHolder"></span>
				</div>
				<input type="button" id="btupload" value="开始上传" onClick="swfu.startUpload();" />
                <div id="nameTip" class="onShow">最多上传个10个，单文件最大<?php echo $size; ?>MB</div>
                <div class="bk3"></div>
                <div class="lh24">支持格式: <?php echo str_replace(',', '、', $type); ?></div>
            </div> 	
    		<div class="bk10"></div>
        	<fieldset class="blue pad-10" id="swfupload">
        	<legend>列表</legend>
        	<ul class="attachment-list" id="fsUploadProgress">    
        	</ul>
    		</fieldset>
    	</div>
       <div class="contentList pad-10 hidden" id="div_swf_2" style="display: none;">
            <ul class="attachment-list">
        	<iframe width="100%" scrolling="auto" height="330" frameborder="false" id="album_dir" allowtransparency="true" style="overflow-x:hidden;border:none" src="<?php echo url('attachment/album', array('admin'=>$admin)); ?>" name="album-dir"></iframe>   
        	</ul>
        </div>
        <div id="att-status" class="hidden"></div>
        <div id="att-status-del" class="hidden"></div>
        <div id="att-name" class="hidden"></div>
        <!-- swf -->
    </div>
</div>
</body>
<script type="text/javascript">
if ($.browser.mozilla) {
	window.onload=function(){
	    if (location.href.indexOf("&rand=")<0) {
			//location.href=location.href+"&rand="+Math.random();
		}
	}
}
function imgWrap(obj){
	$(obj).hasClass('on') ? $(obj).removeClass("on") : $(obj).addClass("on");
}

function SwapTab(name,cls_show,cls_hide,cnt,cur) {
    for(i=1;i<=cnt;i++){
		if(i==cur) {
			$('#div_'+name+'_'+i).show();
			$('#tab_'+name+'_'+i).addClass(cls_show);
			$('#tab_'+name+'_'+i).removeClass(cls_hide);
		} else {
			$('#div_'+name+'_'+i).hide();
			$('#tab_'+name+'_'+i).removeClass(cls_show);
			$('#tab_'+name+'_'+i).addClass(cls_hide);
		}
	}
}

function addonlinefile(obj) {
	var strs = $(obj).val() ? '|'+ $(obj).val() :'';
	$('#att-status').html(strs);
}

function change_params(){
	if($('#watermark_enable').attr('checked')) {
		swfu.addPostParam('watermark_enable', '1');
	} else {
		swfu.removePostParam('watermark_enable');
	}
}
function set_iframe(id,src){
	$("#"+id).attr("src",src); 
}
function album_cancel(obj,id,source){
	var src = $(obj).children("img").attr("path");
	var filename = $(obj).attr('title');
	if($(obj).hasClass('on')){
		$(obj).removeClass("on");
		var imgstr = $("#att-status").html();
		var length = $("a[class='on']").children("img").length;
		var strs = filenames = '';
		for(var i=0;i<length;i++){
			strs += '|'+$("a[class='on']").children("img").eq(i).attr('path');
			filenames += '|'+$("a[class='on']").children("img").eq(i).attr('title');
		}
		$('#att-status').html(strs);
		$('#att-status').html(filenames);
	} else {
		var num = $('#att-status').html().split('|').length;
		var file_upload_limit = '10';
		if(num > file_upload_limit) {alert('不能选择超过'+file_upload_limit+'个附件'); return false;}
		$(obj).addClass("on");
		$('#att-status').append('|'+src);
		$('#att-name').append('|'+filename);
	}
}
</script>
</html>

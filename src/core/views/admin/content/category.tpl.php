<?php include $this->admin_view('header');?>

<link rel="stylesheet" type="text/css" href="/static/jquery.treeview/jquery.treeview.css" />
<script type="text/javascript" src="/static/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/static/jquery.treeview/jquery.treeview.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#category_tree").treeview({
			control: "#treecontrol",
			persist: "cookie",
			cookieId: "treeview-black"
	});
});
function open_list(obj) {
	window.top.$("#current_pos_attr").html($(obj).html());
}
</script>
 <div style="margin-left:6px;margin-top:10px;">
	<div id="treecontrol">
		<span style="display:none">
			<a href="#"></a>
			<a href="#"></a>
		</span>
		<a href="#"><img src="/static/img/minus.gif" />   展开/收缩</a>
	</div>
<?php echo $categorys; ?>
</div>

</body>
</html>

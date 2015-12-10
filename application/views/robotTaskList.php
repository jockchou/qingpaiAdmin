<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/robotTaskList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script type="text/javascript">
(function($) {
	$('.del-task').on('click', function(evt) {
		evt.preventDefault();
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/imglibs/delRobotTask', {id: id}, function(rtn) {
				if (rtn == "1") {
					alert("操作成功");
					window.location.reload();
				} else {
					alert("操作失败");
				}
			});
		}
		return false;
	});
})(jQuery);
</script>
</body>
</html>

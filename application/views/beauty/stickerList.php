<?php include(dirname(dirname(__FILE__)) . "/block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/stickerList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include(dirname(dirname(__FILE__)) . "/block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('.del-btn').on('click', function() {
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要删除该颜值贴纸?");
		if (ok) {
			$.get('/beauty/stickerDelete', {id: id}, function(rtn) {
				if (rtn == "1") {
					location.reload();
				} else {
					alert("操作失败");
				}
			});
		}
	});
	$('.setstate-btn').click(function(){
		var id = $(this).attr('data-id');
		var state = $(this).attr('state');
		var ok = window.confirm("你确定要执行此操作吗?");
		if (ok) {
			$.get('/beauty/stickerState', {id:id, state:state}, function(rtn) {
				if (rtn == "1") {
					location.reload();
				} else {
					alert("操作失败");
				}
			});
		}
	});
})(jQuery);
</script>
</body>
</html>

<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/bandList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {

	$('.unblock').on('click', function() {
		var $this = $(this);
		var userId = $this.attr('data-uid');
		var ok = window.confirm("你确定要执行此操作?");
		if (ok) {
			$.get('/jjuser/unbandUser', {userID: userId}, function(rtn) {
				if (rtn == "1") {
					alert("操作成功");
					window.location.reload();
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

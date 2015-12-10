<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/crondList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('.remove-crond').on('click', function() {
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要执行此操作?");
		if (ok) {
			$.get('/sticker/removeCrond', {id: id}, function(rtn) {
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

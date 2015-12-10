<?php include("block/frame_top.php");?>

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
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('.del-btn').on('click', function() {
		var $this = $(this);
		var id = $this.attr('data-id');
		var op = $this.attr('data-op');
		var ok = window.confirm("你确定要执行此操作?");
		if (ok) {
			$.get('/sticker/stickerDelete', {id: id, op: op}, function(rtn) {
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

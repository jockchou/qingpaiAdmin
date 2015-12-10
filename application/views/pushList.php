<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/pushList.php");?>
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
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/pushboard/pushDel', {id: id}, function(rtn) {
				if (rtn == "1") {
					location.reload();
				}
			});
		}
	});
})(jQuery);
</script>
</body>
</html>

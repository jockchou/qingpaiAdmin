<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/bannerList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('td').css('text-align', 'center');
	
	$('.del-btn').on('click', function() {
		var $this = $(this);
		var id = $this.attr('data-id');
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/banner/deleteBanner', {id: id}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('删除失败！');
				}
			});
		}
	});
	
	$('.offline-btn').on('click', function() {
		var $this = $(this);
		var id = $this.attr('data-id');
		var ok = window.confirm("你确定要下线?");
		if (ok) {
			$.get('/banner/offlineBanner', {id: id}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('删除失败！');
				}
			});
		}
	});
})(jQuery);
</script>
</body>
</html>
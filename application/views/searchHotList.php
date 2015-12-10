<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/searchHotList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('.hotsubject-del-btn').on('click', function() {
		var $this = $(this);
		var sid = $this.attr('data-id');
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/subjectactivity/deSearchHost', {sid: sid}, function(rtn) {
				if (rtn == "1") {
					$this.parent('td').parent('tr').remove();
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

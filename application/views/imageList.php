<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/imageList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">

$(".btn-delimg").on('click', function() {
	$this = $(this);
	
	var imgID = $this.attr('data-id');
	
	var ok = window.confirm("您要删除?");
	
	if (ok) {
		$.get('/imglibs/deleteImage', {imgID: imgID}, function(rtn) {
				if (rtn == "1") {
					window.location.reload();
				} else {
					alert("操作失败");
				}
			});
	}
	return false;
});
</script>
</body>
</html>

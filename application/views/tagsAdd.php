<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/tagsAdd.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
$(function () {
	$('.tagsName').keyup(function () {
		var $this = $(this);
		var tagsName = $this.val();
		if (tagsName.length > 7) {
			document.getElementById("tagsWarning").style.display="inline";
		} else {
			document.getElementById("tagsWarning").style.display="none";
		}
	});

	$('.tagsName').blur(function () {
		var $this = $(this);
		var tagsName = $this.val();
		if (tagsName.length > 7) {
			$this.val('');
			$this.focus();
		}
	});
})
</script>
</body>
</html>

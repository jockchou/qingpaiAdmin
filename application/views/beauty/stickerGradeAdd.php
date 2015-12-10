<?php include(dirname(dirname(__FILE__)) . "/block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/stickerGradeAdd.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include(dirname(dirname(__FILE__)) . "/block/footer.php");?>
<!--end-Footer-part-->
</body>
</html>

<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/addRobotTask.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script type="text/javascript">
function getSelectValue(){

	var title = $("#subjectId option:selected").text();
	$("#subjectTitle").val(title);
}
</script>

</body>
</html>

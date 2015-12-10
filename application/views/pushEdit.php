<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/pushEdit.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<?php include("block/script_msgTypeSel.php");?>

<script type="text/javascript">
	var unLoginDays_placeholder = $("input[name=unLoginDays]").attr('placeholder');
	$("input[name=loginDays]").keyup(function(){ 
		
		var loginDays = parseInt($(this).val());
		if (isNaN(loginDays)) {
			$("input[name=loginDays]").val('');
		} else {
			$("input[name=loginDays]").val(loginDays);
		}
		
		if (loginDays > 0) {
			$("input[name=unLoginDays]").attr('disabled','disabeld');
			$("input[name=unLoginDays]").val('').attr('placeholder', '');

		} else {
			$("input[name=unLoginDays]").removeAttr('disabled');
			$("input[name=unLoginDays]").val('').attr('placeholder', unLoginDays_placeholder);
		}
	});

	$("input[name=unLoginDays]").keyup(function(){ 
		
		var unLoginDays = parseInt($(this).val());
		if (isNaN(unLoginDays)) {
			$("input[name=unLoginDays]").val('');
		} else {
			$("input[name=unLoginDays]").val(unLoginDays);
		}
	});
</script>
</body>
</html>
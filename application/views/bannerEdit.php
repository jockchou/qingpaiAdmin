<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/bannerEdit.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<!--?php include("block/script_msgTypeSel.php");?-->
<script>
	$(function(){
		$("select[name='type']").change(function(){
			
			if (this.value == 1) {
				$("input[name='jumpUrl']").attr('placeholder', 'url路径');
			} else if (this.value == 2) {
				$("input[name='jumpUrl']").attr('placeholder', 'subjectID');
			}
		});
		
		$("select[name='pageType']").change(function(){
			if (this.value == 1) {
				$("select[name='type']").children("option[value='2']").remove();
				$("select[name='type']").parent().find('span').text('H5页面');
			} else if (this.value == 2) {
				$("select[name='type']").append("<option value='2'>话题详情页</option>");
				$("select[name='type']").parent().find('span').text('H5页面');
			}
		});
	});
</script>
</body>
</html>
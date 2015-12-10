<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?=$crumbs?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/versionList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	var fileuploadTips = $("#fileupload-tips");
	var fileupload = $('#fileupload');
	var filePath = $("#filePath");
	
	fileupload.fileupload({
	    dataType: 'json',
	    start: function(e) {
			fileuploadTips.html('上传中').show();
	    },
	    done: function (e, data) {
	        var result = data.result;
	        if (result && result.status == 1) {
	        	fileuploadTips.attr('class', 'label label-success').html('完成').show();
	        	filePath.val(result.filePath);
	        } else {
	        	fileuploadTips.attr('class', 'label label-important').html(result.msg).show();
	        }
	    }
	});
})(jQuery);
$(function(){
	$("#version_list").find(".deleteAlert").click(function(e){
		e.preventDefault();
		var url = $(this).attr("href");
		$("#deleteConfirm").attr("href",url);
		$("#deleteAlert").modal("show");
	});
	
});
</script>
</body>
</html>

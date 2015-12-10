<?php include(dirname(dirname(__FILE__)) . "/block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/stickerGradeList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include(dirname(dirname(__FILE__)) . "/block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$(".del-btn").on("click",function(){
		if(confirm("确定要删除吗?") == false)return;
		var id = $(this).attr("id");
		$.get("/beauty/stickerGradeDelete",{id:id},function(data){
			if(data != '1'){
				alert("删除失败");
			}else{
				window.location.reload(true);
			}
		},'text');
	});
	
	$(".edit-btn").on("click",function(){
		var id = $(this).attr("id");
		if (id > 0) {
			location.href="/beauty/stickerGradeEdit?id=" + id;
		}
	});
})(jQuery);
</script>
</body>
</html>
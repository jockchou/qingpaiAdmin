<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/stickerClassList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$(".deleteClass").on("click",function(){
		if(confirm("确定要删除吗?") == false)return;
		var id = $(this).attr("id");
		$.get("/sticker/stickerClassDelete",{id:id},function(data){
			if(data != '1'){
				alert("删除失败");
			}else{
				window.location.reload(true);
			}
		},'text');
	});
})(jQuery);
</script>
</body>
</html>
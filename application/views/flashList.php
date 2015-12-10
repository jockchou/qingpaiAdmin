<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?=$crumbs?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/flashList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
$(function(){
	$(".rmbtn").click(function(e){
		e.preventDefault();
		var id = $(this).attr("data-id");
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/version/flashRemove', {id: id}, function(rtn) {
				if (rtn == 1) {
					alert("操作成功");
					window.location.reload();
				}else {
					alert("操作失败");
				}
			});
		}
		return false;
	});
});
</script>
</body>
</html>

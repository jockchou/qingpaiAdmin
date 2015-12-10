
<?php include("block/frame_top.php");?>
<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/commentReportList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$(".check-comment-btn").on('click', function(evt) {
		var $this = $(this);
		var id = $this.attr('data-id');
		var commentID = $this.attr('data-cid');
		var op = $this.attr('data-op');
		
		if (window.confirm("你确定要执行此操作?")) {

			$.get("/comport/delComment",{id: id, commentID: commentID, op: op},
					function(rtnCode) {
						if (rtnCode == "1") {
							alert('操作成功!');
							window.location.reload();
						} else {
							alert('操作失败');
						}
					},
					"json");
		}
		
		evt.preventDefault();
		return false;
	});

})(jQuery);
</script>
</body>
</html>

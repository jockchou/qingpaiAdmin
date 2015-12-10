<?php include(dirname(dirname(__FILE__)) . "/block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/reserveTopicList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include(dirname(dirname(__FILE__)) . "/block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('td').css('text-align', 'center');
	
	$('.setOpen-btn').click(function(){
		var setOpen = $(this).attr('setOpen');
		var ok = window.confirm("你确定要执行此操作吗?");
		if (ok) {
			$.get('/selectionTopic/doSendAction', {setOpen : setOpen}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('操作失败！');
				}
			});
		}
	});
	
	$('.del-btn').click(function(){
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要删除该帖子吗?");
		if (ok) {
			$.get('/selectionTopic/deleteReserveTopic', {id: id}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('删除失败！');
				}
			});
		}
	});
	
})(jQuery);
</script>
</body>
</html>
<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/selectionTopicList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('td').css('text-align', 'center');
	
	$('.online-btn').click(function(){
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要上线该帖子吗?");
		if (ok) {
			$.get('/selectionTopic/setSelectionTopicState', {sate: 0, id: id}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('上线失败！');
				}
			});
		}
	});
	
	$('.offline-btn').click(function(){
		var id = $(this).attr('data-id');
		var ok = window.confirm("你确定要下线该帖子吗?");
		if (ok) {
			$.get('/selectionTopic/setSelectionTopicState', {state: 1,id: id}, function(rtn) {
				if (rtn == "0") {
					location.reload();
				} else {
					alert('下线失败！');
				}
			});
		}
	});
	
	$('.del-btn').on('click', function() {
		var $this = $(this);
		var id = $this.attr('data-id');
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/selectionTopic/deleteSelectionTopic', {id: id}, function(rtn) {
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

<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/dubiousCommentList.php");?>
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
		var op = $this.attr('data-op');
		if(op == "chat"){
			location.href = '/message/chatHome?toUserID='+id; 
			return;
		}
		if (window.confirm("你确定要执行此操作?")) {
			if(op == "pass"){
				$.get('/comport/passDubiousComment',{commentID: id},function(rtnCode) {
					if (rtnCode == "1") {
						alert('操作成功!');
						window.location.reload();
					} else {
						alert('操作失败');
					}},'json');
			}else if(op == "stop"){
				$.get('/comport/delComment',{commentID: id,isDubious:1},function(rtnCode) {
					if (rtnCode == "1") {
						alert('操作成功!');
						window.location.reload();
					} else {
						alert('操作失败');
					}},'json');
			}else if(op == "block"){
				$.get('/jjuser/blockUserSave', {userID: id}, function(rtn) {
					if (rtn == 1) {
						alert("操作成功");
						window.location.reload();
					} else {
						alert("操作失败");
					}
				},'text');
			}else if(op == "unblock"){
				$.get('/jjuser/unblockUser', {userID: id}, function(rtn) {
					if (rtn == 1) {
						alert("操作成功");
						window.location.reload();
					} else {
						alert("操作失败");
					}
				});
			}
			evt.preventDefault();
			return false;
		}	
		
	});

})(jQuery);
</script>
</body>
</html>

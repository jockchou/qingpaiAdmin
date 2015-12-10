<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/sensitiveActionList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script type="text/javascript">
	$(".auditSensitive").click(function(event, actionFrom){

		var uid = $(this).attr('data-uid');
		var type = $(this).attr('data-type');
		$.get("/jjuser/updateSensitiveActionState",{
			'type': type,
			'userID': uid,
			'actionFrom': actionFrom
		}, function(rtn){
			if (rtn == 1) {
				window.location.reload();
			} else {
				alert("审核操作失败");
			}
		});
	});

	$('.block-user').on('click', function(evt) {
		evt.preventDefault();
		var _this = $(this);
		var userID = $(this).attr('data-id');

		var ok = window.confirm("你确定要封号?");
		if (ok) {
			$.get('/jjuser/blockUserSave', {userID: userID}, function(rtn) {
				if (rtn == 1) {
					//alert("封号操作成功");
					//window.location.reload();
					$(_this).parent().find(".auditSensitive").trigger('click', ['fenghao']);
				} else {
					alert("封号操作失败");
				}
			},'text');
		}
		return false;
	});
	
	$('.unblock-user').on('click', function(evt) {
		evt.preventDefault();
		
		var userID = $(this).attr('data-id');

		var ok = window.confirm("你确定要解封?");
		if (ok) {
			$.get('/jjuser/unblockUser', {userID: userID}, function(rtn) {
				if (rtn == 1) {
					//alert("操作成功");
					window.location.reload();
				} else {
					alert("操作失败");
				}
			});
		}
		return false;
	});
</script>
</body>
</html>

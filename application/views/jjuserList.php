<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/jjuserList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script type="text/javascript">
(function($) {
	$('.block-user').on('click', function(evt) {
		evt.preventDefault();
		
		var userID = $(this).attr('data-id');

		var ok = window.confirm("你确定要封号?");
		if (ok) {
			$.get('/jjuser/blockUserSave', {userID: userID}, function(rtn) {
				if (rtn == 1) {
					alert("操作成功");
					window.location.reload();
				} else {
					alert("操作失败");
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
					alert("操作成功");
					window.location.reload();
				} else {
					alert("操作失败");
				}
			});
		}
		return false;
	});
	$(".btn-dubious").on("click",function(evt){
		evt.preventDefault();
		var userID = $(this).attr('data-id');
		var ok = window.confirm("你确定要设为可疑?");
		if (ok) {
			$.get('/jjuser/setDubious', {userID: userID}, function(rtn) {
				if (rtn == 1) {
					alert("操作成功");
					window.location.reload();
				}else {
					alert("操作失败");
				}
			},'text');
		}
		return false;
	});
	$(".btn-redubious").on("click",function(evt){
		evt.preventDefault();
		var userID = $(this).attr('data-id');
		var ok = window.confirm("你确定要解除可疑?");
		if (ok) {
			$.get('/jjuser/removeDubious', {userID: userID}, function(rtn) {
				
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
	
	$(".addv-user").on("click",function(evt){
		evt.preventDefault();
		var userID = $(this).attr('data-id');
		var ok = window.confirm("你确定要加V?");
		if (ok) {
			$.get('/jjuser/addV', {userID: userID, isFamous: 1}, function(rtn) {
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
	
	$(".removev-user").on("click",function(evt){
		evt.preventDefault();
		var userID = $(this).attr('data-id');
		var ok = window.confirm("你确定要去V?");
		if (ok) {
			$.get('/jjuser/addV', {userID: userID, isFamous: 0}, function(rtn) {
				
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
})(jQuery);
</script>
</body>
</html>

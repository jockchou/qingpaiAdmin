<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    
	    <div class="row-fluid">
	    	<div class="span12">
			    <div class="widget-box">
			        <div class="widget-title">
			            <h5>封号</h5>
			        </div>
			
			        <div class="widget-content nopadding">
			            <form id="user-form-blockuser" action="/jjuser/blockUserSave" class="form-horizontal" method="post">
			            	
			                <div class="control-group">
			                    <label class="control-label">UserID:</label>
			                    <div class="controls">
			                        <input class="span3" name="userID" type="text" required>
			                    </div>
			                </div>
			                
			                <div class="form-actions">
			                    <button id="user-block-submit" class="btn btn-success" type="submit">无情封号</button>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
	    </div>
	    
	    <div class="row-fluid">
	    	<div class="span12">
			    <div class="widget-box">
			        <div class="widget-title">
			            <h5>禁言</h5>
			        </div>
			
			        <div class="widget-content nopadding">
			            <form id="user-form-banduser" action="/jjuser/bandUserSave" class="form-horizontal" method="post">
			            	
			                <div class="control-group">
			                    <label class="control-label">UserID:</label>
			                    <div class="controls">
			                        <input class="span3" name="userID" type="text" required>
			                    </div>
			                </div>
			                
			                <div class="form-actions">
			                    <button id="user-band-submit" class="btn btn-success" type="submit">无情禁言</button>
			                </div>
			            </form>
			        </div>
			    </div>
			</div>
	    </div>
	    
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('#user-block-submit').on('click', function(evt) {
		evt.preventDefault();
		
		var $form = $("#user-form-blockuser");
		var userID = $form.find(":input[name=userID]").val();

		if (userID == "") {
			alert("用户ID不能为空");
			return;
		}
		var ok = window.confirm("你确定要封号?");
		if (ok) {
			$.get('/jjuser/blockUserSave', {userID: userID}, function(rtn) {
				if (rtn == "1") {
					alert("操作成功");
					window.location.href = '/jjuser/blockList';
				} else if (rtn == "-1"){
					alert("userID不存在");
				} else {
					alert("操作失败");
				}
			});
		}
		return false;
	});
	
	
	$('#user-band-submit').on('click', function(evt) {
		evt.preventDefault();
		
		var $form = $("#user-form-banduser");
		var userID = $form.find(":input[name=userID]").val();

		if (userID == "") {
			alert("用户ID不能为空");
			return;
		}
		var ok = window.confirm("你确定要禁言?");
		if (ok) {
			$.get('/jjuser/bandUserSave', {userID: userID}, function(rtn) {
				if (rtn == "1") {
					alert("操作成功");
					window.location.href = '/jjuser/bandList';
				} else if (rtn == "-1"){
					alert("userID不存在");
				} else {
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

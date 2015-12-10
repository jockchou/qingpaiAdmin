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
			            <h5>修改密码</h5>
			        </div>
			
			        <div class="widget-content nopadding">
			            <form id="user-form-changepass" action="/admin/savePass" class="form-horizontal" method="post">
			            	
			                <div class="control-group">
			                    <label class="control-label">用户名:</label>
			                    <div class="controls">
			                        <input class="span3" name="username" type="text" readonly="true" value="<?=$user->username?>">
			                    </div>
			                </div>
			                
			                <div class="control-group">
			                    <label class="control-label">新密码 :</label>
			                    <div class="controls">
			                        <input class="span3" name="password" value="" autocomplete="off" placeholder="输入4-12个字符的密码" type="password" required>
			                    </div>
			                </div>
			                
			          		<div class="control-group">
			                    <label class="control-label">确认密码 :</label>
			                    <div class="controls">
			                        <input class="span3" name="password2" value="" autocomplete="off" placeholder="再次输入密码" type="password"  required>
			                    </div>
			                </div>
			                
			                <div class="form-actions">
			                    <button id="user-pass-submit" class="btn btn-success" type="submit">保存</button>
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
	$('#user-pass-submit').on('click', function(evt) {
		evt.preventDefault();
		
		var $form = $("#user-form-changepass");
		var username = $form.find(":input[name=username]").val();
		var password = $form.find(":input[name=password]").val();
		var password2 = $form.find(":input[name=password2]").val();

		if (password == "") {
			alert("密码不能为空");
			return;
		}
		if (password2 != password) {
			alert("两次密码输入不一样");
			return;
		}
		var ok = window.confirm("你确定要提交修改吗?");
		if (ok) {
			$.post('/admin/savePass', {username:username,password:password,password2:password2}, function(rtn) {
				if (rtn == "1") {
					alert("修改成功，请重新登录");
					window.location.href = '/login/index';
				} else if (rtn == "-1"){
					alert("密码不能为空");
				} else if (rtn == "-2") {
					alert("两次密码输入不一致");
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

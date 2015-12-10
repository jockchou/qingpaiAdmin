<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/userList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
(function($) {
	$('.user-del-btn').on('click', function() {
		var $this = $(this);
		var username = $this.attr('data-name');
		var ok = window.confirm("你确定要删除?");
		if (ok) {
			$.get('/user/userDelete', {username: username}, function(rtn) {
				if (rtn == "1") {
					$this.parent('td').parent('tr').remove();
				} else {
					if (rtn == "-1") {
						alert("没有权限");
					} else if (rtn == '-2') {
						alert("不能删除超管");
					} else if (rtn == '-3') {
						alert("删除的账号不存在");
					} else if (rtn == '-4') {
						alert("您不是超管，不能删除管理员");
					} else {
						alert("操作失败");
					}
				}
			});
		}
	});

	$('.user-admin-btn').on('click', function() {
		var $this = $(this);
		var username = $this.attr('data-name');
		var oper = $this.attr('data-oper');
		var ok = window.confirm("你确定要执行此操作?");
		if (ok) {
			$.get('/user/userAuth', {username: username, oper: oper}, function(rtn) {
				if (rtn == "1") {
					window.location.reload();
				} else {
					if (rtn == "-1") {
						alert("你不是超管，不能执行此操作");
					} else {
						alert("操作失败");
					}
				}
			});
		}
	});
})(jQuery);
</script>
</body>
</html>

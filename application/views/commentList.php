
<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/commentList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">

$(function($) {
	
	$("#delete").on('click', function(evt) {
		var delArr = [];
		$("span.checked").each(function(){
			var id = $(this).children(":eq(0)").attr('id');
			if(id != "select"){
				delArr.push(id);
			}
		});
		if(delArr.length == 0){
			alert("未选中任何评论");
		}else{
			//delArr = $.toJSON(delArr); 
			if (window.confirm("你确定要执行此操作?")) {
				$.post('/comport/delCommentArr',{commentIDList:delArr},function(rtnCode) {
					//alert(rtnCode);
					if (rtnCode == "1") {
						alert('操作成功!');
						window.location.reload();
					} else {
						alert('操作失败');
					}},'json');
			}
		}
		evt.preventDefault();
		return false;
	});

	$(".check-comment-btn").on('click', function(evt) {
		var $this = $(this);
		var id = $this.attr('data-id');
		if (window.confirm("你确定要执行此操作?")) {
			$.get('/comport/delComment',{commentID: id},function(rtnCode) {
				if (rtnCode == "1") {
					alert('操作成功!');
					window.location.reload();
				} else {
					alert('操作失败');
				}},'json');
		}
		evt.preventDefault();
		return false;
	});

});

function check(){
	$userID = $("#comuserID").val();
	$content = $("#comcontent").val();
	if($.trim($userID) == "" && $.trim($content) == ""){
		alert("搜索的用户userID和评论内容不能同时为空");
		return false;
	}
	return true;
}

function selectBtn(){
	$isChecked = $("#select").is(':checked');
	if($isChecked){
		//$("[name=commentCheck]:checkbox").attr("checked","true");
		$("[name=commentCheck]:checkbox").parent("span").attr("class","checked");
	}else{
		//$("[name=commentCheck]:checkbox").attr("checked","false");
		$("[name=commentCheck]:checkbox").parent("span").attr("class","");
	}
}
</script>
</body>
</html>

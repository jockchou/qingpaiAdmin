<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/charList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script src="/static/js/twemoji.min.js"></script>
<script type="text/javascript">
$(function(){
	
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
	<?php foreach ($charContentList as $key => $item):?>
				
	<?php
		$msgData = json_decode($item['mBody'], TRUE);
	?>
	<?php if (!empty($msgData['content'])):?>
		$("#content_<?=$key?>").html(twemoji.parse(
			<?=json_encode($msgData['content'])?>,
			function(icon, options, variant) {
    			return '/static/twemoji/36x36/' + icon + '.png';
    		}
    	));
	<?php endif;?>
	<?php endforeach;?>
	$("img.emoji").css("max-height", "1.5em");
});
</script>
</body>
</html>
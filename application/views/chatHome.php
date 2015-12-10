<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/chatHome.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script>
	var $msgBox = $("#msg-box");
	var $chatInner = $("#chat-messages-inner");
	var isPost = false;
	var $chatMsg = $('#chat-messages');
	$("#sendBtn").on("click", function() {
		var msgContent = $msgBox.val();
		var toUserID = $msgBox.attr("data-to");
		
		if (msgContent != "" && toUserID != "" && isPost == false) {
			$.post("/message/chatPost", {
				txtContent: msgContent,
				toUserID: toUserID
			}, function(rtn) {
				isPost = false;
				$chatInner.append(rtn);
				$msgBox.val("");
				$chatMsg.animate({scrollTop: $("#chat-messages").get(0).scrollHeight}, 'slow');
			});
			isPost = true;
		}
	});
</script>
</body>
</html>

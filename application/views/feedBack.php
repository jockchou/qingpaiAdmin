<?php include("block/frame_top.php");
	  
?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/feedBack.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript">
	var $msgBox = $("#msg-box");
	var $chatInner = $("#chat-messages-inner");
	var isPost = false;
	var $chatMsg = $('#chat-messages');
	$("#sendBtn").on("click", function() {
		sendMsg(0);
	});

	function sendMsg(type){
		var msgContent = $msgBox.val();
		var toUserID = $msgBox.attr("data-to");
		if (msgContent != "" && toUserID != "" && isPost == false) {
			$.post("/message/chatPost", {
				txtContent: msgContent,
				toUserID: toUserID,
				type: type
			}, function(rtn) {
				isPost = false;
				$chatInner.append(rtn);
				$msgBox.val("");
				$chatMsg.animate({scrollTop: $("#chat-messages").get(0).scrollHeight}, 'slow');
			});
			isPost = true;
		}
	}
	
	$(function(){
		$chatMsg.animate({scrollTop: $("#chat-messages").get(0).scrollHeight}, 'fast');
	});

	function setValue(value){
		arr=value.split('\\');
		if(arr.length == 0){
			arr=value.split('/');
		}
		$("#key").val(arr[arr.length-1]);
		$("#submit").css("display", "block");
		$("#msg-box").attr("readonly","readonly");
		$("#sendBtn").attr("disabled","true");
	}  
	function setPic(){
		var key = $("#key").val();
		$("#msg-box").val("http://qpsticker.qiniudn.com/"+key);
		$("#msg-box").removeAttr("readonly");
		$("#sendBtn").removeAttr("disabled");
		$("#pic").css("display", "none");		
		sendMsg(1);
	}
	window.onload=function(){
		function readFile(){
			var file = this.files[0];
			if(file.type.indexOf("image")<0){
				alert("文件必须为图片！");
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				pic.setAttribute('src',this.result);
				showpic.style.display="block";
			}
		}

		var pic = document.getElementById("pic");
		var showpic = document.getElementById("showpic");
		if(showpic == null){
			showpic = pic;
		}
		var input = document.getElementById("file_input");
		if(input != null)
			input.addEventListener('change',readFile,false);
	} 
</script>
</body>
</html>

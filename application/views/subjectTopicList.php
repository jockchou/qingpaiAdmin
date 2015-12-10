<?php include("block/frame_top.php");?>

<!--main-container-part1-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/subjectTopicList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part2-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<!-- 获取当前页面所有的帖子ID1 -->


<script type="text/javascript">

/*
* author: zhoujing
* email: zhoujing@xunlei.com
* QQ: 164068300
*/

var scrollPageTop = window.scrollPageTop || (function () {
	"use strict";

	var doc = document, backBtn, hz = 1.25, intervalId = 0,
		bindEvent, removeEvent, getScrollTop, setScrollTop, 
		animation, clickHandler, init;

	getScrollTop = function () {
		var yScroll = 0;
		if (self.pageYOffset) {
			yScroll = self.pageYOffset;
		} else if (doc.documentElement && doc.documentElement.scrollTop) {
			yScroll = doc.documentElement.scrollTop;
		} else if (doc.body) {
			yScroll = doc.body.scrollTop;
		}
		return yScroll;
	};

	setScrollTop = function (yScroll) {
		doc.documentElement.scrollTop = yScroll;
		doc.body.scrollTop = yScroll;
	};

	animation = function () {
		intervalId = window.setInterval(function () {
			setScrollTop(getScrollTop() / hz);
			if (getScrollTop() < 1) {
				window.clearInterval(intervalId);
			}
		}, 17);
	};

	
	
	clickHandler = function () {
		animation();
	};

	init = function (btn) {
		backBtn = btn;
		if (doc.body.addEventListener) {
			bindEvent = function (elem, type, handler) {
				elem.addEventListener(type, handler, false);
			};
			removeEvent = function (elem, type, handler) {
				elem.removeEventListener(type, handler, false);
			};
		} else {
			bindEvent = function (elem, type, handler) {
				elem.attachEvent('on' + type, handler);
			};
			removeEvent = function (elem, type, handler) {
				elem.detachEvent('on' + type, handler);
			};
		}

		bindEvent(btn, 'click', clickHandler);
	};

	return {
		init: init,
		hz: hz
	};
}());


;(function($) {


	scrollPageTop.init(document.getElementById("batch-gototop"));
	var list = {};
	
	$(".pingo-block").toggle(
			function () {
				$(this).parent().css("border-color","red");
				list[$(this).attr("id")] = $(this).attr("id");
			},
			function () {
				$(this).parent().css("border-color","gray");
				list[$(this).attr("id")] = 0;
			}
	);
	
	$("#simple-check").click(function(){

		var moveList = [];
		for(var prop in list){ 
		    if(list.hasOwnProperty(prop)){ 
		    	if(list[prop]!=0){
		        	moveList.push(list[prop]); 
		    	}
		    } 
		}
		
		if(moveList.length==0){alert("没有帖子被选中");return;}
		if(confirm("确定要移除这些帖子吗？") == false)return;
		for(var i=0;i<moveList.length;){
			
			$.post('/topic/sendMsg',{movetopic:moveList[i]},function(data){
				if(data != 0){		
					alert("发送消息失败，请重试");
				}
			},'text');
			i++;
		}
		$.post('/topic/setTopicSubjectID',{mt:<?=rand();?>,moveList:moveList},function(data){

				if(data == '1'){
							
					window.location.reload(true);
				}else{
					alert("(2)处理失败，请重试");
				}
				
			},'text');
		
	});
})(jQuery);
</script>
</body>
</html>

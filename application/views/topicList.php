<?php include("block/frame_top.php");?>
<style>
.pingo-block{
	height:230px;
	overflow:hidden;
}
.checkTopicRadioGroup label{
	display: inline-block;
	margin: 5px;
}

.checkTopicRadioGroup label input {
	display:none;
}
.floatRightSidle {
	float: right;
	position: fixed;
	right: 5px;
	top: 25%;
	display: none;
}
</style>
<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/topicList.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script type="text/javascript" src="/static/js/lib/scroll.js"></script>
<script type="text/javascript">
(function($) {
	var parseResult2Str = function(code) {
		if (code === true) return "成功";
		else if (code === false) return "失败";
		else return "未提交数据";
	};
	
	var highTopicArr, passTopicArr, lowTopicArr, badTopicArr, unselectArr, outSubjectArr, topicSubjectList, selectTopicArr, reserveTopicArr;
	
	function in_array(search,array){
		for(var i in array){
			if(array[i]==search){
				return true;
			}
		}
		return false;
	}
	
	$("#batch-check,#select-check").on("click", function() {
		highTopicArr = [];
		passTopicArr = [];
		lowTopicArr = [];
		badTopicArr = [];
		unselectArr = [];
		outSubjectArr = [];
		topicSubjectList = [];
		selectTopicArr = [];
		reserveTopicArr = [];
		
		var checkBtn = this.id;
		
		$(".pingo-box").each(function(i, domEle) {
			var $topicID = $(domEle).attr('data-id');
			$input = $(domEle).find(".checkTopicRadioGroup label span[class='checked']");
			
			if ($input.size() >= 1) {
				$input.each(function(n, dom) {
					$dataType = $(dom).find("input").attr('data-type');
					if ($dataType == 1) {
						highTopicArr.push($topicID);					
					} else if ($dataType == 2) {
						passTopicArr.push($topicID);
					} else if ($dataType == 3) {
						lowTopicArr.push($topicID);
					} else if ($dataType == 4) {
						badTopicArr.push($topicID);
					} else {
						unselectArr.push($topicID);
					}
					
					if ($dataType == 5) {
						outSubjectArr.push($topicID);
					} else if ($dataType == 6) {
						var subjectID = $(dom).find("input").attr('subjectID');
						var subjectTitle = $(dom).find("input").attr('subjectTitle');
						var isOfficial = $(dom).find("input").attr('isOfficial');
						var subjectData = {
							"topicID": $topicID,
							"subjectID":subjectID,
							"subjectTitle": subjectTitle,
							"isOfficial": isOfficial
						}
						topicSubjectList.push(subjectData);
						if (!in_array($topicID, outSubjectArr)) {
							outSubjectArr.push($topicID);
						}
					} else if ($dataType == 7) {
						selectTopicArr.push($topicID);
					} else if ($dataType == 8) {
						reserveTopicArr.push($topicID);
					}
				});  
			} else { //未选择处理方式
				unselectArr.push($topicID);
			}
		});
		
		if (highTopicArr.length < 1 && passTopicArr.length < 1 && lowTopicArr.length < 1 && badTopicArr.length < 1 && topicSubjectList.length < 1 && selectTopicArr.length < 1 && reserveTopicArr.length < 1) {
			alert("未勾选内容！");
			return false;
		}
			
		if (unselectArr.length > 0) {
			if (checkBtn == "batch-check") {
				passTopicArr = passTopicArr.concat(unselectArr);
			}
		}
		
		var ok = window.confirm('提交的任务如下：\n' 
		+ "\n优质:\n" + highTopicArr
		+ "\n通过:\n" + passTopicArr
		+ "\n低质:\n" + lowTopicArr
		+ "\n劣质:\n" + badTopicArr
		+ "\n移出专题:\n" + outSubjectArr
		+ "\n精选:\n" + selectTopicArr
		+ "\n预约精选:\n" + reserveTopicArr
		);
		
		if (ok) {
			var postdata = {
				"highTopicArr": highTopicArr,
				"passTopicArr": passTopicArr,
				"lowTopicArr": lowTopicArr,
				"badTopicArr": badTopicArr,
				"outSubjectArr": outSubjectArr,
				"pageState": <?=is_integer($state) ? $state : 10?>,
				"subjectID": <?=empty($subjectID) ? 0 : $subjectID?>,
				"topicSubjectList": topicSubjectList,
				"selectTopicArr" : selectTopicArr,
				"reserveTopicArr" : reserveTopicArr
			};
			
			//console.log(postdata);
			
			$.post("/topic/checkTopicBatch", postdata, function(rtnData) {
				alert('处理结果：' 
				+ "\n\n优质:" + parseResult2Str(rtnData.r1)
				+ "\n\n通过:" + parseResult2Str(rtnData.r2)
				+ "\n\n低质:" + parseResult2Str(rtnData.r3)
				+ "\n\n劣质:" + parseResult2Str(rtnData.r4)
				+ "\n\n移出专题:" + parseResult2Str(rtnData.r5)
				+ "\n\n精选:" + parseResult2Str(rtnData.r6)
				+ "\n\n预约精选:" + parseResult2Str(rtnData.r7)
				);
				
				window.location.reload();
			});
		}
	});
	
	//回到顶部
	scrollPageTop.init(document.getElementById("batch-gototop"));
	
	var $floatRightSidle = $("#floatRightSidle");
	var dif = 0, clientX = 0, pageWidth = 0, isShow = false;
	
	$(document).on("mousemove", function(e) {
		clientX = e.clientX;
		pageWidth = $(document).width();
		dif = pageWidth - clientX;
		
		//console.log("isShow:" + isShow + ";dis: " + (pageWidth - clientX));
		
		if (dif <= pageWidth / 6 || dif <= 120) { //显示
			if (isShow == false) {
				isShow = true;
				$floatRightSidle.show();
			}
		} else {
			if (isShow == true) {
				isShow = false;
				$floatRightSidle.hide();
			}
		}
	});
	
	$("input[data-type='7']").change(function(){
		var checked = $(this).attr("checked");
		var id = $(this).attr("data-id")
		if (checked == "checked") {
			$("#checkBoxReserve-" + id).attr("disabled", true);
		} else {
			$("#checkBoxReserve-" + id).attr("disabled", false);
		}
	});
	
	$("input[data-type='8']").change(function(){
		var checked = $(this).attr("checked");
		var id = $(this).attr("data-id")
		if (checked == "checked") {
			$("#checkBoxSelect-" + id).attr("disabled", true);
		} else {
			$("#checkBoxSelect-" + id).attr("disabled", false);
		}
	});
	
})(jQuery);
</script>
</body>
</html>

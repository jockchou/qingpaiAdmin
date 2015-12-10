<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
    	<?php
            if (isset($_GET['beginTime']) && isset($_GET['endTime'])) {
                 $commonUrl = "{$pathURL}?userID={$userID}&keyword={$keyword}&beginTime=".$_GET['beginTime']."&endTime=".$_GET['endTime'];
            } else {
                 $commonUrl = "{$pathURL}?userID={$userID}&keyword={$keyword}";
            }
			if(isset($_GET['subjectID'])){
				 $subjectID = $_GET['subjectID'];
			}else{
				 $subjectID = '';
			}
            //不包含时间字段
            $commonUrlNoTime = "{$pathURL}?userID={$userID}&keyword={$keyword}";
        ?>
    	<div class="btn-group">
    	    <?php if(!empty($state) OR $state === "0"):?>
			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=JY_getStateName($state);?><span class="caret"></span></button>
			<?php else:?>
			<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
			<?php endif;?>
        	<ul class="dropdown-menu">
                <!--设置 state-->
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&subjectID=<?=$subjectID?>">所有帖子</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&state=0&subjectID=<?=$subjectID?>">未审核</a></li>
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&state=-3&subjectID=<?=$subjectID?>">可疑</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&state=1&subjectID=<?=$subjectID?>">审核已通过</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&state=-1&subjectID=<?=$subjectID?>">审核不通过</a></li>
        	</ul>
    	</div>
    	
    	<div class="btn-group">
    		<?php if(!empty($type) OR $type === "0"):?>
					<button data-toggle="dropdown" class="btn dropdown-toggle"><?=JY_getTypeName($type);?><span class="caret"></span></button>
			<?php else:?>
			<button data-toggle="dropdown" class="btn dropdown-toggle">选择类型<span class="caret"></span></button>
			<?php endif;?>
        	<ul class="dropdown-menu" >
                <!--设置 type-->
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&subjectID=<?=$subjectID?>">所有类型</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&type=0&subjectID=<?=$subjectID?>">纯文本</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&type=1&subjectID=<?=$subjectID?>">图文</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&type=2&subjectID=<?=$subjectID?>">音频</a></li>
        		<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&type=3&subjectID=<?=$subjectID?>">视频</a></li>
        	</ul>
    	</div>

        <div class="btn-group">
            <?php if(!empty($highQuality) OR $highQuality === "0"):?>
            <button data-toggle="dropdown" class="btn dropdown-toggle" ><?=JY_getHighQualityName($highQuality);?><span class="caret"></span></button>
            <?php else:?>
            <button data-toggle="dropdown" class="btn dropdown-toggle">选择优质<span class="caret"></span></button>
            <?php endif;?>
            <ul class="dropdown-menu" id="selectQuality">
                <!--设置 highQuality-->
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&heatOrder=<?=$heatOrder?>&subjectID=<?=$subjectID?>">所有</a></li>
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&heatOrder=<?=$heatOrder?>&highQuality=0&subjectID=<?=$subjectID?>">未优质</a></li>
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&heatOrder=<?=$heatOrder?>&highQuality=1&subjectID=<?=$subjectID?>">已优质</a></li>
				<li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&heatOrder=<?=$heatOrder?>&highQuality=-1&subjectID=<?=$subjectID?>">低质</a></li>
			</ul>
        </div>
    	
        <div class="btn-group">
            <?php if(!empty($heatOrder) OR $heatOrder === "0"):?>
            <button data-toggle="dropdown" class="btn dropdown-toggle"><?=JY_getHeatOrderName($heatOrder);?><span class="caret"></span></button>
            <?php else:?>
            <button data-toggle="dropdown" class="btn dropdown-toggle">选择热度排序<span class="caret"></span></button>
            <?php endif;?>
            <ul class="dropdown-menu">
                <!--设置 heatOrder-->
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&highQuality=<?=$highQuality?>&subjectID=<?=$subjectID?>">所有</a></li>
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=1&subjectID=<?=$subjectID?>">按照热度倒序</a></li>
                <li><a href="<?=$commonUrl?>&stickerID=<?=$stickerID?>&state=<?=$state?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=0&subjectID=<?=$subjectID?>">按照热度顺序</a></li>
            </ul>
        </div>

        <div id="locationHref" style="display: none;" data-href="<?=$commonUrlNoTime?>&state=<?=$state?>&type=<?=$type?>&highQuality=<?=$highQuality?>&heatOrder=<?=$heatOrder?>&subjectID=<?=$subjectID?>"></div>

        <input type="text" style="margin-bottom:0; text-align:center; width: 119px;" name="beginTime" readonly="readonly" id="beginTime" class="commonPubTime-Ymd span2" value="<?=isset($_GET['beginTime']) && !empty($_GET['beginTime']) ? $_GET['beginTime'] : '开始时间'?>">
        至
        <input type="text" style="margin-bottom:0; text-align:center; width: 119px;" name="endTime" readonly="readonly" id="endTime" class="commonPubTime-Ymd span2" value="<?=isset($_GET['endTime']) && !empty($_GET['endTime']) ? $_GET['endTime'] : '结束时间'?>">

    	<form style="display:inline-block;" action="<?=$pathURL?>" method="get">
    		<input style="margin-bottom: 0;" name="userID" type="text" placeholder="搜索userID" value="<?=$userID?>"/>
    		<button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
		</form>
	</div>
</div>

<?php
	function getSubjectTitle($simpleSubjectList, $subjectID) {
		if (is_array($simpleSubjectList)) {
			foreach ($simpleSubjectList as $subject) {
				if ($subject['subjectID'] == $subjectID) {
					return $subject['title'];
				}
			}
		}
	}

?>

<?php foreach($topicList as $gidx => $groupList):?>
<div class="row-fluid">
	<?php foreach($groupList as $idx => $item):?>
		
	<div class="span3" id="<?=$item['id']?>">
		<div class="widget-box pingo-box" data-subid="<?=$item['subjectID']?>" data-id="<?=$item['id']?>">
			<div class="widget-title">
				<span class="icon"><i class="<?=JY_getTypeClass($item['type']);?>"></i></span>
				<span class="icon">ID:<a href="/comport/getComment?id=<?=$item['id']?>"><?=$item['id']?></a></span>
				<span class="icon" style="border-right:none;">U:<a href="/jjuser/jjuserList?userID=<?=$item['userID']?>"><?=$item['userID']?></a></span>
        	</div>
        	<div class="widget-content pingo-block">
        		<?php if($item['type'] == "0"):?>
        		<p><?=$item['content']?></p>
        		<?php elseif($item['type'] == "1"):?>
        			<?php if ($item['state'] >= 0 OR $item['state'] == -3):?>
        			<img src="<?=$item['resUrl']?>?imageView2/2/w/200" alt="img-<?=$item['id']?>">
        			<?php elseif($item['state'] == -1):?>
        			<img src="/static/img/del_state.jpg" alt="img-<?=$item['id']?>" >
        			<?php endif;?>
        		<p><?=$item['content']?></p>
        		<?php elseif($item['type'] == "2"):?>
        		<p style="text-align:center;">
        			<button class="voicePlay btn btn-inverse icon-volume-up"></button>
        			<audio src="<?=$item['resUrl']?>"></audio>
        		</p>
        		<?php elseif($item['type'] == "3"):?>
        		
        		<?php if ($item['state'] >= 0 OR $item['state'] == -3):?>
        		<video src="<?=$item['resUrl']?>" controls="controls" height="80%" width="80%"></video>
        		<p><?=$item['content']?></p>
        		<?php elseif($item['state'] == -1):?>
        		<img src="/static/img/del_state.jpg" alt="img-<?=$item['id']?>">
        		<?php endif;?>
        		
        		<?php else:?>
        		<?php endif;?>
        		
        	</div>
        	
        	<div class="widget-title">
                <span class="icon" style="border-right:none;">热:<?=$item['heat']?> | 赞:<?=$item['praise']?> | S:<?=$item['state']?> | Q:<?=$item['highQuality']?> </span>
            </div>
            
			<?php
				$simpleSubjectList = null;
				if (!empty($item['simpleSubjectJson'])) {
					$simpleSubjectList = json_decode($item['simpleSubjectJson'], TRUE);
				}
			?>
			
            <?php if ($subjectID > 0):?>
            <div class="widget-title">
                <span class="icon" style="border-right:none;">SID: <?=$subjectID?> | <?="#" . getSubjectTitle($simpleSubjectList, $subjectID) . "#"?></span>
            </div>
			<?php elseif($item['subjectID'] != 0):?>
			<div class="widget-title">
                <span class="icon" style="border-right:none;">SID: <?=$item['subjectID']?> | <?="#" . $item['subjectTitle'] . "#"?></span>
            </div>
			<?php else:?>
			<div class="widget-title">
                <span class="icon" style="border-right:none;">SID: <?=$simpleSubjectList[0]['subjectID']?> | <?="#" . $simpleSubjectList[0]['title'] . "#"?></span>
            </div>
            <?php endif;?>
            <div class="widget-title">
                <span class="icon" style="border-right:none;"><?=date('m月d日   H:i:s', substr($item['pubTime'], 0, 10));?></span>
                <span class="icon" style="border-right:none;"> 
	            	<?php if($item['state'] == "-1"):?>
		            	<a target="_blank" data-url="<?=$item['resUrl']?>" href="http://7sby80.com1.z0.glb.clouddn.com/<?=getKeyFromUrl($item['resUrl']);?>">查看原图</a>
	            	<?php endif;?>
            	</span>
            </div>
			
			<?php
				$qType = "0";
				$qName = "";
				if ($item['state'] != 0) {
					if ($item['state'] == -1) {
						$qType = "4"; //劣质
						$qName = "bad";
					} else if ($item['state'] == 1) { //优质，通过，或者低质
						if ($item['highQuality'] == 1) {
							$qType = "1"; //优质
							$qName = "high";
						} else if ($item['highQuality'] == -1) {
							$qType = "3"; //低质
							$qName = "low";
						} else {
							$qType = "2"; //通过
							$qName = "pass";
						}
					}
				} else {
					$qType = "0"; //未审核
				}
			?>
			
			<div class="widget-content" state="<?=$qName?>">
				<div class="controls checkTopicRadioGroup">
					<label><input data-id="<?=$item['id']?>" data-type="1" <?= $qType == "1" ? "checked" : ""?> id="check1Radio-<?=$item['id']?>" type="radio" name="checkRadio-<?=$item['id']?>" value="<?=$item['id']?>"/>优质</label>
					<label><input data-id="<?=$item['id']?>" data-type="2" <?= $qType == "2" ? "checked" : ""?> id="check2Radio-<?=$item['id']?>" type="radio" name="checkRadio-<?=$item['id']?>" value="<?=$item['id']?>"/>通过</label>
					<label><input data-id="<?=$item['id']?>" data-type="3" <?= $qType == "3" ? "checked" : ""?> id="check3Radio-<?=$item['id']?>" type="radio" name="checkRadio-<?=$item['id']?>" value="<?=$item['id']?>"/>低质</label>
					<label><input data-id="<?=$item['id']?>" data-type="4" <?= $qType == "4" ? "checked" : ""?> id="check4Radio-<?=$item['id']?>" type="radio" name="checkRadio-<?=$item['id']?>" value="<?=$item['id']?>"/>劣质</label>
				</div>
				<hr>
				<div class="controls checkTopicRadioGroup">
				<?php if (isset($item['isSelect']) && $item['isSelect']):?>
					<label><input data-id="<?=$item['id']?>" data-type="7" type="checkbox" checked id="checkBoxSelect-<?=$item['id']?>" />精选</label>
				<?php elseif (isset($item['isReserve']) && $item['isReserve']):?>
					<label><input data-id="<?=$item['id']?>" data-type="8" type="checkbox" checked id="checkBoxReserve-<?=$item['id']?>" />预约精选</label>
				<?php else:?>
					<label><input data-id="<?=$item['id']?>" data-type="7" type="checkbox" id="checkBoxSelect-<?=$item['id']?>" />精选</label>
					<label><input data-id="<?=$item['id']?>" data-type="8" type="checkbox" id="checkBoxReserve-<?=$item['id']?>" />预约精选</label>
				<?php endif;?>
				</div>
				<hr>
				<div class="controls checkTopicRadioGroup">	
				<?php if (!empty($simpleSubjectList)):?>
					<?php foreach ($simpleSubjectList as $simpleSubject):?>
						<label><input data-id="<?=$item['id']?>" data-type="6" id="check5Radio-<?=$item['id']?>" type="checkbox" name="checkRadioSub-<?=$item['id']?>" subjectID="<?=$simpleSubject['subjectID']?>" subjectTitle="<?=$simpleSubject['title']?>" isOfficial="<?=$simpleSubject['isOfficial']?>"/>移除(<?=$simpleSubject['title']?>)</label>
					<?php endforeach;?>
				<?php endif;?>
				</div>
				<!--<p style="margin-top:10px;"><button class="checkTopicSingle btn btn-mini">单个审核</button></p>-->
			</div>
        </div>
	</div>
	<?php endforeach;?>
</div>
<?php endforeach;?>
<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>

<div id="floatRightSidle" class="widget-box floatRightSidle">
  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    <h5>操作</h5>
  </div>
  <div class="widget-content">
  	  <button id="select-check" class="btn btn-info" style="display:block;">处理已选</button>
  	  <button id="batch-check" class="btn btn-danger" style="display:block; margin-top:20px;">处理整页</button>
      <button id="batch-gototop" class="btn btn-success" style="margin-top:20px;">返回顶部</button>
  </div>
</div>        
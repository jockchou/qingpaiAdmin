<div class="widget-box" >
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
    	<?php $commonUrl = $pathURL;?>
		<br>
	</div>
	<?php foreach($topicList as $gidx => $groupList):?>
	<div class="row-fluid">
	<?php foreach($groupList as $idx => $item):?>
		
	<div class="span3" id="<?=$item['id']?>">
		<div class="widget-box pingo-box" style="border-style:solid; border-width:1px; border-color:gray;border-radius:8px;-moz-border-radius:8px;-webkit-border-radius:8px;-o-border-radius:8px;}">
			<div class="widget-title" style="background-color:#F0F0F0;filter:alpha(Opacity=80);-moz-opacity:0.8;opacity: 0.8;">
				<span class="icon"><i class="<?=JY_getTypeClass($item['type']);?>"></i></span>
				<span class="icon">ID:<?=$item['id']?></span>
				<span class="icon" style="border-right:none;">UID:<a href="/jjuser/jjuserList?userID=<?=$item['userID']?>"><?=$item['userID']?></a></span>
				<span> 
            	<?php if($item['state'] == "-1"):?>

            		<?php if($item['checkTime'] > '2015-02-10 10:44'):?>
	            	<a target="_blank" href="http://7sby80.com1.z0.glb.clouddn.com/<?=getKeyFromUrl($item['resUrl']);?>">
	            	<?php else:?>
	            	<a target="_blank" href="<?=$item['resUrl']?>">
	            	<?php endif;?>
	            	<button id="showoldpic" class="btn btn-danger btn-small" style="background-color:#FF6666;  margin-top: 4px;right: 11px;position: absolute;" name="<?php echo $item['id'];?>" state="1">原图</button></a>
            	<?php endif;?>
            	</span>
        	</div>
        	<div class="widget-content pingo-block" id="<?=$item['id']?>" style="height:366px">
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
        		<video src="<?=$item['resUrl']?>" controls="controls" height="100%" width="100%"></video>
        		<?php elseif($item['state'] == -1):?>
        		<img src="/static/img/del_state.jpg" alt="img-<?=$item['id']?>">
        		<?php endif;?>
        			
        		
        		<?php else:?>
        		<?php endif;?>
        	</div>
            <div class="widget-title">
                <span class="icon" style="border-right:none;">时间:<?=date('m月d日   H:i:s', substr($item['pubTime'], 0, 10));?></span>
                <?php
                    if ($item['heat'] > 0) {
                        $heatHtml = '<font color="#FF9B05">' . $item['heat'] . '</font>';
                    } else {
                        $heatHtml = $item['heat'];
                    }
                ?>
                <span class="icon" style="border-right:none;">热度: <?=$heatHtml?></span>
            	
            </div>
			
			<div class="widget-content" style="white-space:nowrap;width:90%;padding:8px;">
				<!--优质，通过，低质，拒绝-->
				
				
				</div>
				

        </div>
	</div>
	<?php endforeach;?>
</div>
<?php endforeach;?>

<div id="floatbt"  style="position:fixed;bottom:100px;right:20px;z-index:999; background-color:#FFFFFF;opacity:0.8;filter:alpha(opacity=50);width:60px;" >
	<button id="simple-check" class="btn btn-danger btn-large">单个移除</button>
	<button id="batch-gototop" class="btn btn-success btn-large">返回顶部</button>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>

<!--<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content" >
    	
	</div>
</div>-->

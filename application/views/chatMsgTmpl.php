<p id="msg-<?=$topicID?>" class="user-linda" style="display:block;width:40%;<?php if($user['id'] == 10086) echo 'margin-left: 55%';?>">
	<span class="msg-block" style="border-radius:10px; left:25px;">
    	<img class="userhead" src="<?=$user['headUrl']?>" alt=""><strong><?=$user['nickname']?></strong> 
    	<span class="time"><?=JY_timeFormat($pubTime)?></span>
    	<?php if(isset($resUrl) && $resUrl != ""):?>
    	<span class="msg"><img alt="img" src="<?=$resUrl?>" width="100px"></span>
    	<?php else:?>
    	<span class="msg"><?=$content?></span>
    	<?php endif;?>
    	
	</span>
</p>

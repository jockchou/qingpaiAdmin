<div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-chat">
          <div class="widget-title"> <span class="icon"> <i class="icon-comment"></i> </span>
            <h5>Let's do a chat</h5>
          </div>
          <div class="widget-content nopadding">
            <div class="chat-users panel-right2">
              <div class="panel-title">
                <h5><img src="<?=$toUser['headUrl']?>" width="32"> 正在与[<?=$toUser['nickname']?>]私聊</h5>
              </div>
              <div class="panel-content nopadding">
                  <ul class="contact-list">
                  <?php foreach($followList as $index => $item):?>
                  <li id="user-<?=$item['followUserID']?>" class="<?=$item['followUserID'] == $toUserID ? "offline" : "online"?>"><a href="/message/chatHome?toUserID=<?=$item['followUserID']?>"><img alt="<?=$item['nickname']?>" src="<?=$item['headUrl']?>"> <span><?=$item['nickname']?></span></a></li>
                  <?php endforeach;?>
                </ul>
              </div>
            </div>
            <div class="chat-content panel-left2">
              <div class="chat-messages" id="chat-messages">
                <div id="chat-messages-inner">
                	<?php foreach($messageList as $index => $item):?>
	                <p id="msg-<?=$item['topicID']?>" class="user-linda" style="display: block;">
	                	<span class="msg-block">
		                	<img class="userhead" src="<?=$item['headUrl']?>" alt=""><strong><?=$item['nickname']?></strong> 
		                	<span class="time"><?=JY_timeFormat($item['pubTime'])?></span>
		                	
		                	<?php if ($item['type'] == '0'):?>
		                	<span class="msg"><?=$item['content']?></span>
		                	<?php elseif($item['type'] == '1'):?>
		                	<span class="msg"><?=$item['content']?></span><br/>
		                	<img width="120" src="<?=$item['resUrl']?>" alt="">
		                	
		                	<?php elseif($item['type'] == '2'):?>
		                	<span class="msg"><a target="_blank" href="<?=$item['resUrl']?>">[发来一段录音]</a></span>
		                	<?php else:?>
		                	<span class="msg"><?=$item['content']?></span><br/>
		                	<video src="<?=$item['resUrl']?>" controls="controls" width="240"></video>
		                	<?php endif;?>
		                	
	                	</span>
	                </p>
	                <?php endforeach;?>
	                
	                <?php if (empty($toUserID)):?>
	                <p class="offline" id="msg-0" style="display:block;color:red;"><span>请选择联系人</span></p>
	                <?php endif;?>
              </div>
              </div>
	              <div class="chat-message well">
	                	<button id="sendBtn" class="btn btn-success">Send</button>
		                <span class="input-box">
		                	<input type="text" data-to="<?=$toUserID?>" name="msg-box" id="msg-box">
		                </span>
	             </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
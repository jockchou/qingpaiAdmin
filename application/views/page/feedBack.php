<?php 
			require_once(dirname(dirname(dirname(__FILE__))) .  DIRECTORY_SEPARATOR . 'third_party'. DIRECTORY_SEPARATOR . 'qiniu' . DIRECTORY_SEPARATOR . 'rs.php');
			$accessKey = 'pU2VbLy6emWXs5x8Kxy2ZIKFtCHID-ghDimXM9tl';  //换成你自己的密钥
			$secretKey = '3N2Ngow0rsEFiJzK6EoHPljza3iP55GtTwsv2WyF';    //换成你自己的密钥
			Qiniu_SetKeys($accessKey, $secretKey);
		
			$bucket = 'qpsticker';
			$putPolicy = new Qiniu_RS_PutPolicy($bucket);
		
			$upToken = $putPolicy->Token(null);
?>
<div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box widget-chat">
          <div class="widget-title"> <span class="icon"> <i class="icon-comment"></i> </span>
            <h5>Let's do a chat</h5>
          </div>
          <div class="widget-content nopadding">
            <div class="chat-users panel-right2" style="width:200px;">
            	<div class="widget-title" align="center">
            	
            	<a href="/message/feedBack?state=0">
            		<button class="btn btn-success" style="margin-top:3px;background-color:<?php if($state == 0)echo 'red';?>">未读消息</button>
            	</a>
            	<a href="/message/feedBack?state=1">
            		<button class="btn btn-success" style="margin-top:3px;background-color:<?php if($state == 1)echo 'red';?>">已读消息</button>
            	</a>
            	</div>
              <div class="panel-title">
              	<?php if(!empty($toUser)):?>
                <h5><img src="<?=$toUser['headUrl']?>" width="32"> 正在与[<?=$toUser['nickname']?>]私聊</h5>
              	<?php endif;?>
              </div>
              <div class="panel-content nopadding">
                  <ul class="contact-list">
                  <?php foreach($userList as $index => $item):?>
                  <li id="user-<?=$item['id']?>" class="<?=$item['id'] == $toUserID ? "offline" : "online"?>"><a href="/message/feedBack?toUserID=<?=$item['id']?>&state=<?=1?>"><img alt="<?=$item['nickname']?>" src="<?=$item['headUrl']?>"> <span><?=$item['nickname']?></span></a></li>
                  <?php endforeach;?>
                  <?php if($state == 0):?>
                  <li><a href="/message/feedBack?state=0&toUserID=<?=$toUserID?>"><button class="btn btn-success" style="width:100%">刷新</button></a></li>
                  <?php endif;?>
                </ul>
              </div>
              
            </div>
            
            
            <div class="chat-content panel-left2">
              <div class="chat-messages" id="chat-messages">
                <div id="chat-messages-inner">
                	<?php foreach($messageList as $index => $item):?>
	                <p id="msg-<?=$item['topicID']?>"  class="user-linda" style="display: block;width:40%;<?php if($item['user']['id'] == 10086) echo 'margin-left: 55%';?>">
	                	<span class="msg-block" style="border-radius: 10px;left: 25px;">
		                	<img class="userhead" src="<?=$item['user']['headUrl']?>" alt=""><strong><?=$item['user']['nickname']?></strong> 
		                	<span class="time"><?=JY_timeFormat($item['pubTime'])?></span>
		                	<?php if ($item['type'] == '0'):?>
		                	<span class="msg" style="display:block;overflow:auto;word-break:break-all;"><?=$item['content']?></span>
		                	<?php elseif($item['type'] == '1'):?>
		                	<span class="msg"><img width="120" src="<?=$item['resUrl']?>" alt=""></span>
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
	              <div class="chat-message well" style="float:left;width:70%;margin-left:25px;">
	                <button id="sendBtn" class="btn btn-success">Send</button>
		            <span class="input-box">
		                <input type="text" data-to="<?=$toUserID?>" name="msg-box" id="msg-box">
		            </span>
	             </div>
	             <div style="float:right;position:absolute;right:30px;bottom:20px;">
	             	<form method="post" target="id_iframe" action="http://up.qiniu.com" name = "form" enctype="multipart/form-data">
		  
						<input type="hidden"  id="token" name="token"  value=<?php echo $upToken?>>
						<input type="hidden" name="key" id="key" value="">
				
						<img id="pic" src="" alt="img" width="100" style="display:none">
				
						<input id="file_input" name="file" type="file" onchange="javascript:setValue(this.value)" style="width:69px;"/>
				
						<input class="btn btn-success" type="submit" value="提交" id="submit" style="display:none" onclick="javascript:setPic()">
					</form>
					<iframe id="id_iframe"  name="id_iframe" style="display:none;"></iframe> 
				</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
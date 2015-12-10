<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
		<h5>操作</h5>
	</div>
	<div class="widget-content">
		<a href="/message/chatHome?toUserID=<?=$rpUserID?>" class="btn btn-primary">私聊</a>
		<?php if ($stateInfo['state'] == 0):?>
		<a href="javascript:void(0);" class="btn btn-danger block-user" data-id="<?=$rpUserID?>">封禁</a>
		<?php else:?>
		<a href="javascript:void(0);" class="btn btn-danger unblock-user" data-id="<?=$rpUserID?>">解封</a>
		<?php endif;?>
	</div>
</div>

<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-th"></i></span>
		<h5>被举报用户私聊信息列表</h5>
	</div>
	<div class="widget-content">
		<div class="container-fluid">
			<div class="row-fluid">
				<fieldset>
				<?php foreach ($charContentList as $key => $item):?>
				
				<?php
					$msgData = json_decode($item['mBody'], TRUE);
				?>
				<?php if (!empty($msgData['content'])):?>
					<span  class="badge badge-info" id="content_<?=$key?>"></span>
				<?php elseif (empty($msgData['content']) && $msgData['type'] == 2 && $msgData['resUrl'] != ""):?>
					<span  class="badge badge-warning">语音(无法播放)</span>
				<?php endif;?>
				<?php endforeach;?>
				</fieldset>
				
				<fieldset>
				<?php foreach ($charContentList as $item):?>
					<?php
					$msgData = json_decode($item['mBody'], TRUE);
					?>
					<?php if (empty($msgData['content']) && $msgData['type'] == 1 && $msgData['resUrl'] != ""):?>
					<div class="span2">
						<img src='<?=$msgData['resUrl']?>'/>
					</div>
					<?php endif;?>
				<?php endforeach;?>
				</fieldset>
			</div>
		</div>
	</div>
</div>
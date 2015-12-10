<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>配置贴纸抽奖活动</h5>
        </div>

        <div class="widget-content nopadding">
            <form id="user-form-add" action="/beauty/stickerActivitySave" class="form-horizontal" enctype="multipart/form-data" method="post">
            	<input class="span3" name="stickerID" type="hidden" value="<?=$stickerID?>">
            	<?php if(isset($actiInfo['id'])):?>
            	<input class="span3" name="activityID" type="hidden" value="<?=$actiInfo['id']?>">
            	<?php endif;?>
            	
                <div class="control-group">
                    <label class="control-label">活动标题:</label>
                    <div class="controls">
                        <input class="span3" name="title" type="text" autofocus="true" required value="<?=isset($actiInfo['title']) ? $actiInfo['title'] : ""?>">
                    </div>
                </div>
                
	            <div class="control-group">
	              <label class="control-label">活动简介: </label>
	              <div class="controls">
	              		<textarea name="content" class="span8"><?=isset($actiInfo['content']) ? $actiInfo['content'] : ""?></textarea>
	              </div>
	            </div>
                
                <?php if(!isset($actiInfo['posterUrl'])):?>
	            <div class="control-group">
	              <label class="control-label">活动海报:</label>
	              <div class="controls">
	                <input name="imageFile" type="file" required/>(限制256K)
	              </div>
	            </div>
	            <?php else:?>
	           	<div class="control-group">
	              <label class="control-label">活动海报:</label>
	              <div class="controls">
	                <img width="300" src="<?=$actiInfo['posterUrl']?>" alt="海报">
	              </div>
	            </div>
	            
	            <div class="control-group">
	              <label class="control-label">重传海报:</label>
	              <div class="controls">
	                <input name="imageFile" type="file"/>(限制256K)
	              </div>
	            </div>
	            <?php endif;?>
                <div class="form-actions">
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
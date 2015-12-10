<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加贴纸</h5>
        </div>

        <div class="widget-content nopadding">
            <form id="user-form-add" action="/sticker/stickerSave" class="form-horizontal" enctype="multipart/form-data" method="post">
            	<?php if (isset($sticker)):?>
            	<input name="stickerID" type="hidden" value="<?=$sticker['id']?>">
            	<?php endif;?>
                <div class="control-group">
                    <label class="control-label">名称:</label>
                    <div class="controls">
                        <input class="span3 tagsName" name="stickerName" placeholder="贴纸名称" type="text" autofocus="true" value="<?=isset($sticker) ? $sticker['name'] : ""?>" required><font color="red"> *</font>必填
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">贴纸类别:</label>
                    <div class="controls">
                       <select id="categoryId" name="categoryId" class="span3">
              			 <?php foreach($categoryIDList as $categoryID): ?>
              			 	<?php if(isset($sticker) && $categoryID['id'] == $sticker['categoryID']):?>
                		 	<option value="<?=$categoryID['id']?>" selected="selected"><?=$categoryID['id']?> <?=$categoryID['title']?> </option>
              			 	<?php else:?>
              			 	<option value="<?=$categoryID['id']?>"><?=$categoryID['id']?> <?=$categoryID['title']?></option>
              			 	<?php endif;?>
              			 <?php endforeach;?>
            		   </select>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">排序值:</label>
                    <div class="controls">
                        <input class="span3 tagsName"  name="orderVal" value="<?=isset($sticker) ? $sticker['orderVal'] : "0"?>" placeholder="排序值(例:50)" type="text" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">标签:</label>
                    <div class="controls">
                        <select name="tag" class="span3" required>
                        	<?php if(isset($sticker)):?>
                        	<option value="0" <?=$sticker['tag'] == 0 ? "selected": ""?>>无标签</option>
                            <option value="1" <?=$sticker['tag'] == 1 ? "selected": ""?>>NEW</option>
                            <option value="2" <?=$sticker['tag'] == 2 ? "selected": ""?>>奖</option>
                        	<?php else:?>
                            <option value="0">无标签</option>
                            <option value="1">NEW</option>
                            <option value="2">奖</option>
                            <?php endif;?>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
	              <label class="control-label">标签上线时间:</label>
	              <div class="controls">
	                <input type="text" name="startTime" readonly="readonly" class="commonPubTime span3" value="<?=isset($sticker) ? $sticker['tagStartTime'] : ""?>">
	              </div>
	            </div>
	            
	            <div class="control-group">
	              <label class="control-label">标签下线时间:</label>
	              <div class="controls">
	                <input type="text" name="endTime" readonly="readonly" class="commonPubTime span3" value="<?=isset($sticker) ? $sticker['tagEndTime'] : ""?>">
	              </div>
	            </div>
	            
	            <?php if(isset($sticker)):?>
	            <div class="control-group" id="showpic">
	              <label class="control-label">图片 :</label>
	              <div class="controls">
	                <img id="pic" src="<?=$sticker['imageUrl']?>" alt="img" width="100">
	              </div>
	            </div>
	            <?php else:?>
	            <div class="control-group" id="showpic" style="display:none">
	              <label class="control-label">图片 :</label>
	              <div class="controls">
	                <img id="pic" src="" alt="img" width="100">
	              </div>
	            </div>
	            <?php endif;?>
	            
	            <div class="control-group">
	              <label class="control-label">上传图片 :</label>
	              <div class="controls">
	                <input id="file_input" name="imageFile" type="file" <?isset($sticker) ? "required" : ""?>/>(限制256K)
	              </div>
	            </div>
	            
	            <div class="control-group">
	              <label class="control-label">上线时间:</label>
	              <div class="controls">
	                <input type="text" name="onlineTime" readonly="readonly" class="commonPubTime span3" value="<?=isset($sticker) ? $sticker['onlineTime'] : date("Y-m-d H:i:s")?>" required>
	              </div>
	            </div>
	            
	            <div class="control-group">
	            	<label class="control-label">设置:</label>
	            	<div class="controls">
	            		<?php if(isset($sticker['isHot']) && $sticker['isHot'] == 1):?>
	            		<input type="checkbox" name="hotTopic" value="1" checked="checked"> 
	            		<?php else:?>
	            		<input type="checkbox" name="hotTopic" value="1"> 
	            		<?php endif;?>
	            		热门
	            	</div>
	            </div>
	            
	            <div class="control-group">
	              <label class="control-label">话题title:</label>
	              <div class="controls">
	              	<?php if(isset($sticker['subjectTitle'])):?>
					<input class="span3 tagsName" type="text" name="subjectTitle" value="<?=$sticker['subjectTitle']?>"> 
					<?php else:?>
					<input class="span3 tagsName" type="text" name="subjectTitle" value="" maxlength="8"> (8个字内) 
					<?php endif;?>
	              </div>
	            </div>
				
				<div class="control-group">
					<label class="control-label">是否全屏:</label>
					<div class="controls">
						<?php if(isset($sticker['isFullScreen']) && $sticker['isFullScreen'] == 1):?>
						<input type="checkbox" name="isFullScreen" value="1" checked="checked"/>
						<?php else:?>
						<input type="checkbox" name="isFullScreen" value="1"/>
						<?php endif;?>
					</div>
	            </div>
	            
                <div class="form-actions">
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
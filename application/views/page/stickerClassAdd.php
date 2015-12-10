<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加贴纸分类</h5>
        </div>

        <div class="widget-content nopadding">
				<form id="user-form-add" action="/sticker/stickerClassSave" class="form-horizontal" enctype="multipart/form-data" method="post">
	            <?php if (isset($sticker)):?>
	            	<input name="stickerID" type="hidden" value="<?=$sticker['id']?>">
	            <?php endif;?>
                <div class="control-group">
                    <label class="control-label">名称:</label>
                    <div class="controls">
                        <input class="span3 tagsName" name="title" placeholder="贴纸名称" type="text" autofocus="true" value="<?=isset($sticker) ? $sticker['title'] : ""?>" required>
                    </div>
                </div>
                
                
	            <?php if(isset($sticker)):?>
	            <div class="control-group" id="showpic">
	              <label class="control-label">图片 :</label>
	              <div class="controls">
	                <img id="pic" src="<?=$sticker['iconUrl']?>" alt="img" width="100">
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
                    <label class="control-label">排序值:</label>
                    <div class="controls">
                        <input class="span3 tagsName"  name="orderVal" value="<?=isset($sticker) ? $sticker['orderVal'] : "0"?>" placeholder="排序值(例:50)" type="text" required>
                    </div>
                </div>
	            
	            
<!--	            <div class="control-group">-->
<!--	            	-->
<!--	              <label class="control-label">上线时间:</label>-->
<!--	              -->
<!--	              <div class="controls">-->
<!--	                <input type="text" name="onlineTime" readonly="readonly" class="commonPubTime span3" value="<?=isset($sticker) ? $sticker['addTime'] : date("Y-m-d H:i:s")?>" required>-->
<!--	              </div>-->
<!--	            </div>-->
	            
                <div class="form-actions">
                	<?php if(isset($sticker)):?>
                	<button id="device-add-submit" class="btn btn-success" type="submit">更新</button>
                	<?php else:?>
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                	<?php endif;?>
                </div>
            </form>
        </div>
    </div>
</div>
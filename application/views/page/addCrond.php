<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>编辑黄历</h5>
	    </div>
	    <div class="widget-content nopadding">
			<form action="/sticker/saveCrond" method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
					<label class="control-label">贴纸ID :</label>
					<div class="controls">
						<input type="text" class="span4" name="stickerID" value="<?=$stickerID?>" readonly="true"/>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">贴纸名称 :</label>
					<div class="controls">
						<input type="text" class="span4" name="name" value="<?=$sticker['name']?>" readonly="true"/>
					</div>
				</div>
				
				<div class="control-group" id="showpic">
					<label class="control-label">当前图片 :</label>
					<div class="controls">
						<img id="pic" src="<?=$sticker['imageUrl']?>" alt="img" width="100">
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">替换图片 :</label>
					<div class="controls">
						<input name="imageFile" type="file" required/><font color="red"> *(必填, 限制256K)</font> 
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">替换时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="actionTime" required value=""/><font color="red"> *(必填)</font>
					</div>
				</div>
				 
				<div class="form-actions">
					<button id='submit' type="submit" class="btn btn-success">保存</button>
				</div>
			 </form>
		</div>
	</div>
</div>
<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加贴纸</h5>
        </div>

        <div class="widget-content nopadding">
            <form id="user-form-add" action="/beauty/stickerSave" class="form-horizontal" enctype="multipart/form-data" method="post">
                <div class="control-group">
                    <label class="control-label">颜值贴纸名称:</label>
                    <div class="controls">
                        <input class="span3 tagsName" name="name" placeholder="贴纸名称" type="text" required><font color="red"> *</font>必填
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">颜值贴纸级别:</label>
                    <div class="controls">
                       <select id="gradeId" name="gradeID" class="span3">
              			 <?php foreach($gradeList as $grade): ?>
              			 	<option value="<?=$grade['id']?>"><?=$grade['id']?> <?=$grade['gradeName']?></option>
              			 <?php endforeach;?>
            		   </select>
                    </div>
                </div>
                
				<div class="control-group">
                    <label class="control-label">性别:</label>
                    <div class="controls">
                       <select id="sex" name="sex" class="span3">
              			 	<option value="0">男</option>
              			 	<option value="1">女</option>
            		   </select>
                    </div>
                </div>
				
                <div class="control-group">
                    <label class="control-label">标签:</label>
                    <div class="controls">
                        <select name="tag" class="span3" required>
                            <option value="0">无标签</option>
                            <option value="1">NEW</option>
                            <option value="2">奖</option>
                        </select>
                    </div>
                </div>
                
                <div class="control-group">
					<label class="control-label">标签上线时间:</label>
					<div class="controls">
						<input type="text" name="tagStartTime" readonly="readonly" class="commonPubTime span3" value="">
					</div>
				</div>
	            
	            <div class="control-group">
					<label class="control-label">标签下线时间:</label>
					<div class="controls">
						<input type="text" name="tagEndTime" readonly="readonly" class="commonPubTime span3" value="">
					</div>
	            </div>
	           
	            <div class="control-group" id="showpic" style="display:none">
					<label class="control-label">图片 :</label>
					<div class="controls">
						<img id="pic" src="" alt="img" width="100">
					</div>
	            </div>
	            
	            <div class="control-group">
					<label class="control-label">上传图片 :</label>
					<div class="controls">
						<input id="file_input" name="imageFile" type="file" required/><font color="red"> *</font>(限制256K)
					</div>
	            </div>
	            
	            <div class="control-group">
					<label class="control-label">上线时间:</label>
					<div class="controls">
						<input type="text" name="onlineTime" readonly="readonly" class="commonPubTime span3" value="" required>
					</div>
	            </div>
	            
	            <div class="control-group">
					<label class="control-label">话题title:</label>
					<div class="controls">
						<input class="span3 tagsName" type="text" name="subjectTitle" value="" maxlength="8"> (8个字内) 
					</div>
	            </div>
				
				<div class="control-group">
					<label class="control-label">文字中心X坐标:</label>
					<div class="controls">
						<input class="span3 tagsName" type="text" placeholder="像素值" name="textPosX" value="" required><font color="red"> *</font>
					</div>
	            </div>
				
				<div class="control-group">
					<label class="control-label">文字中心Y坐标:</label>
					<div class="controls">
						<input class="span3 tagsName" type="text" placeholder="像素值" name="textPosY" value="" required><font color="red"> *</font>
					</div>
	            </div>
				
				<div class="control-group">
					<label class="control-label">是否全屏:</label>
					<div class="controls">
						<input type="checkbox" name="isFullScreen" value="1"/>
					</div>
	            </div>
				
                <div class="form-actions">
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
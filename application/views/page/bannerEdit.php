<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>编辑Banner</h5>
	    </div>
	    <div class="widget-content nopadding">
			<form action="/banner/saveBanner" method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
					<label class="control-label">页面类型 :</label>
					<div class="controls" >
						<select name="pageType" class="span3">
							<option value="1">达人页</option>
							<option selected="selected" value="2">话题页</option>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">跳转类型 :</label>
					<div class="controls" >
						<select name="type" class="span3">
							<option selected="selected" value="1">H5页面</option>
							<option value="2">话题详情页</option>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">跳转URL :</label>
					<div class="controls">
						<input type="text" class="span4" name="jumpUrl" required value="" placeholder='url地址'/><font color="red"> *(必填)</font>
					</div>
				</div>
				
				<div class="control-group" id="showpic" style="display:none">
					<label class="control-label">预览 :</label>
					<div class="controls">
						<img id="pic" src="" alt="img" width="100">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">Banner图片 :</label>
					<div class="controls">
						<input id='file_input' name="imageFile" type="file" required/><font color="red"> *(必填, 限制256K)</font> 
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">上线时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="onlineTime" required value=""/><font color="red"> *(必填)</font>
					</div>
				</div>
				 
				<div class="form-actions">
					<button id='submit' type="submit" class="btn btn-success">保存</button>
				</div>
			 </form>
		</div>
	</div>
</div>
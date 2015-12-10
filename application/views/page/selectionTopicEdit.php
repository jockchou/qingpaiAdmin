<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>编辑精选帖子</h5>
	    </div>
	    <div class="widget-content nopadding">
			<form action="/selectionTopic/saveSelectionTopic" method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
					<label class="control-label">帖子ID :</label>
					<div class="controls">
						<input type="text" class="span3" name="topicID" required value=""/><font color="red"> *(必填)</font>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">插入位置 :</label>
					<div class="controls">
						<input type="text" class="span3" name="locIdx" required value=""/><font color="red"> *(必填, 1～50的整数)</font>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label">上线时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="onlineTime" required value=""/><font color="red"> *(必填)</font>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">失效时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="offlineTime" required value=""/><font color="red"> *(必填)</font>
					</div>
				</div>
				 
				<div class="form-actions">
					<button id='submit' type="submit" class="btn btn-success">保存</button>
				</div>
			 </form>
		</div>
	</div>
</div>
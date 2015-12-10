<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>闪屏</h5>
        </div>
        <div class="widget-content nopadding">
            <form action="/version/flashSave" class="form-horizontal" method="post" enctype="multipart/form-data">
            	<div class="control-group">
					<label class="control-label">上线时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="startTime" required/><font color="red"> *(必填)</font>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label">下线时间 :</label>
					<div class="controls commonPubTime">
						<input type="text" class="span3" name="endTime" required/><font color="red"> *(必填)</font>
					</div>
				</div>
                
                <div class="control-group">
					<label class="control-label">闪屏图片 :</label>
					<div class="controls">
						<input name="imageFile" type="file" required/><font color="red"> *(必填, 限制512K)</font> 
					</div>
				</div>
                
                <div class="control-group">
                    <label class="control-label">终端类型 :</label>
                    <div class="controls">
                    	<label class="radio inline">
							<input type="radio" name="os" value="all" checked>all
						</label>
                  		<label class="radio inline">
							<input type="radio" name="os" value="android">android
						</label>
						<label class="radio inline">
							<input type="radio" name="os" value="ios">ios
						</label>
                  	</div>
                </div>
                
                <div class="form-actions">
                    <button  class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="span2"></div>
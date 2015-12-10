<div class="span2"></div>
<div class="span8">
    <div class="widget-box">
        <div class="widget-title">
            <h5>版本</h5>
        </div>
        <div class="widget-content nopadding">
            <form action="/version/versionSave" class="form-horizontal" method="post">
            	<?php if(isset($version)):?>
                <input value="<?php echo $version->id; ?>" name="versionId" type="hidden"></input>
                <?php endif;?>
            	<div class="control-group">
                    <label class="control-label">版本号 :</label>
                    <div class="controls">
                        <input class="span3" name="versionCode" placeholder="versionCode(例: 1001)" value="<?php if(isset($version)) echo $version->versionCode;?>" type="text"  required>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">版本名称 :</label>
                    <div class="controls">
                        <input class="span3" name="version" value="<?php if(isset($version)) echo $version->version;?>" placeholder="version(例: 1.0.5)" type="text" required>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">文件大小 :</label>
                    <div class="controls">
                        <input class="span3" name="fileSize" value="<?php if(isset($version)) echo $version->fileSize;?>" placeholder="文件大小(例:10)" type="text" required>
                    </div>
                </div>
				<div class="control-group">
                    <label class="control-label">下载URL :</label>

                    <div class="controls">
                        <input class="span6" name="downURL" value="<?php if(isset($version)) echo $version->downURL;?>" placeholder="下载地址" type="url" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">终端类型 :</label>
                    <div class="controls">
                  		<label class="radio inline">
							<input type="radio" <?php if(isset($version)) echo ($version->os == 'android') ? "checked" : ""; else echo "checked";?> name="os" value="android">android
						</label>
						<label class="radio inline">
							<input type="radio" <?php if(isset($version)) echo ($version->os == 'ios') ? "checked" : "";?> name="os" value="ios">ios
						</label>
                  	</div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">升级类型 :</label>
                    <div class="controls">
                  		<label class="radio inline">
							<input type="radio" name="isForbidden" <?php if(isset($version)) echo ($version->isForbidden == '0') ? "checked" : "";?> value="0">普通升级
						</label>
						<label class="radio inline">
							<input type="radio" name="isForbidden" <?php if(isset($version)) echo ($version->isForbidden == '1') ? "checked" : "";?> value="1">强制升级
						</label>
                  	</div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">升级描述 :</label>

                    <div class="controls">
                    	<textarea name="updateMsg" class="span8" required><?=isset($version) ? $version->updateMsg : ""?></textarea>
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
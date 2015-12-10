<div class="span12">

<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-align-justify"></i></span>
		<h5>添加活动</h5>
	</div>
	<div class="widget-content nopadding">
		<form action="/activity/activitySave" method="post" enctype="multipart/form-data" class="form-horizontal">
		
			  <?php if(isset($activity)):?>
        	  <input value="<?php echo $activity['id']; ?>" name="activityId" type="hidden"></input>
        	  <?php endif;?>

            <div class="control-group">
              <label class="control-label">标题 ：</label>
              <div class="controls">
                <input type="text" class="span6" name="title" required value="" />
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">描述 ：</label>
              <div class="controls">
                <input type="text" class="span6" name="description" required value="" />
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">客户端 :</label>
              <div class="controls" >
                <select id="os" name="os" class="span6">
                    <option selected="selected" value="all">所有</option>
                    <option value="android">Android</option>
                    <option value="ios">IOS</option>
                </select>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">VersionCode：</label>
              <div class="controls">
                <input type="text" class="span6" name="versionCode" required value="" />
                （最低版本）
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">渠道号 ：</label>
              <div class="controls">
                <input type="text" class="span6" name="channelID" required value="0" />
              </div>
            </div>
            
            <div class="control-group" id="showpic" style="display:none">
	              <label class="control-label">弹窗图片 :</label>
	              <div class="controls">
	                <img id="pic" src="" alt="img" width="100">
	              </div>
	        </div>
	            
            <div class="control-group">
              <label class="control-label">弹窗图片 :</label>
              <div class="controls">
                <input id="file_input" name="iconFile" type="file"/>(限制256K)
              </div>
            </div>
            
            <div class="control-group" id="showpic1" style="display:none">
	              <label class="control-label">Banner图片 :</label>
	              <div class="controls">
	                <img id="pic1" src="" alt="img" width="100">
	              </div>
	        </div>
            
            <div class="control-group">
              <label class="control-label">Banner图片 :</label>
              <div class="controls">
                <input id="file_input1" name="iconFile2" type="file"/>(限制256K)
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">活动详情URL:</label>
              <div class="controls">
                <input type="text" name="operaUrl" class="span6" value=""/>（跳网页时填写，不填则不跳）
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">上线时间:</label>
              <div class="controls">
                <input type="text" name="beginTime" readonly="readonly" class="commonPubTime span3" value="<?=Date('Y-m-d H:i:s');?>">
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">下线时间:</label>
              <div class="controls">
                <input type="text" name="dueTime" readonly="readonly" class="commonPubTime span3" value="<?=Date('Y-m-d H:i:s');?>">
              </div>
            </div>
            
            <div class="form-actions">
              <button type="submit" class="btn btn-success">保存</button>
            </div>
          </form>
        </div>
	</div>
</div>
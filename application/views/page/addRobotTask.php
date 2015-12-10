<div class="span12">

  <div class="widget-box">
  	<div class="widget-title">
  		<span class="icon"><i class="icon-align-justify"></i></span>
  		<h5>添加机器人推送任务</h5>
  	</div>
  	<div class="widget-content nopadding">
  		<form action="/imglibs/saveRobotTask" method="post" class="form-horizontal" enctype="multipart/form-data">
         
        <?php if(!empty($image)):?>
  		<div class="control-group">
          <label class="control-label">图片ID:</label>
          <div class="controls">
            <input id="imgID" name="imgID" type="text" class="span3" value="<?=$image['id']?>" readonly="true">
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label">要发的图片: </label>
          <div class="controls">
          	<img src="<?=JY_QN_piclibs_url . $image['picName']?>" width="200">
          </div>
        </div>
        <?php else:?>
        <div class="control-group">
          <label class="control-label">上传图片 :</label>
          <div class="controls">
            <input id="file_input" name="imageFile" type="file" required/>(限制256K)
          </div>
        </div>
        <?php endif;?>
        
  		<div class="control-group">
          <label class="control-label">选择机器人 :</label>
          <div class="controls" >
            <select id="robotId" name="robotId" class="span3">
              <?php foreach($robotList as $index => $item): ?>
                <option value="<?=$item['id']?>"><?=$item['nickname']?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label">选择专题活动 :</label>
          <div class="controls" >
            <select id="subjectId" name="subjectId" class="span3" onchange="javascript:getSelectValue()">
            	<option value="0">无</option>
              <?php foreach($subjectList as $index => $item): ?>
                <option value="<?=$item['id']?>"><?=$item['title']?></option>
              <?php endforeach;?>
            </select>
          </div>
        </div>
		
		<input type="hidden" id="subjectTitle" val="" name="subjectTitle"/>
	    
	    <div class="control-group">
          <label class="control-label">消息内容: </label>
          <div class="controls">
            <textarea name="content" class="span8"><?=empty($image) ? "" : $image['picDesc']?></textarea>
          </div>
        </div>
            
        <div class="control-group">
          <label class="control-label">发布时间:</label>
          <div class="controls">
            <input type="text" name="pushTime" readonly="readonly" class="commonPubTime span3" value="<?=Date('Y-m-d H:i:s');?>">
          </div>
        </div>

        <div class="form-actions">
          <button id="subEmbedBtn" type="submit" class="btn btn-success">保存</button>
        </div>
        
      </form>
    </div>
  </div>    
</div>
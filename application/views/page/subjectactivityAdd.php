
<div class="span12">

<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-align-justify"></i></span>
		<h5>添加活动</h5>
	</div>
	<div class="widget-content nopadding">
		
		<form action="/subjectactivity/activitySave" method="post" enctype="multipart/form-data" class="form-horizontal">
			 
			<input value="<?php echo isset($id)?$id:''; ?>" name="id" type="hidden"></input>
			<input value="<?php echo isset($imageUrl)?$imageUrl:''; ?>" name="imageUrl" type="hidden"></input>
			<input value="<?php echo isset($imageUrl2)?$imageUrl2:''; ?>" name="imageUrl2" type="hidden"></input>
			<input value="<?php echo isset($posterUrl)?$posterUrl:''; ?>" name="posterUrl" type="hidden"></input>
            <div class="control-group">
				<label class="control-label">标题 ：</label>
				<div class="controls">
					<input type="text" class="span3 tagsName" name="title" maxlength="8" required value="<?php echo isset($title)?$title:''?>" /> (8个字内)<font color="red"> *</font>必填
				</div>
            </div>

            <div class="control-group">
				<label class="control-label">描述 ：</label>
				<div class="controls">
					<textarea name="content" class="span3" maxlength="48" required text=""><?php echo isset($content)?$content:''?></textarea> (48个字内)<font color="red"> *</font>必填
				</div>
            </div>

			<?php if(isset($imageUrl)):?>
            <div class="control-group" id="showpic">
				<label class="control-label">封面图片 :</label>
				<div class="controls">
					<img id="pic" src="<?=$imageUrl?>" alt="img" width="100">
				</div>
            </div>
            <?php endif;?>
	            
			<div class="control-group">
				<label class="control-label">封面图片 :</label>
				<div class="controls">
					<?php if(isset($imageUrl)):?>
					<input id="file_input" name="iconFile" type="file" />(限制256K)
					<?php else:?>
					<input id="file_input" name="iconFile" type="file" required=""/>(限制256K)<font color="red"> *</font>必填
					<?php endif;?>
              </div>
            </div>
            
            <?php if(isset($posterUrl)):?>
			<div class="control-group" id="showpic1">
				<label class="control-label">海报图片 :</label>
				<div class="controls">
					<img id="pic1" src="<?=$posterUrl?>" alt="img" width="100">
				</div>
			</div>
	        <?php endif;?>
            
            <div class="control-group">
				<label class="control-label">海报图片 :</label>
				<div class="controls">
					<?php if(isset($posterUrl)):?>
					<input id="file_input1" name="iconFile2" type="file" />(限制256K)
					<?php else:?>
					<input id="file_input1" name="iconFile2" type="file" required=""/>(限制256K)<font color="red"> *</font>必填
					<?php endif;?>
				</div>
            </div>

            <?php if(isset($imageUrl2)):?>
	            <div class="control-group" id="showpic1">
					<label class="control-label">3.X图片 :</label>
					<div class="controls">
						<img id="pic1" src="<?=$imageUrl2?>" alt="img" width="100">
					</div>
	            </div>
	        <?php endif;?>
	        
            <div class="control-group">
				<label class="control-label">3.X图片 :</label>
				<div class="controls">
					<?php if(isset($imageUrl2)):?>
					<input id="file_input1" name="iconFile3" type="file" />(限制256K)
					<?php else:?>
					<input id="file_input1" name="iconFile3" type="file" required=""/>(限制256K)<font color="red"> *</font>必填
					<?php endif;?>
				</div>
            </div>
			
			<div class="control-group">
				<label class="control-label">页面类型 :</label>
				<div class="controls" >
					<select name="activityUrlType" class="span3">
						<?php if (isset($activityUrlType) && $activityUrlType == 1):?>
						<option value="0">活动H5页面</option>
						<option selected="selected" value="1">获奖H5页面</option>
						<?php else:?>
						<option selected="selected" value="0">活动H5页面</option>
						<option value="1">获奖H5页面</option>
						<?php endif;?>
					</select>
				</div>
			</div>
			
            <div class="control-group">
				<label class="control-label">活动标题：</label>
				<div class="controls">
					<input type="text" class="span3 tagsName" name="activityTitle" value="<?php echo isset($activityTitle)?$activityTitle:''?>"/>
				</div>
            </div>

            <div class="control-group">
				<label class="control-label">活动H5页面 ：</label>
				<div class="controls">
					<input type="text" class="span3 tagsName" name="activityUrl" value="<?php echo isset($activityUrl)?$activityUrl:''?>"/>
				</div>
            </div>
			
			<div class="control-group">
				<label class="control-label">获奖H5页面 ：</label>
				<div class="controls">
					<input type="text" class="span3 tagsName" name="prizeUrl" value="<?php echo isset($prizeUrl) ? $prizeUrl : ''?>"/>
				</div>
            </div>
            
            <div class="control-group">
				<label class="control-label">排序值 ：</label>
				<div class="controls">
					<input type="text" class="span3 tagsName" name="order" value="<?php echo isset($orderVal)?$orderVal:'0'?>"/>
				</div>
            </div>
            
            <div class="control-group">
				<label class="control-label">上线时间:</label>
				<div class="controls">
					<input type="text" name="onlineTime" readonly="readonly" class="commonPubTime span3" value="<?php echo isset($onlineTime)?$onlineTime:Date('Y-m-d H:i:s');?>">
				</div>
            </div>
            
            
            <div class="control-group">
				<label class="control-label">推荐：</label>
				<div class="controls">
					<?php if(isset($isSearchSubject) && $isSearchSubject == 1):?>
					<label><input type="checkbox" name="recommend[]" value="search" checked="checked"/>搜索推荐</label>
					<?php else:?>
					<label><input type="checkbox" name="recommend[]" value="search"/>搜索推荐</label>
					<?php endif;?>
					<?php if(isset($isHot) && $isHot == 1):?>
					<label><input type="checkbox" name="recommend[]" value="hot" checked="checked"/>热门话题</label>
					<?php else:?>
					<label><input type="checkbox" name="recommend[]" value="hot"/>热门话题</label>
					<?php endif;?>
				</div>
            </div>
             
            <div class="form-actions">
				<?php if(isset($id)):?>
				<button type="submit" class="btn btn-success">更新</button>
				<?php else:?>
				<button type="submit" class="btn btn-success">保存</button>
				<?php endif;?>
            </div>
          </form>
        </div>
	</div>
</div>
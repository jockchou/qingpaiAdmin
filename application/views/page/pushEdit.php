<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>编辑PUSH消息-【尽量避开高峰期发送】</h5>
	    </div>
	    <div class="widget-content nopadding">
		<form action="/pushboard/pushSave" method="post" enctype="multipart/form-data" class="form-horizontal">
			     
            <div class="control-group">
              <label class="control-label">客户端 :</label>
              <div class="controls" >
                <select name="os" class="span6">
                    <option selected="selected" value="all">所有</option>
                    <option value="android">Android</option>
                    <option value="ios">IOS</option>
                </select>
              </div>
            </div>

			      <div class="control-group">
              <label class="control-label">推送时间:</label>
              <div class="controls commonPubTime">
                <input type="text" class="span4" name="pushTime" required value=""/><font color="red"> *(必填)</font>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">通知栏标题</label>
              <div class="controls">
                <input type="text" class="span4" name="title" required value=""/><font color="red"> *(必填)</font>
              </div>
            </div>
            
            <div class="control-group">
              <label class="control-label">消息内容: </label>
              <div class="controls">
                <textarea name="content" class="span8" required value=""></textarea><font color="red"> *(必填)</font>
              </div>
            </div>
			      
            <?php include(dirname(dirname(__FILE__ )).'/block/msgTypeSel.php');?>

			      <div class="control-group">
              <label class="control-label">版本号 </label>
              <div class="controls">
                <input type="text" name="version" class="span4" placeholder="暂未支持"/>
              </div>
            </div>
			
			<div class="control-group" id="showpic" style="display:none">
				<label class="control-label">图片 :</label>
				<div class="controls">
					<img id="pic" src="" alt="img" width="100">
				</div>
	        </div>
			
            <div class="control-group">
              <label class="control-label">通知栏ICON :</label>
              <div class="controls">
                <input id="file_input" name="imageFile" type="file"/>(限制256K)
              </div>
             </div>
			      
            <div class="control-group">
              <label class="control-label">N天内登录 :</label>
              <div class="controls" >
                <input type="text" name="loginDays" value="" placeholder="空值或者0-忽略" class="span4"/>
              </div>
            </div>

            <div class="control-group">
              <label class="control-label">N天内未登录 :</label>
              <div class="controls" >
                <input type="text" name="unLoginDays" value="3" placeholder="空值或者0-所有人" class="span4"/>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-success">保存</button>
            </div>
          </form>
        </div>
	</div>
</div>
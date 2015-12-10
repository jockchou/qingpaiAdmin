<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加账号</h5>
        </div>

        <div class="widget-content nopadding">
            <form id="user-form-add" action="/tags/tagsSave" class="form-horizontal" method="post">
            	
                <div class="control-group">
                    <label class="control-label">标签名称:</label>
                    <div class="controls">
                        <input class="span3 tagsName"  name="tagsName" placeholder="标签名称" type="text" autofocus="true" required>
                        <span id="tagsWarning" style="color:red; display: none;"><i class="icon-remove"></i>标签不能超过7个字！</span>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">适合人群:</label>
                    <div class="controls">
                        <select name="sexAdapt" class="span3" required>
                            <option value="0">全部性别</option>
                            <option value="1">男性</option>
                            <option value="2">女性</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>说明</h5>
	    </div>
	    <div class="widget-content">
	    	<div class="alert alert-block">
              <h4 class="alert-heading">特别说明!</h4>
              	admin账号为系统默认超级管理员，拥有普通账号和管理员功能，并能操作其他管理员<br>
              	管理员只能添加普通账号，不能操作其他管理员账号<br>
              	普通账号没有操作其他账号的权限<br>
            </div>
		</div>
	</div>
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加账号</h5>
        </div>

        <div class="widget-content nopadding">
            <form id="user-form-add" action="/user/userSave" class="form-horizontal" method="post">
            	
                <div class="control-group">
                    <label class="control-label">用户名:</label>
                    <div class="controls">
                        <input class="span3" name="username" placeholder="用户名" type="text" autofocus="true" required>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">密码 :</label>
                    <div class="controls">
                        <input class="span3" name="password" placeholder="密码" type="password" required>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button id="device-add-submit" class="btn btn-success" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
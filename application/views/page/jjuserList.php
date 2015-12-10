<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
        <div class="btn-group">
    		<?php if ($openType === "0" OR $openType === "1" OR $openType === "3"):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$openType === "0" ? "微信账号" : ($openType === "1" ? "微博账号" : "手机账号") ?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择账号类型<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&order=<?=$order?>">所有类型</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&order=<?=$order?>&openType=0">微信账号</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&order=<?=$order?>&openType=1">微博账号</a></li>
                	<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&order=<?=$order?>&openType=3">手机账号</a></li>
            	</ul>
    	</div>
    	
    	<div class="btn-group">
            <?php if(!empty($order)):?>
            <button data-toggle="dropdown" class="btn dropdown-toggle">按热度<?=$order == "desc" ? "降序" : "升序"?><span class="caret"></span></button>
            <?php else:?>
            <button data-toggle="dropdown" class="btn dropdown-toggle">选择排序<span class="caret"></span></button>
            <?php endif;?>
            <ul class="dropdown-menu">
            	<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&openType=<?=$openType?>">按注册时间排</a></li>
                <li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&openType=<?=$openType?>&order=desc">按照赞数降序</a></li>
                <li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&state=<?=$state?>&openType=<?=$openType?>&order=asc">按照赞数升序</a></li>
            </ul>
        </div>
        
    	 <div class="btn-group">
    		<?php if($state === "0" OR $state === "1"):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$state === "0" ? $isDubious=="0"?"正常账号":"可疑账号" : "已封账号"?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择账号状态<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&openType=<?=$openType?>&order=<?=$order?>">所有状态</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&openType=<?=$openType?>&order=<?=$order?>&state=0&isDubious=0">正常账号</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&openType=<?=$openType?>&order=<?=$order?>&state=0&isDubious=1">可疑账号</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&openType=<?=$openType?>&order=<?=$order?>&state=1">已封账号</a></li>
            		<li><a href="<?=$pathURL?>?nickname=<?=$nickname?>&openType=<?=$openType?>&order=<?=$order?>&isFamous=1">达人账号</a></li>
            	</ul>
    	</div>
    	
    	<a href="<?=$pathURL?>" class="btn btn-primary btn-warning">重置筛选</a>
    	
    	<form style="display:inline-block;" action="<?=$pathURL?>" method="get">
    		<input name="nickname" type="text" placeholder="搜索userID,妮称" value="<?=$nickname?>"/>
        <input name="mobileNum" type="text" placeholder="搜索手机号" value="<?=$mobileNum?>"/>
			<button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
		</form>
	</div>
</div>

<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>用户列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>妮称</th>
                  <th>账号类型</th>
                  <th>头像</th>
                  <th>赞数</th>
                  <th>V</th>
                  <th>性别</th>
                  <th>生日</th>
                  <th>注册时间</th>
                  <th>上次登录</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($userList as $index => $item):?>
	                <tr>
	                  <td><?=$item['id']?></td>
	                  <td><?=$item['nickname']?></td>
	                  <?php if ($item['openType'] == "0"):?>
	                   <td><span class="badge badge-success">微信</span></td>
	                  <?php elseif ($item['openType'] == "1"):?>
	                   <td><span class="badge badge-warning">微博</span></td>
                    <?php else:?>
                     <td><span class="badge badge-info">手机号</span></td>
	                  <?php endif;?>
                    <?php if ($item['headUrl'] == ''):?>
                     <td><i>未设</i></td>
                    <?php else:?>
                      <td><img src="<?=$item['headUrl']?>" width="48" height="48" alt="headImage"></td>
                    <?php endif;?>
                      <td><span class="badge badge-warning"><?=$item['praiseCnt']?></span></td>
                      <td><span class="badge badge-warning"><?=$item['isFamous'] ? "V" : ""?></span></td>
	                  <td><?=$item['sex'] == "0" ? "男" : "女"?></td>
	                  <td><?=$item['birthday']?></td>
	                  <td><?=$item['regTime']?></td>
	                  <td><?=$item['lastLoginTime']?></td>
	                  <?php if ($item['state'] == "0" &&$item['isDubious'] != "1"):?>
	                  <td><span class="badge badge-success">正常</span></td>
	                  <?php elseif($item['isDubious'] == "1"):?>
	                  <td><span class="badge badge-success">可疑</span></td>
	                  <?php else:?>
	                  <td><span class="badge badge-warning">封号</span></td>
	                  <?php endif;?>
	                  <td>

	                  

	                  <a class="btn btn-primary btn-mini" href="/message/chatHome?toUserID=<?=$item['id']?>">私聊</a>
 	
	                  <?php if($item['isDubious'] == "1"):?>
	                  <a class="btn btn-primary btn-mini" href="/topic/topicList?userID=<?=$item['id']?>&state=-3">帖子</a>
	                  <?php else:?>
	                  <a class="btn btn-primary btn-mini" href="/topic/topicList?userID=<?=$item['id']?>">帖子</a>
	                  <?php endif;?>
	                  <a class="btn btn-primary btn-mini" href="/jjuser/album?userID=<?=$item['id']?>">相册</a>
	       				 
	       			  <?php if($item['isDubious'] == "1"):?>
	                  <a class="btn btn-primary btn-mini btn-redubious" data-id="<?=$item['id']?>" >解除可疑</a>
	                  <?php else:?>
	                  <a class="btn btn-primary btn-mini btn-dubious" data-id="<?=$item['id']?>" >可疑</a>
	       			  <?php endif;?>
	       			  
	       			  <?php if ($item['state'] == "0"||$item['state'] == "-1"):?>
			          <a class="btn btn-danger btn-mini block-user" data-id="<?=$item['id']?>" href="javascript:void(0);">封号</a>
			          <?php else:?>
			          <a class="btn btn-danger btn-mini unblock-user" data-id="<?=$item['id']?>" href="javascript:void(0);">解封</a>
			          <?php endif;?>
			          
			          <?php if ($item['isFamous'] == "0"):?>
			          <a class="btn btn-warning btn-mini addv-user" data-id="<?=$item['id']?>" href="javascript:void(0);">加V</a>
			          <?php else:?>
			          <a class="btn btn-danger btn-mini removev-user" data-id="<?=$item['id']?>" href="javascript:void(0);">去V</a>
			          <?php endif;?>
	                  </td>
	                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
    	</div>
	</div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>

<div class="widget-box">
  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    <h5>操作</h5>
  </div>
  <div class="widget-content">
    <div class="btn-group">
      <?php if ($state === "0" OR $state === "1"):?>
        <button data-toggle="dropdown" class="btn dropdown-toggle"><?=$state==0 ? ($isDubious==0? "正常账号":"可疑账号"):"已封账号"?><span class="caret"></span></button>
      <?php else:?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">选择账号状态<span class="caret"></span></button>
      <?php endif;?>
        <ul class="dropdown-menu">
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&nickname=<?=$nickname?>">所有状态</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&nickname=<?=$nickname?>&state=0&isDubious=0">正常账号</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&nickname=<?=$nickname?>&state=0&isDubious=1">可疑账号</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&nickname=<?=$nickname?>&state=1">已封账号</a></li>
        </ul>
    </div>
    
    <a href="<?=$pathURL?>" class="btn btn-primary btn-warning">重置筛选</a>

    <form style="display:inline-block;" action="<?=$pathURL?>" method="get">
      <input name="userID" type="text" placeholder="搜索userID" value="<?=$userID == 0?'':$userID?>"/>
      <input name="nickname" type="text" placeholder="搜索昵称" value="<?=$nickname?>"/>
      <button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
    </form>
  </div>
</div>

<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>被举报用户列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>序列号</th>
                  <th>userID</th>
                  <th>妮称</th>
                  <th>账号类型</th>
                  <th>头像</th>
                  <th>性别</th>
                  <th>状态</th>
                  <th>举报时间</th>
                  <th>举报原因</th>
                  <th>举报人ID</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($userList as $index => $item):?>
	                <tr>
	                  <td><?=$item['complainID']?></td>
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
	                  <td><?=$item['sex'] == "0" ? "男" : "女"?></td>
	                  <?php if ($item['state'] == "0" &&$item['isDubious'] != "1"):?>
	                  <td><span class="badge badge-success">正常</span></td>
	                  <?php elseif($item['isDubious'] == "1"):?>
	                  <td><span class="badge badge-success">可疑</span></td>
	                  <?php else:?>
	                  <td><span class="badge badge-warning">封号</span></td>
	                  <?php endif;?>
	                  <td><?=$item['addTime']?></td>
	                  <td><span class="badge badge-warning"><?=$item['reason']?></span></td>
	                  <td>
	                  <a class="btn btn-success btn-mini" href="/jjuser/jjuserList?nickname=<?=$item['userID']?>"><?=$item['userID']?></a>
	                  </td>
	                  <td>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/jjuser/jjuserList?nickname=<?=$item['id']?>">去审核</a>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/topic/topicList?userID=<?=$item['id']?>">看帖子</a>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/jjuser/listChatContent?userID=<?=$item['userID']?>&rpUserID=<?=$item['id']?>">看私聊</a>
	                  </td>
	                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
    	</div>
	</div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>

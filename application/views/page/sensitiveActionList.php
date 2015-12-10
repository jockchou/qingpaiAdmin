<div class="widget-box">
  <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    <h5>操作</h5>
  </div>
  <div class="widget-content">
    <div class="btn-group">
      <?php if ($type === "0"):?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">聊天敏感内容<span class="caret"></span></button>
      <?php elseif($type === "1"):?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">聊天频率过高<span class="caret"></span></button>
      <?php elseif($type === "2"):?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">聊天重复内容<span class="caret"></span></button>
      <?php else:?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">选择类型<span class="caret"></span></button>
      <?php endif;?>
        <ul class="dropdown-menu">
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&state=<?=$state?>">所有类型</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&state=<?=$state?>&type=0">聊天敏感内容</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&state=<?=$state?>&type=1">聊天频率过高</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&state=<?=$state?>&type=2">聊天重复内容</a></li>
        </ul>
    </div>

    <div class="btn-group">
      <?php if ($state === "0" OR $state === "1"):?>
        <button data-toggle="dropdown" class="btn dropdown-toggle"><?=$state==0 ? "未审核" :"已审核"?><span class="caret"></span></button>
      <?php else:?>
        <button data-toggle="dropdown" class="btn dropdown-toggle">选择审核状态<span class="caret"></span></button>
      <?php endif;?>
        <ul class="dropdown-menu">
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&type=<?=$type?>">所有状态</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&type=<?=$type?>&state=0">未审核</a></li>
          <li><a href="<?=$pathURL?>?userID=<?=$userID?>&type=<?=$type?>&state=1">已审核</a></li>
        </ul>
    </div>
    
    <a href="<?=$pathURL?>" class="btn btn-primary btn-warning">重置筛选</a>

    <form style="display:inline-block;" action="<?=$pathURL?>" method="get">
      <input name="userID" type="text" placeholder="搜索userID" value="<?=$userID == 0?'':$userID?>"/>
      <button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
    </form>
  </div>
</div>

<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>可疑行为用户列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>userID</th>
                  <th>妮称</th>
                  <th>账号类型</th>
                  <th>头像</th>
                  <th>性别</th>
                  <th>状态</th>
                  <th>添加时间</th>
                  <th>类型</th>
                  <th width="20%">内容</th>
                  <th>目标用户ID</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($userList as $index => $item):?>
	                <tr>
	                  <td><?=$item['sensitiveID']?></td>
	                  <td>
                     <a class="btn btn-success btn-mini" href="/jjuser/jjuserList?nickname=<?=$item['userID']?>"><?=$item['userID']?></a> 
                    </td>
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
                    <?php if ($item['type'] == "1"):?>
                    <td><span class="badge badge-success">聊天频率</span></td>
                    <?php elseif($item['type'] == "2"):?>
                    <td><span class="badge badge-info">聊天重复内容</span></td>
                    <?php else:?>
                    <td><span class="badge badge-warning">聊天内容</span></td>
                    <?php endif;?>
	                  <td><div style="word-break:break-all; word-wrap:break-word" ><?=$item['content']?></div></td>
	                  <td>
                    <?=$item['targetUserID']?>
	                  </td>
	                  <td>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/jjuser/jjuserList?nickname=<?=$item['id']?>">看账号</a>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/topic/topicList?userID=<?=$item['id']?>">看帖子</a>
	                  <a class="btn btn-primary btn-mini" target="_blank" href="/jjuser/listChatContent?userID=<?=$item['targetUserID']?>&rpUserID=<?=$item['userID']?>">看私聊</a>
	                  <br /><br />
                    <?php if ($item['sensitiveState'] == "0"):?>
                      <a data-uid="<?=$item['userID']?>" data-type="<?=$item['type']?>" class="btn btn-primary btn-mini auditSensitive" href="###">审核</a>
                    <?php else:?>
                      <a class="btn btn-warning btn-mini" href="###">已审核</a>
                    <?php endif;?>

                    <?php if ($item['state'] == "0"||$item['state'] == "-1"):?>
                    <a class="btn btn-danger btn-mini block-user" data-id="<?=$item['id']?>" href="javascript:void(0);">封号</a>
                    <?php else:?>
                    <a class="btn btn-danger btn-mini unblock-user" data-id="<?=$item['id']?>" href="javascript:void(0);">解封</a>
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

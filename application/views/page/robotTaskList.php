<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
        <div class="btn-group">
    		<?php if ($isPushed === "0" OR $isPushed === "1"):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$isPushed === "0" ? "未推" : "已推"?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>?robotID=<?=$robotID?>">所有类型</a></li>
            		<li><a href="<?=$pathURL?>?isPushed=0&robotID=<?=$robotID?>">未推送</a></li>
            		<li><a href="<?=$pathURL?>?isPushed=1&robotID=<?=$robotID?>">已推送</a></li>
            	</ul>
    	</div>
    	
        <div class="btn-group">
    		<?php if (!empty($user)):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$user['nickname']?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择机器人<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>">所有</a></li>
            		<?php foreach($robotList as $idx => $item):?>
            		<li><a href="<?=$pathURL?>?robotID=<?=$item['id']?>&isPushed=<?=$isPushed?>">(<?=$item['id']?>) <?=$item['nickname']?></a></li>
            		<?php endforeach;?>
            	</ul>
    	</div>
    	<a href="<?=$pathURL?>" class="btn btn-primary btn-warning">重置筛选</a>
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
                  <th>机器人</th>
                  <th>消息内容</th>
                  <th>图片</th>
                  <th>推送时间</th>
                  <th>添加时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($imageList as $index => $item):?>
	                <tr>
	                  <td><?=$item['id']?></td>
	                  <td><?=$item['userID']?></td>
	                  <td><?=$item['content']?></td>
                      <td><img src="<?=$item['resUrl']?>" width="100" alt="resUrl"></td>
	                  <td><?=$item['pushTime']?></td>
	                  <td><?=$item['addTime'];?></td>
	                  
	                  <?php if ($item['isPushed'] == "0"):?>
	                  <td><span class="badge badge-success">未推</span></td>
                      <?php else:?>
                      <td><span class="badge badge-info">已推</span></td>
	                  <?php endif;?>
	                  <td>
		                  <?php if ($item['isPushed'] == "0"):?>
		                  <a class="btn btn-primary btn-mini del-task" data-id="<?=$item['id']?>" href="javascript:void(0);">删除</a>
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

<div class="span12">
<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
    	<div class="btn-group">
              <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">每页<?=$pageSize?>条<span class="caret"></span></button>
              <ul class="dropdown-menu">
                <li><a href="/report/reportList?pageSize=10">10</a></li>
                <li><a href="/report/reportList?pageSize=20">20</a></li>
                <li><a href="/report/reportList?pageSize=30">30</a></li>
                <li><a href="/report/reportList?pageSize=40">40</a></li>
                <li><a href="/report/reportList?pageSize=50">50</a></li>
              </ul>
        </div>
        
        <div class="btn-group">
    		  <?php if ($hasRead == 'Y'):?>
              <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">只看已读<span class="caret"></span></button>
              <?php elseif ($hasRead == 'N'):?>
              <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">只看未读<span class="caret"></span></button>
              <?php else:?>
              <button data-toggle="dropdown" class="btn btn-info dropdown-toggle">处理状态<span class="caret"></span></button>
              <?php endif;?>
              <ul class="dropdown-menu">
              	<li><a href="/report/reportList?pageSize=<?=$pageSize?>">看所有</a></li>
                <li><a href="/report/reportList?pageSize=<?=$pageSize?>&hasRead=Y">只看已读</a></li>
                <li><a href="/report/reportList?pageSize=<?=$pageSize?>&hasRead=N">只看未读</a></li>
              </ul>
    	</div>
	</div>
</div>


<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>文章举报列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th><input type="checkbox" id="title-table-checkbox" name="title-table-checkbox" /></th>
                  <th>ID</th>
                  <th>用户ID</th>
                  <th>内容ID</th>
                  <th>举报内容</th>
                  <th>时间</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody>
              	<?php foreach($reportList as $index => $item):?>
	                <tr>
	                  <td><input data-Id="<?=$item->id?>" type="checkbox" /></td>
	                  <td><?=$item->id?></td>
	                  <td><?=$item->userID?></td>
	                  <td><a class="btn btn-info" href="/topic/topicList?topicID=<?=$item->topicID?>">查看</a></td>
	                  <td><?=$item->content?></td>
	                  <?php if ($item->hasRead == 'N'):?>
	                  <td><?=$item->pubTime?></td>
	                  <td>
	                  	<a class="btn btn-info" href="/topic/topicList?topicID=<?=$item->topicID?>">去审核</a>
			          	<a class="btn btn-info tagread-btn" data-id="<?=$item->id?>" href="javascript:void(0);">标记为已审</a>
			          </td>
			          <?php else:?>
			          <td><?=$item->readTime?></td>
			          	<td><span class="label label-warning">已审</span></td>
			          <?php endif;?>
	                  </td>
	                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
    	</div>
	</div>
</div>
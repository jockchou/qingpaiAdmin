<div class="span12">
<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
    	<div class="btn-group">
              <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle">每页<?=$pageSize?>条<span class="caret"></span></button>
              <ul class="dropdown-menu">
	                <li><a href="/comport/comportList?pageSize=10">10</a></li>
	                <li><a href="/comport/comportList?pageSize=20">20</a></li>
	                <li><a href="/comport/comportList?pageSize=30">30</a></li>
	                <li><a href="/comport/comportList?pageSize=40">40</a></li>
	                <li><a href="/comport/comportList?pageSize=50">50</a></li>
              </ul>
              
        </div>
        <div class="btn-group">
        	  <button data-toggle="dropdown" class="btn btn-warning dropdown-toggle"><?=$title?><span class="caret"></span></button>
        	  <ul class="dropdown-menu">
        		<li><a href="/comport/comportList?status=4&title=所有被举报评论&pageSize=<?=$pageSize?>">所有被举报评论</a></li>
				<li><a href="/comport/comportList?status=3&title=举报已通过评论&pageSize=<?=$pageSize?>">举报已通过评论</a></li>
				<li><a href="/comport/comportList?status=2&title=举报未通过评论&pageSize=<?=$pageSize?>">举报未通过评论</a></li>
				<li><a href="/comport/comportList?status=1&title=举报未审核评论&pageSize=<?=$pageSize?>">举报未审核评论</a></li>
			  </ul>
        </div>
	</div>
</div>


<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
	            <h5>评论举报列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>评论ID</th>
	                  <th>评论发表者</th>
	                  <th>举报原因</th>
	                  <th>评论内容</th>
	                  <th>举报时间</th>
	                  <th>操作</th>
	                </tr>
              </thead>
              <tbody>
              	<?php foreach($commentReportList as $index => $item):?>
		                <tr>
		                  <td><?=$item['id']?></td>
		                  <td><?=$item['commentID']?></td>
		                  <td><?=$item['userID']?></td>
		                  <td><?=$item['reason']?></td>
		                  <td width=30%><?=$item['content']?></td>
		                  <td><?=$item['opTime']?></td>
		                  <td>
		                  <?php if($status == 1):?>
		                  	<a class="btn btn-info check-comment-btn" data-id="<?=$item['id']?>" data-cid="<?=$item['commentID']?>" data-op="yes" href="javascript:;">通过</a>
				          	<a class="btn btn-info check-comment-btn" data-id="<?=$item['id']?>" data-cid="<?=$item['commentID']?>" data-op="no" href="javascript:;">不通过</a>
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
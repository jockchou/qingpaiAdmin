<div class="span12">
<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
</div>


<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
          		<h5>可疑评论列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
	              	<tr>
	              		<th>帖子ID</th>
	              		<th>评论ID</th>
	              		<th>评论发表者</th>
	              		<th>评论针对ID</th>
	              		<th>评论内容</th>
	              		<th>评论状态</th>
	              		<th>评论时间</th>
	              		<th>操作</th>
	              	</tr>
              </thead>
              <tbody>
              	<?php foreach($commentList as $index => $item):?>
		                <tr>
		                  	<td><?=$item['topicID']?></td>
		                	<td><?=(string)$item['_id']?></td>
		                  	<td><?=$item['userID']?></td>
		                  	<td><?=$item['toUserID']?></td>
		                  	<td width=30%><?=$item['content']?></td>
		                  	<td>可疑</td>
		                	<td><?=($item['pubTime']);?></td>
		                	<td>
			                	<a class="btn btn-info check-comment-btn" data-id="<?=(string)$item['_id']?>" data-op="pass" href="javascript:;">通过</a>
		                		<a class="btn btn-info check-comment-btn" data-id="<?=(string)$item['_id']?>" data-op="stop" href="javascript:;">不通过</a>
		                		<?php if($item['state'] == 0):?>
		                			<a style="background-color:green" class="btn btn-info check-comment-btn" data-id="<?=$item['userID']?>" data-op="block" href="javascript:;">封号</a>
		                		<?php else:?>
		                			<a style="background-color:#880000" class="btn btn-info check-comment-btn" data-id="<?=$item['userID']?>" data-op="unblock" href="javascript:;">解封</a>
		                		<?php endif;?>
		                		<a class="btn btn-info check-comment-btn" data-id="<?=(string)$item['userID']?>" data-op="chat" href="javascript:;">私聊</a>
		                	</td>
		                </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
    	</div>
	</div>
</div>
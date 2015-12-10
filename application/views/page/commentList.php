
<div class="span12">
<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
        <form style="display:inline-block;" action="/comport/getComment" method="get">
    		<input style="margin-bottom: 0;" name="id" type="text" placeholder="搜索帖子ID或者评论ID" value=""/>
    		<button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
		</form>
		
		<form style="display:inline-block;" onsubmit="return check()" action="/comport/getComment" method="get">
    		<input style="margin-bottom: 0;" name="userID" id="comuserID" type="text" placeholder="搜索userID" value="<?=$userID?>"/>
        	<input style="margin-bottom: 0;" name="content" id="comcontent" type="text" placeholder="搜索评论关键词" value=""/>
			<input type="hidden" name="type" value="1">
			<button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
		</form>
		
		<button id="delete" class="btn btn-success" style="position:relative;left:20px">批量删除</button>
	</div>
</div>


<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
          		<h5>帖子评论列表</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
	              	<tr>
	              		<th>帖子ID</th>
	              		<th>评论ID</th>
	              		<th>删除(全选)<?php if($type == 1):?><input type="checkbox" id="select" onchange="selectBtn()"/><?php endif;?></th>
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
		                	<td><label for="<?=(string)$item['_id']?>"><?=(string)$item['_id']?></label></td>
		                  	<td><input type="checkbox" name="commentCheck" id="<?=(string)$item['_id']?>"/></td>
		                  	<td><a href="/jjuser/jjuserList?userID=<?=$item['userID']?>"><?=$item['userID']?></a></td>
		                  	<td><?=$item['toUserID']?></td>
		                  	<td width="30%"><?=$item['content']?></td>
		                  	<?php if($item['state'] === 0):?>
		                  		<td>正常</td>
		                  	<?php elseif($item['state'] === -1):?>
		                  		<td>不通过</td>
		                  	<?php else:?>
		                  		<td>已删除</td>
		                  	<?php endif;?>
		                	<td><?=($item['pubTime']);?></td>
		                	<td>
		                		<?php if($item['state'] === -2):?>
		                			<button class="btn btn-info check-comment-btn"  disabled="true">删除</button>
		                		<?php else:?>
			                		<a class="btn btn-info check-comment-btn" data-id="<?=(string)$item['_id']?>"  href="javascript:;">删除</a>
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
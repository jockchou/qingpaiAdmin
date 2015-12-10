<div class="span12">
<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>活动</h5>
            <span>
            <form style="display:inline-block;" action="/subjectactivity/subjectactivityList" method="get">
    			<input name="subjectTitle" type="text" placeholder="搜索话题Title" style="margin-top:3px"/>
				<button type="submit" class="tip-bottom" style="margin-top:-6px"><i class="icon-search icon-white"></i></button>
			</form>
            </span>
            
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>ID</th>
                  <th >标题</th>
                  <th>封面图</th>
                  <th>3.X图</th>
                  <th>帖数</th>
                  <th>关注数</th>
                  <th>活动</th>
                  <th>活动类型</th>
                  <th>热门</th>
				  <th>排序值</th>
                  <th>上线时间</th>
                  <th>状态</th>
                  <th>操作</th>
             </tr>
              </thead>
              <tbody>
              	<?php foreach($activityList as $index => $item):?>
	                <tr>
	                <td><?=$item->id?></td>
                    <td><?=$item->title?></td>
	                <td><img src="<?=$item->imageUrl?>" width="100" alt="image"></td>
	                <td><?php if(!empty($item->imageUrl2)):?><img src="<?=$item->imageUrl2?>" width="100" alt="image"><?php endif;?></td>
                    <td><?=$item->topicCnt?></td>
                    <td><?=$item->userCnt?></td>
                    <td><?=$item->isActivity == 0? '否' : '是'?></td>
					<td><?=$item->activityUrlType == 0 ? '活动详情' : '获奖详情'?></td>
                    <td><?=$item->isHot == 0 ? '否' : '是'?></td>
					<td><?=$item->orderVal?></td>
					<td><?=$item->onlineTime?></td>
	                <?php if ($item->state == '1'):?>
	                  <td><span class="label label-success">在线</span></td>
	                <?php else:?>

	                  <td><span class="label label-warning">已下线</span></td>

	                <?php endif;?>
	                <td >
                        <?php if ($item->state == 1):?>
                        <a class="btn btn-danger btn-mini off-activity" data-id="<?=$item->id?>" data-op="off" href="javascript:void(0);">下线</a>
                        <?php else:?>
                        <a class="btn btn-success btn-mini off-activity" data-id="<?=$item->id?>" data-op="on" href="javascript:void(0);">上线</a>
                        <?php endif;?>
                        <a class="btn btn-success btn-mini edit-activity" data-id="<?=$item->id?>"  href="/subjectactivity/subjectactivityUpdate?id=<?=$item->id?>">编辑</a>
	                	<a class="btn btn-success btn-mini topic-activity" data-id="<?=$item->id?>"  href="/topic/topicList?subjectID=<?=$item->id?>">帖子</a>
	                </td>
	              </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
    	</div>
	</div>
</div>
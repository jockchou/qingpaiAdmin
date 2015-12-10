<div class="span12">
<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>活动</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>标题</th>
                  <th>描述</th>
                  <th>客户端</th>
                  <th>版本号</th>
                  <th>渠道号</th>
                  <th>弹窗图片</th>
                  <th>Banner图</th>
                  <th>活动详情URL</th>
                  <th>上线时间</th>
                  <th>下线时间</th>
                  <th>状态</th>
                  <th>操作</th>
             </tr>
              </thead>
              <tbody>
              	<?php foreach($activityList as $index => $item):?>
	                <tr>
	                  <td><?=$item->id?></td>
                    <td><?=$item->title?></td>
                    <td><?=$item->description?></td>
                    <td><?=$item->os?></td>
                    <td><?=$item->versionCode?></td>
                    <td><?=$item->channelID?></td>
	                  <td><img src="<?=$item->imageUrl?>" width="100" alt="image"></td>
	                  <td><img src="<?=$item->bannerUrl?>" width="100" alt="image"></td>
                    <td><?=$item->operaUrl?></td>
	                  <td><?=$item->beginTime?></td>
                    <td><?=$item->dueTime?></td>

	                  <?php if ($item->onlineStatus == '1'):?>
                        <?php if (Date("Y-m-d H:i:s") >= $item->beginTime && Date("Y-m-d H:i:s") <= $item->dueTime):?>
	                      <td><span class="label label-success">正在进行中</span></td>
                        <?php else:?>
                        <td><span class="label label-success">活动已结束</span></td>
                        <?php endif;?>
	                  <?php else:?>
	                  <td><span class="label label-warning">下线</span></td>
	                  <?php endif;?>

	                  <td>
                        <a class="btn btn-danger btn-mini del-activity" data-id="<?=$item->id?>" href="javascript:void(0);">删除</a>
                        <?php if ($item->onlineStatus == 1):?>
                        <a class="btn btn-danger btn-mini off-activity" data-id="<?=$item->id?>" data-op="off" href="javascript:void(0);">下线</a>
                        <?php else:?>
                        <a class="btn btn-success btn-mini off-activity" data-id="<?=$item->id?>" data-op="on" href="javascript:void(0);">上线</a>
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
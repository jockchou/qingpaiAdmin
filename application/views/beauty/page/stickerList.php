<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    
	    <div class="widget-content">
	    	<a href="/beauty/stickerAdd" class="btn btn-primary">添加颜值贴纸</a>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>标签列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>级别ID</th>
						<th>性别</th>
                        <th>名称</th>
						<th>是否全屏</th>
                        <th>图片</th>
						<th>标签</th>
                        <th>添加时间</th>
						<th>上线时间</th>
                        <th>更新时间</th>
                        <th>状态</th>
                        <th>文本中心位置</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($stickerList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['gradeID']?></td>
                        <td><?=$item['sex'] == 0 ? '男' : '女'?></td>
                        <td><?=$item['name']?></td>
						<td><?=$item['isFullScreen'] == 1 ? '是' : '否'?></td>
                        <td><img width="50" src="<?=$item['imageUrl']?>" alt="<?=$item['name']?>"></td>
						<td><span class="badge badge-success"><?=JY_getStickerTagName($item['tag'])?></span></td>
                        <td><?=$item['addTime']?></td>
						<td><?=$item['onlineTime']?></td>
						<td><?=$item['updateTime']?></td>
                        <td>
							<?php if ($item['state'] == 0 && strtotime($item['onlineTime']) < time()):?>
							<span class="badge badge-success">已上线</span>
							<?php elseif ($item['state'] == 0 && strtotime($item['onlineTime']) >= time()):?>
							<span class="badge badge-info">待上线</span>
							<?php else:?>
							<span class="badge badge-important">已下线</span>
							<?php endif?>
						</td>
						<td>(<?=$item['textPosX']?>,<?=$item['textPosY']?>)</td>
                        <td>
							<?php if($item['tag'] == 2):?>
                        	<a class="btn btn-info btn-mini" href="/beauty/stickerActivity?stickerID=<?=$item['id']?>">配置抽奖</a>
                        	<?php elseif($item['tag'] == 1):?>
							<a class="btn btn-info btn-mini" href="/beauty/stickerActivity?stickerID=<?=$item['id']?>">配置NEW</a>
							<?php endif;?>
							
                        	<?php if($item['state'] == 0):?>
                        	<a class="btn btn-danger btn-mini setstate-btn" state='1' data-id="<?=$item['id']?>">下线</a>
                        	<?php else:?>
                        	<a class="btn btn-success btn-mini setstate-btn" state='0' data-id="<?=$item['id']?>">上线</a>
                        	<?php endif;?>
							<a class="btn btn-danger btn-mini del-btn" data-id="<?=$item['id']?>">删除</a>
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(dirname(__FILE__)) )."/block/page.php");?>
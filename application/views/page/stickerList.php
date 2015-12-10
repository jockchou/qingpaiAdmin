<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    
	    <div class="widget-content">
	    	<?php if(isset($_GET['categoryID'])):?>
	    	<a href="/sticker/stickerAdd?categoryID=<?=$_GET['categoryID']?>" class="btn btn-primary">添加贴纸</a>
	    	<?php else:?>
	    	<a href="/sticker/stickerAdd" class="btn btn-primary">添加贴纸</a>
	    	<?php endif;?>
	    	
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
                        <th>分类ID</th>
                        <th>名称</th>
						<th>是否全屏</th>
                        <th>图片</th>
                        <th>标签</th>
                        <th>排序值</th>
                        <th>添加时间</th>
                        <th>上线时间</th>
                        <th>使用次数</th>
                        <th>热门</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($tagsList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['categoryID']?></td>
                        <td><?=$item['name']?></td>
                        <td><?=$item['isFullScreen'] == 1 ? '是' : '否'?></td>
                        <td><img width="50" src="<?=$item['imageUrl']?>" alt="<?=$item['name']?>"></td>
                        <td><span class="badge badge-success"><?=JY_getStickerTagName($item['tag'])?></span></td>
                        <td><?=$item['orderVal']?></td>
                        <td><?=$item['addTime']?></td>
                        <td><?=$item['onlineTime']?></td>
                        <td><?=$item['useCnt']?></td>
                        <td><?=$item['isHot'] == 1 ? "是" : "否"?></td>
                        <td><?=$item['state'] == 0 ? "<span class=\"badge badge-success\">上线</span>" : "<span class=\"badge badge-important\">下线</span>"?></td>
                        <td>
                        	<a class="btn btn-primary btn-mini" href="/sticker/stickerEdit?stickerID=<?=$item['id']?>">编辑</a>
                        	<a class="btn btn-primary btn-mini" href="/sticker/addCrond?stickerID=<?=$item['id']?>">添加替换</a>
                        	<a class="btn btn-primary btn-mini" href="/sticker/listCrond?stickerID=<?=$item['id']?>">历史替换</a>
                        	<?php if($item['state'] == 0):?>
                        	<a class="btn btn-danger btn-mini del-btn" data-op="1" data-id="<?=$item['id']?>">下线</a>
                        	<?php else:?>
                        	<a class="btn btn-success btn-mini del-btn" data-op="0" data-id="<?=$item['id']?>">上线</a>
                        	<?php endif;?>
                        	<a class="btn btn-primary btn-mini" href="/topic/topicList?type=1&stickerID=<?=$item['id']?>">帖子</a>
                        	<?php if($item['tag'] == 2):?>
                        	<a class="btn btn-info btn-mini" href="/sticker/stickerActivity?stickerID=<?=$item['id']?>">配置抽奖</a>
                        	<?php elseif($item['tag'] == 1):?>
							<a class="btn btn-info btn-mini" href="/sticker/stickerActivity?stickerID=<?=$item['id']?>">配置NEW</a>
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
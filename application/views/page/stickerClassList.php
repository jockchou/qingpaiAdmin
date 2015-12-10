<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/sticker/stickerClassAdd" class="btn btn-primary">添加贴纸分类</a>
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
                        <th>名称</th>
                        <th>图标</th>
                        <th>排序值</th>
                        <th>添加时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($stickerClassList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['title']?></td>
                        <td width="50px" height="25px" ><img style="height:100%" width="100%" src="<?=$item['iconUrl']?>" alt="<?=$item['title']?>"></td>
                        <td><?=$item['orderVal']?></td>
                        <td><?=$item['addTime']?></td>
                        <td><?=$item['updateTime']?></td>
                        <td>
                        	<a class="btn btn-primary btn-mini" href="/sticker/stickerClassEdit?id=<?=$item['id']?>">编辑</a>
                        	<a class="btn btn-primary btn-mini" href="/sticker/stickerList?categoryID=<?=$item['id']?>">贴纸</a>
                        	<a class="btn btn-primary btn-mini deleteClass" id="<?=$item['id']?>">删除</a>
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
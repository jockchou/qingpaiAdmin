<div class="span10">
	<a class="btn btn-primary" href="/version/flashAdd">添加</a>
    <div class="widget-box">
        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>OS</th>
                        <th>图片</th>
                        <th>开始时间</th>
                        <th>结束时间</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php foreach($flashList as $index => $item):?>
                    <tr>
                        <td><?=$item['id']?></td>
                        <td><?=$item['os']?></td>
                        <td><img width="50" src="<?=$item['imageUrl']?>"></td>
                        <td><?=$item['startTime']?></td>
                        <td><?=$item['endTime']?></td>
                        <td><?=$item['addTime']?></td>
                        <td>
	                        <a href="javascript:void(0);" data-id="<?=$item['id']?>" class="btn rmbtn">删除</a>
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
</div>
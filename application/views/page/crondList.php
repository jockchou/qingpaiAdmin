<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>黄历列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>贴纸ID</th>
                        <th>图片</th>
                        <th>状态</th>
                        <th>替换时间</th>
                        <th>添加时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($crondList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['stickerID']?></td>
                        <td><img width="50" src="<?=$item['imageUrl']?>" alt="<?=$item['stickerID']?>"></td>
                        <td>
                        	<?php if ($item['hasDone'] == 0):?>
                        	<span class="badge badge-warning">未替换</span>
                        	<?php else:?>
                        	<span class="badge badge-success">已替换</span>
                        	<?php endif;?>
                        </td>
                        <td><?=$item['actionTime']?></td>
                        <td><?=$item['addTime']?></td>
                        <td>
                        	<?php if ($item['hasDone'] == 0):?>
                        	<a class="remove-crond btn btn-primary btn-mini" data-id="<?=$item['id']?>" href="javascript:void(0);">删除</a>
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
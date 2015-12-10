<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/beauty/stickerGradeAdd" class="btn btn-primary">添加贴纸分类</a>
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
                        <th>最小分数</th>
                        <th>最大分数</th>
                        <th>添加时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($stickerGradeList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['gradeName']?></td>
                        <td><?=$item['minScore']?></td>
                        <td><?=$item['maxScore']?></td>
                        <td><?=$item['addTime']?></td>
                        <td><?=$item['updateTime']?></td>
                        <td>
							<a class="btn btn-info btn-mini edit-btn" id="<?=$item['id']?>">编辑</a>
                        	<!--a class="btn btn-danger btn-mini del-btn" id="<!--?=$item['id']?>">删除</a-->
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(dirname(__FILE__))) ."/block/page.php");?>
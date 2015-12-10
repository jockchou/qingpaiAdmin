<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/tags/tagsAdd" class="btn btn-primary">添加标签</a>
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
                        <th>标签名</th>
                        <th>适合人群</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($tagsList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item['id']?></td>
                        <td><?=$item['tagName']?></td>
                        <?php if($item['sexAdapt'] == 0):?>
                        <td><span class="label label-info">全部</span></td>
                        <?php elseif($item['sexAdapt'] == 1):?>
                        <td><span class="label label-success">男性</span></td>
                        <?php else:?>
                        <td><span class="label label-important">女性</span></td>
                        <?php endif;?>
                        <td><?=$item['updateTime']?></td>
                        <td class="center">
	                       <a href="javascript:void(0);" data-name="<?=$item['tagName']?>" class="btn btn-danger tags-del-btn">删除</a>
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
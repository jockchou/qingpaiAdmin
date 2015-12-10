<div class="span12">
	
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
			<h5>操作</h5>
		</div>
		<div class="widget-content">
			<div class="btn-group">
				<?php 
					function getTopicStateName($state) {
						switch($state) {
							case 0:return '所有';
							case 1:return '上线';
							case 2:return '下线';
							default :return '选择状态';
						}
					}
				?>
				<?php if (isset($topicState)):?>
				<button data-toggle="dropdown" class="btn dropdown-toggle"><?=getTopicStateName($topicState)?><span class="caret"></span></button>
				<?php else:?>
				<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
				<?php endif;?>
				<ul class="dropdown-menu">
					<!--设置 topicState-->
					<li><a href="/selectionTopic/selectionTopicList?topicState=0">所有</a></li>
					<li><a href="/selectionTopic/selectionTopicList?topicState=1">上线</a></li>
					<li><a href="/selectionTopic/selectionTopicList?topicState=2">下线</a></li>
				</ul>
			</div>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>精选帖子列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
						<th>帖子ID</th>
                        <th>帖子</th>
                        <th>发帖人ID</th>
						<th>添加时间</th>
						<th>状态</th>
						<th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($selectionTopicList as $index => $item):?>
						<tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
							<td><?=$item['id']?></td>
							<td><?=$item['topicID']?></td>
							<td><img width="72" src="<?=$item['resUrl']?>"></td>
							<td><?=$item['userID']?></td>
							<td><?=$item['addTime']?></td>
							<?php if ($item['state'] == 0):?>
								<td><span class="badge badge-success">上线</span></td>
							<?php else:?>
								 <td><span class="badge badge-important">下线</span></td>
							<?php endif;?>
							<td>
								<?php if ($item['state'] == 0):?>
								<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-info offline-btn">下线</a>
								<?php else:?>
								<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-success online-btn">上线</a>
								<?php endif;?>
								<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-danger del-btn">删除</a>
							</td>
	                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
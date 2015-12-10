<div class="span12">
	
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
			<h5>操作</h5>
		</div>
		<div class="widget-content">
			<div class="btn-group">
				<?php 
					function getStateName($isSend) {
						if ($isSend == 1) {
							return '已发送';
						} else {
							return '未发送';
						}
					}
				?>
				<?php if (isset($isSend)):?>
				<button data-toggle="dropdown" class="btn dropdown-toggle"><?=getStateName($isSend)?><span class="caret"></span></button>
				<?php else:?>
				<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
				<?php endif;?>
				<ul class="dropdown-menu">
					<!--设置 topicState-->
					<li><a href="/selectionTopic/reserveTopicList?isSend=0">未发送</a></li>
					<li><a href="/selectionTopic/reserveTopicList?isSend=1">已发送</a></li>
				</ul>
			</div>
			<div class="btn-group">
			<?php if ($isOpen == 1):?>
				<button class="btn btn-warning setOpen-btn" setOpen="0">停止发送</button>
			<?php else:?>
				<button class="btn btn-info setOpen-btn" setOpen="1">开始发送</button>
			<?php endif;?>
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
                	<?php foreach($reserveTopicList as $index => $item):?>
						<tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
							<td><?=$item['id']?></td>
							<td><?=$item['topicID']?></td>
							<td><img width="72" src="<?=$item['resUrl']?>"></td>
							<td><?=$item['userID']?></td>
							<td><?=$item['addTime']?></td>
							<?php if ($item['isSend'] == 1):?>
								<td><span class="badge badge-important">已发送</span></td>
							<?php else:?>
								<td><span class="badge badge-success">未发送</span></td>
							<?php endif;?>
							<td>
								<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-danger del-btn">删除</a>
							</td>
	                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include(dirname(dirname(dirname(__FILE__))) ."/block/page.php");?>
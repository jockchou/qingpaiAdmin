
<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/sysnotice/editSystNotice" class="btn btn-primary">添加</a>
	    	
	    	<div class="btn-group">
    		<?php if ($type):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=JY_getJumpNameByType($type)?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>">所有类型</a></li>
            		<li><a href="<?=$pathURL?>?type=1"><?=JY_getJumpNameByType("1")?></a></li>
            		<li><a href="<?=$pathURL?>?type=2"><?=JY_getJumpNameByType("2")?></a></li>
            		<li><a href="<?=$pathURL?>?type=3"><?=JY_getJumpNameByType("3")?></a></li>
            		<li><a href="<?=$pathURL?>?type=4"><?=JY_getJumpNameByType("4")?></a></li>
            		<li><a href="<?=$pathURL?>?type=5"><?=JY_getJumpNameByType("5")?></a></li>
            		<li><a href="<?=$pathURL?>?type=6"><?=JY_getJumpNameByType("6")?></a></li>
            		<li><a href="<?=$pathURL?>?type=7"><?=JY_getJumpNameByType("7")?></a></li>
            	</ul>
    	</div>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>小喇叭消息列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>内容</th>
						<th>客户端</th>
                        <th>图片</th>
                        <th>类型</th>
                        <th>跳转Url</th>
                        <th>发布时间</th>
						<th>添加时间</th>
						<th>状态</th>
						<th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($sysNoticeList as $index => $item):?>
                		<tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
	                    <td><?=$item['id']?></td>
	                    <td><?=$item['title']?></td>
	                    <td><?=$item['content']?></td>
                        <td><?=$item['os']?></td>
						<?php if($item['imageUrl']):?>
						    <td><img width="72" src="<?=$item['imageUrl']?>"></td>
						<?php else:?>
							<td>无图</td>
						<?php endif;?>
                        <td><?=JY_getJumpNameByType($item['type'])?></td>
	                    <td><?=$item['jumpUrl']?></td>
	                    <td><?=$item['pubTime']?></td>
	                    <td><?=$item['addTime']?></td>
						 <?php if ($item['isSend'] == 1):?>
	                        <td>发送中</td>
	                    <?php elseif ($item['isSend'] == 2 && $item['os'] == 'android'):?>
                             <td>已发送</td>
                        <?php elseif ($item['isSend'] == 2 && $item['os'] == 'all'):?>
                             <td>安卓已发送|苹果发送中</td>
                        <?php elseif ($item['isSend'] == 2 && $item['os'] == 'ios'):?>
                             <td>苹果发送中</td>
                        <?php elseif ($item['isSend'] > 2 && ($item['os'] == 'all' or $item['os'] == 'ios')):?>
                             <td>已发送</td>
                        <?php else:?>
	                    	<td>待发送</td>
	                    <?php endif;?>
	                    <td>
						<?php if($item['isSend'] == 0):?>
	                    	<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-danger del-btn">删除</a>
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
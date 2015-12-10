
<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/pushboard/pushEdit" class="btn btn-primary">添加</a>
	    	
	    	<div class="btn-group">
    		<?php if ($isSend === "0" OR $isSend === "1" OR $isSend === "2"):?>
                <?php
                    if ($isSend === "1") {
                        $sendText = "发送中";
                    } else if ($isSend === "2") {
                        $sendText = "已发送";
                    } else {
                        $sendText = "待发送";
                    }
                ?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$sendText?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择状态<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>">所有类型</a></li>
            		<li><a href="<?=$pathURL?>?isSend=0">待发送</a></li>
            		<li><a href="<?=$pathURL?>?isSend=1">发送中</a></li>
                    <li><a href="<?=$pathURL?>?isSend=2">已发送</a></li>
            	</ul>
    	</div>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>消息列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>标题</th>
                        <th>内容</th>
                        <th>客户端</th>
                        <th>类型</th>
                        <th>跳转Url</th>
                        <th>添加时间</th>
                        <th>推送时间</th>
                        <th>状态</th>
						<th>Version</th>
                        <th>登陆</th>
                        <th>未登陆</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($pushList as $index => $item):?>
                		<tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
	                    <td><?=$item['id']?></td>
	                    <td><?=$item['title']?></td>
	                    <td><?=$item['content']?></td>
                        <td><?=$item['os']?></td>
                        <td><?=JY_getJumpNameByType($item['type'])?></td>
                        <td><?=$item['jumpUrl']?></td>
	                    <td><?=$item['addTime']?></td>
	                    <td><?=$item['pushTime']?></td>
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
						<td><?=$item['version']?></td>
						<td><?=$item['loginDays']?></td>
                        <td><?=$item['unLoginDays']?></td>
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

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
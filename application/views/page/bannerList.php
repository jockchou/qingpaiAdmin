<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/banner/editBanner" class="btn btn-primary">添加</a>
	    	
			<?php 
				function getBannerNameByPageType($pageType) {
					switch($pageType) {
						case 1: return '达人页';
						case 2: return '话题页';
						default: return '选择页面类型';
					}
				}
				
				function getJumpUrlNameByType($type) {
					switch($type) {
						case 1: return 'H5页面';
						case 2: return '话题详情页';
						default: return '选择跳转类型';
					}
				}
			?>
			
			<div class="btn-group">
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=getBannerNameByPageType((int)$pageType) ?><span class="caret"></span></button>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>?type=<?=$type?>">所有页面类型</a></li>
            		<li><a href="<?=$pathURL?>?pageType=1&type=<?=$type?>"><?=getBannerNameByPageType(1)?></a></li>
            		<li><a href="<?=$pathURL?>?pageType=2&type=<?=$type?>"><?=getBannerNameByPageType(2)?></a></li>
            	</ul>
			</div>
			
	    	<div class="btn-group">
    		<?php if ($type):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=getJumpUrlNameByType((int)$type)?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择跳转类型<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>?pageType=<?=$pageType?>">所有跳转类型</a></li>
            		<li><a href="<?=$pathURL?>?pageType=<?=$pageType?>&type=1"><?=getJumpUrlNameByType(1)?></a></li>
            		<li><a href="<?=$pathURL?>?pageType=<?=$pageType?>&type=2"><?=getJumpUrlNameByType(2)?></a></li>
            	</ul>
			</div>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>banner列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>图片</th>
                        <th>页面类型</th>
                        <th>跳转类型</th>
                        <th>上线时间</th>
						<th>添加时间</th>
						<th>状态</th>
						<th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($bannerList as $index => $item):?>
						<tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
							<td><?=$item['id']?></td>
							<?php if($item['imageUrl']):?>
								<td><img width="72" src="<?=$item['imageUrl']?>"></td>
							<?php else:?>
								<td>无图</td>
							<?php endif;?>
							<td><?=getBannerNameByPageType((int)$item['pageType'])?></td>
							<td><?=getJumpUrlNameByType((int)$item['type'])?></td>
							<td><?=$item['onlineTime']?></td>
							<td><?=$item['addTime']?></td>
							<?php if ($item['state'] == 0):?>
								<td><span class="badge badge-success">上线</span></td>
							<?php else:?>
								 <td><span class="badge badge-important">下线</span></td>
							<?php endif;?>
							<td>
							<?php if ($item['state'] == 0):?>
								<a data-id="<?=$item['id']?>" href="javascript:void(0);" class="btn mini-btn btn-info offline-btn">下线</a>
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
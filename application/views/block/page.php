<?php
	$prevPage = $pageNo - 1;
	$nextPage = $pageNo + 1;
	if ($prevPage <= 0) {
		$prevPage = 1;
	}
	if ($nextPage > $totalPages) {
		$nextPage = $totalPages;
	}
?>
<div data-pages="<?=$totalPages?>" class="fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix">
	<div class="dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_full_numbers">
	<?php if ($totalPages > 1 && $pageNo <= $totalPages):?>
		<?php if ($pageNo == 1):?>
			<a class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default ui-state-disabled">首页</a>
		<?php else:?>
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=1'?>" class="first ui-corner-tl ui-corner-bl fg-button ui-button ui-state-default">首页</a>
		<?php endif;?>
		
		<?php if ($pageNo <= 1):?>
			<a class="previous fg-button ui-button ui-state-default ui-state-disabled">上一页</a>
		<?php else:?>
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . $prevPage?>" class="previous fg-button ui-button ui-state-default">上一页</a>
		<?php endif;?>
		
		<span>
			<?php if($pageNo !== 1):?>
				<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=1'?>" class="fg-button ui-button ui-state-default">1</a>
			<?php endif;?>
			
			<?php if($pageNo - 2 > 1):?>
				<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . ($pageNo-2)?>" class="fg-button ui-button ui-state-default"><?=($pageNo-2)?></a>
			<?php endif;?>
			<?php if($pageNo - 1 > 1):?>
				<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . ($pageNo-1)?>" class="fg-button ui-button ui-state-default"><?=($pageNo-1)?></a>
			<?php endif;?>
			
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . $pageNo?>" class="fg-button ui-button ui-state-default ui-state-disabled"><?=$pageNo?></a>
			
			<?php if($pageNo + 1 <= $totalPages):?>
				<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . ($pageNo+1)?>" class="fg-button ui-button ui-state-default"><?=($pageNo+1)?></a>
			<?php endif;?>
			<?php if($pageNo + 2 <= $totalPages):?>
				<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . ($pageNo+2)?>" class="fg-button ui-button ui-state-default"><?=($pageNo+2)?></a>
			<?php endif;?>
		</span>
        
        <?php if($pageNo != $totalPages && ($pageNo+2) < $totalPages):?>
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . $totalPages?>" class="fg-button ui-button ui-state-default"><?=$totalPages?></a>
		<?php endif;?>
		
        <?php if($pageNo >= $totalPages):?>
			<a class="next fg-button ui-button ui-state-default ui-state-disabled">下一页</a>
		<?php else:?>
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . $nextPage?>" class="next fg-button ui-button ui-state-default">下一页</a>
		<?php endif;?>
		
        <?php if($pageNo != $totalPages):?>
			<a href="<?=$pageUrl . '&pageSize=' . $pageSize . '&pageNo=' . $totalPages?>" class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default">末页</a>
		<?php else:?>
			<a class="last ui-corner-tr ui-corner-br fg-button ui-button ui-state-default ui-state-disabled">末页</a>
		<?php endif;?>
    <?php endif;?>
	</div>
</div>
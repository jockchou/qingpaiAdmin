<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	        <div class="btn-group">
				<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$month?><span class="caret"></span></button>
	        	<ul class="dropdown-menu">
	        		<?php foreach(range(1, 12) as $item):?>
	        		<li><a href="/analytics/report?month=<?=date('Y-') . $item?>"><?=date('Y-') . $item?></a></li>
	                <?php endforeach;?>
	        	</ul>
	    	</div>
	    	<a href="/analytics/exportReportExcel?month=<?=$month?>" date-month="<?=$month?>" class="btn btn-primary">导出Excel表格</a>
	    </div>
	</div>
	
    
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
        <h5>举报统计(<?=$month?>)</h5>
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
           	  <th>日期</th>
              <th>总文章数</th>
              <th>评论数</th>
            </tr>
          </thead>
          <tbody>
          <?php $n1 = $n2 = $n3 = $n4 = $n5 = $n6 = $n7 = 0;?>
          <?php foreach($reportAnalytics as $index => $item):?>
          	<?php
          		$n1 = $item['all_topic'] + $n1;
          		$n2 = $item['all_comment'] + $n2;
          		
          	?>
            <tr class="odd gradeX">
              <th><?=$item['pubTime']?></th>
              <th><?=$item['all_topic']?></th>
              <th><?=$item['all_comment']?></th>
            </tr>
            <?php endforeach;?>
            <tr class="even gradeX">
              <th>总计</th>
              <th><?=$n1?></th>
              <th><?=$n2?></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
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
	        		<li><a href="/analytics/topic?month=<?=date('Y-') . $item?>"><?=date('Y-') . $item?></a></li>
	                <?php endforeach;?>
	        	</ul>
	    	</div>
	    	<a href="/analytics/exportTopicExcel?month=<?=$month?>" date-month="<?=$month?>" class="btn btn-primary">导出Excel表格</a>
	    </div>
	</div>
	
    <style type="text/css">
      .widget-content {overflow-x:auto;}
      table th {white-space: nowrap;}
    </style>
    
    <div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
        <h5>瓶子统计(<?=$month?>)</h5>
      </div>

      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
           	  <th>日期</th>
              <th>总瓶子数</th>
              <th>Android总瓶子数</th>
              <th>IOS总瓶子数</th>
              <th>当天发瓶子数(包含机器人)</th>
              
              <th>未审核</th>
              <th>通过</th>
              <th>不通过</th>
              <th>删除</th>

              <th>机器人总数</th>
              <th>Android总数</th>
              <th>IOS总数</th>

              <th>Android未审核</th>
              <th>Android通过</th>
              <th>Android不通过</th>
              <th>Android删除</th>

              <th>IOS未审核</th>
              <th>IOS通过</th>
              <th>IOS不通过</th>
              <th>IOS删除</th>
              
              <th>收到漂流瓶的数量</th>
              <th>阅读漂流瓶的数量</th>
              <th>回复漂流瓶的数量</th>

              <th>优质贴</th>

            </tr>
          </thead>
          <tbody>
          <?php

            $n1_0 =  $n1_1 =  $n1_2 = $n2 = $n3 = $n4 = $n5 = $n6 = $n7 = $n8 = $n9 = $n10 = $n11 = $n12 = $n13 = $n14 = $n15 = $n16 = $n17 = $n18 = $n19 = $n20 = $n21 = 0;

          ?>
          <?php foreach($topicAnalytics as $index => $item):?>
          	<?php

              $n1_0 += $item['all_total_pub_topic'];
              $n1_1 += $item['android_total_pub_topic'];
              $n1_2 += $item['ios_total_pub_topic'];
              $n2 += $item['all_pub_topic']; // MySQL计算
              
              $n3 += $item['all_0_pub_topic'];
          		$n4 += $item['all_1_pub_topic'];
          		$n5 += $item['all_-1_pub_topic'];
          		$n6 += $item['all_-2_pub_topic'];
          		
              $n18 += $item['robit_topic'];
              $n19 += $item['android_total'];
              $n20 += $item['ios_total'];

              $n7 += $item['android_0_pub_topic'];
          		$n8 += $item['android_1_pub_topic'];
          		$n9 += $item['android_-1_pub_topic'];
              $n10 += $item['android_-2_pub_topic'];

              $n11 += $item['ios_0_pub_topic'];
              $n12 += $item['ios_1_pub_topic'];
              $n13 += $item['ios_-1_pub_topic'];
              $n14 += $item['ios_-2_pub_topic'];

              $n15 += $item['recv_topic'];
              $n16 += $item['read_topic'];
              $n17 += $item['reply_topic'];

              $n21 += $item['highQuality_topic'];
          		
          	?>

            <tr class="odd gradeX">
              <th><?=$item['pubTime']?></th>
              
              <th><?=$item['all_total_pub_topic']?></th>
              <th><?=$item['android_total_pub_topic']?></th>
              <th><?=$item['ios_total_pub_topic']?></th>
              <th><?=$item['all_pub_topic']?></th>

              <th><?=$item['all_0_pub_topic']?></th>
              <th><?=$item['all_1_pub_topic']?></th>
              <th><?=$item['all_-1_pub_topic']?></th>
              <th><?=$item['all_-2_pub_topic']?></th>

              <th><?=$item['robit_topic']?></th>
              <th><?=$item['android_total']?></th>
              <th><?=$item['ios_total']?></th>

              <th><?=$item['android_0_pub_topic']?></th>
              <th><?=$item['android_1_pub_topic']?></th>
              <th><?=$item['android_-1_pub_topic']?></th>
              <th><?=$item['android_-2_pub_topic']?></th>

              <th><?=$item['ios_0_pub_topic']?></th>
              <th><?=$item['ios_1_pub_topic']?></th>
              <th><?=$item['ios_-1_pub_topic']?></th>
              <th><?=$item['ios_-2_pub_topic']?></th>

              <th><?=$item['recv_topic']?></th>
              <th><?=$item['read_topic']?></th>
              <th><?=$item['reply_topic']?></th>

              <th><?=$item['highQuality_topic']?></th>
            </tr>
            <?php endforeach;?>
            <tr class="even gradeX">
              <th>总计</th>
              <th><?=$n1_0?></th>
              <th><?=$n1_1?></th>
              <th><?=$n1_2?></th>
              <th><?=$n2?></th>

              <th><?=$n3?></th>
              <th><?=$n4?></th>
              <th><?=$n5?></th>
              <th><?=$n6?></th>

              <th><?=$n18?></th>
              <th><?=$n19?></th>
              <th><?=$n20?></th>

              <th><?=$n7?></th>
              <th><?=$n8?></th>
              <th><?=$n9?></th>
              <th><?=$n10?></th>
              <th><?=$n11?></th>
              <th><?=$n12?></th>
              <th><?=$n13?></th>
              <th><?=$n14?></th>
              <th><?=$n15?></th>
              <th><?=$n16?></th>
              <th><?=$n17?></th>

              <th><?=$n21?></th>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
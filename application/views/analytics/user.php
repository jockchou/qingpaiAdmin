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
	        		<li><a href="/analytics/user?month=<?=date('Y-') . $item?>"><?=date('Y-') . $item?></a></li>
	                <?php endforeach;?>
	        	</ul>
	    	</div>
	    	<a href="/analytics/exportUserExcel?month=<?=$month?>" date-month="<?=$month?>" class="btn btn-primary">导出Excel表格</a>
	    </div>
	</div>
    
    <style type="text/css">
      .widget-content {overflow-x:auto;}
      table th {white-space: nowrap;}
    </style>

    <div class="widget-box">
      <div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
        <h5>新增注册用户统计(<?=$month?>)</h5>
      </div>
      <div class="widget-content nopadding">
        <table class="table table-bordered table-striped with-check">
          <thead>
            <tr>

           	  <th>日期</th>

              <th>有效用户</th>
              <th>封号</th>
              <th>Android有效</th>
              <th>Android封号</th>
              <th>IOS有效</th>
              <th>IOS封号</th>

              <th>活跃</th>
              <th>Android活跃</th>
              <th>IOS活跃</th>

              <th>登录次数</th>
              <th>Android登录次数</th>
              <th>IOS登录次数</th>

              <th>发送漂流瓶独立数</th>
              <th>Android发送漂流瓶独立数</th>
              <th>IOS发送漂流瓶独立数</th>

              <th>收到漂流瓶独立数</th>
              <th>阅读漂流瓶独立数</th>
              <th>回复漂流瓶独立数</th>

              <th>累计注册</th>
              <th>Android累计注册</th>
              <th>IOS累计注册</th>
            </tr>
          </thead>
          <tbody>
          <?php
            for ($i=1; $i <= 21; $i++) {
              $ni = "n" .  $i;
              $$ni = 0;
            }
          ?>
          <?php foreach($userAnalytics as $index => $item):?>
          	<?php
              $n1 += $item['all_0_register_user'];
              $n2 += $item['all_1_register_user'];
              $n3 += $item['android_0_register_user'];
              $n4 += $item['android_1_register_user'];
              $n5 += $item['ios_0_register_user'];
              $n6 += $item['ios_1_register_user'];
              $n7 += $item['all_active_user'];
              $n8 += $item['android_active_user'];
              $n9 += $item['ios_active_user'];
              $n10 += $item['all_login_times'];
              $n11 += $item['android_login_times'];
              $n12 += $item['ios_login_times'];
              $n13 += $item['all_pub_topic_user'];
              $n14 += $item['android_pub_topic_user'];
              $n15 += $item['ios_pub_topic_user'];
              $n16 += $item['recv_topic_user'];
              $n17 += $item['read_topic_user'];
              $n18 += $item['reply_topic_user'];
              $n19 += $item['all_register_pass_user'];
              $n20 += $item['android_register_pass_user'];
              $n21 += $item['ios_register_pass_user'];
          	?>

            <tr class="odd gradeX">
              <th><?=$item['pubTime']?></th>
              <th><?=$item['all_0_register_user']?></th>
              <th><?=$item['all_1_register_user']?></th>
              <th><?=$item['android_0_register_user']?></th>
              <th><?=$item['android_1_register_user']?></th>
              <th><?=$item['ios_0_register_user']?></th>
              <th><?=$item['ios_1_register_user']?></th>
              <th><?=$item['all_active_user']?></th>
              <th><?=$item['android_active_user']?></th>
              <th><?=$item['ios_active_user']?></th>
              <th><?=$item['all_login_times']?></th>
              <th><?=$item['android_login_times']?></th>
              <th><?=$item['ios_login_times']?></th>
              <th><?=$item['all_pub_topic_user']?></th>
              <th><?=$item['android_pub_topic_user']?></th>
              <th><?=$item['ios_pub_topic_user']?></th>
              <th><?=$item['recv_topic_user']?></th>
              <th><?=$item['read_topic_user']?></th>
              <th><?=$item['reply_topic_user']?></th>
              <th><?=$item['all_register_pass_user']?></th>
              <th><?=$item['android_register_pass_user']?></th>
              <th><?=$item['ios_register_pass_user']?></th>
            </tr>

            <?php endforeach;?>

            <tr class="even gradeX">
              <th>总计</th>
              
              <?php
                for ($i=1; $i <= 21; $i++) {
                  $ni = "n" .  $i
              ?>
                 <th><?=$$ni?></th>
              <?php
                }
              ?>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</div>
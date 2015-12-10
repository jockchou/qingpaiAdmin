<?php include("block/frame_top.php");?>

<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<div class="span12">
			    <div class="widget-box">
		            <div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	            <h5>操作</h5>
	                </div>
					<div class="widget-content">
	                    <div class="btn-group">
				            <input id='date' type='date' value='<?=$date?>'/>
	    	            </div>
	                </div>
	            </div>
				<div class="widget-box">
		 			<div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
					    <h5>活跃统计折线图</h5>
		  			</div>
			  		<div class="widget-content">
						<div id="chart-container">
						</div>
			  		</div>
					
				</div>
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="icon-th"></i> </span>
						<h5><?=$date?>数据统计</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped">
						    <thead>
						        <tr>
								    <th>日期</th>
									<th>新增帖子数</th>
									<th>活跃用户数</th>
									<th>用户总数</th>
								</tr>
						    </thead>
							<tbody>
							<!--循环添加统计数据到列表中-->
							<?php foreach($topicAndUserNum as $key => $item):?>
							    <tr class="odd gradeX">
								    <th><?=substr($item['addTime'], 11, 5)?></th>
									<th><?=$item['topicNum']?></th>
									<th><?=$item['activityUserNum']?></th>
									<th><?=$item['totalUserNum']?></th>
								</tr>
								
							<?php endforeach;?>
							</tbody>
					    </table>
					</div>
				</div>
		 	</div>
	    </div>
    </div>
</div>
<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>

<script src="/static/js/lib/highcharts/highcharts.js"></script>
<script type="text/javascript">

<?php
    $xArray = array();//折线图横坐标数组
    $timeArray = array();//记录时刻的数组
	$topicNumArray = array();//一天内每个时刻的新增帖子数组
	$activeUserNumArray = array();//活跃用户数组
	$totalUserNumArray = array();//总人数数组
	
	for($i = 0; $i < 48;$i++){
		array_push($xArray, $i);
		array_push($topicNumArray, 0);
		array_push($activeUserNumArray, 0);
		array_push($totalUserNumArray, 0);
		if($i%2 == 0){
			if($i < 20)array_push($timeArray, '0' . floor($i/2) . ':00');
			else array_push($timeArray, floor($i/2) . ':00');
		}
		else{
			if($i < 20)array_push($timeArray, '0' . floor($i/2) . ':30');
		    else array_push($timeArray, floor($i/2) . ':30');
		} 
	}
	
    foreach($topicAndUserNum as $key => $item){
		$str = substr($item['addTime'], 11, 5);
		$keys = array_keys($timeArray, $str);
        $topicNumArray[$keys[0]] = (int)$item['topicNum'];
        $activeUserNumArray[$keys[0]] = (int)$item['activityUserNum'];
        $totalUserNumArray[$keys[0]] =(int)$item['totalUserNum'];	
    }
	
?>
$(function () {
	//日期控件改变响应
	$('#date').change(function(){
		location.href = '/analytics/topicAndUser?date='+this.value;
	});
	//画出活跃用户和新增帖子数统计图
	$('#chart-container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '新增帖子和活跃用户统计信息',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$date?>帖子和用户折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($xArray)?>
        },
        yAxis: {
            title: {
                text: '统计数据 (个)'
            },
            min: 0,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            //valueSuffix: '个'
			formatter: function(){
				var timeArray = <?=json_encode($timeArray)?>;
				var totalUserNum = <?=json_encode($totalUserNumArray)?>;
				return '<b>时刻：</b>'+timeArray[this.x]+'<br>'
				+'<b>'+this.series.name+'数量：</b>'+this.y+'<br>'
				+'<b>用户总数：</b>'+totalUserNum[this.x];
			}
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: false
                },
                enableMouseTracking: true
            }
        },

        series: [
            {
                name: '新增帖子',
                data: <?=json_encode($topicNumArray)?>
            },
            {
                name: '活跃用户',
                data: <?=json_encode($activeUserNumArray)?>
            }
        ]
    });
});


</script>
</body>
</html>
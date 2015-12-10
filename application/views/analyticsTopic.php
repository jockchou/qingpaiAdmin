<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<div class="span12">
				<div class="widget-box">
		 			<div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
					<h5>瓶子统计折线图</h5>
		  			</div>
			  		<div class="widget-content">
						<div id="chart-container">
						</div>
			  		</div>
				</div>
		 	</div>
	    </div>
	    
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                    <h5>瓶子统计折线图2</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-container2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

	    <div class="row-fluid">
	    	<?php include("analytics/topic.php");?>
	    </div>
	    
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
<script src="/static/js/lib/highcharts/highcharts.js"></script>
<script type="text/javascript">
<?php
	$dayArray = array();

    $all_total_pub_topic = array();
    $android_total_pub_topic = array();
    $ios_total_pub_topic = array();

	$all_0_pub_topic = array();
	$all_1_pub_topic = array();
	$all_f1_pub_topic = array();
	$all_f2_pub_topic = array();
    
    $android_0_pub_topic = array();
    $android_1_pub_topic = array();
    $android_f1_pub_topic = array();
    $android_f2_pub_topic = array();

    $android_0_pub_topic = array();
    $android_1_pub_topic = array();
    $android_f1_pub_topic = array();
    $android_f2_pub_topic = array();

    $ios_0_pub_topic = array();
    $ios_1_pub_topic = array();
    $ios_f1_pub_topic = array();
    $ios_f2_pub_topic = array();

	$recv_topic = array();
	$read_topic = array();
	$reply_topic = array();

	foreach ($topicAnalytics as $idx => $item ) {

        array_push($dayArray, substr($item['pubTime'], 8, 2));

        array_push($all_total_pub_topic, (int)$item['all_total_pub_topic']);
        array_push($android_total_pub_topic, (int)$item['android_total_pub_topic']);
        array_push($ios_total_pub_topic, (int)$item['ios_total_pub_topic']);

        array_push($all_0_pub_topic, (int)$item['all_0_pub_topic']);
        array_push($all_1_pub_topic, (int)$item['all_1_pub_topic']);
        array_push($all_f1_pub_topic, (int)$item['all_-1_pub_topic']);
        array_push($all_f2_pub_topic, (int)$item['all_-2_pub_topic']);

        array_push($android_0_pub_topic, (int)$item['android_0_pub_topic']);
        array_push($android_1_pub_topic, (int)$item['android_1_pub_topic']);
        array_push($android_f1_pub_topic, (int)$item['android_-1_pub_topic']);
        array_push($android_f2_pub_topic, (int)$item['android_-2_pub_topic']);

        array_push($ios_0_pub_topic, (int)$item['ios_0_pub_topic']);
        array_push($ios_1_pub_topic, (int)$item['ios_1_pub_topic']);
        array_push($ios_f1_pub_topic, (int)$item['ios_-1_pub_topic']);
        array_push($ios_f2_pub_topic, (int)$item['ios_-2_pub_topic']);

		array_push($recv_topic, (int)$item['recv_topic']);
		array_push($read_topic, (int)$item['read_topic']);
		array_push($reply_topic, (int)$item['reply_topic']);
	}
?>

$(function () {
    $('#chart-container').highcharts({
    	chart: {
            type: 'line'
        },
        title: {
            text: '瓶子统计信息(<?=$month?>)',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$month?>瓶子折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($dayArray);?>
        },
        yAxis: {
            title: {
                text: '瓶子数据 (条)'
            },
            min: 0,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '条'
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
                name: '累计',
                data: <?=json_encode($all_total_pub_topic);?>
            }, 
            {
                name: 'Android累计',
                data: <?=json_encode($android_total_pub_topic);?>
            },
            {
                name: 'IOS累计',
                data: <?=json_encode($ios_total_pub_topic);?>
            },
            {
                name: '未审核',
                data: <?=json_encode($all_0_pub_topic);?>
            }, 
            {
                name: '通过',
                data: <?=json_encode($all_1_pub_topic);?>
            },
            {
                name: '未通过',
                data: <?=json_encode($all_f1_pub_topic);?>
            },
            {
                name: '已删除',
                data: <?=json_encode($all_f2_pub_topic);?>
            },
            {
                name: 'Android未审核',
                data: <?=json_encode($android_0_pub_topic);?>
            }, 
            {
                name: 'Android通过',
                data: <?=json_encode($android_1_pub_topic);?>
            },
            {
                name: 'Android未通过',
                data: <?=json_encode($android_f1_pub_topic);?>
            },
            {
                name: 'Android已删除',
                data: <?=json_encode($android_f2_pub_topic);?>
            },
            {
                name: 'IOS未审核',
                data: <?=json_encode($ios_0_pub_topic);?>
            }, 
            {
                name: 'IOS通过',
                data: <?=json_encode($ios_1_pub_topic);?>
            },
            {
                name: 'IOS未通过',
                data: <?=json_encode($ios_f1_pub_topic);?>
            },
            {
                name: 'IOS已删除',
                data: <?=json_encode($ios_f2_pub_topic);?>
            }
        ]
    });

    $('#chart-container2').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '瓶子统计信息(<?=$month?>)',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$month?>瓶子折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($dayArray);?>
        },
        yAxis: {
            title: {
                text: '瓶子数据 (条)'
            },
            min: 0,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '条'
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
                name: '收到漂流瓶',
                data: <?=json_encode($recv_topic);?>
            },
            {
                name: '阅读漂流瓶',
                data: <?=json_encode($read_topic);?>
            },
            {
                name: '回复漂流瓶',
                data: <?=json_encode($reply_topic);?>
            }
        ]
    });
});
</script>
</body>
</html>

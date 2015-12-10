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
					<h5>新增用户统计折线图</h5>
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
                    <h5>用户统计折线图2</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-container2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-signal"></i> </span>
                    <h5>用户统计折线图3</h5>
                    </div>
                    <div class="widget-content">
                        <div id="chart-container3">
                        </div>
                    </div>
                </div>
            </div>
        </div>

	    <div class="row-fluid">
	    	<?php include("analytics/user.php");?>
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

	$all_0_register_user = array();
    $all_1_register_user = array();
    $android_0_register_user = array();
    $android_1_register_user = array();
    $ios_0_register_user = array();
    $ios_1_register_user = array();

    $all_active_user = array();
    $android_active_user = array();
    $ios_active_user = array();

    $all_login_times = array();
    $android_login_times = array();
    $ios_login_times = array();

    $all_pub_topic_user = array();
    $android_pub_topic_user = array();
    $ios_pub_topic_user = array();

    $recv_topic_user = array();
    $read_topic_user = array();
    $reply_topic_user = array();

    $all_register_pass_user = array();
    $android_register_pass_user = array();
    $ios_register_pass_user = array();

	foreach ($userAnalytics as $idx => $item ) {
		
        array_push($dayArray, substr($item['pubTime'], 8, 2));

		array_push($all_0_register_user, (int)$item['all_0_register_user']);
        array_push($all_1_register_user, (int)$item['all_1_register_user']);
        array_push($android_0_register_user, (int)$item['android_0_register_user']);
        array_push($android_1_register_user, (int)$item['android_1_register_user']);
        array_push($ios_0_register_user, (int)$item['ios_0_register_user']);
        array_push($ios_1_register_user, (int)$item['ios_1_register_user']);

        array_push($all_active_user, (int)$item['all_active_user']);
        array_push($android_active_user, (int)$item['android_active_user']);
        array_push($ios_active_user, (int)$item['ios_active_user']);

        array_push($all_login_times, (int)$item['all_login_times']);
        array_push($android_login_times, (int)$item['android_login_times']);
        array_push($ios_login_times, (int)$item['ios_login_times']);

        array_push($all_pub_topic_user, (int)$item['all_pub_topic_user']);
        array_push($android_pub_topic_user, (int)$item['android_pub_topic_user']);
        array_push($ios_pub_topic_user, (int)$item['ios_pub_topic_user']);

        array_push($recv_topic_user, (int)$item['recv_topic_user']);
        array_push($read_topic_user, (int)$item['read_topic_user']);
        array_push($reply_topic_user, (int)$item['reply_topic_user']);

        array_push($all_register_pass_user, (int)$item['all_register_pass_user']);
        array_push($android_register_pass_user, (int)$item['android_register_pass_user']);
        array_push($ios_register_pass_user, (int)$item['ios_register_pass_user']);
	}
?>
$(function () {
    $('#chart-container').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '新增用户统计信息(<?=$month?>)',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$month?>新增用户折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($dayArray);?>
        },
        yAxis: {
            title: {
                text: '单位 (个)'
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
                name: '可用',
                data: <?=json_encode($all_0_register_user);?>
            },
            {
                name: '封号',
                data: <?=json_encode($all_1_register_user);?>
            },
            {
                name: 'Android可用',
                data: <?=json_encode($android_0_register_user);?>
            },
            {
                name: 'Android封号',
                data: <?=json_encode($android_1_register_user);?>
            },
            {
                name: 'IOS可用',
                data: <?=json_encode($ios_0_register_user);?>
            },
            {
                name: 'IOS封号',
                data: <?=json_encode($ios_1_register_user);?>
            },  
            {
                name: '活跃',
                data: <?=json_encode($all_active_user);?>
            },
            {
                name: 'Android活跃',
                data: <?=json_encode($android_active_user);?>
            },
            {
                name: 'IOS活跃',
                data: <?=json_encode($ios_active_user);?>
            },
            {
                name: '累计注册',
                data: <?=json_encode($all_register_pass_user);?>
            },
            {
                name: 'Andoid累计用户数',
                data: <?=json_encode($android_register_pass_user);?>
            },
            {
                name: 'IOS累计用户数',
                data: <?=json_encode($ios_register_pass_user);?>
            }
        ]
    });
});

$(function () {
    $('#chart-container2').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '用户统计信息(<?=$month?>)',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$month?>用户折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($dayArray);?>
        },
        yAxis: {
            title: {
                text: '单位 (个)'
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
                name: '登录次数',
                data: <?=json_encode($all_login_times);?>
            },
            {
                name: 'Android登录次数',
                data: <?=json_encode($android_login_times);?>
            },
            {
                name: 'IOS登录次数',
                data: <?=json_encode($ios_login_times);?>
            }
        ]
    });
});

$(function () {
    $('#chart-container3').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: '用户统计信息(<?=$month?>)',
            x: -20 //center
        },
        subtitle: {
            text: '<?=$month?>用户折线图',
            x: -20
        },
        xAxis: {
            categories: <?=json_encode($dayArray);?>
        },
        yAxis: {
            title: {
                text: '单位 (个)'
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
                name: '发送漂流瓶独立数',
                data: <?=json_encode($all_pub_topic_user);?>
            },
            {
                name: 'Android发送漂流瓶独立数',
                data: <?=json_encode($android_pub_topic_user);?>
            },
            {
                name: 'IOS发送漂流瓶独立数',
                data: <?=json_encode($ios_pub_topic_user);?>
            },
            {
                name: '收到漂流瓶独立数',
                data: <?=json_encode($recv_topic_user);?>
            },
            {
                name: '阅读漂流瓶独立数',
                data: <?=json_encode($read_topic_user);?>
            },
            {
                name: '回复漂流瓶独立数',
                data: <?=json_encode($reply_topic_user);?>
            }
        ]
    });
});
</script>
</body>
</html>

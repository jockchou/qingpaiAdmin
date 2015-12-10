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
					<h5>后台发贴统计折线图</h5>
		  			</div>
			  		<div class="widget-content">
						<div id="chart-container">
						</div>
			  		</div>
				</div>
		  </div>
	    </div>
	    
	    <div class="row-fluid">
	    	<?php include("analytics/water.php");?>
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
	$monthArray = array();
	$allTopicList = array();
	$allCommentList = array();
	$allPariseList = array();
	foreach ($topicAnalytics as $idx => $item ) {
		array_push($monthArray, substr($item['pubTime'], 8, 2));
		array_push($allTopicList, (int)$item['all_topic']);
		array_push($allCommentList, (int)$item['all_comment']);
		array_push($allPariseList, (int)$item['all_parise']);
	}
	
?>
$(function () {
        $('#chart-container').highcharts({
            title: {
                text: '后台发贴统计信息(<?=$month?>)',
                x: -20 //center
            },
            subtitle: {
                text: '<?=$month?>后台发贴折线图',
                x: -20
            },
            xAxis: {
                categories: <?=json_encode($monthArray);?>
            },
            yAxis: {
                title: {
                    text: '文章数据 (条)'
                },
                min: 0,
                tickInterval: 400,
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valueSuffix: '条'
            },
            series: [{
                name: '总文章',
                data: <?=json_encode($allTopicList);?>
            }, {
                name: '评论数',
                data: <?=json_encode($allCommentList);?>
            }, {
                name: '点赞数',
                data: <?=json_encode($allPariseList);?>
            }]
        });
    });
</script>
</body>
</html>

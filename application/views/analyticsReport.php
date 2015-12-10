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
					<h5>举报统计折线图</h5>
		  			</div>
			  		<div class="widget-content">
						<div id="chart-container">
						</div>
			  		</div>
				</div>
		  </div>
	    </div>
	    
	    <div class="row-fluid">
	    	<?php include("analytics/report.php");?>
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
	foreach ($reportAnalytics as $idx => $item ) {
		array_push($monthArray, substr($item['pubTime'], 8, 2));
		array_push($allTopicList, (int)$item['all_topic']);
		array_push($allCommentList, (int)$item['all_comment']);
	}
	
?>
$(function () {
        $('#chart-container').highcharts({
            title: {
                text: '文章举报统计信息(<?=$month?>)',
                x: -20 //center
            },
            subtitle: {
                text: '<?=$month?>文章举报折线图',
                x: -20
            },
            xAxis: {
                categories: <?=json_encode($monthArray);?>
            },
            yAxis: {
                title: {
                    text: '单位 (条)'
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
            series: [{
                name: '总文章',
                data: <?=json_encode($allTopicList);?>
            }, {
                name: '总评论',
                data: <?=json_encode($allCommentList);?>
            }]
        });
    });
</script>
</body>
</html>

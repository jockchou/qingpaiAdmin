<div class="row-fluid">
	<div id="footer" class="span12">
		2014 &copy; JoyoDream Admin.
	</div>
</div>
<script type="text/javascript" src="/static/js/selectpic.js"></script>
<script type="text/javascript" src="/static/js/jquery.min.js"></script> 
<script type="text/javascript" src="/static/js/jquery.ui.custom.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/static/js/masked.js"></script>
<script type="text/javascript" src="/static/js/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="/static/js/jquery.peity.min.js"></script> 
<script type="text/javascript" src="/static/js/jquery.uniform.js"></script>  
<script type="text/javascript" src="/static/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="/static/js/select2.min.js"></script>
<script type="text/javascript" src="/static/js/matrix.js"></script>
<script type="text/javascript" src="/static/js/matrix.tables.js"></script>
<script type="text/javascript" src="/static/js/matrix.form_common.js"></script>
<script type="text/javascript" src="/static/js/jquery.ui.widget.js"></script>
<script type="text/javascript" src="/static/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="/static/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="/static/js/bootstrap-wysihtml5.js"></script>
<script type="text/javascript" src="/static/js/lib/lhgcalendar/lhgcore.lhgcalendar.min.js"></script>
<script type="text/javascript" src="/static/js/lib/lhgcalendar/lhgcalendar.min.js"></script>
<script type="text/javascript">
  $(function(){
 	// 共用时间格式
    $('.commonPubTime').calendar({ format:'yyyy-MM-dd HH:mm:ss' });
    
    $('#beginTime').calendar({
    	format:'yyyy-MM-dd',
    	onSetDate:function() {
    		//alert('日期框原来的值为:'+this.inpE.value+',要用新选择的值:'+this.getDate('date')+'覆盖吗?');
    		
    		var beginTime = this.getDate('date');
    		var endTime = $("#endTime").val();

    		locationPage(beginTime, endTime);
    	}
    });

    $('#endTime').calendar({
    	format:'yyyy-MM-dd',
    	onSetDate:function() {
    		//alert('日期框原来的值为:'+this.inpE.value+',要用新选择的值:'+this.getDate('date')+'覆盖吗?');
    		
    		var beginTime = $("#beginTime").val();
    		var endTime = this.getDate('date');

    		locationPage(beginTime, endTime);
    	}
    });

    function locationPage(beginTime, endTime) {
    	if (beginTime == '' || endTime == '') { //清空时间
    		location.href = $("#locationHref").attr('data-href');
    	} else if (beginTime == '开始时间' || endTime == '结束时间') {

    	} else {
    		location.href = $("#locationHref").attr('data-href') + '&beginTime=' + beginTime + '&endTime=' + endTime;
    	}
    }

  });
</script>

<script type="text/javascript">
	$(function(){
		var url_string = "<?php if(isset($active_menu)) echo $active_menu; else echo uri_string();?>";
		var arr_url_string = url_string.split("/");
		<?php if (isset($type) AND uri_string() == "topic/topicList"):?>
			arr_url_string.push("<?=$type?>");
		<?php endif;?>
		var $active = $("#" + arr_url_string.join("-"));
		$active.addClass("active");
		$active.parent().parent().addClass("open");
	});
</script>
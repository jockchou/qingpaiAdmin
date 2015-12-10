
<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php print($crumbs);?>
	<!--End-breadcrumbs-->
	
	<div class="container-fluid">
	    <hr/>
	    <div class="row-fluid">
	    	<?php include("page/jjuserLocation.php");?>
	    </div>
    </div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7oDruIWjAj9Dkm647oak1tN3"></script>
<script type="text/javascript">

var map = new BMap.Map("baidumap");
window.map = map;

//104.65357,34.443525
var point = new BMap.Point(104.65357, 34.443525);

map.addControl(new BMap.NavigationControl());               //添加平移缩放控件
map.addControl(new BMap.ScaleControl());                    //添加比例尺控件
map.addControl(new BMap.OverviewMapControl());              //添加缩略地图控件
map.enableScrollWheelZoom();                            	//启用滚轮放大缩小
map.centerAndZoom(point, 5); 

var totalPages = 0;
var pageNo = 1;
var pageSize = 1000;
var ALL_LOC_LIST = [];

function loadUserLocation(pageNo) {
	var params = {
		pageNo: pageNo,
		pageSize: pageSize
	};
	
	$.getJSON("/jjuser/getUserLocationList", params, function(data) {
		totalPages = data.totalPages;
		pageNo = data.pageNo;
		showPoint(map, data.userLocationArray);
		
		if (pageNo < totalPages) {
			loadUserLocation(++pageNo);
		}
	});
}

function showUserWindow(map, point) {
	var user = point.userInfo;
	var wiid = "user-window-" + user.userID;
	var sexName = user.sex == 0  ? "男" : "女";
	var sContent = 
	"<h4 style='margin:0 0 5px 0;padding:0.2em 0'>"+user.nickname+"</h4>" + 
	"<img style='float:right;margin:2px' id='" +wiid+ "' src='" + user.headUrl + "' width='64' height='64'/>" + 
	"<p style='margin:0;line-height:1.5;font-size:13px;'>性别：" +sexName+ "</p>" + 
	"<p style='margin:0;line-height:1.5;font-size:13px;'>登录：" +user.lastLoginTime+ "</p>" + 
	"</div>";
	
	var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
	map.openInfoWindow(infoWindow, point); //开启信息窗口
	
	window.setTimeout(function(){
		var imgdom = document.getElementById(wiid);
		if (imgdom) {
			imgdom.onload = function (){
				infoWindow.redraw();
			}
		}
	}, 0);
}

function showPoint(map, pointArray) {
	var points = [],
	len = pointArray.length,
	loc = null,
	point = null,
	i;
	
    for (i = 0; i < len; i++) {
    	loc = pointArray[i];
    	point = new BMap.Point(loc.lng, loc.lat);
    	point.userInfo = loc;
      	points.push(point);
      	ALL_LOC_LIST.push(loc);
    }
    
    var options = {
        size: 3,
        shape: BMAP_POINT_SHAPE_CIRCLE,
        color: '#d340c3'
    };
    
    var pointCollection = new BMap.PointCollection(points, options);  // 初始化PointCollection
    
    pointCollection.addEventListener('mouseover', function (e) {
    	showUserWindow(map, e.point, e.point.userInfo);
    });
    
    map.addOverlay(pointCollection);  // 添加Overlay
}

loadUserLocation(1);

</script>
</body>
</html>

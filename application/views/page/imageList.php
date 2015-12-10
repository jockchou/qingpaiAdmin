<div class="span12">

<div class="widget-box">
	<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
    	<h5>操作</h5>
    </div>
    <div class="widget-content">
        <div class="btn-group">
    		<?php if (!empty($keyword)):?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle"><?=$keyword?><span class="caret"></span></button>
    		<?php else:?>
    			<button data-toggle="dropdown" class="btn dropdown-toggle">选择关键词<span class="caret"></span></button>
    		<?php endif;?>
            	<ul class="dropdown-menu">
            		<li><a href="<?=$pathURL?>">所有</a></li>
            		<li><a href="<?=$pathURL?>?keyword=美腿">美腿</a></li>
            		<li><a href="<?=$pathURL?>?keyword=有沟">有沟</a></li>
            		<li><a href="<?=$pathURL?>?keyword=小清新">小清新</a></li>
            		<li><a href="<?=$pathURL?>?keyword=性感">性感</a></li>
            		<li><a href="<?=$pathURL?>?keyword=美臀">美臀</a></li>
            		<li><a href="<?=$pathURL?>?keyword=文艺">文艺</a></li>
            		<li><a href="<?=$pathURL?>?keyword=宠物">宠物</a></li>
            		<li><a href="<?=$pathURL?>?keyword=风景">风景</a></li>
            		<li><a href="<?=$pathURL?>?keyword=美食">美食</a></li>
            	</ul>
    	</div>
	</div>
</div>

	<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
		    <h5>相册</h5>
		  </div>
		  
		  <div class="widget-content">
		  	<ul class="thumbnails">
		  	<?php foreach($imageList as $index => $item):?>
			      <li class="span2">
			      	<a target="_blank" href="/imglibs/addRobotTask?imgID=<?=$item['id']?>"><img src="<?= JY_QN_piclibs_url . $item['picName']?>" alt="<?=$item['picDesc']?>"></a>
			        <div class="actions">
			        	<a class="btn-delimg" data-id="<?=$item['id']?>" title="删除" href="javascript:void(0);"><i class="icon-plane"></i></a>
			        	<a class="lightbox_trigger" href="<?=JY_QN_piclibs_url . $item['picName']?>"><i class="icon-search"></i></a>
			        </div>
			      </li>
			<?php endforeach;?>
		    </ul>
		  </div>
	</div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
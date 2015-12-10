<div class="span12">
	<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
		    <h5>相册</h5>
		  </div>
		  
		  <div class="widget-content">
		  	<ul class="thumbnails">
		  	<?php foreach($imageList as $index => $item):?>
			      <li class="span2">
			      	<a href="<?=$item['imageUrl']?>"><img src="<?=$item['imageUrl']?>" alt="<?=$item['topicID']?>"></a>
			      </li>
			<?php endforeach;?>
		    </ul>
		  </div>
	</div>
</div>

<?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
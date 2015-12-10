<div class="span12">
	<div class="widget-box">
		  <div class="widget-title"> <span class="icon"> <i class="icon-picture"></i> </span>
		    <h5>相册</h5>
		  </div>
		  
		  <div class="widget-content">
		  	<ul class="thumbnails">
		  	<?php foreach($albumList as $index => $item):?>
			      <li class="span2">
			      	<a><img src="<?=$item['imageURL']?>" alt=""></a>
			        <div class="actions">
			        <a class="lightbox_trigger" href="<?=$item['imageURL']?>">
			        	<i class="icon-search"></i>
			        </a>
			        </div>
			      </li>
			<?php endforeach;?>
		    </ul>
		  </div>
	</div>
</div>
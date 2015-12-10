<?php include("block/frame_top.php");?>

<!--main-container-part-->
<div id="content">
	<!--breadcrumbs-->
	<?php if(isset($crumbs)):?>
		<?=$crumbs?>
	<?php else:?>
		<?php include("block/breadcrumbs.php");?>
	<?php endif;?>
	<!--End-breadcrumbs-->
    <hr/>
    <div class="container-fluid">
	<div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-title">
					<h5>处理结果</h5>
				</div>
				<div class="widget-content">
					<?php if(isset($message['error'])):?>
						<?php foreach($message['error'] as $item):?>
							<div class="alert alert-error alert-block">
								<a class="close" data-dismiss="alert" href="#">×</a>
								<h4 class="alert-heading">错误!</h4>
								<?=$item['messageText']?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
					
					<?php if(isset($message['warning'])):?>
						<?php foreach($message['warning'] as $index => $item):?>
							<div class="alert alert-block">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading">警告!</h4>
							<?=$item['messageText']?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
					
					
					<?php if(isset($message['success'])):?>
						<?php foreach($message['success'] as $index => $item):?>
							<div class="alert alert-success alert-block">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading">成功!</h4>
							<?=$item['messageText']?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
					
					
					<?php if(isset($message['info'])):?>
						<?php foreach($message['info'] as $index => $item):?>
							<div class="alert alert-info alert-block">
							<a class="close" data-dismiss="alert" href="#">×</a>
							<h4 class="alert-heading">提示!</h4>
							<?=$item['messageText']?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!--end-main-container-part-->

<!--Footer-part-->
<?php include("block/footer.php");?>
<!--end-Footer-part-->
</body>
</html>

<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/jjuser/blockUser" class="btn btn-primary">我要禁言</a>
	    	
		   	<form style="display:inline-block;" action="/topic/topicList" method="get">
			  <input name="userID" type="text" placeholder="userID" value=""/>
			  <button type="submit" class="tip-bottom"><i class="icon-search icon-white"></i></button>
			</form>
		</div>
	</div>
	
    <div class="widget-box">
        <div class="widget-title">
            <h5>账号列表</h5>
        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>userID</th>
                        <th>注册时间</th>
                        <th>操作时间</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($userList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item->id?></td>
                        <td><?=$item->registerTime?></td>
                        <td><?=$item->optTime?></td>
                        <td><a class="btn btn-primary btn-mini unblock" data-uid="<?=$item->id?>">解禁</a></td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
</div>
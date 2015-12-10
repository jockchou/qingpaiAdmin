<div class="span12">
	<div class="widget-box">
		<div class="widget-title"><span class="icon"><i class="icon-bookmark"></i></span>
	    	<h5>操作</h5>
	    </div>
	    <div class="widget-content">
	    	<a href="/user/userAdd" class="btn btn-primary">添加账号</a>
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
                        <th>ID</th>
                        <th>用户名</th>
                        <th>更新时间</th>
                        <th>是否管理员</th>
                        <th>操作</th>
                    </tr>
                </thead>

                <tbody>
                	<?php foreach($adminList as $index => $item):?>
                    <tr class="<?=($index % 2 == 0 ? 'odd' : 'even')?> gradeA">
                        <td><?=$item->id?></td>
                        <td><?=$item->username?></td>
                        <td><?=$item->opTime?></td>
                        <?php if($item->isAdmin == 1):?>
                        <td><span class="label label-success">是</span></td>
                        <?php else:?>
                        <td><span class="label label-important">否</span></td>
                        <?php endif;?>
                        <td class="center">
                        	<?php if ($user->username == "admin"):?>
                        		<?php if ($item->isAdmin == 1):?>
                        		<a href="javascript:void(0);" data-name="<?=$item->username?>" data-oper="N" class="btn btn-info user-admin-btn">删除管理员</a>
                        		<?php else:?>
                        		<a href="javascript:void(0);" data-name="<?=$item->username?>" data-oper="Y" class="btn btn-warning user-admin-btn">设置管理员</a>
                        		<?php endif;?>
                        	<?php endif;?>
	                    	<?php if ($item->isAdmin == 1):?>
	                    		<?php if ($user->username == "admin" AND $item->username != "admin"):?>
	                    		<a href="javascript:void(0);" data-name="<?=$item->username?>" class="btn btn-danger user-del-btn">删除</a>
	                    		<?php endif;?>
	                    	<?php else:?>
	                    		<?php if ($user->isAdmin == 1):?>
	                    		<a href="javascript:void(0);" data-name="<?=$item->username?>" class="btn btn-danger user-del-btn">删除</a>
	                    		<?php endif;?>
	                    	<?php endif;?>
                        </td>
                    </tr>
					<?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
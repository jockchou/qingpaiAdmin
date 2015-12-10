<div class="span1"></div>
<div class="span10">
	<a class="btn btn-primary" href="/version/versionAdd">添加</a>
    <div class="widget-box">
        <div class="widget-title">
        	<span class="icon"><i class="icon-eye-open"></i></span>
            <h5><?=$os == "android" ? "Android" : "IOS"?>版本</h5>
        </div>

        <div id="version_list" class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                    	<th>ID</th>
                    	<th>版本号</th>
                        <th>版本名称</th>
                        <th>文件大小</th>
                        <th>客户端类型</th>
                        <th>下载地址</th>
                        <th>升级描述</th>
                        <th>是否强制</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                	<?php if(!empty($versionList)):?>
                	<?php foreach($versionList as $index => $item):?>
                    <tr>
                        <td><?=$item->id?></td>
                        <td><?=$item->versionCode?></td>
                        <td><?=$item->version?></td>
                        <td><?=JY_fileSize($item->fileSize)?></td>
                        <td><?=$item->os?></td>
                        <td><a class="label label-info" title="<?=$item->downURL?>" href="<?=$item->downURL?>">下载Apk</a></td>
                        <td><?=$item->updateMsg?></td>
                        <td>
                        <?php if($item->isForbidden == 1):?>
                        	<span class="label label-warning">强制</span>
	                  	<?php else:?>
	                  		<span class="label label-success">不强制</span>
	                  	<?php endif;?>
	                  	</td>
                        <td><?=$item->opTime?></td>
                        <td>
	                        <a href="/version/versionEdit?id=<?=$item->id?>&os=<?=$item->os?>" class="btn btn-primary">编辑</a>
	                        <a href="/version/versionDelete?id=<?=$item->id?>&os=<?=$item->os?>" class="btn deleteAlert">删除</a>
                        </td>
                    </tr>
					<?php endforeach;?>
					<?php else:?>
					<tr>
						<td style="text-align: center !important;" colspan="11">暂无版本信息！</td>
					</tr>
					<?php endif;?>
                </tbody>
            </table>
        </div>
        <?php if(!empty($pagination)):?>
		<div class="widget-content">
            <div class="pagination alternate pagination-centered">
             <?php echo $pagination;?>
            </div>
         </div>
         <?php endif;?>
    </div>
    <div id="deleteAlert" class="modal hide" tabindex="-1" style="margin-top:250px;">
         <div class="modal-header">
         <button data-dismiss="modal" class="close" type="button">×</button>
         <span class="icon"><i class="icon-info-sign"></i></span>
         </div>
         <div class="modal-body">
         <p>确定要删除该条记录？</p>
         </div>
         <div class="modal-footer"> <a id="deleteConfirm"  class="btn btn-primary" href="#">确定</a> <a data-dismiss="modal" class="btn" href="#">取消</a> </div>
     </div>
</div>
<div class="span1"></div>

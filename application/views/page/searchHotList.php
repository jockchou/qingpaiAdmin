<div class="span12">
<div class="widget-box">
          <div class="widget-title">
          	<span class="icon"><i class="icon-th"></i></span>
            <h5>搜索推荐话题</h5>
          </div>
          <div class="widget-content ">
            <table id="app-list-table" class="table table-bordered table-striped with-check">
              <thead>
                <tr>
                  <th>ID</th>
                  <th width="120">标题</th>
                  <th width="150">描述</th>
                  <th width="60">排序值</th>
                  <th width="60">添加时间</th>
                  <th width="45">话题状态</th>
                  <th width="40">操作</th>
             </tr>
              </thead>
              <tbody>
              	<?php foreach($subjectList as $index => $item):?>
	                <tr>
	                <td><?=$item['id']?></td>
                    <td ><?=$item['title']?></td>
                    <td ><?=$item['content']?></td>
                    <td ><?=$item['orderVal']?></td>
                    <td ><?=$item['addTime']?></td>
                     <?php if ($item['state'] == "1"):?>
	                  <td><span class="badge badge-success">正常</span></td>
	                  <?php else:?>
	                  <td><span class="badge badge-warning">下线</span></td>
	                  <?php endif;?>
	                <td >
	                <a class="btn btn-danger btn-mini hotsubject-del-btn" data-id="<?=$item['id']?>" href="javascript:void(0);">删除</a>
	                </td>
	              </tr>
                <?php endforeach;?>
              </tbody>
            </table>
            <?php include(dirname(dirname(__FILE__)) ."/block/page.php");?>
    	</div>
	</div>
</div>
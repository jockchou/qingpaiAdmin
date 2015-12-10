<div class="span12">
    <div class="widget-box">
        <div class="widget-title">
            <h5>添加颜值贴纸级别</h5>
        </div>

        <div class="widget-content nopadding">
			<form id="user-form-add" action="/beauty/stickerGradeSave" class="form-horizontal" enctype="multipart/form-data" method="post">
	            <div class="control-group" hidden>
					<input name="id" value="<?=isset($stickerGrade['id']) ? $stickerGrade['id'] : 0?>">
				</div>
                <div class="control-group">
                    <label class="control-label">级别名称:</label>
                    <div class="controls">
                        <input class="span3" name="gradeName" placeholder="级别名称" type="text" value="<?=isset($stickerGrade['gradeName']) ? $stickerGrade['gradeName'] : ''?>" autofocus="true" required><font color="red"> *</font>必填
                    </div>
                </div>
	            
				<div class="control-group">
                    <label class="control-label">最小分数:</label>
                    <div class="controls">
                        <input class="span3" name="minScore" placeholder="0到100的整数" type="text" value="<?=isset($stickerGrade['minScore']) ? $stickerGrade['minScore'] : ''?>" required><font color="red"> *</font>必填
                    </div>
                </div>
				
				<div class="control-group">
                    <label class="control-label">最大分数:</label>
                    <div class="controls">
                        <input class="span3" name="maxScore" placeholder="0到100的整数" type="text" value="<?=isset($stickerGrade['maxScore']) ? $stickerGrade['maxScore'] : ''?>" required><font color="red"> *</font>必填
                    </div>
                </div>
				
                <div class="form-actions">
                    <button class="btn btn-success save-btn" type="submit">保存</button>
                </div>
            </form>
        </div>
    </div>
</div>
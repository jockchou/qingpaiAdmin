<div id="search">
<form action="/topic/topicList" method="get">
  <input name="keyword" type="text" placeholder="关键字" value="<?= isset($keyword) ? $keyword : ''?>"/>
  <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
</form>
</div>
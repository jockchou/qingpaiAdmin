<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
    <li  class="dropdown" id="profile-messages" ><a href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i>  <span class="text"><?='欢迎: '.$this->session->userdata('username')?></span><b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li><a href="/admin/changePass"><i class="icon-user"></i>修改密码</a></li>
        <li class="divider"></li>
        <li><a title="退出" href="/login/index"><i class="icon-key"></i>退出</a></li>
      </ul>
    </li>
    <li class=""><a title="退出" href="/login/index"><i class="icon icon-share-alt"></i><span class="text">退出</span></a></li>
  </ul>
</div>

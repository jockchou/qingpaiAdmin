<!DOCTYPE html>
<html>
<head>
    <title>Joyo Admin</title><meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/static/css/bootstrap.min.css" />
	<link rel="stylesheet" href="/static/css/bootstrap-responsive.min.css" />
    <link rel="stylesheet" href="/static/css/matrix-login.css" />
    <link href="/static/font-awesome/css/font-awesome.css" rel="stylesheet" />
    </head>
<body>
        <div id="loginbox">            
            <form id="loginform" class="form-vertical" action="/login/login">
				 <div class="control-group normal_text"> <h3><img src="/static/img/logo.png" alt="Logo" /></h3></div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lg"><i class="icon-user"></i></span><input id="login-username" name="username" type="text" placeholder="Username" />
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_ly"><i class="icon-lock"></i></span><input id="login-password" name="password" type="password" autocomplete="off" placeholder="Password" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <span class="pull-left" style="display:none;" ><a href="#" class="flip-link btn btn-info" id="to-recover">Lost password?</a></span>
                    <span class="pull-right"><a id="login-submit" href="javascript:void(0);" class="btn btn-success" /> 登录</a></span>
                </div>
            </form>
            <form id="recoverform" action="#" class="form-vertical">
				<p class="normal_text">Enter your e-mail address below and we will send you instructions how to recover a password.</p>
                    <div class="controls">
                        <div class="main_input_box">
                            <span class="add-on bg_lo"><i class="icon-envelope"></i></span><input type="text" placeholder="E-mail address" />
                        </div>
                    </div>
                <div class="form-actions">
                    <span class="pull-left"><a href="#" class="flip-link btn btn-success" id="to-login">&laquo; Back to login</a></span>
                    <span class="pull-right"><a class="btn btn-info"/>Reecover</a></span>
                </div>
            </form>
        </div>
        
        <script src="/static/js/jquery.min.js"></script>  
        <script src="/static/js/matrix.login.js"></script> 
    </body>

</html>

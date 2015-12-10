
$(document).ready(function(){

	var login = $('#loginform');
	var recover = $('#recoverform');
	var speed = 400;

	$('#to-recover').click(function(){
		
		$("#loginform").slideUp();
		$("#recoverform").fadeIn();
	});
	$('#to-login').click(function(){
		
		$("#recoverform").hide();
		$("#loginform").fadeIn();
	});
	
	
	$('#to-login').click(function(){
		
	});
    
	function doLogin() {
		var username = $('#login-username').val();
		var password = $('#login-password').val();
		
		if (username != '' && password != '') {
			$.post('/login/doLogin', {
				username: username,
				password: password
			}, function(data) {
				if (data.code !== 1){
					alert(data.msg);
				} else {
					location.href = "/";
				}
			});
		}
	}
	
	$("#login-submit").click(function(evt) {
		doLogin();
		evt.preventDefault();
		return false;
		
	});
	
	$(document).keyup(function(evt) {
		if (evt.keyCode == '13') {
			doLogin();
		}
	});
	
    if($.browser.msie == true && $.browser.version.slice(0,3) < 10) {
        $('input[placeholder]').each(function(){ 
       
        var input = $(this);       
       
        $(input).val(input.attr('placeholder'));
               
        $(input).focus(function(){
             if (input.val() == input.attr('placeholder')) {
                 input.val('');
             }
        });
       
        $(input).blur(function(){
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.val(input.attr('placeholder'));
            }
        });
    });

        
        
    }
});
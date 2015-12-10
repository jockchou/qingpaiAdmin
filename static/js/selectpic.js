window.onload=function(){
		function readFile(){
			var file = this.files[0];
			if(file.type.indexOf("image")<0){
				alert("文件必须为图片！");
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				pic.setAttribute('src',this.result);
				showpic.style.display="block";
			}
		}
		function readFile1(){
			var file = this.files[0];
			if(file.type.indexOf("image")<0){
				alert("文件必须为图片！");
				return false;
			}
			var reader = new FileReader();
			reader.readAsDataURL(file);
			reader.onload = function(e){
				pic1.setAttribute('src',this.result);
				showpic1.style.display="block";
			}
		}
		
		var pic = document.getElementById("pic");
		var showpic = document.getElementById("showpic");
		
		if(showpic == null){
			showpic = pic;
		}
		var input = document.getElementById("file_input");
		
		
		
		var pic1 = document.getElementById("pic1");
		var showpic1 = document.getElementById("showpic1");
		var input1 = document.getElementById("file_input1");
		if(input != null)
			input.addEventListener('change',readFile,false);
		if(input1 != null)
			input1.addEventListener('change',readFile1,false);
	}


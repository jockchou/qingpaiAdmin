<script>
	$(function() {
		$("select[name='type']").change(function() {
			switch(this.value) {
				case "1": $("#jump").attr('placeholder', '填写H5页面URL');	break;
				case "3": $("#jump").attr('placeholder', '填写用户ID');		break;
				case "4": $("#jump").attr('placeholder', '填写帖子ID');		break;
				case "6": $("#jump").attr('placeholder', '填写话题ID');		break;
				default: $("#jump").attr('placeholder', '忽略不填');
			}
		});
	});
</script>
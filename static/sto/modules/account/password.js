
jQuery.validator.addMethod("isPass", function(value,element) {
		var mobile = /^[a-z0-9_]{6,24}$/;
		return this.optional(element) || ( mobile.test(value)); 
		
		}, "密码格式不对，密码应在6-24之间");
		
/**
 * password
 */
function doPost() {
	var validator = jQuery("#f1").validate({
		rules: {
			oldpassword:{
				required:true,
				isPass:true
			},
			password: {
				required:true,
				isPass:true
			},
			confirming: {
				required: true,
				equalTo: "#password"
			}
				
		},
		messages: {
			oldpassword: 
			{
				required:"原密码不能为空",
				isPass:"密码格式不对，密码应在6-24之间"
			}
			,
			password:{
				required:"新密码不能为空",
				isPass:"密码格式不对，密码应在6-24之间"
			},
			confirming: {
				required: "确认密码不能为空",
				equalTo: "两次密码不一致"
			}
		}
	});
	var flag = validator.form();
	
	if(flag){
		var old = jQuery('#oldpassword').val();
		var password = jQuery('#password').val();
		var confirming = jQuery('#confirming').val();
		
		var data = 'old='+old+'&password='+password+'&confirming='+confirming;
		jQuery.post('/account/resetpassword.json', data, function(r){
			if('0' == r.status) {
				Notify.log('修改成功');
				window.f1.reset();
				
			} else {
				Notify.log(r.msg);
			}
		});
	}
}

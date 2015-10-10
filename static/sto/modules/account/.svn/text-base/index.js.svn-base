/**
 * account js
 */
// 省市联动
(function(){
	var pObj = document.getElementById('province');
	var pObjDft = pObj.getAttribute('data-value');
	var cObj = document.getElementById('city');
	var cObjDft = cObj.getAttribute('data-value');
	var aObj = document.getElementById('area');
	var aObjDft = aObj.getAttribute('data-value');
	
	var lianDong = new LianDongJQ().init(pObj, cObj, aObj);
	
	jQuery.validator.addMethod("isPhone", function(value,element) {
		var length = value.length;
		var mobile = /^1[3|4|5|7|8][0-9]\d{8}$/;
		return this.optional(element) || (length == 11 && mobile.test(value)); 
		
		}, "手机格式错误");
		
	var validator = jQuery("#f1").validate({
		rules: {
			name: "required",
			mobile:{
				required:true,
				isPhone:true
			},
			email: {
				required:true,
				email:true
			}
		},
		messages: {
			name: "昵称不能为空",
			mobile:{
				required:"手机不能为空",
				isPhone:"手机格式错误"
			},
			email:{
				required:"邮箱不能为空",
				email:"邮箱格式错误"
			}
		}
	});
	
	
	
	$("#f1").submit(function(){
		
		var flag = $(this).valid();
		
		if(!flag) return;
		
		var nickname = jQuery('#name').val();
		var gender = jQuery('#gender').val();
		var mobile = jQuery('#mobile').val();
		var email = jQuery('#email').val();
		var province = jQuery('#province').val();
		var city = jQuery('#city').val();
		var area = jQuery('#area').val();
		var face = jQuery('#face').val();
	
		jQuery.post('/account/postaccount.json', {
			"name" : nickname,
			"gender" : gender,
			"mobile" : mobile,
			"email" : email,
			"province" : province,
			"city" : city,
			"area" : area,
			"face" : face
		}, function(rs){
			if('0' == rs.status) {
				Notify.log('修改成功');
			} else {
				Notify.log(rs.msg);
			}
			
		}, 'json');
		return false;
	});
	
	$("#doPost").click(function(){
		$("#f1").submit();
	});

})();


// 头像
var settings = {
	debug: false,
	
	flash_url: SP_URL_STO+"js/swfupload/swfupload.swf",
	upload_url: "http://v0.api.upyun.com/eventdb/",
	file_post_name: "file",
	post_params: {"policy": SP_POLICY, "signature": SP_SIGNATURE},
	file_size_limit: "5 MB",
	file_types: "*.jpg;*.gif;*.png",
	file_types_description: "*.jpg;*.gif;*.png",
	file_upload_limit: 0,  //配置上传个数
	file_queue_limit: 1,
	button_window_mode:'transparent',
	css_style:'position:absolute;left:0;top:0;cursor: pointer;',
	button_text: '<span class="whiteFont"></span>',  
	custom_settings: {
		progressTarget: "fsUploadProgress",
		cancelButtonId: "btnCancel"
	},
	button_text_style: '.whiteFont{text-align: center;font-size:15px;padding-top:8px;line-height:36px;color: #FFFFFF;font-family: "微软雅黑";left: 5%;}',  
	button_width: "170",
	button_height: "36",
	button_placeholder_id: "facebtn",
	file_queued_handler:function onFileQueued (file){
		var filesize = Math.round(file.size/1024);
	    	console.log(filesize);
	    	var swfUpload = this;
	 		if(filesize > 5120){
	 			 swfUpload.cancelUpload(file.id);  
		  		 $("#" + file.id).slideUp('fast');  
	 			 Notify.log("图片大小不能大于5M");
	 		}
	},
	file_queue_error_handler: function fileQueueError(file, errorCode, message){
		var filesize = Math.round(file.size/1024);
	    	console.log(filesize);
	    	var swfUpload = this;
	 		if(filesize > 5120){
	 			 swfUpload.cancelUpload(file.id);  
		  		 $("#" + file.id).slideUp('fast');  
	 			 Notify.log("图片大小不能大于5M");
	 		}
	},
	file_dialog_complete_handler: fileDialogComplete,
	upload_start_handler: uploadStart,
	upload_progress_handler: uploadProgress,
	upload_error_handler: function uploadError(file, errorCode, message) {
		
	},
	upload_success_handler: function uploadSuccess(file, serverData) {
		
	},
	upload_complete_handler: uploadComplete,
	queue_complete_handler: queueComplete
};
window.onCallingCardUploaded = function(file, serverData) {
	var serverData = jQuery.parseJSON(serverData);
	var url = SP_URL_UPLOAD + '' + serverData.url + '!w125h119';
	
	document.getElementById('face').value = serverData.url;
	document.getElementById('overview').src = url;
};

window.onFileProgress = function(file, bytesLoaded, bytesTotal) {
	    var NUM = Math.round(((bytesLoaded / bytesTotal) * 100));
	   	if(NUM < 100){
	    	$("#progress_num").show();
    		$("#progress_num").attr("class","ht-account-img-load");
    		$("#progress_num").html(NUM+"%");
    	}else{
    		$("#progress_num").attr("class","");
    		$("#progress_num").hide();
    	}
    	
}
settings.upload_success_handler = onCallingCardUploaded;
settings.upload_progress_handler = onFileProgress;
var swfu = new SWFUpload(settings);
 


	

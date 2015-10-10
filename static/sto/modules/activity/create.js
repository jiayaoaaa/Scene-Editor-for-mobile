/**
 * @author Administrator
 */
function getSetting() {
	        var settings = {
	            flash_url: SP_URL_STO+"js/swfupload/swfupload.swf",
	            upload_url: "http://v0.api.upyun.com/eventdb/",
	            file_post_name: "file",
	            post_params: {"policy": SP_POLICY, "signature": SP_SIGNATURE},
	            file_size_limit: "5 MB",
	            file_types: "*.jpg;*.gif;*.png",
	            file_types_description: "*.jpg;*.gif;*.png",
	            file_upload_limit: 0,  //配置上传个数
	            file_queue_limit: 0,
	            button_window_mode:'transparent',
	            css_style:'position:absolute;left:0;top:0',
	            custom_settings: {
	                progressTarget: "fsUploadProgress",
	                cancelButtonId: "btnCancel"
	            },
	            debug: false,
	
	            // Button settings
	           // button_image_url: "{%$SP_URL_IMG%}add_btn.jpg",
	            button_text: '<span class="whiteFont"></span>',  
	      	    button_text_style: '.whiteFont{text-align: center;font-size:15px;padding-top:8px;line-height:36px;color: #FFFFFF;font-family: "微软雅黑";left: 5%;}',  
	            button_width: "170",
	            button_height: "36",
	            button_placeholder_id: "",
			
	            file_queued_handler: fileQueued,
	            file_queue_error_handler: function fileQueueError(file, errorCode, message){
	            	console.log(message);
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
	                console.log(message);
	            },
	            upload_success_handler: function uploadSuccess(file, serverData) {
	                console.log("未实现上传成功的处理过程")
	            },
	            upload_complete_handler: uploadComplete,
	            queue_complete_handler: queueComplete
	        };
	
	        return settings;
	    };
	    
	    function iscity() {
			var city = $("#city").val();
			var province = $("#province").val();
			var province = $("#province").val();
			var arrea = $("#arrea").val();
			var result =  city == "" ||  province == "" || city == null || province == null ||  arrea == "" || arrea == null ?true:false;
			if(result){
				$('#citys_error').show();
	        	$('#citys_error').html('请勾选城市数据');
			}else{
				$('#citys_error').hide();
				$('#citys_error').html('');
			}
			return result;
		}
	
		//初始化
	    $(document).ready(function(){
			$('input, textarea').placeholder();
			
			
	        $(".uploadButton").each(function(i, n) {
	            var id = "#uploadButton_" + i;
	            $(n).attr("id", id);
				console.log(id);
	            var settings = new getSetting();
	            settings.button_placeholder_id = id;
	            var callbackName = $(n).attr("data-success");
	            console.log(callbackName);
	            settings.upload_success_handler = window[callbackName];
				settings.file_queued_handler = window['onFileQueued'];
				settings.upload_progress_handler = window['onFileProgress'];
	            swfu = new SWFUpload(settings);    
	            console.log(swfu);
	        });
	        
	 
	       
	
			 
			
			//设置头部滚动
			$('#header_title').posfixed({
				distance : 0,
				pos : 'top',
				type : 'while',
				hide : false
			});
			
			
			/**
			 * 下拉菜单
			 */
			$('#province').change(function() {
				
				var id = $(this).val();
				 $.post('/home/publicapi.json?type=getcitychild',{id:id},function(dataP){
				 		console.log(dataP)
				 		if(dataP.status == 0){
				 			$('#city').selectpicker('val','');
				 			$('#arrea').selectpicker('val','');
				 			
				 			$("#city").html('<option selected="true" disabled="true">市</option>');
				 			$("#arrea").html('<option selected="true" disabled="true">区</option>');
			 				for(var i = 0 ; i < dataP.data.length;i++){
			 					var html = '<option value="'+dataP.data[i]['id']+'">'+dataP.data[i].name+'</option>';
			 					$("#city").append(html);
			 				}
			 				$('#city').selectpicker('refresh');
							$('#arrea').selectpicker('refresh');
				 		}
				 	},"json");	
			});
			$('#city').change(function() {
			   var id = $(this).val();
			  
			 	$.post('/home/publicapi.json?type=getcitychild',{id:id},function(dataC){
			 		console.log(dataC)
			 		if(dataC.status == 0){
			 			$('#arrea').selectpicker('val','');
			 			$("#arrea").html('<option selected="true" disabled="true">区</option>');
			 			for(var i = 0 ; i < dataC.data.length;i++){
		 					var html = '<option value="'+dataC.data[i]['id']+'">'+dataC.data[i].name+'</option>';
		 					$("#arrea").append(html);
		 				}
		 				$('#arrea').selectpicker('refresh');
			 		}
			 	},"json");
			});
			
			$("#arrea").change(function(){
				iscity();
			});
			
			//checkbox联动
			$('#enrollck_div').click(function() {
				var enrollck = document.getElementById('enrollck');
				var is_audit = document.getElementById('is_audit');
				if(enrollck.checked){
					$("#enrolldate").hide();
					enrollck.checked = false;
					is_audit.checked = false;
					$("#enrollck_div").attr("class", "ht-active-checkbox");
					$("#is_audit_div").attr("class", "ht-active-checkbox");
				}else{
					$("#enrolldate").show();
					enrollck.checked = true;
					is_audit.checked = true;
					$("#enrollck_div").attr("class", "ht-active-checkbox-on");
					$("#is_audit_div").attr("class", "ht-active-checkbox-on");
				}
			
			});
			
			$("#active_submit").click(function(){
				$("#active_create").submit();
			 });
			 
			
			 
			 $('#active_create').submit(function(){
			 	
		        if (!$(this).valid()){
		        	iscity();
		            return false;
		        } 
		       
		        $('.error').html('');
		        $("#active_submit").attr("disabled",true);
		  
		        $(this).ajaxSubmit({
		            type:"POST",
		            dataType:'json',
		            success: function(jsonData,statusText){
		            	if(statusText == 'success'){
					       if(SP_ACTIVE == 'add'){
					       		$("#active_submit").attr("disabled",false);
						        if (jsonData.status == 0){
									location.href = '/active/createsuccess.html?id='+jsonData.data;
						        }
						        else
						        {
						  			Notify.log(jsonData.msg);
						        }
					       }else{
					       		if (jsonData.status == 0){
						        	Notify.log('修改完成');
						        	setTimeout(function(){
						        		$("#active_submit").attr("disabled",false);
						        		location.href = '/active/index.html';
						        	},3000);
						        }
						        else
						        {
						        	$("#active_submit").attr("disabled",false);
						  			Notify.log(jsonData.msg);
						        }
					       }
					    }
		            }
		        });
		        return false;
		    });
			
			jQuery.validator.addMethod("activit_text", function(value, element) {
				var activit_end  = document.getElementById("activit_end").value;
				var activit_start = document.getElementById("activit_start").value;
				var result =  activit_start == "" ||  activit_end == "" || activit_end == null || activit_start == null?false:true;
				return this.optional(element) || (result);
			}, "请输入举办时间"); 
			
			jQuery.validator.addMethod("activit_dis", function(value, element) {
				var activit_end  = document.getElementById("activit_end").value;
				var activit_start = document.getElementById("activit_start").value;
		
				var result =  activit_start > activit_end?false:true;
				return this.optional(element) || (result);
			}, "举办结束日期不能小于开始日期"); 
			
			jQuery.validator.addMethod("enroll_dis", function(value, element) {
				var enroll_end  = document.getElementById("enroll_end").value;
				var enroll_start = document.getElementById("enroll_start").value;
		
				var result =  enroll_start > enroll_end?false:true;
				return this.optional(element) || (result);
			}, "报名结束日期不能小于开始日期"); 
		
	    
		    var validator = $("#active_create").validate({
		        rules: {
		            title: "required",
		            activit_start:{
		            	required:false
		            },
		            activit_end:{
		            	 activit_text: true,
		            	 activit_dis:true
		            },
					address: "required",
					enroll_start:{
						required:false
					},
					enroll_end:{
						required:false,
						enroll_dis:true
					},
					enroll_num:{
						required:false,
						number:true
					}
		        },
		        messages: {
		            title: "请输入活动标题",
		            activit_end: {
		                required: "请输入举办时间",
		                activit_text: "请输入举办时间",
		                activit_dis:"举办结束日期不能小于开始日期"
		            },
		            enroll_end:{
		            	enroll_dis:"报名结束日期不能小于开始日期"
		            },
		            address: "请输入详细地址",
		            enroll_num:{
		            	number:"请输入数字"
		            }
		        }
		    });
	
			
		 });	
		//上传图片回调
	    window.onCallingCardUploaded = function(file, serverData) {
	    	console.log(serverData)
	        var serverData = $.parseJSON(serverData);
	        var img_url = "http://img.eventown.cn";
	        var url = img_url + '' + serverData.url + '!w125h119';
	        $("#active_img").attr("src",url);
	        $("#thumbnail").val(serverData.url);
	        console.log('onCallingCardUploaded');
	    };
	    window.onFileQueued = function(file){
	    	var filesize = Math.round(file.size/1024);
	    	console.log(filesize);
	    	var swfUpload = this;
	 		if(filesize > 5120){
	 			 swfUpload.cancelUpload(file.id);  
		  		 $("#" + file.id).slideUp('fast');  
	 			 Notify.log("图片大小不能大于5M");
	 		}
	    }
	    window.onFileProgress = function(file, bytesLoaded, bytesTotal) {
	    	var NUM = Math.round(((bytesLoaded / bytesTotal) * 100));
	    	if(NUM < 100){
	    		$("#progress_num").show();
	    		$("#progress_num").attr("class","ht-create-img-load");
	    		$("#progress_num").html(NUM+"%");
	    	}else{
	    		$("#progress_num").attr("class","");
	    		$("#progress_num").hide();
	    	}
	    	
	    }
	    
		

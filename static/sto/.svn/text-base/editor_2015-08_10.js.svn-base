require.config({ //配置
    baseUrl: SP_URL_STO,
    paths: {
        jquery: 'js/jquery.min',
        avalon: "vendor/avalon/avalon", //必须修改源码，禁用自带加载器，或直接删提AMD加载器模块
        domReady: 'vendor/require/domReady',
        css: 'vendor/require/css.js',
        mmPromise: 'vendor/avalon/mmPromise',
        ytab:'js/ytab',
        swfupload:'js/swfupload/js/swfupload',
        swfuploadqueue:'js/swfupload/js/swfupload.queue',
        handlers:'js/swfupload/js/handlers',
        fileprogress:'js/swfupload/js/fileprogress',
        WdatePicker:'js/WdatePicker',
        swiper: 'vendor/swiper/js/swiper.min',
        swiperCss: 'vendor/swiper/css/swiper.min.css',
        notify: 'vendor/notify/notify',
        semantic: 'js/semantic.min',
        posfixed: 'js/posfixed'
    },
    priority: ['text', 'css'],
    shim: {
        jquery: {
            exports: "jQuery"
        },
        avalon: {
            exports: "avalon"
        },
        semantic: {
            exports: "semantic"
        },
        posfixed: {
            exports: "posfixed"
        }
    }
});



require(['avalon', "domReady!", 'jquery','ytab','semantic','notify','WdatePicker','swfupload','swfuploadqueue','fileprogress','handlers','posfixed'], function() { //第二块，添加根VM（处理共用部分）

console.log("加载avalon完毕，开始构建根VM与加载其他模块" + notify);


var editor=function(){};
    editor.prototype={
        addElements:'',
        removeElements:'',
        moveup:'',
        moveDown:'',
        // body...
    };


avalon.scan(document.body);
	
	 function getSetting() {
        var settings = {
            flash_url: SP_URL_STO+"js/swfupload/swfupload.swf",
            upload_url: "http://v0.api.upyun.com/eventdb/",
            file_post_name: "file",
            post_params: {"policy": SP_POLICY, "signature": SP_SIGNATURE},
            file_size_limit: "100 MB",
            file_types: "*.jpg;*.gif;*.png",
            file_types_description: "*.jpg;*.gif;*.png",
            file_upload_limit: 0,  //配置上传个数
            file_queue_limit: 0,
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
    
    
	//表单提交
	function submitForm(){
        var formData = $('.ui.form input').serializeArray(); //or .serialize();
        //alert(formData)
        $.ajax({
            type: 'POST',
            url: '/active/create.json',
            dataType: "json", 
            data: formData,
            success:function(res){
    			if(res.status == 0){
    				location.href = '/active/createsuccess.html?id='+res.data;
    			}else{
    				notify.log(res.msg);
    			}
 		    }
        });
        
    }
	//初始化
    $(document).ready(function(){

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
            swfu = new SWFUpload(settings);    
            console.log(swfu);
        });
        
        $('.ui.dropdown').dropdown();
       
         //设置表单
		$('.ui.form').form({
	            title: {
	                identifier: 'title',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '活动标题不能为空！'
	                    }
	                ]
	            },
	            address: {
	                identifier: 'address',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '详细地址不能为空！'
	                    }
	                ]
	            },
	            activit_start:{
	            	identifier: 'activit_start',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '举办日期开始时间不能为空！'
	                    }
	                ]
	            },
	            activit_end:{
	            	identifier: 'activit_end',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '举办日期结束时间不能为空！'
	                    }
	                ]
	            },
	            active_address:{
	            	identifier: 'active_address',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '活动地址不能为空！'
	                    }
	                ]
	            },
	            province:{
	            	identifier: 'province',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '省份不能为空！'
	                    }
	                ]
	            },
	            city:{
	            	identifier: 'city',
	                rules: [
	                    {
	                        type: 'empty',
	                        prompt: '城市不能为空！'
	                    }
	                ]
	            }
	        }, {
	            inline: true,
	            on     : 'blur',
	           	onSuccess: submitForm
	        });
		 $("#active_submit").click(function(){
			$(".ui.form").submit();
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
		$('.province').dropdown({onChange: function() {
			 	var id = $("#province_sel").val();
			 	$.post('/home/publicapi.json?type=getcitychild',{id:id},function(data){
			 		console.log(data)
			 		if(data.status == 0){
			 			$("#city").html('');
			 			$(".city .text").html('市');
			 			$("#city_sel").val('');
			 			$("#arrea").html('');
			 			$(".arrea .text").html('区');
			 			$("#arrea_sel").val('');
		 				for(var i in data.data){
		 					var html = '<div class="item" data-value="'+data.data[i]['id']+'">'+data.data[i].name+'</div>';
		 					$("#city").append(html);
		 				}
		 				$('.ui.dropdown.city').dropdown({onChange: function() {
							var id = $("#city_sel").val();
						 	$.post('/home/publicapi.json?type=getcitychild',{id:id},function(data){
						 		console.log(data)
						 		if(data.status == 0){
						 			$("#arrea").html('');
			 						$(".arrea .text").html('区');
			 						$("#arrea_sel").val('');
						 			for(var i in data.data){
					 					var html = '<div class="item" data-value="'+data.data[i].id+'">'+data.data[i].name+'</div>';
					 					$("#arrea").append(html);
					 				}
					 				$('.ui.dropdown.arrea').dropdown();
						 		}
						 	},"json");
						 
						}});
			 		}
			 	},"json");
		}});
		
		//checkbox联动
		$('.enrollck').checkbox({onChange:function() {
			
			if($(this).prop('checked')){
				$("#enrolldate").css("display","block");
			}else{
				$("#enrolldate").css("display","none");
			}
		}});
		$('.enrollck').on('click',function(){
			$(this).nextAll('.checkbox').checkbox('toggle');
		});
    });
	//上传图片回调
    window.onCallingCardUploaded = function(file, serverData) {
        var serverData = $.parseJSON(serverData);
        var img_url = "http://img.eventown.cn";
        var url = img_url + '' + serverData.url + '!w125h119';
        $("#active_img").attr("src",url);
        $("#thumbnail").val(serverData.url);
        console.log('onCallingCardUploaded');
    };
    window.onFileQueued = function(file){
    	console.log(file);
    	var filesize = Math.round(file.size/1024);
    	var swfUpload = this;
    	console.log(filesize);
 		if(filesize < 100){
 			 swfUpload.cancelUpload(file.id);  
	  		 $("#" + file.id).slideUp('fast');  
	  		 console.log(window)
 			 notify.log("图片大小不能小于100kb");
 		}
	   
    }
});

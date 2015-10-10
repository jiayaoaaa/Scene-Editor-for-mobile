 var activeId = window.activeId,swfu = null;
 var settings = {
	            flash_url: SP_URL_STO+"js/swfupload/swfupload.swf",
	            upload_url: SP_URL_HOME+'attendee/import.json',
	            file_post_name: "file",
	            post_params: {"activeId": activeId,"PHPSESSID":SP_SSION},
	            file_size_limit: "5 MB",
	            file_types: "*.xls;*.xlsx",
	            file_types_description: "*.xls;*.xlsx",
	            file_upload_limit: 0,  //配置上传个数
	            file_queue_limit: 0,
	            button_window_mode:'transparent',
	            css_style:'position:absolute;left:0;top:0',
	            custom_settings: {
	                cancelButtonId: "btnCancel"
	            },
	            debug: false,
	            button_cursor : SWFUpload.CURSOR.HAND,  
	
	            // Button settings
	           // button_image_url: "{%$SP_URL_IMG%}add_btn.jpg",
	            button_text: '<span class="whiteFont"></span>',  
	      	    button_text_style: '.whiteFont{text-align: center;font-size:15px;padding-top:8px;line-height:36px;color: #FFFFFF;font-family: "微软雅黑";left: 5%;}',  
	            button_width: "170",
	            button_height: "36",
	            button_placeholder_id: "uploadButton",
				button_disabled : false,  
	            file_queued_handler:function onFileQueued  (file){
					var filesize = Math.round(file.size/1024);
					var swfUpload = this;
					if(filesize > 5120){
						 swfUpload.cancelUpload(file.id);  
				  		 $("#" + file.id).slideUp('fast');  
						 Notify.log("图片大小不能小于5M");
					}
					$("#file-name").val(file.name);
					$("#ctlBtn").attr("disabled",false);
				},
	            file_queue_error_handler: function fileQueueError(file, errorCode, message) {
						try {
							if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
								var msgtxt = ("您正在上传的文件队列过多.\n" + (message === 0 ? "您已达到上传限制" : "您最多能选择 " + (message > 1 ? "上传 " + message + " 文件." : "一个文件.")));
								 Notify.log(msgtxt);
								return;
							}
					
							// var progress = new FileProgress(file, this.customSettings.progressTarget);
							// progress.setError();
							// progress.toggleCancel(false);
					
							switch (errorCode) {
							case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
								 Notify.log("文件尺寸过大.");
								this.debug("错误代码: 文件尺寸过大, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
								 Notify.log("无法上传零字节文件.");
								this.debug("错误代码: 零字节文件, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
								 Notify.log("不支持的文件类型.");
								this.debug("错误代码: 不支持的文件类型, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							default:
								if (file !== null) {
									 Notify.log("未处理的错误");
								}
								this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							}
						} catch (ex) {
							
					        this.debug(ex);
					    }
					},
	            file_dialog_complete_handler: function dialog_complete_handler(numFilesSelected, numFilesQueued) {
					try {
						console.log(numFilesSelected)
						if (numFilesSelected > 0) {
							document.getElementById(this.customSettings.cancelButtonId).disabled = false;
						}
						/* I want auto start the upload and I can do that here */
					} catch (ex)  {
				        this.debug(ex);
					}
				} ,
	            upload_start_handler:function uploadStart(file) {
					try {
						/* I don't want to do any file validation or anything,  I'll just update the UI and
						return true to indicate that the upload should start.
						It's important to update the UI here because in Linux no uploadProgress events are called. The best
						we can do is say we are uploading.
						 */
		
						// var progress = new FileProgress(file, this.customSettings.progressTarget);
						// progress.toggleCancel(true, this);
					}
					catch (ex) {
						
					}
					
					return true;
				},
	            upload_progress_handler: onFileProgress = function(file, bytesLoaded, bytesTotal) { //处理进程
					var NUM = Math.round(((bytesLoaded / bytesTotal) * 100));
					$("#swfileProcess").show();
					$("#swfileProcess").attr("class","Bars");
					$("#swfileProcessSize").css("width",NUM+"%");
					$("#swfileProcessTxt").html("上传中"+NUM+"%");
					if(NUM == 100){
						$("#swfileProcess").hide();
						$("#swfileProcess").attr("class","");
						$("#swfileProcessTxt").html("");
					}
				},
	            upload_error_handler: function uploadError(file, errorCode, message) {
	               try {
						var progress = new FileProgress(file, this.customSettings.progressTarget);
						progress.setError();
						progress.toggleCancel(false);
						switch (errorCode) {
							case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
								 Notify.log("上传错误");
								this.debug("错误代码: HTTP错误, 文件名: " + file.name + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
								 Notify.log("上传失败");
								this.debug("错误代码: 上传失败, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.IO_ERROR:
								 Notify.log("服务器 (IO) 错误");
								this.debug("错误代码: IO 错误, 文件名: " + file.name + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
								 Notify.log("安全错误");
								this.debug("错误代码: 安全错误, 文件名: " + file.name + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
								 Notify.log("超出上传限制.");
								this.debug("错误代码: 超出上传限制, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
								 Notify.log("无法验证.  跳过上传.");
								this.debug("错误代码: 文件验证失败, 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
							case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
								// If there aren't any files left (they were all cancelled) disable the cancel button
								if (this.getStats().files_queued === 0) {
									document.getElementById(this.customSettings.cancelButtonId).disabled = true;
								}
								 Notify.log("取消");
								progress.setCancelled();
								break;
							case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
								 Notify.log("停止");
								break;
							default:
								 Notify.log("未处理的错误: " + errorCode);
								this.debug("错误代码: " + errorCode + ", 文件名: " + file.name + ", 文件尺寸: " + file.size + ", 信息: " + message);
								break;
						}
					} catch (ex) {
						
				        this.debug(ex);
				    }
	               
	            },
	            upload_success_handler: function uploadSuccess(file, serverData) { //上传图片回调
					console.log(file);
					console.log(serverData);
				    var serverData = $.parseJSON(serverData);
				    if(serverData.code == 200){
				  		  $("#ctlBtn").attr("disabled",false);
				  		  $("#ctlBtn").attr("id","complete").removeClass("left").text("完成").siblings("button").remove();	
				    }else{
				    	Notify.log(serverData.message);
				    	this.cancelUpload(file.id);  
				  		$("#" + file.id).slideUp('fast');  
				    }
				  
				    console.log('onCallingCardUploaded');
				},
	            upload_complete_handler:function uploadComplete(file) {
					file = this.unescapeFilePostParams(file);
					this.queueEvent("upload_complete_handler", file);
				},
	            queue_complete_handler:function(numFilesUploaded){}
	        };


            
$(function(){
    swfu = new SWFUpload(settings);
    //添加参会人
    $("#add-attendee").on('click',function(){
        var str = '<div class="modal-content" id="modal-content">'+
                '<div class="attend-model-header">'+
                '<p class="attend-model-header-title">添加参会人</p>'+
            '</div>'+
            '<div class="attend-model-content">'+
                '<form method="post" id="manage-add">'+
                    '<input type="hidden" class="form-control" name="action" value="add">'+
                    '<input type="hidden" class="form-control" name="activeId" value="'+activeId+'">'+
                    '<div class="form-group" style="margin-top:17px">'+
                            '<input type="text" name="name" class="form-control"  value="姓名" >'+
                    '</div>'+
                    '<div class="form-group" style="margin-top:17px">'+
                            '<input type="text" name="phone" class="form-control"  value="手机" >'+
                    '</div>'+
                    '<div class="form-group" style="margin-top:17px">'+
                            '<input type="text" name="email" class="form-control" value="邮箱"  >'+
                    '</div>'+
                    '<div class="form-group" style="margin-top:17px">'+
                            '<input type="text" name="company" class="form-control" value="公司"  >'+
                    '</div>'+
                    '<div class="form-group" style="margin-top:17px">'+
                            '<input type="text" name="position" class="form-control"  value="职位" >'+
                    '</div>'+
                '</form>'+
            '</div>'+
            '<div class="attend-model-footer">'+
                '<button type="button" class="btn ht-btn-blue" style="float:left;width:200px;" id="manage-save">保存</button>'+
                '<button type="button" class="btn ht-btn-gray" style="float:right;width:200px;" data-dismiss="modal">取消</button>'+
            '</div>'+
            '<div class="clear"></div>'+
        '<div>';
        $("#modal-content").remove();
        $("#modal-dialog").append(str);
        $("#myModal").modal('show');
			$('.form-control').each(function(k, el) {
		var oldvalue = $(el).val()
		$(el).on('focus', function() {
			if ($(el).val() == oldvalue) {
				$(el).val('')
			}
		})
		$(el).on('blur', function() {
			if ($(el).val() =="") {
				$(el).val(oldvalue)
			}
		})
	})
    })
    
    
    //表头设置
    $('#table-set').on('click',function(){
        var str = '<div class="modal-content" id="modal-content">'+
            '<div class="attend-model-header">'+
                '<p class="attend-model-header-title">表头设置</p>'+
            '</div>'+
            '<div class="attend-model-content table-set-content" id="table-set-content"><form id="form-table-set">'+
            '<input type="hidden" name="activeId" value="'+activeId+'">';
            $.each(tableSet,function(i,item){
                //console.log(item);
                var direction = i%2==0 ? 'left':'right';
                var onoff = item.isShow == 1 ? '':'check-off';
                var action = "table-set";
                if(item.field =="name" || item.field=="phone"){
                    action = "";
                }
                str += '<div class="table-set '+direction+'" action="'+action+'">'+
                        '<input type="hidden" name="'+item.field+'[isShow]" value="'+item.isShow+'">'+
                        '<p class="icon-check '+onoff+'">'+item.title+'</p>'+
                    '</div>';
            })
            str += '<div class="clear"></div></form></div>'+
            '<div class="attend-model-footer">'+
                '<button type="button" class="btn ht-btn-blue" style="float:left;width:200px;" id="table-set-save">保存</button>'+
                '<button type="button" class="btn ht-btn-gray" style="float:right;width:200px;" data-dismiss="modal">取消</button>'+
            '</div>'+
        '</div>';
        $("#modal-content").remove();
        $("#modal-dialog").append(str);
        $("#myModal").modal('show');
	//	$('.table-set').each(function() {
//            if($(this).attr("action")!='')	{
//			   $(this).addClass("on")
//		    }
//        });
    })
	
    $("#modal-dialog").delegate("[action=table-set]","click",function(){
		
        var iconCheck = $(this).find(".icon-check");
        if(iconCheck.hasClass("check-off")){
            iconCheck.removeClass("check-off");
            $(this).children("input").val(1);
        }else{
            iconCheck.addClass("check-off");
            $(this).children("input").val(0);
        }
    })
    $("#modal-dialog").delegate("#table-set-save","click",function(){
        $.post("/attendee/setheader.json",$("#form-table-set").serialize(),function(data){
            if(data.status !== 1){
                Notify.log(data.msg);
            }else{
                window.location.reload();
            }
        })
    })
    $("#modal-dialog").delegate("#manage-save","click",function(){
        var formID = $("#manage-add");
        $(".error-tip").remove();
        formID.find('.form-group').removeClass('has-error');
        var name = formID.find("input[name='name']");
        var phone = formID.find("input[name='phone']");
        var patternMobile=/^1[3|4|5|7|8][0-9]\d{8}$/;
        var email = formID.find("input[name='email']");
        var company = formID.find("input[name='company']");
        var position = formID.find("input[name='position']");
        var patternEmail=/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var fal = true;
        
        if(null == name.val() || "" == name.val() || "姓名" == name.val()){
            name.parent("div").addClass('has-error');
            name.after('<div class="error-tip">姓名不为为空</div>');
            fal = false;
        }
        
        if(null == phone.val() || "" == phone.val() || "手机" == phone.val()){
            phone.parent("div").addClass('has-error');
            phone.after('<div class="error-tip">手机号码不为为空</div>');
            fal = false;
        }else{
        	if(false == patternMobile.test(phone.val())){
	            phone.parent("div").addClass('has-error');
	            phone.after('<div class="error-tip">手机号码格式不正确</div>');
	            fal = false;
	        }
        }
        
        
        
        if(email.val() != "邮箱" && email.val()){
            if(false == patternEmail.test(email.val())){
                email.parent("div").addClass('has-error');
                email.after('<div class="error-tip">邮箱格式不正确</div>');
                fal = false;
            }
        }
        if(fal == false){
        	return fal;
        }
        if(email.val() == "邮箱"){
        	email.val('');
        }
        if(company.val() == "公司"){
        	company.val('');
        }
        if(position.val() == "职位"){
        	position.val('');
        }
        $.post('/attendee/manage.json',formID.serialize(),function(data){
            
            if(data.status == 1){
                window.location.reload();
            }else{
                Notify.log(data.msg);
            }
        });
    })
    
    $('[action="check"] [type="checkbox"]').click(function(){
        var parent = $(this).parents("tr");
        if(parent.hasClass('active')){
            parent.removeClass('active');
        }else{
            parent.addClass('active');
        }
        //event.stopPropagation();
    });
   

    $('#checkAll').click(function(){
        var checked = $(this).is(':checked');
        $('[action="select"]').each(function(){
            var active = $(this).hasClass('active');
            if((checked && !active) || (!checked && active)){
                $(this).find('input[type="checkbox"]').trigger('click');
            }
        })
    });
  
    //导入参会人
    $("#import-attendee").click(function(){
        $("#myModalFile").modal('show'); 
    });
	        
    $("#ctlBtn").on( 'click', function() {
    	 var id = $(this).attr("id");
    	 if("complete" == id){
    	 	window.location.reload();
    	 }else{
    	 	$(this).attr("disabled",true);
      	 	swfu.startUpload();
    	 }
    });
    
    //选择文件
    $("#modal-dialog").delegate("#select-file","click",function(){
        $("[name='file']").click();
    })
    $("#select-file").click(function(){
        $("[name='file']").click();
    })
    $("[name='file']").change(function(){
        var fileName = $(this).val();
        $("#file-name").val(fileName);
    })
    $("#modal-dialog").delegate("[name='file']","change",function(){
        var fileName = $(this).val();
        $("#file-name").val(fileName);
    })
    $("#modal-dialog").delegate("#import-save","click",function(){
        //alert(22222);
        var iframe = $("#iframe-file-import").contents();
        if(iframe.find("#file-name").val() == false){
            Notify.log("请选择文件");
            return false;
        }
        iframe.find("#import").attr("action","/attendee/import.html").submit();
        $("#attend-model-footer").find("button").remove();
        var str = '<button type="button" class="btn btn-success" style="float:right;width:200px;font-size: 16px;" id="import-success">完成</button>';
        $("#attend-model-footer").append(str);
    })
    $("#modal-dialog").delegate("#import-success","click",function(){
        window.location.reload();
    })
    
    $("[action='set-attendee']").click(function(){
        var actionType = $(this).attr("action-type");
        var action = $("#attendee-table").find('tr.active');
        if(action.length <1){
            //alert("请选择参会人");
            Notify.log("请选择参会人");
            return false;
        }
        var dataId=[];
        $.each(action,function(i,item){
            dataId.push($(item).attr('data-id'))
        })
        var postData = {
            action : actionType,
            dataId : dataId
        }
        $.post("/attendee/manage.json",postData,function(data){
            /*Notify.log(data.msg);
            if(actionType == 'delete'){
                window.location.reload();
            }*/
            if(data.status == 1){
                window.location.reload();
            }else{
                Notify.log(data.msg);
            }
        })
    });

    
    
});

function refuse(id,aid,obj){
	$(obj).attr("disabled",true);
	SysUtil.Dialog.confirm('您确定拒绝该参会人？','拒绝参会人', function(f, param){
		if('1' == f) {
			jQuery.post('/attendee/refuse.json', {id:id,aid:aid}, function(rs){
				if('0' == rs.status) {
					window.location.reload();
				} else {
					SysUtil.Dialog.alert(rs.msg);
					$(obj).attr("disabled",false);
				}
				
			});
		}else{
			$(obj).attr("disabled",false);
		}
	});
	
}

function sendmsg(id,aid,phone,obj){
	$(obj).attr("disabled",true);
	SysUtil.Dialog.confirm('您确认是否要发送电子票到'+phone+'吗？','发送电子票', function(f){
		if('1' == f) {
			jQuery.post('/attendee/sendmsg.json',{id:id,aid:aid}, function(rs){
				if('0' == rs.status) {
					window.location.reload();
				} else {
					SysUtil.Dialog.alert(rs.msg);
					$(obj).attr("disabled",false);
				}
				
			});
		}else{
			$(obj).attr("disabled",false);
		}
	});
}



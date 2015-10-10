require.config({ //配置
    baseUrl: SP_URL_STO,
    paths: {
        jquery: 'vendor/jquery/jquery-1.9.1.min',
        avalon: "vendor/avalon/avalon", //必须修改源码，禁用自带加载器，或直接删提AMD加载器模块
        validation: 'vendor/avalon/avalon.validation',
        text: 'vendor/require/text',
        domReady: 'vendor/require/domReady',
        css: 'vendor/require/css.js',
        mmPromise: 'vendor/avalon/mmPromise',
        notify:'vendor/notify/notify_md'
    },
    priority: ['text', 'css'],
    shim: {
        jquery: {
            exports: "jQuery"
        },
        avalon: {
            exports: "avalon"
        }
    }
});



require(['avalon', 'validation', "domReady!", 'jquery','notify'], function() { //第二块，添加根VM（处理共用部分）
    avalon.log("加载avalon完毕，开始构建根VM与加载其他模块" );
    function setSiwperHeight() {
        $('.swiper-container').height($(window).height() - $('.header').outerHeight());
    }

    setSiwperHeight();

    $(window).on('resize', setSiwperHeight);

    // var mySwiper = new Swiper('.swiper-container', {
    //     // Optional parameters
    //     pagination: '.swiper-pagination',
    //     loop: true,
    //     autoplay: 3000
    // })
    var interFaceUrl = {
        reg: 'user/register.json',
        login: 'user/login.json',
        getCode:'user/message.json?type=pwdcode',
        findpwd:'user/message.json?type=repwd'
    }


    var indexPage = avalon.define({
        $id: "indexPage",
        loginIsShow: false,
        regIsShow: false,
        findPwdShow:false,
		regSuccess:false,
        showreg: function() {
        	$('.layer-bg').show();
            indexPage.regIsShow = true;
            indexPage.loginIsShow = false;
        },
        showlogin: function() {
        	$('.layer-bg').show();
            indexPage.regIsShow = false;
            indexPage.loginIsShow = true;
        },
        showPwd:function(){
			$('.layer-bg').show();
            indexPage.regIsShow = false;
            indexPage.loginIsShow = false;
            indexPage.findPwdShow=true;
			indexPage.regSuccess = false;
        },
        close:function(){
			$('.layer-bg').hide();
            indexPage.regIsShow = false;
            indexPage.loginIsShow = false;
            indexPage.findPwdShow=false
			indexPage.regSuccess = false;
        },
         currentIndex: 0,
          toggle: function(index) {
            console.log($(this).parent('li').siblings().removeClass('on').end().addClass('on'))
            
                    indexPage.currentIndex = index;
                    console.log(indexPage.currentIndex)
                }
    })



    //注册

    var regValidationVM;

    function showError(el, data) {
        $(el).parent().find('.error-tip').show().html(data.message);
        // var next = el.nextSibling
        // if (!(next && next.className === "error-tip")) {
        //     next = document.createElement("div")
        //     next.className = "error-tip"
        //     el.parentNode.appendChild(next)
        // }
        // next.innerHTML = data.getMessage()
    }

    function removeError(el) {
        avalon.log($(el).parent().find('.error-tip'));

        $(el).parent().find('.error-tip').hide()
            // var next = el.nextSibling;



        // if (next && next.className === "error-tip") {
        //     el.parentNode.removeChild(next)
        // }
    }

    var regModel = avalon.define({

        $id: 'reg',
        $skipArray: ["validation"],
        mobile: '',
        email: '',
        passwd: '',
        confirm_passwd: '',
        captcha: '',
        errorTxt: "",
        changCaptcha: function() {
            var t = new Date().getTime();
            $(this).attr('src', '/user/captcha.html?' + t)
        },
        validation: {
            validationHooks: {
                match12345: {
                    message: "必须等于12345",
                    get: function(value, data, next) {
                        next(value === "12345")
                        return value
                    }
                },
                alpha_passwd: { //这是名字，不能存在-，因为它是这样使用的ms-duplex-int-alpha_numeric="prop"
                    message: '必须为字母、数字或者下划线，大于6位小于24位', //这是错误提示，可以使用{{expr}}插值表达式，但这插值功能比较弱，
                    //里面只能是某个单词，两边不能有空格
                    get: function(value, data, next) { //这里的传参是固定的，next为回调
                        next(/^[a-z0-9_]{6,24}$/i.test(value)) //这里是规则
                            //如果message有{{expr}}插值表达式，需要用data.data.expr = aaa设置参数，
                            //aaa可以通过data.element.getAttribute()得到
                        return value //原样返回value
                    }
                }
            },
            onInit: function(v) {
                validationVM = v;
                regModel.errorTxt = '';
            },
            onReset: function(e, data) {
                avalon.log('onReset ...')
                removeError(this)
            },
            onError: function(reasons) {
                // alert('onError')
                reasons.forEach(function(reason) {
                    avalon(this).removeClass("success").addClass("error")
                    showError(this, reason)
                }, this)
            },
            onSuccess: function() {
                avalon(this).removeClass("error").addClass("success")
                removeError(this)
            },
            onValidateAll: function(reasons) {

                if (reasons.length !== 'undefined' && reasons.length !== 0) {
                    $(reasons).each(function(k, reason) {
                        avalon(reason.element).removeClass("success").addClass("error");
                        showError(reason.element, reason)
                    })

                }


                if (reasons.length === 0) {
                    avalon.log("全部验证成功！");

                    $.post(interFaceUrl.reg, {
                        mobile: regModel.mobile,
                        email: regModel.email,
                        passwd: regModel.passwd,
                        confirm_passwd: regModel.confirm_passwd,
                        captcha: regModel.captcha
                    }, function(json) {
                    	if(json.status == 0){
                    		indexPage.regIsShow = false;
				            indexPage.loginIsShow = false;
				            indexPage.findPwdShow=false
							indexPage.regSuccess = true;
                    		console.log(indexPage)
                    	}else{
                    		regModel.errorTxt = (json.msg);


                    	    return;
                    	}
                    })
                }
            }
        }


    })

    //登录
    var validationVM;

    function removeErroLogin(el) {
        // var next = el.nextSibling
        // while (next) {
        //     if (next.className === "error-tip") {
        //         el.parentNode.removeChild(next)
        //         break
        //     }
        //     next = next.nextSibling
        // }
        loginMod.errorTxt = ''
    }



    var loginMod = avalon.define({
        $id: "login",
        $skipArray: ["validation"],
        username: "",
        password: "",
        errorTxt: "",
        autologin: false,
        reset: function() {
            validationVM && validationVM.resetAll()
        },
        validation: {
            onInit: function(v) {
                validationVM = v
            },
            onError: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(this).removeClass("success").addClass("error");
                    loginMod.errorTxt = reason.message
                }, this)
            },
            onSuccess: function() {
                avalon(this).removeClass("error").addClass("success")
                loginMod.errorTxt = ''

            },
            onValidateAll: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(reason.element).removeClass("success").addClass("error");
                    loginMod.errorTxt = reason.message
                })
                if (reasons.length === 0) {
                    avalon.log("全部验证成功！");

                    $.post(interFaceUrl.login, {
                        username: loginMod.username,
                        password: loginMod.password,
                        autologin: loginMod.autologin
                    }, function(data) {
                        if(data.status=='0'){
                            window.location.href='active/index.html'
                        }else{
                             loginMod.errorTxt = (data.msg);
                                setTimeout(function(){
                                        loginMod.errorTxt=''
                                    },1000)
                             return;
                        }

                        avalon.log(data);
                       
                    })
                }
            }
        }
    })


    //找回密码
    var timer=null
      var FindpwdbyMobile = avalon.define({
        $id: "FindpwdbyMobile",
        $skipArray: ["validation"],
        username: "",
        code : "",
        errorTxt: "",
        getCode:function(e,$this){


            if(timer){
                return
            }

       


            if(FindpwdbyMobile.username==''){

                FindpwdbyMobile.errorTxt='手机号不能为空'

                setTimeout(function(){
                    FindpwdbyMobile.errorTxt=''
                },1000)
                                return

            }

      


         








            $.post(interFaceUrl.getCode,{
                username:FindpwdbyMobile.username
            },function(json){

	             if(json.status==0){

               var time=60;

                timer=setInterval(function(){
                if(time==0){ clearInterval(timer)} 
                e.target.innerHTML=time--+'秒'
                },1000)

	
	             }
	             else{
	           		 FindpwdbyMobile.errorTxt = (json.msg);
                      setTimeout(function(){
                            FindpwdbyMobile.errorTxt=''
                        },1000)
	             }


            })

        },
        validation: {
            onInit: function(v) {
                validationVM = v;
                FindpwdbyMobile.errorTxt = '';
            },
            onError: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(this).removeClass("success").addClass("error");
                }, this)
            },
            onSuccess: function() {
                avalon(this).removeClass("error").addClass("success")

            },
            onValidateAll: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(reason.element).removeClass("success").addClass("error");
                })
                if (reasons.length === 0) {
                    avalon.log("全部验证成功！");

                    $.post(interFaceUrl.findpwd, {
                        username: FindpwdbyMobile.username,
                        code: FindpwdbyMobile.code
                    }, function(data) {
                       FindpwdbyMobile.errorTxt = (data.msg);
                    })
                }
            }
        }
    })



 var FindpwdbyEmail = avalon.define({
        $id: "FindpwdbyEmail",
        $skipArray: ["validation"],
        username: "",
        code : "",
        errorTxt: "",
        getCode:function(){

               if(FindpwdbyEmail.username==''){



                FindpwdbyEmail.errorTxt='邮箱地址不能为空'

                setTimeout(function(){
                    FindpwdbyEmail.errorTxt=''
                },1000)
                                return

            }


            $.post(interFaceUrl.getCode,{
                username:FindpwdbyEmail.username
            },function(json){

                if(json.status==0){

                    notify.log('验证码已发送,请前往邮箱查收')

                }
                else{
                	FindpwdbyEmail.errorTxt = (json.msg);
                      setTimeout(function(){
                            FindpwdbyEmail.errorTxt=''
                     },1000)
                }


            })

        },
        validation: {
            onInit: function(v) {
                validationVM = v;
                FindpwdbyEmail.errorTxt = '';
            },
            onError: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(this).removeClass("success").addClass("error");
                }, this)
            },
            onSuccess: function() {
                avalon(this).removeClass("error").addClass("success")

            },
            onValidateAll: function(reasons) {
                reasons.forEach(function(reason) {
                    avalon(reason.element).removeClass("success").addClass("error");
                })
                if (reasons.length === 0) {
                    avalon.log("全部验证成功！");

                    $.post(interFaceUrl.findpwd, {
                        username: FindpwdbyEmail.username,
                        code: FindpwdbyEmail.code
                    }, function(data) {

                        avalon.log(data);
                        FindpwdbyEmail.errorTxt = data.msg;
               
                    })
                }
            }
        }
    })

    








    avalon.scan(document.body)



});

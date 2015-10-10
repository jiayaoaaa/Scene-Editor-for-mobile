var authCode = {
    count : 60,
    curCount:'',
    msg     :{
        "phone" : "电话格式不正确",
        "email" : "邮箱格式不正确"
    },
    setId : function(id){
        self.id = id;
    },
    setCount : function(count){
        this.count = count;
    },
    sendMessage : function(id,account,type){
        if(this.check(account,type)){
            $.post('/account/accountAuth.json',{account:account,type:type,action:"send"},function(data){
                if(data.status != 1){
                    //Notify.log(data.msg);
                    $("#message").html('<span style="color:#f00;line-height: 26px;">'+data.msg+'</span>');
                }else{
                    authCode.ExeRemainTime(id);
                    $("#message").html('<span style="color:#76d728;line-height: 26px;">验证码已发送</span>');
                }
            });
        }else{
            Notify.log(this.msg[type]);
            return false;
        }
    },
    authCode:function(account,code,type){
        var goto = {
            "phone" : "/account/PhoneSuccess.html",
            "email" : "/account/EmailSuccess.html"
        }
        if(6 == code.length){
            if(this.check(account,type)){
                $.post('/account/accountAuth.json',{account:account,type:type,code:code,action:"auth"},function(data){
                    if(1 == data.status){
                        window.location.href = goto[type];
                    }else{
                        //Notify.log(data.msg);
                        $("#message").html('<span style="color:#f00;">'+data.msg+'</span>');
                        return false;
                    }
                })
            }
        }else{
            //Notify.log("验证码格式错误");
            $("#message").html('<span style="color:#f00;">请输入6位验证码</span>');
            return false;
        }
    },
    check:function(account,type){
        var rules = {
            "phone":/^1[3|4|5|7|8][0-9]\d{8}$/,
            "email":/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
        };
        if(rules[type]){
            if(rules[type].test(account)){
                return true;
            }
            Notify.log(this.msg[type]);
            return false;
        }
        return false;
    },
    ExeRemainTime:function(id){
        this.setId(id);
        curCount = this.count;
        $("#"+self.id).attr("disabled", "true");
        $("#"+self.id).text(curCount);
        InterValObj = window.setInterval(this.SetRemainTime, 1000);
    },
    SetRemainTime : function(){
        //console.log(curCount);
        if (curCount == 0) {
            window.clearInterval(InterValObj);//停止计时器
            $("#"+self.id).removeAttr("disabled");//启用按钮
            $("#"+self.id).text("获取验证码");
        }else {
            curCount--;
            $("#"+self.id).text(curCount);
        }
    }
}

//authCode.sendMessage('authCode',$('#phone').val());
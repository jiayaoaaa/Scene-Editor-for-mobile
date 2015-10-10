<?PHP


class User_Register extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * 采用post提交
     * email : 邮箱
     * mobile:手机号
     * passwd:密码,8-20位
     * confirm_passwd:确认密码
     * captcha:验证码
     * 验证码生存demo:<img src="/user/Captcha.html">
     * return json array('status'=>'10001','msg'=>'注册成功')
     */
    public function execute($request)
    {
        if($request->format == 'json'){
            $result = $this->check($request->email,$request->mobile,$request->passwd,$request->confirm_passwd,$request->captcha);
            if(true === $result){
                $regtime = $request->REQUEST_TIME;
                $userid = Sp_Account_UniqueId::getUniqueId();
                
                if( false == $userid){
                    return array('status'=>'-127','msg'=>'注册失败');
                }
                $data = array(
                    'userid'    =>$userid,
                    'email'     =>trim($request->email),
                    'mobile'    =>trim($request->mobile),
                    'pwd'       =>trim($request->passwd),
                    'regtime'   =>$regtime,
                    'regip'     =>$request->CLIENT_IP,
                    'kid'       =>$regtime+10
                );
                $lastid = Sp_Account_Regist::storeUser($data);
				if($lastid){
					$obj = $request;
					$obj->username =  $request->mobile;
					$obj->password = $request->passwd;
					$obj->CLIENT_IP = $request->CLIENT_IP;
					Sp_Account_SignIn::signinFromRequest($obj);
				}
                return array('status'=>'0','msg'=>'注册成功');
            }else{
                return $result;
            }
        }
    }
    /*
     * 验证用户信息
     * $password 密码   8-20位
     * $code 4位
     * return array array('status'=>'10000','msg'=>'注册成功')
     */
    public function check($email='',$mobile='',$passwd='',$confirm_passwd='',$code=''){
        $email = trim($email);
        $mobile = trim($mobile);
        $passwd = trim($passwd);
        $confirm_passwd = trim($confirm_passwd);
        $code = trim($code);
        
        $patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
        $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
        $patternPasswd = Sp_Dictionary::getOtherOption('patternPasswd');
        
        if(false == preg_match($patternEmail,$email)){
            return array('status'=>'-120','msg'=>'邮件格式不正确');
        }else if(false == preg_match($patternMobile,$mobile)){
            return array('status'=>'-121','msg'=>'电话格式不正确');
        }else if(false == preg_match($patternPasswd,$passwd)){
            return array('status'=>'-122','msg'=>'密码格式不正确');
        }else if($passwd !== $confirm_passwd){
            return array('status'=>'-123','msg'=>'密码和确认密码不一致');
        }else if(false == Util_Captcha::verify_captcha($code)){
            return array('status'=>'-124','msg'=>'验证码错误');
        }else if(false == Sp_Account_Regist::isAvailableEmail($email)){
            return array('status'=>'-125','msg'=>'该邮件已经注册');
        }else if(false == Sp_Account_Regist::isAvailableMobile($mobile)){
            return array('status'=>'-126','msg'=>'该手机号已经注册');
        }
        return true;
    }
    
    

}
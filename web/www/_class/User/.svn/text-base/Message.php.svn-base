<?PHP
/**
 * 用户发送消息
 */
class User_Message extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * 有post提交 
     * 采用post提交
     * return json array('status'=>'0','msg'=>'成功')
     */
    public function execute($request)
    {
       if($request->format == 'json'){
        	if($request->type == "pwdcode"){  //发送修改账号短信验证码
        		$result = $this->checkCaptchaAndUser($request->username,$request->code,$request->type);
				if(TRUE === $result){
				   $username = $request->username;
					//计算验证码
				   $code = rand(100000, 999999);
				   $content = "您本次在会通网修改密码的验证码为：".$code.",任何人索取验证码均为咋骗，切勿泄露！此验证码会在15分钟后失效";
				   $sms = array();
				   $sms['username'] = $username;
				   $sms['content'] = $content;
				   $sms['type'] = 'pwdcode';
				   $sms['code'] = $code;
				   $sms['user_id'] = Sp_Account_SignIn::getUserIdBySignIn($username);
				   Sp_Sendmsg::send($sms);	
	               return array('status'=>'0','msg'=>'发送成功');
	            }else{
	              
	               return $result;
	            }
        	}else if($request->type == "repwd"){ //修改密码
        		$result = $this->checkCodeAndUser($request->username,$request->code,'pwdcode');
				if(TRUE === $result){
				   $username = $request->username;
					
					
					//计算验证码
				   $code = rand(100000, 999999);
				   $ret = Sp_Account_User::RePwd($username,$code);
				   if($ret){
					   $content = "您本次修改的密码为：".$code.",任何人索取验证码均为咋骗，切勿泄露！此验证码会在15分钟后失效";
					   $sms = array();
					   $sms['username'] = $username;
					   $sms['content'] = $content;
					   $sms['type'] = 'repwd';
					   $sms['user_id'] = Sp_Account_SignIn::getUserIdBySignIn($username);
					   Sp_Sendmsg::send($sms);	
					   
		               return array('status'=>'0','msg'=>'发送成功');
				   }else{
				   	   return array('status'=>'-1','msg'=>'修改失败');
				   }
	            }else{
	            	 
	               return $result;
	            }
        	}
        	else{
        		return array('status'=>'-101','msg'=>'提交参数错误');
        	}
	   }
	   // else{
			// //var_dump($list);
	   		// $view = new Sp_View;
			// $view->display('test/home.html');
	   // }
    }
	
    /*
     * 验证用户明密码
     * $username 用户名 6-20位 英文或者数字
     * $code 密码   8-20位 
     * return array array('status'=>'0','msg'=>'发送成功')
     */
    public function checkCaptchaAndUser($username='',$code='',$type = ''){
        $username = trim($username);
        $code = trim($code);
        $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');

		// if(false == Util_Captcha::verify_captcha($code)){
			// return array('status'=>'-126','msg'=>'验证码有误');
		// }
	
		if(preg_match($patternEmail,$username) || preg_match($patternMobile,$username)){
				
			if(preg_match($patternMobile,$username)){
				if(TRUE == Sp_Account_Regist::isAvailableMobile($username)){
	            	return array('status'=>'-125','msg'=>'该手机号不存在');
				}
				//判断发送条数
				$count = Sp_Sendmsg::getSmsByPhoneCount($username,$type);
				if($count >= 5){
					return array('status'=>'-126','msg'=>'当天发送该类短信消息不能大于5条.');
				}
				// $row = Sp_Sendmsg::getSmsByPhone($username);
				// $nowTime = time() - $row['crttime'];
				// if(is_array($row) && $nowTime <= 15*60){
					// return array('status'=>'-126','msg'=>'手机15分钟内不能重复发送');
				// }
			}
			
			if(preg_match($patternEmail,$username)){
				if(TRUE == Sp_Account_Regist::isAvailableEmail($username)){
	            	return array('status'=>'-126','msg'=>'该邮箱不存在');
				}
				
				//判断发送条数
				$count = Sp_Sendmsg::getSmsByEmailCount($username,$type);
				if($count >= 5){
					return array('status'=>'-126','msg'=>'当天发送该类邮件消息不能大于5条');
				}
				// $row = Sp_Sendmsg::getSmsByEmail($username);
				// $nowTime = time() - $row['crttime'];
				// if(is_array($row) && $nowTime <= 15*60){
					// return array('status'=>'-126','msg'=>'邮箱15分钟内不能重复发送');
				// }
			}
			
			return TRUE;	
		}else{
			return array('status'=>'-121','msg'=>'格式不正确');
		}
		
    }

	
	 /*
     * 验证消息验证码
     * $username 用户名 6-20位 英文或者数字
     * $code 	 消息验证码 
     * return array array('status'=>'0','msg'=>'修改成功')
     */
    public function checkCodeAndUser($username='',$code='',$type = ''){
        $username = trim($username);
        $code = trim($code);
        $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');

		if(strlen($code) != 6){
			return array('status'=>'-126','msg'=>'验证码长度有误');
		}
	
		if(preg_match($patternEmail,$username) || preg_match($patternMobile,$username)){
				
			if(preg_match($patternMobile,$username)){
				if(TRUE == Sp_Account_Regist::isAvailableMobile($username)){
	            	return array('status'=>'-125','msg'=>'该手机号不存在');
				}
				
				$row = Sp_Sendmsg::getSmsByPhone($username,$type);
			
				$nowTime = time() - $row['crttime'];
				if(!is_array($row) || $nowTime > 15*60 || $row['code'] != $code){
					return array('status'=>'-126','msg'=>'验证码错误');
				}
			}
			
			if(preg_match($patternEmail,$username)){
				if(TRUE == Sp_Account_Regist::isAvailableEmail($username)){
	            	return array('status'=>'-126','msg'=>'该邮箱不存在');
				}
				
			    $row = Sp_Sendmsg::getSmsByEmail($username,$type);
				$nowTime = time() - $row['crttime'];
				if(!is_array($row) || $nowTime > 15*60 || $row['code'] != $code){
					return array('status'=>'-126','msg'=>'验证码错误');
				}
			}
			
			return TRUE;	
		}else{
			return array('status'=>'-121','msg'=>'格式不正确');
		}
		
    }
    
    

}
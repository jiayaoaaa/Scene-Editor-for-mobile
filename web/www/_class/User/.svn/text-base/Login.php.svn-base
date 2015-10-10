<?PHP
/**
 * 登录
 */
class User_Login extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * 有post 提交 登录
     * 采用post提交
     * return json array('status'=>'0','msg'=>'登录')
     */
    public function execute($request)
    {
        if($request->format == 'json'){
            $result = $this->check($request->username,$request->password);
            if(TRUE === $result){
            	Loader::nocache();
				$ret = Sp_Account_SignIn::signinFromRequest($request);
				if(is_numeric($ret) && $ret > 0){
					return array('status'=>'0','msg'=>'登录成功');
				}else{
					return array('status'=>'-123','msg'=>'您输入的帐号或密码有误');
				}
               
            }else{
               return $result;
            }
        }else{
            
        }
    }
	
    /*
     * 验证用户明密码
     * $username 用户名 6-20位 英文或者数字
     * $password 密码   8-20位 
     * return array array('status'=>'0','msg'=>'登录成功')
     */
    public function check($username = '',$passwd = ''){
        $username = trim($username);
        $passwd = trim($passwd);
        $confirm_passwd = trim($confirm_passwd);
        
        $patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
        $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
        $patternPasswd = Sp_Dictionary::getOtherOption('patternPasswd');
        $patternUserId = Sp_Dictionary::getOtherOption('patternUserId');
		if((preg_match($patternEmail,$username) || preg_match($patternMobile,$username) || preg_match($patternUserId,$username)) && strlen($passwd) >= 6){
			return TRUE;	
		}else{
			if(false == preg_match($patternEmail,$username)){
	            return array('status'=>'-120','msg'=>'账户名格式不匹配');
	        }else if(strlen($passwd) < 6){
	        	return array('status'=>'-105','msg'=>'密码长度在6-16位字符之间');
	        }
		}
    }
    
    

}
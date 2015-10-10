<?PHP
/**
 * 修改密码
 */
class Account_Resetpassword extends Sp_Account_Action_Abstract
{
    
    public function execute($request)
    {
		if($request->format == 'json') {
			$user = Sp_Account_User::current();
			$userid = $user->id;
			$row = Sp_Account_User::getUser($userid);
			
			$old = $request->old;
			$password = $request->password;
			$confirming = $request->confirming;
			$patternPasswd = Sp_Dictionary::getOtherOption('patternPasswd');
			
			if(false == preg_match($patternPasswd,$old)){
	            return array('status'=>'-122','msg'=>'密码格式不正确');
	        } 
			
			if(false == preg_match($patternPasswd,$confirming)){
	            return array('status'=>'-122','msg'=>'密码格式不正确');
	        } 
			
			if(false == preg_match($patternPasswd,$password)){
	            return array('status'=>'-122','msg'=>'密码格式不正确');
	        } 
			
			// 旧密码
			if(!$this->checkOldPassword($old, $row)) {
				return array('status'=>'-1', 'msg'=>'旧密码不正确');
			}
			
			if($password != $confirming) {
				return array('status'=>'-2', 'msg'=>'两次密码不一致');
			}
			
			$newpwd = Sp_Account_User::encrypt($password, $row['kid']);
			Sp_Account_Info::updatePassword($userid, $newpwd);
			
			return array('status'=>'0', 'msg'=>'密码修改成功');
		}
    }
	
	/**
	 * 检查旧密码 (md5(md5(密码)+kid))  
	 * 
	 * @param string $oldpassword 旧密码
	 * @param array $data 用户数据
	 */
	public function checkOldPassword($oldpassword, & $data) {
		$tmppwd = Sp_Account_User::encrypt($oldpassword, $data['kid']);
		if($tmppwd == $data['pwd']) {
			return true;
		}
		
		return false;
	}
}



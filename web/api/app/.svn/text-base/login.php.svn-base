<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// $Id$
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';

/*
 * 验证用户明密码
 * $username 用户名 6-20位 英文或者数字
 * $password 密码   8-20位 
 * return array array('status'=>'0','msg'=>'登录成功')
 */
 function check($username = '',$passwd = ''){
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
            return array('code'=>'400','msg'=>'账户名格式不匹配');
        }else if(strlen($passwd) < 6){
        	return array('code'=>'400','msg'=>'密码长度在6-16位字符之间');
        }
	}
}

$jsonParam = array();
$request = Request::current();
$result = check($request->username,$request->password);
if(TRUE === $result){
	Loader::nocache();
	$ret = Sp_Account_SignIn::signinFromRequest($request);
	if(is_numeric($ret) && $ret > 0){
		$jsonParam =  array('code'=>'200','msg'=>'登录成功','uid'=>$ret);
	}else{
		$jsonParam =  array('code'=>'400','msg'=>'您输入的帐号或密码有误');
	}
   
}else{
   $jsonParam =  $result;
}

header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);

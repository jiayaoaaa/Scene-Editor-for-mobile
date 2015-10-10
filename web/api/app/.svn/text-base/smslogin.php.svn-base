<?php
    define('ROOT_PATH', __DIR__ . '/../../../');
	include_once ROOT_PATH . 'config/init.php';
	
	/**
	 * 检查手机号
	 * 
	 * @param string $phone 手机号
	 * @return array | true
	 */
	function checkPhone($phone = '') {
		$patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		
		if(empty($phone)) {
			return array('code'=>'400','msg'=>'手机号不能为空');
			
		} else if(false == preg_match($patternMobile,$phone) ){
			return array('code'=>'400','msg'=>'手机格式不正确');
			
		} else if(Sp_Account_Regist::isAvailableMobile($phone)) {
			return array('code'=>'400','msg'=>'手机号不存在');
		}
		
		return true;
		
	}
	
	/**
	 * 检查是否可以登录
	 *
	 * @param string $code 验证码
	 * @param string $phone 手机号
	 */
	function checkLogin($code, $phone) {
		$row = Sp_Sendmsg::getSmsByPhone($phone,'smslogin');
		$nowTime = time() - $row['crttime'];
		if(!is_array($row) || $nowTime > 15*60 || $row['code'] != $code){
			return array('code'=>'400','msg'=>'验证码错误');
		}
		
		return true;
	}
	
	/**
	 * 发送短信
	 *
	 * @param string $phone 手机号
	 */
	function sendSms($phone) {
		$content = '您的验证码为: [code], 任何人索取验证码均为咋骗，切勿泄露！此验证码会在15分钟后失效';
		$code = mt_rand(100000, 999999);
		Sp_Sendmsg::send(array(
			'type' => Sp_Dictionary::getSmsType(0),
			'username' => $phone,
			'code' => $code,
			'content' => str_replace('[code]', $code, $content)
		));
		
		return true;
	}

	$jsonParam = array();
	$request = Request::current();
	$phone = $request->phone;  // 获得手机号
	$rs = checkPhone($phone);
	
	if(is_array($rs)) {
		$jsonParam = $rs;
	}else{
		// 获取短信验证码
		if('getcode' == $request->type){
			sendSms($phone);
			$jsonParam =  array('code'=>'200','msg'=>'短信发送成功');
			
		} else {  // 登陆
			$code = $request->code;
			$rs = checkLogin($code, $phone);
			if(is_array($rs)) {
				$jsonParam =  $rs;
			}else{
				$user = Sp_Account_SignIn::getUserByPhone($phone);
				$jsonParam =  array('code' => '200', 'msg'=>'登录成功','uid'=>$user['id']);
			}
		}
	}
	
	header('Content-type: application/json;charset=utf-8');
	echo json_encode($jsonParam);
?>
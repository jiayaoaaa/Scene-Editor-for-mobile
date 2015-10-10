<?PHP

/**
 * 获取短信登陆码
 */
class User_Smslogin extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
        if($request->format == 'json'){
			$phone = $request->phone;  // 获得手机号
			$rs = $this->checkPhone($phone);
			
			if(is_array($rs)) {
				return $rs;
			}
			
			// 获取短信验证码
			if('getcode' == $request->type){
				$this->sendSms($phone);
				
				return array('status'=>'0','msg'=>'短信发送成功');
				
			} else {  // 登陆
				$code = $request->code;
				$rs = $this->checkLogin($code, $phone);
				
				if(is_array($rs)) {
					return $rs;
				}
				
				return array('status' => '0', 'msg'=>'登录成功');
			}
		}
    }
   
	/**
	 * 检查手机号
	 * 
	 * @param string $phone 手机号
	 * @return array | true
	 */
	public function checkPhone($phone = '') {
		$patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		
		if(empty($phone)) {
			return array('status'=>'-1','msg'=>'手机号不能为空');
			
		} else if(false == preg_match($patternMobile,$mobile) ){
			return array('status'=>'-2','msg'=>'手机格式不正确');
			
		} else if(!Sp_Account_Regist::isAvailableMobile($mobile)) {
			return array('status'=>'-3','msg'=>'手机号不存在');
		}
		
		return true;
		
	}
	
	/**
	 * 检查是否可以登录
	 *
	 * @param string $code 验证码
	 * @param string $phone 手机号
	 */
	public function checkLogin($code, $phone) {
		$row = Sp_Sendmsg::getSmsByPhone($phone,'smslogin');
		$nowTime = time() - $row['crttime'];
		if(!is_array($row) || $nowTime > 15*60 || $row['code'] != $code){
			return array('status'=>'-4','msg'=>'验证码错误');
		}
		
		return true;
	}
	
	/**
	 * 发送短信
	 *
	 * @param string $phone 手机号
	 */
	public function sendSms($phone) {
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
}
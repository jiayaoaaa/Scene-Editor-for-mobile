<?php
// $Id$

/**
 * 用户登录
 * Sp_Account_SignIn::signinFromRequest($request); 
 */
class Sp_Account_SignIn extends Sp_Account_User
{
	const DB_TABLE_USER = 'sp.huitong.ht_users';

	public function __construct(){

	}


	/**
	 * 检查一个用户名是否可用
	 *
	 * @param string
	 * @return boolean
	 */
	public static function isAvailableUid($login, $check_db = TRUE)
	{
		if ( (strlen($login) < 6))
		{
			return FALSE;
		}

		if($check_db) {
			$sql = "SELECT id FROM users WHERE username = ?";
			$dbo = Da_Wrapper::dbo(self::DB_TABLE_USER);
			$sth = $dbo->prepare($sql);
			$sth->execute(array($login));
			$id = $sth->fetchColumn(0);
			if($id > 0) return false;
		}

		return TRUE;
	}

	/**
	 * 检查一个Email是否可用
	 *
	 * @param string
	 * @return boolean
	 */
	public static function isAvailableEmail($email, $check_db = TRUE)
	{
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
		if(!preg_match($patternEmail, $email)) {
			return FALSE;
		}
		if($check_db) {
			$email = Da_Wrapper::select()
				->table(self::DB_TABLE_USER)
				->columns('id')
				->where('email',$email)
				->getOne();
			if($email) return false;
		}
		return TRUE;
	}

	protected static function isLegalLogin($login) {
		return self::isAvailableUid($login, FALSE) || self::isAvailableEmail($login, FALSE);
	}

	/**
	 * function signinFromRequest
	 *
	 * @param object $request
	 * @return mixed
	 */
	public static function getUserIdBySignIn($username,$column = 'id'){
		$patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
		
		$field_name = 'userid';
		if(preg_match($patternMobile, $username)) {
			$field_name = 'mobile';
		}elseif(preg_match($patternEmail, $username)){
			$field_name = 'email';
		}
		
		$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_USER)
				->columns($column)
				->where($field_name,'=',$username)
				->getOne();
		return $ret;		
	}

	/**
	 * function signinFromRequest
	 *
	 * @param object $request
	 * @return mixed
	 */
	public static function signinFromRequest($request)
	{
		$username = $request->username;
		$password = $request->password;
		$request_ip = $request->CLIENT_IP;
		$autologin = $request->autologin;//记住用户名
		$user = self::authenticate($username, $password);
		$cookie_life = null;
		if($request->isMobile()) {
			$cookie_life = parent::_idle_time_wap;
		}
		self::setHttpCookie($user, null, $cookie_life);
		if(is_object($user)) {
			$sql = "update ht_users set login_nums = login_nums+1, logintime = ?, loginip=? where id=?";
			$sth = Da_Wrapper::dbo(self::DB_TABLE_USER)->prepare($sql);
			$ret = $sth->execute(array($request->REQUEST_TIME, $request->CLIENT_IP, $user->id));
			if($autologin == 'true') {
				self::setUserNameCookie($username);//记住用户名
			}else{
				self::setUserNameCookie('');//删除用户名
			}
			return $user->id;
		}
		return $user;
	}
	
	/**
	 * 第三方单点登录
	 * 
	 */
	public static function signinFromThirdUser($userinfo)
	{
		if(empty($userinfo) || !isset($userinfo['userid']))
			return false;
		$username = $user['userid'];
		$user = self::load($userinfo['userid'], 'userid', 0);
		self::setHttpCookie($user);
		if(is_object($user)) {
			$sql = "update users set login_nums = login_nums+1, last_time = ?, last_ip=? where id=?";
			$sth = Da_Wrapper::dbo(self::DB_TABLE_USER)->prepare($sql);
			$ret = $sth->execute(array($request->REQUEST_TIME, $request->CLIENT_IP, $user->id));
			return $user->id;
		}
		return $user;
		
	}
	
	/**
	 * 根据登录名和密码，验证用户
	 *
	 * @param string $username
	 * @param string $password
	 * @param array $option = null
	 * @return mixed 成功返回对象，失败返回 负数或FALSE
	 */
	public static function authenticate($username, $password, $option = null)
	{
		$src_id = isset($option['src_id']) ? $option['src_id'] : 0;
		$username = trim($username);
		if(!$username) {
			return parent::ERR_USERNAME_NOT_FOUND;
		}
		$patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
		
		if(preg_match($patternMobile, $username)) {
			$field_name = 'mobile';
		}elseif(preg_match($patternEmail, $username)){
			$field_name = 'email';
		}else{
			$field_name = 'userid';
		}
	
		$user = self::load($username, $field_name, $src_id);
		if($user->valid()) {
			$crypted_password = self::encrypt($password, $user->kid);
			if($crypted_password == trim($user->pwd)) {
				if($user->status == 1) {
					return parent::ERR_ACCOUNT_DISABLED;
				}
				return $user;
			} else {
				Sp_Log::notice('password incorrect: '.$crypted_password.' - ' . $user['pwd']);
				return parent::ERR_PASSWORD_INCORRECT;
			}
		}
		return parent::ERR_USERNAME_NOT_FOUND;

	}
	/**
	 * 通过手机获得对应的用户信息
	 */
	public static function getUserByPhone($phone){
		$select = Da_Wrapper::select()
			->table(self::DB_TABLE_USER)
			->where('mobile', $phone);
		return $select->getRow();
	}
}
<?php
/**
 * 用户注册类
 * Sp_Account_Regist::register($request);  //注册用户
 */
class Sp_Account_Regist extends Sp_Account_User
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_USER = 'sp.huitong.ht_users';

	function __construct(){

	}

	/**
	 * 检查是否存在指定的记录
	 *
	 * @param string $value
	 * @param string $colname
	 * @return void
	 */
	public static function getUid($value, $colname = 'userid')
	{
		$field = array('userid','email','mobile');
		if (!in_array($colname,$field)) $colname = 'userid';
		$id = Da_Wrapper::getOne(self::DB_NS, "SELECT id FROM ht_users WHERE $colname = ?", array($value));
		return $id;
	}

	/**
	 * 检查一个Email是否可用
	 *
	 * @param string
	 * @return int
	 */
	public static function isAvailableEmail($email)
	{
		return !(self::getUid($email, 'email') > 0);
	}


	/**
	 * 检查一个用户名是否可用
	 *
	 * @param string
	 * @return int
	 */
	public static function isAvailableUid($username)
	{
		return !(self::getUid($username, 'userid') > 0);
	}
	
	
	/**
	 * 检查一个手机是否可用
	 *
	 * @param string
	 * @return int
	 */
	public static function isAvailableMobile($mobile)
	{
		return !(self::getUid($mobile, 'mobile') > 0);
	}
	


	/**
	 * function register
	 * 
	 *  注册用户
	 * 
	 * @param
	 * @return void
	 */
	public static function register($request)
	{
		$username = $request->username;
		$password = $request->password;
		if( strlen($username) < 4 || strlen($username) > 40)
		{
			return -101;
		}
		if( strlen($password) < 6 || strlen($password) > 40)
		{
			return -121;
		}
		
		//判断用户是否存在
		if(self::isAvailableUid($request->username) != TRUE){
			return -108;
		}
		
		//判断手机邮箱是否存在
		if(self::isAvailableEmail($request->email) != TRUE || self::isAvailableMobile($request->mobile) != TRUE){
			return -109;
		}
		
		$email = $request->email;
		$mobile = $request->mobile;
		$now = $request->REQUEST_TIME;
		$rowUser['userid'] = $username;
		$rowUser['pwd'] = $password;
		$rowUser['mobile'] = $mobile;
		$rowUser['email'] = $email;
		$rowUser['kid'] = $now + 10;   //加密kid
		$rowUser['regtime'] = $now;
		$rowUser['regip'] = $request->CLIENT_IP;
		$rowUser['status'] = 0;

		$_refs = Sp_Session::getReferers();
	
		$uid = self::storeUser($rowUser);
		if($uid > 0) {
			$_user = self::load($uid);
			Sp_Account_SignIn::setHttpCookie($_user);

			//设置登录
			$sql = "update ht_users set login_nums = login_nums+1, logintime = ?, loginip=? where id=?";
			$sth = Da_Wrapper::dbo(self::DB_TABLE_USER)->prepare($sql);
			$ret = $sth->execute(array($request->REQUEST_TIME, $request->CLIENT_IP, $uid));
		}
		return $uid;
	}

	/**
	 * 存储用户基本信息
	 *
	 * @param array
	 * @return int
	 */
	public static function storeUser($row)
	{
		$row['pwd'] = self::encrypt($row['pwd'],$row['kid']);
		if (is_array($row)){
			$ret = Da_Wrapper::insert()
				->table(self::DB_TABLE_USER)
				->data($row)
				->execute();
		} else {
			return false;
		}
        return true;
//        $uid = self::getUid($row['userid']);
//		return $uid;
	}
	
	public static function getUserByPhone($phone){
		$select = Da_Wrapper::select()
			->table(self::DB_TABLE_USER)
			->where('mobile', $phone);
		return $select->getRow();
	}
}
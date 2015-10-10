<?php

/**
 * Acl
 */
class Sp_Account_User extends Model_Abstract
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_USER = 'sp.huitong.ht_users';
	const COOKIE_NAME = '_huitong_user';   
	const COOKIE_USER_NAME = '_huitong_userid';
  	const FIELD_LOGIN   = 'username,email,mobile';			// 登录名字段
  	
  	const COOKIE_LIFE = 0;//	60*60*24*7;  //缓存时间
  	
  	// ERROR code
	const ERR_USERNAME_NOT_FOUND 	= -1;	// 没有这个用户
	const ERR_PASSWORD_INCORRECT 	= -2; 	// 密码不正确
	const ERR_ACCOUNT_DISABLED 		= -3; 	// 用户被禁止访问
	
	const _idle_time = 10800;				//3600 * 3;
	const _idle_time_wap = 604800;			//3600 * 24 * 7;
	
	/**
	 * constructor
	 *
	 * @param mixed $id
	 * @return void
	 */
	protected function __construct($id, $key = 'id'){
		
		$this->init($id, $key);
	}
	
	/**
	 * initFrom
	 *
	 * @param mixed $id
	 * @return void
	 */
	protected function init($id = 0, $key = 'id'){
		
		$field_login = explode(',', self::FIELD_LOGIN);
		if(is_array($id)) {
			$this->_unset('login');
			$this->_unset('name');
			$this->_set($id);
			foreach($field_login as $field) {
				if(isset($id[$field]) && $field != 'login') {
					$this->_set('login', $id[$field]);
					break;
				}
			}
            isset($id['name']) && $this->_set('realname', $id['name']);
		}elseif(is_int($id) || is_numeric($id) && $key == 'id') {
			$this->_set('id', intval($id));
			$id > 0 && $this->_set($this->_getRow($this->id, 'id'));
		}elseif(is_int($id) || is_numeric($id) && $key == 'userid') {   //用户ID登录
			$this->_set('login', intval($id));
			$id > 0 && $this->_set($this->_getRow($id, $key));
		}elseif(is_string($id) && !empty($id)) {	// default: key == 'login'
			if($key == 'login' || in_array($key, $field_login)) {
				$this->_set('login', $id);
				$this->_set($this->_getRow($id, $key));
			}
		}
	
	
		if($this->id < 1) {
			// not found
			$this->_unset('login');
			$this->_unset('name');
			if($_COOKIE[self::COOKIE_USER_NAME]) {
				$this->_set('mind_login', base64_decode($_COOKIE[self::COOKIE_USER_NAME]));
			}
		}
		$this->stateStored = false;
		$this->_key = $this->getKey();
	}

	/**
	 * return current singleton self
	 *
	 * @return object
	 */
	public static function current()
	{
		static $_current;
		if($_current === null) {
			$_current = self::retrieve();
			$_current->refresh();
		}
		return $_current;
	}
	
	/**
	 * function load
	 *
	 * @param mixed
	 * @return void
	 */
	public static function load($id, $type = 'id')
	{
		static $_objs = array();
		$key = 'k'.$type.$id;
		if(!isset($_objs[$key]))
		{
			$user = new self($id, $type);
			$_objs[$key] = &$user;
		}
		return $_objs[$key];
	}
	
	/**
	 * 获取用户信息
	 *
	 * @param int $userid 用户 id
	 * @param array $column 列
	 */
	public static function getUser($userid, $column = array()) {
		$ret = array(
			'id',
			'userid',
			'pwd',
			'kid',
			'mobile',
			'email',
			'status',
			'regtime',
			'regip',
			'logintime',
			'loginip',
			'login_nums'
		);
		$ret = array_merge($ret, $column);
		
		/*$select = Da_Wrapper::select()
			->table(self::DB_TABLE_USER)
			->columns($ret)
			->where('id', $userid);

		return $select->getRow();*/
		$cache = Cache::factory();
        $key = 'user_'.$userid;
        $cacheData = $cache->get($key);
        if(false == $cacheData){
            $select = Da_Wrapper::select()->table(self::DB_TABLE_USER)->where('id', $userid)->getRow();
            $cache->set($key,$select);
        }else{
            $select = $cacheData;
        }
        foreach($select as $key=>$value){
            if(false == in_array($key, $ret)){
                unset($select[$key]);
            }
        }
        return $select;
	}
	
	/**
	 * retrieve yy_account from request
	 *
	 * @return Sp_Account
	 */
	protected static function retrieve()
	{
	
		if(!isset($_COOKIE[self::COOKIE_NAME]) || empty($_COOKIE[self::COOKIE_NAME])) return self::guest();
		
		$encrypted_string = $_COOKIE[self::COOKIE_NAME];
		
		//去掉last hit
		$data = self::parseStored($encrypted_string);
        // 验证cookie
        $orig = self::getOrig($data['id'], $data['login']);
        
        // 3des加密
        $cry = new Util_Crypt3Des();
        $cookie = $cry->encrypt($orig);

        if($cookie != $encrypted_string){
            return self::guest();
        }
		$user = new self($data);
		$user->stateStored = true;
		return $user;
	}
	
	/**
	 * 已登录用户刷新状态
	 *
	 * @return void
	 */
	public function refresh()
	{
		if($this->isLogin()) {
			$now = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
			$last_hit = $this->lastHit;
			//判断是否为手机访问
			$request = Request::current();
			if($request->isMobile()) {
				$idle_time = self::_idle_time_wap;
			}else{
				$idle_time = self::_idle_time;
			}
			if($now > $last_hit + $idle_time) { // timeout
				//$this->stateStored = false;
				//self::setHttpCookie(self::guest());
				return false;
			}
			$sub_time = $now - $last_hit;
			if($sub_time > $idle_time / 2 && $sub_time < $idle_time) {
			
				//self::setHttpCookie($this);
			}
			return true;
		}
		return false;
	}
	
	/**
	 * 返回一个未认证的匿名用户对象
	 *
	 * @return Sp_Users_User
	 */
	protected static function guest()
	{
		static $_guest;
		if($_guest === null)
		{
			$_guest = new self(0);
		}
		return $_guest;
	}
	
	/**
	 * 从数据库取一行数据
	 *
	 * @return array
	 */
	protected function _getRow($id, $key = 'id'){
		
		$select = Da_Wrapper::select()
			->table(self::DB_TABLE_USER)
			->columns('id', $key, 'userid', 'pwd','kid', 'mobile', 'email', 'status','regtime', 'regip','logintime', 'loginip', 'login_nums')
			->where($key, $id);

		return $select->getRow();
	}
	
	/**
	 * 返回是否是有效的登录用户
	 *
	 * @return boolean
	 */
	public function valid()
	{
		if($this->id > 0) {
			$login = $this->login;
			if(!empty($login)) return TRUE;
		}
		return false;
	}

	/**
	 * 验证是否登录
	 *
	 * @param
	 * @return void
	 */
	public function isLogin(){
		$valid = $this->valid();
		$stateStored = $this->stateStored;
		return $valid && $stateStored;
	}
	
	/**
	 * 
	 * 密码加密

	 * 	 * @param string $text 
	 * @param string $key 对应的kid
	 * @return string
	 */
	static function encrypt($pwd, $key = null) {
	   return md5(md5($pwd).$key);
	}
	
	
	/**
	 *
	 * 检查登录回调页面
	 * 
	 * @param
	 * @return bool
	 */
	public function checkRedirect($login_url = '', $return_url = ''){
		if($this->isLogin()) return true;
		if(!$login_url) {
			$login_url = SP_URL_HOME.'user/login.html';
		}
		$return_url = $return_url?$return_url:urlencode($_SERVER['HTTP_REFERER']);
		Loader::redirect($login_url.'?returl='.$return_url);
		return false;
	}
	
	
	/**
     * 设置Cookie
     *
     * @param object $user
     * @return mixed
     */
    protected static function setHttpCookie($user,$nickname = null, $life = null){
        $_timenowstamp = time();
        if (is_object($user)) {
        	
            if (isset($_SERVER['HTTP_HOST'])) { // 只有在HTTP请求下才写Cookie
            	$user->stateStored = true;
				$username = (!is_null($nickname)) ? $nickname : $user->login;
                $orig = self::getOrig($user->id, $username);
				$_COOKIE_LIFE = self::COOKIE_LIFE > 0? $_timenowstamp+self::COOKIE_LIFE : 0;
				if($life > 0) {
					$_COOKIE_LIFE = $_timenowstamp + $life;
				}
                $cry = new Util_Crypt3Des();
                $cookie = $cry->encrypt($orig);
				setcookie(self::COOKIE_NAME, $cookie, $_COOKIE_LIFE, '/', Request::genCookieDomain());
            }
        }
        return $user;
    }
	
	/**
	 * 记住用户名 设置Cookie
	 *
	 * @param object $user
	 * @return mixed
	 */
	protected static function setUserNameCookie($user_name){
		$_timenowstamp = time();
		if(isset($_SERVER['HTTP_HOST'])) {	// 只有在HTTP请求下才写Cookie
			if($user_name) {
				$cookie = base64_encode($user_name);
				$_COOKIE_LIFE = $_timenowstamp + 3600*24*365;
			}else{
				$cookie = '';
				$_COOKIE_LIFE = 0;
			}
			setcookie(self::COOKIE_USER_NAME, $cookie, $_COOKIE_LIFE, '/', Request::genCookieDomain());
		}
		return $user_name;
	}
	
	/**
     * cookie原始串
     *
     * @param object $user
     * @return void
     */
    public static function getOrig($id, $login, $mobile = '', $email = '') {
        $return = $id;
        if ($login) {
            $return .= ',' . $login;
        }
        if ($mobile) {
            $return .= ',' . $mobile;
        }
        if ($email) {
            $return .= ',' . $email;
        }
        return $return;
    }
	
	/**
	 * 合并存储的值为一个关联数组
	 *
	 * @param string $str
	 * @param array $keys
	 * @param string $glue
	 * @return array
	 */
	public static function parseStored($str)
	{
		//解密3des
		$cry = new Util_Crypt3Des();
        $str = $cry->decrypt($str);
		
		$data = explode(',', $str);
        $user['id'] = $data[0];
        $user['login'] = $data[1];
		if(isset($data[2])){
		 	$user['mobile'] = $data[2];
		}
        if(isset($data[3])){
            $user['email'] = $data[3];
        }
		return $user;
	}

    /**
     * 退出（清除cookie）
     *
     * @return void
     */
    public  function signout(){
    
    	$this->_set('id',0);
		$this->clear();
        return setcookie(self::COOKIE_NAME, FALSE, time() + 315360000, '/', Request::genCookieDomain());
    }
	/**
	 * @param $username 账号
	 * @param $pwd      密码
	 */
	public static function RePwd($username,$pwd){
		$field_name = 'mobile';	
		if(preg_match($patternMobile, $username)) {
			$field_name = 'mobile';
		}elseif(preg_match($patternEmail, $username)){
			$field_name = 'email';
		}
		$row = array();
		$row['kid'] = time();
		$row['pwd'] = self::encrypt($pwd,$row['kid']);
		$ret = Da_Wrapper::update()->table(self::DB_TABLE_USER)->data($row)->where($field_name, $username)->execute();
		return $ret;
	}
}
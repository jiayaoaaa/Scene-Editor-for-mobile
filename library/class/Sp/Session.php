<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Sp_Session
 *
 * SP 长效会话处理器
 *
 * @package    Sp
 * @author     liut
 * @version    $Id$
 * @created    22:17 2009-07-14
 */


/**
 * Sp_Session
 * 
 */
class Sp_Session
{
	// const
	const COOKIE_TSID = '__tkid';
	const COOKIE_REFS = '_refs';
	const LIFTIME_TSID = 31536000;	// 3600 * 24 * 365 * 1

	// vars
	protected $_sid;
	protected $_ref;
	
	// vars
	private $_new = false;
	private $_ts = 0;

	/**
	 * constructor
	 * 
	 * @return void
	 */
	private function __construct()
	{
		$this->init();
	}

	protected function init() 
	{
		$sid = self::lastSid();
		if(empty($sid) || strlen($sid) < 16) {
			$this->_new = true;
			$this->_sid = self::storedSid();
		} else {
			$this->_sid = $sid;
		}
		$this->_ts = self::makeTimed($this->_sid);
	}

	/**
	 * return current singleton self
	 * 
	 * @return object
	 */
	public static function current()
	{
		static $_current;
		if($_current === null) $_current = new self();
		return $_current;
	}

	/**
	 * 从Cookie里取得sid或新建sid并设置cookie
	 * 
	 * @param
	 * @return void
	 */
	public static function storedSid()
	{
		$sid = self::lastSid();
		if(empty($sid) || strlen($sid) < 16) {
			$sid = self::genSid();
			if(self::isHttp()) {
				setcookie(self::COOKIE_TSID, $sid, time() + self::LIFTIME_TSID, '/',Request::genCookieDomain());
			}
		}
		//if(self::isHttp()) {
			//if(isset($_COOKIE['_tsid']) ) setcookie('_tsid', false, 0, '/',Request::genCookieDomain());	// delete old cookie, 记得一段时间后删除此块
			//if(isset($_COOKIE['tSID']) ) setcookie('tSID', false, 0, '/',Request::genCookieDomain());	// delete old cookie, 记得一段时间后删除此块
			//if(isset($_COOKIE['nuid']) ) setcookie('nuid', false, 0, '/',Request::genCookieDomain());	// delete old cookie, 记得一段时间后删除此块
			
		//}
		return $sid;
	}

	/**
	 * get LastSid
	 * 
	 * @return string
	 */
	public static function lastSid()
	{
		return isset($_COOKIE[self::COOKIE_TSID]) ? $_COOKIE[self::COOKIE_TSID] : null;;
	}
	
	/**
	 * 生成 session_id
	 * 
	 * @return string
	 */
	protected static function genSid()
	{
		return substr(str_replace('.', '', uniqid('',true)), 0, 16);;
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function __get($name)
	{
		if($name === 'id' || $name === 'sid') return $this->_sid;
		if($name === 'new' || $name === 'isNew') return $this->_new;
		if ($name === 'ts' ||  $name === 'timestamp') return $this->_ts;
		return null;
	}
	
	/**
	 * function description
	 * 
	 * @param string $sid;
	 * @return void
	 */
	public static function makeTimed($sid)
	{
		$t = hexdec(substr($sid, 0,8));
		return $t;
	}
	
	
	/**
	 * return stored referers
	 * 处理站外连接
	 * 原则：1. 把站外连接当成有意义有内容；2. 可以不记录链入的完整url，但一定要记录网站名（Host）
	 * 
	 * @param boolean
	 * @return mixed
	 */
	public static function storedReferers($return_array = true)
	{
		static $refs = null;
		if(is_null($refs)) {
			$refs = array(
			0 => '',	// referer site (host), or referer full uri
			1 => '',	// from: union code
			2 => '', // locate: sub union code
			3 => '' // strsend: extends info 
			);
			isset($_COOKIE[self::COOKIE_REFS]) && $refs = explode('~~', $_COOKIE[self::COOKIE_REFS]);
			//var_dump($refs);
			$need_set_cookie = false;
			if(isset($_GET["from"])) $r_1 = $_GET["from"];
			elseif (isset($_GET["unionfrom"])) $r_1 = $_GET["unionfrom"];
			else $r_1 = null;
			$need_set_cookie = !empty($r_1);
			
			if(!empty($r_1)) { // 有效的 from
				$refs[1] = $r_1;
				if(isset($_GET['tn']) && $refs[1] == 'baidu') $refs[2] = $_GET['tn'];
				else $refs[2] = isset($_GET['locate']) ? $_GET['locate'] : '';
				$refs[3] = isset($_GET['strsend']) ? $_GET['strsend'] : '';
			}
			if(isset($_SERVER["HTTP_REFERER"]) && 
				preg_match("#http://([a-z0-9\-\.]+?\.)?([a-z0-9\-]+)\.([a-z]{2,4})/([^\/]+)?#i", $_SERVER["HTTP_REFERER"], $matches)
				/*&& $matches[2] != 'togj'*/ ) {
				//var_dump($matches);
				if($matches[2] != 'togj') {
					$r_0 = $matches[1].$matches[2].'.'.$matches[3];	// $_SERVER["HTTP_REFERER"];
				}
				elseif($matches[2] == 'togj' && isset($matches[4]) && $matches[4] == 'feature') {
					$r_0 = $matches[2].'.'.$matches[3].'/'.$matches[4];
				}
				else {$r_0 = null;}
				if(!empty($r_0)) { // 是有效的主机才取 From
					$refs[0] = $r_0;
				}
			}
			elseif(isset($_GET['direct_from'])) {	// 为了手工输入URL而设置, 17:29 2009-08-05
				$refs[0] = '(local)';
				$refs[1] = $_GET['direct_from'];
				$refs[2] = '';
				$refs[3] = '';
				if (!$need_set_cookie && !empty($refs[1])) $need_set_cookie = true;
			}
			else {
				$refs[0] = '(empty)';	// 为了空referrer也可以记录
			}
			//var_dump($refs);
			//Sp_Log::debug('will set cookie '.($need_set_cookie?'yes':'no'));

			if($need_set_cookie && !empty($refs[0]) && !empty($refs[1]) && self::isHttp()) {
				setcookie(self::COOKIE_REFS, implode('~~', $refs), time() + 604800, '/',Request::genCookieDomain());
				//if(isset($_COOKIE['__refs']) ) setcookie('__refs', false, 0, '/',Request::genCookieDomain());	// delete old cookie, 记得一段时间后删除此块
			}
		}
		if($return_array) return $refs;
		return implode('~~', $refs);
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public static function getReferers()
	{
		isset($_COOKIE[self::COOKIE_REFS]) && $refs = explode('~~', $_COOKIE[self::COOKIE_REFS]);
		if(isset($refs)) return $refs;
		return array('','','','');
	}
	
	public static function isHttp()
	{
		return isset($_SERVER['HTTP_HOST']);
	}
	
	/**
	 * 设置是否使用Track
	 * 
	 * @param boolean $use_track
	 * @return void
	 */
	public static function setTrack($use_track = false)
	{
		if($use_track) {
			$session = Sp_Session::current();
			$tsid = $session->id;
			$_refs = Sp_Session::storedReferers();
		}
	}

	/**
	 * 临时测试
	 * 
	 * @return void
	 */
	public static function testGenSn()
	{
		$i = 0;
		do
		{
			$sid = self::genSid();
			echo $sid, "\t", time(), "\t", self::makeTimed($sid), PHP_EOL;
			$i ++;
		}
		while ($i < 100);
		
		return $i;
	}
	
}


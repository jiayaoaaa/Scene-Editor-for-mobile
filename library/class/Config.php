<?PHP
/** SVN $Id$ */

/**
 * Config
 * 配置管理类
 *
 * @package    Lib
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */


final class Config
{
	//配置数组
	static private $ini  = array();

	//禁止访问构造函数
	private function __construct() {}

	/**
	 * 更改配置信息 
	 *
	 * 字符串可以使用set('dsn.driver','Mysql')的形式来设置子选项
	 *
	 * @param string|array $key 键名 可以是数组或字符串
	 * @return
	 */
	public static function set($key, $value = null)
	{
		if(is_array($key) && is_null($value))
		{
			self::$ini = array_merge(self::$ini, $key);
		}
		else
		{
			$arr = explode(".", $key);
			//用引用方式建立关联数组
			$pt  = &self::$ini;
			while($arr)
			{
				if(!is_array($pt)) $pt = array();
				$key = array_shift($arr);
				$pt = &$pt[$key];
			}
			$pt = $value;
		}
	}

	/**
	 * 取得配置信息 
	 *
	 * 字符串可以使用get('dsn.driver')的形式来取得子选项，对于不存在的键，将返回null
	 * 
	 * @param string $key 配置变量的键值
	 * @param string $defulat 默认值
	 * @return mix 返回配置信息的值
	 */
	public static function get($key = null, $default = null)
	{
		if(is_null($key)) return self::$ini;
		if(isset(self::$ini[$key])) return self::$ini[$key];
		self::load($key);
		//用引用方式查找关联数组
		$arr = explode(".", $key);
		$pt  = &self::$ini;
		while($arr)
		{
			if(!is_array($pt)) {
				return $default;
			}
			$key = array_shift($arr);
			$pt = &$pt[$key];
		}
		if (null === $pt) {
			return $default;
		}
		return $pt;
	}

	//载入配置文件
	public static function load($config)
	{
		if(is_array($config)) {
			self::$ini = array_merge(self::$ini, $config);
		}else {
			$arr = explode('.', $config);
			$key = $arr[0];
			if(self::$ini[$key]) {
				return;
			}
			$ini = Loader::config($key);
			if(is_array($ini)) {
				self::$ini = array_merge(self::$ini, array($key=>$ini));
			}else{
				throw new Exception(sprintf("配置文件不存在 -> <span class='error'>%s</span>",$config));
			}
		}
	}

}
?>
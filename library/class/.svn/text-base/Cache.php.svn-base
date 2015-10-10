<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * 缓存操作类, 使用文件存储
 * 
 * @author      liut
 * @package     Core
 * @version     $Id$
 * @lastupdate $Date$
 */


/**
 * Cache
 *
 * 
 * 
 * Example: 
 * 	required: CONF_ROOT . cache.conf.php:
 *  
 * 	$cache = Cache::factory('section_name'); // section_name defined in config
 * 	$key = 'key1';
 * 	$data = 'abc';
 * 	$ret = $cache->set($key, $data, 60);	// set
 * 	$c_data = $cache->get($key);		// get
 */
abstract class Cache
{
	/** vars */
	protected $_inited 	= FALSE;
	/** vars */
	protected $_caching = TRUE;
	/** vars */
	protected $_lifeTime = 300; //默认的过期时间
	/** vars */
	protected $_group = '';
	
	/**
	 * constructor
	 * 
	 * @return object
	 */
	protected function __construct()
	{
	}
	
	
	/**
	 * 加载配置信息
	 * 
	 * @param string $section
	 * @return array
	 */
	public static function config($section)
	{
		static $_settings = null;
		if($_settings === null) $_settings = Loader::config('cache');
		if(!isset($_settings[$section])) {
			return null;
		}
		
		return $_settings[$section];
	}
	
	/**
	 * 工厂加载方法
	 * 
	 * @param string $section
	 * @return object
	 */
	public static function factory($section = 'default')
	{
		static $instances = array();
		if ($section === 'all_instances') {
			return $instances;
		}
		$config = self::config($section);
		if (is_string($config)) {
			$section = $config;
			$config = self::config($section);
		}
		if (is_null($config)) {
			throw new InvalidArgumentException('cache node ['. $section . '] not found', 101);
		}
		if(!isset($instances[$section]) || $instances[$section] === null) {
			if (isset($config['className'])) $class = $config['className'];
			else {
				$class = __CLASS__ . '_' . ucfirst($section);
			}
			$instances[$section] = new $class();
			if (isset($config['option'])) {
				$instances[$section]->init($config['option']);
			}						
		}
		return $instances[$section];
	}
	
    public function getLifeTime()
    {
        return $this->_lifeTime;
    }
	
	
	// for debug
	protected $_debug     = FALSE;
	protected $_logs      = NULL;
	protected function log($message)
	{
		if (!$this->_debug) return;
		if (is_null($this->_logs))
		{
			$this->_logs = array();
		}
		$this->_logs[] = $message;
	}
	
	public function getLogs()
	{
		return $this->_logs;
	}
	
	
	
}





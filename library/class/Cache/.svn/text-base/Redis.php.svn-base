<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
* 缓存操作类, 使用Redis
* 
* @package     Core
* @version     $Id$
* @lastupdate $Date$
*/


/**
 * Cache_Redis
 *
 * Config:
 * Name 				Default value
 * CACHE_REDIS_SERVERS 	127.0.0.1:6379
 * CACHE_REDIS_PERSISTENT FALSE
 * CACHE_REDIS_FLAG 		TRUE
 * CACHE_REDIS_GROUP 	default
 * CACHE_REDIS_DEBUG 	FALSE
 * 
 * 
 * Example: 
 * 	define('CACHE_REDIS_SERVERS', 'cache1:6379,cache2,cache3,cache4');
 * 	$cache = Cache_Redis::getInstance();
 * 	$key = 'key1';
 * 	$data = 'abc';
 * 	$ret = $cache->set($key, $data, 60);	// set
 * 	$c_data = $cache->get($key);		// get
 */
class Cache_Redis extends Cache implements ArrayAccess
{
	private static $_instances = array();
	protected $_redis  = FALSE;
	private $_mc_flag  = FALSE;
	//private $_group     = '';
	private $_connected = FALSE;
	//private $_debug     = FALSE;
	//private $_logs      = NULL;
	//protected $_inited 	= FALSE;
	
	//protected $_lifeTime = 300; //默认的过期时间
    protected $defaultFlag = 0; //默认标志
    
    protected $nsTimeout = array(); //名称空间过期时间
    protected $nsFlag = array(); //默认标志
	
	protected $_curr_key = null;

	/**
	 * Returns a singleton instance
	 *
	 * @return Cache_Redis
	 * @access public
	 */
	public static function &getInstance() 
	{
		if (!isset(self::$_instances[0]) || !self::$_instances[0]) {
			self::$_instances[0] = Cache::factory('redis');
		}
		return self::$_instances[0];
	}
	
	/**
	 * private construct
	 * 
	 * 
	 */
	protected function __construct()
	{
		$this->_group = defined('CACHE_REDIS_GROUP') ? preg_replace('/[^a-z0-9_:]+/i', '', CACHE_REDIS_GROUP) : '';
	}

	public function init($params = NULL)
	{
		//static $inited = FALSE;
		if ($this->_inited) return $this->_connected;
		$this->_inited = TRUE;
		
		if ( is_array($params) ) foreach($params as $key => $value) {
			$this->setOption($key, $value);
		}
		
		if(!class_exists('Redis', false)) {
			$this->log('class not exists: Redis');
			return FALSE;
		}

		defined('CACHE_REDIS_SERVERS') || define ('CACHE_REDIS_SERVERS', '127.0.0.1:6379' );
		$servers = explode(',', CACHE_REDIS_SERVERS);
		defined('CACHE_REDIS_FLAG') && $this->_mc_flag = CACHE_REDIS_FLAG;
		$this->_debug = defined('CACHE_REDIS_DEBUG') && CACHE_REDIS_DEBUG;
		$persistent = defined('CACHE_REDIS_PERSISTENT') && CACHE_REDIS_PERSISTENT;

		//if(!is_array($servers)) {
		//	$servers = array($servers);
		//}
		$this->_redis = new Redis();
		$this->_connected = FALSE;
		foreach($servers as $server) {
			$parts = explode(':', $server);
			$host = $parts[0];
			$port = isset($parts[1]) ? $parts[1] : 6379;
			if($this->_redis->connect($host, $port)) {
				$this->_connected = true;
				if($this->_debug)
				{
					$message = sprintf("addServer %s:%d OK!", $host, $port);
					$this->log($message);
				}
			}
		}
		return $this->_connected;
	}
	
	/**
	 * 设置选择
	 * 
	 * 
	 */
	public function setOption($name, $value) 
    {
		static $availableOptions = array('lifeTime', 'debug', 'group');
        if (in_array($name, $availableOptions)) {
            $_name = '_'.$name;
            $this->$_name = $value;
        }
    }

	public function __call($method, $arg_array) {
		$ret = FALSE;
		if ($this->init()) 
		{	
			$arg_num = count($arg_array);
			switch ($arg_num) {
				case 0:return call_user_func(array($this->_redis, $method));break;
				case 1:return call_user_func(array($this->_redis, $method),$arg_array[0]);break;
				case 2:return call_user_func(array($this->_redis, $method),$arg_array[0],$arg_array[1]);break;
				case 3:return call_user_func(array($this->_redis, $method),$arg_array[0],$arg_array[1],$arg_array[2]);break;
				case 4:return call_user_func(array($this->_redis, $method),$arg_array[0],$arg_array[1],$arg_array[2],$arg_array[3]);break;
				case 5:return call_user_func(array($this->_redis, $method),$arg_array[0],$arg_array[1],$arg_array[2],$arg_array[3],$arg_array[4]);break;
				default:$this->log("parameter number of $method is invalid ");return FALSE;
			}
		}
		return $ret;
	}

    //名称空间变量获取
    public function nsGet($ns, $key)
    {
        $key = $ns . $this->getNsKey($ns) . $key;
 
        return $this->get($key);
    }
 
    //名称空间变量设置
    public function nsSet($ns, $key, $value, $expire = null, $flag = null)
    {
        isset($expire) or $expire = $this->getNsTimeout($ns);
        isset($flag) or $flag = $this->getNsFlag($ns);
        
        $key = $ns . $this->getNsKey($ns) . $key;
 
        return $this->set($key, $value, $expire, $flag);
    }
    
    //名称空间删除
    public function nsDelete($ns, $key = null, $timeout = 0)
    {
        if (empty($key))
        {
            return $this->delete($ns, $timeout);
        }
        
        
        $key = $ns . $this->getNsKey($ns) . $key;
 
        return $this->delete($key, $timeout);
    }
    
    //生成一个公共key
    private function getNsKey($ns)
    {
        if (!$nsKey = $this->get($ns))
        {
			$nsKey = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
            $this->set($ns, $nsKey, 86400); // 24小时
        }
 
        return $nsKey;
    }
    
    //implements ArrayAccess
    function offsetExists($offset)
    {
        $tmp = $this->_parse($offset);
 
        if ($tmp['ns'])
        {
            return $this->nsGet($tmp['ns'], $tmp['key']) !== false;
        }
        else
        {
            return $this->get($tmp['key']) !== false;
        }
    }
    
    function offsetGet($offset)
    {
        $tmp = $this->_parse($offset);
 
        if ($tmp['ns'])
        {
            return $this->nsGet($tmp['ns'], $tmp['key']);
        }
        else
        {
            return $this->get($tmp['key']);
        }
    }
    
    function offsetSet($offset, $value)
    {
        $tmp = $this->_parse($offset);
        
        if ($tmp['ns'])
        {
            $this->nsSet($tmp['ns'], $tmp['key'], $value, $tmp['timeout'], $tmp['flag']);
        }
        else
        {
            $this->set($tmp['key'], $value, $tmp['timeout'], $tmp['flag']);
        }
    }
    
    function offsetUnset($offset)
    {
        $tmp = $this->_parse($offset);
 
        if ($tmp['ns'])
        {
            $this->nsDelete($tmp['ns'], $tmp['key'], $tmp['timeout']);
        }
        else
        {
            $this->delete($tmp['key'], $tmp['timeout']);
        }
    }
    
	/**
	 * 解析 Key，返回一個數組
	 * 包括：ns，key，timeout，flag
	 * 
	 * key的格式：(timeout 和 flag部分可以省略)
	 * 第一種： key:timeout:flag
	 * 第二種： ns::key:timeout:flag
	 * 
	 * @param string $key
	 * @return void
	 */
    private function _parse($offset)
    {
        $tmp = explode(':', $offset);
        $result = array('ns'=>null, 'key'=>null, 'timeout'=>null, 'flag'=>null);
		if (isset($tmp[1]) && $tmp[1] === '')	// ns::key
        {
            $result['ns'] = $tmp[0];
            $tmp = array_slice($tmp, 2);
        }
 
        $result['key'] = $tmp[0];
        $result['timeout'] = isset($tmp[1]) ? intval($tmp[1]) : null;
        $result['flag'] = isset($tmp[2]) ? ($tmp[2] ? 0 : 1) : null;
        
        return $result;
    }
  
    function getDefaultFlag()
    {
        return $this->defaultFlag;
    }
    
    function setNsTimeout($ns, $val)
    {
        $this->nsTimeout[$ns] = $val;
    }
    
    function getNsTimeout($namesapce)
    {
        return isset($this->nsTimeout[$namesapce]) ? $this->nsTimeout[$namesapce] : $this->_lifeTime;
    }
    
    function setNsFlag($ns, $val)
    {
        $val = empty($val) ? 0 : 1;
        $this->nsFlag[$ns] = $val;
    }
    
    function getNsFlag($ns)
    {
        return isset($this->nsFlag[$ns]) ? $this->nsFlag[$ns] : $this->defaultFlag;
    }

	public function getExtendedStats()
	{
		if ($this->init()) return $this->_redis->getExtendedStats();
		return FALSE;
	}
	

	// 暂时不支持
	public function clean()
	{
		return false;
	}

	/**
	 * 开始一个页面输出缓存
	 * 
	 * @param string $key
	 * @return void
     * @access public
	 */
	public function start($key)
	{
		$this->_curr_key = $key;
        $data = $this[$key];
        if ($data !== false) {
            echo($data);
            return true;
        }
        ob_start();
        ob_implicit_flush(false);
        return false;
	}

    /**
     * 结束并保存输出到缓存
     *
     * @access public
     */
    public function end($abort = false)
    {
        $data = ob_get_contents();
        ob_end_clean();
		$abort || $this[$this->_curr_key] = $data;
        echo($data);
    }
	
	/**
	 * Get statistics
	 * 
	 * @param string $type
	 * @param int $slabid
	 * @param int $limit
	 * @return array
     * @access public
	 */
	public function stats ( $type = null,  $slabid = null,  $limit = 100)
	{
		if ($this->init()) return $this->_redis->getExtendedStats($type, $slabid, $limit);
		return FALSE;
	}
	
	public function getGroup()
	{
		return $this->_group;
	}

	private function _strip($str)
	{
		return strtolower(preg_replace("#[\:\.]+#", '_', $str));
	}
	/**
	 * 使用左边关键词模糊删除
	 */
	public function leftDelete($name){
		$arr = $this->_redis->keys($name."*");
		foreach ($arr as $key => $value) {
			 $this->_redis->delete($value);
		}
	}
}


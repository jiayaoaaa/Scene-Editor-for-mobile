<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
* 缓存操作类, 使用Memcache
* 
* @author      liut
* @package     Core
* @version     $Id$
* @lastupdate $Date$
*/


/**
 * Cache_Memcache
 *
 * Config:
 * Name 				Default value
 * CACHE_MEMCACHE_SERVERS 	127.0.0.1:11211
 * CACHE_MEMCACHE_PERSISTENT FALSE
 * CACHE_MEMCACHE_FLAG 		TRUE
 * CACHE_MEMCACHE_GROUP 	default
 * CACHE_MEMCACHE_DEBUG 	FALSE
 * 
 * 
 * Example: 
 * 	define('CACHE_MEMCACHE_SERVERS', 'cache1:11211,cache2,cache3,cache4');
 * 	$cache = Cache_Memcache::getInstance();
 * 	$key = 'key1';
 * 	$data = 'abc';
 * 	$ret = $cache->set($key, $data, 60);	// set
 * 	$c_data = $cache->get($key);		// get
 */
class Cache_Memcache extends Cache implements ArrayAccess
{
	private static $_instances = array();
	protected $_memcache  = FALSE;
	private $_mc_flag  = FALSE;
	//private $_group     = '';
	private $_connected = FALSE;
	//private $_debug     = FALSE;
	//private $_logs      = NULL;
	//private $_inited 	= FALSE;
	
	//protected $_lifeTime = 300; //默认的过期时间
    protected $defaultFlag = 0; //默认标志
    
    protected $nsTimeout = array(); //名称空间过期时间
    protected $nsFlag = array(); //默认标志
	
	protected $_curr_key = null;

	/**
	 * Returns a singleton instance
	 *
	 * @return Cache_Memcache
	 * @access public
	 */
	public static function &getInstance() 
	{
		if (!isset(self::$_instances[0]) || !self::$_instances[0]) {
			self::$_instances[0] = Cache::factory('memcache');
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
		$this->_group = defined('CACHE_MEMCACHE_GROUP') ? preg_replace('/[^a-z0-9_:]+/i', '', CACHE_MEMCACHE_GROUP) : 'default';
	}

	public function init($params = NULL)
	{
		//static $inited = FALSE;
		if ($this->_inited) return $this->_connected;
		$this->_inited = TRUE;
		
		if ( is_array($params) ) foreach($params as $key => $value) {
			$this->setOption($key, $value);
		}
		
		if(!class_exists('Memcache', false)) {
			$this->log('class not exists: Memcache');
			return FALSE;
		}

		defined('CACHE_MEMCACHE_SERVERS') || define ('CACHE_MEMCACHE_SERVERS', '127.0.0.1:11211' );
		$servers = explode(',', CACHE_MEMCACHE_SERVERS);
		defined('CACHE_MEMCACHE_FLAG') && $this->_mc_flag = CACHE_MEMCACHE_FLAG;
		$this->_debug = defined('CACHE_MEMCACHE_DEBUG') && CACHE_MEMCACHE_DEBUG;
		$persistent = defined('CACHE_MEMCACHE_PERSISTENT') && CACHE_MEMCACHE_PERSISTENT;

		//if(!is_array($servers)) {
		//	$servers = array($servers);
		//}
		$this->_memcache = new Memcache();
		$this->_connected = FALSE;

		foreach($servers as $server) {
			$parts = explode(':', $server);
			$host = $parts[0];
			$port = isset($parts[1]) ? $parts[1] : 11211;

			if($this->_memcache->addServer($host, $port, $persistent)) {
				$this->_connected = true;
				if($this->_debug)
				{
					$message = sprintf("addServer %s:%d(%s) OK!", $host, $port, $persistent);
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
	
	
	/**
	 * 取
	 * 
	 * 
	 */
	public function get($key)
	{
		$ret = FALSE;
		if ($this->init()) 
		{
			$ret = $this->_memcache->get($this->_group.$key);
			if ($this->_debug)
			{
				$message = ($ret ? 'hit' : 'miss') . ' ' . $key;
				$this->log($message);
			}
		}
		return $ret;
	}
	
	/**
	 * 替换
	 * 
	 * @param
	 * @return void
	 */
	public function replace($key, $value, $expire = null, $flag = null)
	{
		if ($this->init()) {
			isset($expire) or $expire = $this->getLifeTime();
			isset($flag) or $flag = $this->getDefaultFlag();
			if( $this->_memcache->replace($this->_group.$key, $value, $flag, $expire) ) {
				return TRUE;
			}
			if ($this->_debug)
			{
				$message = 'memcache replace failed, key: ' . $key;
				$this->log($message);
			}
		}
		return FALSE;
	}
	
	/**
	 * 存
	 * 
	 * @param
	 * @return void
	 */
	public function set($key, $value, $expire = null, $flag = null)
	{
		if ($this->init()) {
			
			isset($expire) or $expire = $this->getLifeTime();
			isset($flag) or $flag = $this->getDefaultFlag();
			
			if ($this->_debug)
			{
				$message = 'set key: ' . $key . ' life: '. $expire;
				$this->log($message);
			}
			if( $this->_memcache->set($this->_group.$key, $value, $flag, $expire) ) {
				return TRUE;
			}
			if ($this->_debug)
			{
				$message = 'set failed, key: ' . $key;
				$this->log($message);
			}
		}
		return FALSE;
	}

	/**
	 * function description
	 * 
	 * @param string $key
	 * @return void
	 */
	public function delete($key, $expire = 0)
	{
		if ($this->init()) return $this->_memcache->delete($this->_group.$key, $expire);
		return FALSE;
	}
	
	/**
	 * delete 的别名
	 * 
	 * @param string $key
	 * @return void
	 */
	public function clear($key)
	{
		return $this->delete($key);
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
		if ($this->init()) return $this->_memcache->getExtendedStats();
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
		if ($this->init()) return $this->_memcache->getExtendedStats($type, $slabid, $limit);
		return FALSE;
	}
	
	public function getGroup()
	{
		return $this->_group;
	}
	
	/**
	 * 函数缓存
	 *
	 */
	public function call()
	{
		$args = func_get_args();
        $id = $this->_makeId($args);
        $data = $this->get($id);
		
        if ($data !== false) {
            if ($this->_debug) {
                $this->log("call hit !");
            }
            $output = $data['output'];
            $result = $data['result'];
        } else {
			if ($this->_debug) {
                $this->log("call missed !");
            }
			
			$target = array_shift($args);
			$result = call_user_func_array($target, $args);
			// TODO: output 未实现
			$data = array('output'=>'', 'result'=>$result);
			$this->set($id, $data);
		}
		//echo $output;
		return $result;
	}
	
	/**
	 * 删除函数缓存
	 *
	 */
	public function drop()
	{
        $id = $this->_makeId(func_get_args());
        return $this->delete($id);		
		
	}
	
	private function _makeId($args)
	{
		// TODO: 参数转 Id 需要更优化
		if (is_string($args[0])) {
			$prefix = 'call_' . $this->_strip($args[0]);
			
		} else {
			$prefix = 'call_obj';
		}
		if (count($args) > 1 && (is_string($args[1]) || is_numeric($args[1]) )) {
			$prefix .= '_' . $this->_strip($args[1]);
			if (count($args) === 2) return $prefix;
		}
		if (count($args) === 1) {
			return $prefix;
		}
		return $prefix . '_' . md5(serialize($args));
		
	}
	
	private function _strip($str)
	{
		return strtolower(preg_replace("#[\:\.]+#", '_', $str));
	}

}


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
 * Cache_Lute
 *
 *
 *
 * Example:
 *
 * 	$cache = Cache_Lute::getInstance();
 * 	$key = 'key1';
 * 	$data = 'abc';
 * 	$ret = $cache->set($key, $data, 60);	// set
 * 	$c_data = $cache->get($key);		// get
 */
class Cache_Lute extends Cache implements Cache_Interface //,ArrayAccess
{

	protected $_cacheDir = '/tmp/';
	protected $_fileSuffix = '.htm';
	private $_filename = NULL;
	/** 是否需要序列化 */
	private $_serialization = FALSE;
	/** id的正则 */
	private $_idPattern = NULL;
	/** id的替代操作 */
	private $_idReplace = NULL;

	protected $_curr_key = null;

	/** 是否忽略 */
    public $ignore = false;
	/**
	 * Returns a singleton instance
	 *
	 * @return object
	 * @access public
	 */
	/*public static function &getInstance()
	{
		if (!isset(self::$_instances[0]) || !self::$_instances[0]) {
			self::$_instances[0] = new self();
		}
		return self::$_instances[0];
	}*/

	/**
	 * constructor
	 *
	 * @return object
	 */
	protected function __construct()
	{
	}


	/**
	 * init
	 *
	 *
	 */
	public function init($params = NULL)
	{
		if ($this->_inited) return $this->_inited;
		$this->_inited = TRUE;

		if ( is_array($params) ) foreach($params as $key => $value) {
			$this->setOption($key, $value);
		}

	}

	/**
	 * 设置选择
	 *
	 *
	 */
	public function setOption($name, $value)
    {
		static $availableOptions = array('cacheDir', 'caching', 'lifeTime', 'debug', 'group', 'fileSuffix', 'serialization', 'idPattern', 'idReplace');
        if (in_array($name, $availableOptions)) {
            $_name = '_'.$name;
            $this->$_name = $value;
        }
    }

	/**
	 * get
	 *
	 *
	 */
	public function get($key)
	{
		$_file = $this->getFilename($key);
		$_refreshTime = time() - $this->_lifeTime;
		if ((file_exists($_file)) && (@filemtime($_file) > $_refreshTime)) {
			$this->log('hit '.$key);
			$data = file_get_contents($_file);
			if ($this->_serialization && is_string($data)) {
				return unserialize($data);
			}
			return $data;
		}
		$this->log('miss '.$key);
		return FALSE;
	}

	/**
	 * set
	 *
	 *
	 */
	public function set($key, $value, $expire = NULL)
	{
		isset($expire) or $expire = $this->getLifeTime();

		$root = $this->_cacheDir;
		if (!(is_dir($root))) {
			$this->log('create dir '.$root);
			mkdir($root, 0777);
		}

		$_file = $this->getFilename($key);
		$dir = dirname($_file);
		if (!(is_dir($dir))) {
			$this->log('create dir '.$dir);
			mkdir($dir, 0777, TRUE);
		}

		$this->log('set key: '.$key.' lifetime: '.$expire);

		if ($this->_serialization) {
			$value = serialize($value);
		}


		$ret = file_put_contents($_file, $value, LOCK_EX);
		@chmod($_file, 0666);
		return TRUE;
	}

	/**
	 * delete
	 *
	 *
	 */
	public function delete($key, $expire = NULL)
	{
		$_file = $this->getFilename($key);
        if(preg_match('/^[A-Z][A-Z0-9]\d{2,6}$/', $key, $matches)){
            foreach(glob(dirname($_file) . "/{$key}*.html") as $filename) {
                if (file_exists($filename)) {
        			unlink($filename);
        		}
            }
            return true;
        } else {
    		if (file_exists($_file)) {
    			return unlink($_file);
    		}
        }
		return FALSE;
	}

	/**
	 * clean
	 *
	 *
	 */
	public function clean()
	{
		// TODO: 清除缓存，待实现
	}

    public function getLifeTime()
    {
        return $this->_lifeTime;
    }

	/**
	 * 返回缓存的文件名
	 *
	 *
	 */
	public function getFilename($key)
	{
		$_path = rtrim($this->_cacheDir,'/') . '/';
		if (!empty($this->_group)) {
			$_path .= trim(preg_replace("/[^a-z0-9_\-\.\/]/", '', $this->_group), './') . '/';
		}
		$this->_filename = $_path . $this->_genId($key) . $this->_fileSuffix;
		return $this->_filename;
	}

	private function _genId($key)
	{
		static $filenames = array();
		if (!isset($filenames[$key])) {
			$filenames[$key] = $this->_refine($key);
		}
		return $filenames[$key];
	}

	private function _refine($key)
	{
		if ($this->_idPattern && preg_match($this->_idPattern, $key, $matches)) {

			if ($this->_idReplace) {
				if (is_callable($this->_idReplace)) {
					return call_user_func($this->_idReplace, $matches);
				} else {
					return preg_replace($this->_idPattern, $this->_idReplace, $key);
				}
			}
			array_shift($matches); // remove first [0]
			return implode('/', $matches);

		}
		return trim(preg_replace("/[^a-z0-9_\-\.\/]/", '', $key), './');

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
		if($this->ignore) return false;
		$this->_curr_key = $key;
        $data = $this->get($key);
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
    public function end()
    {
		if($this->ignore) return false;
        $data = ob_get_contents();
        ob_end_clean();
		$this->set($this->_curr_key, $data);
        echo($data);
    }

	/**
	 * 函数缓存
	 *
	 */
	public function call()
	{
		// TODO: 函数缓存处理
	}

	/**
	 * 删除函数缓存
	 *
	 */
	public function drop()
	{
		// TODO: 删除函数缓存
	}



}




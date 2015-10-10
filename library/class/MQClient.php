<?PHP
abstract class MQClient
{
	protected $_hosts = '127.0.0.1';
	protected $_port = '4370';
	protected $_connectTimeout = 5000;
	protected $_debug     = FALSE;
	protected $_logfile;
	protected $_log;

	protected function __construct()
	{
	}
		// for debug
	protected function log($message)
	{		
		$this->_log->log($message);
		
	}
	
	public function getLog()
	{
		if(!isset($this->_logfile)) return false;
		$file_name = $this->_logfile.date('Ym').'.log';
		if(!isset($this->_log)) $this->_log = &Log::singleton('file',$file_name);

		return $this->_log;
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
		if($_settings === null) $_settings = Loader::config('mq');
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
	public static function factory($myconfig = 'default')
	{
		$section = 'client_'.$myconfig;
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
			throw new InvalidArgumentException('mq client ['. $section . '] not found', 101);
		}
		if(!isset($instances[$section]) || $instances[$section] === null) {
			if (isset($config['className'])) $class = $config['className'];
			else {
				$class = __CLASS__ . '_' . ucfirst($section);
			}
			$instances[$section] = new $class($config['logfile']);
			$client_default = $config['default'];
			if ($client_default){
				$options = self::config($client_default);
				$instances[$section]->init($options['option']);
			} 
		}
		return $instances[$section];
	}
}


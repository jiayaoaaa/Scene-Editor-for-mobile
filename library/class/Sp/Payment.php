<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Payment_Abstract
 *
 * 支付类接口
 *
 * @package    Sp
 * @author     liut
 * @version    $Id$
 */



/**
 * Payment_Abstract
 *
 */
abstract class Sp_Payment #implements Sp_Payment_Interface
{

	// vars
	protected $_ini = array();
	protected $_code = '';
	protected $_n_codeame = '';
	
	protected $_logfile;
	protected $_log;
	
	/**
	 * constructor
	 * 
	 * @return object
	 */
	protected function __construct()
	{
		
	}
	
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
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public static function allConfig()
	{
		static $_settings = null;
		if($_settings === null) $_settings = Loader::config('pay');
		
		return $_settings;
	}
	
	/**
	 * 加载配置信息
	 * 
	 * @param string $section
	 * @return array
	 */
	public static function config($section)
	{
		$_settings = self::allConfig();
		if(!isset($_settings[$section])) {
			throw new Exception('payment node ['. $section . '] not found');
			//return null;
		}
		
		return $_settings[$section];
	}
	
	/**
	 * 工厂加载方法
	 * 
	 * @param string $section
	 * @return object
	 */
	public static function factory($section)
	{
		static $instances = array();
		if(!isset($instances[$section]) || $instances[$section] === null) {
			$option = self::config($section);
			if (isset($option['className'])) $class = $option['className'];
			else {
				$class = __CLASS__ . '_' . ucfirst($section);
			}
			if(isset($option['logfile'])){
				$instances[$section] = new $class($option['logfile']);	
			}else{
				$instances[$section] = new $class();	
			}
			
			$instances[$section]->_ini = $option;
			$instances[$section]->_code = $section;
			isset($option['name']) && $instances[$section]->_name = $option['name'];
		}
		return $instances[$section];
	}

	/**
	 * setOption
	 * 
	 * @param string $key
	 * @return void
	 */
	public function setOption($key, $value = null)
	{
		if (is_array($key)) {
			foreach($key as $k => $v) {
				$this->_ini[$k] = $v;
			}
		} elseif (is_string($key)) {
			$_key = '_'.$key;
			if (property_exists($this, $_key) && $key != 'ini') {
				$this->$_key = $value;
			}
			else {
				$this->_ini[$key] = $value;
			}
		}
		return $this;
	}

	/**
	 * getOption
	 * 
	 * @param string $key
	 * @return void
	 */
	public function getOption($key)
	{
		$_key = '_'.$key;
		if (property_exists($this, $_key)) {
			//echo 'exists ', $_key, "\n";
			return $this->$_key;
		}
        if (array_key_exists($key, $this->_ini)) {
            return $this->_ini[$key];
        }
		return null;
	}

	/**
	 * 准备支付，如准备页面、表单等信息
	 * 
	 * @param array $params
	 * @return void
	 */
	abstract public function prepare($params);

	/**
	 * 接收支付平台通知
	 * 
	 * @param array $params
	 * @return void
	 */
	abstract public function notify($params);

	/**
	 * 支付完成后返回处理
	 * 
	 * @param array $params
	 * @return void
	 */
	abstract public function complete($params);

}


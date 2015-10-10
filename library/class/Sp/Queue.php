<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Queue_Abstract
 *
 * 队列管理类接口
 *
 * @package    Sp
 * @author     liut
 * @version    $Id$
 */



/**
 * Queue_Abstract
 *
 */
abstract class Sp_Queue
{
	const CONFIG_NODE = 'queue'; // 配置文件名称
	const MAX_TIMING = 120;		// 最大时间间隔
	const MAX_RUNING = 28800;	//3600 * 24 * 2 = 172800; // 最多运行时间
	protected $_ini = array();
	protected $_code = '';
	/**
	 * constructor
	 *
	 * @return object
	 */
	protected function __construct()
	{
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
		if($_settings === null) $_settings = Loader::config(self::CONFIG_NODE);

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
			throw new Exception(self::CONFIG_NODE.' node ['. $section . '] not found');
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
			$instances[$section] = new $class();
			$instances[$section]->_ini = $option;
			$instances[$section]->_code = $section;
			isset($option['name']) && $instances[$section]->_name = $option['name'];
		}
		return $instances[$section];
	}

	/**
	 * function description
	 *
	 * @param string $section
	 * @return void
	 */
	public static function consoleRun($section)
	{
		$start_time = time();
		$queue = self::factory($section);
		if (!is_object($queue)) {
			echo $section . ' is not found', PHP_EOL;
			return;
		}

		$timing = 10;
		$i = 0;
		while (sleep($timing) !== FALSE) // 进行死循环，除非在外部杀掉
		{
			$ret_id = $queue->pop();
			if(!$ret_id) {
				if($timing < self::MAX_TIMING) $timing ++;
				echo ".";
				$i = 0;
				continue;
			}
			$timing = 1;
			echo PHP_EOL, $i . " got: \"", $ret_id, "\"  ";
			$ret = $queue->run($ret_id);
			if ($ret === false) echo 'run result: false';
			else echo $ret;
			if ((time() - $start_time) > self::MAX_RUNING ) exit();
			$i ++;
			Da_Wrapper::destroy(); // 清除数据库连接
		}
	}

    public static function consoleRunID($section, $ret_id)
	{
		$queue = self::factory($section);
		if (!is_object($queue)) {
			echo $section . ' is not found', PHP_EOL;
			return;
		}
		$ret = $queue->run($ret_id);
		if ($ret === false) echo 'run result: false';
		Da_Wrapper::destroy(); // 清除数据库连接
	}

    /**
	 * supplier queue
	 *
	 * @param string $section
	 * @return void
	 */
	public static function consoleRunForSupplier($section)
	{
		$start_time = time();
		$queue = self::factory($section);
		if (!is_object($queue)) {
			echo $section . ' is not found', PHP_EOL;
			return;
		}

		$timing = 1;
		$i = 0;
		while (sleep($timing) !== FALSE) // 进行死循环，除非在外部杀掉
		{
			$ret_id = $queue->pop();
			if(!$ret_id) break;
			$timing = 1;
			echo PHP_EOL, $i . " got: \"", $ret_id, "\"  ";
			$ret = $queue->run($ret_id);
			if ($ret === false) echo 'run result: false';
			else echo $ret;
			if ((time() - $start_time) > self::MAX_RUNING ) exit();
			$i ++;
			Da_Wrapper::destroy(); // 清除数据库连接
		}
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
	 * function description
	 *
	 * @return void
	 */
	abstract public function run($qid);

	/**
	 * 将唯一的目标放入队列
	 *
	 * @param string $qid (int or string)
	 * @return void
	 */
	public function push($qid)
	{
		$queue_service = $this->getQueueInstance();
		$queue_service->pput(SP_QS_HOST, SP_QS_PORT, "utf-8", $this->getQueueName(), $qid);
	}

	/**
 	* 从队列中吐出一个
 	*
 	* @return string
 	*/
	public function pop()
	{
		$queue_service = $this->getQueueInstance();
		$ret_id = $queue_service->get(SP_QS_HOST, SP_QS_PORT, "utf-8", $this->getQueueName());
		if(!$ret_id || $ret_id == 'HTTPSQS_GET_END') {
			return false;
		}
		return $ret_id;
	}

	/**
 	* function description
 	*
 	* @return object
 	*/
	public function getQueueInstance()
	{
		static $instance = null;
		if (is_null($instance)) $instance = new Util_HttpsqsClient;
		return $instance;
	}

	/**
	 * function description
	 *
	 * @return string
	 */
	public function getQueueName()
	{
		return 'queue_'.$this->_code;
	}

	/**
	 * function description
	 *
	 * @return string
	 */
	public function getStatus()
	{
		$queue_service = $this->getQueueInstance();

		return $queue_service->status(SP_QS_HOST, SP_QS_PORT, "utf-8", $this->getQueueName());
	}


}
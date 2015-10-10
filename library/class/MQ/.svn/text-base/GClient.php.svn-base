<?PHP
/** 
 * client 类 
 */  
class MQ_GClient extends MQClient{
    private $enabled = false;  
    private $client = null;  
	private static $_instances = array();

	/**
	 * Returns a singleton instance
	 *
	 * @access public
	 */
	public static function &getInstance($config)
	{
		if (!isset(self::$_instances[0]) || !self::$_instances[0]) {
			self::$_instances[0] = MQClient::factory($config);
		}
		return self::$_instances[0];
	}


    /** 
     * 创建client对象，添加job服务器 
     * @param  array    $config     job server config 
     * @param  int      $timeout    超时时间（毫秒） 
     * @return void 
     */  
    public function __construct($logfile)  
    {  
		$this->_logfile = $logfile;
    }  
	public function init($params = NULL)
	{
		if ($this->enabled) return $this->client;

		if ( is_array($params)) 
			foreach($params as $key => $value) {
				$this->setOption($key, $value);
		}		
		$this->client = new GearmanClient();
		if(isset($this->_hosts) && !empty($this->_hosts)) {
			$hosts = explode(',',$this->_hosts);
			//add job server  
			foreach ($hosts as $host) {
				$port = isset($this->_port)?$this->_port : 4730;
				if(!$this->check_conn($host, $port)){  
					continue;
				} else {
					$this->client->addServer($host,$port);  
					$this->enabled = True;  
				}  
			}
		}
        $this->enabled && $this->client->setTimeout($this->_connectTimeout);
	}
	
	/**
	 * 设置选择
	 * 
	 * 
	 */
	public function setOption($name, $value) 
    {
//		static $availableOptions = array('lifeTime', 'debug', 'group');
//        if (in_array($name, $availableOptions)) {
            $_name = '_'.$name;
            $this->$_name = $value;
//        }
    }

    /** 
     * 发送消息，并等待响应 
     * @param   string      任务名 
     * @param   string      该任务的数据 
     * @method string      是否是同步,true:同步，false:异步
     * @return  mixed       job server返回的结果 
     */  
    public function send($task_name, $task_data,$method=true)  
    {  
        if (!$this->enabled){
            $ret = false;     
        } else {
            if($method === true){
                $ret = $this->client->doNormal($task_name, json_encode($task_data));
            }else{
                $ret = $this->client->doBackground($task_name,json_encode($task_data));
            }
        }  
        return $ret;  
    }  
  

	/** 
     * 是否已添加有效jobs server 
     */  
    public function isEnabled(){  
        return $this->enabled;      
    }  

	/** 
	 * 网络检测 
	 * @param   string  机器IP 
	 * @param   string  机器port 
	 * @return  bool            
	 */  
	function check_conn($ip, $port = 4730)  
	{  
		// socket链接测试,200ms超时  
		@$fp = fsockopen($ip, $port, $errno, $errstr, 0.2);   
		if ($fp){         
			$fp && fclose($fp);  
			return true;
		} else {  
			return false;
		}  
	}  
	/**
	 * 添加异步处理消息集合
	 * @param   string      任务名 
     * @param   string      该任务的数据 
	 */
	public function addBackground($task_name, $task_data)  
    {  
        if (!$this->enabled){
            $ret = false;     
        } else {
          	$this->client->addTaskBackground($task_name, json_encode($task_data));
        }  
    }
	/**
	 * 运行消息集合
	 */
	public function runTask()  
    {  
        if (!$this->enabled){
            $ret = false;     
        } else {
          	$this->client->runTasks();
        }  
    }
	 
}  
  
  

?>
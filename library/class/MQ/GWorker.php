<?PHP
/** 
 * worker 类 
 */  
class MQ_GWorker extends MQWorker{  
    private $enabled = False;  
    private $worker = null;  
  	private static $_instances = array();
    private static $task = array(); //注册的任务信息  

  	/**
	 * Returns a singleton instance
	 *
	 * @return Cache_Memcache
	 * @access public
	 */
	public static function &getInstance($config)
	{
		if (!isset(self::$_instances[0]) || !self::$_instances[0]) {
			self::$_instances[0] = MQWorker::factory($config);
		}
		return self::$_instances[0];
	}

    /** 
     * 创建worker对象，添加job服务器 
     * @param  array    $config     job server config 
     * @return void 
     */  
    public function __construct($logfile)  
    {  $this->_logfile = $logfile;
    }  
	public function init($params = NULL)
	{
		if ($this->enabled) return $this->worker;
		
		if ( is_array($params)) 
			foreach($params as $key => $value) {
				$this->setOption($key, $value);
		}
		$this->worker = new GearmanWorker(); 
		$this->initWorker();
	}


	private function initWorker(){

		if(isset($this->_hosts) && !empty($this->_hosts)) {
			$hosts = explode(',',$this->_hosts);
			//add job server  
			foreach ($hosts as $host) {
				$port = isset($this->_port)?$this->_port : 4730;
				if(!$this->check_conn($host, $port)){  
					continue;
				} else {
					$this->worker->addOptions(GEARMAN_WORKER_NON_BLOCKING); 
					$this->worker->addServer($host,$port);  
					$this->enabled = True;  
				}  
			} 
		}
	}
    /** 
     * 注册任务及处理函数 
     * @param   string  $task_name  要注册的"任务" 
     * @param   string  $fun_name   对应的处理函数的函数名 
     * @return  boolean 
     */  
    public function regTask($task_name, $fun_name){  
        if (!$this->enabled){  
            $ret = false;  
        } else {  
            //Register and add callback function  
            $ret = $this->worker->addFunction($task_name, $fun_name);  
            if ($ret){  
                self::$task[$task_name] = $fun_name;      
            }  
        }  
        return $ret;  
    }  
  
    /** 
     * 运行worker 
     * @return  void/boolean 
     */  
    public function run(){  
        if (!$this->enabled){  
            return False;  
        }
		while(@$this->worker->work()||$this->worker->returnCode() == GEARMAN_IO_WAIT 
											||$this->worker->returnCode() == GEARMAN_NO_JOBS){
			if ($this->worker->returnCode() == GEARMAN_SUCCESS)
			continue;
			echo "Waiting for next job...\n";
			if (!@$this->worker->wait()) 
			  { 
				if ($this->worker->returnCode() == GEARMAN_NO_ACTIVE_FDS) 
				{ 
				  # We are not connected to any servers, so wait a bit before 
				  # trying to reconnect. 
				  sleep(10); 
				  continue; 
				} 
			}
		}
    }  
  
	public function setOption($name, $value) 
    {
//		static $availableOptions = array('lifeTime', 'debug', 'group');
//        if (in_array($name, $availableOptions)) {
            $_name = '_'.$name;
            $this->$_name = $value;
//        }
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
     * 重新注册之前的任务 
     */  
    private function reloadTask(){  
        $ret = False;  
        foreach ($this->task as $task_name => $fun_name){  
            $ret = $this->regTask($task_name, $fun_name);      
        }  
        return $ret;  
    }  
  
    /** 
     * 是否已添加有效jobs server 
     */  
    public function isEnabled(){  
        return $this->enabled;      
    }  
}     
?>
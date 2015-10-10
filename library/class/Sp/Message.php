<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Sp_Message
 *
 *
 *
 * @package	Sp
 * @author	 guoll
 * @version	$Id$
 */
/**
 * Sp_Message
 * 消息工厂
 *
 */
abstract class Sp_Message
{
	
	/**
	 * forbid construct
	 *
	 */
	protected function __construct()
	{

	}

	/**
	 * 加载设置项
	 *
	 * @param string $section
	 * @return array
	 */
	public static function setting($section)
	{
		static $_settings = null;
		if(!$_settings[$section]) {
			$mesConf = Sp_Message_Message::getMessageConfig();
			if(is_array($mesConf)) {
				foreach($mesConf as $value) {
					if($value['type'] == $section) {
						if($value['email']) {$_settings[$section]['email'] = 'email';}
						if($value['sms'])   {$_settings[$section]['sms'] = 'sms';}
						if($value['mess'])  {$_settings[$section]['mess'] = 'mess';}
						if($value['ischeckuser']) {$_settings[$section]['ischeckuser'] = '1';}
						break;
					}
				}
			}
		}
		return $_settings[$section];
	}

	/**
	 * 工厂加载方法加载子对象
	 *
	 * @param string $section
	 * @return mixed
	 */
	public static function factory($section)
	{
		static $instances = array();
		if(!isset($instances[$section]) || $instances[$section] === null) {
			$class = __CLASS__ . '_' . ucfirst($section);
			$instances[$section] = new $class();
		}
		return $instances[$section];
	}


	/**
	 * 发送函数(gearman's client)
	 *
	 * @param string $file
	 * @param string $name
	 * @param array $option empty
	 * @return string
	 */
	public static function add($section, $content) {
		extract($content, EXTR_SKIP);
		if($user_id) {
			$user_id = explode(' ', $user_id);
		}else{
			$user_id = array();
		}
		if($admin_id) {
			$admin_id = explode(' ', $admin_id);
		}else{
			$admin_id = array();
		}
		$MQClient = MQClient::factory('client_message');
		$MQlog = $MQClient->getLog(); 
		foreach($user_id as $user) {
			$types = self::setting($section);
			if(is_array($types)) {
				if($types['ischeckuser']) {
					self::filtUserSet($user_id, $section, $types);
				}
				if(is_array($types))
				foreach($types as $v) {
					$data = array('type'=>$v, 'user_id'=>$user, 'data'=>$content);
					$MQlog->log('会员消息发送 content = '.json_encode($data));
					$result = $MQClient->send("message_send", $data);
				}
			}
		}
		/*foreach($admin_id as $admin) {
			$types = self::setting($section, '', $admin);
			if(is_array($types)) {
				foreach($types as $v) {
					$data = array('type'=>$v, 'admin_id'=>$admin, 'data'=>$content);
					$MQlog->log('管理后台消息发送 content = '.json_encode($data));
					$result = $MQClient->send("message_send", $data);
				}
			}
		}*/
	}

	/**
	 * 发送函数(gearman's work)
	 *
	 * @param string $file
	 * @param string $name
	 * @param array $option empty
	 * @return string
	 */
	public static function send($section, $content) {
		extract($content, EXTR_SKIP);
		//$admin_id += 0;
		$user_id += 0;
		$types = self::setting($section);
		if($user_id AND is_array($types)) {
			if($types['ischeckuser']) {
				self::filtUserSet($user_id, $section, $types);
			}
			if(is_array($types))
			foreach($types as $v) {
				$sto = self::factory($v);
				$sto->dispatch($user_id, $section, $content);
			}
		}
	}

	static function filtUserSet($user_id, $section, &$types) {
		$user_set = Sp_Message_Message::getMessageSet($user_id, $section);
		if($user_set) {
			$user_set = current($user_set);
		}else{
			//加载默认设置
			$user_set = Loader::config('message');
			$user_set = $user_set[$section]['channel'];
		}
		if($user_set['email']==0 OR $user_set['email']['default']==0){unset($types['email']);}
		if($user_set['sms']==0 OR $user_set['sms']['default']==0)  {unset($types['sms']);}
		if($user_set['mess']==0 OR $user_set['mess']['default']==0)  {unset($types['mess']);}
		unset($types['ischeckuser']);
	}

	/**
	 * 发送函数(gearman's worker)
	 */
	abstract public static function dispatch($user_id, $class, $data);

	/**
	 * 取模板(gearman's worker)
	 */
	abstract public static function getTpl($class);
	
}
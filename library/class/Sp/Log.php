<?php
/**
 * 日志处理
 *
 * @author 
 * @version $Id$
 * @created 13:30 2009-04-21
 */


/**
 * 通过使用Pear的Log包处理日志
 *
 */
class Sp_Log
{
	const L_EMERG = 	0;     /* System is unusable */
	const L_ALERT = 	1;     /* Immediate action required */
	const L_CRIT = 	 	2;     /* Critical conditions */
	const L_ERR = 	 	3;     /* Error conditions */
	const L_WARNING = 	4;     /* Warning conditions */
	const L_NOTICE = 	5;     /* Normal but significant */
	const L_INFO = 	 	6;     /* Informational */
	const L_DEBUG = 	7;     /* Debug-level messages */

	/* Log types for PHP's native error_log() function. */
	const TYPE_SYSTEM = 0; /* Use PHP's system logger */
	const TYPE_MAIL = 	1; /* Use PHP's mail() function */
	const TYPE_DEBUG = 	2; /* Use PHP's debugging connection */
	const TYPE_FILE = 	3; /* Append to a file */

	static $_logs = array();
	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function log($message, $priority,$path='')
	{
		$log_level = defined('LOG_LEVEL') ? LOG_LEVEL : self::L_ERR;

		if($priority > $log_level) return false;

		if(defined('_PS_DEBUG') && TRUE === _PS_DEBUG && PHP_SAPI !== 'cli') {
			self::$_logs[] = $priority . ' ' . var_export($message, true);
		}

		$now = time();

		static $logger = null;
		if($logger === null) {
			static $conf = null;
			if($conf === null) {
				$log_root = defined('LOG_ROOT') ? LOG_ROOT : '/tmp/';
                $log_root = $path ? $log_root.$path.'/': $log_root;
				$conf = array(
					'lineFormat' => '%1$s %2$s: [%3$s] %4$s',
					'destination' => $log_root .'sp_'.PHP_SAPI.'_'.date('oW', $now).'.log'
				);
			}
			$name = defined('LOG_NAME') ? LOG_NAME : 'SP';
			$logger = &Log::factory('error_log', self::TYPE_FILE, $name, $conf);
		}
		if(is_object($logger)) {
			$logger->setMask(Log::MAX(LOG_LEVEL));
			if(!is_string($message)) {
				$message = var_export($message, true);
			}
			$message .= "\n";
			return $logger->log($message, $priority);
		}
		return false;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function err($message,$path='')
	{
		return self::log($message, self::L_ERR,$path);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function warning($message,$path='')
	{
		return self::log($message, self::L_WARNING,$path);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function notice($message,$path='')
	{
		return self::log($message, self::L_NOTICE,$path);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function info($message,$path='')
	{
		return self::log($message, self::L_INFO,$path);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function debug($message,$path='')
	{
		return self::log($message, self::L_DEBUG,$path);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function getLogs()
	{
		return self::$_logs;
	}

}
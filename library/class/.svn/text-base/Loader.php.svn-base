<?PHP
/**
 * 框架装载器
 * 用来初始化和封装基本操作
 *
 * @package    Lib
 * @author     liut
 * @copyright  2007 liut
 * @version    $Id$
 */

/** 简短的目录分隔符 */
define( 'DS', DIRECTORY_SEPARATOR );


// 初始化加载环境
Loader::init();

/**
 * Loader
 *
 * 装载器
 */
abstract class Loader
{
	
	/**
	 * 对象注册表
	 *
	 * @var array
	 */
	private static $OBJECTS = array();

	/**
	 * 类搜索路径
	 *
	 * @var array
	 */
	private static $CLASS_PATH = array();

	/**
	 * 导入文件搜索路径
	 *
	 * 在使用 loadClass() 时，会通过 import() 指定的搜索路径查找类定义文件。
	 *
	 * 当 loadClass('Service_Products') 时，由于类名称映射出来的类定义文件已经包含了目录名
	 * （Service_Products 映射为 Service/Products.php）。
	 * 所以只能将 Service 子目录所在目录添加到搜索路径，而不是直接将 Service 目录添加到搜索路径。
	 *
	 * example:
	 * <code>
	 * // 假设要载入的文件完整路径为 /www/app/Service/Products.php
	 * Loader::import('/www/app');
	 * Loader::loadClass('Service_Products');
	 * </code>
	 *
	 * @param string $dir
	 */
	public static function import($dir)
	{
		if (!in_array($dir, self::$CLASS_PATH)) {
			array_unshift(self::$CLASS_PATH, $dir);
		}
	}

	/**
	 * 载入指定类的定义文件，如果载入失败抛出异常
	 *
	 * example:
	 * <code>
	 * Loader::loadClass('Db_TableDataGateway');
	 * </code>
	 *
	 * 在查找类定义文件时，类名称中的“_”会被替换为目录分隔符，
	 * 从而确定类名称和类定义文件的映射关系（例如： Db_Driver 的定义文件为
	 * Db/Driver.php）。
	 *
	 * loadClass() 会首先尝试从开发者指定的搜索路径中查找类的定义文件。
	 * 搜索路径可以用 Container::import() 添加，或者通过 $dirs 参数提供。
	 *
	 * 如果没有指定 $dirs 参数和搜索路径，那么 loadClass() 会通过 PHP 的
	 * include_path 设置来查找文件。
	 *
	 * @param string $className 要载入的类名字
	 * @param string|array $dirs 可选的搜索路径
	 */
	public static function loadClass($className, $dirs = null)
	{
		if (class_exists($className, false) || interface_exists($className, false)) {
			return $className;
		}

		if (null === $dirs) {
			$dirs = self::$CLASS_PATH;
		} else {
			if (!is_array($dirs)) {
				$dirs = explode(PATH_SEPARATOR, $dirs);
			}
			$dirs = array_merge($dirs, self::$CLASS_PATH);
		}

		$filename = str_replace('_', DIRECTORY_SEPARATOR, $className);
		if ($filename != $className) {
			$dirname = dirname($filename);
			foreach ($dirs as $offset => $dir) {
				if ($dir == '.') {
					$dirs[$offset] = $dirname;
				} else {
					$dir = rtrim($dir, '\\/');
					$dirs[$offset] = $dir . DIRECTORY_SEPARATOR . $dirname;
				}
			}
			$filename = basename($filename) . '.php';
		} else {
			$filename .= '.php';
		}
		self::loadFile($filename, true, $dirs);

		if ( !(class_exists($className, false) || interface_exists($className, false)) ) {
			//throw new Exception(sprintf("Class %s Not Found: %s", $className, $filename));	// 是否抛出异常有争议
			return false;
		}
		return $className;
	}

	/**
	 * 载入指定的文件
	 *
	 * $filename 参数必须是一个包含扩展名的完整文件名。
	 * loadFile() 会首先从 $dirs 参数指定的路径中查找文件，
	 * 找不到时再从 PHP 的 include_path 搜索路径中查找文件。
	 *
	 * $once 参数指示同一个文件是否只载入一次。
	 *
	 * example:
	 * <code>
	 * Container::loadFile('Table/Products.php');
	 * </code>
	 *
	 * @param string $filename 要载入的文件名
	 * @param boolean $once 同一个文件是否只载入一次
	 * @param array $dirs 搜索目录
	 *
	 * @return mixed
	 */
	public static function loadFile($filename, $once = false, $dirs = null)
	{
		if (preg_match('/[^a-z0-9\-_.]/i', $filename)) {
			throw new Exception(sprintf('Security check: Illegal character in filename: %s.', $filename));
		}

		if (is_null($dirs)) {
			$dirs = self::$CLASS_PATH;
		} elseif (is_string($dirs)) {
			$dirs = explode(PATH_SEPARATOR, $dirs);
		}

		foreach ($dirs as $dir) {
			$path = rtrim($dir, '\\/') . DIRECTORY_SEPARATOR . $filename;
			if (is_file($path) || self::isReadable($path)) {
				return $once ? include_once $path : include $path;
			}
		}

		// include 会在 include_path 中寻找文件
		if (self::isReadable($filename)) {
			return $once ? include_once $filename : include $filename;
		}
	}

	/**
	 * 检查指定文件是否可读
	 *
	 * 这个方法会在 PHP 的搜索路径中查找文件。
	 *
	 * 该方法来自 Zend Framework 中的 Zend_Loader::isReadable()。
	 *
	 * @param string $filename
	 *
	 * @return boolean
	 */
	public static function isReadable($filename)
	{
        if (!$fh = @fopen($filename, 'r', true)) {
            return false;
        }
        @fclose($fh);
        return true;
	}

	/**
	 * 返回指定对象的唯一实例，如果指定类无法载入或不存在，则抛出异常
	 *
	 * example:
	 * <code>
	 * $service = Container::getSingleton('Service_Products');
	 * </code>
	 *
	 * @param string $classname 要获取的对象的类名字
	 *
	 * @return object
	 */
	public static function getSingleton($classname)
	{
		if (isset(self::$OBJECTS[$classname])) {
			return self::registry($classname);
		}
		self::loadClass($classname);
		return self::register(new $classname(), $classname);
	}

	/**
	 * 以特定名字注册一个对象，以便稍后用 registry() 方法取回该对象。
	 * 如果指定名字已经被使用，则抛出异常
	 *
	 * example:
	 * <code>
	 * // 注册一个对象
	 * Container::register(new MyObject(), 'my_obejct');
	 * .....
	 * // 稍后取出对象
	 * $obj = Qee::registry('my_object');
	 * </code>
	 *
	 * Container 提供一个对象注册表，开发者可以将一个对象以特定名称注册到其中。
	 *
	 * 当没有提供 $name 参数时，则以对象的类名称作为注册名。
	 *
	 * 当 $persistent 参数为 true 时，对象将被放入持久存储区。在下一次执行脚本时，
	 * 可以通过 Container::registry() 取出放入持久存储区的对象，无需重新构造对象。
	 * 利用这个特性，开发者可以将一些需要大量构造时间的对象放入持久存储区，
	 * 从而避免每一次执行脚本都去做对象构造操作。
	 *
	 * 使用哪一种持久化存储区来保存对象，由应用程序设置 objectPersistentProvier 决定。
	 * 该设置指定一个提供持久化服务的对象名。
	 *
	 * example:
	 * <code>
	 * if (!Container::isRegister('ApplicationObject')) {
	 * 		Container::loadClass('Application');
	 * 		Container::register(new Application(), 'ApplicationObject', true);
	 * }
	 * $app = Container::registry('ApplicationObject');
	 * </code>
	 *
	 * @param object $obj 要注册的对象
	 * @param string $name 注册的名字
	 * @param boolean $persistent 是否将对象放入持久化存储区
	 */
	public static function register($obj, $name = null, $persistent = false)
	{
		if (is_null($name)) {
			$name = get_class($obj);
		}
		if (!isset(self::$OBJECTS[$name])) {
			self::$OBJECTS[$name] = $obj;
			return self::$OBJECTS[$name];
		}

		throw new Exception('Duplicate entry "Container::register('.$name.')" for key "'.$name.'"');
	}

	/**
	 * 取得指定名字的对象实例，如果指定名字的对象不存在则抛出异常
	 *
	 * 使用示例参考 Container::register()。
	 *
	 * @param string $name 注册名
	 *
	 * @return object
	 */
	public static function registry($name)
	{
		if (isset(self::$OBJECTS[$name])) {
			return self::$OBJECTS[$name];
		}

		throw new Exception('Non-existent entry "registry('.$name.')" for key "'.$name.'"');
	}

	/**
	 * 检查指定名字的对象是否已经注册
	 *
	 * 使用示例参考 Container::register()。
	 *
	 * @param string $name 注册名
	 *
	 * @return boolean
	 */
	public static function isRegistered($name)
	{
		return isset(self::$OBJECTS[$name]);
	}


	/**
	 * 准备运行环境
	 */
	public static function init()
	{
		static $_inited = false;
		// 避免重复调用 self::init()
		if ($_inited) { return true;}
		$_inited = true;

		// 将此文件所在位置加入搜索路径
		self::import(dirname(__FILE__));

		/**
		 * 自动加载对象
		 */
		spl_autoload_register(array('Loader', 'loadClass'));
		/**
		 * 设置异常处理例程
		 */
		set_exception_handler(array('Loader', 'printException'));
		
		return true;
	}

	/**
	 * 打印异常的详细信息
	 *
	 * @param Exception $ex
	 * @param boolean $return 为 true 时返回输出信息，而不是直接显示
	 */
	public static function printException(Exception $ex, $return = false)
	{
		$out = "exception '" . get_class($ex) . "'";
		if ($ex->getMessage() != '') {
			$out .= " with message '" . $ex->getMessage() . "'";
		}
		if (defined('DEPLOY_MODE') && DEPLOY_MODE != false) {
			$out .= ' in ' . basename($ex->getFile()) . ':' . $ex->getLine() . "\n\n";
		} else {
			$out .= ' in ' . $ex->getFile() . ':' . $ex->getLine() . "\n\n";
			$out .= $ex->getTraceAsString();
		}

		if ($return) { return $out; }

		if (ini_get('html_errors')) {
			echo nl2br(htmlspecialchars($out));
		} else {
			echo $out;
		}

		return '';
	}
	
	/**
	 * 打印错误的详细信息
	 * 
	 * @param int $errno
	 * @param string $errstr
	 * @return void
	 */
	public static function printError($errno, $errstr, $errfile = null, $errline = null)
	{
		echo "error: $errno, $errstr \n\n";
		print_r(get_included_files());
		echo "\n";
		debug_print_backtrace();
	}
	
	
	/**
	 * 重定向浏览器到指定的 URL
	 *
	 * @param string $url 要重定向的 url
	 * @param int $delay 等待多少秒以后跳转
	 * @param bool $js 指示是否返回用于跳转的 JavaScript 代码
	 * @param bool $jsWrapped 指示返回 JavaScript 代码时是否使用 <script> 标签进行包装
	 * @param bool $return 指示是否返回生成的 JavaScript 代码
	 */
	public static function redirect($url, $delay = 0, $js = false, $jsWrapped = true, $return = false)
	{
		$delay = (int)$delay;
		if (!$js) {
			if (headers_sent() || $delay > 0) {
				echo <<<EOT
<html>
	<head>
	<meta http-equiv="refresh" content="{$delay};URL={$url}" />
	</head>
</html>
EOT;
				exit;
			} else {
				header("Location: {$url}");
				exit;
			}
		}

		$out = '';
		if ($jsWrapped) {
			$out .= '<script language="JavaScript" type="text/javascript">';
		}
		if ($delay > 0) {
			$out .= "window.setTimeout(function () { document.location='{$url}'; }, {$delay});";
		} else {
			$out .= "document.location='{$url}';";
		}
		if ($jsWrapped) {
			$out .= '</script>';
		}

		if ($return) {
			return $out;
		}

		echo $out;
		exit;
	}

	/**
	 * 输出错误信息并中止
	 * 
	 * @param string $msg
	 * @param int $code
	 * @param boolean $end
	 * @return void
	 */
	public static function response($code = 404, $msg = '', $end = true)
	{
		if($code == 404) {
			header("HTTP/1.0 404 Not Found", true, 404);
			header("Status: 404 Not Found");
			//if(empty($msg)) echo 'Not Found', PHP_EOL;
		} elseif($code == 403) {
			header("HTTP/1.0 403 Forbidden", true, 403);
			header("Status: 403 Forbidden");
			//if(empty($msg)) echo 'Forbidden', PHP_EOL;
		} else {
			header("HTTP/1.0 400 Bad Request");
			header("Status: 400 Bad Request");
		}
		if (!empty($msg)) echo $msg;
		if($end) exit();
	}
	//old
	public static function outputEnd($msg, $code = 404, $end = true)
	{
		self::response($code, $msg, $end);
	}

	/**
	 * 加载配置
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public static function & config($name, $inject = null)
	{
		// TODO: support ini and yaml
		static $settings = array();
		
		if(!isset($settings[$name]) || $settings[$name] == null) {
			$file = $name .'.conf.php';
			$dir = defined('CONF_ROOT') ? rtrim(CONF_ROOT, "\\/") . DIRECTORY_SEPARATOR : NULL;
			$settings[$name] = self::loadFile($file, FALSE, $dir);
			if (is_null($settings[$name])) {
				is_null($dir) && $dir = 'config/';
				$file = $dir . $name . '.ini';
				if (is_file($file)) {
					$settings[$name] = parse_ini_file($file, TRUE);
				}
				if (is_null($settings[$name]) || $settings[$name] === FALSE) {
					$file = $dir . $name . '.yml';
					if (is_file($file) && function_exists('yaml_parse_file') ) {
						$settings[$name] = yaml_parse_file($file);
					}
				}
			}
			if (is_null($settings[$name]) && is_null($inject)) {
				throw new InvalidArgumentException('config file '.$name.'.* not found');
			}
			if (is_array($inject)) { // TODO: here or move out of here, that's question
				$settings[$name] = array_merge($settings[$name], $inject);
			}
		}
		return $settings[$name];
	}

	/**
	 * 设置 Http 无缓存输出
	 * 
	 * @return void
	 */
	public static function nocache()
	{
		if (!headers_sent()) {
			header('Expires: Fri, 02 Oct 98 20:00:00 GMT');
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}
	}
	
}







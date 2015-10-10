<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

// $Id$

/**
 * 用web 404的方式即时生成缺少的文件，仅适用于图片缩略图
 *
 *
 */



include_once 'init.php';

$request_uri = $_SERVER['REQUEST_URI'];
$thr = ImageHandler::make($request_uri);
$thr->display();
//if(defined('_PS_DEBUG') && _PS_DEBUG === TRUE) file_put_contents('thumb_404.log', $thr->debug_out(true));

class ImageHandler
{
	const CACHE_IMAGE_ROOT = '/sproot/web/upload/pdf/';

	private $_uri;
	private $_image_id;
	private $_src_file; // 原图
	private $_real_uri;
	private $_real_file;
	private $_imagick;
	private $_ext;
	private $_section;

	/**
	 * function description
	 *
	 * @param string
	 * @return self
	 */
	public static function make($request_uri)
	{
		static $_obj = null;
		$_obj === null && $_obj = new self($request_uri);
		return $_obj;
	}

	/**
	 * constructor
	 *
	 * @param string $request_uri
	 * @return self
	 */
	protected function __construct($request_uri)
	{
		//$path_parts = pathinfo($request_uri);
		$this->_uri = parse_url($request_uri, PHP_URL_PATH);//$path_parts['dirname'] . '/' . $path_parts['basename'];

		$this->_real_uri = $this->_uri;
		$this->_real_file = self::CACHE_IMAGE_ROOT.substr($this->_real_uri, 1);
	}

	/**
	 * display current thumb image
	 *
	 * @return void
	 */
	public function display()
	{

		list($web_server) = explode('/', $_SERVER['SERVER_SOFTWARE'], 2);
		$mimetype = 'pdf';
		
		header( "Content-Type: $mimetype");
		header('Content-Length: ' . filesize($this->_real_file));
		if('LightTPD' == $web_server && 'WINNT' != PHP_OS) {
			header( "X-LIGHTTPD-send-file: " . $this->_real_uri);
		} elseif($web_server == 'nginx' && 'WINNT' != PHP_OS) {
			header("X-Accel-Redirect: " . $this->_real_uri);
		} else {
			readfile($this->_real_file);
			print_r(error_get_last());// return false;
			exit();
		}
	}

	/**
	 * function description
	 *
	 * @param string $section
	 * @return string
	 */
	private function getDocumentRoot($section)
	{
		$this->debug_log($section);
		if(isset($this->__paths[$section])) return $this->__paths[$section];
		if(isset($this->__paths['default'])) return $this->__paths['default'].'/'.$section;
		return './'.$section;
	}

	static $gs_logs = array();
	/**
	 * function description
	 *
	 * @param mixed $val
	 * @return void
	 */
	protected function debug_log($val)
	{
		self::$gs_logs[] = $val;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public function debug_out($return = false)
	{
		return print_r(self::$gs_logs, $return);
	}

	/**
	 * 建立目录树, 此方法作废, PHP 5.0 以上版已支持递归
	 * /p/a/t/h/n
	 *
	 * @param string $dir
	 * @param int $mode
	 * @return boolean
	 *
	 */
	public static function mkdir_r($dir, $mode = 0755)
	{
		return is_dir($dir) || ( self::mkdir_r(dirname($dir), $mode) && @mkdir($dir, $mode) );
	}



	private function fillPath($img_id)
	{
		$hashcode = md5 ($img_id);
		$dir_part1 = substr ($hashcode, 0, 2);
		$dir_part2 = substr ($hashcode, 2, 2);
		return '/'.$dir_part1.'/'.$dir_part2.'/'.$img_id;
	}
}


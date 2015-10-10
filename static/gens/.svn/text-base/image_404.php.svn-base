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
	const CACHE_IMAGE_ROOT = '/sproot/web/cache/images/';

	const MAX_QUALITY = 92;

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
        if(preg_match("#^/(\d+)(-[sc]\d+c?)?\.(gif|jpg|jpeg|png)$#", $this->_uri, $match) ) {
			header("Location: ".$this->fillPath($match[1]).$match[2].".".$match[3]);
			exit;
		}
        is_dir(self::CACHE_IMAGE_ROOT) || mkdir(self::CACHE_IMAGE_ROOT, 0755);
		$root_path = self::CACHE_IMAGE_ROOT;

        //匹配新的图片地址模式
        preg_match ('%/([a-z0-9]{2})/([a-z0-9]{2})/([a-z0-9]{2})/([a-f0-9]{16,36}|\d+)(-[sc]\d+c?)?\.(gif|jpg|jpeg|png)$%', $this->_uri, $match);
		if (!$match) {
			Loader::outputEnd("invalid url or Don\'t support file type.");
			exit;
		}
		// storage type: db
		if (is_numeric($match[4])){
            $this->_image_id = $match[4];
			$this->_src_file = $root_path.$this->fillPath($this->_image_id).'.'.$match[6];
		// storage type: local file
		} else {						
            $this->_image_id = $match[1].$match[2].$match[3].$match[4];
			$this->_image_dir = $match[1].'/'.$match[2].'/'.$match[3].'/'.$match[4].'.'.$match[6];
            $this->_src_file = $root_path.$this->_image_dir;
		}
		$this->_ext = $match[6];
        $dir = dirname($this->_src_file);
		is_dir($dir) || mkdir($dir, 0755, true);
		// 生成文件
		if (! file_exists ($this->_src_file)) {
			$ret = $this->restore($this->_image_id, $this->_src_file);
		}

		//如果没有命令提示符，显示原图，否则解析尺寸
		if ( $match[5] !== '' ) {
			// check file exists
    		if(is_file($this->_src_file) && filesize($this->_src_file) > 0) {
    			$this->_imagick = new Imagick($this->_src_file);
    		} else {
    			Loader::outputEnd('restore fail');
    		}

			/*
			 * 解析命令提示
			 * s(宽度)[c] 缩略图，c表示为正方形缩略图
			 * c(count)-(id) 大图等分切的小图 count为总数，id为顺序编号
			 */
			preg_match ('/(s|c)(\d+)(c|)/', strtolower ($match[5]), $cmd_match);
			//命令格式不匹配，终止运行
			if (!$cmd_match) {
				Loader::outputEnd('format error');
			}
			$this->_real_uri = $this->_uri;
			$this->_real_file = $root_path.substr($this->_real_uri, 1);
			if ($cmd_match[1] == 's') {
			    $this->_imagick->setImageFormat('JPEG');
                $this->_imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
				if ($this->_imagick->getImageCompressionQuality() > self::MAX_QUALITY) {
					$quality = self::MAX_QUALITY;
				} else {
                    $quality = 100;
                }
                $this->_imagick->setImageCompressionQuality($quality);
                $this->_imagick->stripImage();

				if($cmd_match[3] == 'c') {
					$this->_imagick->cropThumbnailImage($cmd_match[2], $cmd_match[2]); // Crop image and thumb
				} else {
					//$this->_imagick->resizeImage($cmd_match[2], $cmd_match[2], Imagick::FILTER_CATROM, 1, true);
                    //Work out new dimensions
					list($newX,$newY)= $this->scaleImage(
						$this->_imagick->getImageWidth(),
						$this->_imagick->getImageHeight(),
						$cmd_match[2],
						$cmd_match[2]
                    );

					//Scale the image
					$this->_imagick->thumbnailImage($newX,$newY);
				}
				//Write the new image thumb
				$this->_imagick->writeImage($this->_real_file);

			}
		} else {
            $this->_real_uri = $this->_uri;
            $this->_real_file = $root_path.substr($this->_real_uri, 1);
		}
	}

	/**
	 * display current thumb image
	 *
	 * @return void
	 */
	public function display() {
		list($web_server) = explode('/', $_SERVER['SERVER_SOFTWARE'], 2);
		switch($this->_ext) {
			case 'jpg':
				$mimetype = 'image/jpeg';
			break;
			default:
				$mimetype = 'image/'.$this->_ext;
			break;
		}
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


	/**
	 * Calculate new image dimensions to new constraints
	 *
	 * @param Original X size in pixels
	 * @param Original Y size in pixels
	 * @return New X maximum size in pixels
	 * @return New Y maximum size in pixels
	 */
	function scaleImage($x,$y,$cx,$cy) {
		//Set the default NEW values to be the old, in case it doesn't even need scaling
		list($nx,$ny)=array($x,$y);

		//If image is generally smaller, don't even bother
		if ($x>=$cx || $y>=$cx) {

			//Work out ratios
			if ($x>0) $rx=$cx/$x;
			if ($y>0) $ry=$cy/$y;

			//Use the lowest ratio, to ensure we don't go over the wanted image size
			if ($rx>$ry) {
				$r=$ry;
			} else {
				$r=$rx;
			}

			//Calculate the new size based on the chosen ratio
			$nx=intval($x*$r);
			$ny=intval($y*$r);
		}

		//Return the results
		return array($nx,$ny);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	private function restore($image_id, $file)
	{
        if(is_numeric($image_id)){ //图片存储在数据库的处理方式
            $storage = Sp_Storage::factory('mysql_db');
        } else { 
			$src = UPLOAD_ROOT.$this->_image_dir;
			return copy($src, $file);
        }

		$image = $storage->get($image_id);
		if(!$image) {
			Loader::outputEnd('not found');
			return false;
		}
		$data = $image['bytes'];
		if(strlen($data) < 10) {
			Loader::outputEnd('invalid content size');
			return false;
		}
		return file_put_contents($file, $data, FILE_BINARY | LOCK_EX );
	}

	private function fillPath($img_id)
	{
		$hashcode = md5 ($img_id);
		$dir_part1 = substr ($hashcode, 0, 2);
		$dir_part2 = substr ($hashcode, 2, 2);
		$dir_part3 = substr ($hashcode, 4, 2);
		return '/'.$dir_part1.'/'.$dir_part2.'/'.$dir_part3.'/'.$img_id;
	}
}


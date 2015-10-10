<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Sp_Storage
 *
 *
 *
 * @package	Sp
 * @author	 liut
 * @version	$Id$
 */
/**
 * Sp_Storage
 * 文件存储工厂
 *
 * 文件条目结构: array('id'=>'','filename'=>'','size'=>0,'created'=>'','type'=>'','bytes'=>'')
 * 其中 type 是 mimetype的文字表示 如: image/png; bytes 是文件内容，一般为二进制字串; created 是放入时间
 *
 */
abstract class Sp_Storage
{
	protected $_ini;

	// const
	const DFT_MAX_QUALITY = 92;

	/**
	 * forbid construct
	 *
	 */
	protected function __construct($option)
	{
		$this->_ini = $option;
	}

	/**
	 * 加载配置节点
	 *
	 * @param string $section
	 * @return array
	 */
	public static function config($section)
	{
		static $_settings = null;
		if($_settings === null) $_settings = include CONF_ROOT .'storage.conf.php';
		if(!isset($_settings[$section])) {
			throw new Exception('storage node ['. $section . '] not found');
			//return null;
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
			$option = self::config($section);
			$type = $option['type'];
			$class = __CLASS__ . '_' . ucfirst($type);
			$instances[$section] = new $class($option);
		}
		return $instances[$section];
	}

	/**
	 * 返回完整URL
	 *
	 * @param string $section
	 * @return string
	 */
	public static function makeUrl($section, $path)
	{
		$option = self::config($section);
		if($option['url_prefix']) return $option['url_prefix'] . $path;
		return $path;
	}


	/**
	 * 存储文件
	 *
	 * @param string $file
	 * @param string $name
	 * @param array $option empty
	 * @return string
	 */
	abstract public function put($file, $name, $option = null);

	/**
	 * 根据id取出文件
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	abstract public function get($id);

	/**
	 * 根据 hash 值（一般是md5）判断文件是否存在
	 *
	 * @param mixed $hashed
	 * @return mixed id or FALSE
	 */
	abstract public function exists($hashed);

	/**
	 * 根据id删除文件
	 *
	 * @param mixed $id
	 * @return boolean
	 */
	abstract public function delete($id);

	/**
	 * 分页浏览，可以添加查询条件
	 *
	 * @param array $condition = array()
	 * @param int $limit = 20
	 * @param int $offset = 0
	 * @param int $total = null
	 * @return array
	 */
	abstract public function browse($condition = array(), $limit = 20, $offset = 0, & $total = null);

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
			$this->_ini[$key] = $value;
		}
		return $this;
	}

	/**
	 * getOption
	 *
	 * @param string $key
	 * @return void
	 */
	public function getOption($key, $dft = null)
	{
		if(isset($this->_ini[$key])) return $this->_ini[$key];
		return $dft;
	}


	/**
	 * 对上传进行包装
	 *
	 * @param string $section storage.conf里的配置节点
	 * @param string $field 上传文件的input字段名
	 * @param string $new_name 上传文件的文件重命名
	 * @param string $max_size 允许上传的最大文件字节
	 * @param string $width 宽度，可省略
	 * @param string $height 高度，可省略
	 * @return mixed 返回负数为失败，返回不为空的字符为正确
	 */
	public static function upload($section, $field, $new_name = null, $max_size = null, $width = null, $height = null)
	{
		$sto = self::factory($section);
		if(is_array($max_size)) {
			$sto->setOption($max_size);
		} elseif (!is_null($max_size)) {
			$sto->setOption('max_size', $max_size);
		}
		if(!isset($_FILES[$field]) || empty($_FILES[$field]) /* || empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK*/) {
			return false;
		}
		if (is_array($_FILES[$field]['name'])) {
			$data = array();
			for($i = 0, $len = count($_FILES[$field]['name']); $i < $len; $i ++) {
				if($new_name) {
					$new_name .= $i;
				}else {
					$new_name = $_FILES[$field]['name'][$i];
				}
				$ext = strtolower(substr(strrchr($_FILES[$field]['name'][$i], '.'), 1));
				$data[$i] = $sto->_upload($_FILES[$field]['error'][$i], $_FILES[$field]['tmp_name'][$i], $new_name.'.'.$ext, $_FILES[$field]['type'][$i], $_FILES[$field]['size'][$i]);
			}
			return $data;
		}
		else {
			is_null($new_name) && $new_name = $_FILES[$field]['name'];
			$ext = strtolower(substr(strrchr($_FILES[$field]['name'], '.'), 1));
			return $sto->_upload($_FILES[$field]['error'], $_FILES[$field]['tmp_name'], $new_name.'.'.$ext, $_FILES[$field]['type'], $_FILES[$field]['size']);
		}

		//return self::mainUpload($section, $_FILES[$field]);
	}

	/**
	 * 保存上传的文件并返回结果数组
	 *
	 * @param int $status
	 * @param string $file
	 * @param string $name
	 * @param string $type
	 * @param string $size
	 * @return array
	 */
	protected function _upload($status, $file, $name, $type, $size)
	{
		if ($status !== UPLOAD_ERR_OK) {
			return array('errno' => $status, 'error' => self::errorDescription($status));
		}
		$img_info = null;
		$return_array = $this->getOption('return_array');
		$return_info = $this->getOption('return_info');
		if($return_info && !$return_array) $return_array = true;
		$hashed = md5_file($file);
		$id = $this->exists($hashed);
		if ($id) {
			return array('url'=>$id, 'errno' => 0, 'error' => 'exists');
		}
		/**
		添加水印
		 */
		if(defined('WATERMARK_UPLOAD'))
		{
			$img_info = GetImageSize($file);
			$im = new Imagick($file);
			$quality = $im->getImageCompressionQuality();
	
	        if ($quality >= self::DFT_MAX_QUALITY) {
				$quality = self::DFT_MAX_QUALITY;
			} else {
	            $quality = 100;
	        }
	        $im->setImageCompressionQuality($quality);
		
			 //添加水印
			$pic_width = 250;
			$pic_height = 100;
			$pic_url = LIB_ROOT.'source/logo.png';
			$pic_img = new Imagick($pic_url);   //左logo
		  	for ($i=0; $i <= $img_info[1] / $pic_height; $i++) { 
			  	for ($j=0; $j <= $img_info[0] / $pic_width; $j++) { 
				 //添加水印
		   		 $im->compositeImage($pic_img,Imagick::COMPOSITE_OVER,$j*$pic_width,$i*$pic_height);
			    }
			}  
			
			$pic_img->clear();
			$pic_img->destroy();
			if ($img_info[2] == IMAGETYPE_GIF) {
			$im->writeImages($file, true);
			} else {
				$im->writeImage($file); // 覆盖原文件
			}
			
		}
		
		
		
		$retVal = $this->_prepareUpload($file, $name, $type, $size, $img_info);

		if ($retVal < 0) {
			$arr = array('errno' => $retVal, 'error' => self::errorDescription($retVal));
			if ($return_info && is_array($img_info)) {
				$arr['img_info'] = $img_info;
			}
			return $arr;
		} else {
			$meta = array(
				'width'=> $img_info[0],
				'height' => $img_info[1],
				'mime_type' => $img_info[2],
				'type' => $img_info['mime'],
			);
			$url = $this->put($file, $name, $meta);
			$return_url = $this->getOption('return_url');
			$url_prefix = $this->getOption('url_prefix');
			if ($url && $return_url && $url_prefix ) {
				$url = $url_prefix . ltrim($url, '/');
			}
			if (!$return_array) return $url;
			if ($return_info && is_array($img_info) ) {
				return array('url' => $url, 'errno' => 0, 'error' => '', 'img_info' => $img_info);
			}
			return array('url' => $url, 'errno' => 0, 'error' => '');
		}
	}

	/**
	 * 对上传的文件进行预处理
	 *
	 * @param string $file
	 * @param string $name
	 * @param string $type
	 * @param string $size
	 * @param mixed $img_info
	 * @return int
	 */
	protected function _prepareUpload($file, $name, $type, $size, & $img_info = null)
	{
		$allowed_types = $this->getOption('allowed_types');
		if(is_array($allowed_types) && !in_array($type, $allowed_types)) {
			return -3;
		}
		$ext = strtolower(substr(strrchr($name, '.'), 1)); //var_dump($ext);
		$allowed_exts = $this->getOption('allowed_extensions');//var_dump($ext,$allowed_exts);
		if(is_array($allowed_exts) && !in_array($ext, $allowed_exts)) {
			return -4;
		}

		if (in_array($ext, array('gif','jpg','jpeg','jp2','png','swc','swf','tif'))){
			$ret = $this->_prepareImageFile($file, $img_info);
			if ($ret !== 0) return $ret;
		}
		$max_size = $this->getOption('max_size');
		if(filesize($file) > $max_size) {
			return -2;
		}

		return 0;
	}

	/**
	 * prepare to put a file into storage
	 *
	 * @param mixed $file
	 * @param mixed $img_info
	 * @return void
	 */
	protected function _prepareImageFile($file, & $img_info = null)
	{
			$img_info = GetImageSize($file); //var_dump($img_info);
		if ($img_info === FALSE) { // 不是图片类文件
			return -3;
		}
		// strip image
		$strip_image = $this->getOption('strip_image', true);
		if ($strip_image ) {
			$im = new Imagick($file);
			$quality = $im->getImageCompressionQuality();

            if ($quality >= self::DFT_MAX_QUALITY) {
				$quality = self::DFT_MAX_QUALITY;
			} else {
                $quality = 100;
            }
            $im->setImageCompressionQuality($quality);
			
			
			
			
			if ($img_info[2] == IMAGETYPE_GIF) {
				$im->writeImages($file, true);
			} else {
				$im->writeImage($file); // 覆盖原文件
			}

			$im->clear();
			$im->destroy();
			
		}
		// end strip image

		$allowed_imagetypes = $this->getOption('allowed_imagetypes');
		if(is_array($allowed_imagetypes) && !in_array($img_info[2], $allowed_imagetypes)) {
			return -4;
		}
		$width = $this->getOption('width');
		$max_width = $this->getOption('max_width');
		if($width && $img_info[0] != $width || $max_width && $img_info[0] > $max_width ) {
			return -5;
		}
		$height = $this->getOption('height');
		$max_height = $this->getOption('max_height');
		if($height && $img_info[1] != $height || $max_height && $img_info[0] > $max_height ) {
			return -6;
		}
        /*
		if( $img_info[2] == IMAGETYPE_JPEG ) {
			$max_quality =  $this->getOption('max_quality');
			$max_quality || $max_quality = self::DFT_MAX_QUALITY;
			isset($quality) || $quality = self::getImageQuality($file);
			if ($quality > $max_quality) {
				$img_info['quality'] = $quality;
				return -11;
			}
		}
        */

		return 0;
	}

	/**
	 * 根据值返回错误描述
	 *
	 * @param int $status
	 * @return array
	 */
	public static function errorDescription($status)
	{
		switch($status){
			case 0: // UPLOAD_ERR_OK
				return 'OK';
			case 1: // UPLOAD_ERR_INI_SIZE
				return '上传的文件超出系统最大限制';
			case 2: // UPLOAD_ERR_FORM_SIZE
				return '上传的文件超出 MAX_FILE_SIZE 限制';
			case 3: // UPLOAD_ERR_PARTIAL
				return '只有部分被传输';
			case 4: // UPLOAD_ERR_NO_FILE
				return '没有选择文件';
			case 6: // UPLOAD_ERR_NO_TMP_DIR
				return '临时目录不可用';
			case 7: // UPLOAD_ERR_CANT_WRITE
				return '写错误';
			case 8: // UPLOAD_ERR_EXTENSION
				return '由于异常而停止';

			case -1:
				return "文件错误";
			break;
			case -2:
				return "文件尺寸过大";
			break;
			case -3:
				return "文件格式不对";
			break;
			case -4:
				return "文件上传失败";
			break;
			case -5:
				return "图片宽度不符合规定宽度";
			break;
			case -6:
				return "图片高度不符合规定高度";
			break;
			case -11:
				return "图片质量比率太高，请从原稿重新压缩，建议不超过72";
			break;
			default:
				return "文件上传失败";
			break;
		}
	}

	/**
	 * 返回图片的压缩率（PNG:?; JPEG:0-100）
	 *
	 * @param string $file
	 * @return int
	 */
	public static function getImageQuality($file)
	{
		$im = new Imagick($file);
		$quality = $im->getImageCompressionQuality();
		$im->clear();
		$im->destroy();
		return $quality;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function imageTypeToExtension($type, $dot = true)
	{
		static $e = array ( 1 => 'gif', 'jpg', 'png', 'swf', 'psd', 'bmp',
			'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc',
			'aiff', 'wbmp', 'xbm');
		$type = (int)$type;
		if ( $type > 0 && isset($e[$type]) ) {
			return ($dot ? '.' : '') . $e[$type];
		}
		return null;
	}


	/**
	 * 通过文件 hash 值 计算条目的 ID
	 *
	 * @param string $hashed
	 * @return string
	 */
	public function getId($hashed)
	{
		return base_convert($hashed, 16, 36);
	}
}



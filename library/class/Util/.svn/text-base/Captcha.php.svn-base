<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_Captcha, 验证码操作类
 * 
 * @author     Liut
 * @copyright   Liut
 * @package     Core
 * @version     $Id$
 * @lastupdate $Date$
 * ChangeLog:
 */

defined('LIB_ROOT') or define('LIB_ROOT', dirname(__FILE__) . '/../../' );;

/**
 * Util_Captcha
 * 
 * example: 
 * //display
 * $captcha = Util_Captcha::getInstance();
 * $captcha->display();
 * 
 * // verify
 * $sec_id = 0;
 * $sec_word = $_POST['sec_word'];
 * if(Util_Captcha::verify_captcha($sec_word, $sec_id )) {
 * 	// true	
 * }
 * 
 * 
 */
class Util_Captcha
{

	const COOKIE_PREFIX 	= '_c_';
	const CAPTCHA_WIDTH     = 63;
	const CAPTCHA_HEIGHT    = 30;
	const CAPTCHA_SECRET 	= 'captcha_qsw_secret';

	private $_font = NULL;		//'monofont.ttf';

	//private $_captcha_engin  = NULL;
	private $_sec_id 		 = NULL;
	private $_sec_code 		 = NULL;
	private $_sec_material 	 = NULL;
	private $_timed 		 = NULL;
	private $_code_length 	 = 4;
	private $_sec_str 		 = NULL;

	public static function generateCode($characters = 4) 
	{
		/* list all possible characters, similar looking characters and vowels have been removed */
		static $possible = '2345678bcdfghABCDEFHJKjkmnPWLMNpqrstvwQRSTUVXYZxyz';
		$code = '';
		$i = 0;
		while ($i < $characters) {
				$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
				$i++;
		}
		return $code;
	}

	/**
	 * ��ȡһ��ʵ��
	 * 
	 * @param int $id
	 * @return self
	 */
	public static function getInstance($id = 0)
	{
		static $instances = array();
		if (!isset($instances[$id]) || !$instances[$id]) {
			$instances[$id] = new self($id);
		}
		return $instances[$id];
	}

	private function __construct ($sec_id = NULL) {
		$this->_font = LIB_ROOT . 'resource/fonts/MONOFONT.TTF';
		if(empty($sec_id)) $sec_id = 0;
		$this->_sec_id = $sec_id;//sprintf("%032x",$sec_id);
	}

	function __destruct () {
	}

	public function getId() {
		return $this->_sec_id;
	}

	public function getCode() {
		return $this->_sec_code;
	}
	
	public function setLength($length)
	{
		$this->_code_length = $length;
	}
	
	public function setFont($font)
	{
		$this->_font = $font;
	}

	/**
	 * 创建验证码
	 * 
	 * @param string $characters = 4
	 * @return void
	 */
	public function create() {
		static $created = false;
		if($created) return true;
		$created = true;
		$code = self::generateCode($this->_code_length);
		$this->_timed = dechex(time());

		$this->_sec_str = $code;
		// set cookie
		$sec_id = sprintf("%032s",$this->_sec_id);
		$this->_sec_material = md5(self::CAPTCHA_SECRET . $sec_id . strtolower($this->_sec_str) . $this->_timed);
		$cookie = $sec_id . $this->_sec_material . $this->_timed;
		setcookie(self::COOKIE_PREFIX.$this->_sec_id, $cookie, time() + 60 * 5, '/');
	}
	
	/**
	 * retrieve from cookie
	 * 
	 * @return void
	 */
	public function retrieve()
	{
		$key = self::COOKIE_PREFIX.$this->_sec_id;
		if(!isset($_COOKIE[$key]) || empty($_COOKIE[$key])) return FALSE;
		$cookie = $_COOKIE[$key];
		list($sec_id, $this->_sec_material, $this->_timed) = str_split($cookie, 32);
		$this->_sec_id = $sec_id;
		return TRUE;
	}
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function verify($sec_word)
	{
		if($this->isExpired()) return FALSE;
		$sec_id = sprintf("%032s",$this->_sec_id);
		$sec_material = md5(self::CAPTCHA_SECRET . $sec_id . strtolower($sec_word) . $this->_timed);
		return $sec_material === $this->_sec_material;
	}
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function isExpired()
	{
		$now = isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : time();
		return $now > hexdec($this->_timed) + 60*5;
	}

	public function display($IMG_WIDTH = 70,$IMG_HEIGHT = 25) {
       
		$this->create();
		$sec_code = $this->_sec_str;
	
		$font_size = self::CAPTCHA_HEIGHT * 0.75;
		$image = imagecreate(self::CAPTCHA_WIDTH, self::CAPTCHA_HEIGHT) or die('Cannot initialize new GD image stream');
		
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$text_color = imagecolorallocate($image, 188, 182, 0);
		$noise_color = imagecolorallocate($image, 0, 0, 0);
		
		$textbox = imagettfbbox($font_size, 0, $this->_font, $sec_code) or die('Error in imagettfbbox function');
		$x = (self::CAPTCHA_WIDTH - $textbox[4])/2;
		$y = (self::CAPTCHA_HEIGHT - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->_font, $sec_code) or die('Error in imagettftext function');
		
       	for ($i=0; $i<100; $i++) {
			$pxcolor = ImageColorAllocate($image, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
			ImageSetPixel($image, mt_rand(0,$IMG_WIDTH), mt_rand(0,$IMG_HEIGHT), $pxcolor);
		}
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
	
/*		$img = ImageCreate($IMG_WIDTH,$IMG_HEIGHT);
		ImageColorAllocate($img, mt_rand(230,250), mt_rand(230,250), mt_rand(230,250));
		$color = ImageColorAllocate($img, 0, 0, 0);
		
		$offset = 0;
		$codearr = explode('=',$sec_code);
		$codestr = explode('+',$codearr[0]);
		$code = array(
		   0=>$codestr[0],
		   1=>'+',
		   2=>$codestr[1],
		   3=>'='	
		);
		foreach ($code as $char) {
			$offset += 15;
			$txtcolor = ImageColorAllocate($img, mt_rand(0,255), mt_rand(0,150), mt_rand(0,255));
			ImageChar($img, mt_rand(3,5), $offset, mt_rand(1,5), $char, $txtcolor);
		}
		
		for ($i=0; $i<100; $i++) {
			$pxcolor = ImageColorAllocate($img, mt_rand(0,255), mt_rand(0,255), mt_rand(0,255));
			ImageSetPixel($img, mt_rand(0,$IMG_WIDTH), mt_rand(0,$IMG_HEIGHT), $pxcolor);
		}
		
		header('Content-type: image/png');
		imagepng($img);
		imagedestroy($img);
*/		
		exit();
	}

	public static function verify_captcha($sec_word, $sec_id = 0) {
		$captcha = self::getInstance($sec_id);	//
		$captcha->retrieve();
		return $captcha->verify($sec_word);
	}
}


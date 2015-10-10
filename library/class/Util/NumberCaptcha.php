<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */


/**
 *	@name 数字验证码
 * 
 */
class Util_NumberCaptcha
{
	/**
	 * $IMG_WIDTH = 100; //图像宽度
		$IMG_HEIGHT = 23; //图像高度
		$SESSION_VDCODE = ''; //Session变量名称
	 * $operator =  '+-'; //运算符
	 */
	public static function display($IMG_WIDTH = 70,$IMG_HEIGHT = 25,$SESSION_VDCODE = 'vdcode',$operator =  '+') {
		$session_id = session_id();	
		if(empty($session_id)) @session_start();
		$code = array();
		$num1 = $code[] = mt_rand(1,9);
		$code[] = '+';//{mt_rand(0,1)};
		$num2 = $code[] = mt_rand(1,9);
		$codestr = implode('',$code);
		//eval("\$result = ".implode('',$code).";");
		$code[] = '=';
		
		$_SESSION[$SESSION_VDCODE] = ((int)$num1 + (int)$num2);
		
		$img = ImageCreate($IMG_WIDTH,$IMG_HEIGHT);
		ImageColorAllocate($img, mt_rand(230,250), mt_rand(230,250), mt_rand(230,250));
		$color = ImageColorAllocate($img, 0, 0, 0);
		
		$offset = 0;
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
		ImagePng($img);
		exit();
	}
}


<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
* 图像操作类，含缩小和裁切
* 
* @author      liut(liutao@wooliao.net)
* @copyright   Wooliao
* @package     Wool
* @version     $Id$
* @lastupdate $Date$
*/

/**
 * IT_Image
 *
 * Example: 
 * include_once BBSLIB_DIR . '/class/IT/Image.php';
 * $it_image = IT_Image::getInstance(); 
 * $it_image->crop($src, $dst, 120, 120);
 */
class IT_Image {

	/** 图像格式 */
	//public static $ext = '.png';

	/**
	 * Returns a singleton instance
	 *
	 * @return IT_Image
	 * @access public
	 */
	function &getInstance() {
		static $instance = array();
		if (!isset($instance[0]) || !$instance[0]) {
			$instance[0] =& new IT_Image();
		}
		return $instance[0];
	}

	/**
	* 缩小图片，生成新图片文件
	* 
	* @param string $src 源文件全路径 （请保证有读权限）
	* @param string $dst 源文件全路径，jpg格式 （请保证有读写权限）
	* @param string $w 目标宽度（默认120像素）
	* @param string $h 目标高度（默认120像素）
	* @param string $fillspace 如果尺寸不符，是否用白色填充，默认为false，即从源图中间裁切，目标是源图的一部分
	* @param string $quality JPEG质量
	* @return boolean true or false
	*/
	function crop($src, $dst, $w = 120, $h = 120, $fillspace = false, $quality = 75) {
		//$src = $_FILES[$this->name]['tmp_name'];
		$arr = null;
		if( !$src_image = $this->getImage($src, $arr)) return FALSE;
		$src_w = ImageSX($src_image);
		$src_h = ImageSY($src_image);
		
		if ($src_w > $w || $src_h > $h){
			$scalex = ($src_w/$w);
			$scaley = ($src_h/$h);
			if ($fillspace)
			{
				if ($scalex > 1 || $scaley > 1)
				{
					$scale = ($scalex > $scaley) ? $scalex : $scaley;
					$src_image = $this->resize($src_image, $src_w, $src_h, $scale);
					$src_w = ImageSX($src_image);
					$src_h = ImageSY($src_image);

					$src_x=0;$src_y=0;
					$dst_x=($w-$src_w)/2;$dst_y=($h-$src_h)/2;
				}
				
			}
			else
			{
				if ($scalex > 1 && $scaley > 1)
				{
					$scale = ($scalex < $scaley) ? $scalex : $scaley;
					$src_image = $this->resize($src_image, $src_w, $src_h, $scale);
					$src_w = ImageSX($src_image);
					$src_h = ImageSY($src_image);

					$src_x=($src_w-$w)/2;$src_y=($src_h-$h)/2;
					$dst_x=0;$dst_y=0;
				}
				
			}

			$crop = imagecreatetruecolor($w, $h);
			$white = imagecolorallocate($crop, 255, 255, 255);
			imagefill( $crop, 0, 0, $white );
			imagecopy ( $crop, $src_image, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h );
			imagedestroy($src_image);
		} else {
			$crop = & $src_image;
		}

		$ret = imagejpeg($crop, $dst, $quality);
		imagedestroy($crop);
		return $ret;
	}

	function &resize($src_image, $src_w, $src_h, $scale)
	{
		$new_w = $src_w/$scale;
		$new_h = $src_h/$scale;
		$temp = imagecreatetruecolor($new_w, $new_h);
		$white = imagecolorallocate($temp, 255, 0, 0);
		imagecopyresampled($temp, $src_image, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
		imagedestroy($src_image);
		return $temp;
	}

	/**
	* 从图像文件获取图像资源
	*/
	function getImage($filename, $arr = null) {
		if (!$arr = getimagesize($filename)) return FALSE;
		switch($arr[2]){
			case 1:
			return imagecreatefromgif($filename);
			case 2:
			return imagecreatefromjpeg($filename);
			case 3:
			return imagecreatefrompng($filename);
			default:
			return false;
		}
	}
}
?>

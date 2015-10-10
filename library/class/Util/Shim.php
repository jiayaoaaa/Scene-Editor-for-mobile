<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_Shim
 *
 * 输出一张 1x1 透明 gif 图
 * 
 * @package    Lib
 * @author     liut
 * @version    $Id$
 * @created    23:32 2009-11-05
 */


/**
 * Util_Shim
 * 
 * 
 * 	示例:
 * 	<code class="php">
 *  $format = isset($_GET['format']) ? $_GET['format'] : '';
 * 	switch ($format)
 * 	{
 * 		case 'gif':
 *  		Util_Shim::output();
 * 		break;
 * 		
 * 	}
 * 	
 * 	
 * 	</code>
 * 
 */
class Util_Shim
{
	//const
	const GIF_DATA = '47494638396101000100800100000000ffffff21f90401000001002c00000000010001000002024c01003b'; // 1x1 透明gif
	
	
	/**
	 * 输出一张 1x1 透明 gif 图
	 * 
	 * @param boolean $return
	 * @return void
	 */
	public static function output($return = false)
	{
		$str = pack('H*',self::GIF_DATA);
		if($return) return $str;
		if(headers_sent()) return false;
		header("Content-type: image/gif");
		ob_end_clean();
		echo $str;
		exit();
	}
	
}


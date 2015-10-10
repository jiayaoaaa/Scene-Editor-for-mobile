<?PHP

// $Id$


/**
 * 建立目录树, PHP 5以上已经支持 recursive 不用此函数
 * /p/a/t/h/n
 * 
 * @param string $dir
 * @param int $mode
 * @return boolean
 * 
 */
function mkdir_r($dir, $mode = 0755)
{
	return is_dir($dir) || ( mkdir_r(dirname($dir), $mode) && @mkdir($dir, $mode) );
}

<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_image} function plugin
 *
 * Type:     function<br>
 * Name:     html_image<br>
 * Date:     Feb 24, 2003<br>
 * Purpose:  format HTML tags for the image<br>
 * Input:<br>
 *         - file = file (and path) of image (required)
 *         - height = image height (optional, default actual height)
 *         - width = image width (optional, default actual width)
 *         - basedir = base directory for absolute paths, default
 *                     is environment variable DOCUMENT_ROOT
 *         - path_prefix = prefix for path output (optional, default empty)
 *
 * Examples: {html_image file="/images/masthead.gif"}
 * Output:   <img src="/images/masthead.gif" width=400 height=23>
 * @link http://smarty.php.net/manual/en/language.function.html.image.php {html_image}
 *      (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @author credits to Duda <duda@big.hu> - wrote first image function
 *           in repository, helped with lots of functionality
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_block_togjblock($params, $content, &$smarty)
{
	if($smarty->publish == 1) {
		$blocktype = $params['blocktype'];
		$name	   = $params['name'];
		return '<div class="admin_piao" postion="'.$params['position'].'" data="blocktype='.$blocktype.'&name='.$name.'">'.
			   '<a class="admin_piao_edit" href="javascript:void(0)">修改</a>'.
			   $content.
			   '</div>';
	}else{
		return $content;
	}
    
}

/* vim: set expandtab: */

?>

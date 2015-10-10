<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * 
 * $Id$
 */


	/**
	 * Smarty strimwidth modifier plugin,
	 * 以字符“宽度”来定义截取
	 *
	 * 需要提前设置 mb_internal_encoding("UTF-8") 或 mb_internal_encoding("GBK")
	 *
	 *
	 * Type:     modifier<br>
	 * Name:     strimwidth<br>
	 * Purpose:  Smary 自带的 truncate 只支持英文半角，这里是修改版本，去除了$break_word和middle最后两个参数,
	 *           修改支持全角各类UTF或中文字符
	 *           本函数主要是依赖字符宽度控制.
	 *           如果是处理UTF-8，需要提前设置 mb_internal_encoding("UTF-8") .
	 * @author   liut < Eagle.L at gmail dot com >
	 * @param string $string
	 * @param integer $length 需要限制输出的宽度
	 * @param string $etc
	 * @return string
	 */
	function smarty_modifier_strimwidth($string, $start = 0, $width = 80, $etc = '…')
	{
		if ($width == 0) {
	        return '';
		}
		return mb_strimwidth($string, $start, $width, $etc);
/*
		$strlen = mb_strlen($string);

	    if ($strlen > $length || mb_strwidth($string) > $length) {
	        $length -= mb_strwidth($etc);
			$str     = "";
			$count   = 0;
			for ($i = 0; $i < $strlen; $i ++) {
				$curr = mb_substr($string, $i, 1);
				$str .= $curr;
				$count ++;
				if (mb_strwidth($curr) == 2){
					$count ++;
				}
				if ($count >= $length){
					break;
				}
			}
			return $str.$etc;

	    } else {
	        return $string;
	    }
		*/
	}
 

/* vim: set expandtab: */

?>

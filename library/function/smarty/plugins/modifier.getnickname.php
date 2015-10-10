<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 *
 * getnickname
 * 
 */
 
function smarty_modifier_getnickname($email)
{
	preg_match('/^(([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*)\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i', $email, $matches);
	if(isset($matches[1]))
		return $matches[1];
	return 'sw';
}


?>

<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * View_Interface 
 *
 * View 接口
 *
 * @package    Lib
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */


/**
 * View_Interface
 *
 */
interface View_Interface
{
	/**
	 * 
	 */ 
	public function assign($tpl_var, $value = null);
	/**
	 * 
	 */ 
	public function display($tpl_name);
	/**
	 * 
	 */ 
	public function fetch($tpl_name);
}
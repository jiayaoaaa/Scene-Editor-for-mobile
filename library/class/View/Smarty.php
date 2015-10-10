<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * View_Smarty
 *
 * Smarty 模板引擎
 *
 * @package    Lib
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */

include_once 'Smarty/Smarty.class.php';

/**
 * View_Smarty
 *
 */
class View_Smarty extends Smarty implements View_Interface
{
    /**
     * 构造函数
     *
     * @return View_Smarty
     */
    public function __construct()
    {
        parent::Smarty();

        $viewConfig = Config::get('viewConfig');
        if (is_array($viewConfig)) {
            foreach ($viewConfig as $key => $value) {
                if (isset($this->{$key})) {
                    $this->{$key} = $value;
                }
            }
        }

        new View_SmartyHelper($this);
    }
	
}
<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Sp_Admin_View
 *
 * View ģ������
 *
 * @package    Sp
 * @author     liut
 * @version    $Id$
 */

/**
 * Sp_Admin_View
 *
 */
class Sp_Admin_View extends Sp_View
{
    static $all_ui_skins = array('lightness', 'cupertino', 'redmond', 'smoothness', 'flick');
    protected $_skin;


    function __construct()
    {
        parent::__construct();
        $tpl_dir = isset($_SERVER["DOCUMENT_ROOT"]) ? $_SERVER["DOCUMENT_ROOT"] . '/templates/' : '';
        if (!empty($tpl_dir) && is_dir($tpl_dir)) {
            $this->template_dir = $tpl_dir;
        }
        $this->assign('tpl_header', $this->template_dir . 'header.html');
        $this->assign('tpl_footer', $this->template_dir . 'footer.html');
		$this->assign('user',Sp_Admin_User::getUser());
        $request = Request::current();
        $this->assign('ancient_browser', preg_match("#MSIE [1-8]\.#", $request->getAgent()));
    }

    /**
     * function description
     *
     * @param
     * @return void
     */
    public static function rememberSkin($skin)
    {
        empty($skin) && ($skin = isset($_REQUEST['skin']) ? $_REQUEST['skin'] : '');
        //var_dump($skin);
        if (empty($skin) || !in_array($skin, self::$all_ui_skins)) {
            $skin = self::$all_ui_skins[0];
        }
        return setcookie('dust_ui_skin', $skin, $_SERVER['REQUEST_TIME'] + 604800);
        //return $_COOKIE['dust_ui_skin'];
    }

    /**
     * function description
     *
     * @param
     * @return void
     */
    public static function allSkins()
    {
        return self::$all_ui_skins;
    }

}
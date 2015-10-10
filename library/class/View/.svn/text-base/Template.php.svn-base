<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * View_Template
 *
 * 用来处理被编译过的模板文件的引擎，支持Discuz的编译结果必须由View_TemplateCompiler编译产生
 *
 * @package    Lib
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */


/**
 * View_Template
 *
 */

class View_Template implements View_Interface
{
	private $_theme_dir;
	private $_cache_dir;
	private $_style_id;
	const DEFAULT_STYLE_ID = 1;
	
	private $_root = '';
	private $_tplrefresh;

	/**
	 * where assigned template vars are kept
	 *
	 * @var array
	 */
    private $_tpl_vars = array();

	public function __construct($root = null, $style_id = self::DEFAULT_STYLE_ID)
	{
		if (null === $root) $root = Config::get('viewConfig.root');
		$this->_root = $root;
		$this->_style_id = $style_id;
		$this->_tplrefresh = Config::get('viewConfig.tplrefresh');
		if(!defined('IN_DISCUZ')) define( 'IN_DISCUZ', TRUE );
		include $this->_root . 'forumdata/cache/style_'.$this->_style_id.'.php';
		$cache_setting = $this->_root . 'forumdata/cache/cache_settings.php';
		if (file_exists($cache_setting)) 
		{
			include $cache_setting;
		}
		if (isset($_DCACHE['settings'])) 
		{
			$this->assign( $_DCACHE['settings']);
		}
	}

	/**
	 * assigns values to template variables
	 *
	 * @param array|string $tpl_var the template variable name(s)
	 * @param mixed $value the value to assign
	 */
    function assign($tpl_var, $value = null)
    {
        if (is_array($tpl_var)){
            foreach ($tpl_var as $key => $val) {
                if ($key != '') {
                    $this->_tpl_vars[$key] = $val;
                }
            }
        } elseif ($tpl_var != '') {
			$this->_tpl_vars[$tpl_var] = $value;
        }
    }

	/**
	 * assigns values to template variables by reference
	 *
	 * @param string $tpl_var the template variable name
	 * @param mixed $value the referenced value to assign
	 */
    function assign_by_ref($tpl_var, &$value)
    {
        if (is_array($tpl_var)){
            foreach ($tpl_var as $key => $val) {
                if ($key != '') {
                    $this->_tpl_vars[$key] = &$val;
                }
            }
        } elseif ($tpl_var != ''){
			$this->_tpl_vars[$tpl_var] = &$value;
        }
    }

	public function template($file, $templateid = 0, $tpldir = '')
	{
		//global $tplrefresh, $inajax;
		$tplrefresh = $this->_tplrefresh;
		$file .= $inajax && ($file == 'header' || $file == 'footer') ? '_ajax' : '';
		$tpldir = $tpldir ? $tpldir : TPLDIR;
		$templateid = $templateid ? $templateid : TEMPLATEID;

		$tplfile = $this->_root.''.$tpldir.DS.$file.'.htm';
		$objfile = $this->_root.'forumdata/templates/'.$templateid.'_'.$file.'.tpl.php';
		if(TEMPLATEID != 1 && $templateid != 1 && !file_exists($tplfile)) {
			return $this->template($file, 1, 'templates/default/');
		}
		if($tplrefresh == 1 || ($tplrefresh > 1 && substr($GLOBALS['timestamp'], -1) > $tplrefresh)) {
			if(!file_exists($tplfile) || @filemtime($tplfile) > @filemtime($objfile)) {
				$tc = new View_TemplateCompiler($this->_root);
				$tc->parse($file, $templateid, $tpldir);
			}
		}
		return $objfile;
	}
	
	public function display($tpl_name)
	{//var_dump($template);
		echo $this->fetch($tpl_name);
	}
	
	public function fetch($tpl_name)
	{
		$template_file = $this->template($tpl_name);
		ob_start();
		@extract($this->_tpl_vars);
		include $template_file;
		$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
	
	public function debug()
	{
		
		return FALSE;
	}
	
	public function output()
	{
		
		return FALSE;
	}
	
}
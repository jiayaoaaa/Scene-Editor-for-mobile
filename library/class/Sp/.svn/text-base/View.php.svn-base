<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Sp_View
 *
 * View 模板引擎
 *
 * @package    Sp
 * @author     liut
 * @version    $Id$
 */

if (!class_exists('Smarty', FALSE)) {
    include_once SMARTY_DIR . 'SmartyBC.class.php';

    if (!class_exists('Smarty', FALSE)) {
        die('class Smarty not found!');
    }
}

/**
 * Sp_View
 *
 */
class Sp_View extends SmartyBC implements View_Interface
{
    //protected $_head_title = '';
    //protected $_head_keywords = '';
    //protected $_head_description = '';
    protected $_head_links = array();
    protected $_head_scripts = array();
    protected $_head_styles = array();
    protected $_foot_scripts = array();
    protected $_head_links_origin = array();
    protected $_head_scripts_origin = array();
    protected $_foot_scripts_origin = array();
    protected $_head_styles_origin = array();
    protected $_charset = 'UTF-8';
    protected $_parent_dir = null;
    protected $_dft_skin = VIEW_SKIN_DEFAULT;
    protected $_cur_skin = '';
    protected $_request = null;

    /**
     * 继承Smarty并设置项目的属性
     */
    function __construct($charset = 'UTF-8', $cur_skin = 'default')
    {
        //Class Constructor. These automatically get set with each new instance.
        method_exists('Smarty', 'Smarty') && $this->Smarty() || parent::__construct();
        if (isset($cur_skin) && !empty($cur_skin)) {
            $this->_cur_skin = $cur_skin;
        } else {
            if (defined('VIEW_SKIN_CURRENT')) {
                $this->_cur_skin = VIEW_SKIN_CURRENT;
            } else {
                $this->_cur_skin = $this->_dft_skin;
            }
        }
        if (defined('VIEW_SKINS_ROOT')) {
            $this->_parent_dir = VIEW_SKINS_ROOT;
        } else {
            die("please set template skin dir first! ");
        }

        $this->template_dir = VIEW_SKINS_ROOT . $this->_cur_skin . '/';
        //echo $this->template_dir;
        //$this->use_sub_dirs = true;
        $this->compile_id = (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'local') . '_' . $this->_cur_skin;
        $this->compile_dir = VIEW_COMPILE_DIR;
        $this->config_dir = VIEW_CONFIG_DIR;
        $this->plugins_dir = array(LIB_ROOT . 'function/smarty/plugins', SMARTY_DIR . '/plugins');

        // Smarty 的模板缓存，奇怪的设计，慎用
        //$this->cache_dir = VIEW_CACHE_DIR;
        //$this->cache_lifetime = defined('VIEW_CACHE_LIFETIME') ? VIEW_CACHE_LIFETIME : 1440;
        //$this->clear_all_cache();
        //$this->caching = defined('VIEW_CACHE_ENABLE') ? VIEW_CACHE_ENABLE : true;
        //$this->security = true;
        $this->use_sub_dirs = TRUE;  //开启缓存目录分级
        $this->left_delimiter = '{%';
        $this->right_delimiter = '%}';

		
        $this->_charset = $charset;
        new Sp_View_Helper($this);

        $this->assign_by_ref('head_title', $this->_head_title);
        $this->assign_by_ref('head_keywords', $this->_head_keywords);
        $this->assign_by_ref('head_description', $this->_head_description);
        $this->assign_by_ref('head_links', $this->_head_links);
        $this->assign_by_ref('head_styles', $this->_head_styles);
        $this->assign_by_ref('head_scripts', $this->_head_scripts);
        $this->assign_by_ref('foot_scripts', $this->_foot_scripts);
        $this->assign_by_ref('charset', $this->_charset);

        defined('SP_URL_API') && $this->assign('SP_URL_API', SP_URL_API); //API  kong 增加
        defined('SP_URL_HOME') && $this->assign('SP_URL_HOME', SP_URL_HOME);
        defined('SP_URL_CSS') && $this->assign('SP_URL_CSS', SP_URL_CSS);
        defined('SP_URL_IMG') && $this->assign('SP_URL_IMG', SP_URL_IMG);
        defined('SP_URL_JS') && $this->assign('SP_URL_JS', SP_URL_JS);
        defined('SP_URL_STO') && $this->assign('SP_URL_STO', SP_URL_STO);
        defined('SP_URL_CS') && $this->assign('SP_URL_CS', SP_URL_CS);
	    defined('SP_URL_UPLOAD') && $this->assign('SP_URL_UPLOAD', SP_URL_UPLOAD);	
	 	defined('SP_URL_FILE') && $this->assign('SP_URL_FILE', SP_URL_FILE);		
        defined('SP_DOMAIN_SUFFIX') && $this->assign('SP_DOMAIN_SUFFIX', SP_DOMAIN_SUFFIX); 

        
        defined('DATA_TYPE') && $this->assign('DATA_TYPE', DATA_TYPE);
        
        $this->assign('COOKIE_DOMAIN', Request::genCookieDomain());

        // current request
        $this->_request = Request::current();
        $this->assign_by_ref('_request', $this->_request);

        is_null($this->_parent_dir) && $this->_parent_dir = CONF_ROOT . 'templates/';

        if (is_dir($this->_parent_dir)) {
            $this->assign('parent_dir', $this->_parent_dir);
        } else {
            $this->assign('parent_dir', '');
        }
		
		$user = Sp_Account_User::current();
		if ($user->isLogin()){
			$user = Sp_Account_User::getUser($user->id, array('name','face','gender','province','city','area','mobile_status','email_status'));
			$this->assign('user',$user);
		}
		
        $this->assign('SP_COMPANY', SP_COMPANY); //公司名称
        $this->assign('SP_INVEST_COMPANY', SP_INVEST_COMPANY); //网站名称

        $this->default_template_handler_func = array($this, 'make_template');

    }

    /**
     * 添加头部脚本引用的名称
     *
     * @param string $name
     * @param boolean $unshift 是否放在最前面
     * @param boolean $v 是否生成版本号
     * @return void
     */
    public function addScript($name, $unshift = false, $v = true)
    {
        if (!in_array($name, $this->_head_scripts_origin)) {
            array_push($this->_head_scripts_origin, $name);
            $v && $name = $this->getLastModifyName($name, 'js');
            if ($unshift) return array_unshift($this->_head_scripts, $name);
            return array_push($this->_head_scripts, $name);
        }
    }

    /**
     * 添加尾部脚本引用的名称
     *
     * @param string $name
     * @param boolean $unshift 是否放在最前面
     * @param boolean $v 是否生成版本号
     * @return void
     */
    public function addFootScript($name, $unshift = false, $v = true)
    {
        if (!in_array($name, $this->_foot_scripts)) {
            array_push($this->_foot_scripts_origin, $name);
            $v && $name = $this->getLastModifyName($name, 'js');
            if ($unshift) return array_unshift($this->_foot_scripts, $name);
            return array_push($this->_foot_scripts, $name);
        }
    }

    /**
     * function description
     *
     * @param string $name
     * @param boolean $unshift 是否放在最前面
     * @param boolean $v 是否生成版本号
     * @return void
     */
    public function addStyle($name, $unshift = false, $v = true)
    {
        if (!in_array($name, $this->_head_styles_origin)) {
            array_push($this->_head_styles_origin, $name);
            $v && $name = $this->getLastModifyName($name, 'css');
            if ($unshift) return array_unshift($this->_head_styles, $name);
            return array_push($this->_head_styles, $name);
        }
    }

    /**
     * add head link
     *
     * @param array $entry
     * @return void
     */
    public function addHeadLink($entry)
    {
        if (is_array($entry) && count($entry) > 1) {
            $this->_head_links[] = $entry;
        }

    }

    /**
     * 返回包含最后更新时间戳的脚本名称
     *
     * @param string $name
     * @param string $suffix [css js]
     */
    public function getLastModifyName($name, $suffix)
    {
        $name = preg_replace('/_v\d+$/', '', $name);
        $sto_root = $suffix == 'js' ? STO_JS_ROOT : STO_CSS_ROOT;
        $filename = $sto_root . $name . '.' . $suffix;
        if (file_exists($filename)) {
            $mtile = filemtime($filename);
            return $name . '_v' . $mtile;
        }
        return $name;
    }

    /**
     * function description
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->_charset;
    }

    /**
     * function description
     *
     * @param string $charset
     * @return void
     */
    public function setCharset($charset)
    {
        $this->_charset = $charset;
    }

    /**
     * 设置页面标题
     *
     * @param $title
     * @return void
     */
    public function setTitle($title)
    {
        //$this->_head_title = $title;
        $this->assign_by_ref('head_title', $title);
    }

    /**
     * function description
     *
     * @param
     * @return void
     */
    public function setKeywords($kw)
    {
        $this->assign_by_ref('head_keywords', $kw);
    }


    /**
     * function description
     *
     * @param
     * @return void
     */
    public function out_404($end = true)
    {
        header("HTTP/1.0 404 Not Found");
        //获取模板主键
        $this->display('error/404.html');
        $end && exit();
    }
	
	/**
     * function description
     *
     * @param
     * @return void
     */
    public function out_500($end = true)
    {
        //header("HTTP/1.1 500 Internal Server Error");
        //获取模板主键
        $this->display('error/500.html');
        $end && exit();
    }
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function relocation($message = '', $url = '')
    {
        if (!$url) {
            $url = SP_URL_HOME;
        }
        if ($message) {
            echo '<script>alert("' . $message . '");location.href = "' . $url . '";</script>';
        } else {
            echo '<script>location.href = "' . $url . '";</script>';
        }
        exit();
    }

    /**
     * displays the template results
     *
     * @param string $tpl_name
     * @param string $cache_id
     * @param string $compile_id
     * @return void
     */
    public function display($tpl_name, $cache_id = null, $compile_id = null)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && preg_match('/MSIE (7|8)/', $this->_request->getAgent())) { // 检测是否为IE
            $content = $this->fetch($tpl_name);
            $content = str_replace(array('http://' . SP_STATIC_HOST . '/', SP_URL_STAT, SP_URL_USER), '/', $content);
            $content = str_replace('/wanlitong/', SP_URL_USER . 'wanlitong/', $content);
            echo $content;
        } else {
            //$g_view->assign("res_bundle", FALSE);
            parent::display(trim($tpl_name), $cache_id, $compile_id);
        }
    }

    protected function make_template($resource_type, $resource_name, &$template_source, &$template_timestamp, &$smarty_obj)
    {
        if ($resource_type == 'file') {
            if (!is_readable($resource_name)) {
                $skins = array($this->_cur_skin);
                if ($this->_cur_skin != $this->_dft_skin) {
                    $skins[] = $this->_dft_skin;
                }
                foreach ($skins as $skin) {
                    $file = $this->_parent_dir . $skin . '/' . $resource_name;
                    if (is_readable($file)) {
                        $template_source = file_get_contents($file);
                        return true;
                    }
                }
            }
        }
        // not a file
        return false;

    }

    /**
     * 返回当前选择的skin名称
     */
    public function getSkin()
    {
        return $this->_cur_skin;
    }

}


/**
 * Sp_View_Helper
 *
 */
class Sp_View_Helper
{
    private $_view = null;

    /**
     * 构造函数
     *
     * @param Smarty $view
     */
    public function __construct($view)
    {
        if (is_object($view)) {
            $this->_view = & $view;
            $charset = $view->getCharset();
            empty($charset) || mb_internal_encoding($charset);
            $view->register_modifier('truncate', array(& $this, '_modifier_truncate'));
            // //$view->register_modifier('strcut',    array(& $this, '_modifier_strcut'));
            // $view->register_modifier('sp_thumb',    array(& $this, '_modifier_sp_thumb'));
            // $view->register_modifier('sp_nickname',    array(& $this, '_modifier_sp_nickname'));
            // $view->register_modifier('sp_avatar',    array(& $this, '_modifier_sp_avatar'));
            // $view->register_modifier('to_gbk',    array(& $this, '_modifier_to_gbk'));
            $view->register_modifier('url_item', array(& $this, '_modifier_url_item'));
        }
    }

    /**
     * function description
     *
     * @param string $url
     * @return void
     */
    public function _modifier_sp_thumb($url, $size = '100x100')
    {
        if (strncasecmp($url, 'http://sto.', 11) === 0) {
            return preg_replace("#(http://sto\.[a-z\.]+/)(.{5,})#i", "$1/thumb/s$size/$2", $url);
        }
        return $url;
    }


    /**
     * Smarty truncate modifier plugin, 根据宽度输出字符
     *
     * Type:     modifier<br>
     * Name:     truncate<br>
     * Purpose:  Smary 自带的truncate只支持英文半角， 这里是修改版本， 去除了$break_word和middle最后两个参数,
     *           修改支持全角各类UTF或中文字符
     *           本函数主要是依赖字符宽度控制.
     *           如果是处理UTF-8，需要提前设置 mb_internal_encoding("UTF-8") .
     * @author   liut < Eagle.L at gmail dot com >
     * @param string $string
     * @param integer $length
     * @param string $etc
     * @return string
     */
    function _modifier_truncate($string, $length = 80, $etc = '…')
    {

        if ($length == 0) {
            return '';
        }
        return mb_strimwidth($string, 0, $length, $etc);

    }

    /**
     * 根据用户Email查找用户头像地址
     *
     * @param
     * @return void
     */
    function _modifier_sp_avatar($email, $size = 23)
    {
        return Sp_Account::makeAvatar($email, $size);
    }


    /**
     * 将UTF-8 转码为 GBK
     *
     * @param  string $text
     * @return void
     */
    function _modifier_to_gbk($text)
    {
        return iconv('utf-8', 'gbk', $text);
    }

    /**
     * 将商品 id 转换成 商品页 url
     *
     * @param  int $id
     * @return string
     */
    function _modifier_url_item($id)
    {
        return SP_URL_ITEM . $id . '/';
    }

}



<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * View_SmartyHelper
 *
 * Smarty 模板引擎
 *
 * @package    Lib
 * @author     liut
 * @copyright  =yy-inc.com=
 * @version    $Id$
 */


/**
 * View_SmartyHelper
 *
 */
class View_SmartyHelper
{
    /**
     * 构造函数
     *
     * @param Smarty $tpl
     */
    public function __construct($tpl) {
        $tpl->register_function('url',          array(& $this, '_pi_func_url'));
        $tpl->register_function('webcontrol',   array(& $this, '_pi_func_webcontrol'));
        $tpl->register_function('_t',           array(& $this, '_pi_func_t'));
        $tpl->register_function('get_conf',  array(& $this, '_pi_func_get_conf'));
        $tpl->register_function('dump_ajax_js', array(& $this, '_pi_func_dump_ajax_js'));

        $tpl->register_modifier('parse_str',    array(& $this, '_pi_mod_parse_str'));
        $tpl->register_modifier('to_hashmap',   array(& $this, '_pi_mod_to_hashmap'));
        $tpl->register_modifier('col_values',   array(& $this, '_pi_mod_col_values'));
        $tpl->register_modifier('friendly_time',   array(& $this, '_friendly_time'));
    }

    /**
     * 提供对  url() 函数的支持
     */
    public function _pi_func_url($params)
    {
        $controllerName = isset($params['ctl']) ? $params['ctl'] : null;
        unset($params['ctl']);
        $actionName = isset($params['act']) ? $params['act'] : null;
        unset($params['act']);
        $anchor = isset($params['anchor']) ? $params['anchor'] : null;
        unset($params['anchor']);

        $options = array('bootstrap' => isset($params['bootstrap']) ? $params['bootstrap'] : null);
        unset($params['bootstrap']);

        $args = array();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                $args = array_merge($args, $value);
                unset($params[$key]);
            }
        }
        $args = array_merge($args, $params);

        return url($controllerName, $actionName, $args, $anchor, $options);
    }

    /**
     * 提供对  WebControls 的支持
     */
    public function _pi_func_webcontrol($params)
    {
        $type = isset($params['type']) ? $params['type'] : 'textbox';
        unset($params['type']);
        $name = isset($params['name']) ? $params['name'] : null;
        unset($params['name']);

        $ui = Loader::initWebControls();
        return $ui->control($type, $name, $params, true);
    }

    /**
     * 提供对  _T() 函数的支持
     */
    public function _pi_func_t($params)
    {
        return _T($params['key'], isset($params['lang']) ? $params['lang'] : null);
    }

    /**
     * 提供对 Config::get() 方法的支持
     */
    public function _pi_func_get_conf($params)
    {
        return Config::get($params['key']);
    }

    /**
     * 输出 Ajax 生成的脚本
     */
    public function _pi_func_dump_ajax_js($params)
    {
        $wrapper = isset($params['wrapper']) ? (bool)$params['wrapper'] : true;
        $ajax = Loader::initAjax();
        /* @var $ajax Ajax */
        return $ajax->dumpJs(true, $wrapper);
    }

    /**
     * 将字符串分割为数组
     */
    public function _pi_mod_parse_str($string)
    {
        $arr = array();
        parse_str(str_replace('|', '&', $string), $arr);
        return $arr;
    }

    /**
     * 将二维数组转换为 hashmap
     */
    public function _pi_mod_to_hashmap($data, $f_key, $f_value = '')
    {
        $arr = array();
        if (!is_array($data)) { return $arr; }
        if ($f_value != '') {
            foreach ($data as $row) {
                $arr[$row[$f_key]] = $row[$f_value];
            }
        } else {
            foreach ($data as $row) {
                $arr[$row[$f_key]] = $row;
            }
        }
        return $arr;
    }

    /**
     * 获取二维数组中指定列的数据
     */
    public function _pi_mod_col_values($data, $f_value)
    {
        $arr = array();
        if (!is_array($data)) { return $arr; }
        foreach ($data as $row) {
            $arr[] = $row[$f_value];
        }
        return $arr;
    }
	
	public function _friendly_time($switch_time) 
	{
		$now_time = time();
		$time_span = $now_time - $switch_time;
		if($time_span < 60)
			return '1分钟前';
		elseif($time_span < 3600)
			return floor($time_span/60).'分钟前';
		elseif($time_span < 86400)
			return floor($time_span/3600).'小时前';
		elseif($time_span < 2592000)
			return floor($time_span/86400).'天前';
		elseif($time_span < 31104000)
			return '约'.floor($time_span/2592000).'月前';
		else
			return date('Y-m-d', $switch_time);
		
	}
}

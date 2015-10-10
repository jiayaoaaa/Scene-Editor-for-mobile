<?PHP

/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_PrettyQuery: 处理静态化的参数输入
 * 
 * 
 * @author ao
 * @version $Id$
 */

/**
 * Util_PrettyQuery
 * 
 * 
 * 
 * 
 * example: 
 * <code>
 * $keys = array('kw', 'cate', 'land', 'price', 'brand', 'stat', 'sort', 'rows', 'page');
 * $prefix = '/search/item/';
 * $glue = '--';
 * $suffix = '.html';
 * $pq = new Util_PrettyQuery($keys, $prefix, $glue, $suffix);
 * $pq->init();
 * $pq->dft('stat', 1)->dft('page', 1)->dft('rows', 40);
 * // 可以配合Pager提供分页Url格式
 * $pager = new Util_Pager($total = 0, $pq->page, $pq->rows, $pq->url('page', '%d'));
 * // Smarty
 * $view->assign('pq', $pq);
 * // Smarty Tpl
 * <a href="{ $pq->url('cate', '024') }" >女士</a>
 * </code>
 * 
 */
class Util_PrettyQuery
{
	// private vars
	private $prefix = '/';
	private $suffix = '.html';
	private $glue = '--';
	private $keys = array('kw', 'cate', 'land', 'price', 'brand', 'stat', 'sort', 'rows', 'page');
	// public vars
	private $vals = array();

	/**
	 * 构造函数
	 *
	 *
	 * @param mixed $keys = null
	 * @param string $prefix = '/' url prefix URL前辍
	 * @param string $glue = '--' 连接各参数值的分隔符
	 * @param string $suffix = '.html' URL后辍
	 * 
	 * @return object
	 */
	public function __construct($keys, $prefix = '/', $glue = '--', $suffix = '.html')
	{
		$this->keys = $keys;
		$this->prefix = $prefix;
		$this->glue = $glue;
		$this->suffix = $suffix;
	}

	/**
	 * 从请求地址初始化
	 *
	 * @param string $uri = $_SERVER['REQUEST_URI']
	 * @return object
	 */
	public function init($uri = null)
	{
		if(is_null($uri)) {
			$uri = urldecode($_SERVER['REQUEST_URI']);
		}
		$pos = strpos($uri, $this->prefix);
		if($pos === FALSE) {
			$this->vals = array_fill_keys($this->keys, '');
			return $this;
		}
		$str = substr($uri, $pos + strlen($this->prefix));
		if ( ($pos = strpos($str, $this->suffix)) !== FALSE) {
			$str = substr($str, 0, $pos);
		}
		elseif ( ($pos = strpos($str, '?')) !== FALSE) {
			$str = substr($str, 0, $pos);
		}
		
		$k_len = count($this->keys);
		$u_vals = explode($this->glue, $str, $k_len + 2); unset($str);
		if(count($u_vals) > $k_len) $u_vals = array_slice($u_vals, 0, $k_len);
		else $u_vals = array_pad($u_vals, $k_len, '');
		foreach($u_vals as &$v) {
			$v = trim($v,'/');
		}
		$this->vals = array_combine($this->keys, $u_vals);
		
		return $this;
	}

	/**
	 * 设置默认值
	 *
	 * @param string $name
	 * @param string $value
	 * @return object
	 */
	public function dft($name, $value)
	{
		$v = $this->vals[$name];
		if(empty($v)) $this->vals[$name] = $value;
		return $this;
	}

	/**
	 * 根据名称取值
	 *
	 * @param string $name
	 * @return string
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->vals)) {
			return is_null($this->vals[$name]) ? '' : $this->vals[$name];
		}
		return null;
	}

	/**
	 * 设置某个键的值
	 *
	 * @param string $name
	 * @param string $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		is_string($name) && !empty($name) && $this->vals[$name] = $value;
	}

	/**
	 * 设置某个键的值
	 * 
	 * @param string $name
	 * @param string $value
	 * @return object
	 */
	public function set($name, $value)
	{
		$this->__set($name, $value);
		return $this;
	}
	
	/**
	 * 返回某个参数是否有效
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function __isset($name)
	{
		return is_string($name) && isset($this->vals[$name]) && !empty($this->vals[$name]);
	}
	
	/**
	 * 返回已经格式化过的 url
	 *
	 * @param string $name
	 * @param string $value
	 * @return string
	 */
	public function url($name = null, $value = '', $name2 = null, $value2 = '')
	{
		$arr = $this->vals;
		if(is_array($name)) {
			foreach($name as $key => $value) {
				isset($arr[$key]) && $arr[$key] = $value;
			}
		} elseif(is_string($name)) {
			isset($arr[$name]) && $arr[$name] = $value;
			is_string($name2) && isset($arr[$name2]) && $arr[$name2] = $value2;
		}
		//$arr = empty($name) ? $this->vals : array_merge($this->vals, array($name=>$value));
		return $this->prefix . $this->seed($arr) . $this->suffix;
	}
	/**
	 * 返回可用于标识本次实例值的字串种子
	 * 
	 * @return string
	 */
	public function seed($vals = null)
	{
		is_null($vals) && $vals = $this->vals;
		//var_dump($vals);
		return implode($this->glue, array_values($vals));
	}
	
}



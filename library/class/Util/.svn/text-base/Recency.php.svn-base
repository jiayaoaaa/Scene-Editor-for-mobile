<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_Recency
 *
 * 用Cookie保存最近操作过的ID，最新的在最后
 * 在Cookie中保存的字符串用逗号（,）分隔（默认）
 * 
 * @package    Lib
 * @author     liut
 * @version    $Id$
 * @created    21:53 2009-07-30
 */


/**
 * Util_Recency
 * 
 * 
 * 	示例:
 * 	<code class="php">
 *  $cookie_name = 'myrecent';
 * 	$recency = Util_Recency::make($cookie_name);
 * 	$recency->add($id);
 * 	$recency->save();
 *  
 * 	$recent_ids = $recency->getIds();
 * 	
 * 	</code>
 * 
 */
class Util_Recency
{
	// vars
	protected $_cookie_name;
	protected $_cookie_life = 604800;
	protected $_max_items = 10;
	protected $_ids;
	protected $_glue = ','; // 存储Cookie值的分隔符
	protected $_changed = false;

	/**
	 * constructor
	 * 
	 * @return void
	 */
	protected function __construct($cookie_name)
	{
		$this->_cookie_name = $cookie_name;
		$this->_ids = isset($_COOKIE[$this->_cookie_name]) ? explode($this->_glue, $_COOKIE[$this->_cookie_name]) : array();
	}

	/**
	 * return current singleton self
	 * 
	 * @return object
	 */
	public static function make($name = 'recent')
	{
		static $_objs = array();
		if(!isset($_objs[$name]) || $_objs[$name] === null) {
			$_objs[$name] = new self($name);
		}
		return $_objs[$name];
	}

	/**
	 * 添加 ID
	 * 
	 * @param mixed $id
	 * @return int
	 */
	public function add($id)
	{
		$key = array_search($id, $this->_ids);
		if ($key !== FALSE) {
			if ($key === 0) {
				return true;
			}
			unset($this->_ids[$key]);
		} elseif(count($this->_ids) >= $this->_max_items) {
			array_pop($this->_ids);
		}
		$ret = array_unshift($this->_ids, $id);
		if($ret) $this->_changed = true;
		return $ret;
	}

	/**
	 * 返回当前的ID数组
	 * 
	 * @return array
	 */
	public function getIds()
	{
		return $this->_ids;
	}

	/**
	 * 保存到数组到 Cookie
	 * 
	 * @return void
	 */
	public function save()
	{
		if($this->_changed) {
			setcookie($this->_cookie_name, implode($this->_glue, $this->_ids), $_SERVER['REQUEST_TIME'] + $this->_cookie_life, '/');
		}
	}

	/**
	 * 设置 Cookie 保存时间
	 * 
	 * @param int $lifetime
	 * @return void
	 */
	public function setLife($lifetime)
	{
		$this->_cookie_life = $lifetime;
	}

	/**
	 * 设置 最大 保存数
	 * 
	 * @param int $length
	 * @return void
	 */
	public function setLength($length)
	{
		$this->_max_items = $length;
	}

	/**
	 * 设置分隔符
	 * 
	 * @param string $glue
	 * @return void
	 */
	public function setGlue($glue)
	{
		$this->_glue = $glue;
	}
	
	
}

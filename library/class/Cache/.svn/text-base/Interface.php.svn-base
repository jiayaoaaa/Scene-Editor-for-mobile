<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Cache_Interface
 *
 * 缓存引擎类接口
 *
 * @package    Core
 * @author     liut
 * @version    $Id$
 */



/**
 * Cache_Interface
 *
 */
interface Cache_Interface
{
	
	/**
	 * 按参数（数组）初始化
	 *
	 */
	public function init($params = NULL);
	
	/**
	 * 按 Key 取缓存条目
	 *
	 */
	public function get($key);
	
	/**
	 * 存缓存数据
	 *
	 */
	public function set($key, $value, $expire);
	
	/**
	 * 按 Key 删除缓存条目
	 *
	 */
	public function delete($key, $expire = NULL);
	
	/**
	 * 清除全部缓存条目
	 *
	 */
	public function clean();
	
	/**
	 * 开始输出缓存
	 *
	 */
    public function start($key);
	
	
	/**
	 * 结束输出
	 *
	 */
    public function end();
	
	/**
	 * 函数缓存
	 *
	 */
	public function call();
	
	/**
	 * 删除函数缓存
	 *
	 */
	public function drop();
	
}


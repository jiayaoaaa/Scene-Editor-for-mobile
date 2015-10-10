<?php
/**
 * Data Object Model 数据模型基类，多表示为通用的、 以数字Id为主键的类的基类
 *
 * @author 
 * @version $Id$
 * @created 2:20 2009年7月16日
 */

/**
 * Model_Abstract
 * 
 */
abstract class Model_Abstract implements ArrayAccess, Serializable
{
	// private vars
	private $_data = array();
	private $_key;
	private $_old_data = array();
	private $_new_data = array();

	//protected vars;
	protected $_editables = array();
	protected $_primary_keys = array('id');


	/**
	 * constructor
	 * 
	 * @param int $id
	 */
	protected function __construct()
	{
	}

	/**
	 * initFromArgs
	 * 
	 * @param mixed $id
	 * @param string $col
	 * @return void
	 */
	protected function init($id, $col = 'id')
	{
		if(is_array($id)) {
			$this->_set($id);
		}
		elseif(is_int($id) || is_numeric($id) && $col == 'id') {
			$row = $this->_getRow($id, 'id');
			if(is_array($row)) {
				$this->_set('id', intval($id));
				$this->_set($row);
			}
		}
		elseif(!empty($id) && in_array($col, $this->_primary_keys))
		{
			$row = $this->_getRow($id, $col);
			if(is_array($row)) {
				$this->_set($col, $id);
				$this->_set($row);
			}
		}
		$this->_key = $this->getKey();
	}

	/**
	 * 经过包装的属性获取方法
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		$_name = '_'.$name;
		if (property_exists($this, $_name)) {
			//echo 'exists ', $name, "\n";
			return $this->$_name;
		}
        if (array_key_exists($name, $this->_data)) {
            return $this->_data[$name];
        }
		$method = 'get'.ucfirst($name);
		if(method_exists($this, $method)) 
		{
			$ret = $this->$method();
			$this->_data[$name] = $ret;
			return $ret;
		}
		return null;
	}

	/**
	 * Check if key exists in data
	 * 
	 * @param string $name
	 * @return void
	 */
	public function __isset($name)
	{
		$_name = '_'.$name;
		if (property_exists($this, $_name)) {
			return true;
		}
		return array_key_exists($name, $this->_data);
	}
	
	/**
	 * inner unset
	 * 
	 * @param string $name
	 * @return void
	 */
	protected function _unset($name)
	{
		unset($this->_data[$name]);
	}
	
	
	/**
	 * 设置成员值
	 * 
	 * @param string $name | array
	 * @param mixed $value
	 * @return void
	 */
	public function __set($name, $value)
	{
		if(!is_string($name) || empty($name)) return false;
		
		$method = 'set'.ucfirst($name);
		if(method_exists($this, $method)) {
			$old_value = $this->__get($name);
			$this->$method($value);
			$new_value = $this->__get($name);
			$this->_setChanged($name, $new_value, $old_value);
			return;
		}
		$_name = '_'.$name;
		if (property_exists($this, $_name)) {
			$this->$_name = $value;
		}
		else
		{
			$this->_setChanged($name, $value, $this->__get($name));
			$this->_data[$name] = $value;
		}
	}

	/**
	 * 修改某个值时做记录
	 * 
	 * @param string $name
	 * @param string $new_value
	 * @param string $old_value
	 * @return void
	 */
	private function _setChanged($name, $new_value, $old_value)
	{
		if (substr($name, 0, 1) == '_') return;
		if($this->checkEditable($name)) {
			if($new_value != $old_value) {
				$this->_old_data[$name] = $old_value;
				$this->_new_data[$name] = $new_value;
			}
		}
	}

	/**
	 * [保护]返回修改过的值
	 * 
	 * @return array
	 */
	protected function _getChanged()
	{
		return $this->_new_data;
	}

	/**
	 * [保护]返回原来的值
	 * 
	 * @return array
	 */
	protected function _getOriginal()
	{
		return $this->_old_data;
	}

	/**
	 * internal set value only !!!
	 * 
	 * @param string $name | array
	 * @param string $value
	 * @return void
	 */
	protected function _set($name, $value = null)
	{
		if(is_array($name)) // init or load
		{
			foreach($name as $k => $v) {
				$this->_initSet($k, $v);
			}
		}
		elseif(is_string($name)) {
			$this->_initSet($name, $value);
		}
		return true;
	}

	/**
	 * init set data value
	 * 
	 * @param string $name
	 * @param mixed $value
	 * @return void
	 */
	private function _initSet($name, $value)
	{
		$_name = '_'.$name;
		if (property_exists($this, $_name)) {
			$this->$_name = $value;
		}else{
		  $this->_data[$name] = $value;
        }
	}

	/**
	 * 返回这个类是否为有效的类，以Id>0 且条目数多于1 为条件
	 * 
	 * @return boolean
	 */
	public function valid()
	{
		return $this->id > 0 && count($this->_data) > 1;
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	protected function clear()
	{
		unset($this->_data);
	}

	/**
	 * 根据 id 返回用来在 Cache 中使用的本类的 键名
	 * 
	 * @param int $id
	 * @return string
	 */
	public function getKey()
	{
		return get_class($this) . '_' . $this->id;
	}

	/**
	 * 根据 id 返回数据行，一般是数据库
	 * 
	 * @param mixed $id, int or string
	 * @param string $key
	 * @return array
	 */
	abstract protected function _getRow($id, $key = 'id');

	/**
	 * 检查某个字段是否可编辑
	 * 
	 * @param string $name
	 * @return void
	 */
	public function checkEditable($name)
	{
		return in_array($name, $this->_editables);
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	protected function setEditable($name, $alias = null)
	{
		if(is_array($name)) {
			$this->_editables = array_merge($this->_editables, $name);
		}
		else {
			if(is_null($alias)) $alias = $name;
			$this->_editables[$name] = $alias;
		}
	}

	/**
	 * implements ArrayAccess
	 * 
	 * @param string $offset
	 * @return boolean
	 */
	public function offsetExists($offset)
	{
		return $this->__isset($offset);
	}

	/**
	 * implements ArrayAccess
	 * 
	 * @param string $offset
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->__get($offset);
	}

	/**
	 * implements ArrayAccess
	 * 
	 * @param string $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet($offset, $value)
	{
		$this->__set($offset, $value);
	}

	/**
	 * implements ArrayAccess
	 * 
	 * @param string $offset
	 * @return void
	 */
	public function offsetUnset($offset)
	{
		$this->_unset($offset);
	}
	
	
	protected static function _genKey($id, $col = 'id')
	{
		return '_'.$col.$id;
	}
	
	// Serializable
    public function serialize() {
        return serialize($this->_data);
    }
	
	// Serializable
    public function unserialize($data) {
        $this->_data = unserialize($data);
    }
	
}


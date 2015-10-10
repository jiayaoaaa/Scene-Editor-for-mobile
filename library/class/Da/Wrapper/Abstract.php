<?php
/**
 *  数据库访问的包装类的基类（虚类）
 *
 * @version $Id$
 * @created 13:30 2010-04-21
 */

/**
 * Da_Wrapper_Abstract
 */
abstract class Da_Wrapper_Abstract
{
	protected $_ns;
	protected $_db;
	protected $_table;
	protected $_where = array();
	protected $_custom_where = array();
	private $_input_params;
	protected $_operate;
	protected $_limit = 0;
	protected $_offset = 0;
	protected $_dbh;
	protected $_table_key;
	protected $_cache_key;
	protected $_pk_name;
	protected $_pk_value;

	private $_cacheobj;
	private $_cachable = true;

	/**
	 * function description
	 *
	 * @return this
	 */
	public static function select()
	{
		$obj = new Da_Wrapper_Select();
		return $obj;
	}

	/**
	 * function description
	 *
	 * @return this
	 */
	public static function update()
	{
		$obj = new Da_Wrapper_Write('UPDATE');
		return $obj;
	}

	/**
	 * function description
	 *
	 * @return this
	 */
	public static function insert()
	{
		$obj = new Da_Wrapper_Write('INSERT');
		return $obj;
	}

	/**
	 * function description
	 *
	 * @return this
	 */
	public static function delete()
	{
		$obj = new Da_Wrapper_Write('DELETE');
		return $obj;
	}

	/**
	 * function description
	 *
	 * @return this
	 */
	public function table($table_key)
	{
        $arr = explode(".", $table_key, 4);
        $avgc = count($arr);
        if($avgc == 3){
            array_splice($arr, 2, 0, array(null));
        }
        list($this->_ns,  $this->_db, $schema, $node) = $arr;
        $this->_table = ($schema ? $schema . '.' : '') . $node;
		$this->_table_key = $table_key;
		$this->_cache_key = null;
		return $this;
	}

	/**
	 * function description
	 *
	 * @return this
	 */
	public function where()
	{
		$argc = func_num_args();
		$argv = func_get_args();
		if($argc > 0) {
			if(is_array($argv[0])) {
				foreach($argv[0] as $key => $val) {
					$this->_where[$key] = array('=', $val);
				}
			} elseif($argc > 1) {
				$col = $argv[0];
				if(is_array($argv[1]) && in_array($argv[1][0], array('IN','BETWEEN'))) {
					$op = array_shift($argv[1]);
					$val = $argv[1];
				} elseif($argc == 2) {
					$op = '=';
					$val = $argv[1];
				} elseif($argc > 2 && is_string($argv[1])) {
					$op = $argv[1];
					$val = $argv[2];
				}
				if (in_array($op, array('IN','BETWEEN'))) {
					if (is_array($val)) {
						$len = count($val);
						if ($len === 0) {
							unset($val);
						}
						if ($len === 1) {
							$op = '=';
							$val = $val[0];
						}
					} else {
						unset($val);
					}
				}
                if(!isset($val)){
                    $val = 0;
                    $date = date("Ymd");
                    error_log(date("H:i:s").'danger: condition is null' . $col . $op."\n", 3, LOG_ROOT . "sp_danger_$date.log");
                }
				if ($col && $op && isset($val)) $this->_where[$col] = array($op, $val);
			} elseif ($argc == 1 && is_string($argv[0])) {
				$this->_custom_where[] = $argv[0];
			}
		}
		$this->_cache_key = null;
		return $this;
	}


	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function getParams()
	{
		return $this->_input_params;
	}
	protected function setParams($arr) {
		if(is_array($this->_input_params))
			$this->_input_params = array_merge($this->_input_params, $arr);
		else $this->_input_params = $arr;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function genWhere()
	{
		//Sp_Log::debug('genWhere: '.print_r($this->_where, true));
		$where = '';
		if(is_array($this->_where)) {
			$tmp = '';
			foreach($this->_where as $key => $val) {
				//if(!is_array($val)) continue;
				if(is_array($val[1]) && !empty($val[1])) {
					if (in_array($val[0], array('IN', 'NOT IN'))) {
						$slag = ''; $_t = '';
						foreach($val[1] as $k => $v) {
							$slag .= $_t . (is_int($v) || is_float($v) ? $v : $this->getDbh()->quote($v));
							$_t = ',';
						}
						$where .= "$tmp$key $val[0] ($slag)";
					}
					elseif ($val[0] == 'BETWEEN') {
						$where .= sprintf("%s%s BETWEEN :%s AND :%s", $tmp, $key, $key.'1', $key.'2');//" $tmp $key $val";
						$this->_input_params[$key.'1'] = $val[1][0];
						$this->_input_params[$key.'2'] = $val[1][1];
					}

				}
				elseif ($val[0] == '@@') // 全文搜索匹配
				{
					$where .= sprintf("%s%s %s %s", $tmp, $key, $val[0], $val[1]);
				}
				else { // $val[0]: =, like, !=, >, <, ...
					$where .= sprintf("%s%s %s :%s", $tmp, $key, $val[0], $key);//" $tmp $key $val";
					$this->_input_params[$key] = $val[1];
				}
				$tmp = ' AND ';
			}
		}
		if (count($this->_custom_where) > 0) {
			$where .= $tmp . implode(' AND ', $this->_custom_where);
		}

		return !empty($where) ? ' WHERE '.$where : '';
	}



	/**
	 * 返回 Cache 对象
	 *
	 * @return object
	 */
	protected function getCacheInstance()
	{
		if($this->_cacheobj === null)
		{
			$this->_cacheobj = Cache_Memcache::getInstance();
		}
		return $this->_cacheobj;
	}

	/**
	 * 内部调用 Cache->get
	 *
	 * @param string $key
	 */
	protected function cacheGet($key) {
		if ($this->_cachable && $cache = $this->getCacheInstance()) {
			return $cache->get($key);
		}
		return FALSE;
	}

	/**
	 * 内部调用 Cache->set
	 *
	 * @param string $key
	 * @param mixed $var
	 * @param int $expire
	 */
	protected function cacheSet($key, $var, $expire){
		if ($this->_cachable && $cache = $this->getCacheInstance())
			return $cache->set($key, $var, $expire);
	}

	/**
	 * 内部调用 Cache->delete
	 *
	 * @param string $key
	 */
	protected function cacheRemove($key){
		if ($this->_cachable && $cache = $this->getCacheInstance())
			return $cache->delete($key);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function getRowByPk($id)
	{
	//	$key =
	//	$row = $this->cacheGet()
		return ;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function getMinLifetime()
	{
		$ret = Da_Wrapper::configValue('dc', $this->_ns, $this->_db, $this->_table, ':min_lifetime');
		return $ret;
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function getLifetime()
	{
		$ret = Da_Wrapper::configValue('dc', $this->_ns, $this->_db, $this->_table, ':lifetime');
		return $ret;
	}

	protected function getTablePkName()
	{
		return Da_Wrapper::configValue('dc', $this->_ns, $this->_db, $this->_table, ':primary_key');
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	protected function getDbh()
	{
		if($this->_dbh == null) $this->_dbh = Da_Wrapper::dbo($this->_table_key);
		return $this->_dbh;
	}

}
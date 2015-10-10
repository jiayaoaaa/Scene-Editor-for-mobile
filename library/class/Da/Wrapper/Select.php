<?php
/**
 *  数据库访问的包装类
 *
 * @version $Id$
 * @created 13:30 2010-04-21
 */

/**
 * Da_Wrapper_Select
 */
class Da_Wrapper_Select extends Da_Wrapper_Abstract
{
	private static $all_cache;
	private $_cols;
	private $_orders;
	private $_total;
	private $_groups;
	
	const FUNC_ONE = 0;
	const FUNC_COL = 1;
	const FUNC_ROW = 2;
	const FUNC_ALL = 3;
	const FUNC_TAL = 4;
	
	/**
	 * constructor
	 * 
	 * @return self
	 */
	protected function __construct()
	{
		$this->_operate = 'SELECT';
	}

	/**
	 * set SELECT
	 * 
	 * @return this
	 */
	public function columns()
	{
		$argc = func_num_args();
		$argv = func_get_args();
		if($argc > 0) {
			if(is_array($argv[0])) {
				$this->_cols = $argv[0];
			} else {
				$this->_cols = $argv;
			}
		}
		return $this;
	}
	
	/**
	 * set ORDER BY
	 * 
	 * @param mixed $orderby
	 * @return object this
	 */
	public function orderby()
	{
		$argc = func_num_args();
		$argv = func_get_args();
		if($argc == 1 && is_array($argv[0])) $this->_orders = $argv[0];
		elseif($argc > 0) {
			$this->_orders = $argv;
		}
		$this->_cache_key = null;
		return $this;
	}

	/**
	 * set GROUP BY
	 * 
	 * @param mixed $groupby
	 * @return void
	 */
	public function groupby()
	{
		$argc = func_num_args();
		$argv = func_get_args();
		if($argc == 1 && is_array($argv[0])) $this->_groups = $argv[0];
		elseif($argc > 0) {
			$this->_groups = $argv;
		}
		$this->_cache_key = null;
		return $this;
	}
	
	/**
	 * set LIMIT
	 * 
	 * @param int $limit
	 * @param int $offset
	 * @return object this
	 */
	public function limit($limit, $offset = 0)
	{
		$this->_limit = $limit;
		$this->_offset = $offset;
		$this->_cache_key = null;
		return $this;
	}
	
	/**
	 * function description
	 * 
	 * @return void
	 */
	public function getTotal()
	{
		if($this->_total == null) $this->_total = $this->getDoSth(true)->fetchColumn(0);
		return $this->_total;
	}
	
	
	/**
	 * 分页查询
	 * 
	 * @param int $limit
	 * @param int $offset
	 * @param int $total
	 * @return array
	 */
	public function getPage($limit = 10, $offset = 0, & $total = 0)
	{
		$num_args = func_num_args();
		if($num_args >= 3) {
			$total = $this->getTotal();
		}
		if($offset > $total) $offset = 0;
		$this->limit($limit, $offset);
		
		return $this->getAll();
	}
	
	/**
	 * function description
	 * 
	 * @return array
	 */
	public function getAll($fetch_style = PDO::FETCH_ASSOC)
	{
		$sth = $this->getDoSth();
		if($sth) {
			return $sth->fetchAll($fetch_style);
		}
		return false;
	}

	/** 
	 * 返回第一行作为一个数组
	 *
	 */
	public function getRow($fetch_style = PDO::FETCH_ASSOC)
	{
		$sth = $this->getDoSth();
		if($sth) {
			return $sth->fetch($fetch_style);
		}
		return false;
	}

	/** 
	 * 返回第一行第一列的值
	 *
	 */
	public function getOne()
	{
		return $this->_getData(self::FUNC_ONE);
	}

	/** 
	 * 返回第一行第一列的值
	 *
	 */
	public function getCol()
	{
		return $this->_getData(self::FUNC_COL);
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	private function _getData($func)
	{
		switch($func) {
			case self::FUNC_ONE:
				return $this->getDoSth()->fetchColumn(0);
			break;
			case self::FUNC_COL:
				return $this->getDoSth()->fetchAll(PDO::FETCH_COLUMN, 0);
			break;
			case self::FUNC_ROW:
				return $this->getDoSth()->fetch(PDO::FETCH_ASSOC);
			break;
			case self::FUNC_ALL:
				return $this->getDoSth()->fetchAll(PDO::FETCH_ASSOC);
			break;
			case self::FUNC_TAL:
				return $this->getDoSth(true)->fetchColumn(0);
			break;
			default:
				throw new InvalidArgumentException("invalid func value");
			break;
		}
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	private function getDoSth($count = false)
	{
		$sql = $this->genSql($count);
		Sp_Log::debug(__CLASS__ . '->'. __FUNCTION__ .': '.$sql);
		$dbh = $this->getDbh(); //var_dump($dbh);
		$input_parms = $this->getParams(); //var_dump($input_parms);
		if(is_array($input_parms) && count($input_parms) > 0) {
			$sth = $dbh->prepare($sql);
			$ret = $sth->execute($input_parms);
			if(!$ret) {
				Sp_Log::warning(__CLASS__ . '->'. __FUNCTION__ .' execute: '.print_r($sth->errorInfo(), true));
			}
		} else {
			$sth = $dbh->query($sql);
			if(!$sth){
				Sp_Log::warning(__CLASS__ . '->'. __FUNCTION__ .' query: '.print_r($dbh->errorInfo(), true));
			}
		}
		if(!$sth) {
			Sp_Log::warning(__CLASS__ . '->'. __FUNCTION__ . ' table : ' . $this->_table . ', : ' . print_r($dbh->errorInfo(),true));
		}
		return $sth;
	}

	/**
	 * function description
	 * 
	 * @return void
	 */
	public function genSql($count = false)
	{
		$sql = $this->_operate . ' ';
		if($count) $sql .= 'COUNT(*)';
		else {
			if(!is_array($this->_cols) || count($this->_cols) == 0) {
				$sql .= "*";
			} else {
				$sql .= implode(', ', $this->_cols);
			}
		}
		$sql .= " FROM " . $this->_table;
		$sql .= $this->genWhere();
		if(!$count) {
			$sql .= $this->genGroup();
			$sql .= $this->genOrder();
			if($this->_limit > 0) $sql .= $this->genLimit();
		}
		return $sql;
	}
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function genLimit()
	{
		$driver_name = $this->getDbh()->getAttribute(PDO::ATTR_DRIVER_NAME);
		if($driver_name == 'pgsql') {
			return " LIMIT $this->_limit OFFSET $this->_offset";
		}
		return " LIMIT $this->_offset, $this->_limit";
	}
	
	/**
	 * function description
	 * 
	 * @return string
	 */
	public function genOrder()
	{
		if(is_array($this->_orders) && ($len = count($this->_orders)) > 0) {
			$sql = '';$tmp = '';
			for($i = 0; $i < $len; $i ++) {
				if(preg_match("#([a-z][a-z0-9_]+)(\s+(ASC|DESC))?#i", $this->_orders[$i])) {
					$sql .= $tmp . $this->_orders[$i];
					$tmp = ',';
				}
			}
			if(!empty($sql)) return ' ORDER BY '.$sql;
		}
		return '';
	}
	
	/**
	 * function description
	 * 
	 * @return void
	 */
	public function genGroup()
	{
		if(is_array($this->_groups) && count($this->_groups) > 0) {
			return ' GROUP BY '.implode(', ', $this->_groups);
		}
		return '';
	}
	
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function genCacheKey()
	{
		if($this->_cache_key == null) {
			$str = $this->_ns . '_' . $this->_db . '_' . $this->_table;
			if(is_array($this->_where)) {
				foreach($this->_where as $key => $val) {
					if($val[0] == 'IN' && is_array($val[1])){
						$str .= '_' . $key . '_' . implode('_', $val[1]);
					} else {
						$str .= sprintf("_%s_%s_%s", $key, ord($val[0]), $val[1]);
					}
					
				}
			}
			$this->_cache_key = $str;
		}
		return $this->_cache_key;
	}
	
}
<?php
/**
 *  数据库访问的包装类
 *
 * @version $Id$
 * @created 13:30 2010-04-21
 */

/**
 * Da_Wrapper_Operator
 */
class Da_Wrapper_Write extends Da_Wrapper_Abstract
{
	private $_row_data;
	
	/**
	 * constructor
	 * 
	 * @return self
	 */
	protected function __construct($operate)
	{
		$this->_operate = strtoupper($operate);
	}

	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function data($row)
	{
		$this->_row_data = $row;
		return $this;
	}
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function execute()
	{
		$sql = $this->genSql();
		$ret = false;
		Sp_Log::debug(__CLASS__ . '->'. __FUNCTION__ .': '.$sql);
		$dbh = $this->getDbh(); //var_dump($dbh);
		$input_parms = $this->getParams(); //var_dump($input_parms);
		if(is_array($input_parms) && count($input_parms) > 0) {
			$sth = $dbh->prepare($sql);
            //print_r($this->parms($sql,$input_parms));exit;
			if(!$sth) {
				Sp_Log::warning('table: ' . $this->_table_key . ',' . __CLASS__ . '->'. __FUNCTION__ .': '.print_r($sth->errorInfo(),true));
			}
			$ret = $sth->execute($input_parms);
			if($ret && in_array($this->_operate, array('UPDATE','DELETE')) ) {
				return $sth->rowCount();
			}
		} else {
			//echo $sql;
			$ret = $dbh->exec($sql);
		}
		if(!$ret) {
			Sp_Log::warning('table: ' . $this->_table_key . ',' . __CLASS__ . '->'. __FUNCTION__ .': '.print_r($dbh->errorInfo(),true));
			
		}
		if($ret && $this->_operate == 'INSERT' && $dbh->getAttribute(PDO::ATTR_DRIVER_NAME) == 'mysql') {
			$ret = $dbh->lastInsertId();
		}
		return $ret;
	}
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	public function genSql()
	{
		$sql = '';
		switch($this->_operate) {
			case 'INSERT':
				$cols = array_keys($this->_row_data);
				$sql = 'INSERT INTO '.$this->_table.'('.implode(',',$cols).') VALUES('.implode(',',$this->getColumnKeys($cols)).')';
				$this->setParams($this->_row_data);
				//var_dump($this->getParams());
			break;
			case 'UPDATE':
				$cols = array_keys($this->_row_data);
			//	var_dump($cols);
				$where = $this->genWhere();	// init input_params
				$params = $this->getParams();
				$str = ''; $tmp = '';
				foreach($cols as $key) {
					if(isset($params[$key])) {
						$key_new = $key . '_new';
						$this->_row_data[$key_new] = $this->_row_data[$key];
						unset($this->_row_data[$key]);
						
						$str .= $tmp . $key . ' = ' . ':' . $key_new;
					} else {
						$str .= $tmp . $key . ' = ' . ':' . $key;
					}
					$tmp = ',';
				}
				if(!empty($str)) {
					$sql = 'UPDATE '.$this->_table.' SET ' . $str . $where;
					$this->setParams($this->_row_data);
				}
			break;
			case 'DELETE':
				$sql = 'DELETE FROM '.$this->_table . $this->genWhere();
			break;
			
		}
		return $sql;
	}
	
	/**
	 * function description
	 * 
	 * @param
	 * @return void
	 */
	private function getColumnKeys($keys)
	{
		$arr = array();
		foreach($keys as $key ) {
			$arr[] = ':'.$key;
		}
		return $arr;
	}
	
    private function parms($string,$data) {
        $indexed=$data==array_values($data);
        foreach($data as $k=>$v) {
            if(is_string($v)) $v="'$v'";
            if($indexed) $string=preg_replace('/\?/',$v,$string,1);
            else $string=str_replace(":$k",$v,$string);
        }
        return $string;
    }
	
	
}
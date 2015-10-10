<?php

/**
 * Acl
 */
class Sp_Account_UniqueId extends Model_Abstract
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_USER = 'sp.huitong.ht_unique_id';
  	
  	
	
	/**
	 * constructor
	 *
	 * @param mixed $id
	 * @return void
	 */
	protected function __construct($id, $key = 'id'){
		$this->init($id, $key);
	}
    
    protected function _getRow($id, $key = 'id'){
		
		$select = Da_Wrapper::select()
			->table(self::DB_TABLE_USER)
			->columns('id', $key, 'userid', 'pwd','kid', 'mobile', 'email', 'status','regtime', 'regip','logintime', 'loginip', 'login_nums')
			->where($key, $id);
			
		return $select->getRow();
	}
	
	/**
	 * initFrom
	 *
	 * @param mixed $id
	 * @return void
	 */
	protected function init($id = 0, $key = 'id')
	{
		$field_login = explode(',', self::FIELD_LOGIN);
		if(is_array($id)) {
			$this->_unset('login');
			$this->_unset('name');
			$this->_set($id);
			foreach($field_login as $field) {
				if(isset($id[$field]) && $field != 'login') {
					$this->_set('login', $id[$field]);
					break;
				}
			}
            isset($id['name']) && $this->_set('realname', $id['name']);
		}elseif(is_int($id) || is_numeric($id) && $key == 'id') {
			$this->_set('id', intval($id));
			$id > 0 && $this->_set($this->_getRow($this->id, 'id'));
		}elseif(is_string($id) && !empty($id)) {	// default: key == 'login'
			if($key == 'login' || in_array($key, $field_login)) {
				$this->_set('login', $id);
				$this->_set($this->_getRow($id, $key));
			}
		}
		if($this->id < 1) {
			// not found
			$this->_unset('login');
			$this->_unset('name');
			if($_COOKIE[self::COOKIE_NAME]) {
				$this->_set('mind_login', base64_decode($_COOKIE[self::COOKIE_NAME]));
			}
		}
		$this->stateStored = false;
		$this->_key = $this->getKey();
	}
    
    public static function getUniqueId(){
        $row = array('tid'=>1);
        $ret = Da_Wrapper::insert()->table(self::DB_TABLE_USER)->data($row)->execute();        
        return $ret;
    }

}
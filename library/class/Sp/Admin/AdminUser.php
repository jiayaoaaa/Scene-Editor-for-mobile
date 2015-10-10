<?php

/**
 * Acl
 */
class Sp_Admin_AdminUser
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_ADMIN_USER = 'sp.yltouzi.admin_users';
	
	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function store($id = 0, $row = array())
	{
		if(count($row) < 1)
			return false;

		//set password
		if(!empty($row['password']))
		{
			 $current_user = Sp_Admin_Account::current();
			 $row['password'] = $current_user->hashPassword($row['username'], $row['password']);

		}
		else
		{
			unset($row['password']);
		}

		if(!$id) { // create
			$ret = Da_Wrapper::insert()->table(self::DB_TABLE_ADMIN_USER)->data($row)->execute();
		
		} else {
			$ret = Da_Wrapper::update()->table(self::DB_TABLE_ADMIN_USER)->data($row)->where('id', $id)->execute();
			if($ret > 0){
			  $ret = $id;
			}
 
		}
       
		return $ret;
	}




	/**
	 * function delete
	 * @param int $id
	 * @return boolean
	 */
	public static function deleteUser($id = 0)
	{
		$id = (int)$id;
		if($id < 1)
			return false;
		
		//delete role
		$ret =  Da_Wrapper::delete()
		->table(self::DB_TABLE_ADMIN_USER)
		->where('id',$id)
		->execute();
       
	    return $ret;
	}


	/**
	 * function getUserIfCanEdit
	 * @param int $id
	 * @return boolean
	 */
	public static function getUserRoleId($id = 0)
	{

		if($id < 1)
			return -1;
		$data = Da_Wrapper::select()
				->table(self::DB_TABLE_ADMIN_USER)
				->columns('role_id')
				->where('id','=',$id)
				->getOne();

		if(!isset($data) || empty($data))
			return -2;

		return  $data;
	}


	
	/**
	 * function getUserIfCanEdit
	 * @param int $id
	 * @return boolean
	 */
	public static function getUserById($id = 0,$column = '')
	{

		if($id < 1)
			return -1;

		if(empty($column))
		{
			$data = Da_Wrapper::select()
				->table(self::DB_TABLE_ADMIN_USER)
				->where('id','=',$id)
				->getRow();

			if(!isset($data) || empty($data))
				return -2;
		}
		else
		{
			$data = Da_Wrapper::select()
				->table(self::DB_TABLE_ADMIN_USER)
				->columns($column)
				->where('id','=',$id)
				->getOne();
		}

		return  $data;
	}
	

}
<?php

/**
 * Acl
 */
class Sp_City_City
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_CITY = 'sp.huitong.ht_citys';

	/**
	 * 
	 * 获得省份数据
	 * 
	 * @return array
	 */
	public static function getProvince()
	{
		$data = Da_Wrapper::select()
				->table(self::DB_TABLE_CITY)
				->where('type','1')
				->orderby('listorder asc')
				->getAll();
       
	    return $data;
	}
	
	/**
	 * 活动城市联动
	 * 
	 */
	public static function getChlidById($id = 0){
		$data = Da_Wrapper::select()
				->table(self::DB_TABLE_CITY)
				->where('parentid',$id)
				->orderby('listorder asc')
				->getAll();
       
	    return $data;
	}


}
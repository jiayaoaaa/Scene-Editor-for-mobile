<?php

/**
 * Acl活动操作类
 */
class Sp_Letter_Material
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_LETTER = 'sp.huitong.ht_letter_material';


	
	/**
	 * 添加邀请函
	 */
	public static function add($row){
		if(empty($row['crttime'])){
			$row['crttime'] = time();
		}
		$data = Da_Wrapper::insert()
				->table(self::DB_TABLE_LETTER)
				->data($row)
				->execute();
       
	    return $data;
	}
	

}
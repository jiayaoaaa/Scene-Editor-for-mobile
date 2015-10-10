<?php

/**
 * Acl活动操作类
 */
class Sp_Letter_Letter
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_LETTER = 'sp.huitong.ht_letter';


	
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
	/**
	 * 
	 */
	public static function save($id,$row){
		$data = Da_Wrapper::update()
				->table(self::DB_TABLE_LETTER)
				->data($row)
				->where("id",$id)
				->execute();
		return $data;
	}
	/**
	 * 获得单条邀请函数据
	 */
	public static function getLetterById($id,$user_id = 0){
		$db = Da_Wrapper::select()
				->table(self::DB_TABLE_LETTER)
				->where("id",$id)
				->where("status","!=",-1);
		
		if($user_id > 0){
			$db = $db->where('user_id',$user_id);
		}
		$data = $db->getRow();
		return 	$data;	
	}

	/**
	 * 用户分页数据
	 * @param int $userid 用户id
	 * @param int $limit 过滤条数
	 * @param int $pageSize 分页大小
	 */
	public static function getListByUser($userid, $aid,$limit, $offset = 10) {
		$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_LETTER)
				->where('user_id','=',$userid)
				->where('active_id','=',$aid)
				->where('status','>',-1)
				->limit($offset,$limit)
				->getAll();
	
		return $ret;
	}
	
	/**
	 * 获得用户数据总数
	 * @param int $userid 用户id
	 */
	public static function getTotalByUser($userid,$aid){
		$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_LETTER)
				->where('status','>',-1)
				->where('user_id','=',$userid)
				->where('active_id','=',$aid)
				->getTotal();
		return $ret;
	}
	
	
	/**
	 * 根据主键删除活动
	 * 
	 * @param string|array $key 主键
	 */
	public static function delByPrimarykey($id,$user_id = 0){
		$db = Da_Wrapper::update()
				->table(self::DB_TABLE_LETTER)
				->data(array('status'=>-1))
				->where('id', $id);
		
		if($user_id > 0){
			$db = $db->where('user_id',$user_id);
		}
		
		$data = $db->execute();
		return $data;
	}
	
	/**
	 * 获取报名条件
	 */
	public static function getLimitByLetterId($Id){
		$colunms = "b.is_enroll,b.is_audit,b.enroll_start,b.enroll_end,b.enroll_num,b.isdel,b.id";
        $sql = "select ".$colunms." from ht_letter a left join ht_active b on a.active_id = b.id where a.id='{$Id}'";
	
        $data = Da_Wrapper::getRow(self::DB_NS,$sql);
		return $data;
	}
	/**
	 * 获取当前参会人的人数
	 */
	public static function getCurrentNum($Id){
		return Da_Wrapper::select()->table("sp.huitong.ht_apply_data")->where(array("activeId"=>$Id))->getTotal();
	}
	
}
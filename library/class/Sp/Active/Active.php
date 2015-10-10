<?php

/**
 * Acl活动操作类
 */
class Sp_Active_Active
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_ACTIVE = 'sp.huitong.ht_active';


	
	/**
	 * 添加活动
	 */
	public static function add($row){
		if(empty($row['crttime'])){
			$row['crttime'] = time();
		}
		
		$data = Da_Wrapper::insert()
				->table(self::DB_TABLE_ACTIVE)
				->data($row)
				->execute();
       
	    return $data;
	}
	/**
	 * 通过id修改对应的活动
	 * @param int $id 活动id
	 * @param array $row 修改的数据
	 * @param int $user_id 用户id
	 * 
	 */
	public static function updateById($id,$row,$user_id = 0){
		$db = Da_Wrapper::update()
				->table(self::DB_TABLE_ACTIVE)
				->data($row)
				->where('id', $id);
				
		if($user_id > 0){
			$db = $db->where('user_id',$user_id);
		}
		$ret = $db->execute();
		return $ret;
	}
	
	/**
	 * 获得单行数据
	 */
	public static function getActiveById($id,$user_id = 0){
		$db = Da_Wrapper::select()
				->table(self::DB_TABLE_ACTIVE)
				->where("id",$id)
				->where("isdel",0);
		
		if($user_id > 0){
			$db = $db->where('user_id',$user_id);
		}
		$data = $db->getRow();
		return 	$data;	
	}
	
	/**
	 * 得到用户数据条数
	 * @param int $userid 用户id
	 */
	public static function getUserActiveCount($userid, $condition = '1=1') {
		$count = Da_Wrapper::getOne(self::DB_TABLE_ACTIVE, 
			"select count(*) as c from {active} where user_id = {$userid} and {$condition}");
			
		return $count;
	}
	
	/**
	 * 用户分页数据
	 * @param int $userid 用户id
	 * @param string $condition where 条件
	 * @param int $limit 过滤条数
	 * @param int $pageSize 分页大小
	 */
	public static function getListByUser($userid, $condition, $limit, $pageSize = 10) {
		$sql = "select a.*,p.name as provinceName,c.name as cityName,e.name as arreaName  from ht_active a 
				left join ht_citys p on p.id = a.province
				left join ht_citys c on c.id = a.city
				left join ht_citys e on e.id = a.arrea
				where a.user_id = {$userid} and {$condition} order by id desc limit {$limit}, {$pageSize}";
		
		$data = Da_Wrapper::getAll(self::DB_NS, $sql);
		return $data;
	}
	
	/**
	 * 得到分页字符串
	 * @param int $userid 用户id
	 * @param int $nowPage 当前第几页
	 * @param int $pageSize 分页大小
	 */
	public static function getPageString($userid, $nowPage, $pageSize = 10,$where = '1=1') {
		$total = self::getUserActiveCount($userid,$where);
		$pager = new Util_Pager($total, $nowPage, $pageSize);
		$pageString = $pager->renderNav(true);
		
		return $pageString;
	}
	
	/**
	 * 根据主键删除活动
	 * 
	 * @param string|array $key 主键
	 */
	public static function delByPrimarykey($key) {
		$ids = $key;
		if(is_array($key)) {
			$ids = implode(',', $key);
		}
		
		$data = Da_Wrapper::execute(self::DB_TABLE_ACTIVE, 
			"update {active} set isdel = 1 where id in ({$ids})");
			
		return $data;
	}

}
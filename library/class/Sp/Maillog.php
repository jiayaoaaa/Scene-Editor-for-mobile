<?php
/**
 * Dictionary
 *
 * @author 
 * @version $Id$
 * @created 18:18 2014-03-13
 * @�ʼ�������־
 */

/**
 * Acl
 */
class Sp_Maillog
{
	const DB_NS = 'sp.yltouzi';
	const DB_TABLE_LOG = 'sp.yltouzi.email_log';

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public static function getAll($filter = array())
	{
		global $g_timer;
		isset($g_timer) && $g_timer->setMarker('mail_log getAll start');
		if($filter['user_id'] > 0) {
			
		}
		$sql = "SELECT * FROM mail_log";
		$data = Da_Wrapper::getAll(self::DB_NS, $sql);
		return $data;
	}

	public static function add($uid, $type)
	{
		$info['type'] = $type;
		$info['user_id'] = $uid;
		$info['addtime'] = time();
		$ret = Da_Wrapper::insert()->table(self::DB_TABLE_LOG)->data($info)->execute();
		return $ret;
	}

	public static function last($uid, $type)
	{
		$ret = Da_Wrapper::select()
			->table(self::DB_TABLE_LOG)
			->columns('addtime')
			->where('user_id',$uid)
			->where('type',$type)
			->orderby('id DESC')
			->getOne();
		return $ret;
	}
}
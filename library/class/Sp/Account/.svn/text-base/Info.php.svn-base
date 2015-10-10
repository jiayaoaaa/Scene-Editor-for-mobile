<?php
/**
 * 修改信息
 *
 * @author yu
 */
class Sp_Account_Info extends Sp_Account_User
{
	const DB_NS = 'sp.huitong';
	const DB_TABLE_USER = 'sp.huitong.ht_users';

	/**
	 * 修改用户信息
	 *
	 * @param int $userid 用户 id
	 * @param array $row 修改的数据
	 */
	public static function updateUser($userid, & $row) {
		$rs = Da_Wrapper::update()->table(self::DB_TABLE_USER)
			->data($row)->where('id', $userid)->execute();
			
		return $rs;
	}
	
	/**
	 * 修改用户密码
	 *
	 * @param int $userid 用户 id
	 * @param string $pwd 密码
	 */
	public static function updatePassword($userid, $pwd) {
		$data = array('pwd'=>$pwd);
		$rs = Da_Wrapper::update()->table(self::DB_TABLE_USER)
			->data($data)->where('id', $userid)->execute();
			
		return $rs;
	}
}
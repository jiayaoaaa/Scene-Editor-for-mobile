<?php
/**
 * Admin_Menu
 */

/**
 * Acl
 */
class Sp_Payment_Paybank
{
	const DB_NS = 'sp.yltouzi';
	const DB_TABLE_PAYMENT = 'sp.yltouzi.payment';
	const DB_TABLE_BANK = 'sp.yltouzi.bank';
	const DB_TABLE_BANK_PAYMENT = 'sp.yltouzi.bank_payment';
	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
   public static function getAllPayment($page = 1, $offset = 10, $orderby=' psort DESC', $type='payment', $ispage=true)
	{   
		$limit = '';
		if($ispage){
		   $limit = ' limit '.($page-1)*$offset.','.$offset;
		}
		$sql = "SELECT * FROM ".$type." order by ".$orderby.$limit;
		$data = Da_Wrapper::getAll(self::DB_NS,$sql);
			    
		return $data;
	}
   
    /**
	 * 获取数据总条数
	 * @param	string		$where 
	 */
	public static function getTotal($type='payment',$where=''){
        $table = $type == 'payment' ? 'payment' : 'bank';
		$where = !empty($where) ? ' where '.$where : '';
		$sql = "SELECT count(*) as num FROM ".$table.$where;
		$ret = Da_Wrapper::getRow(self::DB_NS,$sql);
		return $ret['num'];
	}

	/**
	 * 修改第三方支付/银行
	 *
	 * @param array
	 * @return int
	 */
	public static function updateinfo($row,$id,$type='payment')
	{
		if($type == 'payment'){
		   $table = self::DB_TABLE_PAYMENT;
		}elseif($type == 'bank'){
		   $table = self::DB_TABLE_BANK;
		}
		if (is_array($row)){
			$res = Da_Wrapper::update()
				->table($table)
				->data($row)
				->where('id',$id)
				->execute();
		}
		return $res;
	}

	public static function insertInfo($row,$type='payment')
	{
		if($type == 'payment'){
		   $table = self::DB_TABLE_PAYMENT;
		}elseif($type == 'bank'){
		   $table = self::DB_TABLE_BANK;
		}else{
		   $table = self::DB_TABLE_BANK_PAYMENT;
		}
		if (is_array($row)){
			$ret = Da_Wrapper::insert()
				->table($table)
				->data($row)
				->execute();
		}

		if($ret && $type == 'payment'){
		   $banks = self::getAllPayment('','','bsort DESC','bank',false);
		   foreach($banks as $k=>$v){
		      $info = array(
			    'bank_id'=>$v['id'],
			    'pay_id'=>$ret
			  );
             self::insertInfo($info,'bank_pay');
		   }
		}
		return $ret;
	}

	public static function updatebankpayment($row,$pid,$bid)
	{
		
		if (is_array($row)){
			$res = Da_Wrapper::update()
				->table(self::DB_TABLE_BANK_PAYMENT)
				->data($row)
				->where('bank_id',$bid)
				->where('pay_id',$pid)
				->execute();
		}
		return $res;
	}

	public static function getallbankpayment()
	{
		$sql = "select * from bank_payment";
		return Da_Wrapper::getAll(self::DB_TABLE_PAYMENT,$sql);
	}
   
  
	public static function getBankPayment($where=""){
		
		$sql = "SELECT * FROM `bank_payment`".$where;
		$ret = Da_Wrapper::getAll(self::DB_NS,$sql);
		return $ret;
	}

	public static function checkpayment($where=""){
		
		$sql = "SELECT * FROM `payment`".$where;
		$ret = Da_Wrapper::getRow(self::DB_NS,$sql);
		return $ret;
	}

	//获取银联支付
	public static function getpaybank($where="",$isAll=1){
		if($isAll > 0){
		    $sql = "SELECT b.*,p.pay_type FROM `bank` as b left join bank_payment as p on b.id = p.bank_id where b.p_id = p.pay_id".$where." order by bsort ASC";
			$ret = Da_Wrapper::getAll(self::DB_NS,$sql);
		}else{
		    $sql = "SELECT b.* FROM `bank` as b left join bank_payment as p on b.id = p.bank_id where b.p_id = p.pay_id".$where;
			$ret = Da_Wrapper::getRow(self::DB_NS,$sql);
		}
		return $ret;
	
	}

	//
	public static function getpayment($where="",$isAll=1){
		if($isAll > 0){
		    $sql = "SELECT * FROM `payment` ".$where;
			$ret = Da_Wrapper::getAll(self::DB_NS,$sql);
		}else{
		    $sql = "SELECT * FROM `payment` ".$where;
			$ret = Da_Wrapper::getRow(self::DB_NS,$sql);
		}
		return $ret;
	
	}
	
}
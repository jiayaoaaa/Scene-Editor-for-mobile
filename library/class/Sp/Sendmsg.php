<?php
/**
 * @description 发送公共类
 */
class Sp_Sendmsg{ 
	
    private static $key = 'niphudatrwaergasddf';
    private static $secret = 'fwgkjijqlwfagqero%p';
	
	const DB_TABLE_MSM = 'sp.huitong.ht_sms_report';
	
	/**
	 * @param $phone 手机号
	 * @param $content 发送信息
	 */
    public static function sendPhone($phone, $content)
    {
    	//使用会通短信通道
        $s = new Util_SMS(self::$key, self::$secret, SMS_HTH);
        $s->setMobile($phone);
        $s->setContent($content);
        return $s->send();
    }
	
	/**
	 * @param $email 邮箱
	 * @param $content 发送信息
	 */
	public static function sendEmail($username,$content,$title = '会通短信通知'){
        //发送邮箱
        $email = new Util_Email();
        $sms = array(
        			'title'=>$title,
			        'email' => $username,
			        'content' => $content);
				
        return $email->sendEmail($sms);
	}
	/**
	 * 
	 * @param $username 手机号 OR 邮箱
	 * @param $type     发送类型repwd(修改密码) 
	 * @param $code   验证码
	 */
	public static function send($condition){
		
		if (!is_array($condition)) return FALSE;
		
		extract($condition, EXTR_SKIP);
		
		if(empty($type) || empty($content) || empty($username))  return FALSE;
		
		//记录日志表
        $request = Request::current();
	   
	    $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
		$patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
		$row =  array(
		            'sms_id' =>$type,
		            'content' => $content,
		            'ip' => $request->getIp(),
		            'crttime' => time()
		        );
				
		//邮箱发送	
	    if(preg_match($patternEmail,$username)){
	    	$row['email'] = $username;
			self::sendEmail($username, $content);
	    } 
		
		//手机发送	
	    if(preg_match($patternMobile,$username)){
			$row['phone'] = $username;
			self::sendPhone($username, $content);
		}
		
		//验证码
		if(!empty($code)){
			$row['code'] = $code;
		}
		//用户id
		if(!empty($user_id)){
			$row['user_id'] = $user_id;
		}
		
		$ret = Da_Wrapper::insert()
				->table(self::DB_TABLE_MSM)
				->data($row)
				->execute();
	    return $ret;
	}
	
	/**
	 * 通过手机获得最新一条短信数据
	 * @param $phone 手机号
	 */		
    public static function getSmsByPhone($phone,$sms_id){
    	$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_MSM)
				->where('phone',$phone)
				->where('sms_id',$sms_id)
				->orderby('id desc')
				->getRow();
		return $ret;		
    }   
    /**
	 * 通过手机获得当天的条数
	 * @param $phone 手机号
	 * @param $type 
	 */
	public static function getSmsByPhoneCount($phone,$sms_id){
		$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_MSM)
				->where('phone',$phone)
				->where('sms_id',$sms_id)
				->where('crttime ','>=',strtotime(date('Y-m-d',time())." 00:00:01"))
				->where('crttime','<=',strtotime(date('Y-m-d',time())." 23:59:59"))
				->getTotal();
		return $ret;
	}
	
	/**
	 * 通过邮箱获得当天的条数
	 * @param $email 邮箱
	 * @param $type 
	 */
	public static function getSmsByEmailCount($email,$sms_id){
		$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_MSM)
				->where('email',$email)
				->where('sms_id',$sms_id)
				->where('crttime ','>=',strtotime(date('Y-m-d',time())." 00:00:01"))
				->where('crttime','<=',strtotime(date('Y-m-d',time())." 23:59:59"))
				->getTotal();
		return $ret;
	}
	
	/**
	 * 通过手机获得最新一条短信数据
	 * @param $email 邮箱
	 */		
    public static function getSmsByEmail($email,$sms_id){
    	$ret = Da_Wrapper::select()
				->table(self::DB_TABLE_MSM)
				->where('email',$email)
				->where('sms_id',$sms_id)
				->orderby('crttime desc')
				->getRow();
		return $ret;		
    }
    /*
     * editor by Carten
     * 验证Code是否有效
     */
    public static function authCode($account='',$code='',$type=''){
        $return = self::checkCode($account,$code,$type);
        if(1 !== $return){
            return $return;
        }
        
        $update = array(
            'phone'=>array(
                'update' => array('mobile_status'=>1),
                'where'  => array('mobile'=>$account)
            ),
            'email'=>array(
                'update' => array('email_status'=>1),
                'where'  => array('email'=>$account)
            )
        );
        
        $data['code'] = $code;
        $data['sms_id'] = $type;
        $data[$type] = $account;
        $time = time()-(15*60);
        if($userid = Da_Wrapper::select()->table(self::DB_TABLE_MSM)->columns('id')->where($data)->where("crttime >= $time")->getOne()){
            $reUpdate = Da_Wrapper::update()->table("sp.huitong.ht_users")->data($update[$type]['update'])->where($update[$type]['where'])->execute();
            $cache = Cache::factory();
            $key = 'user_'.$userid;
            $cache->delete($key);
            return $reUpdate ? 1: false;
        }else{
            return false;
        }
    }
    
    public static function checkCode($account,$code='',$type=''){
        $rules['phone'] = Sp_Dictionary::getOtherOption("patternMobile");
        $rules['email'] = Sp_Dictionary::getOtherOption("patternEmail");
        
        $msg['phone'] = "电话格式不正确";
        $msg['email'] = "邮箱格式不正确";
        $return = 1;
        $filter = array('phone','email');
        
        if(false == in_array($type,$filter)){
            $return = array("status"=>-100,"msg"=>"参数错误");
        }else if(FALSE == preg_match($rules[$type], $account)){
            $return = array("status"=>-101,"msg"=>$msg[$type]);
        }else if(6 !== strlen($code)){
            $return = array("status"=>-102,"msg"=>"验证码格式错误");
        }
        return $return;
    }
	
	

}

?>
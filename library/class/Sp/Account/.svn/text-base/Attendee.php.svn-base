<?php

class Sp_Account_Attendee extends Model_Abstract {
//class Sp_Account_Attendee {

    const DB_NS = 'sp.huitong';
    const DB_TABLE = 'sp.huitong.ht_apply_data';
    

    public function __construct($config) {
        $user = Sp_Account_User::current();
        $where = array(
            'id'        =>@$_REQUEST['activeId'],
            'user_id'   =>$user->id ? $user->id:$config 
        );
        if($where['id']){
            $result = Da_Wrapper::select()->table("sp.huitong.ht_active")->columns('id')->where($where)->getOne();
            if(false == $result){
                exit("参数错误");
            }
        }
    }
    /*
     * 参会人列表
     */
    public function AttendeeList($activeId='',$cloumns='',$where=array()){ 
        $where['activeId']=$activeId;
        $model = Da_Wrapper::select()->table(self::DB_TABLE)->columns($cloumns)->where($where)->where("status != -1");
        $total = $model->getTotal();
        $data = array('','');
        $size = 20;
        if($total !== 0){
            $page = $_GET['page'] ? $_GET['page']:1;
            $pager = new Util_Pager($total, $page, $size, "?page=%d&activeId=".$activeId);
            $offset = $pager->getOffset();
            $pager->setTotal($total);
            //$data[0] = $pager->renderNav();
             $data[0] = $pager->renderNav(true);
        }
        $data[1] = $model->orderby('applyTime desc')->limit($size,($page-1)*$size)->getAll();
        return $data;
    }
    /*
     * 获取表头
     * @activeId    活动ID
     */
    public function GetTableHeaderByActiveId($activeId = ''){
        if(!$activeId){
            return FALSE;
        }
        $sql = "select * from ht_apply_data_header where activeId = ?";        
        $dbo = Da_Wrapper::dbo('sp.huitong.ht_apply_data_header');
        $sth = $dbo->prepare($sql);
        $sth->execute(array($activeId));
        return $sth->fetchAll(2);
    }
    /*
     * 返回数组中指定的一列
     * 
     */
    public function getColumnFormArr($data,$column='',$key){
        if(version_compare(PHP_VERSION,'5.5.0','>=')){
            return array_column($data,$column,$key);
        }
        $i=0;
        foreach($data as $value){
            if($key){
                $return[$value[$key]] = $value[$column];
            }else{
                $return[$i] = $value[$column];
            }
            $i++;
        }
        return $return;
    }
    
    /*
     * 设置表头
     * @data    二维数组
     * return   boolean
     */
    public function setTableHeader($data=array()){
        if($data == false){
            return false;
        }
        foreach($data as $key => $value){
            $where['activeId'] = $value['activeId'];            
            $where['field'] = $value['field'];
            $id = Da_Wrapper::select()->table('sp.huitong.ht_apply_data_header')->columns('id')->where($where)->getOne();
            if($id){
                unset($value['activeId'],$value['field']);
                Da_Wrapper::update()->table('sp.huitong.ht_apply_data_header')->data($value)->where($where)->execute();
            }else{
                Da_Wrapper::insert()->table('sp.huitong.ht_apply_data_header')->data($value)->execute();
            }
        }
        return true;
    }
    
    public static function add($data=array()){
        $where = array(
            'activeId'  => $data['activeId'],
            'phone'     => $data['phone'],
            'email'     => $data['email']
        );
        $repertory = Da_Wrapper::select()->table(self::DB_TABLE)->columns(array('id','status'))->where($where)->getRow();
        if(false === $repertory){
            return Da_Wrapper::insert()->table(self::DB_TABLE)->data($data)->execute();
        }else if( -1 == $repertory['status']){
            $update=array_diff($data,$where);
            $update["applyTime"] = time();
            $update["status"]    = 0;
            return Da_Wrapper::update()->table(self::DB_TABLE)->data($update)->where($where)->execute();
        }else if(0 == $repertory['status']){
            return -2;
        }else if(1 == $repertory['status']){
            return -3;
        }
        return -4;
        /*try{
            $id = Da_Wrapper::insert()->table(self::DB_TABLE)->data($data)->execute();
        }catch(PDOException $e){
            $id = 2;
        }
        return $id;*/
    }
    /*
     * 参会人上传日志
     */
    public static function uploadLog($data=array()){
        return Da_Wrapper::insert()->table("sp.huitong.ht_apply_upload_log")->data($data)->execute();
    }
    
    public function signAndDelete($data = array(),$status=''){
        $filter = array(0,1,-1);
        if(!in_array($status,$filter)){
            return false;
        }
        $update = array(
            'status'    =>  intval($status)
        );
        foreach($data as &$value){
            intval($value);
            Da_Wrapper::update()->table("sp.huitong.ht_apply_data")->data($update)->where("id = $value")->execute();
        }
        return true;
    }
    /*
     * 为API获取参会人
     */
    public function getAttendeeListForApi($activeId='',$pageSize=20,$page=0){
        $where['activeId']=$activeId;
        $offset = $page*$pageSize;
        $model = Da_Wrapper::select()->table(self::DB_TABLE)->where($where)->where("status != -1");
        $count = $model->getTotal();
        $data = $model->orderby('firstChater asc,applyTime desc')->limit($pageSize,$offset)->getAll();
        return array($count,$data);
    }
    
    public function _getRow($id, $key = 'id') {
        
    }
    /**
	 * 通过参会人id获得参会人
	 */
	public static function getAttendeeById($id){
		$row = Da_Wrapper::select()->table(self::DB_TABLE)->where("id",$id)->getRow();
		return $row;
	}
	
	
	 /**
	 * 通过签到码获得参会人
	 */
	public static function getAttendeeBySn($signId){
		$row = Da_Wrapper::select()->table(self::DB_TABLE)->where("signId",$signId)->getRow();
		return $row;
	}
	
	
	/**
	 * 拒绝参会人
	 */
	public static function refuse($id){
		$ret = Da_Wrapper::update()->table(self::DB_TABLE)->data(array("checkStatus"=>2))->where("id",$id)->execute();
		return $ret;
	}
	/**
	 * 设置审核成功
	 */
	public static function success($id){
		$ret = Da_Wrapper::update()->table(self::DB_TABLE)->data(array("checkStatus"=>1))->where("id",$id)->execute();
		return $ret;
	}
}

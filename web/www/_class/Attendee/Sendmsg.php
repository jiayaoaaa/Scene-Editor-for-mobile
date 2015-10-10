<?PHP
/**
 * 发送参会人信息
 */
class Attendee_Sendmsg extends Sp_Account_Action_Abstract
{
    protected $condition = array();
	const PAGE_SIZE = OFFSET;
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
        if ($request->format == 'json') {
			$id = $request->id;
			$aid = $request->aid;
			if(!is_numeric($id) || !is_numeric($aid)) {
				return array('status' => '-1', 'msg'=>'参数错误');
			}
			$user = Sp_Account_User::current();
			$active = Sp_Active_Active::getActiveById($aid,$user->id);
			if(is_array($active) && count($active) > 1){
				$at = Sp_Account_Attendee::getAttendeeById($id);
				if($at['activeId'] == $aid && $at['status'] == 0 && ($at['checkStatus'] == 0 || $at['checkStatus'] == 1)){
					$row = Sp_Sendmsg::getSmsByPhone($at['phone'],'attendee');
					if(is_array($row) && count($row) < 3){
						$nowDate = date("Y-m-d",time());
						$msgDate = date("Y-m-d",$row['crttime']);
						if($nowDate == $msgDate){
							return array('status'=>'-126','msg'=>'该电子票已在当天发送过，不能重复发送。','data'=>$shortArr);
						}
					}
                   $code = $this->getSignIdCode($at);
                   if(false == $code){
                       return array('status'=>'-1', 'msg'=>'生成电子票失败');
                   }
				   $url = SP_URL_HOME."attendee/code/".$code.".html";
				   $shortArr = Util_ShortUrl::shortSina($url);
				   if($shortArr === FALSE){
				   	   return array('status'=>'-1', 'msg'=>'生成电子票失败');
				   }else{
				   	
					   $content = $at['name']."你好：你已报名成功".$active['title']."，会议时间：".date("Y-m-d H:i",$active['activit_start'])." ~ ".date("Y-m-d H:i",$active['activit_start'])."，会议地点：".$active['address']."。您的电子票为".$shortArr['url_short']."，签到码为".$code. "，请保留此短信至会议结束。";
					   $sms = array();
					   $sms['username'] = $at['phone'];
					   $sms['content'] = $content;
					   $sms['type'] = 'attendee';
					   $sms['user_id'] = $user->id;
					   Sp_Sendmsg::send($sms);
					   if($at['checkStatus'] == 0){
					   		Sp_Account_Attendee::success($id);
					   }
					   return array('status'=>'0', 'msg'=>'发送成功');
				   }
				}else{
					return array('status'=>'-1', 'msg'=>'数据有误');
				}
			}else{
				return array('status'=>'-1', 'msg'=>'数据有误');
			}
		} 
    }
    
    public function getSignIdCode($data){
        $where = array('id'=>$data["id"]);
        $signId = Da_Wrapper::select()->table("sp.huitong.ht_apply_data")->columns('signId')->where($where)->getOne();
        
        if($signId){
            $signCode = $signId;
        }else{
            
            $time = date("YmdHis");
            $activeId = substr($data["activeId"],-2);
            $activeId = strlen($activeId)>1 ? $activeId : "0$activeId";
            $phone = substr($data["phone"],-3);
            $signIdEle = array(
                substr($time,3,4),
                substr($phone,0,2),
                $activeId,
                substr($phone,-1),
                substr($time,7,1),
                substr($time,8),
            );
            $signCode = implode("", $signIdEle);
            Da_Wrapper::update()->table("sp.huitong.ht_apply_data")->data(array("signId"=>$signCode))->where($where)->execute();
        }
        return $signCode;
    }

}
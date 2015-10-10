<?PHP
/**
 * 创建活动页面
 */
class Active_Create extends Sp_Account_Action_Abstract
{
    protected $condition = array();
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
     
        if ($request->format == 'json') {
			$activit_end = $request->activit_end;		 //活动结束时间
			$activit_start = $request->activit_start;    //活动开始时间
			$address	= $request->address;			 //详细地址
			$arrea	= $request->arrea;					//区域
			$city	= $request->city;					//城市
			$enroll_end = $request->enroll_end;			
			$enroll_start = $request->enroll_start;
			$is_audit = $request->is_audit;
			$is_enroll = $request->is_enroll; 			//是否需要审核
			$province = $request->province;				//省份
			$title	= $request->title;					//标题
			$thumbnail = $request->thumbnail;
			$enroll_num = $request->enroll_num;
			if(empty($title) || empty($activit_end) || empty($activit_end) || empty($address)  || empty($province) || empty($city)){
				return array('status'=>'-5','msg'=>'提交数据不完整');	
			}
			
			if(!empty($is_audit) && (empty($is_enroll) || empty($enroll_start) || empty($enroll_end))){
				return array('status'=>'-5','msg'=>'完善活动时间选项');	
			}
			
			if(strtotime($activit_end) < strtotime($activit_start)){
				return array('status'=>'-5','msg'=>'举办结束日期不能小于开始日期');	
			}
			
			$user = Sp_Account_User::current();
			$active = array();
			$active['activit_end']  = strtotime($activit_end);
			$active['activit_start']  = strtotime($activit_start);
			$active['address']  = $address;
			$active['arrea']  = empty($arrea)?0:$arrea;
			$active['city']  = $city;
			$active['province']  = $province;
			$active['title']  = $title;
			$active['user_id']  = $user->id;
			
			if(!empty($thumbnail)){
				$active['thumbnail']  = $thumbnail;
			}
			if(!empty($is_audit)){
				if(strtotime($enroll_end) < strtotime($enroll_start)){
					return array('status'=>'-5','msg'=>'报名结束日期不能小于开始日期');	
				}
				if(!is_numeric($enroll_num)){
					return array('status'=>'-5','msg'=>'人数不能为空');	
				}
				$active['is_audit']  = 1;
				$active['is_enroll']  = 1;
				$active['enroll_start']  = strtotime($enroll_start);
				$active['enroll_end']  = strtotime($enroll_end);
				$active['enroll_num'] = $enroll_num;
			}
			$aid = Sp_Active_Active::add($active);
			if(is_numeric($aid) && $aid > 0){
				return array('status'=>'0','msg'=>'添加成功','data'=>$aid);	
			}else{
				return array('status'=>'-1','msg'=>'添加失败');	
			}
        } else {
        	$province = Sp_City_City::getProvince();
			$view = new Sp_View;
			$uploadInfo = Util_FileUpload::getUpfileKey('huitong');
			$view->assign('province',$province);
			$view->assign('uploadInfo',$uploadInfo);
            $view->display("active/create.html");
        }

    }

    

}
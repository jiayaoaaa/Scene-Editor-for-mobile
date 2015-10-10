<?PHP

class Home_Publicapi extends Sp_Web_Action_Abstract
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
   		if($request->format == 'json'){
   			if($request->type == 'getcitychild'){   //活动城市三级联动
   				$id = $request->id;
   				if(!is_numeric($id)){
   					return array('status'=>'-1','msg'=>'参数错误');	
   				}	
				$list = Sp_City_City::getChlidById($id);
				return array('status'=>'0','msg'=>'获取成功','data'=>$list);	
   			}
			return array('status'=>'-1','msg'=>'提交地址有误');	
   		}
    }

}
<?PHP
/**
 * 拒绝参会人
 */
class Attendee_Refuse extends Sp_Account_Action_Abstract
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
				if($at['activeId'] == $aid && $at['checkStatus'] == 0){
					$rs = Sp_Account_Attendee::refuse($id);
					return array('status'=>'0', 'msg'=>'拒绝成功');
				}else{
					return array('status'=>'-1', 'msg'=>'数据有误');
				}
			}else{
				return array('status'=>'-1', 'msg'=>'数据有误');
			}
			
		} 
    }

}
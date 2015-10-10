<?PHP
/**
 * 删除对应的活动
 */
class Letter_Create extends Sp_Account_Action_Abstract
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
			$active_id = $request->active_id;	
			$title = $request->title;
			$discrib = $request->discrib;
			if(!is_numeric($active_id) || empty($title)) {
				return array('status' => '-1', 'msg'=>'参数错误');
			}
			$user = Sp_Account_User::current();
			$letter = array();
			$letter['user_id'] = $user->id;
			$letter['title'] = $title;
			$letter['discrib'] = $discrib;
			$letter['active_id'] = $active_id;
			$lastid = Sp_Letter_Letter::add($letter);
			
			if(is_numeric($lastid) && $lastid > 0){
				return array('status'=>'0','msg'=>'添加成功','data'=>$lastid);	
			}else{
				return array('status'=>'-1','msg'=>'添加失败');	
			}
		} 
    }

}
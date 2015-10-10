<?PHP
/**
 * 删除对应的活动
 */
class Letter_Delone extends Sp_Account_Action_Abstract
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
			if(!is_numeric($id)) {
				return array('status' => '-1', 'msg'=>'参数错误');
			}
			$user = Sp_Account_User::current();
			$rs = Sp_Letter_Letter::delByPrimarykey($id,$user->id);
			
			return array('status'=>'0', 'msg'=>'删除成功');
		} 
    }

}
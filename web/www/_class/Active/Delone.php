<?PHP
/**
 * 获得所有活动
 */
class Active_Delone extends Sp_Account_Action_Abstract
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
			$pkid = $request->pkid;
			if(!is_numeric($pkid)) {
				return array('status' => '-1', 'msg'=>'参数错误');
			}
			
			$rs = Sp_Active_Active::delByPrimarykey($pkid);
			
			return array('status'=>'0', 'msg'=>'删除成功');
		} 
    }

}
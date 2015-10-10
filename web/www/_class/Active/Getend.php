<?PHP
/**
 * 获得进行中活动
 */
class Active_Getend extends Sp_Account_Action_Abstract
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
			$user = Sp_Account_User::current();
			$nowtime = time();
			
			// 当前页数
			$nowPage = $request->page;
			empty($nowPage) && ($nowPage = 1);
			$limitRow = ($nowPage - 1) * self::PAGE_SIZE;
			
			// 分页数据
			$array = Sp_Active_Active::getListByUser($user->id, 
				"a.isdel = 0 and a.activit_end < {$nowtime}", 
				$limitRow, self::PAGE_SIZE);
			
			// 分页
			$pageString = Sp_Active_Active::getPageString($user->id, 
				$nowPage, self::PAGE_SIZE,"isdel = 0 and activit_end < {$nowtime}");
			
			$data = array();
			if(is_array($array)) {
				$data['status'] = '0';
				$data['data'] = $array;
				$data['msg'] = '';
				$data['nowtime'] = $nowtime;
				$data['pageString'] = $pageString;
				
			} else {
				$data['status'] = '-1';
				$data['data'] = array();
				$data['msg'] = '';
			}
			
			return $data;
		} 
    }

    

}
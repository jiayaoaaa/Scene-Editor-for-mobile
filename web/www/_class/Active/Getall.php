<?PHP
/**
 * 获得所有活动
 */
class Active_Getall extends Sp_Account_Action_Abstract
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
			
			// 当前页数
			$nowPage = $request->page;
			empty($nowPage) && ($nowPage = 1);
			$limitRow = ($nowPage - 1) * self::PAGE_SIZE;
			
			// 分页数据
			$array = Sp_Active_Active::getListByUser($user->id, 'a.isdel = 0', $limitRow, self::PAGE_SIZE);
			
			// 分页
			$pageString = Sp_Active_Active::getPageString($user->id, $nowPage, self::PAGE_SIZE,'isdel = 0');
			
			$data = array();
			if(is_array($array)) {
				$data['status'] = '0';
				$data['data'] = $array;
				$data['msg'] = '';
				$data['pageString'] = $pageString;
				$data['nowtime'] = time();
				$data['nowPage'] = $nowPage;
				
			} else {
				$data['status'] = '-1';
				$data['data'] = array();
				$data['msg'] = '';
			}
			
			return $data;
			
		} 
    }

}
<?PHP
/**
 * 邀请函页面
 */
class Letter_Index extends Sp_Account_Action_Abstract
{
    protected $condition = array();	
	const PAGE_SIZE = 9;
	
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
			$aid = $request->id;
			if(!is_numeric($aid)){
				$data = array();	
				$data['status'] = '-1';
				$data['msg'] = '提交数据有误';
				return $data;
			}
			
			// 当前页数
			$nowPage = $request->page;
			empty($nowPage) && ($nowPage = 1);
			$limitRow = ($nowPage - 1) * self::PAGE_SIZE;
			
			// 分页数据
			$array = Sp_Letter_Letter::getListByUser($user->id,$aid,$limitRow, self::PAGE_SIZE);
			$total = Sp_Letter_Letter::getTotalByUser($user->id,$aid);
			if(is_array($array) && count($array)){
				$cry = new Util_Crypt3Des();
				foreach ($array as $key => $value) {
					 $id = $cry->encrypt($value['id']);
					$id = base64_encode($id);
					$array[$key]['sid'] = $id;
				}
			}
			// 分页
			$pager = new Util_Pager($total, $nowPage, self::PAGE_SIZE);
			$pageString = $pager->renderNav(true);
			$data = array();
			if(is_array($array)) {
				$data['status'] = '0';
				$data['data'] = $array;
				$data['msg'] = '';
				$data['pageString'] = $pageString;
				$data['nowtime'] = time();
 				
			} else {
				$data['status'] = '-1';
				$data['data'] = array();
				$data['msg'] = '';
			}			
			return $data;
        } else {
        	$aid = $request->id;
			if(!is_numeric($aid)) {
				$this->show404();
			}
			
			$user = Sp_Account_User::current();
			$active = Sp_Active_Active::getActiveById($aid,$user->id);
			
			if(empty($active)) {
				$this->show404();
			}
			
			$view = new Sp_View;
			$view->assign('active',$active);
			$view->assign('select','letter');
            $view->display("letter/index.html");
        }

    }

    

}
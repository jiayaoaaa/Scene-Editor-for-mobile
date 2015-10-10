<?PHP
/**
 * editor by carten 2015/8/6
 */
class Attendee_Index extends Sp_Account_Action_Abstract
{
    protected $condition = array();
    
    protected $headers = array(
        'name'  => '姓名',
        'phone' => '电话',
    );



    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {

/*$total = 90;
$page = 8;
$size = 10; 
$pager = new Util_Pager($total, $page, $size, "?page=%d&activeId=19");
$offset = $pager->getOffset();
$pager->setTotal($total);
echo $pager->renderNav();*/


        $model = new Sp_Account_Attendee;
        $activeId = $request->activeId;
        $header = $model->GetTableHeaderByActiveId($activeId);
        if(false == $header){
            $showHeader = $this->headers;
        }else{
            $showHeader = $this->getShowHeader($header);
            $showHeader = $model->getColumnFormArr($showHeader,'title','field');
        }
        $columns =array_keys($showHeader);
        array_push($columns,'id');
		$columns[] = 'status';
		$columns[] = 'checkStatus';
        $dataProvide = $model->AttendeeList($activeId,$columns);
        if ($request->format == 'json') {
        	$arrary = array();
			return $array;
        } else {
            /*$user = Sp_Account_User::current();
			$user = Sp_Account_User::load($user->id);*/
            $aid = $request->activeId;
			if(!is_numeric($aid)) {
				$this->show404();
			}
			
			$user = Sp_Account_User::current();
			$active = Sp_Active_Active::getActiveById($aid,$user->id);
			
			if(empty($active)){
				$this->show404();
			}
			
			
			$view = new Sp_View;
			$view->assign('active',$active);
            $view->assign('data',$dataProvide[1]);
            $view->assign('page',$dataProvide[0]);
            $view->assign('header',$showHeader);
            $view->assign('headerSet',json_encode($header));
            $view->assign('activeId',$activeId);
            $view->assign('uploadInfo',$uploadInfo);
            $view->display("attendee/index.html");
        }

    }
    public function getShowHeader($data=array()){
        foreach($data as $key=>$value){
            if(0 == $value["isShow"]){
                unset($data[$key]);
            }
        }
        
        return $data;
    }

    

}
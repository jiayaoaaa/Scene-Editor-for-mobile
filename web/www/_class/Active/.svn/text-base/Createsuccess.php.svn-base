<?PHP
/**
 * 创建成功页面
 */
class Active_Createsuccess extends Sp_Account_Action_Abstract
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
        	return array();	
        } else {
        	$id = $request->id;
			
			if(empty($id) || !is_numeric($id)){	
				$this->show404();
			}
			$user = Sp_Account_User::current();
			$active = Sp_Active_Active::getActiveById($id,$user->id);
			
			if(empty($active)){
				$this->show404();
			}
	
			$view = new Sp_View;
			$view->assign("active",$active);
            $view->display("active/createsuccess.html");
        }
    }

}
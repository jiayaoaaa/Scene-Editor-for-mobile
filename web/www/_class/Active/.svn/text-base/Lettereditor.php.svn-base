<?PHP
/**
 * 邀请函编辑页面
 */
class Active_Lettereditor extends Sp_Account_Action_Abstract
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
        	$arrary = array();	
			$id = $request->id;
			if(!is_numeric($id) || $id < 1){
				return array('status'=>'-5','msg'=>'参数错误');	
			}
		
			$pageConfig = $_POST['pageConfig'];
			$pageItem = $_POST['pageItem'];
			$letter = array();
			$letter['pageConfig'] = $pageConfig;
			$letter['pageItem'] = $pageItem;
			Sp_Letter_Letter::save($id,$letter);
			return array('status' => 0,'msg'=>'保存成功');;
        } else {
        	
        	$id = $request->id;
			if(!is_numeric($id) || $id < 1){
				$this->show404();
			}
			$letter = Sp_Letter_Letter::getLetterById($id);
			if(empty($letter)) {
				$this->show404();
			}
			$active = Sp_Active_Active::getActiveById($letter['active_id'],$user->id);
			if(empty($active)) {
				$this->show404();
			}
			$view = new Sp_View;
			$view->assign("id",$id);
			$view->assign("active",$active);
            $view->display("active/lettereditor.html");
        }

    }

    

}
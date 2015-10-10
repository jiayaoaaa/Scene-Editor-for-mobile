<?PHP
/**
 * 邀请函页面
 */
class Letter_Show extends Sp_Web_Action_Abstract
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
        	$id = $request->id;	
			if(!is_numeric($id)) {
				return array('status' => '-1', 'msg'=>'参数错误');
			}
			$letter = Sp_Letter_Letter::getLetterById($id);
			if(is_array($letter) && count($letter) > 0){
				$letter['pageConfig'] = json_decode($letter['pageConfig'],TRUE);
				$letter['pageItem'] = json_decode($letter['pageItem'],TRUE);
			}
			if(!empty($letter)){
				$active = Sp_Active_Active::getActiveById($letter['active_id']);
				if(empty($active)) {
					return array('status' => '-1', 'msg'=>'数据有误');
				}
			}
			
			return array('status'=>'0', 'msg'=>'获取成功','data'=>$letter);
        } else {
        	
        	$jssdk = new Util_Jssdk("wx91f7f41fce0885bc", "YjlcfXNkdBYjlcfXNkdBYjlcfXNkdBYj");
			$signPackage = $jssdk->GetSignPackage();

        	$id = $request->id;
			$id = base64_decode($id);
			$cry = new Util_Crypt3Des();
	        $id = $cry->decrypt($id);
			if(!is_numeric($id)) {
				$this->show404();
			}
			
			$letter = Sp_Letter_Letter::getLetterById($id);
			if(empty($letter)) {
				$this->show404();
			}
			$active = Sp_Active_Active::getActiveById($letter['active_id']);
			if(empty($active)) {
				$this->show404();
			}
			$view = new Sp_View;
			$view->assign("letter",$letter);
			$view->assign('active',$active);
			$view->assign('signPackage',$signPackage);
            $view->display("letter/show.html");
        }

    }

    

}
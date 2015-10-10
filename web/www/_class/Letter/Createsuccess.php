<?PHP
/**
 * 创建成功页面
 */
class Letter_Createsuccess extends Sp_Account_Action_Abstract
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
			if(!is_numeric($id) || $id < 1){
				$this->show404();
			}
			$letter = Sp_Letter_Letter::getLetterById($id);
			if(empty($letter)) {
				$this->show404();
			}
			
			$view = new Sp_View;
			$view->assign("letter",$letter);
            $view->display("letter/createsuccess.html");
        }
    }

}
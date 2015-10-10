<?PHP
/**
 * 发送参会人信息
 */
class Attendee_Code extends Sp_Web_Action_Abstract
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
    	$id = $request->id;
		if(empty($id)){
			header("Location: ".SP_URL_HOME);
	    	exit;
	    }
		$data =  Sp_Account_Attendee::getAttendeeBySn($id);
		if(empty($data)){
			header("Location: ".SP_URL_HOME);
		    exit;
		}
        if ($request->type == 'code') {
			include LIB_ROOT . 'third/phpqrcode/qrlib.php';
			$errorCorrectionLevel = "L";  
			$matrixPointSize = "6";
			QRcode::png($id, false, $errorCorrectionLevel, $matrixPointSize);
			
		}else{
			
			$active = Sp_Active_Active::getActiveById($data['activeId']);
			if(empty($active)) {
				$this->show404();
			}
			$data['sn'] = $this->formatSn($data['signId']);
			$view = new Sp_View;
			$view->assign('data',$data);
			$view->assign('active',$active);
            $view->display("attendee/code.html");
		}
    }
 
 	private function formatSn($sn){
 		$str = "";
	
 		for ($i=0; $i < strlen($sn); $i++) {
			 $str .= $sn[$i];
			 if(($i + 1) % 4 == 0){
			 	$str .= " ";
			 }
		}
		return $str;
 	}

}
<?PHP

/**
 * editor by carten 2015/8/6
 */
class Attendee_Import extends Sp_Web_Action_Abstract {

    protected $condition = array();

    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request) {
      	header("Content-type:text/html;charset=utf-8");
        if ($request->format == 'json') {
        	if (isset($_POST["_huitong_user"])) {
           	   $cookie_user = urldecode($_POST['_huitong_user']);	
			   $user = Sp_Account_User::parseStored($cookie_user);	
			   $activeId = $request->activeId;
	           if(!is_numeric($user['id']) || $user['id'] < 1 || !is_numeric($activeId) || $activeId < 1){
	           		$jsonParam = array('code'=>'500', 'message'=>'上传错误');
				    echo json_encode($jsonParam);
					exit;
	           }
	           $arrary = array();
	           $up = new Util_Upload(
					array(
						'savepath' => UPLOAD_ROOT . 'attendee',
						'subdirpattern' => 'Y/m/d', 
						'israndname'=>true,
						'allowtype'=>array('xls','xlsx'),
						'maxsize'=>5120000
					)
				);
				
				$up->uploadFile('file');  // input's name property
				$msg = $up->getErrorMsg();
				$jsonParam = array();
				if(empty($msg)) {
						$filename = $up->getUploadFileName();
						if (is_readable($filename) == false) {
							$jsonParam = array('code'=>'500', 'message'=>'文件不可读');
							 echo json_encode($jsonParam);
							exit; 
						} 
						@chmod($filename, 0777);
						$data = array(
		                    'userId'=>$user['id'],
		                    'fileDir'=>$filename
	               		 );
					
						$data['activeId'] = $activeId;
			            $lastid =  Sp_Account_Attendee::uploadLog($data);
			            if ($lastid) {
			            	if(class_exists('GearmanClient')){
			            		$client_active = MQClient::factory('participants');
			                	$client_active->send('importParticipants', $data,false);
			            	}
			            }			
					$jsonParam = array('code'=>'200', 'message'=>'ok','url'=>'','time'=>time());
				} else {
					$jsonParam = array('code'=>'500', 'message'=>$msg);
				}
	            echo json_encode($jsonParam);
	        }else{
	        	$jsonParam = array('code'=>'500', 'message'=>'错误访问');
				 echo json_encode($jsonParam);
	        } 
        }
    }
}

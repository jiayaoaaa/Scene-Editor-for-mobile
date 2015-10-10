<?PHP
/**
 * 邀请函素材上传
 */
class Lettermaterial_Upload extends Sp_Account_Action_Abstract
{
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
    	
        if ($request->format == 'json') {
        	$t = $request->type;

			if('music' == $t){
			
				$up = new Util_Upload(
					array(
						'savepath' => UPLOAD_ROOT . 'music',
						'subdirpattern' => 'Y/m/d', 
						'israndname'=>true,
						'allowtype'=>array('wav','mp3'),
						'maxsize'=>5120000
					)
				);
				
				$up->uploadFile('file');  // input's name property
				$msg = $up->getErrorMsg();
				
				if(empty($msg)) {
					$filename = $up->getUploadFileName();
					$filename = str_replace(UPLOAD_ROOT, "", $filename);
					$name = $_FILES['file']['name'];
					$user = Sp_Account_User::current();
					$material = array();
					$material['user_id'] = $user->id;
					$material['type'] = 2;
					$material['name'] = $name;
					$material['url'] = $filename;
					Sp_Letter_Material::add($material);
					return array('status'=>'0', 'msg'=>'上传成功','data'=>$filename);
				} else {
					return array('status'=>'-1', 'msg'=>$msg);
				}
					
			} 
			else if('image' == $t){
				$up = new Util_Upyun(
						array(
							'save_path' => UPLOAD_ROOT.'image/',
							'save_url' => 'huitong/'
						)
					);
					
				$msg = $up->uploadFile('file');
				if($msg['status'] == 0){
					$name = $_FILES['file']['name'];
					$user = Sp_Account_User::current();
					$material = array();
					$material['user_id'] = $user->id;
					$material['type'] = 1;
					$material['name'] = $name;
					$material['url'] = $msg['data'];
					Sp_Letter_Material::add($material);
				}
				return $msg;
			}
			else {
				return array('status'=>'-2', 'msg'=>'未上传');
			}
        }
    }

}
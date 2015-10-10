<?PHP
/**
 * 个人信息首页
 */
class Account_Index extends Sp_Account_Action_Abstract
{
    
    public function execute($request)
    {
		global $priv;
		
		$user = Sp_Account_User::current();
		$uploadInfo = Util_FileUpload::getUpfileKey('huitong');
		$province = Sp_City_City::getProvince();
		$view = new Sp_View;
		$userInfo = Sp_Account_User::getUser($user->id, array('name','face','gender','province','city','area','mobile_status','email_status'));
		
        $auth = array(
            'mobile_status'=>$userInfo['mobile_status'],
            'email_status' =>$userInfo['email_status']
        );
		
		$view->assign('province', $province);
		$view->assign('action', $priv);
        $view->assign('auth', $auth);        
		
		if(!empty($userInfo['province'])){
			$city = Sp_City_City::getChlidById($userInfo['province']);
			$view->assign('city',$city);
		}
		if(!empty($userInfo['city'])){
			$arrea = Sp_City_City::getChlidById($userInfo['city']);
			$view->assign('arrea',$arrea);
		}
		$view->assign('uploadInfo', $uploadInfo);
		$view->display("account/index.html");
    }
}
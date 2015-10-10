<?PHP
/**
 * 修改密码
 */
class Account_Password extends Sp_Account_Action_Abstract
{
    
    public function execute($request)
    {
		global $priv;
		
		$user = Sp_Account_User::current();
		$user = Sp_Account_User::getUser($user->id, array('name','face','gender','province','city','area'));
		$uploadInfo = Util_FileUpload::getUpfileKey('huitong');
		
		$view = new Sp_View;
		
		$view->assign('user', $user);
		$view->assign('action', $priv);
		$view->assign('uploadInfo', $uploadInfo);
		$view->display("account/password.html");
    }
}
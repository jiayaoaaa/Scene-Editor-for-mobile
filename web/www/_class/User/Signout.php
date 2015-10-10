<?PHP

/**
 * 退出登录
 */
class User_Signout extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
        	$user = Sp_Account_User::current();
			$user->signout();
			header("Location: /");
    }
   

}
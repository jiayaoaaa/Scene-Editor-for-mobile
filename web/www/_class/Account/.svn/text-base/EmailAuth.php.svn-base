<?PHP
/**
 * editor by carten 2015/8/6
 */
class Account_EmailAuth extends Sp_Account_Action_Abstract
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
        global $priv;
        
        if ($request->format == 'json') {
        	$arrary = array();
			return $array;
        } else {
			$view = new Sp_View;
            $view->assign("action",$priv);
            $view->display("account/emailAuth.html");
        }

    }
    
    /*public function sendCode(){
        $controll = new Account_PhoneAuth;
        return $controll->sendCode("1353075115@qq.com");
    }*/


    

}
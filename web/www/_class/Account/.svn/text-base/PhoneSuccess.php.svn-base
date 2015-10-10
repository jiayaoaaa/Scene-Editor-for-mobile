<?PHP
/**
 * editor by carten 2015/8/6
 */
class Account_PhoneSuccess extends Sp_Account_Action_Abstract
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
            
        } else {
			$view = new Sp_View;
            $view->assign("action",$priv);
            $view->display("account/phoneSuccess.html");
        }
    }
    


    

}
<?PHP


class User_Captcha extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * 生存验证码
     */
    public function execute($request)
    {
        $captcha =  Util_Captcha::getInstance();
        $captcha->display(70,30);
    }
    
    
    

}
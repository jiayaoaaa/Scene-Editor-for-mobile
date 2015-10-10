<?PHP
/**
 * editor by carten 2015/8/6
 */
class Account_PhoneAuth extends Sp_Account_Action_Abstract
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
            if($request->action == 'sendCode'){
                return $this->sendCode($request->mobile);
            }else if($request->action == 'authCode'){
                return $this->authCode($request->mobile,$request->code);
            }
            return array('status'=>123,'msg'=>'参数错误');
        } else {
			$view = new Sp_View;
            $view->assign("action",$priv);
            $view->display("account/phoneAuth.html");
        }
    }
    /*
     * 发送验证码
     */
    public function sendCode($username=''){
        $code = rand(100000, 999999);
        $content = "您本次在会通网修改密码的验证码为：".$code.",任何人索取验证码均为咋骗，切勿泄露！此验证码会在15分钟后失效";
        $data = array(
            'code'      =>$code,
            'content'   =>$content,
            'username'  =>$username,
            'type'      =>'Auth'
        );
        if(Sp_Sendmsg::send($data)){
            $return = array("status"=>1,"msg"=>"发送成功");
        }else{
            $return = array("status"=>0,"msg"=>"发送失败");
        }
        return $return;
    }
    /*
     * 验证验证码
     */
    public function authCode($phone,$code,$model = 'phoneAuth'){
        if(Sp_Sendmsg::authCode($phone,$code,$model)){
            $return = array("status"=>1,"msg"=>"验证成功");
        }else{
            $return = array("status"=>0,"msg"=>"验证失败,请重新获取验证码");
        }
        return $return;
    }


    

}
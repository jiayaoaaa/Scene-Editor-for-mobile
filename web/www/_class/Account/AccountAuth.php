<?PHP
/**
 * editor by carten 2015/8/6
 */
class Account_AccountAuth extends Sp_Account_Action_Abstract
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
        if ($request->format == 'json') {
            $account = $request->account;
            $type = $request->type;
            $action = $request->action;
            if( 'send'== $action){
                return $this->sendCode($account,$type);
            }else if( 'auth'== $action){
                $code = $request->code;
                return $this->authCode($account,$code,$type);
            }else{
                return array('status'=>-110,'msg'=>'参数错误');
            }
            
        } else {
            
        }
    }
    public function check($account = '',$type=''){
        $rules['phone'] = Sp_Dictionary::getOtherOption("patternMobile");
        $rules['email'] = Sp_Dictionary::getOtherOption("patternEmail");
        
        $msg['phone'] = "电话格式不正确";
        $msg['email'] = "邮箱格式不正确";
        $return = 1;
        $filter = array('phone','email');
        
        if(false == in_array($type,$filter)){
            $return = array("status"=>-100,"msg"=>"参数错误");
        }else if(FALSE == preg_match($rules[$type], $account)){
            $return = array("status"=>-101,"msg"=>$msg[$type]);
        }else{
            $currentTime = time();
            $time = $currentTime-60;
            $hours = $currentTime-60*60;
            $where = array($type=>$account);
            $flag = Da_Wrapper::select()->table('sp.huitong.ht_sms_report')->columns('id')->where($where)->where("crttime >= $time")->getOne();
            if(false != $flag){
                $return = array("status"=>-102,"msg"=>"请一分钟后在试");
            }
            $sendCount = Da_Wrapper::select()->table('sp.huitong.ht_sms_report')->columns('id')->where($where)->where("crttime >= $hours")->getTotal();
            if(5 <= $sendCount){
                $return = array("status"=>-103,"msg"=>"你已多次获取，为保证账号的安全，防止恶意验证，请1小时后再试");
            }
        }
        return $return;
        
    }
    /*
     * 发送验证码
     */
    public function sendCode($username='',$type=''){
        $check = $this->check($username,$type);
        if(1 !== $check){
            return $check;
        }
        $code = rand(100000, 999999);
        $content = "您本次在会通网修改密码的验证码为：".$code.",任何人索取验证码均为咋骗，切勿泄露！此验证码会在15分钟后失效";
        $data = array(
            'code'      =>$code,
            'content'   =>$content,
            'username'  =>$username,
            'type'      =>$type
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
    public function authCode($account='',$code='',$type = 'phone'){
        $auth = Sp_Sendmsg::authCode($account,$code,$type);
        if(1 === $auth){
            $return = array("status"=>1,"msg"=>"验证成功");
        }else if(false === $auth){
            $return = array("status"=>0,"msg"=>"验证失败,请重新获取验证码");
        }else{
            $return = $auth;
        }
        return $return;
    }


    

}
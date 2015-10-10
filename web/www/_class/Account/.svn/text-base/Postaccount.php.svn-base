<?PHP
/**
 * 个人信息首页
 */
class Account_Postaccount extends Sp_Account_Action_Abstract
{
    
    public function execute($request)
    {
		if($request->format == 'json') {
			$data = array();
			
			$email = $request->email;
			$mobile = $request->mobile;
		    $patternEmail = Sp_Dictionary::getOtherOption('patternEmail');
	        $patternMobile = Sp_Dictionary::getOtherOption('patternMobile');
	 
	        
	        if(false == preg_match($patternEmail,$email)){
	            return array('status'=>'-120','msg'=>'邮件格式不正确');
	        }else if(false == preg_match($patternMobile,$mobile)){
	            return array('status'=>'-121','msg'=>'电话格式不正确');
	        }
			
			$user = Sp_Account_User::current();
			
			$data['name'] = $request->name;
			$data['gender'] = $request->gender;
			$data['mobile'] = $mobile;
			$data['email'] = $email;
			$data['province'] = $request->province;
			$data['city'] = $request->city;
			$data['area'] = $request->area;
			$data['face'] = $request->face;
			$ret = Sp_Account_Info::updateUser($user->id, $data);
			return array('status'=>'0', 'msg'=>'成功');
		}
    }
}
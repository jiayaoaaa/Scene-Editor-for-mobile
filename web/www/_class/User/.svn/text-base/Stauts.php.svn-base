<?PHP

/**
 * 判断是否登录
 */
class User_Stauts extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
        $user =  Sp_Account_User::current();
        if ($user->isLogin() === FALSE) {  //未登录跳转
			echo 'document.write(\'<div class="menu"><a href="javascript:void(0);"  ms-click="showlogin" class="ht-btn-blue">登录</a><a href="javascript:void(0);"  ms-click="showreg" class="ht-btn-gray">注册</a></div>\')';
		}else{
			$userInfo = Sp_Account_User::getUser($user->id, array('face'));
			$pic = empty($userInfo['face'])?SP_URL_IMG.'dzx.jpg':SP_URL_UPLOAD.$userInfo['face'];
			$html = '<div class="ht-user">'.
					'<a href="javascript:void(0);" class="ht-user-navlink show">'.
						'<img src="'.$pic.'" /></a>'.
					'<div class="ht-user-dropdown">'.
					'<a href="/active/index.html" class="line">'.
						'<i class="ht-topNav-icon01"></i>'.
							'<span>我的活动</span></a>'.
						'<a href="/account/index.html" >'.
							'<i class="ht-topNav-icon02"></i><span>我的信息</span></a>'.
						'<a href="/account/password.html" class="line">'.
							'<i class="ht-topNav-icon03"></i>'.
							'<span>修改密码</span></a>'.
							'<a href="/user/signout.html" >'.
							'<i class="ht-topNav-icon05"></i>'.
							'<span>退出</span></a></div></div>';
        	echo 'document.write(\''.$html.'\')';
        }
    }
   

}
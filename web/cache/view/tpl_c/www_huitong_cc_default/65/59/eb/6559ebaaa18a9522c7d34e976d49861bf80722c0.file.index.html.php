<?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 14:41:06
         compiled from "D:\hexing\sp_v1\config/../skins/default\index.html" */ ?>
<?php /*%%SmartyHeaderCode:3266255e445a4700277-92682022%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6559ebaaa18a9522c7d34e976d49861bf80722c0' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\index.html',
      1 => 1442472060,
      2 => 'file',
    ),
    'ccc9be776a3e1232a4b36e7a86a1bb54322784d8' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\skins\\default\\main_layout.html',
      1 => 1441793772,
      2 => 'file',
    ),
    '19a4143c7ad34ad0881f141878671eb995a9a8f7' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\tpl_header.html',
      1 => 1441599262,
      2 => 'file',
    ),
    '5cd4ed4985f7d017c7db2d4bb5431c1c72d0d598' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\tpl_footer.html',
      1 => 1441001633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3266255e445a4700277-92682022',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e445a4952040_25044508',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_STO' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e445a4952040_25044508')) {function content_55e445a4952040_25044508($_smarty_tpl) {?><!DOCTYPE html>
<html>

<head>
    <title>
免费专业智能会议管理工具 
 - 会通，邀请函、在线报名、电子签到</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="keyword" content="电子邀请函，在线报名、电子签到、会议系统、在线会议管理" />
    <meta name="description" content="会通是会唐专为会议主办方打造的专业职能会议管理工具，让办会变的更容易。场景邀请函简单易用，在线报名省时省力，电子签到专业高效。" />
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
	
<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/common.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/main.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/animate.min.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/notify.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/backcommon.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/jquery.jslides.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/swiper/css/swiper.min.css">

    <script type="text/javascript">
    	var SP_URL_STO = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
';
    </script>
    
 <script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/require/require.js" data-main="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
main.js"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/jquery.min.js"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/jquery.jslides.js"></script>

   
    <style>
    .ms-controller {
        visibility: hidden;
    }
    </style>
</head>

<body ms-controller="indexPage">
    <!-- <div class="header">
        <div class="logo"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/logo.png" alt=""></div>
        <div class="menu">
            <a href="#"  ms-click="showlogin" class="ht-btn-blue">登录</a>
            <a href="#"  ms-click="showreg" class="ht-btn-gray">注册</a>
        </div>
    </div> -->
	<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '3266255e445a4700277-92682022');
content_55fa6082a89bc0_99738968($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>

    

<!--	<div class="slider">

        <div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
/picture/s1.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
/picture/s2.jpg" alt=""></div>
        <div class="swiper-slide"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
/picture/s3.jpg" alt=""></div>
    </div>
    <div class="swiper-pagination"></div>

</div>
 </div> -->

<div id="full-screen-slider">
	<ul id="slides">
		<li style="background:url(<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/banner01.jpg) no-repeat center top"></li>
		<li style="background:url(<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/banner02.jpg) no-repeat center top"></li>
	</ul>
</div>





<!--找回密码-->
         <div class="border-style  center zoomInUp animated" id="findPwd" ms-visible="findPwdShow" style="display: none;">
        <div class="title"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/findpwd_tit.jpg" alt=""></div>
                <button class="close" ms-click="close" >X</button>

        <ul class="tabs"><li  class="on" ><a href="#"ms-click="toggle(0)">手机找回</a></li>
            <li><a href="#" ms-click="toggle(1)">邮箱找回</a></li>
        </ul>
        <div class="tab-content">
      <div class="contents"  ms-visible="currentIndex === 0" >

         <div class="form" id="FindpwdbyMobile"  ms-controller="FindpwdbyMobile">
         	 <div class="error-tip" >{{errorTxt}}</div>
            <form action="" ms-widget="validation"  novalidate="novalidate">
                <div class="form-group ">
                    <input class="form-control " type="text" placeholder="手机号" ms-duplex-required="username"  data-duplex-event="change" />
                </div>
                <div class="form-group ">
                   <div class="width-70"> <input class="form-control code"  type="text" placeholder="短信验证码" ms-duplex-required="code"  data-duplex-event="change" /></div>  

                       <div class="width-30"> <a class="btn success pull-right" ms-click="getCode">获取</a></div>  

                </div>
              
                <div class="form-group ">
                    <button class="btn success pull-center">找回</button>
                </div>
            </form>
        </div>
          
      </div>
        

      <div class="contents"  ms-visible="currentIndex === 1" >

           <div class="form"    id="FindpwdbyEmail" ms-controller="FindpwdbyEmail">
           	<div class="error-tip" >{{errorTxt}}</div>
            <form action=""  ms-widget="validation"  novalidate="novalidate">
                <div class="form-group " >
                    <input class="form-control " type="text" placeholder="邮箱" ms-duplex-required="username"  data-duplex-event="change" />
                </div>
                <div class="form-group ">
                   <div class="width-70"> <input class="form-control code"  type="text" ms-duplex-required="code"  data-duplex-event="change" placeholder="邮箱验证码" /></div>  

                       <div class="width-30">  <a class="btn success pull-right" ms-click="getCode" >获取</a></div>  

                </div>
              
                <div class="form-group ">
                    <button class="btn success pull-center">找回</button>
                </div>
            </form>
        </div>
   
        </div>         

        </div>
     
    </div> 
<!--找回密码-->











    <!--登录-->
    <div class="border-style center zoomInUp animated" id="loginArea" ms-visible="loginIsShow" ms-controller="login" style="display: none;">
        <div class="title"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/login_tit.jpg" alt=""></div>
        <div class="error-tip" >{{errorTxt}}</div>
        <button class="close" ms-click="close">X</button>
        <div class="form" >
            <form action=""  ms-widget="validation"  novalidate="novalidate">
                <div class="form-group ">
                    <input class="form-control " type="text" placeholder="ID/手机/邮箱" ms-duplex-required="username"  data-duplex-event="change"/>
                </div>
                <div class="form-group ">
                    <input class="form-control " type="password" placeholder="密码" ms-duplex-required="password" data-duplex-event="change" />
                </div>
               <!--  <div class="form-group ht-checkbox-box ">
                    <input type="checkbox" ms-duplex-checked="autologin" >
                    <label class="ht-input-text1">记住账号</label>
                    
                </div> -->
                <div class="form-group ">
                    <button class="btn ht-btn-blue pull-center">登&nbsp;&nbsp;&nbsp;&nbsp;录</button>
                </div>
                <div class="login-bottom"><a href="#"  ms-click="showreg" >注册账号</a> | <a href="#" ms-click="showPwd" >找回密码</a></div>
            </form>
        </div>
    </div>
    <!--登录end-->



    <!--注册-->
        <div class="border-style center zoomInUp animated" id="regArea" ms-visible="regIsShow"  style="display: none;">
        <div class="title"><img src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
img/reg_tit.jpg" alt=""></div>
        
        <button class="close" ms-click="close">X</button>

        <div class="form" ms-controller="reg">
        	 <div class="error-tip" >{{errorTxt}}</div>
            <form action="" ms-widget="validation"  novalidate="novalidate">
                <div class="form-group ">
                    <input class="form-control " type="text" placeholder="手机"  ms-duplex-required="mobile" ms-duplex-phone="mobile" data-duplex-event="change" required/>
                    <div class="error-tip"></div>
                </div>
                <div class="form-group ">
                    <input class="form-control " type="text" placeholder="邮箱" ms-duplex-required="email"  ms-duplex-email="email" data-duplex-event="change" />
                      <div class="error-tip"></div>
                </div>
                <div class="form-group ">
                    <input class="form-control " id="password" type="password" ms-duplex-required="passwd" placeholder="密码"   ms-duplex-alpha_passwd="passwd"   data-duplex-event="change"/>
                      <div class="error-tip"></div>
                </div>
                   <div class="form-group ">
                <input class="form-control " id="confirm_passwd" type="password"  placeholder="确认密码"  ms-duplex-repeat="confirm_passwd" data-duplex-repeat="password" data-duplex-event="change" />
                  <div class="error-tip"></div>
                </div>
                  <div class="form-group ">
                    <input class="form-control code"  type="text" placeholder="验证码"  maxlength="6" minlength="4"  ms-duplex-required="captcha" /> 
                    <img src="/user/captcha.html?t=234" ms-click="changCaptcha">
                      <div class="error-tip"></div>
                </div>


                <div class="form-group ">
                    <button  class="btn ht-btn-blue pull-center" ms-click="onValidateAll" >注册</button>
                </div>
            </form>
        </div>
    </div>
	 <div class="border-style center zoomInUp animated" id="regSuccess" ms-visible="regSuccess"  style="display: none;">
	 	<button class="close" ms-click="close">X</button>
	    <div class="layer-success">
	        <span>&nbsp;</span>
	        <p>注册成功，马上体验</p>
	        <a class="ht-btn-blue" href="/active/index.html">进入会通</a>
	    </div>
    </div>
    <div class="layer-bg" style="display: none;" ></div> 
    
    

    <!--注册end-->
    <?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '3266255e445a4700277-92682022');
content_55fa6082b4aa45_74479930($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
    

</body>

</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 14:41:06
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55fa6082a89bc0_99738968')) {function content_55fa6082a89bc0_99738968($_smarty_tpl) {?><div class="ht-header">
	<div class="/*ht-header-wrapper*/ ht-wrapper-1200">
		<a href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
"><img class="ht-logo ht-pull-left" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
logo.png" alt="logo"></a>
		<div class="ht-pull-right">
			<div id="showLogin">
				<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
user/stauts.html" type="text/javascript"></script>
			</div>
		</div><div class="ht-clearR"></div>
	</div>
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 14:41:06
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55fa6082b4aa45_74479930')) {function content_55fa6082b4aa45_74479930($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
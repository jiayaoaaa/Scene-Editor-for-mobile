<?php /* Smarty version Smarty-3.1.8, created on 2015-09-11 14:49:45
         compiled from "D:\hexing\sp_v1\config/../skins/default\account\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2067455f2798993da46-27479362%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12d80932e2749a7c0f164028dceb1c0fe67f02a6' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\account\\index.html',
      1 => 1441697514,
      2 => 'file',
    ),
    'ec6dc46517b17a4946b0380db9d26d8678c2a886' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\skins\\default\\layout.html',
      1 => 1441609960,
      2 => 'file',
    ),
    '19a4143c7ad34ad0881f141878671eb995a9a8f7' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\tpl_header.html',
      1 => 1441599262,
      2 => 'file',
    ),
    'eed8a0903aca1148d0144c36ddd085d6d0c239ea' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\skins\\default\\account\\nav.html',
      1 => 1440665149,
      2 => 'file',
    ),
    '5cd4ed4985f7d017c7db2d4bb5431c1c72d0d598' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\tpl_footer.html',
      1 => 1441001633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2067455f2798993da46-27479362',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_CSS' => 0,
    'SP_URL_STO' => 0,
    'SP_URL_JS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55f2798a055915_60095929',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55f2798a055915_60095929')) {function content_55f2798a055915_60095929($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
个人信息
 - 会通</title>
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
backcommon.css" rel="stylesheet"/>
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap-ie6.css?1">
	<![endif]-->
	
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
font-awesome.min.css">
	<!--[if IE 7]>
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
font-awesome-ie7.min.css">
	<![endif]-->
	
	<!--Basic Styles-->
    
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
notify.css"  />
<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
account.css" rel="stylesheet" />
<!--[if lte IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
ie.css">
<![endif]-->
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap-select.min.css">

    <script type="text/javascript">
    var SP_URL_STO = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
';
    </script>
    <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/jquery/jquery-1.9.1.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
 	<!--[if lt IE 9]>
 	 <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
html5shiv.min.js"></script>
 	  <script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
respond.min.js"></script>	
 	<![endif]-->
    
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/common.js"></script>
<script>
var SP_URL_UPLOAD = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
';
var SP_POLICY = "<?php echo $_smarty_tpl->tpl_vars['uploadInfo']->value['policy'];?>
", SP_SIGNATURE = "<?php echo $_smarty_tpl->tpl_vars['uploadInfo']->value['sign'];?>
";
</script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap-select.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/notify/notify.js"></script>

</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2067455f2798993da46-27479362');
content_55f27989b6fe57_87151100($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	

   	
<div class="ht-maincontainer ht-wrapper-1200">
	
<div class="ht-user-path">&nbsp;&lt;&nbsp;<a href="/active/index.html">返回我的活动</a></div>
<div class="ht-account">
	<div class="ht-account-left ht-pull-left">
	<?php /*  Call merged included template "./nav.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("./nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2067455f2798993da46-27479362');
content_55f27989bd0737_88237931($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "./nav.html" */?>
	</div>
	<div class="ht-account-right ht-pull-left">
		<div class="ht-account-right-wrapper">
			<h2>个人信息 ( ID : <?php echo $_smarty_tpl->tpl_vars['user']->value['userid'];?>
 )</h2>
			<div class="ht-account-form">
				<form id="f1" name="f1">
					<div class="ht-account-form-left ht-pull-left">
						<div class="form-group" style="margin-bottom: 0px!important;">
							<label for="exampleInputEmail1">昵称</label>
							<input type="text" id="name" name="name" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
" class="form-control ht-user-input">
						</div>
						<div class="form-group ht-account-line-32 ht-user-form-line-height">
							<label for="exampleInputEmail1">性别</label>
							<div class="form-inline ht-heihgt-32">
								<select id="gender" name="gender" class="selectpicker ht-create-select">
									<option value="1" <?php if ($_smarty_tpl->tpl_vars['user']->value['gender']=="1"){?>selected="selected"<?php }?>>男</option>
									<option value="0" <?php if ($_smarty_tpl->tpl_vars['user']->value['gender']=="0"){?>selected="selected"<?php }?>>女</option>
								</select>
							</div>
						</div>
						<div class="form-group ht-user-form-line-height" style="clear: both;">
                            <label for="exampleInputEmail1">手机
                                <?php if ($_smarty_tpl->tpl_vars['auth']->value['mobile_status']!='1'){?>
                                <font color="#fd5e7a">*</font><span>(未验证)</span><span class="checkPhoneEmail"><a href="/account/phoneAuth.html">验证</a></span>
                                <?php }?>
                            </label>
                            <label></label>
							<input type="text" id="mobile" name="mobile" <?php if ($_smarty_tpl->tpl_vars['auth']->value['mobile_status']=='1'){?>disabled="disabled"<?php }?> class="form-control ht-user-input" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['mobile'];?>
">
						</div>
						<div class="form-group ht-user-form-line-height">
							<label for="exampleInputEmail1">邮箱
                                <?php if ($_smarty_tpl->tpl_vars['auth']->value['email_status']!='1'){?>
                                <font color="#fd5e7a">*</font><span>(未验证)</span><span class="checkPhoneEmail"><a href="/account/emailAuth.html">验证</a></span>
                                <?php }?>
                            </label>
							<input type="text" id="email" <?php if ($_smarty_tpl->tpl_vars['auth']->value['email_status']=='1'){?>disabled="disabled"<?php }?> name="email" class="form-control ht-user-input" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
">
						</div>
						<div class="form-group  ht-account-line-32 ht-user-form-line-height">
							<label for="exampleInputEmail1">所在地</label>
							<div class="form-inline ht-heihgt-32">
							
									<select data-value="<?php echo $_smarty_tpl->tpl_vars['user']->value['province'];?>
" id="province" name="province" class="selectpicker ht-create-select ht-left">
										<option selected="true" value="" disabled="true">省</option>
										<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
											<option <?php if ($_smarty_tpl->tpl_vars['user']->value['province']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?>  value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
										<?php } ?> 
									</select>
									
									<select data-value="<?php echo $_smarty_tpl->tpl_vars['user']->value['city'];?>
" id="city" name="city" class="selectpicker ht-create-select ht-left" >
										<option selected="true" value="" disabled="true">市</option>
										<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
												<option <?php if ($_smarty_tpl->tpl_vars['user']->value['city']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
										<?php } ?> 
									</select>
									
									<select data-value="<?php echo $_smarty_tpl->tpl_vars['user']->value['area'];?>
" id="area" name="area" class="selectpicker ht-create-select">
										<option selected="true" value="" disabled="true">区</option>
										<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['arrea']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
												<option  <?php if ($_smarty_tpl->tpl_vars['user']->value['area']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
										<?php } ?> 
									</select>
							
							</div>
						</div>
						<button type="button" id="doPost" style="margin-top: 30px; padding:0;" class="ht-user-btn-blue">保&nbsp;&nbsp;存</button>
					</div>
					<div class="ht-account-form-right ht-pull-right">
						<!-- 头像地址 -->
						<input type="hidden" name="face" id="face" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['face'];?>
" />
						
						<div class="ht-account-form-right-wrapper">
							<div class="ht-account-avatar">
								<img id="overview" width="180" height="180" <?php if (!empty($_smarty_tpl->tpl_vars['user']->value['face'])){?> src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
<?php echo $_smarty_tpl->tpl_vars['user']->value['face'];?>
" <?php }else{ ?> src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
dzx.jpg" <?php }?> />
								<div id="progress_num" style="display: none;">100%</div>
							</div>
							<div class="ht-account-avatar-btn">
								<div class="ht-user-btn-blue">选择头像</div>
								<span id="facebtn"></span>
								<div>
									<div id="divStatus" style="display: none;">0 个文件已上传</div>
									<input id="btnCancel" type="button" style="display: none" onclick="swfu.cancelQueue();"/>
								</div>
							</div>
							<div class="ht-account-avatar-info">
								请上传 5M 以内 jpg、png、gif 建议 500*500 尺寸图片
							</div>
						</div>
					</div>
					<div class="ht-clear"></div>
					
					
				</form>
			</div>
		</div>
	</div><div class="ht-clearL"></div>
</div>


</div>

<!-- 本页 js -->
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/liandong.js"></script>
<!--
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/swfupload/swfuplaod-total.js"></script>
-->
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/fileprogress.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/handlers.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.queue.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/jquery.validate.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
modules/account/index.js"></script>

<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2067455f2798993da46-27479362');
content_55f2798a048f75_26008367($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-11 14:49:45
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55f27989b6fe57_87151100')) {function content_55f27989b6fe57_87151100($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-11 14:49:45
         compiled from "D:\hexing\sp_v1\skins\default\account\nav.html" */ ?>
<?php if ($_valid && !is_callable('content_55f27989bd0737_88237931')) {function content_55f27989bd0737_88237931($_smarty_tpl) {?><a <?php if ($_smarty_tpl->tpl_vars['action']->value=="index"||$_smarty_tpl->tpl_vars['action']->value=="phoneAuth"||$_smarty_tpl->tpl_vars['action']->value=="authSuccess"||$_smarty_tpl->tpl_vars['action']->value=="emailAuth"){?>class="active"<?php }?> href="/account/index.html" >个人信息</a>
<a <?php if ($_smarty_tpl->tpl_vars['action']->value=="password"){?>class="active"<?php }?> href="/account/password.html">修改密码</a><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-11 14:49:46
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55f2798a048f75_26008367')) {function content_55f2798a048f75_26008367($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
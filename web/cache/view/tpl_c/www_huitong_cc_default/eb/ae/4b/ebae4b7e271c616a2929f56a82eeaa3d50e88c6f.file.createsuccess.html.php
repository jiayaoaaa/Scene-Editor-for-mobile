<?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 17:36:03
         compiled from "D:\hexing\sp_v1\config/../skins/default\letter\createsuccess.html" */ ?>
<?php /*%%SmartyHeaderCode:2244755e445e8b69b72-77549160%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ebae4b7e271c616a2929f56a82eeaa3d50e88c6f' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\letter\\createsuccess.html',
      1 => 1441788755,
      2 => 'file',
    ),
    'a686e0051207353f3acfe67354f89147a82742f2' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\layout.html',
      1 => 1441609960,
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
  'nocache_hash' => '2244755e445e8b69b72-77549160',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e445e8d81d53_69875278',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_CSS' => 0,
    'SP_URL_STO' => 0,
    'SP_URL_JS' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e445e8d81d53_69875278')) {function content_55e445e8d81d53_69875278($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
邀请函创建完成
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
    
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
backcommon.css" rel="stylesheet"/>
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
activity-create.css" rel="stylesheet"/>

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
    
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
ytab.js"></script>

</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2244755e445e8b69b72-77549160');
content_55effd83e42881_19580432($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	



   	
<div class="ht-maincontainer ht-wrapper-1200">
	
<div class="row" style="margin-left: 0px;margin-right: 0px;">
			<div style="height: 50px;font-size:14px;line-height: 50px;">
				<div style="margin-left:30px;width:500px;">
					<a href="/active/index.html">我的活动</a>  >  <a href="/active/lettereditor.html?id=<?php echo $_smarty_tpl->tpl_vars['letter']->value['id'];?>
"> <?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
 </a>  > 创建成功
				</div>
			</div>
			<div class="ht-left ht-user-active-option-l" style="height:560px;margin-bottom: 20px!important;">
				<div class="ht-create-option-margin">
					<div class="title">
						邀请函创建完成
					</div>
					<div style="line-height: 36px;">
							嗨，你还有其它需要吗？<br/>
						
							1、您觉得一份邀请函不够？点击活动邀请函，为此活动创建更多精美的邀请函吧！<br/>
							
							2、已有参会人名单？快点击活动参会人，导入名单
					</div>
					<div  style="margin-top: 50px;">
							<a href="/active/index.html" class="btn btn-default  ht-create-btn-170 ht-left ht-create-bth-color1" >
								我的活动
							</a>
							<a href="/attendee/index.html?activeId=<?php echo $_smarty_tpl->tpl_vars['letter']->value['active_id'];?>
" class="btn btn-default  ht-create-btn-170 ht-left ht-create-bth-color2" style="margin-left: 16px;">
								参会人名单
							</a>
							<a href="/letter/index.html?id=<?php echo $_smarty_tpl->tpl_vars['letter']->value['active_id'];?>
" class="btn btn-default  ht-create-btn-170 ht-left ht-create-bth-color3 " style="margin-left: 16px;">
								活动邀请函
							</a>
					</div>
					
				</div>
				<div style="clear: both"></div>
			</div>
			<!-- <div class="ui vertical divider">
			Or
			</div> -->
			<div class="ht-right ht-user-active-option-r" >
				<div  class="ht-create-option-margin" style="text-align: center;">
					<div class="title">
						邀请函二维码
					</div>
					<div style="padding-bottom:35px;padding-top: 35px;border-bottom: 1px dashed #E5E5E5;">
						<img style="border:1px solid #CCC;border-radius: 10px;" width="200" height="200" src="/letter/rcode.html?id=<?php echo $_smarty_tpl->tpl_vars['letter']->value['id'];?>
" />
					</div>
				
					<p style="padding-bottom:24px;padding-top: 24px;border-bottom: 1px dashed #E5E5E5;">
                       微信 扫一扫<BR>
						嗨，一份精美的邀请函已经完成了，快拿起手机，使用微信扫描上面的二维码，分享给您的朋友吧！
					</p>
				</div>
			</div>
</div>

</div>



<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2244755e445e8b69b72-77549160');
content_55effd83f13283_83568856($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 17:36:03
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55effd83e42881_19580432')) {function content_55effd83e42881_19580432($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 17:36:03
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55effd83f13283_83568856')) {function content_55effd83f13283_83568856($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 11:23:24
         compiled from "D:\hexing\sp_v1\config/../skins/default\letter\index.html" */ ?>
<?php /*%%SmartyHeaderCode:848155e5131fe82e25-16522904%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '36ea02c54f644ca2039bd7d8b8614249a4b16986' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\letter\\index.html',
      1 => 1441769002,
      2 => 'file',
    ),
    'd517b947717d217bf293488bf6dc1e368345aee0' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\skins\\default\\letter_layout.html',
      1 => 1441768653,
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
  'nocache_hash' => '848155e5131fe82e25-16522904',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e513205a1968_78484084',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_CSS' => 0,
    'SP_URL_STO' => 0,
    'SP_URL_JS' => 0,
    'active' => 0,
    'SP_URL_UPLOAD' => 0,
    'select' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e513205a1968_78484084')) {function content_55e513205a1968_78484084($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\hexing\\sp_v1\\config/../library/third/smarty//plugins\\modifier.date_format.php';
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
邀请函列表
 - 会通</title>
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap.min.css" rel="stylesheet"/>
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
font-awesome.min.css" rel="stylesheet"/>
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
backcommon.css" rel="stylesheet"/>
	<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
letter.css" rel="stylesheet"/>
	<!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap-ie6.css?1">
	<![endif]-->
	<!--Basic Styles-->
    
<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
ie.css">
<![endif]-->

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
 	<!--[if lt IE 8]>
 		<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
font-awesome-ie7.min.css" rel="stylesheet"/>
 	<![endif]-->	
    
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/loader.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/common.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/arttemplate/template-native.js"></script>
<script type="text/javascript">
	var SP_URL_LEETTER = '/letter/index.json?id=<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
';
</script>


</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '848155e5131fe82e25-16522904');
content_55efa62c9fc0f2_55560961($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	

   	
<div class="ht-maincontainer ht-wrapper-1200">
	<div class="/*row*/ ">
		<!--start 面包屑  -->
		<div class="ht-lettr-crumb">
			<div class="ht-lettr-crumb-title">
				
	<a href="/active/index.html">我的活动</a>  > 活动邀请函

			</div>
		</div>
		<!--end 面包屑  -->
		
		<div class="ht-lettr-header">
			<!--start 左边部分 -->
			<div class="ht-lettr-header-left">
				<img <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['thumbnail'])){?>src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
<?php echo $_smarty_tpl->tpl_vars['active']->value['thumbnail'];?>
"<?php }else{ ?>src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
nopic.jpg"<?php }?> height="100%" width="100%" />
			</div>
			<!--end 左边部分 -->
			
			<!--start 中间部分 -->
			<div class="ht-lettr-header-center" >
					<div class="ht-letter-header-center-title">
						<a href="/active/edit.html?id=<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
">
							<span class="ht-left"><i class="ht-auth"></i> <?php echo $_smarty_tpl->tpl_vars['active']->value['title'];?>
 &nbsp;<i class="fa fa-edit" style="font-size:18px!important;"></i></span>
							
						</a>
						
					</div>
					
					<p>
						活动日期：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['activit_start'],"%Y.%m.%d");?>
 ~ <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['activit_end'],"%Y.%m.%d");?>

					</p>
					<?php if ($_smarty_tpl->tpl_vars['active']->value['is_enroll']==1){?>
					<p>
						报名日期：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['enroll_start'],"%Y.%m.%d");?>
 ~ <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['enroll_end'],"%Y.%m.%d");?>

					</p>
					<?php }?>
					<p class="address">
						活动地点：<?php echo $_smarty_tpl->tpl_vars['active']->value['address'];?>

					</p>
			</div>
			<!--end 中间部分 -->
			
			<!--start 右边部分 -->
			<div class="ht-lettr-header-right">
				<div class="ht-letter-right-main">
					<div class="ht-left">
						<img   src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
ioswx.png" />
					</div>
					<div class="ht-left ht-letter-right-wx">
						免费签到工具<br/>
					
						扫描下载(仅支持iOS) 
					</div>
					<div class="ht-clear"></div>
				</div>
			</div>
			<!--end 右边部分 -->
			
		
			<div class="ht-clear"></div>
		</div>
		
		<!--start 页面列表主体 -->
		<div class="/*row*/ ht-lettr-main">
			<div style="float:left;">
				<div class="ht-main-left-list">
					<a href="/letter/index.html?id=<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
" ><i class="ht-auth <?php if (!empty($_smarty_tpl->tpl_vars['select']->value)&&$_smarty_tpl->tpl_vars['select']->value=='letter'){?>ht-auth-ok<?php }?>"></i>邀请函</a>
					<a href="/attendee/index.html?activeId=<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
" ><i class="ht-auth <?php if (empty($_smarty_tpl->tpl_vars['select']->value)||$_smarty_tpl->tpl_vars['select']->value=='attendee'){?>ht-auth-ok<?php }?>"></i>参会人</a>
				</div>
				<div class="ht-clear"></div>
			</div>
			<div class="ht-letter-main-right">
				
	<!--start 创建部分 -->
	<div id="createButton" style="display:none;">
		<div class="ht-letter-createLetter">
			<div class="ht-createLetter-btn-wrapper">
				<i class="ht-createLetter-btn-icon"></i>
				<p>快来创建活动的第一个邀请函吧</p>
				<a href="javascript:addLetter(<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
);" class="btn ht-createLetter-btn  ht-btn-blue">创建邀请函</a>
			</div>
		</div>
	</div>
	<!--end 创建部分-->
	
	<div id="itemlist" ></div>
	<div class="ht-clearL"></div>
	<div id="pagestring" ></div>

			</div>
		</div>
		<!--end 页面列表主体-->
		<div class="ht-clear"></div>
	</div>
</div><div style="height:100px;"></div>

<script id="listtemplate" type="text/html">
<<?php ?>% if (data){ %<?php ?>>
	<<?php ?>% for(var i=0,len=data.length; i<len; i++) { %<?php ?>>
		<!--start 邀请函集合 -->
		<div class="ht-letter-item">
			<div class="ht-left ht-letter-item-img">
				<a href="/letter/show/<<?php ?>%=data[i].sid %<?php ?>>.html"><img  width="170" height="170" src="/letter/rcode.html?id=<<?php ?>%=data[i].id %<?php ?>>" /></a>
				<p>
					微信 扫一扫 分享
				</p>
			</div>
			<div class="ht-right  ht-letter-item-body">
					<div class="ht-letter-item-left" >
						<div class="ht-letter-item-body-top">
							<p class="ht-letter-tit" ><<?php ?>%=data[i].title %<?php ?>></p>
							<p class="ht-letter-text" ><<?php ?>%=data[i].discrib %<?php ?>></p>
						</div>
						<div class="ht-letter-item-body-bottom">
							<<?php ?>%=dateFormat(data[i].crttime * 1000, "yyyy.MM.dd hh:mm") %<?php ?>>
						</div>
					</div>
					<div class="ht-right ht-submenu"  style="border-left:1px solid #CCC;border-bottom:1px solid #CCC;" >
						<div class="ht-submenu-settingbtn" ></div>
						<div class="ht-submenu-item">
							<a href="/active/lettereditor.html?id=<<?php ?>%=data[i].id %<?php ?>>"  target="_black">
								<div class="ht-submenu-btn line">
									<i class="ht-subMenu-icon01"></i>
									<span>编辑</span>
								</div>
							</a>
							<a href="javascript:;" onclick="delLetter('<<?php ?>%=data[i].id %<?php ?>>')">
								<div  class="ht-submenu-btn">
									<i class="ht-subMenu-icon04"></i>
									<span>删除</span>
								</div>
							</a>
						</div>
					</div>
			</div>
			<div class="ht-clear"></div>
		</div>
		<!--end 邀请函集合 -->
	<<?php ?>% } %<?php ?>>
	<!--start 集合添加-->
		<div class="ht-letter-item">
			<a href="javascript:addLetter(<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
);">
				<div class="ht-createLetter-btn-add">
						<i class="ht-createLetter-btn-icon"></i>
						<p style="margin-top: 20px;">你还可以为该活动创建更多的邀请函</p>
				</div>
			</a>
		</div>
	<!--end 集合添加-->
<<?php ?>% } %<?php ?>>	
</script>
<!-- 本页 js -->
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
SysUtil.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
modules/letter/index.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
jquery.placeholder.min.js"></script>
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap-ie.js"></script>
<![endif]-->

<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '848155e5131fe82e25-16522904');
content_55efa62ccd0200_09422601($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 11:23:24
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55efa62c9fc0f2_55560961')) {function content_55efa62c9fc0f2_55560961($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 11:23:24
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55efa62ccd0200_09422601')) {function content_55efa62ccd0200_09422601($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
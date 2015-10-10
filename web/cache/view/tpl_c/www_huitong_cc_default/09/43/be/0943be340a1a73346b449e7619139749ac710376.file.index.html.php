<?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 10:41:27
         compiled from "D:\hexing\sp_v1\config/../skins/default\active\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2600955e5131ad25351-61313704%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0943be340a1a73346b449e7619139749ac710376' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\active\\index.html',
      1 => 1441793772,
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
    '5cd4ed4985f7d017c7db2d4bb5431c1c72d0d598' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\tpl_footer.html',
      1 => 1441001633,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2600955e5131ad25351-61313704',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e5131b74f5b8_65764440',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_CSS' => 0,
    'SP_URL_STO' => 0,
    'SP_URL_JS' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5131b74f5b8_65764440')) {function content_55e5131b74f5b8_65764440($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
活动列表
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
activity.css" rel="stylesheet"/>

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
js/loader.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/arttemplate/template-native.js"></script>

</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2600955e5131ad25351-61313704');
content_55f0edd749e008_51406524($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	

   	
<div class="ht-maincontainer ht-wrapper-1200">
	
	<div class="/*col-md-3*/ ht-pull-left ht-maincontainer-left" style="position:relative;">
		<div class="ht-maincontainer-left-user" >
			<div class="ht-pull-left">
				<img  <?php if (!empty($_smarty_tpl->tpl_vars['user']->value['face'])){?>src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
<?php echo $_smarty_tpl->tpl_vars['user']->value['face'];?>
"<?php }else{ ?>src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
dzx.jpg"<?php }?> />
			</div>
			<div class="ht-pull-left ht-maincontainer-left-user-info">
				<strong><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</strong>
				<p>ID: <?php echo $_smarty_tpl->tpl_vars['user']->value['userid'];?>
</p>
			</div><div class="ht-clearL"></div>
			<div class="ht-main-left-list">
				<?php if ($_smarty_tpl->tpl_vars['user']->value['mobile_status']!='1'){?>
                       <a href="/account/phoneAuth.html" ><i class="ht-mob-not-icon"></i><?php echo $_smarty_tpl->tpl_vars['user']->value['mobile'];?>
</a>
                <?php }else{ ?> 
              		  <a href="javascript:;" ><i class="ht-mob-icon"></i><?php echo $_smarty_tpl->tpl_vars['user']->value['mobile'];?>
</a>               
                <?php }?>
				<?php if ($_smarty_tpl->tpl_vars['user']->value['email_status']!='1'){?>
                       <a href="/account/emailAuth.html" ><i class="ht-mail-not-icon"></i><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</a>             
                <?php }else{ ?>      
               			 <a href="javascript:;" ><i class="ht-mail-icon"></i><?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
</a>          
                <?php }?>
				
			</div>
		</div>
		<a class="ht-user-edit" href="/account/index.html"><i class="fa fa-edit" style="font-size: 24px!important;"></i></a>
	</div>
	<div class="/*col-md-9*/ ht-ignore-padding ht-maincontainer-right ">
		<div class="ht-tab-list" >
            <div class="creation-activity">在这里，添加新活动</div>
			<a title="创建活动" href="/active/create.html"><i class="fa fa-plus ht-tab-create-btn"></i></a>
			<span id="httab">
			<a id="all" href="javascript:;" class="ht-tab ht-tab-on"><i>全部项目</i></a><!--
            --><a id="ing" href="javascript:;" class="ht-tab"><i>进行中</i></a><!--
            --><a id="end" href="javascript:;" class="ht-tab"><i>已结束</i></a>
			</span>
			<div class="ht-clear"></div>
		</div>
		
		<div id="createButton" style="display:none;">
			<div class="ht-createActivity">
				<div class="ht-createActivity-btn-wrapper">
					<i class="ht-createActivity-btn-icon"></i>
					<p>创建一个活动</p>
					<a href="/active/create.html" class="ht-createActivity-btn">创建活动</a>
				</div>
			</div>
		</div>
		
		<!-- 列表 -->
		<div id="itemlist" class="ht-activity-list"></div>
		<div class="ht-clearL"></div>
		<div id="pagestring" ></div><div class="ht-clear"></div>
	</div>
	
	<div class="ht-clear"></div>



<script id="listtemplate" type="text/html">
<<?php ?>% if (data){ %<?php ?>>
<<?php ?>% for(var i=0,len=data.length; i<len; i++) { %<?php ?>>
<div class="ht-activity-item ">
<!-- 子菜单 -->
	<span class="ht-submenu">
		<b class="ht-submenu-settingbtn"></b>
		<div class="ht-submenu-item">
			<a href="/active/edit.html?id=<<?php ?>%=data[i].id %<?php ?>>" class="line">
				<i class="ht-subMenu-icon01"></i>
				<span>编&nbsp;&nbsp;&nbsp;辑</span>
			</a>
			<<?php ?>% if(isGonging(nowtime, data[i].activit_start, data[i].activit_end)){ %<?php ?>>
			<!--
			<a href="javascript:;" class="line">
				<i class="ht-subMenu-icon01"></i>
				<span>编&nbsp;&nbsp;&nbsp;辑</span>
			</a>
			<a href="" class="line">
				<i class="ht-subMenu-icon01"></i>
				<span>统&nbsp;&nbsp;&nbsp;计</span>
			</a>
			<a href="javascript:;" class="line" onclick="shareActive('1', '<<?php ?>%=data[i].title %<?php ?>>')">
				<i class="ht-subMenu-icon01"></i>
				<span>分&nbsp;&nbsp;&nbsp;享</span>
			</a>
			-->
			
			<a href="/letter/index.html?id=<<?php ?>%=data[i].id %<?php ?>>" class="line">
				<i class="ht-subMenu-icon02"></i>
				<span>邀请函</span>
			</a>
			<<?php ?>% } %<?php ?>>
			<a href="/attendee/index.html?activeId=<<?php ?>%=data[i].id %<?php ?>>" class="line">
				<i class="ht-subMenu-icon03"></i>
				<span>参会人</span>
			</a>
			<a href="javascript:;" onclick="delActive('<<?php ?>%=data[i].id %<?php ?>>')">
				<i class="ht-subMenu-icon04"></i>
				<span>删&nbsp;&nbsp;&nbsp;除</span>
			</a>
		</div>
	</span>
	<div class="ht-activity-item-img">
		<a href="/letter/index.html?id=<<?php ?>%=data[i].id %<?php ?>>"><img class="lazy" data-original="<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
<<?php ?>%=data[i].thumbnail %<?php ?>>" onload="nopic(this)" /></a>
	</div>
	<div class="ht-activity-item-info">
		<i class="ht-auth"></i>
		<a class="ht-activity-tit" href="/letter/index.html?id=<<?php ?>%=data[i].id %<?php ?>>"><<?php ?>%=data[i].title %<?php ?>></a>
		<<?php ?>% if(isGonging(nowtime, data[i].activit_start, data[i].activit_end)){ %<?php ?>>
		<a href="javascript:;" class="ht-btn-blue ht-activity-item-info-btn">进行中</a>
		<<?php ?>% } else { %<?php ?>>
		<a href="javascript:;" class="ht-btn-blue ht-activity-item-info-btn disabled">已结束</a>
		<<?php ?>% } %<?php ?>>
	</div>
	<div class="ht-activity-item-time">
		<p>活动时间：
			<<?php ?>%=dateFormat(data[i].activit_start * 1000, "yyyy.MM.dd hh:mm") %<?php ?>> - 
			<<?php ?>%=dateFormat(data[i].activit_end * 1000, "yyyy.MM.dd hh:mm") %<?php ?>>
		</p>
		<<?php ?>% if(data[i].is_enroll == 1){ %<?php ?>>
		<p>报名时间：
			<<?php ?>%=dateFormat(data[i].enroll_start * 1000, "yyyy.MM.dd hh:mm") %<?php ?>> - 
			<<?php ?>%=dateFormat(data[i].enroll_end * 1000, "yyyy.MM.dd hh:mm") %<?php ?>>
		</p>
		<<?php ?>% } %<?php ?>>
	</div>
	<div class="ht-activity-item-bottom">
		<i class="ht-icon-address">地址</i>
		<<?php ?>%=data[i].address %<?php ?>>
	</div>
</div>
<<?php ?>% }} %<?php ?>>
</script>

</div>

<!-- 本页 js -->
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/jquery.lazyload.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/jquery.lazyload.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/ytab.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/SysUtil.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
modules/activity/ajaxload.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
modules/activity/index.js"></script>

<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2600955e5131ad25351-61313704');
content_55f0edd77250b1_32065661($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 10:41:27
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55f0edd749e008_51406524')) {function content_55f0edd749e008_51406524($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 10:41:27
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55f0edd77250b1_32065661')) {function content_55f0edd77250b1_32065661($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
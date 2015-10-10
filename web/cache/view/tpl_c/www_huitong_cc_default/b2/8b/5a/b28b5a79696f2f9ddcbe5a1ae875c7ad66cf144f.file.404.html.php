<?php /* Smarty version Smarty-3.1.8, created on 2015-09-09 19:43:31
         compiled from "D:\hexing\sp_v1\config/../skins/default\error\404.html" */ ?>
<?php /*%%SmartyHeaderCode:2229655e5213c8c0375-45316985%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b28b5a79696f2f9ddcbe5a1ae875c7ad66cf144f' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\error\\404.html',
      1 => 1441793772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2229655e5213c8c0375-45316985',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e5213c9c4d13_48439475',
  'variables' => 
  array (
    'SP_URL_STO' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e5213c9c4d13_48439475')) {function content_55e5213c9c4d13_48439475($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<title>404 找不到对应的页面</title>
		<meta name="description" content="" />
		<meta name="author" content="Administrator" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
		<link rel="shortcut icon" href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/backcommon.css">
        <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
css/error.css">
	</head>
	<body>
        <div class="hr-404-top"><a href="/"></a></div>
		<div class="ht-404-box">
           <div class="ht-404-icon"></div>
             <h3>哎呀亲...你访问的页面出错了</h3>
             <p>你输入的网址有误或者链接已经过期。</p>
             <a class="ht-goHome" href="/">返回首页</a>
        </div>
        <?php echo $_smarty_tpl->getSubTemplate ("../tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</body>
</html>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 17:16:08
         compiled from "D:\hexing\sp_v1\config/../skins/default\active\create.html" */ ?>
<?php /*%%SmartyHeaderCode:172155e55e8d178fc0-02168678%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1f9db320cf7c3b8e165d1d8cade84d54f884dec' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\active\\create.html',
      1 => 1442314006,
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
  'nocache_hash' => '172155e55e8d178fc0-02168678',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e55e8d88f4f5_77598621',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_CSS' => 0,
    'SP_URL_STO' => 0,
    'SP_URL_JS' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e55e8d88f4f5_77598621')) {function content_55e55e8d88f4f5_77598621($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\hexing\\sp_v1\\config/../library/third/smarty//plugins\\modifier.date_format.php';
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
	<?php if (!empty($_smarty_tpl->tpl_vars['option']->value)){?><?php echo $_smarty_tpl->tpl_vars['active']->value['title'];?>
<?php }else{ ?>创建活动<?php }?>
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
activity-create.css" rel="stylesheet"/>
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
notify.css">
	<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
bootstrap-select.min.css">
	<!--[if lte IE 7]>
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
    
	 <script type="text/javascript">
	 	var SP_POLICY = "<?php echo $_smarty_tpl->tpl_vars['uploadInfo']->value['policy'];?>
", SP_SIGNATURE = "<?php echo $_smarty_tpl->tpl_vars['uploadInfo']->value['sign'];?>
";
	 </script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap-select.min.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
ytab.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
WdatePicker.js"></script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
posfixed.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/handlers.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.queue.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
jquery.validate.min.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
jquery.form.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/notify/notify.js"></script>

</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '172155e55e8d178fc0-02168678');
content_55fa84d8de4e57_65991872($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	

 <div class="ht-attached ht-user-header" id="header_title" >
 	<div class="ht-wrapper-1200" >
		<span class="ht-left ht-create-margin-top-8"  >
			<a href="/active/index.html">我的活动</a>
			 >
			<?php if (!empty($_smarty_tpl->tpl_vars['option']->value)){?> 
				<?php echo $_smarty_tpl->tpl_vars['active']->value['title'];?>

			<?php }else{ ?>
			创建活动
			<?php }?>
		</span>
		
		<a href="javascript:void(0);" id="active_submit"  class="btn btn-default ht-right  ht-create-btn-120 ht-create-bth-color2  ht-create-margin-top-8"  > 保 存 </a>
 	</div>
 </div>

   	
<div class="ht-maincontainer ht-wrapper-1200">
	
	<form id="active_create" <?php if (!empty($_smarty_tpl->tpl_vars['option']->value)){?>action="/active/edit.json?id=<?php echo $_smarty_tpl->tpl_vars['active']->value['id'];?>
"<?php }else{ ?>action="/active/create.json"<?php }?>>
	<div class="row" style="margin-left: 0px!important;margin-right:0px!important;background:#fcfcfc">
			<div class="ht-left ht-user-active-option-l" >
				<div class="ht-user-active-option">
					<div class="title">
						活动基本信息
					</div>
					<div class="form-group">
						<label for="exampleInputEmail1">活动标题</label>
						<input class="form-control input" name="title" value="<?php echo $_smarty_tpl->tpl_vars['active']->value['title'];?>
" type="text" style="min-width:95%;width: auto;" />
					</div>
					<div class="form-group" >
						<label>举办日期</label>
						<div class="form-inline">
							<input value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['activit_start'],"%Y-%m-%d %H:%S");?>
" class="Wdate form-control input ht-left" style="width: 200px;" id="activit_start" name="activit_start" validate="required:false" type="text" placeholder="开始时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})" />
							<span  class="ht-left ht-create-margin-left-10 ht-create-margin-right-10"> — </span>
							<input value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['activit_end'],"%Y-%m-%d %H:%S");?>
" class="Wdate form-control input" style="width: 200px;" id="activit_end" name="activit_end" type="text" placeholder="结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})" onclick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})" />
						</div>
					</div>
					<div class="form-group  ht-activity-line-32">
						<label>活动城市</label>
						<div class="form-inline ht-heihgt-32" style="*z-index:9;*position:relative">
							<select name="province" id="province"  class="selectpicker  ht-create-select ht-left">
									<option selected="true" value="" disabled="true">省</option>
									<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
										<option <?php if ($_smarty_tpl->tpl_vars['active']->value['province']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?>  value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
									<?php } ?> 
							</select>
							
							<select name="city" id="city"  class=" selectpicker ht-create-margin-left-10 ht-create-margin-right-10  ht-left  ht-create-select">
								<option selected="true" value="" disabled="true" >市</option>
								<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
										<option <?php if ($_smarty_tpl->tpl_vars['active']->value['city']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
								<?php } ?> 
								
							</select>
							
							<select name="arrea" id="arrea"  class="selectpicker  ht-create-select">
								<option selected="true" value="" disabled="true">区</option>
								<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['arrea']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
										<option  <?php if ($_smarty_tpl->tpl_vars['active']->value['arrea']==$_smarty_tpl->tpl_vars['item']->value['id']){?> selected="selected" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
								<?php } ?> 
							</select>
							
						</div>
						<div id="citys_error" class="error"></div>
					</div>
					<div class="form-group ht-activity-line-32" style="clear: both;">
						<label>详细地址</label>
						<input  value="<?php echo $_smarty_tpl->tpl_vars['active']->value['address'];?>
" class="form-control input" style="min-width:95%;width: auto;" name="address" type="text">
					</div>
					<div class="form-group  ht-activity-line-32" >
						<label>活动封面</label>
						<div >
							<div  style="width:235px;float: left;position:relative;">
								<img id="active_img" class="image" <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['thumbnail'])){?>src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_UPLOAD']->value;?>
<?php echo $_smarty_tpl->tpl_vars['active']->value['thumbnail'];?>
"<?php }else{ ?> src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
upload.jpg" <?php }?> />
								<input type="hidden" name="thumbnail" id="thumbnail" value="<?php echo $_smarty_tpl->tpl_vars['active']->value['thumbnail'];?>
" />
								<div id="progress_num" style="display: none;">100%</div>
							</div>
							<div style="float: left;margin-left: 25px;">
									
									<!-- <a href="javascript:void(0);" class="btn btn-default  ht-create-btn-170 ht-create-bth-color2" style="height: 36px;padding: 0px!important;line-height: 36px;"> 选择封面 </a>
									<br/><br/> -->
									<a href="javascript:void(0)"  class="btn btn-default  ht-create-btn-170 ht-create-bth-color2" style="width: 170;height: 36px;padding: 0px!important;">
										<div style="position:relative;">
											<span style="position:absolute;left:0;top:0;line-height: 36px;" class="ht-create-btn-170">自定义封面</span>
		                                    <span  class="img-responsive center-block uploadButton" data-success="onCallingCardUploaded"></span>
		                                    <div>
		                                        <div id="divStatus" style="display: none;">0 个文件已上传</div>
		                                        <input id="btnCancel" type="button" style="display: none" onclick="swfu.cancelQueue();"/>
		                                    </div>
										</div>
	                                </a>
								<div class="ht-margin-top-8" >请上传5M以内jpg、png、gif<br/>建议500*300尺寸图片</div>
							</div>
						</div>
					</div>
					<div style="clear: both"></div>
				</div>
			</div>

			<div class="ht-right ht-user-active-option-r">
				<div class="ht-user-active-option">
					<div class="title">
						活动设置
					</div>
					
					<div class="enrollck">
						<div <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['is_enroll'])){?> class="ht-active-checkbox-on" <?php }else{ ?> class="ht-active-checkbox" <?php }?> id="enrollck_div">
							<input id="enrollck" name="is_enroll" value="1" type="checkbox" <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['is_enroll'])){?> checked="checked" <?php }?>  />
						</div>
						<span>需要报名</span>
					</div>
					
					<div class="hr"></div>
					
					<div id="enrolldate" <?php if (empty($_smarty_tpl->tpl_vars['active']->value['is_enroll'])){?> style="display: none;" <?php }?>>
						<div class="form-group ht-activity-line-32">
							<label>报名起止日期</label>
							<div  class="form-inline">
								<input <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['enroll_start'])){?> value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['enroll_start'],"%Y-%m-%d %H:%S");?>
"<?php }?> class="Wdate form-control input" style="float: left;width: 150px!important;" id="enroll_start" name="enroll_start"  type="text" placeholder="开始时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-%d %H:%m'})" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})"  /> 
								 <span style="float: left;margin-left: 10px;margin-right: 10px;"> — </span>
								<input <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['enroll_end'])){?> value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['active']->value['enroll_end'],"%Y-%m-%d %H:%S");?>
"<?php }?> class="Wdate form-control input" style="float: left;width: 150px!important;" id="enroll_end" name="enroll_end"  type="text" placeholder="结束时间" onfocus="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-%d %H:%m'})" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:00',minDate:'%y-%M-{%d+1} %H:%m'})"  />
							</div>
						</div>
						
						<div class="form-group ht-activity-line-32" style="clear: both;">
							<label>活动人数（最大支持参与人数，如不限制请填0）</label>
							<input class="form-control input" <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['enroll_end'])){?> value="<?php echo $_smarty_tpl->tpl_vars['active']->value['enroll_num'];?>
" <?php }?> name="enroll_num" type="text" style="min-width:95%;width: auto;" />
						</div>
						
						<div class="hr"></div>
					</div>	
					
					
					<div  style="margin-bottom: 2px !important;">
						<div <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['is_audit'])){?> class="ht-active-checkbox-on" <?php }else{ ?> class="ht-active-checkbox" <?php }?> id="is_audit_div">
							<input id="is_audit" name="is_audit" value="1" type="checkbox" <?php if (!empty($_smarty_tpl->tpl_vars['active']->value['is_audit'])){?> checked="checked" <?php }?>  readonly="readonly"/>
						</div>
						<span>需要审核（报名人员被审核通过后，才能收到参会签到名片）</span>
					</div>
				</div>
			</div>

	</div>
	</form>	

</div>

	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap.min.js"></script>
	<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
jquery.placeholder.min.js"></script>
	<!--[if lte IE 6]>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
bootstrap-ie.js"></script>
	<![endif]-->
	<script type="text/javascript">
	<?php if (!empty($_smarty_tpl->tpl_vars['option']->value)){?>
	var SP_ACTIVE = 'edit';
	<?php }else{ ?>
	var SP_ACTIVE = 'add';
	<?php }?>
	(function ($) {
	$(document).ready(function() {
		if ($.isFunction($.bootstrapIE6)) $.bootstrapIE6($(document));
	});
	})(jQuery);
	</script>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
modules/activity/create.js"></script>
	

<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '172155e55e8d178fc0-02168678');
content_55fa84d94b4d39_90340574($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 17:16:08
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55fa84d8de4e57_65991872')) {function content_55fa84d8de4e57_65991872($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-17 17:16:09
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55fa84d94b4d39_90340574')) {function content_55fa84d94b4d39_90340574($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
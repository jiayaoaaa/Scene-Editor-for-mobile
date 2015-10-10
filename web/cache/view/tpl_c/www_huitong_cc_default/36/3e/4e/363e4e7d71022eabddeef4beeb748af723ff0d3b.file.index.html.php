<?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 15:57:29
         compiled from "D:\hexing\sp_v1\config/../skins/default\attendee\index.html" */ ?>
<?php /*%%SmartyHeaderCode:2095755ee83d478f827-40706279%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '363e4e7d71022eabddeef4beeb748af723ff0d3b' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\attendee\\index.html',
      1 => 1441694789,
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
  'nocache_hash' => '2095755ee83d478f827-40706279',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55ee83d4e8e345_24353708',
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
<?php if ($_valid && !is_callable('content_55ee83d4e8e345_24353708')) {function content_55ee83d4e8e345_24353708($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\hexing\\sp_v1\\config/../library/third/smarty//plugins\\modifier.date_format.php';
?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
我的参会人
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
    
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
notify.css">
<link href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
attendee.css" rel="stylesheet"/>
<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_CSS']->value;?>
ie.css">
<![endif]-->
<style type="text/css">
	.webuploader-pick{
		margin-left: 15px;
	}	
</style>

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
    
<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
json2.js"></script>
<![endif]-->
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
SysUtil.js"></script>
<script type="text/javascript">
    var tableSet = JSON.parse('<?php echo $_smarty_tpl->tpl_vars['headerSet']->value;?>
');
    var activeId = <?php echo $_smarty_tpl->tpl_vars['activeId']->value;?>
;
    if(false == tableSet){
        var tableSet = {
            0:{"isShow":"1","title":"姓名","field":"name"},
            1:{"isShow":"1","title":"手机","field":"phone"},
            2:{"isShow":"0","title":"邮箱","field":"email"},
            3:{"isShow":"0","title":"职位","field":"position"},
            4:{"isShow":"0","title":"公司名称","field":"company"},
            5:{"isShow":"0","title":"公司地址","field":"address"},
            6:{"isShow":"0","title":"性别","field":"sex"}
        };
    }
    var flag = "<?php echo $_smarty_tpl->tpl_vars['flag']->value;?>
";
    if(flag){
        Notify.log("文件上传成功");
    }
</script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/loader.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/common.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/bootstrap.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
vendor/notify/notify.js"></script>

</head>

<body >
<?php /*  Call merged included template "tpl_header.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2095755ee83d478f827-40706279');
content_55f137e963c132_75358111($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_header.html" */?>
   	

   	
<div class="ht-maincontainer ht-wrapper-1200">
	<div class="/*row*/ ">
		<!--start 面包屑  -->
		<div class="ht-lettr-crumb">
			<div class="ht-lettr-crumb-title">
				
<a href="/active/index.html">我的活动</a>  > 我的参会人

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
				
<div class="attendee_box">
    <div class="attendee_header">
        <!--<p class=" btn-green">
            <span class="btn-left"></span>
            <span class="btn-mid">添加参会人</span>
            <span class="btn-right"></span>
        </p>
        <p class="btn btn-blue">
            <span class="btn-left"></span>
            <span class="btn-mid">导入参会人</span>
            <span class="btn-right"></span>
        </p>-->
        <div class="left" style="padding-right:5px">
            <button type="button" class="btn ht-btn-blue" id="add-attendee" >添加参会人</button>
            <button type="button" class="btn ht-btn-blue" style="*+margin-left: 8px;" id="import-attendee">导入参会人</button>
        </div>
        <div class="dropdown active left">
            <a id="drop4" class="btn ht-btn-blue" style="*+font-size: 16px!important;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                操作  <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDrop1">
                <li class=""><a href="javascript:void(0)" action="set-attendee" action-type="signIn">设为已签到</a></li>
                <li class=""><a href="javascript:void(0)" action="set-attendee" action-type="signOut">设为未签到</a></li>
                <li role="separator" class="divider"></li>
                <li class=""><a href="javascript:void(0)" action="set-attendee" action-type="delete">删除</a></li>
            </ul>
        </div>
        <button type="button" class="btn ht-btn-green" style="float:right;" id="table-set">表单设置</button>
    </div>
    <div class="attendee_content">
        <table class="table table-hover table-bordered" id="attendee-table">
            <tr >
                <th width="12">
                    <label>
                        <input type="checkbox" id="checkAll">
                    </label>
                </th>
<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['header']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value){
$_smarty_tpl->tpl_vars['list']->_loop = true;
?>
                <th><?php echo $_smarty_tpl->tpl_vars['list']->value;?>
</th>
<?php } ?>
				<th>签到</th>
				<th>报名状态</th>
                <th>操作</th>
            </tr>
			<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value){
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
			            <tr action="select" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
			                <td action="check">
			                    <label>
			                        <input type="checkbox" class="HTDataSelect" />
			                    </label>
			                </td>
						    <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
						        <?php if (('id'!=$_smarty_tpl->tpl_vars['key']->value&&'status'!=$_smarty_tpl->tpl_vars['key']->value&&'checkStatus'!=$_smarty_tpl->tpl_vars['key']->value)){?>
						                <td><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</td>
						        <?php }?>
						    <?php } ?>  
			    			<td><?php if ($_smarty_tpl->tpl_vars['val']->value['status']==0){?>未签到<?php }else{ ?><b style="color: red;">已签到</b><?php }?></td>     
			    			<td><?php if ($_smarty_tpl->tpl_vars['val']->value['checkStatus']==0){?>审核中<?php }elseif($_smarty_tpl->tpl_vars['val']->value['checkStatus']==1){?><b style="color: red;">成功</b><?php }else{ ?>未通过<?php }?></td>     
			                <td>
			                	<?php if ($_smarty_tpl->tpl_vars['val']->value['status']==0&&$_smarty_tpl->tpl_vars['val']->value['checkStatus']==0){?><button onclick="sendmsg(<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['activeId']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['phone'];?>
',this)">发送电子票</button><button onclick="refuse(<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['activeId']->value;?>
,this)">拒绝</button><?php }elseif($_smarty_tpl->tpl_vars['val']->value['status']==0&&$_smarty_tpl->tpl_vars['val']->value['checkStatus']==1){?><button onclick="sendmsg(<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
,<?php echo $_smarty_tpl->tpl_vars['activeId']->value;?>
,'<?php echo $_smarty_tpl->tpl_vars['val']->value['phone'];?>
',this)">重发电子票</button><?php }?>
			                </td>
			            </tr>
			<?php } ?>
        </table>
        <?php echo $_smarty_tpl->tpl_vars['page']->value;?>

    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" id="modal-dialog">
        <div class="modal-content" id="modal-content" >
            <div class="attend-model-header">
                <p class="attend-model-header-title">添加参会人</p>
            </div>
            
            <div class="attend-model-footer">
                <button type="button" class="btn ht-btn-blue" style="float:left;width:200px;" data-dismiss="modal">保存</button>
                <button type="button" class="btn ht-btn-gray" style="float:right;width:200px;">取消</button>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalFile" tabindex="-2" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document" id="modal-dialog">
	    <div class="modal-content">
	        	<div class="attend-model-header">
	            	<p class="attend-model-header-title">导入参会人名单</p>
	       		</div>
	            <div class="attend-model-content" style="width:415px;text-align:left;">
	                <div id="uploader" class="wu-example">
		                <div  style="margin-top:10px;height:40px;">
		        			<input type="text" name="file" id="file-name" class="form-control left" style="width:310px;height:40px;*+width:270px;*+height:25px;margin-right: 10px;" readonly value="请选择CSV或EXCEL文件" />
		        			<a href="javascript:void(0)"  class="btn ht-btn-green  ht-create-btn-80 " style="width: 80px;height: 40px;padding: 0px!important; text-align:center">
								<div style="position:relative;">
									<span style="position:absolute;left:0;top:0;line-height: 40px; text-align:center" class="ht-create-btn-80">选择文件</span>
                                    <span  class="img-responsive center-block uploadButton" id="uploadButton"></span>
                                    <div>
                                        <div id="divStatus" style="display: none;"></div>
                                        <input id="btnCancel" type="button" style="display: none" onclick="swfu.cancelQueue();"/>
                                    </div>
								</div>
                            </a>
				    	 	<div style="height:0px;font-size: 0px;clear: both;" ></div>
		        			<div class="clear"></div>
		        		</div>
				    	<div class="item" id="item"></div>
			  		</div>
			  	  <div id="swfileProcess" style="display: none;"> 
					    <div id="swfileProcessSize" style="width: 0%;"> 
					        <span id="swfileProcessTxt"></span> 
					    </div> 
				  </div> 
	              请按模板格式添加人员名单，<a href="/attendee/export.html" style="color:#337ab7">下载参会人名单模板</a>
	       	   </div>
	            <div class="attend-model-footer">
	                <button type="button" class="btn left ht-btn-blue" style="width:200px;opacity:1"  id="ctlBtn"  disabled="disabled" >上传</button>
	                <button type="button" class="btn ht-btn-gray" style="float:right;width:200px;" data-dismiss="modal">取消</button>
	            </div>
	        <div class="clear"></div>
	    </div>
	</div>    
</div>

			</div>
		</div>
		<!--end 页面列表主体-->
		<div class="ht-clear"></div>
	</div>
</div><div style="height:100px;"></div>



<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
jquery.placeholder.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/swfupload.cookie.js"></script>
<!-- <script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_JS']->value;?>
swfupload/js/fileprogress.js"></script> -->
<script type="text/javascript">
	var SP_URL_HOME = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
',SP_SSION = '<?php echo session_id();?>
';
</script>
<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_STO']->value;?>
js/attendee.js"></script>
<!-- 本页 js -->

<?php /*  Call merged included template "tpl_footer.html" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("tpl_footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0, '2095755ee83d478f827-40706279');
content_55f137e9a91908_85449123($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); /*  End of included template "tpl_footer.html" */?>
</body>
</html>
<?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 15:57:29
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_header.html" */ ?>
<?php if ($_valid && !is_callable('content_55f137e963c132_75358111')) {function content_55f137e963c132_75358111($_smarty_tpl) {?><div class="ht-header">
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
</div><?php }} ?><?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 15:57:29
         compiled from "D:\hexing\sp_v1\config/../skins/default\tpl_footer.html" */ ?>
<?php if ($_valid && !is_callable('content_55f137e9a91908_85449123')) {function content_55f137e9a91908_85449123($_smarty_tpl) {?> <div class="ht-footer-box"><div class="ht-user-footer">
 	<!-- 	<div class="ht-bottom-nav"><a href="#" target="_blank">关于会场云</a> | <a href="#" target="_blank">联系我们</a> </div> -->
        <div class="ht-copyright">Copyright © <script type="text/javascript">var data = new Date(); document.write(data.getFullYear());</script> All Rights Reserved 会通V1.0  经营许可证编号：京ICP备09035497号-8</div> 
 </div></div><?php }} ?>
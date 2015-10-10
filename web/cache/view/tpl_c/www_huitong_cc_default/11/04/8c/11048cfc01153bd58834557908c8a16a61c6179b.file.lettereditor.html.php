<?php /* Smarty version Smarty-3.1.8, created on 2015-09-10 12:32:26
         compiled from "D:\hexing\sp_v1\config/../skins/default\active\lettereditor.html" */ ?>
<?php /*%%SmartyHeaderCode:2950555e445a32a22d1-00484051%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11048cfc01153bd58834557908c8a16a61c6179b' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\active\\lettereditor.html',
      1 => 1441859540,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2950555e445a32a22d1-00484051',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e445a332b749_51464710',
  'variables' => 
  array (
    'SP_URL_IMG' => 0,
    'SP_URL_HOME' => 0,
    'id' => 0,
    'active' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e445a332b749_51464710')) {function content_55e445a332b749_51464710($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>邀请函制作</title>
<link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
css/editor.css">
<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
css/animate.lib.css">
<script>
var SP_URL_STO = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
'
var SP_LETTER_ID = '<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
'
</script>


<script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
vendor/require/require.js" data-main="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
editor.js"></script>

</head>
<body oncontextmenu="return false">
  <div id="loading">
  <h3>
    会议邀请函 在线制作</h3>
</div> 


  <!--[if lt IE 10]> 
  <div id="loading">
  <h3>
请使用 <a href="http://dlsw.baidu.com/sw-search-sp/soft/51/11843/Firefox_V40.0.3.5716_setup.1440733002.exe">火狐</a>、<a href="http://dlsw.baidu.com/sw-search-sp/soft/9d/14744/ChromeStandalone_V45.0.2454.85_Setup.1441175508.exe">谷歌</a> 或 IE9以上的浏览器来制作
    </h3>
</div>


  <![endif]-->

<div id="root"  ms-controller="root">
  <div class="top-box">
    <div class="top-box-r fr">
    <button ms-click="saveAll" class="btn-blue">保存</button>
    <button ms-click="saveDone" class="btn-blue">完成</button>

    </div>
    <div class="top-box-l fl"><a href="javascript:void(0);"  ms-click="addPage" ><i class="yqh-icon01"></i><b>添加页面</b></a><a href="javascript:void(0);" ms-click="baseSetting"><i class="yqh-icon02"></i><b>基本设置</b></a></div>
    <div class="top-box-c">
    <a href="javascript:void(0);" ms-click="insertSingleTxt" ><i class="yqh-icon03" ></i><b>文本</b></a>
    <a href="javascript:void(0);"  ms-click="insertSingleImage"><i class="yqh-icon04"  ></i><b>图片</b></a>
    <?php if ($_smarty_tpl->tpl_vars['active']->value['is_enroll']==1){?><a href="javascript:void(0);" ms-click="insertForm"><i class="yqh-icon05" ></i><b>报名表单</b></a><?php }?>
<!--    <a href="javascript:void(0);"><i class="yqh-icon06"></i><b>多人物</b></a>
    <a href="javascript:void(0);"><i class="yqh-icon07"></i><b>日程</b></a>-->
    </div>
  </div>
  <!-- /.container-fluid -->
  <hr>
  <div class="editor-content fix">
    <div id="pageTree" ms-controller="pageTree">
      <ul>
        <li ms-repeat="pageArr" ms-click="showpage($index)"  ms-class="active:curPageIndex==$index"> <span class="up"></span> <span class="down"></span> <span class="close"  ms-click="remove($index,$event)"></span> 
                <span class="pageNum">第{{$index+1}}页</span>
          <div class="inner" > </div>
        </li>
      </ul>
    </div>
    <div id="editorContent"  ms-controller="editor">
<!--      <div id="toolbar">
        <button class="btn  btn-default btn-small" ms-attr-disabled="haspage" ms-click="insertSingleTxt">插入文字</button>
        <button class="btn btn-mini btn-default" ms-attr-disabled="haspage"  ms-click="insertSingleImage" >插入图片</button>
        <button class="btn btn-mini btn-default" ms-attr-disabled="haspage" ms-click="insertForm" >报名表单</button>
      </div>-->
      <div id="editor">
        <div id="editorFrame" class="m-editor"  ms-css-background-color="curPage.pagebgColor">
          <div 
          class="elements" ms-repeat-elment="curPage.comInsList" 
          ms-css-left="{{elment.left}}px" 
          ms-css-top="{{elment.top}}px" 
          ms-css-width="{{elment.width}}px" 
          ms-css-height="{{elment.height}}px" 
         ms-css-animation="{{elment.animationName}} {{elment.animationDuration}}s ease {{elment.animationDelay}}s {{elment.animationIterationCount}}" 
         ms-css-opacity="{{elment.opacity/100}}"  
         ms-css-background-color="{{elment.backgroundColor}}"
         ms-css-z-index="elment.zIndex"   
         ms-resizable="editor" 
         ms-class="selected:selectedIndex==$index" 
         ms-mousedown="chooseElements($index,$event)"

         > 
                <img class="singleimg" ms-if="elment.type=='image'" ms-attr-src="elment.imageUrl" />
            <div ms-if="elment.type=='text'" class="singletxt" 
                    ms-css-font-size="{{elment.fontSize}}" 
                    ms-css-color="{{elment.fontColor}}" 
                    ms-css-line-height="{{elment.lineHeight}}"  
                    ms-css-text-align="{{elment.textAlign}}" 
                    > {{elment.textcontent}} </div>
            <div ms-if="elment.type=='form'" class="singleform" >
              <div class="form-group "  ms-each="elment.formElment">
                <div class="clearfix form-line" ms-visible="el.ischecked"> <i>{{el.label}}</i>
                  <input ms-if="el.type=='text'" ms-attr-name="{{el.name}}" ms-attr-type="{{el.type}}"  >
                  <!--ms-attr-placeholder="{{el.label}}" -->
                  
                  <label ms-if="el.type=='radio'" style="margin-left:3em">
                    <input  ms-attr-name="{{el.radioname}}" ms-attr-type="{{el.type}}"  >
                    {{el.text1}}</label>
                  <label ms-if="el.type=='radio'" >
                    <input  ms-attr-name="{{el.radioname}}" ms-attr-type="{{el.type}}"  >
                    {{el.text2}}</label>
                </div>
              </div>
              <div id="formSubmitBtn">提交</div>
            </div>
          </div>
          <ul class="u-Layer-ctrl" ms-visible="ctrl.isShowLayerCtrl" ms-css-top="ctrl.layerTop" ms-css-left="ctrl.layerLeft">
                 <li ms-on-mousedown="toUpLayer($event)" ms-class="disable: ctrl.isTopLayer">上移一层</li>
                           <li ms-on-mousedown="toDownLayer($event)" ms-class="disable: ctrl.isBottomLayer">下移一层</li>
                           <li ms-on-mousedown="toTopLayer($event)" ms-class="disable: ctrl.isTopLayer">移到最顶层</li>
                            <li ms-on-mousedown="toBottomLayer($event)" ms-class="disable: ctrl.isBottomLayer">移到最底层</li>
            <li class="last" ms-on-mousedown="deleteComponent($event)">删除</li>
          </ul>
        </div>
      </div>
    </div>
    <div id="sidebar">
      <div ms-include-src="mainconfigSrc"></div>
      <div ms-include-src="consconfigSrc"></div>
      <div ms-include-src="pageconfigSrc"></div>
    </div>
  </div>
  
  <!--insertImage--> 
  
  <!--     <form action="/lettermaterial/upload.json?type=music" class="dropzone" id="insertImage" >
    <div class="dz-default dz-message"><h4>+ 点击或拖拽图片到此区域</h4></div>

       </form>
 -->
  
  <div id="insertImageTpl" style="display:none">
    <div class="dz-preview dz-file-preview"> <img data-dz-thumbnail />
      <div class="action"> <a   class="inset-btn" >插入</a> <a  data-dz-remove >删除</a> </div>
    </div>
    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
  </div>
</div>

<!--/insertImage-->

</div>

<!--template-->

<div id="tplForUploadImage" style="display:none">
  <div class="dz-image-preview">
    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress>上传中,请稍后...</span></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
  </div>
</div>
<!--/template-->





</body>
</html>
<?php }} ?>
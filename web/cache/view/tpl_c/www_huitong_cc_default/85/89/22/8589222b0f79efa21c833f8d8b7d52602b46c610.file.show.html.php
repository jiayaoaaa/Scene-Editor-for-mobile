<?php /* Smarty version Smarty-3.1.8, created on 2015-09-15 19:38:44
         compiled from "D:\hexing\sp_v1\config/../skins/default\letter\show.html" */ ?>
<?php /*%%SmartyHeaderCode:715255e51ba53f5eb0-97576587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8589222b0f79efa21c833f8d8b7d52602b46c610' => 
    array (
      0 => 'D:\\hexing\\sp_v1\\config/../skins/default\\letter\\show.html',
      1 => 1442317121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '715255e51ba53f5eb0-97576587',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_55e51ba5494924_52276198',
  'variables' => 
  array (
    'letter' => 0,
    'SP_URL_IMG' => 0,
    'SP_URL_HOME' => 0,
    'SP_URL_FILE' => 0,
    'signPackage' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55e51ba5494924_52276198')) {function content_55e51ba5494924_52276198($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8" />
    <title><?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
</title>
    <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['letter']->value['discrib'];?>
" />
    <meta name="author" content="yaojia888" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_IMG']->value;?>
favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
css/show.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
css/animate.lib.css">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
vendor/swiper/css/swiper.css">
    <script>
  if(/Android (\d+\.\d+)/.test(navigator.userAgent)){
    var version = parseFloat(RegExp.$1);
    if(version>2.3){
      var phoneScale = parseInt(window.screen.width)/384;
      document.write('<meta name="viewport" content="width=384, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');
    }else{
      document.write('<meta name="viewport" content="width=384, target-densitydpi=device-dpi">');
    }
  }else{
    document.write('<meta name="viewport" content="width=384, user-scalable=no, target-densitydpi=device-dpi">');
  }
</script>
    <script>
    var SP_URL_STO = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
',
        SP_URL_FILE = '<?php echo $_smarty_tpl->tpl_vars['SP_URL_FILE']->value;?>
',
        SP_LETTER_ID = '<?php echo $_smarty_tpl->tpl_vars['letter']->value['id'];?>
',
           title= '<?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
', // 分享标题
            desc='<?php echo $_smarty_tpl->tpl_vars['letter']->value['discrib'];?>
', // 分享描述

      wxconfig= {
        debug: true,
        appId: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["appId"];?>
',
        timestamp: <?php echo $_smarty_tpl->tpl_vars['signPackage']->value["timestamp"];?>
,
        nonceStr: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["nonceStr"];?>
',
        signature: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["signature"];?>
',
        jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ'

          // 所有要调用的 API 都要加到这个列表中
        ]
      }


    </script>
    <script src="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
vendor/require/require.js" data-main="<?php echo $_smarty_tpl->tpl_vars['SP_URL_HOME']->value;?>
show.js"></script>
    </script>
	<script>

	  /*
	   * 注意：
	   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
	   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
	   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
	   *
	   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
	   * 邮箱地址：weixin-open@qq.com
	   * 邮件主题：【微信JS-SDK反馈】具体问题
	   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
	   */
	//   wx.config({
	//     debug: true,
	//     appId: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["appId"];?>
',
	//     timestamp: <?php echo $_smarty_tpl->tpl_vars['signPackage']->value["timestamp"];?>
,
	//     nonceStr: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["nonceStr"];?>
',
	//     signature: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value["signature"];?>
',
	//     jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ'

	//       // 所有要调用的 API 都要加到这个列表中
	//     ]
	//   });
	//   wx.ready(function () {
	//     // 在这里调用 API
	    
	//     //分享到朋友圈
	//     wx.onMenuShareTimeline({
	// 	    title: '<?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
', // 分享标题
	// 	    link: location.href, // 分享链接
	// 	    imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
	// 	    success: function () { 
	// 	        // 用户确认分享后执行的回调函数
	// 	    },
	// 	    cancel: function () { 
	// 	        // 用户取消分享后执行的回调函数
	// 	    }
	// 	});
		
	// 	//分享给朋友
	// 	wx.onMenuShareAppMessage({
	// 	    title: '<?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
', // 分享标题
	// 	    desc: '<?php echo $_smarty_tpl->tpl_vars['letter']->value['discrib'];?>
', // 分享描述
	// 	    link: location.href, // 分享链接
	// 	    imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
	// 	    type: '', // 分享类型,music、video或link，不填默认为link
	// 	    dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
	// 	    success: function () { 
	// 	        // 用户确认分享后执行的回调函数
	// 	    },
	// 	    cancel: function () { 
	// 	        // 用户取消分享后执行的回调函数
	// 	    }
	// 	});
		
	// 	//分享到QQ
	// 	wx.onMenuShareQQ({
	//     title: '<?php echo $_smarty_tpl->tpl_vars['letter']->value['title'];?>
', // 分享标题
	//     desc: '<?php echo $_smarty_tpl->tpl_vars['letter']->value['discrib'];?>
', // 分享描述
	//     link: 'location.href', // 分享链接
	//     imgUrl: manifest[0].src || SP_URL_STO+'/img/logo.png', // 分享图标
	//     success: function () { 
	//        // 用户确认分享后执行的回调函数
	//     },
	//     cancel: function () { 
	//        // 用户取消分享后执行的回调函数
	//     }
	// });

	//   });
	</script>
    </head>

    <body >
<div id="container" ms-controller="main" class="swiper-container">
      <div class="swiper-wrapper">
        
    <div class="swiper-slide" data-repeat-rendered="rendered" ms-repeat-page="pageItemArr" style="background-size:cover" ms-css-background-color="page.pagebgColor" ms-css-background-image="'url(' + page.pagebgImage + ')' ">
          <div class="elements" ms-repeat-elment="page.comInsList" ms-css-left="{{elment.left}}px" ms-css-top="{{elment.top}}px" ms-css-width="{{elment.width}}px" ms-css-height="{{elment.height}}px" 
                ms-attr-animation="{{elment.animationName}} {{elment.animationDuration}}s ease {{elment.animationIterationCount}}" 
                ms-attr-delay={{elment.animationDelay}}
                ms-css-z-index={{elment.zIndex}}
                ms-visible="elment.animationDelay == 0"
                ms-css-opacity="{{elment.opacity/100}}" ms-css-background-color="{{elment.backgroundColor}}" >
                    <img class="singleimg" ms-if="elment.type=='image'" ms-attr-src="{{elment.imageUrl}}" />
                    <div ms-if="elment.type=='text'" class="singletxt" ms-css-font-size="{{elment.fontSize}}" ms-css-color="{{elment.fontColor}}" ms-css-line-height="{{elment.lineHeight}}" ms-css-text-align="{{elment.textAlign}}">
                        {{elment.textcontent}}
                    </div>
                    <div ms-if="elment.type=='form'" class="singleform swiper-no-swiping"  style="-webkit-overflow-scrolling:touch">
                        <form action="" id="singleform">
                        <div class="form-group " ms-each="elment.formElment">
                            <div class="clearfix form-line" ms-visible="el.ischecked">
                                <input ms-if="el.type=='text'" ms-attr-id="{{el.name}}" ms-attr-name="{{el.name}}" ms-attr-type="{{el.type}}" ms-attr-placeholder="{{el.label}}">
                                <label ms-if="el.type=='radio'">
                                <input ms-if="el.type=='text'" ms-attr-name="{{el.name}}" ms-attr-type="{{el.type}}">



                                <span ms-if="el.type=='radio'" >{{el.label}}</span>
                                <label ms-if="el.type=='radio'" >
                                      <input ms-attr-name="{{el.name}}" value="男" ms-attr-type="{{el.type}}"> {{el.text1}}</label>

                                <label ms-if="el.type=='radio'">
                                    <input ms-attr-name="{{el.name}}" value="女" ms-attr-type="{{el.type}}"> {{el.text2}}</label>

                            </div>
                        </div>
                        <div id="formSubmitBtn" ms-click="formSubmit">提交</div>
                          </form>
            

                          
                        </div>
      </div>
        </div>
    </div>
<div id="music">
</div>
<div id="arrow" class="arrow-ver" ></div>
<div id="loading">
      <div class="spinner">会通</div>
    </div>

<audio loop="loop" autoplay="autoplay" src=""></audio>
</body>
</html>
<?php }} ?>
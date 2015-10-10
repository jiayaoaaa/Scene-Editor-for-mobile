/**
 * 系统工具类
 * @author yu
 * SysUtil.Dialog.show(content, title, btnHtml)
 * SysUtil.Dialog.confirm(msg[, title, callback, params])
 * SysUtil.Dialog.alert(msg[, title, callback, params])
 * function callback(flag, params) {...}  // flag 1=>确定 0=>取消 -1=>忽略
 *
 * 文件上传 引入 swfupload-tatal.js 即可
 * SysUtil.Dialog.upfile(setting, callback);  // settings => {}
 */
window.SysUtil = window.SysUtil || {};
SysUtil.ROOT = SP_URL_STO;  // 样式路径


/**
 * 遮罩层 无依赖任何东西
 */
SysUtil.Lock = function() {
	function YLock() {
		this.inited = false;
		this.mask = null;
		this.maskId = 'y-mask';
		this.version = 0;  // 针对ie6处理
	}
	YLock.prototype = {
		constructor : YLock
		,init : function() {
			if(this.inited) return;
			this.mask = document.createElement('div');
			this.mask.id = this.maskId;
			this.mask.setAttribute('id', this.maskId);
			this.mask.style.position = 'fixed';
			this.mask.style.zIndex = '1120';
			this.mask.style.width = '100%';
			this.mask.style.height = '100%';
			this.mask.style.top = 0;
			this.mask.style.left = 0;
			this.mask.style.backgroundColor = '#000';
			this.mask.style.filter = 'alpha(opacity=50)';
			this.mask.style.opacity = '0.5';
			// 处理ie
			if(!!window.ActiveXObject) {
				this.version = parseInt(navigator.userAgent.toLowerCase().match(/msie (\d+)/)[1]);
			}
			this.inited = true;
		}
		,processIE6 : function() {
			if(this.version != 6) return;
			var _this = this, scrTop = 0;
			document.body.style.height = '100%';
			document.body.style.width = '100%';
			window.onscroll = function() {
				scrTop = document.documentElement.scrollTop || document.body.scrollTop;
				//ie6遮罩位置
				_this.mask.style.position = 'absolute';
				_this.mask.style.top = scrTop + 'px';
			};
		}
		/**
		 * 对外调用方法
		 */
		,unlock : function() {
			if(document.getElementById(this.maskId)) {
				document.body.removeChild(this.mask);
			}
		}
		,lock : function() {
			this.init();
			document.body.insertBefore(this.mask, document.body.firstChild);
			this.processIE6();
		}
	};
	return new YLock();
}();

/**
 * 对话框 需要 css 文件
 */
SysUtil.Dialog = function() {
	function YDialog() {
		this.loaded = false;
		this.callback = null;  // 回调函数
		this.params = '';  // 参数
		this.tmpDialogContainer = null;  // 用于存放模板
		this.tmpDialogContainerId = 'y-tmpDialog';
		this.domSize = null;  // 可见区大小
		this.conf = {
			"cssFile" : SysUtil.ROOT + '/css/dialog-flat.css'
		};
		this.dragConf = {
			"dragable" : true
			,"srcObj" : null
			,"targetObj" : null
			,"diffX" : 0
			,"diffY" : 0
		};
		this.html =
'<div class="y-dialog" id="y-modalDialog">\
	<a href="javascript:;" id="y-modalDialog-title-close" onclick="SysUtil.Dialog.close(-1)" class="y-dialog-close">&times;</a>\
	<div class="y-dialog-innerwrapper">\
		<div class="y-dialog-header" id="y-modalDialog-title">{$title}</div>\
		<div class="y-dialog-content" id="y-modalDialog-content">{$content}</div>\
	</div>\
	<div class="y-dialog-footer" id="y-modalDialog-footer">{$footer}</div>\
</div>';	
		
		this.defaultBtnHtml = '<input class="btn ht-btn-blue" type="button" value="确定" onclick="SysUtil.Dialog.close(1)"/>&nbsp;<input class="btn ht-btn-gray" type="button" value="取消" onclick="SysUtil.Dialog.close(0)"/>';
		this.alertBtnHtml = '<input class="btn ht-btn-blue" type="button" value="确定" onclick="SysUtil.Dialog.close(1)"/>';
		
	}
	YDialog.prototype = {
		constructor : YDialog
		/* ------ drag ------ */
		,_mouseup : function(e) {
			var _self = this;
			document.onmousemove = null;
			document.onmouseup = null;
		}
		,_mousemove : function(e) {
			e = e || window.event;
			this.dragConf.targetObj.style.left = e.clientX - this.dragConf.diffX + 'px';
			this.dragConf.targetObj.style.top =  e.clientY - this.dragConf.diffY + 'px';
		}
		,_mousedown : function(e) {
			e = e || window.event;
			var _self = this;
			this.dragConf.diffX = e.clientX - this.dragConf.targetObj.offsetLeft;  //初始化差值
			this.dragConf.diffY = e.clientY - this.dragConf.targetObj.offsetTop;
			document.onmousemove = function(e){
				_self._mousemove(e);
			};
			document.onmouseup = function(e){
				_self._mouseup(e);
			};
		}
		,initDrag : function() {
			if(!this.dragConf.dragable) return;
			var _self = this;
			this.dragConf.srcObj = document.getElementById('y-modalDialog-title');  // title
			this.dragConf.targetObj = this.tmpDialogContainer;  // 目标移动对象
			this.dragConf.srcObj.onmousedown = function(e){
				_self._mousedown(e);
			};
		}
		/* ------ end drag ------ */
		,initPostion : function() {
			this.domSize = {
				"width" : Math.max(document.documentElement.clientWidth, document.body.clientWidth),
				"height" : Math.max(document.documentElement.clientHeight, 0/*document.body.clientHeight*/)
			};
			var scrTop = document.documentElement.scrollTop || document.body.scrollTop;
			var contentWidth = Math.max(/*this.tmpDialogContainer.scrollWidth, this.tmpDialogContainer.offsetWidth*/0, 460);
			this.tmpDialogContainer.style.left = parseInt((this.domSize.width - contentWidth) / 2) + 'px';
			this.tmpDialogContainer.style.top = /*scrTop +*/ 40 + 'px';
		}
		,init : function() {
			if(this.loaded) return;
			// 临时容器
			this.tmpDialogContainer = document.createElement('span');
			this.tmpDialogContainer.id = this.tmpDialogContainerId; 
			this.tmpDialogContainer.setAttribute('id', this.tmpDialogContainerId);
			this.tmpDialogContainer.style.position = 'fixed';
			this.tmpDialogContainer.style.zIndex = '1127';
			// 加载css
			var linkObj = document.createElement('link');  
			linkObj.setAttribute("rel", "stylesheet");
			linkObj.setAttribute("type", "text/css");
			linkObj.setAttribute("href", this.conf.cssFile);
			document.getElementsByTagName("head")[0].appendChild(linkObj);
			this.loaded = true;
		}
		,replaceVars : function(msg, title, btnHtml) {
			var s = this.html;
			s = s.replace('{$title}', title);
			s = s.replace('{$content}', msg);
			s = s.replace('{$footer}', btnHtml);
			this.tmpDialogContainer.innerHTML = s;
		}
		,render : function() {
			var body = document.body;
			body.insertBefore(this.tmpDialogContainer, body.firstChild);
			this.initPostion();  // 计算位置
			
			this.initDrag();  // 拖动处理
		}
		,clearData : function() {
			this.callback = null;
			this.params = '';
		}
		/**
		 * 对外调用方法
		 */
		,show : function(content, title, btnHtml) {
			content = content || "";
			title = title || "";
			
			btnHtml = btnHtml || this.defaultBtnHtml;
			this.clearData();  // 清空回调函数
			
			this.init();  // 初始化临时容器 加载css
			this.replaceVars(content, title, btnHtml);  // 临时容器赋值innerHTML
			this.render();  // 临时容器加入dom
			// 遮罩层
			SysUtil.Lock.lock();
		}
		,confirm : function(msg, title, callback, params) {
			msg = msg || "";
			title = title || "消息";
			
			this.clearData();  // 清空回调函数和参数
			"function" == typeof callback && (this.callback = callback);
			undefined != params && (this.params = params);
			var btnHtml = this.defaultBtnHtml;
			
			this.init();  // 初始化临时容器 加载css
			this.replaceVars(msg, title, btnHtml);  // 临时容器赋值innerHTML
			this.render();  // 临时容器加入dom
			// 遮罩层
			SysUtil.Lock.lock();
		}
		,alert : function(msg, title, callback, params) {
			msg = msg || "";
			title = title || "警告";
			
			this.clearData();  // 清空回调函数
			"function" == typeof callback && (this.callback = callback);
			undefined != params && (this.params = params);
			var btnHtml = this.alertBtnHtml;
			
			this.init();  // 初始化临时容器 加载css
			this.replaceVars(msg, title, btnHtml);  // 临时容器赋值innerHTML
			this.render();  // 临时容器加入dom
			// 遮罩层
			SysUtil.Lock.lock();
		}
		// 上传文件 ======
		,upfile : function(settings, callback) {
			settings = settings || {};
			// 一些配置
			var set = {
				flash_url : SysUtil.ROOT + "js/swfupload/swfupload.swf",
				css_style : 'position:absolute;right:86px;bottom:14px',  // 勿动
				
				upload_url : "",  // 上传地址
				
				button_placeholder_id : "_upfilebtn",  // 勿动
				button_window_mode : 'transparent',  // 勿动
				
				custom_settings : {
					progressTarget : "_upfilelist"  // 文件队列容器id 勿动
					// 每个图片上传完成时调用
					,afterSuccessCallback : callback
				}
			};
			
			var html = '<div class="swf-fieldset" id="_upfilelist"></div>';
			var btnHtml = 
'<input class="y-dialog-btn y-dialog-btn-primary" type="button" value="选择文件" onclick=""/>\
<span id="_upfilebtn"></span>&nbsp;\
<input class="y-dialog-btn" type="button" value="上传" onclick="SysUtil.Dialog.swf.startUpload()"/>';
			
			if(!!getSwfUpload) {
				for(key in settings) {
					set[key] = settings[key];
				}
				
				SysUtil.Dialog.show(html, '上传', btnHtml);
				SysUtil.Dialog.swf = getSwfUpload(set);
			}
		}
		// 上传文件 ======
		,close : function(flag) {
			if(document.getElementById(this.tmpDialogContainerId)) {
				document.body.removeChild(this.tmpDialogContainer);
			}
			// 关闭遮罩
			SysUtil.Lock.unlock();
			if(null != this.callback) {
				this.callback(flag, this.params);
			}
		}
		,setContent : function(str) {
			// 加入dom后才能调用该方法
			document.getElementById('y-modalDialog-content').innerHTML = str;
			this.initPostion();
		}
	};
	return new YDialog();
}();

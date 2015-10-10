/**
 * YTab
 * @author yulipu 
 */
function YTab(beginStyle, activeClass) {
	this.activeClass = activeClass + ' y-on';
	this.beginStyle = beginStyle;
	this.handlers = null;  // Array
	this.showAreas = null;  // Array
	this.callback = null;  // Array
}
YTab.prototype = {
	constructor : YTab
	,clearAllBg : function() {
		var len = this.handlers.length;
		for(var i=0; i<len; i++) {
			this.handlers[i].className = '';
		}
	}
	,initBegin : function() {
		var len = this.handlers.length;
		for(var i=0; i<len; i++) {
			this.handlers[i].className = this.beginStyle;
		}
	}
	,closeAllAreas : function() {
		if(!this.showAreas) return;
		var len = this.showAreas.length;
		for(var i=0; i<len; i++) {
			this.showAreas[i].style.display = 'none';
		}
	}
	,openNowArea : function() {
		// 找出现在是第几个
		var len =  this.handlers.length;
		var idx = 0;
		for(var i=0; i<len; i++) {
			if(this.handlers[i].className.indexOf('y-on') > 0) {
				idx = i;
				break;
			}
		}
		
		// 回调
		if(this.callback) {
			this.callback(this.handlers[idx]);
		}
		
		if(!this.showAreas) return;
		this.showAreas[i].style.display = 'block';
	}
	,start : function() {
		var _self = this;
		var len = this.handlers.length;
		for(var i=0; i<len; i++) {
			this.handlers[i].onclick = function() {
				// 清除所有背景色
				_self.clearAllBg();
				// 初始样式
				_self.initBegin();
				// 当前背景色
				this.className = _self.activeClass;
				// 关闭所有显示区域
				_self.closeAllAreas();
				// 打开当前区域
				_self.openNowArea();
			};
		}
	}
	,init : function(handlers, showAreas, callback) {
		this.handlers = handlers;
		this.showAreas = showAreas;
		this.callback = callback;
		
		this.start();
	}
};
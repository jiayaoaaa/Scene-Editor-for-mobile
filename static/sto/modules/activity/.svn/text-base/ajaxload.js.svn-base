/**
 * 数据加载
 * 依赖 template jquery jquery.imagelazyload
 * @author yu
 */
function AjaxLoad() {
	this.nowTab = 'all';
	this.container = document.getElementById('itemlist');
	this.pageContainer = document.getElementById('pagestring');
	this.urls = {
		loadAll : '/active/getall.json',
		loadIng : '/active/getgoing.json',
		loadEnd : '/active/getend.json'
	};
	
	this.init();
}
AjaxLoad.prototype = {
	constructor : AjaxLoad
	,init : function() {
		// 模版
		template.helper('dateFormat', function (date, format) {
			date = new Date(date);
			var map = {
				"M": date.getMonth() + 1, //月份 
				"d": date.getDate(), //日 
				"h": date.getHours(), //小时 
				"m": date.getMinutes(), //分 
				"s": date.getSeconds(), //秒 
				"q": Math.floor((date.getMonth() + 3) / 3), //季度 
				"S": date.getMilliseconds() //毫秒 
			};
			format = format.replace(/([yMdhmsqS])+/g, function(all, t){
				var v = map[t];
				if(v !== undefined){
					if(all.length > 1){
						v = '0' + v;
						v = v.substr(v.length-2);
					}
					return v;
				}
				else if(t === 'y'){
					return (date.getFullYear() + '').substr(4 - all.length);
				}
				return all;
			});
			return format;
		});
		
		template.helper('isGonging', function(unixtime, activestarttime, activeendtime){
			//unixtime = parseInt(unixtime);
			if(unixtime < activestarttime || unixtime < activeendtime) {
				return true;
			}
			
			return false;
		});
	}
	
	// 加载分页数据
	,ajaxData : function(param) {
		//alert(param);
		if('all' == this.nowTab) {
			this.loadAll(param);
			
		} else if('ing' == this.nowTab) {
			this.loadIng(param);
			
		} else if('end' == this.nowTab) {
			this.loadEnd(param);
		}
	}
	// 分页
	,processPage : function() {
		var _self = this;
		var list = _self.pageContainer.getElementsByTagName('a');
		for(var i=0,len=list.length; i<len; i++) {
			list[i].setAttribute('data-href', list[i].href);
			list[i].href = 'javascript:;';
			
			list[i].onclick = function(){
				_self.ajaxData(this.getAttribute('data-href'));
				return false;
			};
		}
	}
	// 渲染数据
	,renderHtml : function(d) {
		/*
		if('all' == this.nowTab) {
			jQuery('#createButton').show();
		} else {
			jQuery('#createButton').hide();
		}
		*/
		
		if(d.status == '0') {
			if(d.data.length > 0) {
				var html = template('listtemplate', d);
				this.container.innerHTML = html;
				
				// 创建按钮
				jQuery('#createButton').hide();
				
				// lazyload
				jQuery("img.lazy").lazyload();
				
				// 二维码
				jQuery('.ht-qrcode').on('mouseover', function(){
					//this.nextSibling.style.display = 'block';
					jQuery(this).parent().find('.ht-qrimg').show();
				});
				jQuery('.ht-qrcode').on('mouseout', function(){
					//this.nextSibling.style.display = 'block';
					jQuery(this).parent().find('.ht-qrimg').hide();
				});
				
			} else {
				// 无数据显示创建按钮
				
				if(this.nowTab == 'end'){
					this.container.innerHTML = '<div class="ht-tips-icon"></div><div class="ht-activity-list-notify">您还没有已结束的活动</div>';
					jQuery("#createButton").hide();
				}else if(this.nowTab == 'ing'){
					this.container.innerHTML = '<div class="ht-tips-icon"></div><div class="ht-activity-list-notify">您还没有进行中的活动</div>';
					jQuery("#createButton").hide();
				}else{
					this.container.innerHTML = '';
					jQuery("#createButton").show();
				}
				
			}
			
			// 分页
			if('' != d.pageString) {
				this.pageContainer.innerHTML = d.pageString;
				this.processPage();
			}
			
		} else {
			jQuery("#createButton").show();
		}
	}
	// 加载所有
	,loadAll : function(param){
		var _self = this;
		!param && (param = '');
		jQuery.get(_self.urls.loadAll + param, function(d){
			_self.renderHtml(d);
			
		}, 'json');
	}
	,loadIng : function(param) {
		var _self = this;
		!param && (param = '');
		jQuery.get(_self.urls.loadIng + param, function(d){
			_self.renderHtml(d);
			
		}, 'json');
	}
	,loadEnd : function(param) {
		var _self = this;
		!param && (param = '');
		jQuery.get(_self.urls.loadEnd + param, function(d){
			_self.renderHtml(d);
			
		}, 'json');
	}
};

var ajaxLoad = new AjaxLoad();

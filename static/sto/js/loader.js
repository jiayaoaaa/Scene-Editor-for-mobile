/**
 * Loader
 * 动态加载 js css 修改自 sea.js
 * @author yulipu
 * 用法
 *  var Loader = new Loader();
 *  1. 动态加载js
 *    Loader.use('http://xxx.com/static/js/jquery.js');
 *    Loader.many(['http://xxx.com/static/js/jquery.js']);
 *  2. 动态加载js后执行方法
 *    Loader.use('http://xxx.com/static/js/jquery.js', function(){...});
 *  3. 动态加载css
 *    Loader.use('http://xxx.com/static/css/home.css');
 *    Loader.many(['http://xxx.com/static/css/home.css']);
 */
function Loader() {
	this.doc = document;
	this.IS_CSS_REG = /\.css(?:\?|$)/i;
	this.READY_STATE_REG = /^(?:loaded|complete|undefined)$/;
	
	// bug fix
	// `onload` event is not supported in WebKit < 535.23 and Firefox < 9.0
	// ref:
	//  - https://bugs.webkit.org/show_activity.cgi?id=38995
	//  - https://bugzilla.mozilla.org/show_bug.cgi?id=185236
	//  - https://developer.mozilla.org/en/HTML/Element/link#Stylesheet_load_events
	this.isOldWebKit = (window.navigator.userAgent.replace(/.*AppleWebKit\/(\d+)\..*/, "$1")) * 1 < 536;
	// For some cache cases in IE 6-8, the script executes IMMEDIATELY after
	// the end of the insert execution, so use `currentlyAddingScript` to
	// hold current node
	this.currentlyAddingScript = '';
	this.head = this.doc.getElementsByTagName('head')[0];
	// ref: #185 & http://dev.jquery.com/ticket/2709
	this.baseElement = this.head.getElementsByTagName("base")[0];
}
Loader.prototype = {
	constructor : Loader
	,isFunction : function(fn) {
		return "[object Function]" === Object.prototype.toString.call(fn);
	}
	,pollCss : function(node, callback) {
		var _self = this;
		var sheet = node.sheet;
		var isLoaded = false;
		
		// for WebKit < 536
		if(_self.isOldWebKit) {
			if(sheet) {
				isLoaded = true;
			}
		} else {
			if (sheet) {  // for Firefox < 9.0
				try {
					if(sheet.cssRules) {
						isLoaded = true;
					}
				} catch (ex) {
					// The value of `ex.name` is changed from "NS_ERROR_DOM_SECURITY_ERR"
					// to "SecurityError" since Firefox 13.0. But Firefox is less than 9.0
					// in here, So it is ok to just rely on "NS_ERROR_DOM_SECURITY_ERR"
					if(ex.name === "NS_ERROR_DOM_SECURITY_ERR") {
						isLoaded = true;
					}
				}
			}
		}
		
		setTimeout(function() {
			if (isLoaded) {
				// Place callback here to give time for style rendering
				_self.isFunction(callback) && callback();
			} else {
				_self.pollCss(node, callback);
			}
		}, 50);
	}
	,addOnload : function(node, callback, isCss) {
		var _self = this;
		var missingOnload = isCss && (_self.isOldWebKit || !("onload" in node));
		// for Old WebKit and Old Firefox
		if(missingOnload) {
			setTimeout(function() {
				_self.pollCss(node, callback);
			}, 10);  // Begin after node insertion
			return;
		}

		node.onload = node.onerror = node.onreadystatechange = function() {
			if(_self.READY_STATE_REG.test(node.readyState)) {
				// Ensure only run once and handle memory leak in IE
				node.onload = node.onerror = node.onreadystatechange = null;
				// Remove the script to reduce memory leak
				if(!isCss) {
					_self.head.removeChild(node);
				}
				// Dereference the node
				node = null;
				_self.isFunction(callback) && callback();
			}
		};
	}
	,log : function(msg) {
		if(console.log) {
			console.log(msg);
		}
	}
	,use : function(url, callback, charset) {
		var isCss = this.IS_CSS_REG.test(url);
		var node = this.doc.createElement(isCss ? "link" : "script");
		if(undefined != charset) {
			node.charset = charset;
		}
		this.addOnload(node, callback, isCss);
		if (isCss) {
			node.rel = "stylesheet";
			node.href = url;
		} else {
			node.async = true;
			node.src = url;
		}
		this.currentlyAddingScript = node;

		// ref: #185 & http://dev.jquery.com/ticket/2709
		this.baseElement ?
			this.head.insertBefore(node, this.baseElement) :
			this.head.appendChild(node);

		this.currentlyAddingScript = null;
	}
	,many : function(urls, callback) {
		var _this = this;
		_this.loadedIdx = 0;  // 置 0
		
		if(urls.length > 0) {  // [xxx, zzz]
			var len = urls.length;
			for(var i=0; i<len; i++) {
				this.use(urls[i], function(){
					_this.loadedIdx++;
					if(_this.loadedIdx == len) {
						callback && callback();
					}
				});
			}
		}
	}
};
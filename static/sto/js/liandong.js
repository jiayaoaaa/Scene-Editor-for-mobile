/**
 * 省市地区联动 依赖 jQuery
 * @author yu
 */
function LianDongJQ() {
	this.pObj = null;
	this.cObj = null;
	this.aObj = null;
	this.handlerAttribute = 'data-value';
	this.api = '/home/publicapi.json?type=getcitychild&id=';
}
LianDongJQ.prototype = {
	constructor : LianDongJQ,
	request : function(f) {
		var _self = this;
		var pid = 1 == f ? '0' :
			(2 == f ? _self.pObj.value : _self.cObj.value);
		
		var url = _self.api + pid;
			
		jQuery.get(url, function(d){
			if('0' != d.status) return;
			var tmp = ''
			
			if(2 == f){
				_self.render(_self.cObj, d.data);
				tmp = _self.cObj.getAttribute(_self.handlerAttribute);
				if(null != tmp && '' != tmp) {
					_self.cObj.value = tmp;
					_self.request(3);
					_self.cObj.setAttribute(_self.handlerAttribute, '');
				}
				$('#city').selectpicker('refresh');
				$('#area').selectpicker('refresh');
			} else {
				_self.render(_self.aObj, d.data);
				tmp = _self.aObj.getAttribute(_self.handlerAttribute);
				if(null != tmp && '' != tmp) {
					_self.aObj.value = tmp;
					_self.aObj.setAttribute(_self.handlerAttribute, '');
				}
				$('#area').selectpicker('refresh');	
			}
			
		}, 'json');
	},
	render : function(obj, data) {
		if(data.length && data.length > 0) {
			obj.length = 0;
			if(obj.id == "city"){
				$("#city").html('<option selected="true" disabled="true">市</option>');
				$("#area").html('<option selected="true" disabled="true">区</option>');			
			}
			if(obj.id == "area"){
				$("#area").html('<option selected="true" disabled="true">区</option>');
			}
			for(var i=0; i<data.length; i++) {
				obj.options.add(new Option(data[i]['name'], data[i]['id']));
			}
		}
	},
	start : function() {
		var _self = this;
		_self.pObj.onchange = function(){
			
			_self.request(2);
			
		};
		_self.cObj.onchange = function(){
			_self.request(3);
			
		};
	},
	init : function(pObj, cObj, aObj) {
		this.pObj = pObj;
		this.cObj = cObj;
		this.aObj = aObj;
		
		this.start();
	}
};

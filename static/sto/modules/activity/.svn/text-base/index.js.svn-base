// 方法
function delActive(pkid) {
	SysUtil.Dialog.confirm('你确定要删除这个活动吗？所有与此活动相关的信息，包括活动信息、邀请函、人员名单等将永久被删除。', 
		'删除活动', function(f, param){
		
		if('1' == f) {
			jQuery.post('/active/delone.json', 'pkid='+param, function(rs){
				if('0' == rs.status) {
					//window.location.reload();
					ajaxLoad.ajaxData();  // 无刷新加载
					
				} else {
					SysUtil.Dialog.alert(rs.msg);
				}
				
			});
		}
	}, pkid);
}
function shareActive(url, content) {
	url = encodeURIComponent(url);
	content = encodeURIComponent(content);
	var urls = {
		"sina" : "http://service.weibo.com/share/share.php?url="+url+"&title="+content,
		"qzone" : "http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url="+url+"&desc="+content,
		"more" : "http://s.share.baidu.com/mshare?title="+content
	};
	var html =
'<div class="ht-share">\
	<a target="_blank" href="'+ urls.sina +'" class="ht-share-sina"></a>\
	<a target="_blank" href="'+ urls.qzone +'" class="ht-share-qzone"></a>\
	<a target="_blank" href="javascript:;" class="ht-share-weixin" onclick="_showShareQrcode()"></a>\
	<a target="_blank" href="'+ urls.more +'" class="ht-share-more"></a>\
	<div style="display:none" id="ht-share-qrcode"><img src="/active/qrcode.html?code='+url+'" /></div>\
</div>';
	
	SysUtil.Dialog.show(html, '分享', '&nbsp;');
	
}
function _showShareQrcode() {
	var obj = document.getElementById('ht-share-qrcode');
	if(obj.style.display == 'none') {
		obj.style.display = '';
	} else {
		obj.style.display = 'none';
	}
}
function nopic(obj) {
	if(obj.getAttribute('data-loaded')) {
		obj.onload = null;
		return;
	}
	obj.setAttribute('data-loaded', 1);
	
	if('http://img.eventown.cn/' == obj.getAttribute('data-original')) {
		var p = SP_URL_STO + 'img/nopic.jpg';
		obj.setAttribute('data-original', p);
		obj.src = p;
	}
}


// 处理业务
var handlers = document.getElementById('httab').getElementsByTagName('a');
new YTab('ht-tab', 'ht-tab ht-tab-on')
	.init(handlers, null, function(obj){
		
	var flag = obj.getAttribute('id');
	if('all' == flag) {
		ajaxLoad.loadAll();
		ajaxLoad.nowTab = 'all';
		
	} else if('ing' == flag) {
		ajaxLoad.loadIng();
		ajaxLoad.nowTab = 'ing';
		
	} else if('end' == flag) {
		ajaxLoad.loadEnd();
		ajaxLoad.nowTab = 'end';
		
	}
});

// 初始加载 all
ajaxLoad.loadAll();


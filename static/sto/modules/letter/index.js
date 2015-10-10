var loader = new Loader();

// 依赖
var _depens = [
	//SP_URL_STO + 'vendor/jquery/jquery-1.9.1.min.js',
	SP_URL_STO + 'js/jquery.lazyload.min.js',
	SP_URL_STO + 'modules/letter/ajaxload.js'

];

function delLetter(pkid) {
	SysUtil.Dialog.confirm('你确定要删除这个邀请函吗？', 
		'删除邀请函', function(f, param){
		
		if('1' == f) {
			jQuery.post(U('/letter/delone.json'), 'id='+param, function(rs){
				if('0' == rs.status) {
					ajaxLoad.ajaxData();  // 无刷新加载
				} else {
					SysUtil.Dialog.alert(rs.msg);
				}
				
				loader.log(rs);
			});
		}
	}, pkid);
}

 
function submitLetter(active,obj){
	var title = document.getElementById('letter_title');
	var discrib = document.getElementById('letter_discrib');
	obj.disabled = true;
	if(title.value == null || title.value == "" || title.value == "标题"){
		title.focus();
		var letter_title_error = document.getElementById('letter_title_error');
		letter_title_error.innerHTML = '标题不能为空';
		obj.disabled = false;
		return false;
	}
	var discribTxt = discrib.value;
	if(discrib.value == "描述"){
		discribTxt = "";
	}
	$.post('/letter/create.json',{active_id:active,title:title.value,discrib:discribTxt},function(data){
 		if(data.status == 0){
 			location.href = "/active/lettereditor.html?id="+data.data;
 		}else{
 			SysUtil.Dialog.close(-1);
 			SysUtil.Dialog.alert(data.msg);
 			obj.disabled = false;
 		}
 	},"json");
}
function titleUp(title){
	if(title.value != ""){
		var letter_title_error = document.getElementById('letter_title_error');
		letter_title_error.innerHTML = '';
	}
}
function addLetter(active) {
	
	var html =
	'<form class="ht-share">\
		<div class="form-group">\
			<input class="form-control" style="*+width:95%;" id="letter_title" name="title" placeholder="标题" type="text" onkeyup="titleUp(this)" />\
			<div id="letter_title_error" style="color:red;text-align:left;"></div>\
		</div>\
		<div class="form-group">\
			<textarea class="form-control" style="*+width:95%;height:70px;" id="letter_discrib" name="discrib" placeholder="描述" type="text" ></textarea>\
		</div>\
	</form>';
	
	var btnHtml = 
	'<input class="btn ht-btn-blue" type="button" value="确定" onclick="submitLetter('+active+',this)"/>&nbsp;\
	<input class="btn ht-btn-gray" type="button" value="取消" onclick="SysUtil.Dialog.close(-1)"/>';

	SysUtil.Dialog.show(html, '创建邀请函', btnHtml);
	
	var msie = /msie/.test(navigator.userAgent.toLowerCase());
	var isIE=!!window.ActiveXObject;
	if(msie && isIE){
		$('input, textarea').placeholder();
	}
	
}

// 处理业务
loader.many(_depens, function(){
	// 初始加载 all
	ajaxLoad.loadAll();
});

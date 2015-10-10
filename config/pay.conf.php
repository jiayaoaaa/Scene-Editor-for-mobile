<?php
/* 
 * @version 2014-03-26
 */

return array(
	'online_bank'=>array(
		'name'=>'网银支付',
		'logo'=>"bank/online_bank.png",
	),
	'yeepay'=>array(
		'name' => '易宝',
		'type'=>"url", 
		'logo'=>"bank/yeepay.jpg",
		'p1_MerId'=>'10012419148',//商户编号
		'merchantKey'=>'69cl522AV6q613Ii4W6u8K6XuW8vM1N6bFgyv769220IuYe9u37N4y7rI4Pl',//密钥
		'notify_url'=> SP_URL_HOME.'payment/yeepay/notify.html', 
		'return_url'=>SP_URL_HOME."payment/yeepay/return.html",  // 同步返回地址
		//真实地址先换为测试地址
		'reqURL_onLine' => "https://www.yeepay.com/app-merchant-proxy/node",//请求地址
		//'reqURL_onLine' => SP_URL_HOME."test_pay.html",//请求地址
	),
	'weixinpay'=>array(
		'name' => '微信',
		'type'=>"url", 
		'logo'=>"bank/weixinpay.png",
		'p1_MerId'=>'10022623',//商户编号
		'merchantKey'=>'c01d141f71475f83748bffeb2f01c50e',  //密钥
		'virCardNoIn'=>'wx91f7f41fce0885bc',//微信公众号身份的唯一标识
		'serctKey'=>'YjlcfXNkdBYjlcfXNkdBYjlcfXNkdBYj',   //商户支付密钥Key
		'sslcertPath'=>LIB_ROOT.'../config/security/apiclient_cert.pem',
		'sslkeyPath'=>LIB_ROOT.'../config/security/apiclient_key.pem',
		'notify_url'=>SP_URL_HOME.'payment/weixin/notify.html', // 异步返回地址
		'curl_Timeout'=> 30, //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
		//真实地址先换为测试地址
		//'reqURL_onLine' => SP_URL_HOME."payment/weixin/js_api_call.php",//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
		'logfile' => '/sproot/logs/pay/pay_weixin_',  //微信输出日志
		'reqURL_onLine' => "http://tianshihui.eventool.cn/pay/weixin/demo/demo/js_api_call_ccnn_ticket.php"
	),
	'weixinpay'=>array(
		'name' => '支付宝',
		'type'=>"url", 
		'logo'=>"bank/alipay.png",
		'p1_MerId'=>'10022623',//商户编号
		'merchantKey'=>'c01d141f71475f83748bffeb2f01c50e',  //密钥
		'virCardNoIn'=>'wx91f7f41fce0885bc',//微信公众号身份的唯一标识
		'serctKey'=>'YjlcfXNkdBYjlcfXNkdBYjlcfXNkdBYj',   //商户支付密钥Key
		'sslcertPath'=>LIB_ROOT.'../config/security/apiclient_cert.pem',
		'sslkeyPath'=>LIB_ROOT.'../config/security/apiclient_key.pem',
		'notify_url'=>SP_URL_HOME.'payment/weixin/notify.html', // 异步返回地址
		'curl_Timeout'=> 30, //本例程通过curl使用HTTP POST方法，此处可修改其超时时间，默认为30秒
		//真实地址先换为测试地址
		//'reqURL_onLine' => SP_URL_HOME."payment/weixin/js_api_call.php",//获取access_token过程中的跳转uri，通过跳转将code传入jsapi支付页面
		'logfile' => '/sproot/logs/pay/pay_weixin_',  //微信输出日志
		'reqURL_onLine' => "http://tianshihui.eventool.cn/pay/weixin/demo/demo/js_api_call_ccnn_ticket.php"
	),
);
?>
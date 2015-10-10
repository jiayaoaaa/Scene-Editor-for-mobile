<?php
   
/**
 * 统一支付接口类
 */
class Sp_Payment_Weixinpay_UnifiedOrderPub extends Sp_Payment_Weixinpay_WxpayClientPub
{	
	function __construct()
	{
		//设置接口链接
		$this->url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
		//设置curl超时时间
		$this->curl_timeout = 30;
	}
	
	/**
	 * 生成接口参数xml
	 */
	function createXml()
	{
		try
		{
			//检测必填参数
			if($this->parameters["out_trade_no"] == null) 
			{
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("缺少统一支付接口必填参数out_trade_no！"."<br>");
			}elseif($this->parameters["body"] == null){
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("缺少统一支付接口必填参数body！"."<br>");
			}elseif ($this->parameters["total_fee"] == null ) {
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("缺少统一支付接口必填参数total_fee！"."<br>");
			}elseif ($this->parameters["notify_url"] == null) {
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("缺少统一支付接口必填参数notify_url！"."<br>");
			}elseif ($this->parameters["trade_type"] == null) {
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("缺少统一支付接口必填参数trade_type！"."<br>");
			}elseif ($this->parameters["trade_type"] == "JSAPI" &&
				$this->parameters["openid"] == NULL){
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("统一支付接口中，缺少必填参数openid！trade_type为JSAPI时，openid为必填参数！"."<br>");
			}
		 
		   	$this->parameters["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];//终端ip	    
		    $this->parameters["nonce_str"] = $this->createNoncestr();//随机字符串
		    $this->parameters["sign"] = $this->getSign($this->parameters);//签名
		    return  $this->arrayToXml($this->parameters);
		}catch (Sp_Payment_Weixinpay_SDKRuntimeException $e)
		{
			die($e->errorMessage());
		}
	}
	
	/**
	 * 获取prepay_id
	 */
	function getPrepayId()
	{
//return $this->postXml();
		$this->postXml();
		//var_dump($this->postXml());
		$this->result = $this->xmlToArray($this->response);
		$prepay_id = $this->result["prepay_id"];

		return $prepay_id;
	}
	
}
?>
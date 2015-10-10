<?php
   /**
 * 短链接转换接口
 */
class Sp_Payment_Weixinpay_ShortUrlPub extends Sp_Payment_Weixinpay_WxpayClientPub
{
	function __construct() 
	{
		//设置接口链接
		$this->url = "https://api.mch.weixin.qq.com/tools/shorturl";
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
			if($this->parameters["long_url"] == null ) 
			{
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("短链接转换接口中，缺少必填参数long_url！"."<br>");
			}
			$_settings = Loader::config('pay');
		   	$this->parameters["appid"] = $_settings['weixinpay']['virCardNoIn'];//公众账号ID
		   	$this->parameters["mch_id"] = $_settings['weixinpay']['p1_MerId'];//商户号
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
	function getShortUrl()
	{
		$this->postXml();
		$prepay_id = $this->result["short_url"];
		return $prepay_id;
	}
	
}
?>
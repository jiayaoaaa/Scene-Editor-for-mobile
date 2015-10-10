<?php
   /**
 * 对账单接口
 */
class Sp_Payment_Weixinpay_DownloadBillPub extends Sp_Payment_Weixinpay_WxpayClientPub
{

	function __construct() 
	{
		//设置接口链接
		$this->url = "https://api.mch.weixin.qq.com/pay/downloadbill";
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
			if($this->parameters["bill_date"] == null ) 
			{
				throw new Sp_Payment_Weixinpay_SDKRuntimeException("对账单接口中，缺少必填参数bill_date！"."<br>");
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
	 * 	作用：获取结果，默认不使用证书
	 */
	function getResult() 
	{		
		$this->postXml();
		$this->result = $this->xmlToArray($this->result_xml);
		return $this->result;
	}
	
	

}

?>
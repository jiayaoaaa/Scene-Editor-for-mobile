<?php
    /**
 * 请求商家获取商品信息接口
 */
class Sp_Payment_Weixinpay_NativeCallPub extends Sp_Payment_Weixinpay_WxpayServerPub
{
	/**
	 * 生成接口参数xml
	 */
	function createXml()
	{
		if($this->returnParameters["return_code"] == "SUCCESS"){
		   $_settings = Loader::config('pay');
	   	$this->parameters["appid"] = $_settings['weixinpay']['virCardNoIn'];//公众账号ID
	   	$this->parameters["mch_id"] = $_settings['weixinpay']['p1_MerId'];//商户号
		    $this->returnParameters["nonce_str"] = $this->createNoncestr();//随机字符串
		    $this->returnParameters["sign"] = $this->getSign($this->returnParameters);//签名
		}
		return $this->arrayToXml($this->returnParameters);
	}
	
	/**
	 * 获取product_id
	 */
	function getProductId()
	{
		$product_id = $this->data["product_id"];
		return $product_id;
	}
	
}
?>
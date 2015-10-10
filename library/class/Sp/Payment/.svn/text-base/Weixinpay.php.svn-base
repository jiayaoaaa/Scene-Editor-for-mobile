<?PHP

// $Id$

/**
 * weixin
 *
 * 微信支付
 *
 * @package    Sp
 * @author     zhaoyu
 * @version    $Id$
 */

class Sp_Payment_Weixinpay extends Sp_Payment
{
	public function __construct($logfile)  
    {  $this->_logfile = $logfile;
    } 
	/**
	 * 准备支付，如准备页面、表单等信息
	 * 
	 * @param array params
	 * @return void
	 */
	public function prepare($params)
	{
		$p1_MerId = $this->getOption('p1_MerId'); // 商户号
		$merchantKey = $this->getOption('merchantKey'); // 密钥
		$return_url = $this->getOption('return_url'); //返回处理地址
		$notify_url = $this->getOption('notify_url'); //回调处理地址
		$reqURL_onLine = $this->getOption('reqURL_onLine'); //返回处理地址
		$virCardNoIn = $this->getOption('virCardNoIn');
		
		#	商户订单号,选填.
		##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
		$p2_Order					= $params['sn'];

		#	支付金额,必填.
		##单位:分，精确到元.
		$p3_Amt						= $params['amount'] * 1000;

		#	商品名称
		$body						= $params['title'];

		#商户扩展信息
		##商户可以任意填写1K 的字符串,支付成功时将原样返回.												
		$pa_MP						= $params['user_id'];


		#调用签名函数生成签名串
		
		//使用统一支付接口
		$unifiedOrder = new Sp_Payment_Weixinpay_UnifiedOrderPub();
	 	$unifiedOrder->setParameter("appid",$virCardNoIn);  	//公众账号ID
	 	$unifiedOrder->setParameter("mch_id",$p1_MerId); //商户号
		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("body",$body);//商品描述
		//自定义订单号，此处仅作举例
		$timeStamp = time();
		$unifiedOrder->setParameter("out_trade_no",$p2_Order);//商户订单号 
		$unifiedOrder->setParameter("total_fee",$p3_Amt);//总金额
		$unifiedOrder->setParameter("notify_url",$notify_url);//通知地址 
		$unifiedOrder->setParameter("trade_type","NATIVE");//交易类型
	
		//非必填参数，商户可根据实际情况选填
		//$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
		//$unifiedOrder->setParameter("device_info","XXXX");//设备号 
		//$unifiedOrder->setParameter("attach","XXXX");//附加数据 
		//$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
		//$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
		//$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
		//$unifiedOrder->setParameter("openid","XXXX");//用户标识
		//$unifiedOrder->setParameter("product_id","XXXX");//商品ID
		
		//获取统一支付接口结果
		$unifiedOrderResult = $unifiedOrder->getResult();
		
		//商户根据实际情况设置相应的处理流程
		if ($unifiedOrderResult["return_code"] == "FAIL") 
		{
			var_dump($unifiedOrderResult);
			//商户自行增加处理流程
			echo "通信出错：".$unifiedOrderResult['return_msg']."<br>";
			return FALSE;
		}
		elseif($unifiedOrderResult["result_code"] == "FAIL")
		{
			//商户自行增加处理流程
			//echo "错误代码：".$unifiedOrderResult['err_code']."<br>";
			//echo "错误代码描述：".$unifiedOrderResult['err_code_des']."<br>";
			return FALSE;
		}
		elseif($unifiedOrderResult["code_url"] != NULL)
		{
			//从统一支付接口获取到code_url
			$code_url = $unifiedOrderResult["code_url"];
			//商户自行增加处理流程
			//......
		}
		return $code_url; 
	}
	
	/**
	 * 接收支付平台通知
	 * 
	 * @param array params
	 * @return void
	 */
	public function notify($xml)
	{
		//使用通用通知接口
		$notify = new Sp_Payment_Weixinpay_NotifyPub();
		
		//存储微信的回调
		$notify->saveData($xml);
		
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
			//==商户根据实际情况设置相应的处理流程，此处仅作举例=======
		
		//以log文件形式记录回调信息
		$log_ = $this->getLog();
		$log_->log("-------------------------------------");
		if($notify->checkSign() == TRUE)
		{
			$log_->log("【接收到的notify通知】:".$xml);
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log("【通信出错】:".$xml);
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log("【业务出错】:".$xml);
			}
			else{
				//此处应该更新一下订单状态，商户自行增删操作
				$log_->log("【支付成功】:".$xml);
			}
			
			//商户自行增加处理流程,
			//例如：更新订单状态
			//例如：数据库操作
			//例如：推送支付完成信息
			$msg = array();
			$msg['code'] = $notify->data["out_trade_no"];		//商户订单号
			$msg['y_amount'] = $notify->data["total_fee"];	// 总金额
			//$msg['y_bank'] = $notify->data["bank_type"];		// 银行类型
			$msg['y_merchantaccount'] = $notify->data["appid"];	// 商户在微信的appid 
			$msg['y_orderid'] = $notify->data["transaction_id"];	// 微信支付的订单号
			$msg['status'] = 1; // 订单状态更新
		}else{
			$log_->log("非支付通知访问");
		}
		return $returnXml;
	}
	
	/**
	 * 支付完成后返回处理
	 * 
	 * @param array params
	 * @return void
	 */
	public function complete($params)
	{
		
	}
}
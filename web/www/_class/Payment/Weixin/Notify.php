<?PHP
/**
 * 微信通用通知
 * ====================================================
 * 支付完成后，微信会把相关支付和用户信息发送到商户设定的通知URL，
 * 商户接收回调信息后，根据需要设定相应的处理流程。
 */
class Payment_Weixin_Notify extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
    
		error_reporting(E_ALL);
		ini_set("displays", 1);
    	$payment = Sp_Payment::factory('weixinpay');
		$returnXml = $payment->notify($GLOBALS['HTTP_RAW_POST_DATA']);
		echo $returnXml;
	}
}
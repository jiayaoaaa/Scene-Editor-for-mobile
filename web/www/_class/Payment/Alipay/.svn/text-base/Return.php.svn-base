<?PHP
/**
 * 支付宝支付
 */
class Payment_Alipay_Return extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
		$payment = Sp_Payment::factory('alipay');
		$payment->complete($_GET);
	}
}
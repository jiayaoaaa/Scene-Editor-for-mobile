<?PHP
/**
 * 创建支付宝交易页面
 */
class Payment_Alipay_Index extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
		$view = new Sp_View;
		$request = Request::current();
		$order_sn = $request->c_order;
		$order_id = $request->c_orderid;
		$order_amount = $request->c_orderamount;
		$the_order = Sp_Shopping_Order::load($order_sn,'odrcode');
		if (!$the_order->ID OR $the_order->ID <> $order_id) {
			$view->assign('error_message', "错误的订单编号");
			$view->out_404();
			return;
		}
		$TruePr = $the_order["TruePr"];
		$ComePr = $the_order["ComePr"];
		$BackPr = $the_order["BackPr"];
		$the_order['order_amount'] = round($TruePr - $ComePr + $BackPr, 2);
		$Payment = Sp_Payment::factory("alipay");
		$params = array(
			'order_id' => $order_id,
			'order_sn' => $order_sn,
			'order_amount' => $the_order['order_amount']
		);
		$link = $Payment->prepare($params);
		echo $link;
	}
}
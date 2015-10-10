<?PHP

class Payment_Weixin_Recode extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    public function execute($request)
    {
		$param = array();
		$param['sn'] = 'fdsafdsafsdafds'.time();
		$param['amount'] = 0.001;
		$param['title'] = '测试支付';
		
    	$payment = Sp_Payment::factory('weixinpay');
		$returnUrl = $payment->prepare($param);
		include LIB_ROOT."third/phpqrcode/phpqrcode.php";
        // 纠错级别：L、M、Q、H
        $level = 'L';
        // 点的大小：1到10,用于手机端4就可以了
        $size = 4;
		
        // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数fal
        QRcode::png($returnUrl, false, $level, $size);
	}
}
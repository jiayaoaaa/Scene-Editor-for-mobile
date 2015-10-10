<?php
/**
 * 生成二维码
 */
class Active_Qrcode extends Sp_Account_Action_Abstract
{
	public function execute($request)
    {
		include LIB_ROOT . 'third/phpqrcode/qrlib.php';
		
		$errorCorrectionLevel = "L";  
		$matrixPointSize = "6";

		// 二维码数据
		$data = $request->code;
		if(!empty($data)) {
			QRcode::png($data, false, $errorCorrectionLevel, $matrixPointSize);
		}
	}

}
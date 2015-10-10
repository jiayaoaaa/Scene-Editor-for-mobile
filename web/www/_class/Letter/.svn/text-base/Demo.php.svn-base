<?PHP
/**
 * 邀请函二维码
 */
class Letter_Demo extends Sp_Web_Action_Abstract
{
    protected $condition = array();
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
		$url = $request->url;
		if(!empty($url)){
			// $cry = new Util_Crypt3Des();
	        // $id = $cry->encrypt($id);
			// $id = base64_encode($id);
// 			
	 		// include LIB_ROOT."third/phpqrcode/phpqrcode.php";
// 			
	        // // 纠错级别：L、M、Q、H
	        // $level = 'L';
	        // // 点的大小：1到10,用于手机端4就可以了
	        // $size = 4;
	        // // 下面注释了把二维码图片保存到本地的代码,如果要保存图片,用$fileName替换第二个参数fal
	        // QRcode::png($url, false, $level, $size);
	        $view = new Sp_View;
            $view->display("letter/demo.html");
		}else{
			$this->show404();
		}
    }

}
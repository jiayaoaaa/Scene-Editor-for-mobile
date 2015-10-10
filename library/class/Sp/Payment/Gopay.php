<?PHP

// $Id$

/**
 * Gopay
 *
 * 国付宝支付
 *
 * @package    Sp
 * @author     luozhe
 * @version    $Id$
 */

class Sp_Payment_Gopay extends Sp_Payment
{
	/**
	 * 准备支付，如准备页面、表单等信息
	 * 
	 * @param array params
	 * @return void
	 */
	#网关版本号
	public static $version                     = '2.1';
	public static $tranCode                     = '8888';
    public static $verficationCode             = "yonghejinrong";
	public function prepare($params)
	{
		$request = Request::current();
		$merchantID = $this->getOption('p1_MerId'); // 商户代码
		$backgroundMerUrl = $this->getOption('notify_url'); //返回处理地址(测试为同步地址，上线后改为异步)
		$frontMerUrl = '';//$this->getOption('return_url');//同步参数
		$reqURL_onLine = $this->getOption('reqURL_onLine'); //第三方发送地址
		
		#网关版本号
		$version                   = self::$version;

        #网关语言版本
		$language                   = '1';
		
        #交易代码
		$tranCode                   = self::$tranCode;

		
		#订单号
		$merOrderNum				= $params['sn'];

		#	交易金额,必填.
		##单位:元，精确到分.
		$tranAmt					= $params['amount'];

		#	交易币种,固定值"156"人民币.
		$currencyType				= "156";

		#	交易时间.
		$tranDateTime				= date("YmdHis",time());

		#	国付宝转入账户.
		$virCardNoIn				= $this->getOption('virCardNoIn');

		#	用户浏览器IP.
		$tranIP						= $request->getIp();

		#	商品名称
		##用于支付时显示在国付宝支付网关左侧的订单产品信息.
		$goodsName					 = '用户充值';
        $verficationCode             = self::$verficationCode;
		
		//国付宝服务器时间
		$gopayServerTime = Sp_Payment_Gopay_HttpClient::getGopayServerTime();
		
        #	密文串
		$signValue						= Sp_Payment_Gopay_HttpClient::getReqHmacString($version,$tranCode,$merchantID,$merOrderNum,$tranAmt,'',$tranDateTime,$frontMerUrl,$backgroundMerUrl,'','',$tranIP,'',$gopayServerTime,$verficationCode);
		header('Content-Type: text/html; charset=gb2312');
		$rel = '<html><head><title>支付跳转中...</title></head>';
		$rel .= '<body onLoad="document.gopay.submit();">';
		$rel .= '<style type="text/css">.tz_box{ width:536px; border-radius:10px; box-shadow:0px 0px 2px #ccc; height:350px; margin:60px auto 0px auto; border:1px solid #CFCFCF; position:relative;}</style>';
		$rel .= '<div class="tz_box"><div style="position:absolute; left:190px; top:55px;"><img width="158" src="'.SP_URL_IMG.'logo_.png" /></div><div style="margin-top:150px; border-radius:10px; text-align:center; background:#F0F0F0; width:400px; height:80px; line-height:80px; font-size:16px; margin-left:auto;margin-right:auto;">网页正在跳转中，请稍后...</div><div style="text-align:center; font-size:16px; margin-top:40px; color:#636363;">感谢您访问雍和金融网站，<br />希望能给您轻松理财体验！&nbsp;</div></div>';
		$rel .= '<form name="gopay" action="'.$reqURL_onLine.'" method="post">';
		$rel .= '<input type="hidden" name="merchantID" value="'.$merchantID.'">';
		$rel .= '<input type="hidden" name="backgroundMerUrl" value="'.$backgroundMerUrl.'">';
		$rel .= '<input type="hidden" name="frontMerUrl" value="'.$frontMerUrl.'">';
		$rel .= '<input type="hidden" name="version" value="'.$version.'">';
		$rel .= '<input type="hidden" name="language" value="'.$language.'">';
		$rel .= '<input type="hidden" name="tranCode" value="'.$tranCode.'">';
		$rel .= '<input type="hidden" name="merOrderNum" value="'.$merOrderNum.'">';
		$rel .= '<input type="hidden" name="tranAmt" value="'.$tranAmt.'">';
		$rel .= '<input type="hidden" name="currencyType" value="'.$currencyType.'">';
		$rel .= '<input type="hidden" name="tranDateTime" value="'.$tranDateTime.'">';
		$rel .= '<input type="hidden" name="virCardNoIn" value="'.$virCardNoIn.'">';
		$rel .= '<input type="hidden" name="tranIP" value="'.$tranIP.'">';
		$rel .= '<input type="hidden" name="goodsName" value="'.$goodsName.'">';
		$rel .= '<input type="hidden" name="signValue" value="'.$signValue.'">';
		$rel .= '<input type="hidden" name="gopayServerTime" value="'.$gopayServerTime.'">';
		//银行编码
		if(isset($params['bank_id']) && $params['bank_id']){
		   $rel .= '<input type="hidden" name="bankCode" value="'.$params['bank_id'].'">';
		   $rel .= '<input type="hidden" name="userType" value="1">';
		   
		}
		
		$rel .= '</form></body></html>';
		$rel = iconv("UTF-8","GB2312",$rel);
		echo $rel;
		exit;
		
		
	}
	
	/**
	 * 接收支付平台通知(同步)
	 * 
	 * @param array params
	 * @return void
	 */
	public function complete($params)
	{
		$view = new Sp_View;
		#	解析返回参数.
		$version = $params["version"];
		$charset = $params["charset"];
		$language = $params["language"];
		$signType = $params["signType"];
		$tranCode = $params["tranCode"];
		$merchantID = $params["merchantID"];
		$merOrderNum = $params["merOrderNum"];
		$tranAmt = $params["tranAmt"];
		$feeAmt = $params["feeAmt"];
		$frontMerUrl = $params["frontMerUrl"];
		$backgroundMerUrl = $params["backgroundMerUrl"];
		$tranDateTime = $params["tranDateTime"];
		$tranIP = $params["tranIP"];
		$respCode = $params["respCode"];
		$msgExt = $params["msgExt"];
		$orderId = $params["orderId"];
		$gopayOutOrderId = $params["gopayOutOrderId"];
		$bankCode = $params["bankCode"];
		$tranFinishTime = $params["tranFinishTime"];
		$merRemark1 = $params["merRemark1"];
		$merRemark2 = $params["merRemark2"];
		$signValue = $params["signValue"];
		#	判断返回签名是否正确（True/False）
		$bRet = Sp_Payment_Gopay_HttpClient::CheckHmac($version,$tranCode,$merchantID,$merOrderNum,$tranAmt,$feeAmt,$tranDateTime,$frontMerUrl,$backgroundMerUrl,$orderId,$gopayOutOrderId,$tranIP,$respCode,'',self::$verficationCode,$signValue);
		if($bRet){
            if($respCode == '0000'){
			    $sn = trim($merOrderNum);//订单号
				$amount = floatval($tranAmt);//金额
				$recharge_info = Sp_Trade_Recharge::getBySn($sn);
				if(floatval($recharge_info['amount']) == $amount) {
					$ret = false;
					$amount_num = 1;
					if($recharge_info['status'] == 1) {
					    $ret = true;
					}elseif($recharge_info['status'] < 1) {
						$amount_num = Sp_Trade_Recharge::getUserRechargeReport('WHERE status = 1 AND user_id='.$recharge_info['user_id']);
						$param = array(
							'id' => $recharge_info['id'],
							'user_id' => $recharge_info['user_id'],
							'sn' => $sn,
							'amount' => $amount,
							'bank_sn' => $_REQUEST['gopayOutOrderId'],
							'trd_sn' => $_REQUEST['orderId'],
							'remark' => json_encode($_REQUEST)
						);
						$ret = Sp_Trade_Tradeprocess::recharge($param);
					}
					if($ret) {//处理成功
						//首冲奖励
						if($amount_num == 0)
						{
							$active_send_info = array(
								'uid'=>	$recharge_info['user_id'],
								'type' => 'first_recharge'
							);
							$client_active = MQClient::factory('active');
							$client_active->send('activePrizeReset_new_register',$active_send_info);
						}
						$user = Sp_Account_User::getUserBase($recharge_info['user_id']); //用户信息
						$data = array(
							'user_id' => $recharge_info['user_id'],
							'account' => $amount,
							'user_name' => $user->data["username"],
							'email' => $user->data['email'],
							'realname' => $user->data["username"],
							'phone' => $user->data['phone'],
						);
						Sp_Message::send('recharge', $data);//发送消息
						$request = Request::current();
						if($request->isMobile()) {
							Loader::redirect(SP_URL_WAP.'moneyrecord.html');
						}else{
							Loader::redirect(SP_URL_USER.'moneyrecord.html');
						}
					}else{
						echo 'RespCode=9999|JumpURL=';
						$body = print_r($_REQUEST,true);
						Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(数据库操作失败)', $body);
					}
			   }
			}else{
				echo 'RespCode=9999|JumpURL=';
				$body = print_r($_REQUEST,true);
				Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(国付宝操作失败)', $body);
			}
		}else{
		    $body = print_r($_REQUEST,true);
			Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(签名验证失败)', $body);
			$view->assign('error_message', "抱歉，您的支付没有成功，请重新支付，谢谢");
			$view->out_404();
			return;
		}
	}
	
	/**
	 * 支付完成后返回处理(异步)
	 * 
	 * @param array params
	 * @return void
	 */
	public function notify($params)
	{
		$view = new Sp_View;
		#	解析返回参数.
		$version = $params["version"];
		$charset = $params["charset"];
		$language = $params["language"];
		$signType = $params["signType"];
		$tranCode = $params["tranCode"];
		$merchantID = $params["merchantID"];
		$merOrderNum = $params["merOrderNum"];
		$tranAmt = $params["tranAmt"];
		$feeAmt = $params["feeAmt"];
		$frontMerUrl = $params["frontMerUrl"];
		$backgroundMerUrl = $params["backgroundMerUrl"];
		$tranDateTime = $params["tranDateTime"];
		$tranIP = $params["tranIP"];
		$respCode = $params["respCode"];
		$msgExt = $params["msgExt"];
		$orderId = $params["orderId"];
		$gopayOutOrderId = $params["gopayOutOrderId"];
		$bankCode = $params["bankCode"];
		$tranFinishTime = $params["tranFinishTime"];
		$merRemark1 = $params["merRemark1"];
		$merRemark2 = $params["merRemark2"];
		$signValue = $params["signValue"];

		#	判断返回签名是否正确（True/False）
		$bRet = Sp_Payment_Gopay_HttpClient::CheckHmac($version,$tranCode,$merchantID,$merOrderNum,$tranAmt,$feeAmt,$tranDateTime,$frontMerUrl,$backgroundMerUrl,$orderId,$gopayOutOrderId,$tranIP,$respCode,'',self::$verficationCode,$signValue);
		if($bRet){
            if($respCode == '0000'){
			    $sn = trim($merOrderNum);//订单号
				$amount = floatval($tranAmt);//金额
				$recharge_info = Sp_Trade_Recharge::getBySn($sn);
				$amount_num = 1;
				if(floatval($recharge_info['amount']) == $amount) {
					$ret = false;
					if($recharge_info['status'] == 1){
					    $request = Request::current();
						if($request->isMobile()) {
							echo 'RespCode=0000|JumpURL='.SP_URL_WAP.'moneyrecord.html';
						}else{
							echo 'RespCode=0000|JumpURL='.SP_URL_USER.'moneyrecord.html';
						}
						exit;
					}elseif($recharge_info['status'] < 1) {
						$amount_num = Sp_Trade_Recharge::getUserRechargeReport('WHERE status = 1 AND user_id='.$recharge_info['user_id']);
						$param = array(
							'id' => $recharge_info['id'],
							'user_id' => $recharge_info['user_id'],
							'sn' => $sn,
							'amount' => $amount,
							'bank_sn' => $_REQUEST['gopayOutOrderId'],
							'trd_sn' => $_REQUEST['orderId'],
							'remark' => json_encode($_REQUEST)
						);
						$ret = Sp_Trade_Tradeprocess::recharge($param);
					}
					if($ret) {//处理成功
						//首冲奖励
						if($amount_num == 0)
						{
							$active_send_info = array(
								'uid'=>	$recharge_info['user_id'],
								'type' => 'first_recharge'
							);
							$client_active = MQClient::factory('active');
							$client_active->send('activePrizeReset_new_register',$active_send_info);
						}
						$user = Sp_Account_User::getUserBase($recharge_info['user_id']); //用户信息
						$data = array(
							'user_id' => $recharge_info['user_id'],
							'account' => $amount,
							'user_name' => $user->data["username"],
							'email' => $user->data['email'],
							'realname' => $user->data["username"],
							'phone' => $user->data['phone'],
						);
						Sp_Message::send('recharge', $data);//发送消息
						$request = Request::current();
						if($request->isMobile()) {
							echo 'RespCode=0000|JumpURL='.SP_URL_WAP.'moneyrecord.html';
						}else{
							echo 'RespCode=0000|JumpURL='.SP_URL_USER.'moneyrecord.html';
						}
					}else{
						echo 'RespCode=9999|JumpURL=';
						$body = print_r($_REQUEST,true);
						Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(数据库处理失败)', $body);
					}
			   }
			}else{
				$body = print_r($_REQUEST,true);
				Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(国付宝处理失败)', $body);
				echo 'RespCode=9999|JumpURL=';
			}
		}else{
		    $body = print_r($_REQUEST,true);
			Sp_Admin_Mail::send('274211178@qq.com', '国付宝支付失败(签名验证失败)', $body);
			echo 'RespCode=9999|JumpURL=';
			exit;
		}
	}
}
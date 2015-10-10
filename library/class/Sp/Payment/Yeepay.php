<?PHP

// $Id$

/**
 * Yeepay
 *
 * 易宝支付
 *
 * @package    Sp
 * @author     guolinlin
 * @version    $Id$
 */

class Sp_Payment_Yeepay extends Sp_Payment
{
	/**
	 * 准备支付，如准备页面、表单等信息
	 * 
	 * @param array params
	 * @return void
	 */
	public function prepare($params)
	{
		$p1_MerId = $this->getOption('p1_MerId'); // 商户号
		$merchantKey = $this->getOption('merchantKey'); // "8934e7d15453e97507ef794cf7b0519d";密钥
		$return_url = $this->getOption('return_url'); //返回处理地址
		$reqURL_onLine = $this->getOption('reqURL_onLine'); //返回处理地址
		
		#	商户订单号,选填.
		##若不为""，提交的订单号必须在自身账户交易中唯一;为""时，易宝支付会自动生成随机的商户订单号.
		$p2_Order					= $params['sn'];

		#	支付金额,必填.
		##单位:元，精确到分.
		$p3_Amt						= $params['amount'];

		#	交易币种,固定值"CNY".
		$p4_Cur						= "CNY";

		#	商品名称
		##用于支付时显示在易宝支付网关左侧的订单产品信息.
		$p5_Pid						= '用户充值';

		#	商品种类
		$p6_Pcat					= '';

		#	商品描述
		$p7_Pdesc					= '';

		#	商户接收支付成功数据的地址,支付成功后易宝支付会向该地址发送两次成功通知.
		$p8_Url						= $return_url;	

		#	商户扩展信息
		##商户可以任意填写1K 的字符串,支付成功时将原样返回.												
		$pa_MP						= $params['user_id'];

		#	支付通道编码
		##默认为""，到易宝支付网关.若不需显示易宝支付的页面，直接跳转到各银行、神州行支付、骏网一卡通等支付页面，该字段可依照附录:银行列表设置参数值.			
		$pd_FrpId					= $params['bank_id'] ? $params['bank_id'] : '';

		#	应答机制
		##默认为"1": 需要应答机制;
		$pr_NeedResponse	= "0";

		#调用签名函数生成签名串
		$hmac = Sp_Payment_Yeepay_Common::getReqHmacString($p2_Order,$p3_Amt,$p4_Cur,$p5_Pid,$p6_Pcat,$p7_Pdesc,$p8_Url,$pa_MP,$pd_FrpId,$pr_NeedResponse);
		$p0_Cmd = Sp_Payment_Yeepay_Common::$p0_Cmd;
		$p9_SAF = Sp_Payment_Yeepay_Common::$p9_SAF;
		header('Content-Type: text/html; charset=gb2312');
		$rel = '<html><body onLoad="document.yeepay.submit();">';
		$rel .= '<form name="yeepay" action="'.$reqURL_onLine.'" method="post">';
		$rel .= '<input type="hidden" name="p0_Cmd" value="'.$p0_Cmd.'">';
		$rel .= '<input type="hidden" name="p1_MerId" value="'.$p1_MerId.'">';
		$rel .= '<input type="hidden" name="p2_Order" value="'.$p2_Order.'">';
		$rel .= '<input type="hidden" name="p3_Amt" value="'.$p3_Amt.'">';
		$rel .= '<input type="hidden" name="p4_Cur" value="'.$p4_Cur.'">';
		$rel .= '<input type="hidden" name="p5_Pid" value="'.$p5_Pid.'">';
		$rel .= '<input type="hidden" name="p6_Pcat" value="'.$p6_Pcat.'">';
		$rel .= '<input type="hidden" name="p7_Pdesc" value="'.$p7_Pdesc.'">';
		$rel .= '<input type="hidden" name="p8_Url" value="'.$p8_Url.'">';
		$rel .= '<input type="hidden" name="p9_SAF" value="'.$p9_SAF.'">';
		$rel .= '<input type="hidden" name="pa_MP" value="'.$pa_MP.'">';
		$rel .= '<input type="hidden" name="pd_FrpId" value="'.$pd_FrpId.'">';
		$rel .= '<input type="hidden" name="pr_NeedResponse" value="'.$pr_NeedResponse.'">';
		$rel .= '<input type="hidden" name="hmac" value="'.$hmac.'">';
		$rel .= '</form></body></html>';
		$rel = iconv("UTF-8","GB2312",$rel);
		echo $rel;
		exit;
	}
	
	/**
	 * 接收支付平台通知
	 * 
	 * @param array params
	 * @return void
	 */
	public function notify($params)
	{
		;
	}
	
	/**
	 * 支付完成后返回处理
	 * 
	 * @param array params
	 * @return void
	 */
	public function complete($params)
	{
		$view = new Sp_View;
		#	解析返回参数.
		$return = Sp_Payment_Yeepay_Common::getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);

		#	判断返回签名是否正确（True/False）
		$bRet = Sp_Payment_Yeepay_Common::CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
		#	以上代码和变量不需要修改.
				
		#	校验码正确.
		if($bRet){
			if($r1_Code=="1"){
				
			#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
			#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.      	  	
				
				$user_id = $r8_MP;//用户id
				$sn = trim($r6_Order);//订单号
				$amount = floatval($r3_Amt);//金额
				$recharge_info = Sp_Trade_Recharge::getBySn($sn);
				if(floatval($recharge_info['amount']) == $amount and $recharge_info['user_id'] == $user_id) {
					if($r9_BType=="1"){#交易成功 在线支付页面返回
						$request = Request::current();
						if($request->isMobile()) {
							Loader::redirect(SP_URL_WAP.'moneyrecord.html');
						}else{
							Loader::redirect(SP_URL_USER.'moneyrecord.html');
						}
						/*
						$ret = false;
						if($recharge_info['status'] < 1) {
							$param = array(
								'id' => $recharge_info['id'],
								'user_id' => $user_id,
								'sn' => $sn,
								'amount' => $amount,
								'bank_sn' => $_REQUEST['ro_BankOrderId'],
								'trd_sn' => $_REQUEST['r2_TrxId'],
								'remark' => json_encode($_REQUEST)
							);
							$ret = Sp_Trade_Tradeprocess::recharge($param);
						}
						if($ret) {//处理成功
							$user = Sp_Account_User::getUserBase($user_id); //用户信息
							$data = array(
								'user_id' => $user_id,
								'account' => $amount,
								'user_name' => $user->data["username"],
								'email' => $user->data['email'],
								'realname' => $user->data["username"],
								'phone' => $user->data['phone'],
							);
							Sp_Message::send('recharge', $data);//发送消息
							Loader::redirect(SP_URL_USER.'moneyrecord.html');
						}elseif($recharge_info['status'] < 1) {//失败
							echo '资金流处理失败！';
							$body = print_r($_REQUEST,true);
							Sp_Admin_Mail::send('zeningli@qq.com', '资金流处理失败！', $body);
						}else{
							$request = Request::current();
							if($request->isMobile()) {
								Loader::redirect(SP_URL_WAP.'moneyrecord.html');
							}else{
								Loader::redirect(SP_URL_USER.'moneyrecord.html');
							}
						}*/
					}elseif($r9_BType=="2"){
						#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
						$ret = false;
						if($recharge_info['status'] == 1) {
							echo "success";
						}elseif($recharge_info['status'] < 1) {
							$param = array(
								'id' => $recharge_info['id'],
								'user_id' => $user_id,
								'sn' => $sn,
								'amount' => $amount,
								'bank_sn' => $_REQUEST['ro_BankOrderId'],
								'trd_sn' => $_REQUEST['r2_TrxId'],
								'remark' => json_encode($_REQUEST),
							);
							$amount_num = Sp_Trade_Recharge::getUserRechargeReport('WHERE status = 1 AND user_id='.$user_id);
							$ret = Sp_Trade_Tradeprocess::recharge($param);
							if($ret) {//处理成功

								//首冲奖励
								if($amount_num == 0)
								{
									$active_send_info = array(
										'uid'=>	$user_id,
										'type' => 'first_recharge'
									);
									$client_active = MQClient::factory('active');
									$client_active->send('activePrizeReset_new_register',$active_send_info);
								}
								$user = Sp_Account_User::getUserBase($user_id); //用户信息
								$data = array(
									'user_id' => $user_id,
									'account' => $amount,
									'user_name' => $user->data["username"],
									'email' => $user->data['email'],
									'realname' => $user->data["username"],
									'phone' => $user->data['phone'],
								);
								Sp_Message::send('recharge', $data);//发送消息
							}else{
								echo '资金流处理失败！';
								$body = print_r($_REQUEST,true);
								Sp_Admin_Mail::send('zeningli@qq.com', '资金流处理失败！', $body);
							}
						}	 
					}
				}
			}
		}else{
			$body = print_r($_REQUEST,true);
			Sp_Admin_Mail::send('zeningli@qq.com', '易宝支付失败(签名验证失败)', $body);
			$view->assign('error_message', "抱歉，您的支付没有成功，请重新支付，谢谢");
			$view->out_404();
			return;
		}
	}
}
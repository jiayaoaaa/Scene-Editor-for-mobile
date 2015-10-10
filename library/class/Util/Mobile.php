<?php
   /**
 * 漫道科技短信平台函数
 * @param 类型string $info['phone'] 手机号码
 * @param 类型string $info['content'] 发送内容
 */

class Util_Mobile
{

    public function mdgms($info)
	{
		
		//初始化
		////另外的一个帐号
		$gmssn  = 'SDK-BBX-010-19818';
		$gmspwd = strtoupper(md5($gmssn.'c-860e-['));
		$argv = array( 
				 'sn'=>$gmssn, //提供的账号
				 'pwd'=>$gmspwd, //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
				 'mobile'=>$info['phone'],//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
				 'content'=>iconv('UTF-8', 'GB2312', $info['content']),//短信内容
				 'ext'=>'',
				 'rrid'=>'',//默认空 如果空返回系统生成的标识串 如果传值保证值唯一 成功则返回传入的值
				 'stime'=>''//定时时间 格式为2011-6-29 11:09:21
				 );
		$flag = 0; 
		//要post的数据 
		$params="";
		//构造要post的字符串 
		foreach ($argv as $key=>$value) { 
			 if ($flag!=0) { 
							 $params .= "&"; 
							 $flag = 1; 
			  } 
			 $params .= $key."=";
			 $params .= urlencode($value); 
			 $flag = 1; 
		} 
		$length = strlen($params); 
		//创建socket连接 
		$fp = fsockopen("sdk2.entinfo.cn",80,$errno,$errstr,10) or exit($errstr."--->".$errno);

		//构造post请求的头 
		$header = "POST /z_mdsmssend.aspx HTTP/1.1\r\n"; 
		$header .= "Host:sdk2.entinfo.cn\r\n"; 
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n"; 
		$header .= "Content-Length: ".$length."\r\n"; 
		$header .= "Connection: Close\r\n\r\n"; 
		//添加post的字符串 
		$header .= $params."\r\n"; 
		//发送post的数据 
		$t = fputs($fp,$header);
		$inheader = 1; 
		
		$res = Sp_Common_Sms::insertSms($info); 
		
		while (!feof($fp)) { 
			$line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据 
			if ($inheader && ($line == "\n" || $line == "\r\n")) { 
				$inheader = 0;
			}
			if ($inheader == 0) {
				return $line;
			} 
		} 
		fclose($fp);
		
	}
}


?>   

                         
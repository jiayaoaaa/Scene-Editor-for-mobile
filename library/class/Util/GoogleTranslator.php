<?php
/**
 * GOOGLE翻译API
 * $Id$
 * $str = Util_GoogleTranslator::translater($text);
 * @author Abu
 *
 */
class Util_GoogleTranslator {
	const GOOGLE_API_URL = 'http://translate.google.com/translate_t';
	
	/**
	 * 处理数据并返回
	 * 
	 * @param string $text
	 * @param string $from
	 * @param string $to
	 */
	public static function translate($text, $from = 'auto', $to = 'zh-CN') {
		$gphtml = self::postPage ( self::GOOGLE_API_URL, $text, $from, $to );
		//print_r($gphtml); exit;
		if ($gphtml) {
			preg_match_all ( '/<span\s+title\="[^>]+>([^<]+)<\/span>/i', $gphtml, $res );
			//print_r($res); exit;
			if (! empty ( $res [1] [0] ) && isset ( $res [1] [0] ))
				$out = $res [1] [0];
			else
				$out = $text;
		} else {
			$out = "";
		}
		return $out;
	}
	
	/**
	 * 
	 * 发送请求返回数据
	 * @param string $url
	 * @param string $text
	 * @param string $from
	 * @param string $to
	 */
	public static function postPage($url, $text, $from, $to) {
		$str = "";
		if ($url != "" && $text != "") {
			$ch = curl_init ( $url );
			//设定以文本方式返回数据
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			//允许GOOGLE将请求重定向并从重定向页面接收返回内容
			curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 15 );
			//这里组织发送参数，基本上不用改，如果一定要改，建议定义变量修改
			$fields = array ('hl=zh-CN', 'langpair=' . $from . '|' . $to, 'ie=UTF-8', 'text=' . $text );
			$fields = implode ( '&', $fields );
			//发送POST请求
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
			$str = curl_exec ( $ch );
			//print_r($html); exit;
			if (curl_errno ( $ch ))
				$str = "";
			curl_close ( $ch );
		}
		return $str;
	}
}
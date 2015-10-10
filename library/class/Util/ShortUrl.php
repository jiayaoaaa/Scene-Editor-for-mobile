<?php
    Class Util_ShortUrl {
    	
		public static function shortUrl($url='', $prefix='', $suffix='') {
			$base32 = array (
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
			'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p',
			'q', 'r', 's', 't', 'u', 'v', 'w', 'x',
			'y', 'z', '0', '1', '2', '3', '4', '5');
			
			$hex = md5($prefix.$url.$suffix);
			$hexLen = strlen($hex);
			$subHexLen = $hexLen / 8;
			$output = array();
			
			for ($i = 0; $i < $subHexLen; $i++) {
				$subHex = substr ($hex, $i * 8, 8);
				$int = 0x3FFFFFFF & (1 * ('0x'.$subHex));
				$out = '';
				for ($j = 0; $j < 6; $j++) {
					$val = 0x0000001F & $int;
					$out .= $base32[$val];
					$int = $int >> 5;
				}
				$output[] = $out;
			}
			return $output;
		}
		
		/**
		 * 通过新浪接口获得短链接
		 */
		public static function shortSina($url){
			$url = "http://api.t.sina.com.cn/short_url/shorten.json?source=949250644&url_long=".urlencode($url);
			$curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			
            $re = curl_exec($curl);
			
            if (curl_errno($curl)) {
               	return FALSE;
            }
			
			$re = json_decode($re,TRUE);
			
            curl_close($curl);
            return is_array($re) && count($re) > 0?$re[0]:FALSE;	
		}
		
    }
    
?>
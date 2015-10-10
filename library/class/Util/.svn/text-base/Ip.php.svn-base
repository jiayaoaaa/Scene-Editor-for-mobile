<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_Ip IP地址计算工具
 * 
 * 
 * @author ao
 * @version $Id$
 */

// 

/**
 * Util_Ip
 *
 * example: 
 * $str = Util_Ip::convert('64.233.189.99');
 * echo $str;	// - 美国 加利福尼亚州Google公司
 */
class Util_Ip
{
	
	public static function convert($ip) {
		if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
			return '';
		}

		$ipdata_file = LIB_ROOT.'resource/ip_data/wry.dat';
		//var_dump($ipdata_file);
		if( file_exists($ipdata_file) && $fd = fopen($ipdata_file, 'rb')) 
		{

			$ip = explode('.', $ip);
			$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

			$DataBegin = fread($fd, 4);
			$DataEnd = fread($fd, 4);
			$ipbegin = implode('', unpack('L', $DataBegin));
			if($ipbegin < 0) $ipbegin += pow(2, 32);
			$ipend = implode('', unpack('L', $DataEnd));
			if($ipend < 0) $ipend += pow(2, 32);
			$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

			$BeginNum = 0;
			$EndNum = $ipAllNum;
			$ip1num = 0;
			$ip2num = 0;
			while($ip1num > $ipNum || $ip2num < $ipNum) {
				$Middle= intval(($EndNum + $BeginNum) / 2);

				fseek($fd, $ipbegin + 7 * $Middle);
				$ipData1 = fread($fd, 4);
				if(strlen($ipData1) < 4) {
					fclose($fd);
					return '- System Error';
				}
				$ip1num = implode('', unpack('L', $ipData1));
				if($ip1num < 0) $ip1num += pow(2, 32);

				if($ip1num > $ipNum) {
					$EndNum = $Middle;
					continue;
				}

				$DataSeek = fread($fd, 3);
				if(strlen($DataSeek) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
				fseek($fd, $DataSeek);
				$ipData2 = fread($fd, 4);
				if(strlen($ipData2) < 4) {
					fclose($fd);
					return '- System Error';
				}
				$ip2num = implode('', unpack('L', $ipData2));
				if($ip2num < 0) $ip2num += pow(2, 32);

				if($ip2num < $ipNum) {
					if($Middle == $BeginNum) {
						fclose($fd);
						return '- Unknown';
					}
					$BeginNum = $Middle;
				}
			}

			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(1)) {
				$ipSeek = fread($fd, 3);
				if(strlen($ipSeek) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
				fseek($fd, $ipSeek);
				$ipFlag = fread($fd, 1);
			}
			$ipAddr1 = 0;
			$ipAddr2 = 0;
			if($ipFlag == chr(2)) {
				$AddrSeek = fread($fd, 3);
				if(strlen($AddrSeek) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$ipFlag = fread($fd, 1);
				if($ipFlag == chr(2)) {
					$AddrSeek2 = fread($fd, 3);
					if(strlen($AddrSeek2) < 3) {
						fclose($fd);
						return '- System Error';
					}
					$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
					fseek($fd, $AddrSeek2);
				} else {
					fseek($fd, -1, SEEK_CUR);
				}
				$ipAddr2  = 0;				
				while(($char = fread($fd, 1)) != chr(0))
					$ipAddr2 .= $char;

				$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
				fseek($fd, $AddrSeek);
				
				while(($char = fread($fd, 1)) != chr(0))
					$ipAddr1 .= $char;
			} else {
				fseek($fd, -1, SEEK_CUR);
				while(($char = fread($fd, 1)) != chr(0))
					$ipAddr1 .= $char;

				$ipFlag = fread($fd, 1);
				if($ipFlag == chr(2)) {
					$AddrSeek2 = fread($fd, 3);
					if(strlen($AddrSeek2) < 3) {
						fclose($fd);
						return '- System Error';
					}
					$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
					fseek($fd, $AddrSeek2);
				} else {
					fseek($fd, -1, SEEK_CUR);
				}
				while(($char = fread($fd, 1)) != chr(0))
					$ipAddr2 .= $char;
			}
			fclose($fd);

			if(preg_match('/http/i', $ipAddr2)) {
				$ipAddr2 = '';
			}
			$ipaddr = "$ipAddr1 $ipAddr2";
			$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
			$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
			$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
			if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
				$ipaddr = '- Unknown';
			}

			return '- '.$ipaddr;

		}
		else 
		{

			$datadir = LIB_ROOT.'resource/ipdata/';
			$ip_detail = explode('.', $ip);
			if(file_exists($datadir.$ip_detail[0].'.txt')) {
				$ip_fdata = @fopen($datadir.$ip_detail[0].'.txt', 'r');
			} else {
				if(!($ip_fdata = @fopen($datadir.'0.txt', 'r'))) {
					return '- Invalid IP data file';
				}
			}
			for($i = 0; $i <= 3; $i++) {
				$ip_detail[$i] = sprintf('%03d', $ip_detail[$i]);
			}
			$ip = join('.', $ip_detail);
			do {
				$ip_data = fgets($ip_fdata, 200);
				$ip_data_detail = explode('|', $ip_data);
				if($ip >= $ip_data_detail[0] && $ip <= $ip_data_detail[1]) {
					fclose($ip_fdata);
					return '- '.$ip_data_detail[2].$ip_data_detail[3];
				}
			} while(!feof($ip_fdata));
			fclose($ip_fdata);
			return '- UNKNOWN';

		}

	}

}
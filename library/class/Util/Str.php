<?php
/**
 *@author: jiarongping
 *@createtime: 2014-05-19
 *@version: 1.0
 **/
class Util_Str{
	
	/**
	 *@desc 截取字符串
	 *@param $string 需要截取的字符串
	 *@param $length 需要截取的字符长度$length 汉字为2倍
	 *@param $etc 后缀
	 *@return string
	 **/
	public static function cutStr($string, $length, $etc='...')
	{
		
		 $result  = '';    
          $string  =  html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');    
          //$string   =   trim($string);
          $strlen = strlen($string);  
   
          for($i = 0;(($i < $strlen) && ($length > 0));   $i++)  
          {  
			  if($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))  
			  {  
				  if($length   <   1.0)  
				  {  
						  break;  
				  }  

				  $result   .=   substr($string,   $i,   $number);  
				  $length   -=   1.0;  
				  $i   +=   $number   -   1;  
			  }  
			  else  
			  {  
				   $result .= substr($string,$i,1);  
				   $length -= 0.5;  
			  }  
          }  
   
          $result =  htmlspecialchars($result,ENT_QUOTES,'UTF-8');  
   
          if($i<$strlen)  
          {  
              $result .= $etc;  
          }  
   
          return  $result;  
		
	}
	
	/**
	 * @description 装饰字符串
	 * @param string $str 原字符串
	 * @param array $len 长度集
	 * @param string $etc 替换字符
	 * @return string
	**/
	public static function decorateStr($str, $len, $etc='*', $max_etc_len = 0)
	{
		if(empty($str) || empty($len) || empty($etc) || strlen($etc) < 1)
			return false;
		
		
		$str = self::stringToArray($str);
		$len_str = count($str);
		$result = '';
		$etc_len = 0;
		foreach($len as $v)
		{
			if(preg_match('/\d+\.\d+/',$v))
			{
				$len_arr = explode('.',$v);
				$start = (int)$len_arr[0]-1;
				$end = (int)$len_arr[1]-1;
			}
			else
			{
				$len_arr = explode('-',$v);
				$start = (int)$len_arr[0]-1;
				$end = (int)($start+$len_arr[1])-1;
			}
			
			
			if($start < 1)
			{
				continue;
			}
			elseif($end < 1)
			{
				for($i=0; $i<$len_str; $i++)
				{
					if($str[$i] == $etc)
					{
						continue;
					}
					elseif($i >= $start)
					{
						if(($max_etc_len > 0 && $etc_len < $max_etc_len) || $max_etc_len < 1)
						{
							$result .= $etc; 
							$etc_len ++;
						}
					}
					else
					{
						$result .= $str[$i];
					}
				}
			}
			else
			{
				if($start > $end) {
					$end = $start;
				}
				for($i=0; $i<$len_str; $i++)
				{
					if($str[$i] == $etc)
					{
						continue;
					}
					elseif($i >= $start && $i <= $end)
					{
						if(($max_etc_len > 0 && $etc_len < $max_etc_len) || $max_etc_len < 1)
						{
							$result .= $etc; 
							$etc_len ++;
						}
					}
					else
					{
						$result .= $str[$i];
					}	
				}
			}
		}

		return $result;
	

	}


	public static function getStrLen($str)
	{
		$str_arr = self::stringToArray($str);
		return count($str_arr);
	}


	/**
	* @description 字符串转换为数组 utf-8
	* @param string $str 字符串
	* @return array
	**/
	public static function stringToArray($str)
	{
		$arr = array();
		$string   =   html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');    
		for($i=0;$i<strlen($str);$i++){
			
			if(ord($str[$i])>127)
			{
				$arr[]=$str[$i].$str[++$i].$str[++$i];
			}
			else
			{
				$arr[]=$str[$i];
			}
		}

		return $arr;
	}
    /**
	* @description 转换大写 utf-8
	* @param string $str 字符串
	* @return array
	**/
	public static function  cny($ns) {
		static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
			$cnyunits=array("元","角","分"),
			$grees=array("拾","佰","仟","万","拾","佰","仟","亿");
		list($ns1,$ns2)=explode(".",$ns,2);
		if($ns2 !== '00'){
			$ns2 = self::stringToArray($ns2);
			krsort($ns2);
		}else{
		    $ns2 = array();
		}
		$ret=array_merge($ns2,array(implode("",self::cny_map_unit(str_split($ns1),$grees)),""));
		$ret=implode("",array_reverse(self::cny_map_unit($ret,$cnyunits)));
		return str_replace(array_keys($cnums),$cnums,$ret);
	}
	public static function cny_map_unit($list,$units) {
		$ul=count($units);
		$xs=array();
		foreach (array_reverse($list) as $x) {
			$l=count($xs);
			if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]);
			else $n=is_numeric($xs[0][0])?$x:'';
			array_unshift($xs,$n);
		}
		return $xs;
	}
}
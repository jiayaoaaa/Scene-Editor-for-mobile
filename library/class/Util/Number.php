<?php
/**
 *@author: jiarongping
 *@createtime: 2014-06-10
 *@version: 1.0
 **/
class Util_Number{
	
	/** 
     * @desc  im:十进制数转换成三十六机制数 
     * @param (int)$num 十进制数 
     * return 返回：三十六进制数 
    */  
    public static function get_char($num) {  
        $num = intval($num);  
        if ($num <= 0)  
            return false;  
        $charArr = array("0","1","2","3","4","5","6","7","8","9",'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');  
        $char = '';  
        do {  
            $key = ($num - 1) % 36;  
            $char= $charArr[$key] . $char;  
            $num = floor(($num - $key) / 36);  
        } while ($num > 0);  
        return $char;  
     }  
      
    /** 
     * @desc  im:三十六进制数转换成十机制数 
     * @param (string)$char 三十六进制数 
     * return 返回：十进制数 
     */  
    public static function get_num($char){  
        $array=array("0","1","2","3","4","5","6","7","8","9","A", "B", "C", "D","E", "F", "G", "H", "I", "J", "K", "L","M", "N", "O","P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y","Z");  
        $len=strlen($char);  
        for($i=0;$i<$len;$i++){  
            $index=array_search($char[$i],$array);  
            $sum+=($index+1)*pow(36,$len-$i-1);  
        }  
        return $sum;  
    }
}
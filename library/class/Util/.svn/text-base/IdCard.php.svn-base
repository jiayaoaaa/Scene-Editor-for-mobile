<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */

/**
 * Util_IdCard 身份证验证
 * 
 * 
 * @author ao
 * @version $Id$
 */

// 

/**
 * Util_IdCard
 *
 * example: 
 * $str = Util_IdCard::isCreditNo('220202198702035263');
 * echo $str;
 */
class Util_IdCard
{
	
	 /**
	 * 验证身份证号
	 * @param $vStr
	 * @return bool
	 */
	public static function isCreditNo($vStr)
	{
		$vCity = array(
			'11','12','13','14','15','21','22',
			'23','31','32','33','34','35','36',
			'37','41','42','43','44','45','46',
			'50','51','52','53','54','61','62',
			'63','64','65','71','81','82','91'
		);

		if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;

		if (!in_array(substr($vStr, 0, 2), $vCity)) return false;

		$vStr = preg_replace('/[xX]$/i', 'a', $vStr);
		$vLength = strlen($vStr);

		if ($vLength == 18)
		{
			$vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
		} else {
			$vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
		}

		if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
		if ($vLength == 18)
		{
			$vSum = 0;

			for ($i = 17 ; $i >= 0 ; $i--)
			{
				$vSubStr = substr($vStr, 17 - $i, 1);
				$vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
			}

			if($vSum % 11 != 1) return false;
		}

		return true;
	}

	// $num为身份证号码，$checkSex：1为男，2为女，不输入为不验证
    public static function isCreditNoOrSex($num,$checkSex=''){
        // 不是15位或不是18位都是无效身份证号
        if(strlen($num) != 15 && strlen($num) != 18){
            return false;
        }
        // 是数值
        if(is_numeric($num)){
            // 如果是15位身份证号
            if(strlen($num) == 15 ){
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（6位）
                $dateNum = substr($num,6,6);
                // 性别（3位）
                $sexNum = substr($num,12,3);
            }else{
            // 如果是18位身份证号
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
            }
        }else{
        // 不是数值
            if(strlen($num) == 15){
                return false;
            }else{
                // 验证前17位为数值，且18位为字符x
                $check17 = substr($num,0,17);
                if(!is_numeric($check17)){
                    return false;
                }
                // 省市县（6位）
                $areaNum = substr($num,0,6);
                // 出生年月（8位）
                $dateNum = substr($num,6,8);
                // 性别（3位）
                $sexNum = substr($num,14,3);
                // 校验码（1位）
                $endNum = substr($num,17,1);
                if($endNum != 'x' && $endNum != 'X'){
                    return false;
                }
            }
        }
 
        if(isset($areaNum)){
            if(!self::checkArea($areaNum)){
                return false;
            }
        }
 
        if(isset($dateNum)){
            if(!self::checkDate($dateNum)){
                return false;
            }
        }
        // 性别1为男，2为女
        if($checkSex == 1){
			//die(123);
            if(isset($sexNum)){
                if(!self::checkSex($sexNum)){
                    return false;
                }
            }
        }else if($checkSex == 2){
			//die(123);
            if(isset($sexNum)){
                if(self::checkSex($sexNum)){
                    return false;
                }
            }
        }
 
        if(isset($endNum)){
            if(!self::checkEnd($endNum,$num)){
				//var_dump(self::checkEnd($endNum,$num));
                return false;
            }
        }
        return true;
    }
 
    // 验证城市
    private static function checkArea($area){
        $num1 = substr($area,0,2);
        $num2 = substr($area,2,2);
        $num3 = substr($area,4,2);
        // 根据GB/T2260—999，省市代码11到65
        if(10 < $num1 && $num1 < 66){
            return true;
        }else{
            return false;
        }
        //============
        // 对市 区进行验证
        //============
    }
 
    // 验证出生日期
    private static function checkDate($date){
        if(strlen($date) == 6){
            $date1 = substr($date,0,2);
            $date2 = substr($date,2,2);
            $date3 = substr($date,4,2);
            $statusY = self::checkY('19'.$date1);
        }else{
            $date1 = substr($date,0,4);
            $date2 = substr($date,4,2);
            $date3 = substr($date,6,2);
            $nowY = date("Y",time());
            if(1900 < $date1 && $date1 <= $nowY){
                $statusY = self::checkY($date1);
            }else{
                return false;
            }
        }
        if(0<$date2 && $date2 <13){
            if($date2 == 2){
                // 润年
                if($statusY){
                    if(0 < $date3 && $date3 <= 29){
                        return true;
                    }else{
                        return false;
                    }
                }else{
                // 平年
                    if(0 < $date3 && $date3 <= 28){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                $maxDateNum = self::getDateNum($date2);
                if(0<$date3 && $date3 <=$maxDateNum){
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }
 
    // 验证性别
    private static function checkSex($sex){
        if($sex % 2 == 0){
            return false;
        }else{
            return true;
        }
    }
 
    // 验证18位身份证最后一位
    private static function checkEnd($end,$num){
        $checkHou = array(1,0,'x',9,8,7,6,5,4,3,2);
        $checkGu = array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        $sum = 0;
        for($i = 0;$i < 17; $i++){
            $sum += (int)$checkGu[$i] * (int)$num[$i];
        }
        $checkHouParameter= $sum % 11;
        if($checkHou[$checkHouParameter] != $num[17]){
            return false;
        }else{
            return true;
        }
    }
 
    // 验证平年润年，参数年份,返回 true为润年  false为平年
    private static function checkY($Y){
        if(getType($Y) == 'string'){
            $Y = (int)$Y;
        }
        if($Y % 100 == 0){
            if($Y % 400 == 0){
                return true;
            }else{
                return false;
            }
        }else if($Y % 4 ==  0){
            return true;
        }else{
            return false;
        }
    }
 
    // 当月天数 参数月份（不包括2月）  返回天数
    private static function getDateNum($month){
        if($month == 1 || $month == 3 || $month == 5 || $month == 7 || $month == 8 || $month == 10 || $month == 12){
            return 31;
        }else if($month == 2){
        }else{
            return 30;
        }
    }
 
}
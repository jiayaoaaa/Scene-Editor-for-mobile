<?php
/**
 * Dictionary
 *
 * @author zhaoyu
 * @version $Id$
 * @created 2015-07-13
 * @系统字典
 */

/**
 * Acl
 */
class Sp_Dictionary{   
	
	public static function getOtherOption($k = '', $v = null){
		
		$config = array(
			//验证手机
			'patternMobile' => "/^1[3|4|5|7|8][0-9]\d{8}$/",
			//验证邮箱
			'patternEmail' => "/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/",
			//验证密码
			'patternPasswd' => "/^[a-z0-9_]{6,24}$/",
			//验证用户ID
			'patternUserId' => "/^\d{6,10}$/",

		);

		return isset($v)?$config[$k][$v]:$config[$k];
	}
    /*
     * editor by carten
     * 获取第一个文中的首字母
     * @string 中文
     * @return 
     */
    public static function getFirstCharter($str = ''){
        
        if(empty($str)){return false;}	
        $fchar=ord($str{0});
        if($fchar>=ord('A')&&$fchar<=ord('z')) return strtoupper($str{0});

        $s1=iconv('UTF-8','gb2312',$str);
        $s2=iconv('gb2312','UTF-8',$s1);
        $s=$s2==$str?$s1:$str;
        $asc=ord($s{0})*256+ord($s{1})-65536;

        if($asc>=-20319&&$asc<=-20284) return 'A';
        if($asc>=-20283&&$asc<=-19776) return 'B';
        if($asc>=-19775&&$asc<=-19219) return 'C';
        if($asc>=-19218&&$asc<=-18711) return 'D';
        if($asc>=-18710&&$asc<=-18527) return 'E';
        if($asc>=-18526&&$asc<=-18240) return 'F';
        if($asc>=-18239&&$asc<=-17923) return 'G';
        if($asc>=-17922&&$asc<=-17418) return 'H';
        if($asc>=-17417&&$asc<=-16475) return 'J';
        if($asc>=-16474&&$asc<=-16213) return 'K';
        if($asc>=-16212&&$asc<=-15641) return 'L';
        if($asc>=-15640&&$asc<=-15166) return 'M';
        if($asc>=-15165&&$asc<=-14923) return 'N';
        if($asc>=-14922&&$asc<=-14915) return 'O';
        if($asc>=-14914&&$asc<=-14631) return 'P';
        if($asc>=-14630&&$asc<=-14150) return 'Q';
        if($asc>=-14149&&$asc<=-14091) return 'R';
        if($asc>=-14090&&$asc<=-13319) return 'S';
        if($asc>=-13318&&$asc<=-12839) return 'T';
        if($asc>=-12838&&$asc<=-12557) return 'W';
        if($asc>=-12556&&$asc<=-11848) return 'X';
        if($asc>=-11847&&$asc<=-11056) return 'Y';
        if($asc>=-11055&&$asc<=-10247) return 'Z';
        return false;
    }
	
	/**
	 * 获得发送短信的类型
	 *
	 * @param int $typeid 类型 id
	 */
	public static function getSmsType($typeid) {
		$ret = array(
			// 短信登陆
			0 => 'smslogin'
		);
		
		return $ret[$typeid];
	}
}
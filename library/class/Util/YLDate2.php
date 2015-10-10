<?php
/**
 *@author: jiarongping
 *@createtime: 2014-06-23
 *@version: 3.2.0
 *@新增自动追踪月份功能,暂不替换,待测
 **/
class Util_YLDate{
	
	/**
	 *@desc 获取截止时间戳
	 *@param $beginTime : date or time 日期或时间
	 *@param $duration 周期(天数)
	 *@return time
	 **/
	public static function getEndTime($beginTime,$duration)
	{
		
		$beginTime = self::getTimeByDateOrTime($beginTime);

		return $beginTime+($duration*24*3600)-24*3600;
		
	}

	/**
	 *@desc 通过周期获取截止时间戳
	 *@param $beginTime : date or time 日期或时间
	 *@param $duration 周期(天数)
	 *@return time
	 **/
	 public static function getEndTimeByDuration($beginTime,$duration,$type='month')
	 {
		 $type = empty($type)?'month':$type;
		 if($type === 'day')
		 {
			return self::getEndTime($beginTime,$duration);
		 }
		 else
		 {

			$y = (int)self::getDate($beginTime,'Y');
			$m = (int)self::getDate($beginTime,'m');
			$d = (int)self::getDate($beginTime,'d');
			switch($type)
			{
				case 'month':
					return mktime(0,0,0,$m+$duration,$d,$y)-24*3600;
					break;
				case 'year':
					return mktime(0,0,0,$m,$d,$y+$duration)-24*3600;
					break;
			}
		 }
		
	 }


	/**
	 *@desc 获取开始日期时间戳
	 *@param $beginTime : date or time 日期或时间
	 *@return time
	 **/
	public static function getTimeByDateOrTime($datestring)
	{
		if(!preg_match('/^[0-9]*$/',$datestring))
			$datestring = strtotime($datestring);

		$datestring = strtotime(date('Y-m-d',$datestring));
		return $datestring;
	}


	/**
	 *@desc 获取周期数
	 *@param $beginTime： time or date  开始时间戳或开始日期
	 *@param $duration 周期
	 *@param $type 周期类型 {month 月 year年 day 天}
	 *@param $realtime 用户真实投资时间 time or date 时间戳或开始日期
	 *@return array
	 **/
	public static function getTimes($beginTime, $duration, $type, $realtime)
	{
		$startTime = self::getTimeByDateOrTime($beginTime);
		if(!empty($type))
			$endTime = self::getEndTimeByDuration($beginTime,$duration,$type);
		else
			$endTime = self::getTimeByDateOrTime($duration);

		$times = array();
		$i = 0;
		
		$times['endDate'] = self::getDate($endTime);
		if(empty($realtime))
		{
			$times['mindays'] = self::getTowDaysMin($startTime,$endTime);
		}
		else
		{
			$realtime = self::getTimeByDateOrTime($realtime);
			$times['mindays'] = self::getTowDaysMin($realtime,$endTime);
		}
		
		$begind = (int)self::getDate($startTime,'d');
		while($startTime <= $endTime)
		{
			$starty = (int)self::getDate($startTime,'Y');
			$startm = (int)self::getDate($startTime,'m');
			$startd = (int)self::getDate($startTime,'d');
			$times['data'][$i]['startdate'] = self::getDate(self::getTimeByDateOrTime($starty.'-'.$startm.'-'.$startd),'Y-m-d');
			
			//计算月份与年份
			if($startm == 12)
			{
				$starty ++;
				$startm = 1;
			}
			else
			{
				$startm ++;
			}
			
			//计算天数
			$thisday = $startd;
			$days = self::getMonthLastDay($startm,$starty);
			if($days < $begind)
			{
				$thisday = $days;
			}else
			{
				$thisday = $begind;
			}


			if($startm < 10)
				$startm = '0'.$startm;

			
			//当前时间
			$thisTime = self::getTimeByDateOrTime($starty.'-'.$startm.'-'.$thisday);

			//判断当前时间与结束时间关系
			if($thisTime < $endTime)
			{
				$startTime = $thisTime;
				$times['data'][$i]['enddate'] = self::getDate($startTime-(24*3600),'Y-m-d');
			}
			else
			{
				$startTime = $endTime+1;
				$times['data'][$i]['enddate'] = self::getDate($startTime,'Y-m-d');

			}

			if(!empty($realtime))
			{
				$endRealTime = self::getTimeByDateOrTime($times['data'][$i]['enddate']);
				$startRealTime = self::getTimeByDateOrTime($times['data'][$i]['startdate']);
				if($realtime <= $endRealTime && $realtime >= $startRealTime)
				{
					if($i == 0)$times['data'][$i]['startdate'] = self::getDate($realtime,'Y-m-d');
					$times['data'][$i]['days'] = self::getTowDaysMin($realtime, $times['data'][$i]['enddate']);
					$i++;
					continue;
				}
				elseif($realtime > $endRealTime)
				{
					$times['data'][$i]['days'] = 0;
					$i++;
					continue;
				}
			}

			$times['data'][$i]['days'] = self::getTowDaysMin($times['data'][$i]['startdate'], $times['data'][$i]['enddate']);

			$i++;
		}
		
		//总期数
		$times['times'] = $i;

		return $times;
		
	}


	/**
	 *@desc 计算周期数与周期对应利息
	 *@param $beginTime： time or date  开始时间戳或开始日期
	 *@param $duration 周期
	 *@param $apr 利率
	 *@param $money 本金
	 *@param $getType 获取类型(call function)
	 *@param $type 周期类型 {month 月 year年 day 天}
	 *@param $realtime 用户真实投资时间 time or date 时间戳或开始日期
	 *@return array
	 **/
	 public static  function getTimesAndInterest($beginTime, $duration, $apr, $money, $getType='dayAprMonthPay', $type='', $realtime='')
	 {
		 if($apr <= 0 || $money <= 0)
			 return false;

		 $times = self::getTimes($beginTime, $duration, $type, $realtime);
		 //call user function
		 if(method_exists(new Util_YLDate(),$getType))
			$data = self::$getType($times,$apr,$money);
		 else
			 $data = array();

		 return $data;
	 }



	 /**
	  *@desc 通过天数计算利息
	  *@param $days 总天数
	  *@param $apr 利率
	  *@param $money 本金
	  *@param $type 类型 0 排除最后一天的利息 1计算所有天数的利息
	  *@return array
	  **/

	public static function getAprByDays($days, $apr, $money, $type = 1)
	{
		if($days <=0 || $apr <= 0 || $money <= 0)
			 return false;
		
		$data = array();

		 //每天的利率
		 $data['total_days'] = $days;
		 $data['days_apr'] = ($type == 0)?($days-1):$days;
		 $data['apr_day'] = $apr/36500;
		 $total = $data['days_apr'] *  $data['apr_day'] * $money * 100;
		 $total = explode('.',$total);
		 $data['total_interest'] = sprintf('%.2f',$total[0]/100);//结束日期不算钱
		 // $data['total_interest'] = sprintf("%.2f",$data['total_interest']);
		
		return $data;
		
	}


	/**
	 *@desc 按日计息，按月付息，到期还本
	 *@param $times 期数数组
	 *@param $apr 利率
	 *@param $money 本金	
	 *@return array
	 **/
	 public static function dayAprMonthPay($times,$apr,$money)
	 {
	 
		 $data = array('times'=>$times['times'], 'data'=>array(), 'total_interest' => 0,'mindays'=>$times['mindays'],'endDate'=>$times['endDate']);
		 $apr_data = self::getAprByDays($data['mindays'],$apr,$money);
		 //每天的利率
		 $apr_day = $apr_data['apr_day'];
		 //总利息
		 $data['total_interest'] = $apr_data['total_interest'];
		 $count = $times['times'];
		
		 if(is_array($times['data']) && count($times['data'])>0){
			  $i = 1;
			 $total_interest = 0;
		 	 foreach($times['data'] as $k => $v)
			 {
				
				$pay = array();
				
				$pay['times'] = $i;
	
				$pay['days'] = $v['days'];
	
				if($i < $count)
				{
					//该周期的利息（保留两位小数，并四舍五入）
					$pay['pay_apr_money'] = sprintf("%.2f", $apr_day * $v['days'] * $money);
					$pay['pay_date'] = $times['data'][$i]['startdate'];
					$pay['pay_money'] = 0;
				}
				else
				{
					//该周期的利息（保留两位小数）
					$pay['pay_apr_money'] = sprintf('%.2f',$data['total_interest']-$total_interest);
					//$pay['pay_apr_money'] = $pay['pay_apr_money']>0?$pay['pay_apr_money']:0;
					$pay['pay_date'] = $times['data'][$k]['enddate'];
					$pay['pay_money'] = $money;
				}
	
				//期数息和
				$total_interest += $pay['pay_apr_money'];
				//期数数据
				$data['data'][$i] = $pay;
	
				$i++;
			 }
		 }
		 return $data;
	 }


	 /**
	 *@desc 息随本清
	 *@param $times 期数数组
	 *@param $apr 利率
	 *@param $money 本金	
	 *@return array
	 **/
	 public static function aprEndMonthPay($times,$apr,$money)
	 {
	 
		 $data = array('times'=>1, 'data'=>array(), 'total_interest' => 0,'mindays'=>$times['mindays'],'endDate'=>$times['endDate']);
		 $apr_data = self::getAprByDays($data['mindays'],$apr,$money);
		 //每天的利率
		 $apr_day = $apr_data['apr_day'];
		 //总利息
		 $data['total_interest'] = $apr_data['total_interest'];
		 $count = $times['times'];
		
		 if(is_array($times['data']) && count($times['data'])>0){
			$i = 1;
			
			$pay = array();
		
			//该周期的利息（保留两位小数，并四舍五入）
			$pay['pay_apr_money'] = $data['total_interest'];
			$pay['pay_date'] = $times['endDate'];
			$pay['pay_money'] = $money;
			$pay['times'] = 1;
			$pay['days'] = $times['mindays'];
			//期数数据
			$data['data'][$i] = $pay;

		 }
		 return $data;
	 }

	

	/**
	 *@desc 获取两日期相差的天数
	 *@param $firstday 时间戳或日期
	 *@param $secondday 时间戳或日期
	 *@return days 天数
	 **/
	public static function getTowDaysMin($firstday, $secondday)
	{
		$firstTime = self::getTimeByDateOrTime($firstday);
		$endTime = self::getTimeByDateOrTime($secondday);

		$days = ceil(($endTime - $firstTime)/(24*3600))+1;
		return abs($days);//绝对值
	}


	/**
	 *@desc 获取日期
	 *@param $timestring 时间戳或日期
	 *@param $datestyle 时间格式，默认为 Y-m-d
	 *@return date
	 **/
	 public static function getDate($timestring = '', $datestyle = 'Y-m-d')
	 {
		$datestyle = empty($datestyle)?'Y-m-d':$datestyle;
		$timestring = self::getTimeByDateOrTime($timestring);
		$timestring = date($datestyle,$timestring);
		return $timestring;
	 
	 }

	 
	 /**
	 *@desc 获取当前月天数
	 *@param $month 月份
	 *@param $year 年份
	 *@return days 天数
	 **/
	 public static function getMonthLastDay($month,$year)
	 {
		$nextMonth = (($month+1)>12) ? 1 : ($month+1);
		$year      = ($nextMonth>12) ? ($year+1) : $year;
		$lastDay   = date('d',mktime(0,0,0,$nextMonth,0,$year));
		return $lastDay;
	 }  
	
}
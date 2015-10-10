<?php
/**
 *@author: jiarongping
 *@createtime: 2014-03-28
 *@version: 3.1.0
 **/
class Util_Rand{
	
	/**
	 *@desc 获取随机数组
	 *@param $arr : 种子数组
	 *@param $ksort : 是否以键值排序
	 *@return array
	 **/
	public static function getRandArray($arr = array(), $ksort = true)
	{
		if(empty($arr))
			return false;
		
		//统计
		$max_get_num = 0;
		$base_data = array();
		$total = 0;
		foreach($arr as $v)
		{
			if($v['surplus_num'] > $max_get_num)
			{
				$max_get_num = $v['surplus_num'];
				$base_data = $v;
			}

			$total += $v['surplus_num'];
		}

		$max_get_num = $base_data['surplus_num'];

		if(empty($total) || empty($max_get_num))
			return false;
		
		$result = array('total'=>$total,'all_list'=>array(),'data'=>array(),'base_data'=>$base_data);
		foreach($arr as $k=>$v)
		{
			if($v['surplus_num'] < 1 || $v['surplus_num'] >= $max_get_num)
				continue;

			//基数计算
			$nums = $total/$v['surplus_num'];
			
			if($nums < 1)
				continue;
			$nums = explode('.',$nums);
			$nums = (int)$nums[0];
			
			//随机填充
			for($i = 0; $i< $v['surplus_num']; $i++)
			{
				$start = ($i*$nums)+1;
				$end = ($i+1)*$nums;
				
				//寻找空白格
				$key = rand($start,$end);
				$get_val = $result['all_list'][$key];
				while($get_val > 0)
				{
					$key = rand($start,$end);
					$get_val = $result['all_list'][$key];
				}

				$result['all_list'][$key] = $v['id'];
				$result['data'][$v['id']] = $v;
				$result['key'][$v['id']][] = $key;
			}

		}

		if($ksort == true && !empty($result['all_list']))
		{
			ksort($result['all_list']);
		}

		return $result;
		
	}
	
}
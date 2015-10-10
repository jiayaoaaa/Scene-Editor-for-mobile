<?PHP

set_time_limit(0);

define("WORKER_PDO_TEST", 1);   //PDO重新连接
define('ROOT_PATH', __DIR__ . '/../../');
include_once ROOT_PATH . 'config/init.php';

$worker = MQWorker::factory('participants');
$log = $worker->getLog();

$worker->regTask("importParticipants", "importParticipants_cb");
$worker->run();

/**
 * @name 导入参会人名单
 */
function importParticipants_cb($job) {
    global $log;
	$log->log(PHP_EOL . '-----------------------------');
    $arg = $job->workload();
    $invest_info = json_decode($arg, true);
    $log->log('接收参数');
    if (!is_array($invest_info)) {
        $log->log("importParticipants 数据错误 " . json_encode($arg));
        return false;
    }
    $log->log($invest_info);
    $log->log('处理开始');
    $data = getExcelData($invest_info['fileDir']);
	if(is_array($data) && count($data) > 0){
		$log->log('处理成功');
	    foreach($data as $val){
	        $val['fromId'] = -1;
	        $val['activeId'] = $invest_info['activeId'];
	        $val['applyTime'] = time();
            Sp_Account_Attendee::add($val);
	        //Da_Wrapper::insert()->table("sp.huitong.ht_apply_data")->data($val)->execute();
	    }
	    $log->log('插入成功');
	}else{
		$log->log('处理失败');
	}
  	return TRUE;  
}

/*
 * 把excel里面的数据转换成数组
 * return array()
 */
function getExcelData($uploadfile=''){
	global $log;
	$log->log('处理file开始');
	if (is_readable($uploadfile) == false) {
		$log->log('文件不可读');
		return FALSE;
	} 
	$data = array();
    Loader::import(PHPEXCEL_ROOT);
	try{
	    $objReader = PHPExcel_IOFactory::createReader('Excel5');
	    $objReader->setReadDataOnly(TRUE);
	    $objPHPExcel = $objReader->load($uploadfile);
	    $sheet = $objPHPExcel->getSheet(0);
	    $highestRow = $sheet->getHighestRow();
	    $highestColumn = $sheet->getHighestColumn();
	    $fieldAndTitle = getFieldAndTitle();
		$log->log('处理file结束');
	    $fields = array(); 
	    for($j=1;$j<=$highestRow;$j++)                        //从第一行开始读取数据
	    {
	        for($k='A';$k<=$highestColumn;$k++)               //从A列读取数据
	        {
	            $value = $objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue();
	            if($j == 1){
	                $field = array_search($value, $fieldAndTitle);
	                if(false !== $field){
	                    $fields[$k] = $field;
	                }else{
	                    // ("模板有误,请从新生存模板");
	                }
	            }else{
	                $key = $fields[$k];
	                $data[$j][$key]=$value==NUll?'':$value;
	                if($key == 'name'){
	                    $data[$j]['firstChater'] = Sp_Dictionary::getFirstCharter($value);
	                }
	            }
	        }        
	    }
		$log->log('返回数据成功');
	}catch(Exception $e){
		$log->log('处理错误: '.$e->__toString());
    }
	
    return $data;
}

/*
 * 获取用户表单的头部
 * return array('字段名'=>'字段名称')
 */

function getFieldAndTitle() {
    return array(
            'name'      =>'姓名',
            'phone'     =>'电话',
            //'position'  =>'职位'
            'position'  =>'工作',
            'email'=>'邮箱',
            'company'=>'公司名称',
            'address'=>'公司地址',
            'sex'   => '性别'
        );
}

?>

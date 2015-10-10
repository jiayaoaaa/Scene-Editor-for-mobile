<?PHP
/*
 * editor by carten
 */
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';

define('PAGE_SIZE', 5);

$jsonParam = array();
$request = Request::current();
$id = $request->id; 
if(is_numeric($id) && $id > 0){
	// 当前页数
	$nowPage = $request->page;
	empty($nowPage) && ($nowPage = 1);
	$limitRow = ($nowPage - 1) * PAGE_SIZE;
	// 分页数据
	$array = Sp_Active_Active::getListByUser($id, "a.isdel = 0",$limitRow, PAGE_SIZE);
	if(is_array($array) && count($array) > 0){
		foreach ($array as $key => $value) {
			$array[$key]['activit_start'] = !empty($value['activit_start'])?date("Y-m-d H:i",$value['activit_start']):"";
			$array[$key]['activit_end'] = !empty($value['activit_end'])?date("Y-m-d H:i",$value['activit_end']):"";
			
			$array[$key]['enroll_start'] = !empty($value['enroll_start'])?date("Y-m-d H:i",$value['enroll_start']):"";
			$array[$key]['enroll_end'] = !empty($value['enroll_end'])?date("Y-m-d H:i",$value['enroll_end']):"";
			$array[$key]['thumbnail'] = !empty($value['thumbnail'])?SP_URL_UPLOAD.$value['thumbnail']."!w420h336":"http://m.eventool.cn/img/"."nopic.jpg";
			$array[$key]['crttime'] = !empty($value['crttime'])?date("Y-m-d H:i:s",$value['crttime']):"";
		}
	}
	
	
	$jsonParam = array(
	    "code"=>"200",
	    "msg"=>"成功",
	    "data"=>is_array($array) && count($array)>0?$array:array()
	    );
}else{
	$jsonParam = array(
	    "code"=>"400",
	    "msg"=>"缺少参数"
	    );
}

header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);

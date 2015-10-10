<?PHP
/*
 * editor by carten
 */
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';

$headers = array(
    'name'  => '姓名',
    'phone' => '电话'
);

function getShowHeader($data=array()){
    foreach($data as $key=>$value){
        if(0 == $value["isShow"]){
            unset($data[$key]);
        }
    }

    return $data;
}

function check($activeId,$UId){
    if(false == $activeId || false==$UId){
        return false;
    }
    if(false == is_numeric($activeId) || false == is_numeric($UId)){
        return false;
    }
    return true;
}


$jsonParam = array();
$request = Request::current();
$activeId = $request->activeId;
$UId = $request->uid;
$pageSize = $request->pageSize;
$page = $request->page;
if(check($activeId,$UId)){
    $model = new Sp_Account_Attendee($UId);
    if(false == $model){
        $jsonParam = array(
            "code"=>"201",
            "msg"=>"请求参数错误"
        );
    }else{
        $dataProvide = $model->getAttendeeListForApi($activeId,$pageSize,$page);
        $jsonParam = array(
            "code"=>"200",
            "msg"=>"",
            "count"=>$dataProvide[0],
            "data"=>$dataProvide[1]
        );
    }
}else{
    $jsonParam = array(
        "code"=>"201",
        "msg"=>"请求参数错误"
    );
}
header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);

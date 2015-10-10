<?PHP
/*
 * editor by carten
 */
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';

$request = Request::current();
$activeId = $request->active_id;
if(is_numeric($activeId)){
    $where['activeId'] = $activeId;
    $unSign = Da_Wrapper::select()->table("sp.huitong.ht_apply_data")->where($where)->where("status = 0")->getTotal();
    $signed = Da_Wrapper::select()->table("sp.huitong.ht_apply_data")->where($where)->where("status = 1")->getTotal();
    $jsonParam = array(
        "code"=>"204",
        "msg"=>"查询成功",
        "signed"=>$signed,
        "unsign" =>$unSign
    );
}else{
    $jsonParam = array(
        "code"=>"206",
        "msg"=>"参数错误",
        "signed"=>0,
        "unsign" =>0
    );
}

header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);






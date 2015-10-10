<?PHP
/*
 * editor by carten
 */
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';

$request = Request::current();
$signNo = $request->signNo;
$activeId = $request->active_Id;
file_put_contents("/sproot/logs/1111_sign_line.txt", "signNo:".$signNo.",activeId:".$activeId);
$patternMobile = Sp_Dictionary::getOtherOption("patternMobile");
if(preg_match($patternMobile,$signNo)){
    $where = array("phone"=>$signNo,"activeId"=>$activeId);
}else{
    $where = array("signId"=>$signNo);
}


$signId = Da_Wrapper::select()->table("sp.huitong.ht_apply_data")->columns('Id,status')->where($where)->getRow();

if(!$signId['Id']){
    $jsonParam = array(
        "code"=>"204",
        "msg"=>"签到码不存在"
    );
}else{
    if(1 == $signId['status']){
        $jsonParam = array(
            "code"=>"205",
            "msg"=>"签到码已使用"
        );
    }else if( -1 == $signId['status'] ){
        $jsonParam = array(
            "code"=>"206",
            "msg"=>"签到码无效"
        );
    }else if( 0 == $signId['status']){
        $model = new Sp_Account_Attendee;
        if($model->signAndDelete(array($signId["Id"]),1)){
            $jsonParam = array(
                "code"=>"200",
                "msg"=>"恭喜您,签到成功"
            );
        }
    }
}

header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);






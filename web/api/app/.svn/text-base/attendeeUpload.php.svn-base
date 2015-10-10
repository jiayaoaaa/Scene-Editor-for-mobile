<?PHP
/*
 * editor by carten
 */
define('ROOT_PATH', __DIR__ . '/../../../');
include_once ROOT_PATH . 'config/init.php';


//file_put_contents('1111.txt', $_POST);

$request = Request::current();
$data = $request->data;
file_put_contents("/sproot/logs/1111.txt", $data);
$dataArr = json_decode($data);
$model = new Sp_Account_Attendee;
$i = 0;
foreach($dataArr as $value){
    $signIn[$i] = intval($value['id']);    
    $i++;
}
$model->signAndDelete($signIn,1);
$jsonParam = array(
    "code"=>"200",
    "msg"=>"上传成功"
);
header('Content-type: application/json;charset=utf-8');
echo json_encode($jsonParam);






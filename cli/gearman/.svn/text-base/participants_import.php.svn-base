<?php
define("WORKER_PDO_TEST",1);
/*
 * author zhaoyu
 * date 2015/04/10
 * 响应worker
 */
define('ROOT_PATH', __DIR__.'/../../');
include_once ROOT_PATH.'config/init.php';


$client_active = MQClient::factory('participants');
$client_active->send('importParticipants',array("uid"=>10086));

?>
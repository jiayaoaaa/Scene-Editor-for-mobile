<?php
/**
 $ext_arr = array(
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
 */
class Util_Upyun {

private $save_path;

private $save_url;

private $dir;

private $allowtype = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

private $max_size = 5120000; //5M

public function __construct($args=array()) {
        foreach($args as $key => $value) {
            $key = strtolower($key);
            //查看用户参数中数组的下标是否和成员属性名相同
        //if(!in_array( $key, get_class_vars(get_class($this)) )) {
        //    continue;
        //}
        
        $this->setArgs($key, $value);
    }
}

private function setArgs($key, $value) {
    $this->$key = $value;
}

public function uploadFile($filename='file'){
	//PHP上传失败
	if (!empty($_FILES[$filename]['error'])) {
		switch($_FILES[$filename]['error']){
			case '1':
				$error = '超过php.ini允许的大小。';
				break;
			case '2':
				$error = '超过表单允许的大小。';
				break;
			case '3':
				$error = '图片只有部分被上传。';
				break;
			case '4':
				$error = '请选择图片。';
				break;
			case '6':
				$error = '找不到临时目录。';
				break;
			case '7':
				$error = '写文件到硬盘出错。';
				break;
			case '8':
				$error = 'File upload stopped by extension。';
				break;
			case '999':
			default:
				$error = '未知错误。';
		}
		return  array('error' => -1, 'msg'=>$error);;
	}
	
	//有上传文件时
	if (empty($_FILES) === false) {
		//原文件名
		$file_name = $_FILES[$filename]['name'];
		//服务器上临时文件名
		$tmp_name = $_FILES[$filename]['tmp_name'];
		//文件大小
		$file_size = $_FILES[$filename]['size'];
		
		//创建文件夹
		$ymd = date("Y/m/d/");
		$this->save_path .= $ymd;
		if (!file_exists($this->save_path)) {
			mkdir($this->save_path,0777,TRUE);
		}
		
		//检查文件名
		if (!$file_name) {
			return array('error' => -1, 'msg'=>"请选择文件。");
		}
		//检查目录
		if (@is_dir($this->save_path) === false) {
			return array('error' => -1, 'msg'=>"上传目录不存在。");
		}
		//检查目录写权限
		if (@is_writable($this->save_path) === false) {
			return array('error' => -1, 'msg'=>"上传目录没有写权限。");
		}
		//检查是否已上传
		if (@is_uploaded_file($tmp_name) === false) {
			return array('error' => -1, 'msg'=>"上传失败。");
		}
		
		//检查文件大小
		if ($file_size > $this->max_size) {
			return array('error' => -1, 'msg'=>"上传文件大小超过限制。");
		}
		
		//获得文件扩展名
		$temp_arr = explode(".", $file_name);
		$file_ext = array_pop($temp_arr);
		$file_ext = trim($file_ext);
		$file_ext = strtolower($file_ext);
		//检查扩展名
		if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
			array('error' => -1, 'msg'=>"上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
		}

		
		//新文件名
		$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
		//移动文件
		$file_path = $this->save_path . $new_file_name;
		
		$datas = fopen($tmp_name,'r'); 
		fseek($datas, 0, SEEK_END);
		$file_length = ftell($datas);//print $file_length;exit;
		fseek($datas, 0);
		
	
		if (@move_uploaded_file($tmp_name, $file_path) == false) {
			return array('error' => -1, 'msg'=>"1111");
		}
		@chmod($file_path, 0644);
		$file_url = $this->save_url .$ymd. $new_file_name;
	
		
		$bucket = '/eventdb';
	 	// demobucket为空间名
		$uri = '/eventdb/'.$file_url;//print $uri;exit;
		$process = curl_init('http://v0.api.upyun.com'.$uri);
		// 取得世界时间。得到的日期格式如：Thu, 11 Jul 2013 05:34:12 GMT
		$date = gmdate('D, d M Y H:i:s \G\M\T');
		// 本地待上传的文件
		$local_file_path = $file_path;
	
		$datas = fopen($local_file_path,'r'); 
		fseek($datas, 0, SEEK_END);
		$file_length = ftell($datas);//print $file_length;exit;
		fseek($datas, 0);
		if($datas === false){
			return array('error' => -1, 'msg'=>"获取文件失败。");
		}
		// 计算签名
		// 1. "PUT"：当前发起的是 PUT 请求（POST 请求时以"POST"进行签名）
		// 2. $uri：请求路径
		// 3. $file_length：PUT 请求（或 POST）的文件内容长度
		// 4. "demopass"：操作员密码
		$sign = md5("PUT&{$uri}&{$date}&{$file_length}&".md5("zhangdongdong"));
		
	
		// 发起 PUT 上传请求
		curl_setopt($process, CURLOPT_PUT, 1);
	
		// 设置待上传的内容
		curl_setopt($process, CURLOPT_INFILE, $datas);
	
		// 设置待上传的长度
		curl_setopt($process, CURLOPT_INFILESIZE, $file_length);
	
		// 设置表头参数：demouser为操作员名称
		curl_setopt($process, CURLOPT_HTTPHEADER, array(
			"Expect:", 
			"Date: ".$date, // header 传递的时间需要与签名时的时间保持一致
			"mkdir: true",
			"Authorization: UpYun zhangdongdong:".$sign
		));
		
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_TIMEOUT, 60);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	
		$a = curl_exec($process);
		$code = curl_getinfo($process, CURLINFO_HTTP_CODE);
		curl_close($process);
		
		if($code == 200){
			return array('error' => 0, 'msg'=>'上传成功','data' => $file_url);
		}
		else{
			return array('error' => -1, 'msg'=>'上传失败');
		}
		
	}
	
}



}
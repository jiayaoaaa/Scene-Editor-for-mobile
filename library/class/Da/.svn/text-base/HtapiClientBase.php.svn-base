<?php 
class Da_HtapiClientBase{
	
	protected  $info_url = "";
        
        private static $debug = false;
	
	public function __construct(){
		 //$this->info_url = "http://local.pay.eventown.com.cn:81/?ct=index";
        $this->info_url = "http://local.pay.eventown.com.cn:81/?ct=index";
        //$this->info_url = "http://123.125.211.35/?ct=index";        
	} 

	public function sendRequest($arr, $post = false) {
            ksort($arr);
            $str = $this->getParam($arr);
            $url = $this->getInfoURL($str);
            $this->url = $url;
            $re = $this->achieve($url, $post === false ? false : $post);
            $re = json_decode($re, true);
            if ($re["errno"] < 0) {
                return $re['describe'];
            }
            return $re['data'];
        }

        protected function achieve($url, $data = false) {
            //echo $url;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            if ($data !== false) {
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            $re = curl_exec($curl);
            if($_GET['op']==1){
              echo "<br/><br/><br/>";echo $url;echo "<br/>";var_dump($re);
            }
            if (curl_errno($curl)) {
                exit("-102");
            }
            $h = explode("\r\n", $re);
            if (self::$debug === true) {
                foreach ($h as $v) {
                    if (substr($v, 0, 7) == "console") {
                        $this->msg = substr($v, 8);
                    }
                }
            }
            $re = array_pop($h);
            curl_close($curl);
            return $re;
        }

        public function getInfoURL($param = "") {
            return $this->info_url . $param;
        }

        public function getParam($array) {
            if (is_array($array) && count($array) > 0) {
                foreach ($array as $key => $value) {
                    $str .= "&" . $key . "=" . $value;
                }
                return $str;
            }
            return;
        }

        public function debug() {
            echo $this->msg;
        }

        public function __call($fun, $value) {
            exit("the function $fun not found");
        }

}

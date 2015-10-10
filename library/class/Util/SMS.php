<?php

defined('LIB_ROOT') or define('LIB_ROOT', dirname(__FILE__) . '/../../');

class Util_SMS{
    
    private $mobile;
            
    private $content;
    
    private $type;
    
    private $key;
    
    private $secret;
    
    public function __construct($key,$secret,$type){
        if(strlen($key)<1 || strlen($secret)<1){
            return false;
        }
        $this->key = $key;
        $this->secret = $secret;
        $this->type = $type;
    }
    
    public function setMobile($mobile){
        $this->mobile = $mobile;
    }
    
    public function setContent($content){
        $this->content = $content;
    }
    
    public function send(){
        $re = $this->formateDate();
        $signature = $this->buildSignature($re);
        $arr['signature'] = $signature;
        $arr['key'] = $this->key;
        $arr['type'] = $this->type;
        $arr['mobile'] = $this->mobile;
        $arr['content'] = $this->content;
	
        return $this->m_post(SMS_URL, $arr);
    }
    
    private function buildSignature($data){
        $this->verify();
        return md5(md5($this->key.$this->secret).$data);
    }
    
    private function formateDate(){
        $arr['key'] = $this->key;
        $arr['type'] = $this->type;
        $arr['mobile'] = $this->mobile;
        $arr['content'] = $this->content;
        ksort($arr);
        $str = "";
        foreach($arr as $k=>$v){
            $str .= $k.'='.$v.'&';
        }
        return substr($str,0,-1);
    }
    
    private function verify(){
        if(strstr($this->mobile,",")){
            $arr = explode(',', $this->mobile);
            foreach($arr as $v){
                if(!$this->verifyMobile($v)){
                    throw new Exception('手机号不合法');
                }
            }
        }else{
            if(!$this->verifyMobile($this->mobile)){
                throw new Exception('手机号不合法');
            }
        }
    }
    
    private function verifyMobile($mobile){
        if(is_numeric($mobile) && strlen($mobile) == 11 && substr($mobile,0,1)==1){
            return true;
        }
        return false;
    }
    
    private function m_post($url,$data,$timeout=30){
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_USERAGENT, "eventown");
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
	    curl_setopt($curl, CURLOPT_POST, 1);
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
	    curl_setopt($curl, CURLOPT_HEADER, 0);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    $tmpInfo = curl_exec($curl);
	    if (curl_errno($curl)) {
	       echo 'Errno'.curl_error($curl);exit;
	    }
	    curl_close($curl);
	    return json_decode($tmpInfo,true);
	}
    
}


<?php
// $Id$
/*
* 过滤不符合的词语
*/


class Util_Badwords
{
	var $bwl;	//黑词数组
	var $mem; 	//memcache对象
	
	//构造函数
	function __construct(){
		$this->mem = Cache_Memcache::getInstance();
		$this->mem->init();
		if(( $this->bwl = $this->mem->get("BlackWordList")) == false){ 
			$this->getBlackWordListFromDB();
		}
	}
	
	/**
	 * function getblacklist from db
	 * 
	 * @param
	 * @return void
	 */
	public function getBlackWordListFromDB(){
		$sql = " SELECT find "
			." FROM bbs_words ";
		$dbw = Sw_Db_Wrapper::getInstance();
		$data = $dbw->getFlatCached("club", $sql, 10 * 10,"BlackWordList");
		if (count($data) > 0){
			$this->mem->set("BlackWordList", $data, 1800);
			$this->bwl = $data;
		}
	}

	/**
	 * function check the word is have black list
	 * 
	 * @param
	 * @return boolean
	 */
	 function check($word){
	 	$count = count($this->bwl);
		for($i = 0;$i < $count;$i++){
			if( strpos($word, $this->bwl[$i]) !== FALSE) return true;
		}
		return false;
	}

	/**
	 * function replace word
	 * 
	 * @param
	 * @return void
	 */
	 function replace(&$word, $replace_str = '***')
	{
		$word = str_replace($this->bwl, $replace_str, $word);
		return $word;
	}
}

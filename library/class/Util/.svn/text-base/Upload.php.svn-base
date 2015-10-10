<?php
/**
 * FileUpload
 * @Description 多文件上传类
 *
 * Time: 2013-11-04
 *		include "FileUpload.class.php";
 *      $up=new FileUpload(array('savepath'=>'./mytest/'));
 *      $up->uploadFile('userfile');  //userfile 为input框的name值 多文件时input 的name值要有中括号: name="userfile[]" 没有中括号只能上传第一个文件
 *      echo $up->getErrorMsg();  //得到错误信息
 * 		
 * 基本功能有 都以参数形式传入构造函数
 * 		指定上传文件格式 [array] allowtype 
 * 		指定文件大小     [int] maxsize
 * 		
 * 实例1 上传头像到指定目录 并以随即名保存 文件名长度为20(默认为20)
 * 		$up = new FileUpload(array('savepath'=>'./avatar/', 'israndname'=>true, 'newfilenamelength'=>20));
 * 实例2 上传头像到指定目录 并且用用户id作为文件名 如上传 photo.png 保存为 2.png
 * 		$up = new FileUpload(array('savepath'=>'./avatar/', 'israndname'=>false, 'givenfilename'=>2));
 * 实例3 上传头像到指定目录 在目录下以日期为单位建立子目录保存头像
 * 		$up = new FileUpload(array('savepath'=>'./avatar/', 'subdirpattern'=>'Y/m' , 'israndname'=>false, 'givenfilename'=>2));
 * 		以上生成目录为 './avatar/2013/10'
 */
class Util_Upload {
    private $name = 'name';
    private $type = 'type';
    private $tmp_name = 'tmp_name';
    private $error = 'error';
    private $size = 'size';

	// 构造方法用到的字段
    private $savepath = '';  //指定上传文件保存的路径
	private $subdirpattern = '';  // 结合savepath使用 为空表示不添加子目录,不为空 比如 'Y/m' 表示 2011/01 那么保存路径就是 $savepath  . '/2011/01'
    private $allowtype = array('gif', 'jpg', 'png');
    private $maxsize = 2048000; //Byte 2000K
    private $israndname = true;  //是否随机重命名 true false不随机 使用原文件名
	private $givenfilename = '';  //使用给定的文件名 配合 israndname 使用
	private $ignoreemptyfile = true;  //是否忽略没有上传文件的文本域
	private $newfilenamelength = 20;
	
	// 本类用到的字段
    private $errorMessage = '';
    private $uploadFileArray = null;
    private $originalFileName = '';
    private $expandedName = '';
	public $newFileName = '';  // 保存单个文件名
	public $resFileNameArr = array();  // 保存所上传的全部文件名
	
    
    //1. 指定上传路径， 2，充许的类型， 3，限制大小， 4，是否使用随机文件名称
    //new FileUpload( array('savepath'=>'./uploads/', 'allowtype'=>array('txt','gif'), 'israndname'=>true) );
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
	
	/**
	 * 得到文件大小
	 * @param int size 字节数
	 */
	private function getFileSize($size) {
	    $unit = 'Bytes';
	    if($size < 1024) {
	    	return $size.$unit;
	    } else if($size < pow(1024, 2)) {
			$unit = 'KB';
			$size = round($size / 1024, 2);
	    } else if($size < pow(1024, 3)) {
			$unit = 'MB';
			$size = round($size / pow(1024, 2), 2);
	    } else if($size < pow(1024, 4)) {
			$unit = 'GB';
			$size = round($size / pow(1024, 3), 2);
	    } else {
	    	$unit = 'TB';
	    	$size = round($size / pow(1024, 4), 2);
	    }
		
		return $size.$unit;
	}
    
    /**
     * 得到一个数组的键组成的数组
     */
    private function myArray_keys(& $arr) {
        $returnArr = array();
        foreach($arr as $key => $val) {
            $returnArr[] = $key;
        }
		
        return $returnArr;
    }
    
    /**
     * 重新排列上传文件
     * $uploadFileArray 上传的文件的数组
     */
    private function reSortFile(& $uploadFileArray) {
		// input name没有[] 时是字符串
		// 有[] 时是数组
		$multiFlag = is_array($uploadFileArray[$this->name]) ? true : false;
        $file_arr = array();
		
        $file_num = $multiFlag ? count($uploadFileArray[$this->name]) : 1;  //计算上传的文件数
        $file_keys = $this->myArray_keys($uploadFileArray);  //得到数组,包含了name type error tmp_name size
        
        for($i=0; $i<$file_num; $i++) {
            foreach($file_keys as $value) {
                $file_arr[$i][$value] = $multiFlag ? $uploadFileArray[$value][$i] : $uploadFileArray[$value];
            }
        }
		
        return $file_arr;
    }
    
    /**
     * 错误报告 
     * $errorno 错误号
     */
    private function setErrorMsg($errorno){
        $msg = "上传文件<font color='red'>&nbsp;{$this->originalFileName}&nbsp;</font>时出错:&nbsp;";
        switch($errorno){
            case 1:
            case 2:
                $msg .= '文件过大,无法上传';  //配置文件中的大小
            case 3:
                $msg .= '文件只被部分上传'; break;
            case -1:
                $msg .= '不充许的文件类型'; break;
            case -2:
                $msg .= '文件过大,上传文件不能超过'.$this->getFileSize($this->maxsize); break;
            case -3: 
                $msg .= '上传失败'; break;
            case -4:
                $msg .= '建立存放上传文件目录失败,请重新指定上传目录'; break;
            case -5:
                $msg .= '必须指定上传文件的路径'; break;
            case -6:
                $msg .= '不是上传的文件'; break;
            default: $msg .=  "未知错误";
        }
        return $msg.'<br>';
    }
    
    /**
     * 检查有没有指定上传路径
     */
    private function emptySavePath() {
        if(empty($this->savepath)) {
            $this->errorMessage .= $this->setErrorMsg(-5);
            return true;
        }
        return false;
    }
    
    /**
     * 得到扩展名
     * $fileName 文件名
     */
    private function getExpandedName() {
        $pos = strrpos($this->originalFileName, '.');
        return substr($this->originalFileName, $pos+1);
    }
    
    /**
     * 检查文件扩展名是够合法
     */
    private function isLegalExpandedName() {
        if(in_array($this->expandedName, $this->allowtype)) {
            return true;
        }
        $this->errorMessage .= $this->setErrorMsg(-1);
		
        return false;
    }
    
    /**
     * 检查上传的文件有没有错误
     * $i 第几个文件
     */
    private function hasError($i) {
        $errorno = $this->uploadFileArray[$i][$this->error];
        if(0 == $errorno) {
            return 0; //文件正常
        } else if(4 == $errorno) {
            return 4;  //没有上传文件
        }
        $this->errorMessage .= $this->setErrorMsg($errorno);
		
        return 99;  //文件有错误
    }
    
    /**
     * 检查文件大小
     * $i 第几个文件
     */
    private function isLegalSize($i) {
        $fileSize = $this->uploadFileArray[$i][$this->size];
        if($fileSize <= $this->maxsize) {
            return true;
        }
        $this->errorMessage .= $this->setErrorMsg(-2);
        return false;
    }
    
    /**
     * 检查所给出的文件是否是通过HTTP POST上传的
     * $i 第几个文件
     */
    private function isUploadedFile($i) {
        $tmpName = $this->uploadFileArray[$i][$this->tmp_name];
        if(is_uploaded_file($tmpName)) {
            return true;
        }
        $this->errorMessage .= $this->setErrorMsg(-6);
        return false;
    }
    
    /**
     * 得到新文件名(如果用户指定不用新文件名则使用旧文件名)
     *
     */
    private function initNewFileName() {
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$chars = $this->originalFileName;  // 有后缀 .jpg
        if($this->israndname) {
			$chars = '';
            for($i=0; $i<$this->newfilenamelength-14; $i++) {
				$chars .= substr($str, mt_rand(0, strlen($str)-1), 1);
			}
			$chars .= date('YmdHis', time());
			$chars = $chars . '.' . $this->expandedName;
        } else {
			// 给定了使用指定的名字
			if('' != $this->givenfilename) {
				$chars = $this->givenfilename . '.' . $this->expandedName;
			}
		}
       
		return $chars;
    }
	
    /**
     * 复制文件到指定地方
     * $i 第几个文件
     */
    private function copyFile($i) {
        $this->newFileName = $this->initNewFileName();
		$this->resFileNameArr[] = $this->newFileName;  // 保存文件名
        
		if(is_dir($this->savepath)) {
			@move_uploaded_file($this->uploadFileArray[$i][$this->tmp_name], $this->savepath.$this->newFileName);
        } else {
			die('上传目录创建失败');
		}
    }
	
	/**
	 * 检查是否有空文件
	 */
	private function chkEmptyFile(& $arr) {
		$flag = 1;
		for($i = 0; $i < count($arr); $i++) {
			if(intval($arr[$i][$this->error]) == 4) {
				$flag = 4;
				break;
			}
		}
		
		return $flag;
	}
	
	/**
	 * 初始化上传文件夹
	 */
	private function initSavePath() {
		$this->savepath = rtrim($this->savepath, '/') . '/';
		!empty($this->subdirpattern) && $this->savepath = $this->savepath . date($this->subdirpattern, time()) . '/';
		
		$tmpSavePath = rtrim($this->savepath, '/');
		if(!is_dir($tmpSavePath)) {
			mkdir($this->savepath,0777,TRUE);
			chmod($this->savepath, 0777);
		}
	}
    
    /**
     * 开始上传文件方法
     */
    private function startUpload() {
        for($i=0; $i<count($this->uploadFileArray); $i++) {
            if(0 === $this->hasError($i)) {
                $this->originalFileName = $this->uploadFileArray[$i][$this->name];  // aa.jpg
                $this->expandedName = $this->getExpandedName();
                if($this->isLegalExpandedName()) {
                    if($this->isLegalSize($i)) {
                        //if($this->isUploadedFile($i)) {
                            $this->copyFile($i);
                        //}
                    }
                }
            }
        }
    }
    
    /**
     * 上传文件 入口
     * $fileField input框的name属性值
     */
    public function uploadFile($fileField) {
        //检查上传路径
        if(true === $this->emptySavePath()) {
            return false;
        }
		
        if(0 !== count($_FILES)) {
            //重新排列上传文件
            $this->uploadFileArray = $this->reSortFile($_FILES[$fileField]);
            
			//开始上传文件
			if( !$this->ignoreemptyfile && 4 == $this->chkEmptyFile($this->uploadFileArray) ) {
				die('强制全部上传模式');
				
			} else {
				$this->initSavePath();  // 初始化上传路径
				$this->startUpload();
			}
        }
    }
     
    /**
     * de到错误信息 
     */     
    public function getErrorMsg() {
        return $this->errorMessage;
    }
	
	// 得到上传的文件
	public function getUploadFileName() {
		foreach($this->resFileNameArr as $key=>$val) {
			$this->resFileNameArr[$key] = $this->savepath . $this->resFileNameArr[$key];
		}
		if(1 == count($this->resFileNameArr)) {
			return $this->resFileNameArr[0];
		}
		
		return $this->resFileNameArr;
	}
}
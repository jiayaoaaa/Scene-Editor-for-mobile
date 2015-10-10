<?php  
define('ROOT_PATH', __DIR__.'/../../');
include_once ROOT_PATH.'config/init.php';
 
class Test extends PHPUnit_Framework_TestCase  
{
	// /**
	 // * 测试异常
	 // */
	// public function testException(){
		// try{
// 			
            // new ErrorException('aaaa');
//             
		// }catch(InvalidArgumentException $e){
			// return;
		// }
		// //$this->fail('Exception not run!');
	// }

	/** 
	* @test 
	*/    
    public function testNewArrayIsEmpty()  
    {  
        // 创建数组fixture。  
        $fixture = array();  
   		
        // 断言数组fixture的尺寸是0。  
        $this->assertEquals(0, sizeof($fixture));  
    }
	public function testLogin(){
		
	}  
    
    /** 
    * @test 
    */    
    public function testNewArrayIsNotEmpty()  
    {  
        // 创建数组fixture。  
        $fixture = array();  
        $fixture[] = 11;
        // 断言数组fixture的尺寸是0。  
        $this->assertEquals(0, sizeof($fixture));  
    } 
}  
?>  
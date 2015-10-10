<?PHP
/**
 * editor by carten 2015/8/6
 */
class Attendee_Export extends Sp_Account_Action_Abstract
{
    protected $condition = array();
	
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
        //echo "导出参会人";
        $this->getTemplate();
        exit;
        if ($request->format == 'json') {
        	$arrary = array();
			return $array;
        } else {
			$view = new Sp_View;
            $view->display("active/index.html");
        }

    }
    /*
     * 按照表单设置,生存"参会人导入"模板
     */
    public function getTemplate(){
		try{
		
        Loader::import(PHPEXCEL_ROOT);
        $resultPHPExcel = new PHPExcel;
        $fieldAndTitle = $this->getFieldAndTitle();
        
        $n = 65;
        foreach($fieldAndTitle as $val){
            $coloum = chr($n).'1';
            $resultPHPExcel->getActiveSheet()->setCellValue($coloum, $val);
            $n++;
        }
        $outputFileName = 'apply_data.xls'; 
        $xlsWriter =  PHPExcel_IOFactory::createWriter($resultPHPExcel, 'Excel5');
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary"); 
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
        header("Pragma: no-cache"); 
        $xlsWriter->save( "php://output" );
		}catch(Exception $e){
         echo $e->__toString();
        }
    }
    
    /*
     * 获取用户表单的头部
     * return array('字段名'=>'字段名称')
     */
    public function getFieldAndTitle(){
        return array(
            'name'      =>'姓名',
            'phone'     =>'电话',
            //'position'  =>'职位'
            'position'  =>'职位',
            'email'=>'邮箱',
            'company'=>'公司名称',
            'address'=>'公司地址',
            'sex'   => '性别'
        );
    }

    

}
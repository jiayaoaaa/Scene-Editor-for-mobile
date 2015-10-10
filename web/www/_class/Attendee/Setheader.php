<?PHP
/**
 * editor by carten 2015/8/12
 */
class Attendee_Setheader extends Sp_Account_Action_Abstract
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
        if ($request->format == 'json') {
            $activeId = $_POST['activeId'];
            unset($_POST['activeId']);
            $data = $this->dataFormat($_POST,$activeId);
            $model = new Sp_Account_Attendee;
            if($model->setTableHeader($data)){
                $return = array('status'=>1,'msg'=>'表头设置成功');
            }else{
                $return = array('status'=>0,'msg'=>'表头设置失败');
            }
			return $return;
        } else {
			$view = new Sp_View;
            $view->display("active/index.html");
        }

    }
    /*
     * 格式化数据
     * @data    二维数组
     * return   data    二维数组
     */
    public function dataFormat($data=array(),$activeId=''){
        if(false == $data || $activeId == false){
            echo "参数错误";
            return false;
        }
        $arr = array(
            'name'      =>array('title'=>'姓名','field'=>'name'),
            'phone'     =>array('title'=>'电话','field'=>'phone'),
            'email'     =>array('title'=>'邮箱','field'=>'email'),
            'position'  =>array('title'=>'职位','field'=>'position'),
            'company'   =>array('title'=>'公司名称','field'=>'company'),
            'address'   =>array('title'=>'公司地址','field'=>'address'),
            'sex'       =>array('title'=>'性别','field'=>'sex'),
        );
        $i=0;
        foreach($data as $key=>$value){
            $value['activeId'] = $activeId;
            $return[$i] = array_merge($value, $arr[$key]);
            $i++;
        }
        return $return;
        
    }

}
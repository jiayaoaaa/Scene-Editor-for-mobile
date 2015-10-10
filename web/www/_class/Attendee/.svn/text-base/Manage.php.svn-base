<?PHP
/**
 * editor by carten 2015/8/12
 */
class Attendee_Manage extends Sp_Account_Action_Abstract
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
            $action = $request->action;
            if($action == 'add'){
                return $this->addAttendee();
            }else if($action == 'signIn'){
                return $this->signIn($_POST['dataId']);
            }else if($action == 'signOut'){
                return $this->signOut($_POST['dataId']);
            }else if($action == 'delete'){
                return $this->attendeeDelete($_POST['dataId']);
            }
        } else {
			$view = new Sp_View;
            $view->display("active/index.html");
        }

    }
    /*
     * 添加参会人
     */
    public function addAttendee(){
        $data = $_POST;
        unset($data['action']);
        $flag = true;
        if(false == $data['name']){
            $flag = false;
        }else if(false == preg_match(Sp_Dictionary::getOtherOption('patternMobile'), $data['phone'])){
            $flag = false;
        }else if($data['email']){
            if(false == preg_match(Sp_Dictionary::getOtherOption('patternEmail'), $data['email'])){
                $flag = false;
            }
        }
        if(false == $flag){
            return array('status'=>0,'msg'=>'数据有误请从新填写');
        }else{
            $data['firstChater'] = Sp_Dictionary::getFirstCharter($data['name']);
            $data['fromId'] = -1;
            $data['applyTime'] = time();
            $return = Sp_Account_Attendee::add($data);
            if($return == -2){
                return array('status'=>-2,'msg'=>'此人已经存在');
            }else if(-3 == $return){
                return array('status'=>-3,'msg'=>'此人已经签到');
            }else if(-4 == $return ){
                return array('status'=>-4,'msg'=>'添加失败');
            }else if($return){
                return array('status'=>1,'msg'=>'添加成功');
            }
            return array('status'=>0,'msg'=>'数据有误请从新填写');
        }
    }
    /*
     * 签到
     */
    public function signIn($data){
        if(!is_array($data)){
            $data = explode(",", $data);
        }
        $Model = new Sp_Account_Attendee;
        $return = $Model->signAndDelete($data,1);
        if($return){
            return array("status"=>1,"msg"=>"设置成功");
        }
        return array("status"=>0,"msg"=>"设置失败");
    }
    
    /*
     * 未签到
     */
    public function signOut($data){
        if(!is_array($data)){
            $data = explode(",", $data);
        }
        $Model = new Sp_Account_Attendee;
        $return = $Model->signAndDelete($data,0);
        if($return){
            return array("status"=>1,"msg"=>"设置成功");
        }
        return array("status"=>0,"msg"=>"设置失败");
    }
    
    /*
     * 逻辑删除
     */
    public function attendeeDelete($data){
        if(!is_array($data)){
            $data = explode(",", $data);
        }
        $Model = new Sp_Account_Attendee;
        $return = $Model->signAndDelete($data,-1);
        if($return){
            return array("status"=>1,"msg"=>"删除成功");
        }
        return array("status"=>0,"msg"=>"删除失败");
    }
    
    

    

    

}
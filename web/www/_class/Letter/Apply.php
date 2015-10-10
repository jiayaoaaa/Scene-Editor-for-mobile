<?PHP
/**
 * 邀请函页面
 */
class Letter_Apply extends Sp_Web_Action_Abstract
{
    /**
     * function description
     *
     * @param
     * @return void
     */
    public function execute($request)
    {
//        $letterId = 31;
//        $data = array("name"=>"wu","phone"=>"18612848103","email"=>"864775622@qq.com");
        if ($request->format == 'json') {
            $letterId = $request->letterId;
            $data = $_POST['data'];
            return $this->apply($letterId,$data);
        } 

    }
    /*
     * 收集参会人信息
     * @letterId    邀请函ID
     * @data        json数据    
     */
    public function apply($letterId='',$data=''){
        $data['fromId'] = $letterId;
        if(false == $letterId){
            return array("status"=>-1,"msg"=>"数据有误");
        }else if(false == $data){
            return array("status"=>-2,"msg"=>"数据有误");
        }
        $element = $this->getLimitByLetterId($letterId);
        $return = $this->check($letterId,$data,$element);
        $data['checkStatus'] = $element['is_audit'] != 1 ? 1:0;
        $data['activeId'] = $element['id'] ? $element['id']:0;
        if(true === $return){
            //add data
            if($this->insert($data)){
                return array("status"=>0,"msg"=>"报名成功");
            }
            return array("status"=>-11,"msg"=>"报名失败,请不要重复报名");
        }else{
            return $return;
        }
    }
    /*
     * 信息验证
     * 成功返回0,失败返回-1
     * $letterId    邀请函ID    int
     * $data        数据        array
     * $element     判断的因子  array
     */
    public function check($letterId='',$data=array(),$element=array()){
        $time = time();
        if(false == $element['id']){
            return array("status"=>-3,"msg"=>"数据有误");
        }else if($element['is_enroll'] != 1){
            return array("status"=>-4,"msg"=>"此活动不需要报名");
        }else if($element['isdel'] == 1){
            return array("status"=>-5,"msg"=>"此活动已经删除");
        }else if($time < $element['enroll_start']){
            return array("status"=>-6,"msg"=>"报名未开始");
        }else if($time > $element['enroll_end']){
            return array("status"=>-7,"msg"=>"报名已经结束");
        }
        $num = $this->getCurrentNum($element['id']);
        if(false != $element['enroll_num'] && $num >= $element['enroll_num']){
            return array("status"=>-8,"msg"=>"报名人数已满");
        }
        $flag = true;
        if(false == $data['name']){
            $flag = false;
        }else if(false == preg_match(Sp_Dictionary::getOtherOption('patternMobile'), $data['phone'])){
            $flag = false;
        }else if( $data['email'] ){
            if(false == preg_match(Sp_Dictionary::getOtherOption('patternEmail'), $data['email'])){
                $flag = false;
            }
        }
        if($flag == false){
            return array("status"=>-9,"msg"=>"参数有误");
        }
        return true;
    }
    /*
     * 获取报名条件
     * is_enroll:报名;is_audit:审核;enroll_start:报名开始时间;enroll_end:报名结束时间;enroll_num:报名人数;isdel:是否删除
     */
    public function getLimitByLetterId($letterId=''){
        $Id = intval($letterId);
      	$data =  Sp_Letter_Letter::getLimitByLetterId($Id);
        return $data;
    }
    /*
     * 获取当前参会人的人数
     * @activeId    活动ID
     */
    public function getCurrentNum($activeId=''){
        $Id = intval($activeId);
        return Sp_Letter_Letter::getCurrentNum($Id);
    }
    /*
     * 添加参会人
     */
    public function insert($data){
        $data['applyTime'] = time();
        $data['firstChater'] = Sp_Dictionary::getFirstCharter($data['name']);
        try{
            $id = Sp_Account_Attendee::add($data);
        }catch(PDOException $e){
            $id = false;
        }
        return $id < 1?false:$id;
    }
    
    

}
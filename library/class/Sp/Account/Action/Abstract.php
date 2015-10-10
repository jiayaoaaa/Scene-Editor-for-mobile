<?PHP

/**
 * Sp_Account_Action_Abstract
 * User 控制器 接口
 *
 * @author 
 * @version $Id$
 * @created 
 */


abstract class Sp_Account_Action_Abstract //implements Action_Interface
{

	protected $_view = null;
	protected $_user = null;
	protected $_request = null;
	
	public function __construct()
    {
		$user =  Sp_Account_User::current();
        if ($user->isLogin() === FALSE) {  //未登录跳转
            header("Location: " . SP_URL_HOME );
            exit;
        }
	}
		
	/**
	 * 执行一次行为请求
	 *
	 * @return mixed
	 */
	abstract public function execute($request);

    /**
     *  实例化模型类
     * @param $className
     * @return mixed
     */
    public function loadModel($className){
		return new $className;
	}
	
	/**
	 * 显示404页面
	 */
	public function show404(){
		header("Location: /home/error.html");
		exit();
	}
	
	/**
	 * get grid data
	 *
	 * @param array $callback
	 * @param array $condition = array()
	 * @return array
	 */
	public function fetchGrid($callback, $condition = array())
	{
		$request = $this->getRequest();

		$sort_name = $request->sidx;
		$sort_order = $request->sord;
		if($sort_name) $condition['sort_name'] = $sort_name;
		if($sort_order) $condition['sort_order'] = $sort_order;
		$page = $request->page;
		$limit = $request->rows;
		if (!$page) $page = 1;
		if (!$limit) $limit = 10;

		$offset = (($page-1) * $limit);
		$total_records = 0;
		$data = call_user_func_array($callback, array($condition, $limit, $offset, &$total_records));
		$total_pages = ceil($total_records/$limit);
		return array(
            'page' => $page,
            'total_pages' => $total_pages,
            'total_records' => $total_records,
            'rows' => $data,
            '__src' => $request->_source
	    );
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public function outputJson($data)
	{
		echo json_encode($data);
	}

	/**
	 * function description
	 *
	 * @param
	 * @return void
	 */
	public function outputGridJson($data, $total = 0, $page = 1)
	{

			header("Content-type: text/x-json");
			$json = "";
			$json .= "{\n";
			$json .= "page: $page,\n";
			$json .= "total: $total,\n";
			$json .= "rows: [";
			$rc = false;
			foreach ($data as $row) {
				if ($rc) $json .= ",";
				$json .= "\n{";
				$json .= "id:'".$row['id']."',";
				$json .= "cell:[";
				$sub_rc = false;
				foreach($row as $val) {
					if ($sub_rc) $json .= ",";
					$json .= "'".addslashes($val)."'";
					$sub_rc = true;
				}
				$json .= "]";
				$json .= "}";
				$rc = true;
			}
			$json .= "]\n";
			$json .= "}";
			echo $json;
			return ;
	}

	/**
	 * request
	 *
	 * @return object
	 */
	public function getRequest()
	{
		if($this->_request == null) {
			$this->_request = Request::current();
		}
		return $this->_request;
	}
}


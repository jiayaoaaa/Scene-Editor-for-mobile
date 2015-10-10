<?PHP

/**
 * Sp_Admin_Action_Abstract
 * Admin 控制器 接口
 *
 * @author
 * @version $Id$
 * @created
 */
abstract class Sp_Admin_Action_Abstract //implements Action_Interface
{

    protected $_view = null;
    protected $_user = null;
    protected $_request = null;
    protected $_isAdmin = null;
    protected $_roleList = null;

    public function __construct()
    {
        if (Sp_Admin_User::isLogin() === FALSE) {
            header("Location: " . SP_URL_CDGN . "login/index.html");
            exit;
        }

        $userArr = Sp_Admin_User::getUser();
        $user_id = $userArr['id'];
        //单点登录验证
        $session_id = $_COOKIE['session_id'];
        $cache = Cache_Memcache::getInstance();
        $SSO_memcache_key = 'SSO_admin_user_'.$user_id;
        $SSO_memcache_data = $cache->get($SSO_memcache_key);
        if($session_id != $SSO_memcache_data && !empty($SSO_memcache_data) && $user_id != 1){
            echo "<script type='text/javascript'>";
            echo "alert('您的账号在其他地方登录，已被踢下线!');";
            echo "location.href = '".SP_URL_DESK."login/signout.html'";
            echo "</script>";
            exit;
        }
        
        $spAdminUser = new Sp_Admin_User();
        $userInfo = $spAdminUser->adminuser_getUserAndRole($user_id, DATA_TYPE);

        if (($userInfo['groupid'] > 0 && $userInfo['cdgn_del'] >= 0) || $userInfo['groupid'] == 1) {
            define('CDGN_GROUP', '1');
        }

        if (($userInfo['custom_groupid'] > 0 && $userInfo['custom_del'] >= 0) || $userInfo['groupid'] == 1) {
            define('CUSTOM_GROUP', '1');
        }

        if (($userInfo['ad_groupid'] > 0 && $userInfo['ad_del'] >= 0) || $userInfo['groupid'] == 1) {
            define('AD_GROUP', '1');
        }
		
		if (($userInfo['cs_groupid'] > 0 && $userInfo['cs_del'] >= 0) || $userInfo['groupid'] == 1) {
            define('CS_GROUP', '1');
        }
		
		if($userInfo['groupid'] == 1){
			define('CS_SYSTEM', '1');
		}
		
        if ($userInfo[STATUS_DEL] != 0) {
            echo "<script type='text/javascript'>";
            echo "alert('您在该管理系统没有权限，或者是被移除！')";
            echo "</script>";
            exit;
        }


        if ($userInfo['groupid'] == 1) {
            $this->_isAdmin = TRUE;
        }

        if ($userInfo['groupid'] != 1) {
            $spAdminRole = new Sp_Admin_Role();
            $spGroupInfo = $spAdminRole->adminuser_getGroupRole($userInfo[GROUP_NAME]);
            $spAdminGroupRole = is_array($spGroupInfo['rolelist']) && count($spGroupInfo['rolelist']) > 0 ? $spGroupInfo['rolelist'] : array();
            $spUserRole = is_array($userInfo['rolelist']) && count($userInfo['rolelist']) > 0 ? $userInfo['rolelist'] : array();

            $spRoleList = array_merge($spAdminGroupRole, $spUserRole);
            $this->_roleList = $spRoleList;
            $spFormatRoleList = array();
            foreach ($spRoleList as $val) {
                $spFormatRoleList[] = $val['m'] . DIRECTORY_SEPARATOR . $val['c'];
            }
			$requestUriArr = str_replace("/custom", "", $_SERVER['REQUEST_URI']);
			
            $requestUriArr = explode('.', $requestUriArr);
            $userPath = str_replace('/', DIRECTORY_SEPARATOR, ltrim(ltrim($requestUriArr[0], '/'), '\\'));
            $userPath = str_replace('\\', DIRECTORY_SEPARATOR, $userPath);
            $checkList = explode(DIRECTORY_SEPARATOR, $userPath);

            if ($userPath != '' && !in_array($userPath, $spFormatRoleList) && !Sp_Admin_Menu::checkWhiteList($checkList[0], $checkList[1])) {
                echo "<script type='text/javascript'>";
                echo "alert('您没有获得该权限！');";
                echo "location.href = '".SP_URL_DESK."';";
                echo "</script>";
                exit;
            }
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
    public function loadModel($className)
    {
        return new $className;
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
        if ($sort_name) $condition['sort_name'] = $sort_name;
        if ($sort_order) $condition['sort_order'] = $sort_order;
        $page = $request->page;
        $limit = $request->rows;
        if (!$page) $page = 1;
        if (!$limit) $limit = 10;

        $offset = (($page - 1) * $limit);
        $total_records = 0;
        $data = call_user_func_array($callback, array($condition, $limit, $offset, &$total_records));
        $total_pages = ceil($total_records / $limit);
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
            $json .= "id:'" . $row['id'] . "',";
            $json .= "cell:[";
            $sub_rc = false;
            foreach ($row as $val) {
                if ($sub_rc) $json .= ",";
                $json .= "'" . addslashes($val) . "'";
                $sub_rc = true;
            }
            $json .= "]";
            $json .= "}";
            $rc = true;
        }
        $json .= "]\n";
        $json .= "}";
        echo $json;
        return;
    }

    /**
     * request
     *
     * @return object
     */
    public function getRequest()
    {
        if ($this->_request == null) {
            $this->_request = Request::current();
        }
        return $this->_request;
    }

    /**
     * function description
     *
     * @return void
     */
    public function getView()
    {
        if ($this->_view == null) {
            $this->_view = new Sp_Admin_View;
            $this->_view->assign('current_user', $this->getUser());
        }
        return $this->_view;
    }

    /**
     * function description
     *
     * @return void
     */
    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = Sp_Admin_Account::current();
        }
        return $this->_user;
    }

    public function downCsvTpl($header, $name = 'tpl')
    {
        $request = $this->getRequest();
        $ua = strtolower($request->getAgent());
        $is_windows = strpos($ua, "windows") !== false;

        $clean = function ($v) use ($is_windows) {
            $v = preg_replace("#\(.+\)#", '', $v);
            if ($is_windows) return iconv("UTF-8", "GBK", $v);
            return $v;
        };

        $fp = fopen('php://temp', 'r+');
        fputcsv($fp, array_map($clean, $header));
        rewind($fp);
        $csv = fgets($fp) . PHP_EOL;
        fclose($fp);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $name . '.csv');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . strlen($csv));
        echo $csv;
        exit;
    }
}


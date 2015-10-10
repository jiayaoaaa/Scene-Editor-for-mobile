<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// $Id$
define('ROOT_PATH', __DIR__ . '/../../');
include_once ROOT_PATH . 'config/init.php';

function checkCached($res, $priv, $ctl,$format)
{
    if ($format == 'html') return 0;
    $ac = Loader::config("admin.cache");
    if (isset($ac[$res]) && isset($ac[$res][$priv])) {
        $request = Request::current();
        $ret = $ac[$res][$priv];
        $str = '';
        if (isset($ret['params'])) {
            foreach (explode(',', $ret['params']) as $param) {
                $v = $request->$param;
                if (!is_null($v)) $str .= $v;
            }
        }
        $ret['cache_key'] = sprintf("dust_ac_%s_%s_%u_%s", strtolower($res), strtolower($priv), crc32($str), $request->format);
        return $ret;
    }
    return 0;
}

$mod_path = filter_input(INPUT_GET, '_mod', FILTER_SANITIZE_STRING);

Loader::import(WEB_ROOT . 'www/_class');
$request = Request::current();

list($res, $priv,$crl) = explode('/', $mod_path);
$result = array('success' => false);

$testRes = $res;
$testPriv = $priv;
//初始化action
if (empty($res)) $res = 'home';
if (empty($priv)) $priv = 'index';

isset($g_timer) && $g_timer->setMarker('dust.main start check role');
isset($g_timer) && $g_timer->setMarker('dust.main over checked');
$ctl_class = !empty($crl)? ucfirst($res) . '_' . ucfirst($priv).'_'.ucfirst($crl): ucfirst($res) . '_' . ucfirst($priv);
Loader::loadClass($ctl_class);
if ((($_SERVER['REQUEST_URI'] == '/' && (empty($testRes) && empty($testPriv))) || (strpos($_SERVER['REQUEST_URI'],"."))) &&  class_exists($ctl_class, false)) {
    $ctl_obj = new $ctl_class();
    isset($g_timer) && $g_timer->setMarker('dust.main class instanced');

    // TODO: cache process
    $cached = checkCached($res, $priv,$crl,$request->format);
    if (is_array($cached) && isset($cached['life']) && isset($cached['cache_key'])) {
        $cache_life = $cached['life'];
        $cache_key = $cached['cache_key'];
    } else {
        $cache_life = intval($cached);
        $cache_key = sprintf("huitong_www_ac_%u_%s", crc32($_SERVER['REQUEST_URI']), $request->format);
    }

    if (!$request->isPost() && $cache_life > 0) {
        $cache = Cache_Memcache::getInstance();
        $result = $cache->get($cache_key);
        if (FALSE === $result) {
            $result = $ctl_obj->execute($request);
            $cache->set($cache_key, $result, $cache_life);
        }
    } else {
        $result = $ctl_obj->execute($request);
    }

    isset($g_timer) && $g_timer->setMarker('dust.main class executed');
    if ($result === TRUE) {
        $result = array('success' => true);
    } elseif (is_array($result) && count($result) == 3 && isset($result[0]) && isset($result[1]) && is_bool($result[0]) && is_string($result[1])) {
        $tmp = $result;
        if ($tmp[0] === TRUE) {
            $result = array('success' => true);
            if (isset($tmp[1])) {
                $result['message'] = $tmp[1];
                if (isset($tmp[2])) {
                    $result['detail'] = $tmp[2];
                }
            }
        } else {
            $result = array('success' => false);
            $result['errors'] = array('code' => $tmp[1]);
            $result['errors']['reason'] = $tmp[2];
        }
    }
} else {  //404页面设置
	header("Location: /home/error.html");
	exit();
}

isset($g_timer) && $g_timer->setMarker('dust.main result loaded');

if (!is_null($result)) {
	header('Content-type: application/json');
	//header('Content-type: text/json'); 
	//header("Content-type:text/html;charset=utf-8");
    echo json_encode($result);
}
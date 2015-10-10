<?PHP
//error_reporting(0);
/**
 * 网站初始化
 *
 * @version        1.0
 * @since           12:54 2009-02-09
 * @author          liut
 * @words           Init
 * @Revised Information
 * $Id$
 * 
 */
//

define('CONF_ROOT', dirname(__FILE__) . '/' );

// 加载核心起始配置文件
include_once CONF_ROOT . 'config.inc.php';

$xhprof_on = false;
if (defined('_PS_DEBUG')) {
	$xhprof_on = true;
	if (extension_loaded('xhprof')) {
		include_once LIB_ROOT . 'include/xhprof/utils/xhprof_lib.php';
		include_once LIB_ROOT . 'include/xhprof/utils/xhprof_runs.php';
		xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
	}
}




defined('LIB_ROOT') || define ('LIB_ROOT', CONF_ROOT.'/../library/' );


if(defined('ENABLE_BENCHMARK') && TRUE === ENABLE_BENCHMARK) {

	// for Benchmark
	require_once LIB_ROOT.'Benchmark/Timer.php';

	$g_timer = new Benchmark_Timer();
	$g_timer->start();
	$g_timer->setMarker('web.init: start');

}
// Global Loader
include_once LIB_ROOT . 'class/Loader.php'; 



isset($g_timer) && $g_timer->setMarker('lib.loader loaded');

if (PHP_SAPI === 'cli') { // command line
	isset($argv) || $argv = $_SERVER['argv'];
}
elseif(isset($_SERVER['HTTP_HOST'])) { // http mod, cgi, cgi-fcgi
	if(headers_sent()) {
		exit('headers already sent');
	}
	$format = 'html';
	if (isset($_GET['format'])) {
		$format = $_GET['format'];
	} elseif (isset($_POST['format'])) {
		$format = $_POST['format'];
	}
	switch ($format) {
		case 'js':
			$ctype = 'text/javascript';
			break;
		case 'json':
			$ctype = 'applcation/json'; //'text/javascript';//'text/x-json';//
			break;
		case 'xml':
			$ctype = 'text/xml';
			break;
		default:
			$ctype = 'text/html';
			break;
	}
	
	if(defined('RESPONSE_CHARSET')) header('Content-Type: '.$ctype.'; charset='.RESPONSE_CHARSET);
	defined('CONTENT_TYPE') || define('CONTENT_TYPE', $ctype );
	unset($format, $ctype);
	
	if (defined('RESPONSE_NO_CACHE')) {
		header('Expires: Fri, 02 Oct 98 20:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		header('Pragma: no-cache');
	}
}

<?PHP
// $Id$

$xhprof_on = false;
if (mt_rand(1, 10000) === 1) {
	$xhprof_on = true;
	if (extension_loaded('xhprof')) {
		include_once 'include/xhprof/utils/xhprof_lib.php';
		include_once 'include/xhprof/utils/xhprof_runs.php';
		xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);
	}
}
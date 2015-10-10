<?PHP
// $Id$

if ($xhprof_on && extension_loaded('xhprof')) {
	$profiler_namespace = 'myapp';  // namespace for your application
	$xhprof_data = xhprof_disable();
	$xhprof_runs = new XHProfRuns_Default();
	$run_id = $xhprof_runs->save_run($xhprof_data, $profiler_namespace);

	if (defined('CONTENT_TYPE') && CONTENT_TYPE === 'html') {
		// url to the XHProf UI libraries (change the host name and path)
		$profiler_url = sprintf('http://%s/XHProf/?run=%s&source=%s', $_SERVER['HTTP_HOST'], $run_id, $profiler_namespace);
		echo '<a href="'.$profiler_url.'" target="_blank">Profiler output</a>';
		
	}
	
}
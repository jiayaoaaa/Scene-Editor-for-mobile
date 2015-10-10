<?PHP
/** $Id$ */
return;
if(isset($g_debug_footer_loaded)) return;
$g_debug_footer_loaded = true;

if(!defined('_PS_DEBUG') || TRUE !== _PS_DEBUG)
{
	return;
}

if(!isset($_SERVER['HTTP_HOST']) && !defined('DEBUG_CONSOLE_ENABLE'))
{
	return;
}

if(!defined('_PS_DEBUG_FORCE_OUPUT') && isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
{
	return;
}

if(isset($_SERVER['HTTP_HOST'])) echo "<div id=\"_bt_info\" style=\"text-align: justify;clear: both; margin: 5px;\">\n";


if((isset($g_timer) && class_exists('Benchmark_Timer', FALSE)))
{
	$g_timer->stop();
	$g_timer->display(); // to output html formated
}

if(isset($g_error_messages))
{
	echo "<!-- error_messages:\n", print_r($g_error_messages, true), "\n-->\n";
}

if(isset($g_log_queries))
{
	echo "<!-- log_queries:\n", print_r($g_log_queries, true), "\n-->\n";
}

echo "<!-- included:\n", print_r(get_included_files(), true), "\n-->\n";


if(class_exists('Cache', false))
{
	echo "<!-- cache:\n", htmlspecialchars(print_r(Cache::factory('all_instances'), true)), "\n-->\n";
}

if (class_exists('Da_Wrapper', false))
{
	echo "<!-- dbos\n";
	foreach(Da_Wrapper::getDbos() as $key => $dbo)
	{
		echo $key, ":\n";
		echo 'class: ', get_class($dbo), ":\n";
		print_r($dbo->errorInfo());
		if (property_exists($dbo, 'logs')) {
			echo 'logs:', PHP_EOL;
			print_r($dbo->logs);
		}
		
		//echo 'querynum: ', $dbo->querynum, ":\n";
		//print_r($dbo->queries);
	}
	echo "\n-->\n";
}

if(class_exists('Db_Factory', false))
{
	//var_dump(Db_Factory::getDbos());
	foreach(Db_Factory::getDbos() as $key => $dbo)
	{
		echo "<!-- \n";
		echo $key, ":\n";
		echo 'class: ', get_class($dbo), ":\n";
		echo 'querynum: ', $dbo->querynum, ":\n";
		print_r($dbo->queries);
		echo "\n-->\n";
	}
}

if(class_exists('Sp_Log', false))
{
	echo "<!-- logs:\n", print_r(Sp_Log::getLogs(), true), "\n-->\n";
}

//var_dump(xdebug_get_declared_vars());
if(isset($_SERVER['HTTP_HOST'])) echo "</div>";

<?PHP

// $Id$
$_debug = (defined('_PS_DEBUG') && TRUE === _PS_DEBUG);
return array(
	// default nodes
	'memcache' => array(
		'className' => 'Cache_Memcache',
		'option' => array(
			'debug' => $_debug
		)
	),
	'default' => 'memcache',
	'lute' => array(
		'className' => 'Cache_Lute',
		'option' => array(
			'cacheDir' => CACHE_ROOT,
			'lifeTime' => 300,
			'debug' => $_debug
		),
	),
	'file' => 'lute',
	'redis' => array(
		'className' => 'Cache_Redis',
		'option' => array(
			'cacheDir' => CACHE_ROOT,
			'lifeTime' => 300,
			'debug' => $_debug
		),
	),
	
);

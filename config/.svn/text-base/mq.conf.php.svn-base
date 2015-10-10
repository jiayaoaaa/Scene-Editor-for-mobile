<?PHP
// $Id$
$_debug = (defined('_PS_DEBUG') && TRUE === _PS_DEBUG);
return array(
	// default nodes
	'gearman' => array(
		'option' => array(
			'hosts' =>'127.0.0.1',
			'port' => 4730,
			'connectTimeout' => 5000,
			'debug' => $_debug,
		)
	),
	'client_default' => array(
		'className' => 'MQ_GClient',
		'logfile' => '/sproot/logs/client_default_',
		'default'  =>'gearman',
	),
	'worker_default' => array(
		'className' => 'MQ_GWorker',
		'logfile' => '/sproot/logs/worker_default_',
		'default'  =>'gearman',
	),
	'worker_participants' => array(
		'className' => 'MQ_GWorker',
		'logfile'  => '/sproot/logs/worker_participants_',
		'default'  =>'gearman',
	),
	'client_participants' => array(
		'className' => 'MQ_GClient',
		'logfile' => '/sproot/logs/client_participants_',
		'default'  =>'gearman',
	),
);

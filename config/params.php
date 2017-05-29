<?php

return [
    'adminEmail' => 'dragan.zivkovic@bravostudio.com',
	'platformModules' => [
		[
			'name' => 'Sync Alerts',
			'iconClass' => 'glyphicon glyphicon-bell',
			'controller' => 'sync-alerts'
		],
		[
			'name' => 'Tables Manager',
			'iconClass' => 'glyphicon glyphicon-list-alt',
			'controller' => 'tables-manager'
		],[
			'name' => 'Jobs Manager',
			'iconClass' => 'glyphicon glyphicon-briefcase',
			'controller' => 'jobs-manager'
		],
		[
			'name' => 'Spark Monitor',
			'iconClass' => 'glyphicon glyphicon-fire',
			'controller' => 'spark-monitor'
		],
	],
];

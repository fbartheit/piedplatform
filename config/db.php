<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=pied_piper',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];



/*return [
'components' => [
    'dataBucket' => [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost;dbname=pied_piper',
		'username' => 'root',
		'password' => '',
		'charset' => 'utf8',
	],
    'syncDB' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=sync_database', 
        'username' => 'root',
        'password' => '',
		'charset' => 'utf8',
    ],
],
];*/
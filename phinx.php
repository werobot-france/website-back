<?php

require 'vendor/autoload.php';

\App\DotEnv::load();
$container = \App\ContainerBuilder::direct();

return [
	'paths' => [
		'migrations' => '%%PHINX_CONFIG_DIR%%/src/Database/Migrations',
		'seeds' =>  '%%PHINX_CONFIG_DIR%%/src/Database/Seeds'
	],
	'environments' => [
		'default_database' => 'development',
		'development' => [
			'adapter' => 'mysql',
			'host' => $container->get('db')['host'],
			'name' => $container->get('db')['database'],
			'user' => $container->get('db')['username'],
			'pass' => $container->get('db')['password']
		]
	]
];

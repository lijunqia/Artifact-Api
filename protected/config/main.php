<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'IM',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.tables.*',
		'application.models.forms.*',
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,  
			'caseSensitive'=>false,
			'rules'=>array(
				// REST routers
//				array('<controller>/list', 'pattern'=>'<controller>/item', 'verb'=>'GET'),
//				array('<controller>/view', 'pattern'=>'<controller>/item/', 'verb'=>'GET'),
//				array('<controller>/create', 'pattern'=>'<controller>/item', 'verb'=>'POST'),
//				array('<controller>/update', 'pattern'=>'<controller>/item/', 'verb'=>'PUT'),
//				array('<controller>/delete', 'pattern'=>'<controller>/item/', 'verb'=>'DELETE'),
				// 通用路由
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => DB_CONNECTION,
			'username' => DB_USER,
			'password' => DB_PASSWORD,
			'emulatePrepare' => DB_EMULATE,
			'charset' => DB_CHARSET,
		),
		
//		'cache'=>array(
//			'class'=>'system.caching.CMemCache',
//			'keyPrefix'=> 'CACHE_365_VC',
//			'servers'=>array(
//				array('host'=>MEMCACHE_HOST, 'port'=>MEMCACHE_PORT, 'weight'=>MEMCACHE_WEIGHT, 'timeout'=>MEMCACHE_TIMEOUT),
//			),
//		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error',
					'logfile'=>'app.log.'.date('ymd'),
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page

		'upload'=>'/upload',

	),
);
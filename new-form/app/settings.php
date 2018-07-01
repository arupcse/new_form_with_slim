<?php

// Do not modify this file. Instead, copy it to settings.php and modify that one.

return [
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            // Medoo/database configuration
            'database_type' => 'mysql',
            'server'        => 'mysql-server.cc.swin.edu.au',
            'database_name' => 'web_demo',
            'table_name'    => 'meedo_test',
             'username'      => getenv('DB_USERNAME'),
            'password'      => getenv('DB_PASSWORD'),
            'charset'       => 'utf8',
            'port'          => '3306',
            // Enable logging
	        "logging" => true,
            'option' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
        ],
        'renderer' => [
            'template_path' => APPPATH . '/app/views',
        ],
        'view' => [
            'template_path' => APPPATH . '/app/views',
        ],
        'header' => [
			'windowTitle'     => 'My Legacy Form',
            'metaRobots'      => 'noarchive, noodp, notranslate, noimageindex',
            'metaDescription' => 'My app description',
            'metaKeywords'    => 'My app keywords',
			'pageTitle'       => 'Admin area for Legacy',
			'formTitle'       => 'Legacy Form',
			'formDescription' => 'The basic desciption of this form goes here'
		],
    ],
];

<?php

return [
	'settings' => [
		'logger' => [
            // error heading
            'title' => 'FORM_LOGGER',
            // Path to log directory
            'directory' => APPPATH.'/logs',
            // Log file name
            'filename' => 'form', // without the ext, default ext is .log
            // Your timezone
            // 'timezone' => 'Oceania/Australia/Melbourne',
            // Log level
            'level' => 'logger::DEBUG',
            // List of Monolog Handlers you wanna use
            'handlers' => []
		],
	],
];

<?php

return [
	'settings' => [
		'extensions' => [
			'png', 'jpeg', "jpg",
			// 'zip',
			'pdf',
			'txt', 'doc', 'docx',
			'csv', 'xls', 'xlsx',
			'ppt', 'pptx'
		],
		'size' => [
			'5M'
		],
		'uploadeddir' => [
			'path' => APPPATH.'/uploads',	//APPPATH is defined in index.php
		],

	],
];

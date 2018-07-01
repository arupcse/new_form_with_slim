<?php
/**
*   This files contains the settings relate to the admin page
*
*   header_admin - information related to page head <head>
*   admin_list - list of the admins who will receive the CSV email
*   csv_file_attributes - name and date format of the generated csv files e.g. form_data_20170822_120535.csv
*/

return [
    'settings' => [
        'header_admin' => [
			'windowTitle'     => 'Legacy Form Admin',
            'metaRobots'      => 'noarchive, noodp, notranslate, noimageindex',
            'metaDescription' => 'Form admin description',
            'metaKeywords'    => 'keywords for form admin',
			'pageTitle'       => 'Admin area for Legacy',
			'formTitle'       => 'Admin - Legacy Form',
			'formDescription' => 'Admin area description goes here'
		],
        'admin_list' => [
			'Ramiro Rosales'   =>  'rrosales@swin.edu.au',
			'Arup Sarker'      =>  'asarker@swin.edu.au',
			'Dan Sheperd'      =>  'deshepherd@swin.edu.au',
			'Neil Lamborn'     =>  'nlamborn@swin.edu.au',
		],
        'csv_file_attributes' => [
            'prefix'           => 'form_csv',
            'date_format'      => 'Ymd_His',  // Y-year, m-month, d-day, H-hour, i-minute, s-second
            'seperator'        =>  '-'        // dash or underscore
		],
    ],
];

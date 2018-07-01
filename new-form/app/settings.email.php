<?php

return [
	'settings' => [
		'email_student' => [
			'from' 		=> 'noreply@swin.edu.au',
			//name of the field that contains the email address
			// 'to' 		=> 'asarkerswin.edu.au',
		    'cc' 	    => 'asarker@swin.edu.au',
		    'bcc' 	    => 'asarker@swin.edu.au',
		    'subject'   => 'New form is submittied'
		],
		'email_admin' => [
			'from' 		=> 'noreply@swin.edu.au',
			'to' 		=> 'asarker@swin.edu.au',
			'cc' 	    => 'asarker@swin.edu.au',
			'bcc' 	    => 'asarker@swin.edu.au',
			'subject'   => '(Admin) New form is submittied'
		],
		'email_csv' => [
			'from' 		=> 'noreply@swin.edu.au',
			'cc' 	    => 'asarker@swin.edu.au',
			'bcc' 	    => 'asarker@swin.edu.au',
			'subject'   => 'CSV Form Submissions (admin)',
			'body'		=> 'A spreadsheet containing the requested data is attached.'
		],

	],
];

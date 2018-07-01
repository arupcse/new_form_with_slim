<?php

use Respect\Validation\Validator as v;

return [
	'settings' => [
		'validation_rules' => [
			'full_name' 		=> v::notEmpty() -> stringType() -> length(3, 100),
		    'email' 			=> v::notEmpty() ->length(1, 50) -> email(),
		    'comments' 		  	=> ($empty = v::notEmpty() -> stringType() -> length(1, 255)),
		    'student_type' 	  	=> $empty,
		    'student_interest'  => v::notEmpty(),
		    'campus' 			=> $empty,
		    'faculty'			=> v::notEmpty()
		],
		'validation_msg' =>	[
				'notEmpty'   => 'Should not be blank',
				'length'     => 'Name is not long enough',
				'email'      => 'Should enter a valid email',
				'size'       => 'No file was uploaded',
				'extension'  => 'This extension is not allowed'
		],
	],
];

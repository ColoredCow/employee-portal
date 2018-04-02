<?php

return [
	'display_date_format' => 'd/m/Y',
	'hr' => [
		'round' => [
			'statuses' => [
				'new' => 'new',
				'rejected' => 'rejected',
				'in-progress' => 'in-progress',
			],
		],
		'defaults' => [
			'scheduled_person_id' => 1,
		],
	],
	'finance' => [
		'invoice' => [
			'status' => [
				'unpaid' => 'Unpaid',
				'paid' => 'Paid',
			],
		],
	],
	'project' => [
		'status' => [
			'active' => 'Active',
			'inactive' => 'Inactive',
		],
	],
];

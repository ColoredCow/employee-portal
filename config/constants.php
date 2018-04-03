<?php

return [
	'date_format' => 'Y-m-d',
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
	'currency' => [
		'INR' => [
			'name' => 'Indian Rupees',
			'symbol' => '₹',
		],
		'USD' => [
			'name' => 'US Dollars',
			'symbol' => '$',
		],
	],
	'project' => [
		'status' => [
			'active' => 'Active',
			'inactive' => 'Inactive',
		],
	],
];

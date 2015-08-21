<?php

return [

	/*
	|--------------------------------------------------------------------------
	| SECTION LIST
	|--------------------------------------------------------------------------
	|	List of all sections available for processing.
	|
	*/

	'section_list' => [

		'cutlery',
		'cake-stand'

	],

	/*
	|--------------------------------------------------------------------------
	| SECTION REF CODE
	|--------------------------------------------------------------------------
	|	Get the ref code from the full section name and the full section
	| 	name from the ref code.
	|
	*/

	'section_ref_code' => [

		// fullname -> ref code
		'bric-a-brac' => 'b',
		'cake-stand'  => 's',
		'cutlery'     => 'c',
		'furniture'   => 'f',
		'key-holder'  => 'k',
		'luminaire'   => 'l',

		// ref code -> fullname
		'b' => 'bric-a-brac',
		's' => 'cake-stand',
		'c' => 'cutlery',
		'f' => 'furniture',
		'k' => 'key-holder',
		'l' => 'luminaire'

	],

	/*
	|--------------------------------------------------------------------------
	| CATEGORY LISTS
	|--------------------------------------------------------------------------
	|	Lists of the different categories for every section.
	|
	*/

	'cutlery_categ_list' => [

		// Spoons
		'teaspoon',
		'big-spoon',
		'dessert-spoon',
		'baby-spoon',

		// Forks
		'big-fork',
		'dessert-fork',

		// Knives
		'knife',

		// Servers
		'serving-spoon',
		'serving-fork',
		'cake-server',
		'sugar-server',
		'ladle',
		'patisserie-server',
		'little-ladle',

		// Others
		'pair'

	],

	'cake_stand_categ_list' => [

		'two-plates',
		'two-oval-plates',
		'plate-gravy-boat',
		'three-plates'

	],

	/*
	|--------------------------------------------------------------------------
	| VARIOUS VALUES
	|--------------------------------------------------------------------------
	|	Mass values for cutlery categories and price for cake stand categs.
	|
	*/

	'cutlery_category_mass' => [

		// Spoons
		'teaspoon'          => 35,
		'big-spoon'         => 90,
		'dessert-spoon'     => 60,
		'baby-spoon'        => 35,

		// Forks
		'big-fork'          => 80,
		'dessert-fork'      => 50,

		// Knives
		'knife'             => 60,

		// Servers
		'serving-spoon'     => 130,
		'serving-fork'      => 100,
		'cake-server'       => 100,
		'sugar-server'      => 30,
		'ladle'             => 250,
		'patisserie-server' => 100,
		'little-ladle'      => 80,

		// Others
		'pair' => 20 // has to be changed

	],

	'cake_stand_category_price' => [

		'two-plates'       => 49,
		'two-oval-plates'  => 54,
		'plate-gravy-boat' => 59,
		'three-plates'     => 69

	]

];

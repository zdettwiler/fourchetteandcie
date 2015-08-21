<?php

$array = [
	"id" => 123,
	"order" => 'order',
	"nb" => 45,
	"color" => 'blue',
	"categ" => [
		"categ1" => 'test',
		"categ2" => 'jfieown'
	]
];

echo '<pre>';
print_r($array);
echo '</pre>';


unset($array["categ"]);

echo '<pre>';
print_r($array);
echo '</pre>';
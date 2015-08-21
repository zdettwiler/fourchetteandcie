<?php namespace FandC\Http\Controllers 
use Illuminate\Support\Facades\DB;
echo DB::table('cutlery')->all();
// $file = file_get_contents('items_readable.txt');

// $file = preg_replace("/\s+/", " ", $file);

// $file = str_replace("   ", "\n\n", $file);

// $file = str_replace("	€", ' €', $file);

// $file = str_replace("	", "\n\n", $file);

// $file = str_replace("\n", "#", $file);
// $file = str_replace(" #", "#", $file);
// $file = str_replace("###", "\n", $file);
// $file = str_replace("#", "\t", $file);
// $file = str_replace(" (", "\t", $file);
// $file = str_replace(") ", "\t", $file);


// echo $file;






$items = [];
// c23 TEA | FOR TWO#Pair Teaspoons (teaspoon, pair) €28.00


$file = fopen("items_readable.txt", "r");
while ($data = fscanf($file, "%s %[^\n]s\n"))
{
	list ($ref, $more_details) = $data;
	// echo $ref.' '.$more_details.'<br>';
	// echo '<pre>';
	$more_details = explode("\t", $more_details);
	// echo '</pre>';
	$items[] = [
		'ref' => $ref,
		'stamped' => $more_details[0],
		'descr' => $more_details[1],
		'categ' => $more_details[2],
		'price' => $more_details[3]
	];
}
fclose($file);

echo '<pre>';
print_r($items);
echo '</pre>';

